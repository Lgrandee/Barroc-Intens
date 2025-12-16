<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use App\Models\User;
use App\Models\PlanningTicket;

class PlannerDashboard extends Component
{
    /**
     * PERFORMANCE OPTIMIZATION:
     * wire:poll.2s refreshes every 2 seconds (currently set for testing).
     * For production with many concurrent users, consider:
     * - Increase to 5s or 10s: wire:poll.5s or wire:poll.10s
     * - Use wire:poll.keep-alive to only poll when tab is visible
     * - Use Laravel Echo + Pusher for event-driven real-time updates instead of polling
     */
    
    public function render()
    {
        // Planned tasks this week
        $plannedTasksCount = PlanningTicket::whereBetween('scheduled_time', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // Completed tasks this week
        $completedTasksCount = PlanningTicket::where('status', 'completed')
            ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // Team capacity (users with role technician or similar)
        $teamMembers = User::count();
        $maxTasksPerDay = 4; // Assume 4 tasks per person per day
        $totalCapacity = $teamMembers * $maxTasksPerDay * 5; // 5 work days
        $usedCapacity = $plannedTasksCount;
        $teamCapacityPercent = $totalCapacity > 0 ? round(($usedCapacity / $totalCapacity) * 100) : 0;

        // Backlog (tasks past scheduled time but not completed)
        $backlogCount = PlanningTicket::where('scheduled_time', '<', now())
            ->where('status', '!=', 'completed')
            ->count();

        // Weekly overview by day
        $weeklyOverview = collect();
        for ($i = 0; $i < 5; $i++) {
            $date = now()->startOfWeek()->addDays($i);
            $tasksOnDay = PlanningTicket::whereDate('scheduled_time', $date)->count();
            $dayCapacity = $teamMembers * $maxTasksPerDay;
            $weeklyOverview->push([
                'date' => $date,
                'label' => $date->translatedFormat('l j M'),
                'tasks' => $tasksOnDay,
                'capacity' => $dayCapacity,
                'percent' => $dayCapacity > 0 ? round(($tasksOnDay / $dayCapacity) * 100) : 0
            ]);
        }

        // Team schedule
        $teamSchedule = User::with(['planningTickets' => function($q) {
            $q->whereDate('scheduled_time', today())->orderBy('scheduled_time');
        }])->take(5)->get();

        // Urgent changes (recent tickets or high priority)
        $urgentChanges = PlanningTicket::with('user', 'feedback')
            ->where(function($q) {
                $q->where('priority', 'hoog')
                  ->orWhere('created_at', '>=', now()->subHours(24));
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('livewire.dashboards.planner-dashboard', compact(
            'plannedTasksCount',
            'completedTasksCount',
            'teamCapacityPercent',
            'backlogCount',
            'weeklyOverview',
            'teamSchedule',
            'urgentChanges'
        ));
    }
}

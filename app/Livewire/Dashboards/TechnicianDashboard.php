<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use App\Models\Product;
use App\Models\PlanningTicket;
use Carbon\Carbon;

class TechnicianDashboard extends Component
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
        // Open tickets
        $openTicketsCount = PlanningTicket::where('status', 'open')->count();
        
        // Scheduled services this week
        $scheduledServicesCount = PlanningTicket::where('catagory', 'service')
            ->whereBetween('scheduled_time', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // Average response time - calculated in PHP for SQLite compatibility
        $openTickets = PlanningTicket::where('status', 'open')->get();
        $avgResponseTime = $openTickets->count() > 0 
            ? $openTickets->avg(function($t) { return now()->diffInDays($t->created_at); }) 
            : 0;

        // Low stock alerts (for technician supplies)
        $lowStockThreshold = 10;
        $stockAlerts = Product::where('stock', '<', $lowStockThreshold)
            ->orderBy('stock')
            ->take(5)
            ->get();
        $stockAlertsCount = $stockAlerts->count();

        // Urgent tickets - simplified ordering for SQLite
        $urgentTickets = PlanningTicket::with('user', 'feedback')
            ->where('priority', 'hoog')
            ->orWhere('status', 'open')
            ->orderBy('priority')
            ->take(5)
            ->get();

        // Weekly planning
        $weeklyPlanning = PlanningTicket::with('user', 'feedback')
            ->whereBetween('scheduled_time', [now()->startOfWeek(), now()->endOfWeek()])
            ->orderBy('scheduled_time')
            ->get()
            ->groupBy(function($ticket) {
                return Carbon::parse($ticket->scheduled_time)->format('l j F');
            });

        return view('livewire.dashboards.technician-dashboard', compact(
            'openTicketsCount',
            'scheduledServicesCount',
            'avgResponseTime',
            'stockAlerts',
            'stockAlertsCount',
            'urgentTickets',
            'weeklyPlanning'
        ));
    }
}

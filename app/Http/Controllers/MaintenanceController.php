<?php

namespace App\Http\Controllers;

use App\Models\PlanningTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    /**
     * Display the maintenance planning page (only for logged-in technician)
     */
    public function planning(Request $request)
    {
        $user = Auth::user();
        $isManagement = $user && $user->department === 'Management';
        $userId = $user?->id;

        // Update overdue tasks to 'te_laat' status
        $overdueQuery = PlanningTicket::query();
        if (!$isManagement) {
            $overdueQuery->where('user_id', $userId);
        }
        $overdueQuery
            ->where('status', 'open')
            ->where('scheduled_time', '<', now())
            ->update(['status' => 'te_laat']);

        $query = PlanningTicket::with(['user', 'feedback.customer', 'feedback.products']);
        if (!$isManagement) {
            $query->where('user_id', $userId);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('feedback.customer', function($customerQuery) use ($search) {
                    $customerQuery->where('name_company', 'like', "%{$search}%");
                })
                ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('catagory', $request->category);
        }

        // Period filter
        $periodLabel = null;
        $periodStart = null;
        $periodEnd = null;

        if ($request->filled('period')) {
            $now = now();
            switch ($request->period) {
                case 'today':
                    $periodStart = $now->copy();
                    $periodEnd = $now->copy();
                    $periodLabel = 'Vandaag';
                    $query->whereDate('scheduled_time', $now->toDateString());
                    break;
                case 'tomorrow':
                    $periodStart = $now->copy()->addDay();
                    $periodEnd = $now->copy()->addDay();
                    $periodLabel = 'Morgen';
                    $query->whereDate('scheduled_time', $now->addDay()->toDateString());
                    break;
                case 'this_week':
                    $periodStart = $now->copy()->startOfWeek();
                    $periodEnd = $now->copy()->endOfWeek();
                    $periodLabel = 'Deze week';
                    $query->whereBetween('scheduled_time', [$periodStart, $periodEnd]);
                    break;
                case 'next_week':
                    $periodStart = $now->copy()->addWeek()->startOfWeek();
                    $periodEnd = $now->copy()->addWeek()->endOfWeek();
                    $periodLabel = 'Volgende week';
                    $query->whereBetween('scheduled_time', [$periodStart, $periodEnd]);
                    break;
                case 'this_month':
                    $periodStart = $now->copy()->startOfMonth();
                    $periodEnd = $now->copy()->endOfMonth();
                    $periodLabel = 'Deze maand';
                    $query->whereMonth('scheduled_time', $now->month)
                          ->whereYear('scheduled_time', $now->year);
                    break;
            }
        }

        $planningTickets = $query->orderBy('scheduled_time', 'desc')->paginate(15);

        return view('technician.planning', compact('planningTickets', 'periodLabel', 'periodStart', 'periodEnd'));
    }



    /**
     * Display the specified maintenance task details
     */
    public function show($id)
    {
        $user = Auth::user();
        $isManagement = $user && $user->department === 'Management';

        $query = PlanningTicket::with(['user', 'feedback.customer', 'feedback.products']);
        if (!$isManagement) {
            $query->where('user_id', $user?->id);
        }

        $task = $query->findOrFail($id);

        return view('technician.detail', compact('task'));
    }

    /**
     * Show rapport form
     */
    public function rapport($id)
    {
        $user = Auth::user();
        $isManagement = $user && $user->department === 'Management';

        $query = PlanningTicket::with(['user', 'feedback.customer', 'feedback.products']);
        if (!$isManagement) {
            $query->where('user_id', $user?->id);
        }

        $task = $query->findOrFail($id);

        return view('technician.rapport', compact('task'));
    }

    /**
     * Update the feedback/rapport for a maintenance task
     */
    public function updateRapport(Request $request, $id)
    {
        $user = Auth::user();
        $isManagement = $user && $user->department === 'Management';

        $query = PlanningTicket::with('feedback');
        if (!$isManagement) {
            $query->where('user_id', $user?->id);
        }

        $task = $query->findOrFail($id);

        $request->validate([
            'feedback' => 'required|string|max:5000',
            'status' => 'required|in:voltooid,probleem,te_laat',
            'used_materials' => 'nullable|string|max:2000',
        ]);

        $task->feedback->update([
            'feedback' => $request->feedback,
        ]);

        $task->update([
            'status' => $request->status,
            'used_materials' => $request->used_materials,
        ]);

        return redirect()->route('technician.onderhoud.show', $id)
            ->with('success', 'Rapport succesvol opgeslagen en status bijgewerkt');
    }
}

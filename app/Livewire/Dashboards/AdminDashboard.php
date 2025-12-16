<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use App\Models\User;
use App\Models\Factuur;
use App\Models\PlanningTicket;

class AdminDashboard extends Component
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
        // Revenue this month from paid invoices
        $monthlyRevenue = Factuur::where('status', 'betaald')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->with('products')
            ->get()
            ->sum('total_amount');

        $activeUsers = User::where('status', 'active')->count();
        if ($activeUsers == 0) $activeUsers = User::count();

        $openTicketsCount = PlanningTicket::where('status', 'open')->count();
        
        $lateInvoicesCount = Factuur::where('due_date', '<', now())
            ->whereNotIn('status', ['betaald', 'paid'])
            ->count();

        $openInvoicesCount = Factuur::whereNotIn('status', ['betaald', 'paid'])->count();
        
        $recentInvoices = Factuur::with('customer')->latest()->take(5)->get();

        // Payment reminders: invoices due within 7 days that aren't paid
        $reminders = Factuur::with('customer')
            ->where('due_date', '<=', now()->addDays(7))
            ->where('due_date', '>=', now()->subDays(7))
            ->whereNotIn('status', ['betaald', 'paid'])
            ->orderBy('due_date')
            ->take(5)
            ->get();

        return view('livewire.dashboards.admin-dashboard', compact(
            'monthlyRevenue',
            'activeUsers', 
            'lateInvoicesCount', 
            'recentInvoices',
            'openInvoicesCount',
            'openTicketsCount',
            'reminders'
        ));
    }
}

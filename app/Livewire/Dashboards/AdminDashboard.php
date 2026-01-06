<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use App\Models\User;
use App\Models\Factuur;
use App\Models\PlanningTicket;

class AdminDashboard extends Component
{
    public $filter = 'maand';

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $chartData = $this->getChartData($filter);
        $this->dispatch('update-admin-chart', data: $chartData);
    }

    /**
     * PERFORMANCE OPTIMIZATION:
     * wire:poll.2s refreshes every 2 seconds (currently set for testing).
     * For production with many concurrent users, consider:
     * - Increase to 5s or 10s: wire:poll.5s or wire:poll.10s
     * - Use wire:poll.keep-alive to only poll when tab is visible
     * - Use Laravel Echo + Pusher for event-driven real-time updates instead of polling
     */
    
    public function getChartData($filter)
    {
        $labels = [];
        $data = [];

        if ($filter === 'maand') {
            // Days of current month - single query approach
            $start = now()->startOfMonth();
            $end = now()->endOfMonth();
            
            // Get all paid invoices for this month with products
            $invoices = Factuur::whereIn('status', ['betaald', 'paid'])
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->with('products')
                ->get();
            
            // Build labels and aggregate data
            $period = \Carbon\CarbonPeriod::create($start, $end);
            foreach ($period as $date) {
                $labels[] = $date->format('d');
                $dayTotal = $invoices->filter(function($inv) use ($date) {
                    return $inv->paid_at && $inv->paid_at->format('Y-m-d') === $date->format('Y-m-d');
                })->sum('total_amount');
                $data[] = $dayTotal;
            }
            
        } elseif ($filter === 'kwartaal') {
            // Weeks of current quarter
            $start = now()->startOfQuarter();
            $end = now()->endOfQuarter();
            
            // Get all paid invoices for this quarter with products
            $invoices = Factuur::whereIn('status', ['betaald', 'paid'])
                ->whereBetween('paid_at', [$start, $end])
                ->with('products')
                ->get();
            
            $weekStart = $start->copy();
            while ($weekStart <= $end) {
                $weekEnd = $weekStart->copy()->endOfWeek();
                if ($weekEnd > $end) $weekEnd = $end;
                
                $labels[] = 'W' . $weekStart->weekOfYear;
                $weekTotal = $invoices->filter(function($inv) use ($weekStart, $weekEnd) {
                    return $inv->paid_at && $inv->paid_at >= $weekStart && $inv->paid_at <= $weekEnd;
                })->sum('total_amount');
                $data[] = $weekTotal;
                
                $weekStart->addWeek();
            }

        } elseif ($filter === 'jaar') {
            // Months of current year
            $invoices = Factuur::whereIn('status', ['betaald', 'paid'])
                ->whereYear('paid_at', now()->year)
                ->with('products')
                ->get();
            
            for ($m = 1; $m <= 12; $m++) {
                $labels[] = \Carbon\Carbon::create()->month($m)->format('M');
                $monthTotal = $invoices->filter(function($inv) use ($m) {
                    return $inv->paid_at && $inv->paid_at->month === $m;
                })->sum('total_amount');
                $data[] = $monthTotal;
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Omzet',
                    'data' => $data,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4
                ]
            ]
        ];
    }

    public function render()
    {
        // Revenue this month from paid invoices
        $monthlyRevenue = Factuur::whereIn('status', ['betaald', 'paid'])
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

        // Get chart data for initial render
        $chartData = $this->getChartData($this->filter);

        return view('livewire.dashboards.admin-dashboard', compact(
            'monthlyRevenue',
            'activeUsers', 
            'lateInvoicesCount', 
            'recentInvoices',
            'openInvoicesCount',
            'openTicketsCount',
            'reminders',
            'chartData'
        ));
    }
}

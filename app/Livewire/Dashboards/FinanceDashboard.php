<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use App\Models\Factuur;

class FinanceDashboard extends Component
{
    public $filter = 'maand';

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $chartData = $this->getChartData($filter);
        $this->dispatch('update-finance-chart', data: $chartData);
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
        $invoicedData = [];
        $receivedData = [];

        if ($filter === 'maand') {
            $start = now()->startOfMonth();
            $end = now()->endOfMonth();
            
            // Single query for all invoices and paid invoices this month
            $allInvoices = Factuur::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->with('products')
                ->get();
            
            $paidInvoices = Factuur::whereIn('status', ['betaald', 'paid'])
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->with('products')
                ->get();
            
            $period = \Carbon\CarbonPeriod::create($start, $end);
            foreach ($period as $date) {
                $labels[] = $date->format('d');
                $invoicedData[] = $allInvoices->filter(fn($inv) => 
                    $inv->created_at && $inv->created_at->format('Y-m-d') === $date->format('Y-m-d')
                )->sum('total_amount');
                $receivedData[] = $paidInvoices->filter(fn($inv) => 
                    $inv->paid_at && $inv->paid_at->format('Y-m-d') === $date->format('Y-m-d')
                )->sum('total_amount');
            }
            
        } elseif ($filter === 'kwartaal') {
            $start = now()->startOfQuarter();
            $end = now()->endOfQuarter();
            
            // Single query for all invoices and paid invoices this quarter
            $allInvoices = Factuur::whereBetween('created_at', [$start, $end])
                ->with('products')
                ->get();
            
            $paidInvoices = Factuur::whereIn('status', ['betaald', 'paid'])
                ->whereBetween('paid_at', [$start, $end])
                ->with('products')
                ->get();
            
            $weekStart = $start->copy();
            while ($weekStart <= $end) {
                $weekEnd = $weekStart->copy()->endOfWeek();
                if ($weekEnd > $end) $weekEnd = $end;
                $labels[] = 'W' . $weekStart->weekOfYear;
                
                $invoicedData[] = $allInvoices->filter(fn($inv) => 
                    $inv->created_at && $inv->created_at >= $weekStart && $inv->created_at <= $weekEnd
                )->sum('total_amount');
                $receivedData[] = $paidInvoices->filter(fn($inv) => 
                    $inv->paid_at && $inv->paid_at >= $weekStart && $inv->paid_at <= $weekEnd
                )->sum('total_amount');
                
                $weekStart->addWeek();
            }
            
        } elseif ($filter === 'jaar') {
            // Single query for all invoices and paid invoices this year
            $allInvoices = Factuur::whereYear('created_at', now()->year)
                ->with('products')
                ->get();
            
            $paidInvoices = Factuur::whereIn('status', ['betaald', 'paid'])
                ->whereYear('paid_at', now()->year)
                ->with('products')
                ->get();
            
            for ($m = 1; $m <= 12; $m++) {
                $labels[] = \Carbon\Carbon::create()->month($m)->format('M');
                $invoicedData[] = $allInvoices->filter(fn($inv) => 
                    $inv->created_at && $inv->created_at->month === $m
                )->sum('total_amount');
                $receivedData[] = $paidInvoices->filter(fn($inv) => 
                    $inv->paid_at && $inv->paid_at->month === $m
                )->sum('total_amount');
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Gefactureerd',
                    'data' => $invoicedData,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4
                ],
                [
                    'label' => 'Ontvangen',
                    'data' => $receivedData,
                    'borderColor' => 'rgb(16, 185, 129)',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.4
                ]
            ]
        ];
    }

    public function render()
    {
        // Revenue this month (paid invoices)
        $monthlyRevenue = Factuur::whereIn('status', ['betaald', 'paid'])
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->with('products')
            ->get()
            ->sum('total_amount');

        // Outstanding invoices (total amount)
        $outstandingAmount = Factuur::whereNotIn('status', ['betaald', 'paid'])
            ->with('products')
            ->get()
            ->sum('total_amount');

        // Overdue invoices percentage
        $totalInvoices = Factuur::count();
        $overdueInvoices = Factuur::where('due_date', '<', now())
            ->whereNotIn('status', ['betaald', 'paid'])
            ->count();
        
        $overduePercentage = $totalInvoices > 0 ? round(($overdueInvoices / $totalInvoices) * 100) : 0;

        $recentInvoices = Factuur::with('customer')->latest()->take(5)->get();

        // Payment reminders logic (same as Admin)
        $reminders = Factuur::with('customer')
            ->where('due_date', '<=', now()->addDays(7))
            ->where('due_date', '>=', now()->subDays(7))
            ->whereNotIn('status', ['betaald', 'paid'])
            ->orderBy('due_date')
            ->take(5)
            ->get();

        $chartData = $this->getChartData($this->filter);
        $this->dispatch('update-finance-chart', $chartData);

        return view('livewire.dashboards.finance-dashboard', compact(
            'monthlyRevenue', 
            'outstandingAmount', 
            'overduePercentage',
            'recentInvoices',
            'reminders',
            'chartData'
        ));
    }
}

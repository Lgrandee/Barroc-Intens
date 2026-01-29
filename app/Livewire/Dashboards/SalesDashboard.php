<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use App\Models\Offerte;
use App\Models\Customer;
use App\Models\PlanningTicket;

class SalesDashboard extends Component
{
    public $filter = 'maand';

    public function setFilter($filter)
    {
        $this->filter = $filter;
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
        $createdData = [];
        $acceptedData = [];

        if ($filter === 'maand') {
             $start = now()->startOfMonth();
             $end = now()->endOfMonth();
             $period = \Carbon\CarbonPeriod::create($start, $end);
             
             foreach ($period as $date) {
                 $labels[] = $date->format('d');
                 $createdData[] = Offerte::whereDate('created_at', $date)->count();
                 $acceptedData[] = Offerte::where('status', 'accepted')->whereDate('updated_at', $date)->count();
             }
        } elseif ($filter === 'kwartaal') {
            $start = now()->startOfQuarter();
            $end = now()->endOfQuarter();
            while ($start <= $end) {
                $weekEnd = $start->copy()->endOfWeek();
                if ($weekEnd > $end) $weekEnd = $end;
                $labels[] = 'W' . $start->weekOfYear;
                
                $createdData[] = Offerte::whereBetween('created_at', [$start, $weekEnd])->count();
                $acceptedData[] = Offerte::where('status', 'accepted')->whereBetween('updated_at', [$start, $weekEnd])->count();
                
                $start->addWeek();
            }
        } elseif ($filter === 'jaar') {
             for ($m = 1; $m <= 12; $m++) {
                 $labels[] = \Carbon\Carbon::create()->month($m)->format('M');
                 $createdData[] = Offerte::whereMonth('created_at', $m)->whereYear('created_at', now()->year)->count();
                 $acceptedData[] = Offerte::where('status', 'accepted')->whereMonth('updated_at', $m)->whereYear('updated_at', now()->year)->count();
             }
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Nieuwe Offertes',
                    'data' => $createdData,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4
                ],
                [
                    'label' => 'Geaccepteerd',
                    'data' => $acceptedData,
                    'borderColor' => 'rgb(16, 185, 129)',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.4
                ]
            ]
        ];
    }

    public function render()
    {
        $totalOffertes = Offerte::count();
        $newLeads = Customer::where('created_at', '>=', now()->subMonth())->count();
        
        // Conversion Ratio: Accepted offertes / Total offertes
        $acceptedOffertes = Offerte::where('status', 'accepted')->count();
        $conversionRatio = $totalOffertes > 0 ? round(($acceptedOffertes / $totalOffertes) * 100) : 0;

        // Average deal value - simplified calculation
        $avgDealValue = 0;
        
        // Optimize: Calculate directly if possible, or limit
        // For accurate sum with pivot quantity, we need to iterate.
        // Capping at 100 recent offertes for performance estimate if needed
        $offertes = Offerte::with('products')->latest()->take(50)->get();
        if ($offertes->count() > 0) {
            $totalValue = 0;
            foreach ($offertes as $offerte) {
                foreach ($offerte->products as $p) {
                    $qty = 1; // Pivot quantity not available in DB
                    $totalValue += $p->price * $qty;
                }
            }
            $avgDealValue = $offertes->count() > 0 ? $totalValue / $offertes->count() : 0;
        }

        $recentDeals = Offerte::with('customer')->latest()->take(3)->get();

        // Tasks from planning tickets
        $recentTasks = PlanningTicket::with('user', 'feedback')
            ->orderBy('scheduled_time')
            ->take(5)
            ->get();

        $openTasksCount = PlanningTicket::where('status', 'open')->count();

        return view('livewire.dashboards.sales-dashboard', compact(
            'totalOffertes', 
            'newLeads', 
            'conversionRatio', 
            'avgDealValue',
            'recentDeals',
            'recentTasks',
            'openTasksCount'
        ));
    }
}

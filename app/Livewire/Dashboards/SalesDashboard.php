<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use App\Models\Offerte;
use App\Models\Customer;
use App\Models\PlanningTicket;

class SalesDashboard extends Component
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
        $totalOffertes = Offerte::count();
        $newLeads = Customer::where('created_at', '>=', now()->subMonth())->count();
        
        // Conversion Ratio: Accepted offertes / Total offertes
        $acceptedOffertes = Offerte::where('status', 'accepted')->count();
        $conversionRatio = $totalOffertes > 0 ? round(($acceptedOffertes / $totalOffertes) * 100) : 0;

        // Average deal value - simplified calculation
        $avgDealValue = 0;
        $offertes = Offerte::with('products')->get();
        if ($offertes->count() > 0) {
            $totalValue = 0;
            foreach ($offertes as $offerte) {
                foreach ($offerte->products as $p) {
                    $totalValue += $p->price;
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

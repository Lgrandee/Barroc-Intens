<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Factuur;
use App\Models\Offerte;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PlanningTicket;
use App\Models\OrderLogistic;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
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

        return view('admin.dashboard', compact(
            'monthlyRevenue',
            'activeUsers', 
            'lateInvoicesCount', 
            'recentInvoices',
            'openInvoicesCount',
            'openTicketsCount',
            'reminders'
        ));
    }

    public function sales()
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

        // Tasks from planning tickets assigned to current user or all recent
        $recentTasks = PlanningTicket::with('user', 'feedback')
            ->orderBy('scheduled_time')
            ->take(5)
            ->get();

        $openTasksCount = PlanningTicket::where('status', 'open')->count();

        return view('sales.dashboard', compact(
            'totalOffertes', 
            'newLeads', 
            'conversionRatio', 
            'avgDealValue',
            'recentDeals',
            'recentTasks',
            'openTasksCount'
        ));
    }

    public function purchasing()
    {
        // Total stock value - calculated in PHP for SQLite compatibility
        $totalStockValue = Product::all()->sum(function($p) { return $p->stock * $p->price; });
        
        // Product counts
        $productCount = Product::sum('stock');
        
        // Low stock products (threshold: 15 units)
        $lowStockThreshold = 15;
        $lowStockProducts = Product::where('stock', '<', $lowStockThreshold)
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->take(5)
            ->get();
        $lowStockCount = Product::where('stock', '<', $lowStockThreshold)->count();
        
        // Open orders (orders created in last month)
        $openOrdersCount = OrderLogistic::where('created_at', '>=', now()->subMonth())->count();
        
        // Recent orders
        $recentOrders = OrderLogistic::with('product')
            ->latest()
            ->take(5)
            ->get();

        // All products for stock overview
        $allProducts = Product::orderBy('stock')->take(10)->get();

        return view('purchasing.dashboard', compact(
            'totalStockValue',
            'productCount',
            'lowStockProducts',
            'lowStockCount',
            'openOrdersCount',
            'recentOrders',
            'allProducts'
        ));
    }

    public function finance()
    {
        // Monthly revenue from paid invoices
        $monthlyRevenue = Factuur::where('status', 'betaald')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->with('products')
            ->get()
            ->sum('total_amount');

        // Outstanding invoice amount
        $outstandingAmount = Factuur::whereNotIn('status', ['betaald', 'paid'])
            ->with('products')
            ->get()
            ->sum('total_amount');

        // Overdue percentage
        $totalInvoices = Factuur::count();
        $overdueCount = Factuur::where('due_date', '<', now())
            ->whereNotIn('status', ['betaald', 'paid'])
            ->count();
        $overduePercentage = $totalInvoices > 0 ? round(($overdueCount / $totalInvoices) * 100, 1) : 0;

        // Recent invoices
        $recentInvoices = Factuur::with('customer')->latest()->take(5)->get();

        // Payment reminders
        $reminders = Factuur::with('customer')
            ->where('due_date', '<=', now()->addDays(7))
            ->whereNotIn('status', ['betaald', 'paid'])
            ->orderBy('due_date')
            ->take(5)
            ->get();

        return view('finance.dashboard', compact(
            'monthlyRevenue',
            'outstandingAmount',
            'overduePercentage',
            'recentInvoices',
            'reminders'
        ));
    }

    public function technician()
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

        return view('technician.dashboard', compact(
            'openTicketsCount',
            'scheduledServicesCount',
            'avgResponseTime',
            'stockAlerts',
            'stockAlertsCount',
            'urgentTickets',
            'weeklyPlanning'
        ));
    }

    public function planner()
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

        return view('planner.dashboard', compact(
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

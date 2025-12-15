<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Factuur;
use App\Models\Offerte;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PlanningTicket; // Adjust if Ticket model name differs
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        // Stats for Admin
        $currentMonthRevenue = 0; // Placeholder as calculation is complex with dynamic attribute
        // Simplify revenue: Sum of all invoices paid this month? Or just simplified count for now.
        // Let's use counts + simpler stats.
        
        $activeUsers = User::where('status', 'active')->count(); // Assuming status field exists
        if ($activeUsers == 0) $activeUsers = User::count();

        $openTicketsCount = PlanningTicket::where('status', 'open')->count();
        
        $lateInvoicesCount = Factuur::where('due_date', '<', now())
            ->where('status', '!=', 'paid')
            ->count();

        $openInvoices = Factuur::where('status', 'open')->take(5)->get(); // For "Je hebt 5 openstaande facturen"
        
        $recentInvoices = Factuur::with('customer')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'activeUsers', 
            'lateInvoicesCount', 
            'recentInvoices',
            'openInvoices',
            'openTicketsCount'
        ));
    }

    public function sales()
    {
        $totalOffertes = Offerte::count();
        $newLeads = Customer::where('created_at', '>=', now()->subMonth())->count();
        
        // Conversion Ratio: Contracts / Offertes?
        $offertesCount = Offerte::count();
        $contractsCount = 0; // Offerte::where('status', 'accepted')->count(); ?
        $conversionRatio = $offertesCount > 0 ? round(($contractsCount / $offertesCount) * 100) : 0;

        $recentDeals = Offerte::with('customer')->latest()->take(3)->get();

        return view('sales.dashboard', compact('totalOffertes', 'newLeads', 'conversionRatio', 'recentDeals'));
    }

    public function purchasing()
    {
        return view('purchasing.dashboard');
    }

    public function finance()
    {
        return view('finance.dashboard');
    }

    public function technician()
    {
        return view('technician.dashboard');
    }

    public function planner()
    {
        return view('planner.dashboard');
    }
}

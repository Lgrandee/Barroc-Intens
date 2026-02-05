<?php

namespace App\Http\Controllers;

use App\Models\PlanningTicket;
use App\Models\Customer;
use App\Models\User;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Show the form for editing the specified ticket
     */
    public function edit($id)
    {
        $ticket = PlanningTicket::with(['user', 'feedback.customer'])->findOrFail($id);
        $customers = Customer::orderBy('name_company')->get();
        $technicians = User::where('department', 'Technician')->get();
        return view('planner.tickets.edit', compact('ticket', 'customers', 'technicians'));
    }

    /**
     * Update the specified ticket in storage
     */
    public function update(Request $request, $id)
    {
        $ticket = PlanningTicket::with('feedback')->findOrFail($id);
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:meeting,installation,service',
            'priority' => 'nullable|in:laag,medium,hoog',
            'technician_id' => 'nullable|exists:users,id',
            'appointment_date' => 'nullable|date',
        ]);

        // Update feedback
        $ticket->feedback->update([
            'customer_id' => $request->customer_id,
            'description' => $request->subject,
            'feedback' => $request->description,
        ]);

        // Update ticket
        $ticket->update([
            'catagory' => $request->category,
            'priority' => $request->priority,
            'user_id' => $request->technician_id ?? $ticket->user_id,
            'appointment_date' => $request->appointment_date,
        ]);

        return redirect()->route('planner.tickets.index')
            ->with('success', 'Ticket succesvol bijgewerkt!');
    }
    /**
     * Display ticket overview
     */
    public function index(Request $request)
    {
        $query = PlanningTicket::with(['user', 'feedback.customer']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('feedback.customer', function($customerQuery) use ($search) {
                    $customerQuery->where('name_company', 'like', "%{$search}%");
                })
                ->orWhere('id', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Priority filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Department/Category filter
        if ($request->filled('department')) {
            $query->where('catagory', $request->department);
        }

        $tickets = $query->orderBy('scheduled_time', 'desc')->paginate(20);

        return view('planner.tickets.index', compact('tickets'));
    }

    /**
     * Show ticket creation form
     */
    public function create()
    {
        $customers = Customer::orderBy('name_company')->get();
        $technicians = User::where('department', 'Technician')->get();

        return view('planner.tickets.create', compact('customers', 'technicians'));
    }

    /**
     * Store new ticket
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:meeting,installation,service',
            'priority' => 'nullable|in:laag,medium,hoog',
            'technician_id' => 'nullable|exists:users,id',
            'appointment_date' => 'required|date',
        ]);

        // Create feedback entry
        $feedback = Feedback::create([
            'customer_id' => $request->customer_id,
            'employee_id' => Auth::id(),
            'description' => $request->subject,
            'feedback' => $request->description,
        ]);

        // Create planning ticket
        $ticket = PlanningTicket::create([
            'catagory' => $request->category,
            'feedback_id' => $feedback->id,
            'location' => $request->location ?? Customer::find($request->customer_id)->address,
            'scheduled_time' => $request->scheduled_time ?? now()->addDays(2),
            'appointment_date' => $request->appointment_date,
            'user_id' => $request->technician_id ?? User::where('department', 'Technician')->first()->id,
        ]);

        return redirect()->route('planner.tickets.index')
            ->with('success', 'Ticket succesvol aangemaakt!');
    }

    /**
     * Display ticket details
     */
    public function show($id)
    {
        $ticket = PlanningTicket::with(['user', 'feedback.customer', 'feedback.products'])->findOrFail($id);

        return view('planner.tickets.show', compact('ticket'));
    }
    /**
     * Verwijder een ticket
     */
    public function destroy($id)
    {
        $ticket = PlanningTicket::findOrFail($id);
        // Verwijder gekoppelde feedback indien gewenst
        if ($ticket->feedback) {
            $ticket->feedback->delete();
        }
        $ticket->delete();
        return redirect()->route('planner.tickets.index')->with('success', 'Ticket succesvol verwijderd!');
    }
}

<?php

namespace App\Livewire;

use App\Models\PlanningTicket;
use Livewire\Component;
use Livewire\WithPagination;

class PlannerTicketsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $priority = '';
    public $department = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'priority' => ['except' => ''],
        'department' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingPriority()
    {
        $this->resetPage();
    }

    public function updatingDepartment()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->status = '';
        $this->priority = '';
        $this->department = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = PlanningTicket::with(['user', 'feedback.customer']);

        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('feedback.customer', function ($customerQuery) use ($search) {
                    $customerQuery->where('name_company', 'like', "%{$search}%");
                })
                ->orWhere('id', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->priority) {
            $query->where('priority', $this->priority);
        }

        if ($this->department) {
            $query->where('catagory', $this->department);
        }

        $tickets = $query->orderBy('scheduled_time', 'desc')->paginate(15);

        return view('livewire.planner-tickets-table', [
            'tickets' => $tickets,
        ]);
    }
}

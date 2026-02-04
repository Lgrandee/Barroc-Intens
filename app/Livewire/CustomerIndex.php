<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $bkrStatus = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingBkrStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $customers = Customer::when($this->search, function ($query) {
            return $query->where(function ($q) {
                $q->where('name_company', 'like', '%' . $this->search . '%')
                  ->orWhere('contact_person', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone_number', 'like', '%' . $this->search . '%');
            });
        })
        ->when($this->bkrStatus !== '', function ($query) {
            $query->where('bkr_status', $this->bkrStatus);
        })
        ->paginate(15);

        return view('livewire.customer-index', compact('customers'));
    }
}

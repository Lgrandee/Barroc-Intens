<?php

namespace App\Livewire;

use App\Models\Factuur;
use Livewire\Component;
use Livewire\WithPagination;

class FactuurTable extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'all';
    public $period = 'all';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingPeriod()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->status = 'all';
        $this->period = 'this_month';
        $this->resetPage();
    }

    public function delete($factuurId)
    {
        $factuur = Factuur::find($factuurId);

        if ($factuur) {
            $factuur->delete();
            session()->flash('success', 'Factuur verwijderd.');
        }
    }

    public function render()
    {
        $query = Factuur::with(['customer', 'products']);

        // Zoekfunctie
        if ($this->search) {
            $query->where(function($q) {
                $q->where('id', 'like', "%{$this->search}%")
                  ->orWhereHas('customer', function($q) {
                      $q->where('name_company', 'like', "%{$this->search}%");
                  });
            });
        }

        // Status filter
        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }

        // Periode filter
        if ($this->period === 'this_month') {
            $query->whereMonth('invoice_date', now()->month)
                  ->whereYear('invoice_date', now()->year);
        } elseif ($this->period === 'last_30_days') {
            $query->where('invoice_date', '>=', now()->subDays(30));
        } elseif ($this->period === 'last_90_days') {
            $query->where('invoice_date', '>=', now()->subDays(90));
        }

        $facturen = $query->orderBy('invoice_date', 'desc')->paginate(10);

        return view('livewire.factuur-table', [
            'facturen' => $facturen
        ]);
    }
}

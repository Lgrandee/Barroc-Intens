<?php

namespace App\Livewire;

use App\Models\Factuur;
use Carbon\Carbon;
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
        $periodLabel = null;
        $periodStart = null;
        $periodEnd = null;

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
            $periodStart = Carbon::now()->startOfMonth();
            $periodEnd = Carbon::now()->endOfMonth();
            $periodLabel = 'Deze maand';
            $query->whereBetween('invoice_date', [$periodStart, $periodEnd]);
        } elseif ($this->period === 'last_30_days') {
            $periodEnd = Carbon::now();
            $periodStart = Carbon::now()->subDays(30);
            $periodLabel = 'Laatste 30 dagen';
            $query->where('invoice_date', '>=', $periodStart);
        } elseif ($this->period === 'last_90_days') {
            $periodEnd = Carbon::now();
            $periodStart = Carbon::now()->subDays(90);
            $periodLabel = 'Laatste 90 dagen';
            $query->where('invoice_date', '>=', $periodStart);
        }

        $facturen = $query->orderBy('invoice_date', 'desc')->paginate(10);

        return view('livewire.factuur-table', [
            'facturen' => $facturen,
            'periodLabel' => $periodLabel,
            'periodStart' => $periodStart,
            'periodEnd' => $periodEnd,
        ]);
    }
}

<?php

namespace App\Livewire;

use App\Models\Offerte;
use Livewire\Component;
use Livewire\WithPagination;

class OfferteTable extends Component
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
        $this->period = 'all';
        $this->resetPage();
    }

    public function delete($offerteId)
    {
        $offerte = Offerte::find($offerteId);

        if ($offerte) {
            $offerte->delete();
            session()->flash('success', 'Offerte verwijderd.');
        }
    }

    public function render()
    {
        $query = Offerte::with(['customer', 'products' => function($q) {
            $q->withPivot('quantity');
        }]);

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
        if ($this->period === 'last_7_days') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($this->period === 'last_30_days') {
            $query->where('created_at', '>=', now()->subDays(30));
        } elseif ($this->period === 'last_90_days') {
            $query->where('created_at', '>=', now()->subDays(90));
        }

        $offertes = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.offerte-table', [
            'offertes' => $offertes
        ]);
    }
}

<?php

namespace App\Livewire;

use App\Models\OrderLogistic;
use Livewire\Component;
use Livewire\WithPagination;

class OrderLogisticsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->sortBy = 'created_at';
        $this->sortDirection = 'desc';
        $this->resetPage();
    }

    public function render()
    {
        $query = OrderLogistic::with('product');

        // Zoekfunctie
        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('product', function($q) {
                    $q->where('product_name', 'like', "%{$this->search}%");
                });
            });
        }

        $logs = $query->orderBy($this->sortBy, $this->sortDirection)->paginate(15);

        return view('livewire.order-logistics-table', [
            'logs' => $logs
        ]);
    }
}

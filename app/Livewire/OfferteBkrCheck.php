<?php

namespace App\Livewire;

use App\Models\Offerte;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OfferteBkrCheck extends Component
{
    public Offerte $offerte;
    public string $status;

    public function mount(Offerte $offerte): void
    {
        $this->offerte = $offerte->loadMissing('customer');
        $this->status = $this->offerte->customer->bkr_status ?? 'unknown';
    }

    public function approve(): void
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Sales', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Sales en Management hebben toegang tot offertes.');
        }

        if ($this->offerte->customer) {
            $this->offerte->customer->bkr_status = 'approved';
            $this->offerte->customer->save();
            $this->status = 'approved';
            session()->flash('success', 'BKR check gemarkeerd als goedgekeurd.');
        }
    }

    public function render()
    {
        return view('livewire.offerte-bkr-check', [
            'isApproved' => $this->status === 'approved',
        ]);
    }
}

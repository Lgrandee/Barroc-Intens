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
        // Altijd de opgeslagen bkr_status van de klant gebruiken, anders 'unknown'
        $this->status = $this->offerte->customer->bkr_status ?? 'unknown';
    }

    public function approve(): void
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Sales', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Sales en Management hebben toegang tot offertes.');
        }

        if ($this->offerte->customer) {
            // Random kans: 70% approved, 30% denied
            $isApproved = rand(1, 100) <= 70;
            $this->offerte->customer->bkr_status = $isApproved ? 'approved' : 'denied';
            $this->offerte->customer->save();
            $this->status = $this->offerte->customer->bkr_status;

            if ($isApproved) {
                session()->flash('success', 'BKR check gemarkeerd als goedgekeurd.');
            } else {
                session()->flash('warning', 'BKR check gemarkeerd als afgekeurd. Neem contact op met de klant.');
            }
        }
    }

    public function resetBkrStatus(): void
    {
        $this->status = 'unknown';
    }

    public function render()
    {
        return view('livewire.offerte-bkr-check', [
            'isApproved' => $this->status === 'approved',
            'isDenied' => $this->status === 'denied',
            'isUnknown' => $this->status === 'unknown',
        ]);
    }
}

<?php

namespace App\Livewire;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerBkrCheck extends Component
{
    public Customer $customer;
    public string $status;

    public function mount(Customer $customer): void
    {
        $this->customer = $customer;
        $this->status = $this->customer->bkr_status ?? 'unknown';
    }

    public function approve(): void
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Sales', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Sales en Management hebben toegang tot BKR checks.');
        }

        $isApproved = rand(1, 100) <= 70;
        $this->customer->bkr_status = $isApproved ? 'approved' : 'denied';
        $this->customer->save();
        $this->status = $this->customer->bkr_status;

        if ($isApproved) {
            session()->flash('success', 'BKR check gemarkeerd als goedgekeurd.');
        } else {
            session()->flash('warning', 'BKR check gemarkeerd als afgekeurd. Neem contact op met de klant.');
        }
    }

    public function resetBkrStatus(): void
    {
        $this->status = 'unknown';
    }

    public function render()
    {
        return view('livewire.customer-bkr-check', [
            'isApproved' => $this->status === 'approved',
            'isDenied' => $this->status === 'denied',
            'isUnknown' => $this->status === 'unknown',
        ]);
    }
}

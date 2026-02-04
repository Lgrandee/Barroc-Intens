<?php

namespace App\Http\Controllers;

use App\Models\Offerte;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OfferteController extends Controller
{
    public function index(Request $request)
    {
        // Controleer of gebruiker Sales of Management is
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Sales', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Sales en Management hebben toegang tot offertes.');
        }

        return view('offerte.index');
    }

    public function show($id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Sales', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Sales en Management hebben toegang tot offertes.');
        }

        $offerte = Offerte::with(['customer', 'products'])->findOrFail($id);

        return view('offerte.show', compact('offerte'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Sales', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Sales en Management hebben toegang tot offertes.');
        }

        return view('offerte.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Sales', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Sales en Management hebben toegang tot offertes.');
        }

        $validated = $request->validate([
            'name_company_id' => ['required', 'exists:customers,id'],
            'product_ids' => ['required', 'array', 'min:1'],
            'product_ids.*' => ['required', 'exists:products,id'],
            'product_quantities' => ['required', 'array'],
            'product_quantities.*' => ['required', 'integer', 'min:1'],
            'valid_until' => ['nullable', 'date', 'after:today'],
            'delivery_time_weeks' => ['nullable', 'integer', 'min:1'],
            'payment_terms_days' => ['nullable', 'integer', 'min:1'],
            'custom_terms' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', 'in:pending,draft'],
        ]);

        // Store primary product in product_id for backward compatibility
        $primaryProduct = $validated['product_ids'][0] ?? null;

        $offerte = Offerte::create([
            'name_company_id' => $validated['name_company_id'],
            'product_id' => $primaryProduct,
            'status' => $validated['status'],
            'valid_until' => $validated['valid_until'] ?? now()->addDays(30),
            'delivery_time_weeks' => $validated['delivery_time_weeks'] ?? null,
            'payment_terms_days' => $validated['payment_terms_days'] ?? null,
            'custom_terms' => $validated['custom_terms'] ?? null,
        ]);

        // Attach products many-to-many with quantity
        $syncData = [];
        foreach ($validated['product_ids'] as $productId) {
            $qty = $validated['product_quantities'][$productId] ?? 1;
            $syncData[$productId] = ['quantity' => $qty];
        }
        $offerte->products()->sync($syncData);

        // Always redirect to show page (approval/send page)
        return redirect()->route('offertes.show', $offerte->id)->with('success', 'Offerte aangemaakt. Controleer de details en verstuur naar de klant.');
    }

    public function downloadPdf($id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Sales', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Sales en Management hebben toegang tot offertes.');
        }

        $offerte = Offerte::with(['customer', 'products'])->findOrFail($id);
        $pdf = Pdf::loadView('offerte.pdf', compact('offerte'));
        $filename = 'Offerte-OFF-' . date('Y', strtotime($offerte->created_at)) . '-' . str_pad($offerte->id, 3, '0', STR_PAD_LEFT) . '.pdf';
        return $pdf->download($filename);
    }

    public function downloadTermsPdf()
    {
        $pdf = Pdf::loadView('offerte.terms-pdf');
        return $pdf->download('Algemene-voorwaarden-2025.pdf');
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Sales', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Sales en Management hebben toegang tot offertes.');
        }

        $offerte = Offerte::with(['customer', 'products'])->findOrFail($id);

        return view('offerte.edit', compact('offerte'));
    }

    public function sendToCustomer($id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Sales', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Sales en Management hebben toegang tot offertes.');
        }

        $offerte = Offerte::with('customer')->findOrFail($id);
        $offerte->sent_at = now();

        // If still in draft, move to pending to reflect it was sent
        if ($offerte->status === 'draft') {
            $offerte->status = 'pending';
        }

        $offerte->save();

        $customerLabel = $offerte->customer->name_company ?? $offerte->customer->email ?? 'onbekende klant';

        return redirect()->route('offertes.index')
            ->with('success', 'Offerte gemarkeerd als verstuurd naar ' . $customerLabel);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Sales', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Sales en Management hebben toegang tot offertes.');
        }

        $validated = $request->validate([
            'name_company_id' => ['required', 'exists:customers,id'],
            'product_ids' => ['required', 'array', 'min:1'],
            'product_ids.*' => ['required', 'exists:products,id'],
            'product_quantities' => ['required', 'array'],
            'product_quantities.*' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:accepted,rejected,pending,draft'],
        ]);

        $offerte = Offerte::findOrFail($id);
        $oldStatus = $offerte->status;

        // Store primary product in product_id for backward compatibility
        $primaryProduct = $validated['product_ids'][0] ?? null;

        $offerte->update([
            'name_company_id' => $validated['name_company_id'],
            'product_id' => $primaryProduct,
            'status' => $validated['status'],
        ]);

        // Sync products many-to-many with quantity
        $syncData = [];
        foreach ($validated['product_ids'] as $productId) {
            $qty = $validated['product_quantities'][$productId] ?? 1;
            $syncData[$productId] = ['quantity' => $qty];
        }
        $offerte->products()->sync($syncData);

        // Als offerte wordt geaccepteerd, maak automatisch een factuur en contract aan
        if ($validated['status'] === 'accepted' && $oldStatus !== 'accepted') {
            $this->createFactuurFromOfferte($offerte);
            return redirect()->route('offertes.show', $offerte->id)->with('success', 'Contract aangemaakt. Factuur aangemaakt.');
        }

        return redirect()->route('offertes.show', $offerte->id)->with('success', 'Offerte bijgewerkt.');
    }


    /**
     * Create a factuur automatically from an accepted offerte
     */
    private function createFactuurFromOfferte(Offerte $offerte)
    {
        if ($offerte->status !== 'accepted') {
            return; // Safety: only create contract/factuur when accepted
        }

        $offerte->loadMissing(['products', 'contract']);

        // Check if factuur already exists for this offerte
        if (!$offerte->factuur()->exists()) {
            // Create factuur with same data as offerte
            $factuur = \App\Models\Factuur::create([
                'name_company_id' => $offerte->name_company_id,
                'offerte_id' => $offerte->id,
                'invoice_date' => now(),
                'due_date' => now()->addDays(30), // Default 30 dagen betalingstermijn
                'reference' => 'OFF-' . date('Y', strtotime($offerte->created_at)) . '-' . str_pad($offerte->id, 3, '0', STR_PAD_LEFT),
                'payment_method' => 'bank_transfer',
                'description' => 'Factuur voor geaccepteerde offerte',
                'status' => 'concept',
            ]);

            // Copy products from offerte to factuur
            $syncData = [];
            foreach ($offerte->products as $product) {
                $qty = $product->pivot->quantity ?? 1;
                $syncData[$product->id] = ['quantity' => $qty];
            }
            $factuur->products()->sync($syncData);
        }

        // Create contract alongside the factuur (once)
        $primaryProduct = $offerte->products->first();
        $contractExists = Contract::where('name_company_id', $offerte->name_company_id)
            ->whereDate('start_date', now()->toDateString())
            ->where('product_id', $primaryProduct?->id)
            ->exists();

        if (!$offerte->contract) {
            $contract = Contract::create([
                'name_company_id' => $offerte->name_company_id,
                'product_id' => $primaryProduct?->id,
                'offerte_id' => $offerte->id,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addYear()->toDateString(),
                'status' => 'active',
            ]);

            // Attach same products with quantities to the contract
            $contractSync = [];
            foreach ($offerte->products as $product) {
                $qty = $product->pivot->quantity ?? 1;
                $contractSync[$product->id] = ['quantity' => $qty];
            }
            $contract->products()->sync($contractSync);
        }
    }
}

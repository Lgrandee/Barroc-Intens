<?php

namespace App\Http\Controllers;

use App\Models\Factuur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactuurController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Finance', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Finance en Management hebben toegang tot facturen.');
        }

        return view('factuur.index');
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Finance', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Finance en Management hebben toegang tot facturen.');
        }

        return view('factuur.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Finance', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Finance en Management hebben toegang tot facturen.');
        }

        $validated = $request->validate([
            'name_company_id' => ['required', 'exists:customers,id'],
            'invoice_date' => ['required', 'date'],
            // Optional: used only to calculate due_date, not stored directly
            'payment_terms_days' => ['nullable', 'integer', 'min:0'],
            'reference' => ['nullable', 'string', 'max:100'],
            'payment_method' => ['required', 'in:bank_transfer,ideal,creditcard,cash'],
            'description' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'product_ids' => ['required', 'array', 'min:1'],
            'product_ids.*' => ['required', 'exists:products,id'],
            'product_quantities' => ['required', 'array'],
            'product_quantities.*' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:concept,verzonden'],
        ]);

        // Calculate due date based on payment terms (defaults to 30 days if not provided)
        $paymentTermsDays = (int) ($validated['payment_terms_days'] ?? 30);
        $dueDate = \Carbon\Carbon::parse($validated['invoice_date'])->addDays($paymentTermsDays);

        // Always create as 'concept' first - only mark as 'verzonden' when actually sent from send page
        $factuur = Factuur::create([
            'name_company_id' => $validated['name_company_id'],
            'invoice_date' => $validated['invoice_date'],
            'due_date' => $dueDate,
            'reference' => $validated['reference'] ?? null,
            'payment_method' => $validated['payment_method'],
            'description' => $validated['description'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'concept',
            'sent_at' => null,
        ]);

        // Attach products with quantities
        $syncData = [];
        foreach ($validated['product_ids'] as $productId) {
            $qty = $validated['product_quantities'][$productId] ?? 1;
            $syncData[$productId] = ['quantity' => $qty];
        }
        $factuur->products()->sync($syncData);

        // Redirect based on user's choice
        if ($validated['status'] === 'concept') {
            return redirect()->route('facturen.edit', $factuur->id)->with('success', 'Factuur concept opgeslagen.');
        }

        // User chose "Maak aan en verstuur" - go to send page
        return redirect()->route('facturen.send', $factuur->id)->with('success', 'Factuur aangemaakt. Verstuur naar klant.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Finance', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Finance en Management hebben toegang tot facturen.');
        }

        $factuur = Factuur::with(['customer', 'products'])->findOrFail($id);
        $factuur->factuurnr = 'FACT-' . date('Y', strtotime($factuur->invoice_date)) . '-' . str_pad($factuur->id, 3, '0', STR_PAD_LEFT);

        return view('factuur.edit', compact('factuur'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Finance', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Finance en Management hebben toegang tot facturen.');
        }

        $validated = $request->validate([
            'name_company_id' => ['required', 'exists:customers,id'],
            'product_ids' => ['required', 'array', 'min:1'],
            'product_ids.*' => ['required', 'exists:products,id'],
            'product_quantities' => ['required', 'array'],
            'product_quantities.*' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $factuur = Factuur::findOrFail($id);

        $factuur->update([
            'name_company_id' => $validated['name_company_id'],
            'description' => $validated['description'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Sync products with quantities
        $syncData = [];
        foreach ($validated['product_ids'] as $productId) {
            $qty = $validated['product_quantities'][$productId] ?? 1;
            $syncData[$productId] = ['quantity' => $qty];
        }
        $factuur->products()->sync($syncData);

        return redirect()->route('facturen.edit', $factuur->id)->with('success', 'Factuur bijgewerkt.');
    }

    public function send($id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Finance', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Finance en Management hebben toegang tot facturen.');
        }

        $factuur = Factuur::with(['customer', 'products'])->findOrFail($id);
        $factuur->factuurnr = 'FACT-' . date('Y', strtotime($factuur->invoice_date)) . '-' . str_pad($factuur->id, 3, '0', STR_PAD_LEFT);

        return view('factuur.send', compact('factuur'));
    }

    public function sendEmail(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Finance', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Finance en Management hebben toegang tot facturen.');
        }

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
        ]);

        $factuur = Factuur::findOrFail($id);

        // Update status to verzonden and log sent_at timestamp
        $factuur->update([
            'status' => 'verzonden',
            'sent_at' => now(),
        ]);

        // TODO: Send actual email here with Mail facade
        // Mail::to($validated['email'])->send(new FactuurMail($factuur));

        return redirect()->route('facturen.index')->with('success', 'Factuur verstuurd naar ' . $validated['email'] . ' op ' . now()->format('d-m-Y H:i'));
    }

    public function downloadPdf($id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Finance', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Finance en Management hebben toegang tot facturen.');
        }

        $factuur = Factuur::with(['customer', 'products'])->findOrFail($id);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('factuur.pdf', compact('factuur'));
        $filename = 'FACT-' . date('Y', strtotime($factuur->invoice_date)) . '-' . str_pad($factuur->id, 3, '0', STR_PAD_LEFT) . '.pdf';
        return $pdf->download($filename);
    }
}

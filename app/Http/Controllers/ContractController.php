<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        // Controleer of gebruiker Finance of Management is
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Finance', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Finance en Management hebben toegang tot contracten.');
        }

        $query = Contract::with(['customer', 'products']);

        // Zoekfunctie
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('customer', function($q) use ($search) {
                    $q->where('name_company', 'like', "%{$search}%");
                })
                ->orWhereHas('products', function($q) use ($search) {
                    $q->where('product_name', 'like', "%{$search}%");
                })
                ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Sorteer op startdatum
        $contracts = $query->orderBy('start_date', 'desc')->paginate(10);

        // Total active contracts (for quick stats)
        $totalActive = Contract::where('status', 'active')->count();

        return view('contract.index', compact('contracts', 'totalActive'));
    }

    public function show($id)
    {
        // Controleer of gebruiker Finance of Management is
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Finance', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Finance en Management hebben toegang tot contracten.');
        }

        $contract = Contract::with(['customer', 'products'])->findOrFail($id);

        return view('contract.show', compact('contract'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Finance', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Finance en Management hebben toegang tot contracten.');
        }

        return view('contract.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Finance', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Finance en Management hebben toegang tot contracten.');
        }

        $validated = $request->validate([
            'name_company_id' => ['required', 'exists:customers,id'],
            'product_ids' => ['required', 'array', 'min:1'],
            'product_ids.*' => ['required', 'exists:products,id'],
            'product_quantities' => ['required', 'array'],
            'product_quantities.*' => ['required', 'integer', 'min:1'],
            'start_date' => ['required', 'date'],
        ]);

        // store primary product in product_id for backward compat
        $primaryProduct = $validated['product_ids'][0] ?? null;

        // Bepaal end_date automatisch 2 jaar na start_date
        $startDate = new \DateTime($validated['start_date']);
        $endDate = (clone $startDate)->modify('+2 years');

        $contract = Contract::create([
            'name_company_id' => $validated['name_company_id'],
            'product_id' => $primaryProduct,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'status' => 'pending',
        ]);

        // Attach products many-to-many with quantity
        $syncData = [];
        foreach ($validated['product_ids'] as $productId) {
            $qty = $validated['product_quantities'][$productId] ?? 1;
            $syncData[$productId] = ['quantity' => $qty];
        }
        $contract->products()->sync($syncData);

        return redirect()->route('contracts.show', $contract->id)->with('success', 'Contract aangemaakt.');
    }

    public function downloadPdf($id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->department ?? '', ['Finance', 'Management'])) {
            abort(403, 'Toegang geweigerd. Alleen Finance en Management hebben toegang tot contracten.');
        }

        $contract = Contract::with(['customer', 'products'])->findOrFail($id);
        $pdf = Pdf::loadView('contract.pdf', compact('contract'));
        $filename = 'Contract-CON-' . date('Y', strtotime($contract->start_date)) . '-' . str_pad($contract->id, 3, '0', STR_PAD_LEFT) . '.pdf';
        return $pdf->download($filename);
    }
}

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factuur bewerken</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        /* Light-only page background override */
        html:not(.dark) body { background-color: #f3f4f6 !important; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-zinc-900">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-white dark:bg-zinc-800 border-b border-gray-200 dark:border-zinc-700 px-6 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-black dark:text-white">Factuur bewerken</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Wijzig de factuurgegevens</p>
                </div>
                <a href="{{ route('facturen.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                    Terug naar overzicht
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('facturen.update', $factuur->id) }}" method="POST" id="factuurForm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column - Main Form -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Bewerk factuur section -->
                        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl p-6 border border-gray-200 dark:border-zinc-700">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-black dark:text-white">Bewerk factuur</h2>
                                <div class="flex gap-2">
                                    <button type="button" onclick="window.location.href='{{ route('facturen.index') }}'"
                                        class="px-4 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
                                        Annuleren
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 text-sm bg-yellow-400 text-black rounded hover:bg-yellow-300 font-semibold shadow">
                                        Opslaan wijzigingen
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <!-- Factuur Info -->
                                <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-600 rounded p-4">
                                    <div class="grid grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Klant</div>
                                            <span class="text-black dark:text-white font-medium">{{ $factuur->customer->name_company ?? 'Onbekend' }}</span>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Factuurnr</div>
                                            <span class="text-black dark:text-white font-medium">{{ $factuur->factuurnr }}</span>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Factuurdatum</div>
                                            <span class="text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($factuur->invoice_date)->format('d-m-Y') }}</span>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Status</div>
                                            @switch($factuur->status)
                                                @case('betaald')
                                                    <span class="text-green-700 font-medium">✅ Betaald</span>
                                                    @break
                                                @case('verzonden')
                                                    <span class="text-yellow-700 font-medium">📧 Verzonden</span>
                                                    @break
                                                @case('verlopen')
                                                    <span class="text-red-700 font-medium">⚠️ Verlopen</span>
                                                    @break
                                                @case('concept')
                                                    <span class="text-gray-700 font-medium">📝 Concept</span>
                                                    @break
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="mt-2 pt-2 border-t text-xs space-y-1">
                                        @if($factuur->offerte)
                                            <div>
                                                <span class="text-gray-500">Gekoppeld aan offerte:</span>
                                                <a href="{{ route('offertes.show', $factuur->offerte->id) }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                                                    OFF-{{ date('Y', strtotime($factuur->offerte->created_at)) }}-{{ str_pad($factuur->offerte->id, 3, '0', STR_PAD_LEFT) }}
                                                </a>
                                            </div>
                                        @endif
                                        @if($factuur->reference)
                                            <div>
                                                <span class="text-gray-500">Referentie:</span>
                                                <span class="text-gray-900">{{ $factuur->reference }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>                                <!-- Customer Search (read-only display) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Klant</label>
                                    <input type="text" value="{{ $factuur->customer->name_company ?? '' }}" disabled
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-gray-50 dark:bg-zinc-700 text-gray-700 dark:text-gray-300">
                                    <input type="hidden" name="name_company_id" value="{{ $factuur->name_company_id }}">
                                </div>

                                <!-- Regels Header -->
                                <div class="pt-4">
                                    <div class="grid grid-cols-12 gap-2 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-2">
                                        <div class="col-span-5">Omschrijving</div>
                                        <div class="col-span-2">Aantal</div>
                                        <div class="col-span-2">Prijs</div>
                                        <div class="col-span-2">Actie</div>
                                    </div>
                                </div>

                                <!-- Products -->
                                @livewire('product-multi-select', [
                                    'name' => 'products',
                                    'initialSelected' => $factuur->products->pluck('id')->toArray(),
                                    'initialQuantities' => $factuur->products->mapWithKeys(function($product) {
                                        return [$product->id => $product->pivot->quantity];
                                    })->toArray()
                                ])

                                <!-- Add Rule Button -->
                                <button type="button" class="text-sm text-gray-700 dark:text-gray-300 hover:text-black dark:hover:text-white font-medium">
                                    + Regel toevoegen
                                </button>

                                <!-- Description -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Omschrijving (zichtbaar op factuur)</label>
                                    <textarea name="description" rows="2"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">{{ $factuur->description ?? '' }}</textarea>
                                </div>

                                <!-- Internal Notes -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Interne notities (niet zichtbaar voor klant)</label>
                                    <textarea name="notes" rows="2"
                                        class="w-full px-3 py-2 border border-yellow-300 dark:border-yellow-600 rounded bg-yellow-50 dark:bg-yellow-900/20 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">{{ $factuur->notes ?? '' }}</textarea>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">💡 Deze notities zijn alleen voor intern gebruik</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Summary & History -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Total Summary -->
                        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl p-6 border border-gray-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-black dark:text-white mb-4">Totaal</h2>

                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-300">Subtotaal</span>
                                    <span class="font-medium text-black dark:text-white" id="subtotal">€{{ number_format($factuur->products->sum(function($p) { return $p->price * $p->pivot->quantity; }), 2, ',', '.') }}</span>
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-300">BTW (21%)</span>
                                    <span class="font-medium text-black dark:text-white" id="btw">€{{ number_format($factuur->products->sum(function($p) { return $p->price * $p->pivot->quantity; }) * 0.21, 2, ',', '.') }}</span>
                                </div>

                                <div class="border-t border-gray-200 dark:border-zinc-600 pt-3 flex justify-between">
                                    <span class="font-semibold text-black dark:text-white">Totaal</span>
                                    <span class="font-semibold text-black dark:text-white text-lg" id="total">€{{ number_format($factuur->total_amount * 1.21, 2, ',', '.') }}</span>
                                </div>
                            </div>

                            <a href="{{ route('facturen.send', $factuur->id) }}" class="block text-center bg-yellow-400 hover:bg-yellow-300 text-black font-semibold py-2 px-4 rounded shadow mt-6 text-sm transition-colors">
                                Verstuur factuur →
                            </a>
                        </div>

                        <!-- Change History -->
                        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl p-6 border border-gray-200 dark:border-zinc-700">
                            <h3 class="text-lg font-semibold text-black dark:text-white mb-4">Wijzigingsgeschiedenis</h3>

                            <div class="space-y-3 text-sm">
                                <div>
                                    <div class="text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($factuur->updated_at)->format('d M Y') }}</div>
                                    <div class="text-black dark:text-white">— Aangepast door {{ Auth::user()->name ?? 'Gebruiker' }}</div>
                                </div>
                                <div>
                                    <div class="text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($factuur->created_at)->format('d M Y') }}</div>
                                    <div class="text-black dark:text-white">— Concept aangemaakt</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('facturen.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                        Terug naar factuur overzicht
                    </a>
                </div>
            </form>
        </div>
    </div>

    @livewireScripts

    <script>
        // Update totals dynamically
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('productsUpdated', (data) => {
                const subtotal = data[0]?.subtotal || 0;
                const btw = subtotal * 0.21;
                const total = subtotal + btw;

                document.getElementById('subtotal').textContent = '€' + subtotal.toFixed(2).replace('.', ',');
                document.getElementById('btw').textContent = '€' + btw.toFixed(2).replace('.', ',');
                document.getElementById('total').textContent = '€' + total.toFixed(2).replace('.', ',');
            });
        });
    </script>
</body>
</html>

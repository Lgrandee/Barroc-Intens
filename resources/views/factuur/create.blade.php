<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factuur aanmaken</title>
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
                    <h1 class="text-3xl font-semibold text-black dark:text-white">Factuur aanmaken</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Maak een nieuwe factuur aan</p>
                </div>
                <a href="{{ route('facturen.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                    Terug naar overzicht
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-8">
            <form action="{{ route('facturen.store') }}" method="POST" id="factuurForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column - Main Form -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Nieuwe factuur section -->
                        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl p-6 border border-gray-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-black dark:text-white mb-4">Nieuwe factuur</h2>

                            <div class="space-y-4">
                                <!-- Customer Search -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kies klant of zoek...</label>
                                    @livewire('customer-search', ['name' => 'name_company_id', 'required' => true])
                                </div>

                                <!-- Factuurnr and Invoice Date -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Factuurnr (auto)</label>
                                        <input type="text" value="Wordt automatisch gegenereerd" disabled
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-gray-50 dark:bg-zinc-700 text-gray-500 dark:text-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Factuurdatum</label>
                                        <input type="date" name="invoice_date" value="{{ date('Y-m-d') }}" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                    </div>
                                </div>

                                <!-- Reference and Payment Terms -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Referentie (optioneel)</label>
                                        <input type="text" name="reference" placeholder="Contract-nr, Offerte-nr, of Project-nr"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Bijv: CONTRACT-2025-001 of OFF-2025-005</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Betalingstermijn</label>
                                        <select name="payment_terms_days" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                            <option value="30">30 dagen</option>
                                            <option value="14">14 dagen</option>
                                            <option value="7">7 dagen</option>
                                            <option value="0">Direct betaalbaar</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Betaalwijze</label>
                                    <select name="payment_method" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                        <option value="bank_transfer">Bankoverschrijving</option>
                                        <option value="ideal">iDEAL</option>
                                        <option value="creditcard">Creditcard</option>
                                        <option value="cash">Contant</option>
                                    </select>
                                </div>

                                <!-- Products Table -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Producten</label>
                                    @livewire('product-multi-select', ['name' => 'products'])
                                </div>

                                <!-- Description for Invoice -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Omschrijving</label>
                                    <textarea name="description" rows="2" placeholder="Korte omschrijving van de factuur (verschijnt op de factuur)"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">{{ old('description') }}</textarea>
                                </div>

                                <!-- Internal Notes -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Interne notities (optioneel)</label>
                                    <textarea name="notes" rows="3" placeholder="Notities voor intern gebruik, niet zichtbaar voor klant"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">{{ old('notes') }}</textarea>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3 pt-4">
                                    <button type="submit" name="status" value="concept"
                                        class="px-6 py-2 border border-gray-300 dark:border-zinc-600 rounded text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700 font-medium">
                                        💾 Opslaan als concept
                                    </button>
                                    <button type="submit" name="status" value="verzonden"
                                        class="px-6 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-300 font-semibold shadow">
                                        ✉️ Maak aan en verstuur
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Preview & Total -->
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl p-6 sticky top-6 border border-gray-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-black dark:text-white mb-4">Voorbeeld & Totaal</h2>

                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-300">Subtotaal</span>
                                    <span class="font-medium text-black dark:text-white" id="subtotal">€0,00</span>
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-300">BTW (21%)</span>
                                    <span class="font-medium text-black dark:text-white" id="btw">€0,00</span>
                                </div>

                                <div class="border-t border-gray-200 dark:border-zinc-600 pt-3 flex justify-between">
                                    <span class="font-semibold text-black dark:text-white">Totaal</span>
                                    <span class="font-semibold text-black dark:text-white text-lg" id="total">€0,00</span>
                                </div>
                            </div>

                            <div class="mt-6 p-3 bg-yellow-50 border border-yellow-200 rounded text-xs text-yellow-900">
                                <strong>💡 Tip:</strong> Selecteer "Maak aan en verstuur" om direct naar de verzendpagina te gaan, of kies "Opslaan als concept" om later te verzenden.
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

<x-layouts.app :title="'Factuur aanmaken'">
  <style>
    /* Light-only page background override for consistency */
    html:not(.dark) body { background-color: #f3f4f6 !important; }
  </style>
  <main class="p-6 min-h-screen max-w-4xl mx-auto">
    <header class="mb-6">
      <div class="text-center mb-4">
        <h1 class="text-3xl font-semibold text-black dark:text-white">Factuur aanmaken</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">Maak een nieuwe factuur aan voor een klant</p>
      </div>
      <a href="{{ route('facturen.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
        Terug naar overzicht
      </a>
    </header>

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
      <div class="p-6">
        <form id="factuurForm" action="{{ route('facturen.store') }}" method="POST" class="space-y-6">
          @csrf

          <div>
            <label class="font-semibold text-xl text-gray-800 dark:text-gray-200">Kies klant of zoek...</label>
            @livewire('customer-search', ['name' => 'name_company_id', 'required' => true])
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="invoice_date" class="font-semibold text-gray-800 dark:text-gray-200">Factuurdatum</label>
              <input type="date" id="invoice_date" name="invoice_date" value="{{ date('Y-m-d') }}" required class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md" />
            </div>

            <div>
              <label for="payment_terms_days" class="font-semibold text-gray-800 dark:text-gray-200">Betalingstermijn</label>
              <select id="payment_terms_days" name="payment_terms_days" required class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md">
                <option value="30">30 dagen</option>
                <option value="14">14 dagen</option>
                <option value="7">7 dagen</option>
                <option value="0">Direct betaalbaar</option>
              </select>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="payment_method" class="font-semibold text-gray-800 dark:text-gray-200">Betaalwijze</label>
              <select id="payment_method" name="payment_method" required class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md">
                <option value="bank_transfer">Bankoverschrijving</option>
                <option value="ideal">iDEAL</option>
                <option value="creditcard">Creditcard</option>
                <option value="cash">Contant</option>
              </select>
            </div>

            <div>
              <label for="reference" class="font-semibold text-gray-800 dark:text-gray-200">Referentie (optioneel)</label>
              <input type="text" id="reference" name="reference" placeholder="Contract-nr, Offerte-nr" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md" />
            </div>
          </div>

          <div>
            <label class="font-semibold text-gray-800 dark:text-gray-200">Producten</label>
            @livewire('product-multi-select', ['name' => 'products'])
          </div>

          <div>
            <label for="description" class="font-semibold text-gray-800 dark:text-gray-200">Omschrijving</label>
            <textarea id="description" name="description" rows="3" placeholder="Korte omschrijving van de factuur (verschijnt op de factuur)" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md">{{ old('description') }}</textarea>
          </div>

          <div>
            <label for="notes" class="font-semibold text-gray-800 dark:text-gray-200">Interne notities (optioneel)</label>
            <textarea id="notes" name="notes" rows="3" placeholder="Notities voor intern gebruik, niet zichtbaar voor klant" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md">{{ old('notes') }}</textarea>
          </div>
          <div class="flex justify-between items-center pt-4">
            <button type="submit" name="status" value="concept" class="inline-flex items-center gap-2 rounded-md bg-gray-100 border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-200 transition-colors">
              💾 Opslaan als concept
            </button>
            <button type="submit" name="status" value="verzonden" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
              <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"/></svg>
              Maak aan en verstuur
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
      Beheer facturen via financiën — wees zorgvuldig bij het invullen van factuurgegevens
    </div>
  </main>

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
</x-layouts.app>

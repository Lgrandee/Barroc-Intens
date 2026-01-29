<x-layouts.app :title="'Factuur bewerken'">
  <style>
    /* Light-only page background override for consistency */
  </style>
  <main class="p-6 min-h-screen max-w-4xl mx-auto">
    <header class="mb-6">
      <div class="text-center mb-4">
        <h1 class="text-3xl font-semibold text-black dark:text-white">Factuur bewerken</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">Wijzig de factuurgegevens</p>
      </div>
      <a href="{{ route('facturen.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
        Terug naar overzicht
      </a>
    </header>

    @if(session('success'))
      <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
        {{ session('success') }}
      </div>
    @endif

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
      <div class="p-6">
        <form action="{{ route('facturen.update', $factuur->id) }}" method="POST" id="factuurForm" class="space-y-6">
          @csrf
          @method('PUT')

          <!-- Factuur Info -->
          <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
              <div>
                <div class="text-xs text-yellow-700 mb-1">Klant</div>
                <span class="text-black font-medium">{{ $factuur->customer->name_company ?? 'Onbekend' }}</span>
              </div>
              <div>
                <div class="text-xs text-yellow-700 mb-1">Factuurnr</div>
                <span class="text-black font-medium">{{ $factuur->factuurnr }}</span>
              </div>
              <div>
                <div class="text-xs text-yellow-700 mb-1">Factuurdatum</div>
                <span class="text-yellow-900">{{ \Carbon\Carbon::parse($factuur->invoice_date)->format('d-m-Y') }}</span>
              </div>
              <div>
                <div class="text-xs text-yellow-700 mb-1">Status</div>
                @switch($factuur->status)
                  @case('betaald')
                    <span class="text-green-700 font-medium">✅ Betaald</span>
                    @break
                  @case('verzonden')
                    <span class="text-blue-700 font-medium">📧 Verzonden</span>
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
            <div class="mt-3 pt-3 border-t border-yellow-300 text-xs space-y-1">
              @if($factuur->offerte)
                <div>
                  <span class="text-yellow-800">Gekoppeld aan offerte:</span>
                  <a href="{{ route('offertes.show', $factuur->offerte->id) }}" class="text-blue-600 hover:text-blue-700 font-medium underline">
                    OFF-{{ date('Y', strtotime($factuur->offerte->created_at)) }}-{{ str_pad($factuur->offerte->id, 3, '0', STR_PAD_LEFT) }}
                  </a>
                </div>
              @endif
              @if($factuur->reference)
                <div>
                  <span class="text-yellow-800">Referentie:</span>
                  <span class="text-yellow-900 font-medium">{{ $factuur->reference }}</span>
                </div>
              @endif
            </div>
          </div>

          <div>
            <label for="customer_display" class="font-semibold text-gray-800 dark:text-gray-200">Klant (niet aanpasbaar)</label>
            <input type="text" id="customer_display" value="{{ $factuur->customer->name_company ?? '' }}" disabled class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 rounded bg-gray-50 dark:bg-zinc-700 text-gray-700 dark:text-gray-300" />
            <input type="hidden" name="name_company_id" value="{{ $factuur->name_company_id }}">
          </div>

          <div>
            <label class="font-semibold text-gray-800 dark:text-gray-200">Producten</label>
            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-2 grid grid-cols-12 gap-2">
              <div class="col-span-5">Omschrijving</div>
              <div class="col-span-2">Aantal</div>
              <div class="col-span-2">Prijs</div>
              <div class="col-span-2">Actie</div>
            </div>
            @livewire('product-multi-select', [
              'name' => 'products',
              'initialSelected' => $factuur->products->pluck('id')->toArray(),
              'initialQuantities' => $factuur->products->mapWithKeys(function($product) {
                return [$product->id => $product->pivot->quantity];
              })->toArray()
            ])
          </div>

          <div>
            <label for="description" class="font-semibold text-gray-800 dark:text-gray-200">Omschrijving (zichtbaar op factuur)</label>
            <textarea id="description" name="description" rows="3" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md">{{ $factuur->description ?? '' }}</textarea>
          </div>

          <div>
            <label for="notes" class="font-semibold text-gray-800 dark:text-gray-200">Interne notities (niet zichtbaar voor klant)</label>
            <textarea id="notes" name="notes" rows="3" placeholder="Voeg interne notities toe..." class="mt-1 block w-full p-2 border border-yellow-300 dark:border-yellow-600 rounded bg-yellow-50 dark:bg-yellow-900/20 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">{{ $factuur->notes ?? '' }}</textarea>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">💡 Deze notities zijn alleen voor intern gebruik</p>
          </div>

          <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
            <h3 class="font-semibold text-yellow-900 mb-3">Totaaloverzicht</h3>
            <div class="space-y-3">
              <div class="flex justify-between text-sm">
                <span class="text-yellow-800">Subtotaal</span>
                <span class="font-medium text-black" id="subtotal">€{{ number_format($factuur->products->sum(function($p) { return $p->price * $p->pivot->quantity; }), 2, ',', '.') }}</span>
              </div>
              <div class="flex justify-between text-sm">
                <span class="text-yellow-800">BTW (21%)</span>
                <span class="font-medium text-black" id="btw">€{{ number_format($factuur->products->sum(function($p) { return $p->price * $p->pivot->quantity; }) * 0.21, 2, ',', '.') }}</span>
              </div>
              <div class="border-t border-yellow-300 pt-3 flex justify-between">
                <span class="font-semibold text-black">Totaal</span>
                <span class="font-semibold text-black text-lg" id="total">€{{ number_format($factuur->total_amount * 1.21, 2, ',', '.') }}</span>
              </div>
            </div>
          </div>

          <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-600 rounded-md p-4">
            <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-3">Wijzigingsgeschiedenis</h3>
            <div class="space-y-2 text-sm">
              <div>
                <div class="text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($factuur->updated_at)->format('d M Y H:i') }}</div>
                <div class="text-gray-800 dark:text-gray-200">Laatst aangepast door {{ Auth::user()->name ?? 'Gebruiker' }}</div>
              </div>
              <div>
                <div class="text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($factuur->created_at)->format('d M Y H:i') }}</div>
                <div class="text-gray-800 dark:text-gray-200">Concept aangemaakt</div>
              </div>
            </div>
          </div>

          <div class="flex justify-between items-center pt-4">
            <a href="{{ route('facturen.index') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline">
              Annuleren
            </a>
            <div class="flex gap-3">
              <a href="{{ route('facturen.send', $factuur->id) }}" class="inline-flex items-center gap-2 rounded-md bg-blue-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-600 transition-colors">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" /><path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" /></svg>
                Verstuur factuur
              </a>
              <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"/></svg>
                Opslaan wijzigingen
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
      Bewerk facturen zorgvuldig — wijzigingen worden direct opgeslagen in de database
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

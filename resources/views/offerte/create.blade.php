<x-layouts.app :title="'Offerte Aanmaken'">
  <style>
    /* Light-only page background override */
    html:not(.dark) body { background-color: #f3f4f6 !important; }
  </style>

  <div class="min-h-screen">
    <div class="bg-white dark:bg-zinc-800 border-b border-gray-200 dark:border-zinc-700 px-6 py-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-semibold text-black dark:text-white">Offerte aanmaken</h1>
          <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Maak een nieuwe offerte aan</p>
        </div>
        <a href="{{ route('offertes.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
          <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
          Terug naar overzicht
        </a>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">
      <form action="{{ route('offertes.store') }}" method="POST" id="offerte-form">
        @csrf
        <input type="hidden" name="status" id="status-input" value="pending">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl p-6 border border-gray-200 dark:border-zinc-700">
              <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-black dark:text-white">Nieuwe offerte</h2>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Concept</span>
              </div>

              <div class="space-y-5">
                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Klant of bedrijf</label>
                  @livewire('customer-search', ['initialId' => old('name_company_id')])
                  @error('name_company_id')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Producten</label>
                  @livewire('product-multi-select', ['initialSelected' => old('product_ids', [])])
                  @error('product_ids')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label for="valid_until" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Geldig tot</label>
                    <input
                      type="date"
                      id="valid_until"
                      name="valid_until"
                      value="{{ old('valid_until', now()->addDays(30)->format('Y-m-d')) }}"
                      class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                    />
                    @error('valid_until')
                      <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                  </div>

                  <div>
                    <label for="delivery_time_weeks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Levertijd</label>
                    <select
                      id="delivery_time_weeks"
                      name="delivery_time_weeks"
                      class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                    >
                      <option value="2" {{ old('delivery_time_weeks') == '2' ? 'selected' : '' }}>2-3 weken</option>
                      <option value="4" {{ old('delivery_time_weeks') == '4' ? 'selected' : '' }}>4-6 weken</option>
                      <option value="8" {{ old('delivery_time_weeks') == '8' ? 'selected' : '' }}>8-12 weken</option>
                    </select>
                    @error('delivery_time_weeks')
                      <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label for="payment_terms_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Betalingsvoorwaarden</label>
                    <select
                      id="payment_terms_days"
                      name="payment_terms_days"
                      class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                    >
                      <option value="14" {{ old('payment_terms_days') == '14' ? 'selected' : '' }}>14 dagen</option>
                      <option value="30" {{ old('payment_terms_days') == '30' ? 'selected' : '' }}>30 dagen</option>
                      <option value="60" {{ old('payment_terms_days') == '60' ? 'selected' : '' }}>60 dagen</option>
                    </select>
                    @error('payment_terms_days')
                      <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <div class="inline-flex items-center gap-2 px-3 py-2 rounded-md bg-yellow-50 dark:bg-yellow-100/10 border border-yellow-200 dark:border-yellow-300/30">
                      <span class="inline-flex h-2 w-2 rounded-full bg-yellow-500"></span>
                      <span class="text-sm font-semibold text-yellow-900 dark:text-yellow-200">Pending bij aanmaken</span>
                    </div>
                  </div>
                </div>

                <div>
                  <label for="custom_terms" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Aanvullende voorwaarden</label>
                  <textarea
                    id="custom_terms"
                    name="custom_terms"
                    rows="4"
                    placeholder="Voeg hier eventuele aanvullende voorwaarden of opmerkingen toe..."
                    class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                  >{{ old('custom_terms') }}</textarea>
                  @error('custom_terms')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200 dark:border-zinc-700 mt-2">
                  <button type="button" onclick="saveDraft()" class="px-6 py-2 border border-gray-300 dark:border-zinc-600 rounded text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700 font-medium flex items-center gap-2">
                    <span>💾</span>
                    Opslaan als concept
                  </button>
                  <button type="submit" class="px-6 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-300 font-semibold shadow flex items-center gap-2">
                    <span class="inline-block h-2 w-2 rounded-full bg-black"></span>
                    Offerte aanmaken
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl p-6 sticky top-6 border border-gray-200 dark:border-zinc-700">
              <h2 class="text-lg font-semibold text-black dark:text-white mb-4">Status & details</h2>
              <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                <div class="flex items-center justify-between">
                  <span>Concept status</span>
                  <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-zinc-700 text-gray-700 dark:text-gray-200">Concept</span>
                </div>
                <div class="flex items-center justify-between">
                  <span>Planning</span>
                  <span class="text-gray-900 dark:text-white font-semibold">Pending → Verzenden</span>
                </div>
                <div class="flex items-center justify-between">
                  <span>Laatste wijziging</span>
                  <span class="text-gray-900 dark:text-white font-semibold">{{ now()->format('d M Y H:i') }}</span>
                </div>
                <div class="pt-2 text-xs text-gray-500 dark:text-gray-400">
                  Wijzig de geldigheid, levering en voorwaarden hiernaast. Productprijzen en BTW worden direct bepaald bij de productselectie.
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    function saveDraft() {
      document.getElementById('status-input').value = 'draft';
      document.getElementById('offerte-form').submit();
    }
  </script>
</x-layouts.app>

<x-layouts.app :title="'Offerte aanmaken'">
  <style>
    /* Light-only page background override for consistency */
  </style>

  <main class="p-6 min-h-screen max-w-4xl mx-auto">
    <header class="mb-6">
      <div class="text-center mb-4">
        <h1 class="text-3xl font-semibold text-black dark:text-white">Offerte aanmaken</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">Maak een nieuwe offerte aan voor een klant</p>
      </div>
      <a href="{{ route('offertes.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
        Terug naar overzicht
      </a>
    </header>

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
      <div class="p-6">
        <form action="{{ route('offertes.store') }}" method="POST" id="offerte-form" class="space-y-6">
          @csrf
          <input type="hidden" name="status" id="status-input" value="pending">

          <div>
            @livewire('customer-search', ['initialId' => old('name_company_id')])
            @error('name_company_id')
              <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div>
            @livewire('product-multi-select', ['initialSelected' => old('product_ids', [])])
            @error('product_ids')
              <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="valid_until" class="font-semibold text-gray-800 dark:text-gray-200">Geldig tot</label>
              <input type="date" id="valid_until" name="valid_until" value="{{ old('valid_until', now()->addDays(30)->format('Y-m-d')) }}" required class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md" />
              @error('valid_until')
                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div>
              <label for="delivery_time_weeks" class="font-semibold text-gray-800 dark:text-gray-200">Levertijd</label>
              <select id="delivery_time_weeks" name="delivery_time_weeks" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md">
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
              <label for="payment_terms_days" class="font-semibold text-gray-800 dark:text-gray-200">Betalingsvoorwaarden</label>
              <select id="payment_terms_days" name="payment_terms_days" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md">
                <option value="14" {{ old('payment_terms_days') == '14' ? 'selected' : '' }}>14 dagen</option>
                <option value="30" {{ old('payment_terms_days') == '30' ? 'selected' : '' }}>30 dagen</option>
                <option value="60" {{ old('payment_terms_days') == '60' ? 'selected' : '' }}>60 dagen</option>
              </select>
              @error('payment_terms_days')
                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div>
              <label class="font-semibold text-gray-800 dark:text-gray-200">Initiële status</label>
              <div class="mt-1 flex items-center gap-2 px-3 py-2 rounded-md bg-yellow-50 border border-yellow-200 w-fit">
                <span class="inline-flex h-2 w-2 rounded-full bg-yellow-500"></span>
                <span class="text-sm font-semibold text-yellow-900">In behandeling</span>
              </div>
            </div>
          </div>

          <div>
            <label for="custom_terms" class="font-semibold text-gray-800 dark:text-gray-200">Aanvullende voorwaarden (optioneel)</label>
            <textarea id="custom_terms" name="custom_terms" rows="4" placeholder="Voeg hier eventuele aanvullende voorwaarden of opmerkingen toe..." class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md">{{ old('custom_terms') }}</textarea>
            @error('custom_terms')
              <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
            <h3 class="font-semibold text-yellow-900 mb-2">Offertestatus</h3>
            <p class="text-sm text-yellow-800">Wanneer je deze offerte aanmaakt, krijgt deze de status <strong>"In behandeling"</strong>. Je kunt deze later wijzigen naar "Concept" of "Geaccepteerd" via de bewerkingspagina.</p>
          </div>

          <div class="flex justify-between items-center pt-4">
            <a href="{{ route('offertes.index') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline">
              Annuleren
            </a>
            <div class="flex gap-3">
              <button type="button" onclick="saveDraft()" class="inline-flex items-center gap-2 rounded-md bg-gray-100 border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-200 transition-colors">
                💾 Opslaan als concept
              </button>
              <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"/></svg>
                Offerte aanmaken
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
      Maak offertes zorgvuldig aan — wijzig de details later in de bewerkingspagina
    </div>
  </main>

  <script>
    function saveDraft() {
      document.getElementById('status-input').value = 'draft';
      document.getElementById('offerte-form').submit();
    }
  </script>
</x-layouts.app>

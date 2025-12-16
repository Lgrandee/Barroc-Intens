<x-layouts.app :title="'Offerte Aanmaken'">
  <style>
    /* Light-only page background override */
    html:not(.dark) body { background-color: #f3f4f6 !important; }
  </style>
  <main class="p-6 max-w-3xl mx-auto">
    <header class="mb-6 flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl font-semibold text-black dark:text-white">Offerte Aanmaken</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">Maak een nieuwe offerte aan voor een klant</p>
      </div>
      <a href="{{ route('offertes.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-3 py-1.5 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
        <span class="inline-block h-2 w-2 rounded-full bg-black"></span>
        Terug naar overzicht
      </a>
    </header>

    <form action="{{ route('offertes.store') }}" method="POST" class="space-y-6" id="offerte-form">
      @csrf
      <input type="hidden" name="status" id="status-input" value="pending">

      <!-- Klantgegevens Section -->
      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
        <div class="p-5 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
          <h2 class="text-lg font-semibold text-black dark:text-white flex items-center gap-2">
            <span>👤</span> Klantgegevens
          </h2>
        </div>
        <div class="p-5 space-y-4">
          <div>
            @livewire('customer-search', ['initialId' => old('name_company_id')])
            @error('name_company_id')
              <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <!-- Producten Section -->
      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
        <div class="p-5 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
          <h2 class="text-lg font-semibold text-black dark:text-white flex items-center gap-2">
            <span>📦</span> Producten
          </h2>
        </div>
        <div class="p-5">
          @livewire('product-multi-select', ['initialSelected' => old('product_ids', [])])
          @error('product_ids')
            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Voorwaarden & Details Section -->
      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
        <div class="p-5 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
          <h2 class="text-lg font-semibold text-black dark:text-white flex items-center gap-2">
            <span>📋</span> Voorwaarden & Details
          </h2>
        </div>
        <div class="p-5 space-y-4">
          <div>
            <label for="valid_until" class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide mb-2">
              Offerte geldigheid
            </label>
            <input
              type="date"
              id="valid_until"
              name="valid_until"
              value="{{ old('valid_until', now()->addDays(30)->format('Y-m-d')) }}"
              class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-colors"
            />
            @error('valid_until')
              <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div>
            <label for="delivery_time_weeks" class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide mb-2">
              Levertijd
            </label>
            <select
              id="delivery_time_weeks"
              name="delivery_time_weeks"
              class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-colors"
            >
              <option value="2" {{ old('delivery_time_weeks') == '2' ? 'selected' : '' }}>2-3 weken</option>
              <option value="4" {{ old('delivery_time_weeks') == '4' ? 'selected' : '' }}>4-6 weken</option>
              <option value="8" {{ old('delivery_time_weeks') == '8' ? 'selected' : '' }}>8-12 weken</option>
            </select>
            @error('delivery_time_weeks')
              <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div>
            <label for="payment_terms_days" class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide mb-2">
              Betalingsvoorwaarden
            </label>
            <select
              id="payment_terms_days"
              name="payment_terms_days"
              class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-colors"
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
            <label for="custom_terms" class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide mb-2">
              Aanvullende voorwaarden
            </label>
            <textarea
              id="custom_terms"
              name="custom_terms"
              rows="4"
              placeholder="Voeg hier eventuele aanvullende voorwaarden of opmerkingen toe..."
              class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-colors"
            >{{ old('custom_terms') }}</textarea>
            @error('custom_terms')
              <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-zinc-700">
        <p class="text-xs text-gray-500 dark:text-gray-400">Laatst gewijzigd: {{ now()->format('d M Y H:i') }}</p>
        <div class="flex gap-3">
          <button type="button" onclick="saveDraft()" class="inline-flex items-center gap-2 rounded-md border border-gray-300 dark:border-zinc-600 px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-zinc-700 shadow hover:bg-gray-50 dark:hover:bg-zinc-600 transition-colors">
            <span>📝</span>
            Opslaan als concept
          </button>
          <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
            <span class="inline-block h-2 w-2 rounded-full bg-black"></span>
            Offerte aanmaken
          </button>
        </div>
      </div>
    </form>

    <script>
      function saveDraft() {
        document.getElementById('status-input').value = 'draft';
        document.getElementById('offerte-form').submit();
      }
    </script>
  </main>
</x-layouts.app>

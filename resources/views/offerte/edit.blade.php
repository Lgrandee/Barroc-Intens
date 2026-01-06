<x-layouts.app :title="'Offerte Bewerken'">
  <style>
    /* Light-only page background override */
    html:not(.dark) body { background-color: #f3f4f6 !important; }
  </style>
  <main class="p-6 max-w-4xl mx-auto">
    <header class="mb-6 flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl font-semibold text-black dark:text-white">Offerte Bewerken</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">Bewerk offerte OFF-{{ date('Y', strtotime($offerte->created_at)) }}-{{ str_pad($offerte->id, 3, '0', STR_PAD_LEFT) }}</p>
      </div>
      <a href="{{ route('offertes.show', $offerte->id) }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-3 py-1.5 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
        <span class="inline-block h-2 w-2 rounded-full bg-black"></span>
        Goedkeuren
      </a>
    </header>

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
      <div class="p-6">
        <form id="offerte-form" action="{{ route('offertes.update', $offerte->id) }}" method="POST" class="space-y-6">
          @csrf
          @method('PUT')

          @livewire('customer-search', ['initialId' => $offerte->name_company_id])

          <div>
            @livewire('product-multi-select', [
              'initialSelected' => $offerte->products->pluck('id')->toArray(),
              'initialQuantities' => $offerte->products->pluck('pivot.quantity', 'id')->toArray()
            ])
            @error('product_ids')
              <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div>
            <label for="status" class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide mb-2">Status</label>
            <select id="status" name="status" required class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-colors">
              <option value="draft" {{ $offerte->status == 'draft' ? 'selected' : '' }}>Concept (draft)</option>
              <option value="pending" {{ $offerte->status == 'pending' ? 'selected' : '' }}>In Behandeling (pending)</option>
              <option value="accepted" {{ $offerte->status == 'accepted' ? 'selected' : '' }}>Geaccepteerd (accepted)</option>
              <option value="rejected" {{ $offerte->status == 'rejected' ? 'selected' : '' }}>Afgewezen (rejected)</option>
            </select>
            @error('status')
              <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="border-t border-gray-200 dark:border-zinc-700 pt-6 flex justify-between items-center">
            <a href="{{ route('offertes.show', $offerte->id) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-300 text-sm font-medium transition-colors">
              Annuleren
            </a>
            <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
              <span class="inline-block h-2 w-2 rounded-full bg-black"></span>
              Opslaan wijzigingen
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</x-layouts.app>

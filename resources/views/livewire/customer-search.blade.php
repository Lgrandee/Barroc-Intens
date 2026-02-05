<div>
  <label for="name_company_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Klant <span class="text-red-500">*</span></label>

  @if($selectedId)
    {{-- Selected customer display --}}
    <div class="mt-1 flex items-center gap-2 p-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-gray-50 dark:bg-zinc-900">
      <div class="flex-1">
        <span class="font-medium text-gray-900 dark:text-white">{{ $selectedName }}</span>
      </div>
      <button
        type="button"
        wire:click="clearSelection"
        class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 px-2"
      >✕</button>
    </div>
    <input type="hidden" name="name_company_id" value="{{ $selectedId }}" />
  @else
    {{-- Search input --}}
    <div class="relative mt-1">
      <input
        type="text"
        wire:model.live.debounce.100ms="search"
        placeholder="Zoek op bedrijfsnaam, contactpersoon of plaats..."
        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent"
      />

      @if($search && $results->isEmpty() && $showDropdown)
        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Geen klanten gevonden</div>
      @endif

      @if($showDropdown && $results->isNotEmpty())
        <div class="absolute z-20 mt-1 w-full bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
          @foreach($results as $customer)
            <button
              type="button"
              wire:click="selectCustomer({{ $customer->id }})"
              class="w-full px-3 py-2 text-left bg-white dark:bg-zinc-800 hover:bg-blue-50 dark:hover:bg-zinc-700 border-b border-gray-200 dark:border-zinc-700 last:border-b-0 transition"
            >
              <div class="font-medium text-sm text-gray-900 dark:text-white">{{ $customer->name_company }}</div>
              <div class="text-xs text-gray-500 dark:text-gray-400">
                {{ $customer->contact_person ? $customer->contact_person . ' • ' : '' }}{{ $customer->city ?? '' }}
              </div>
            </button>
          @endforeach
        </div>
      @endif
    </div>
  @endif

  @error('name_company_id')
    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
  @enderror
</div>

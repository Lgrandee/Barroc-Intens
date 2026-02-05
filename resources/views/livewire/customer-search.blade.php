<div>
  <label for="name_company_id" class="font-semibold text-gray-800 dark:text-gray-200">Zoek klant of bedrijf</label>

  @if($selectedId)
    {{-- Selected customer display --}}
    <div class="mt-1 flex items-center gap-2 p-2 border border-gray-300 rounded-md bg-gray-50">
      <div class="flex-1">
        <span class="font-medium">{{ $selectedName }}</span>
      </div>
      <button
        type="button"
        wire:click="clearSelection"
        class="text-sm text-gray-500 hover:text-gray-700 px-2"
      >✕</button>
    </div>
    <input type="hidden" name="name_company_id" value="{{ $selectedId }}" />
  @else
    {{-- Search input --}}
    <div class="relative mt-1">
      <input
        type="text"
        wire:model.live.debounce.100ms="search"
        placeholder="Zoek op bedrijfsnaam, contactpersoon of plaats"
        class="w-full p-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-gray-900"
      />

      @if($search && $results->isEmpty() && $showDropdown)
        <div class="mt-1 text-xs text-gray-500">Geen klanten gevonden</div>
      @endif

      @if($showDropdown && $results->isNotEmpty())
        <div class="absolute z-20 mt-1 w-full bg-gray-200 border-2 border-gray-400 rounded-md shadow-lg max-h-60 overflow-y-auto">
          @foreach($results as $customer)
            <button
              type="button"
              wire:click="selectCustomer({{ $customer->id }})"
              class="w-full px-3 py-2 text-left bg-white hover:bg-blue-50 border-b border-gray-200 last:border-b-0"
            >
              <div class="font-medium text-sm">{{ $customer->name_company }}</div>
              <div class="text-xs text-gray-500">
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

<div>
  <div class="space-y-2">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Producten <span class="text-red-500">*</span></label>

    {{-- Search input --}}
    <div class="relative">
      <input
        type="text"
        wire:model.live.debounce.100ms="search"
        placeholder="Zoek op productnaam..."
        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent"
      />

      @if($search && $results->isEmpty() && $showDropdown)
        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Geen producten gevonden</div>
      @endif

      @if($showDropdown && $results->isNotEmpty())
        <div class="absolute z-20 mt-1 w-full bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
          @foreach($results as $res)
            <button
              type="button"
              wire:click.prevent="toggle({{ $res->id }})"
              class="w-full px-4 py-3 flex justify-between items-center bg-white dark:bg-zinc-800 hover:bg-blue-50 dark:hover:bg-zinc-700 border-b border-gray-200 dark:border-zinc-700 last:border-b-0 text-left transition-colors"
            >
              <div class="flex-1">
                <div class="font-medium text-sm text-gray-900 dark:text-white">{{ $res->product_name }}</div>
                <div class="flex gap-3 mt-1">
                  <span class="text-xs text-gray-600 dark:text-gray-400">€{{ number_format($res->price, 2, ',', '.') }} / jaar</span>
                  <span class="text-xs {{ $res->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                    Voorraad: {{ $res->stock }}
                    Voorraad: {{ $res->stock }}
                  </span>
                </div>
              </div>
              <div class="ml-4 px-3 py-1 bg-yellow-400 text-black rounded-lg text-xs font-semibold">
                + Toevoegen
              </div>
            </button>
          @endforeach
        </div>
      @endif
    </div>

    {{-- Selected products list (shopping cart style) --}}
    @if(!empty($selected) && count($selected) > 0)
      <div class="border border-gray-300 dark:border-zinc-600 rounded-lg overflow-hidden mt-4">
        <div class="bg-gray-100 dark:bg-zinc-900 px-4 py-2 border-b border-gray-300 dark:border-zinc-600">
          <div class="flex justify-between items-center">
            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">Geselecteerde Producten</span>
            <span class="text-xs text-gray-600 dark:text-gray-400">{{ count($selected) }} item(s)</span>
          </div>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-zinc-700 bg-white dark:bg-zinc-800">
          @foreach($selected as $productId)
            @php
              $product = \App\Models\Product::find($productId);
            @endphp
            @if($product)
              <div class="px-4 py-3 hover:bg-blue-50 dark:hover:bg-zinc-700 flex justify-between items-center bg-white dark:bg-zinc-800">
                <div class="flex-1">
                  <div class="font-medium text-sm text-gray-900 dark:text-white">{{ $product->product_name }}</div>
                  <div class="flex gap-3 mt-0.5">
                    <span class="text-xs text-gray-500 dark:text-gray-400">€{{ number_format($product->price, 2, ',', '.') }} / jaar</span>
                    <span class="text-xs {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                      Voorraad: {{ $product->stock }}
                    </span>
                  </div>
                </div>
                <div class="flex items-center gap-2">
                  <button type="button" wire:click="decrement({{ $product->id }})" class="px-2 py-1 bg-gray-200 dark:bg-zinc-700 rounded text-sm font-bold text-gray-800 dark:text-white">−</button>
                  <input type="number" min="1" wire:model.live="quantities.{{ $product->id }}" class="w-12 text-center border border-gray-300 dark:border-zinc-600 rounded text-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white" name="product_quantities[{{ $product->id }}]" value="{{ $quantities[$product->id] ?? 1 }}" />
                  <button type="button" wire:click="increment({{ $product->id }})" class="px-2 py-1 bg-gray-200 dark:bg-zinc-700 rounded text-sm font-bold text-gray-800 dark:text-white">+</button>
                  <button
                    type="button"
                    wire:click="remove({{ $product->id }})"
                    wire:confirm="Weet je zeker dat je dit product wilt verwijderen?"
                    class="ml-2 text-red-600 hover:text-red-800 text-sm font-medium"
                  >Verwijderen</button>
                </div>
              </div>
              <input type="hidden" name="product_ids[]" value="{{ $product->id }}" />
            @endif
          @endforeach
        </div>
        <div class="bg-gray-100 dark:bg-zinc-900 px-4 py-3 border-t border-gray-300 dark:border-zinc-600 space-y-2">
          @php
            $subtotal = collect($selected)->sum(function($id) {
              $product = \App\Models\Product::find($id);
              $qty = $this->quantities[$id] ?? 1;
              return ($product?->price ?? 0) * $qty;
            });
            $vat = $subtotal * 0.21;
            $total = $subtotal + $vat;
          @endphp
          <div class="flex justify-between items-center text-sm">
            <span class="text-gray-600 dark:text-gray-400">Subtotaal (per jaar)</span>
            <span class="text-gray-900 dark:text-white">€{{ number_format($subtotal, 2, ',', '.') }}</span>
          </div>
          <div class="flex justify-between items-center text-sm">
            <span class="text-gray-600 dark:text-gray-400">Btw (21%)</span>
            <span class="text-gray-900 dark:text-white">€{{ number_format($vat, 2, ',', '.') }}</span>
          </div>
          <div class="flex justify-between items-center pt-2 border-t border-gray-400 dark:border-zinc-700">
            <span class="text-sm font-semibold text-gray-900 dark:text-white">Totaal incl. Btw (per jaar)</span>
            <span class="text-sm font-semibold text-gray-900 dark:text-white">€{{ number_format($total, 2, ',', '.') }}</span>
          </div>
        </div>
      </div>
    @endif
  </div>
</div>

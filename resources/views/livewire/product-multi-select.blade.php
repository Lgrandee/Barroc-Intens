<div>
  <div class="space-y-2">
    <label class="font-semibold text-gray-800 dark:text-gray-200">Selecteer producten</label>

    {{-- Search input --}}
    <div class="relative">
      <input
        type="text"
        wire:model.live.debounce.100ms="search"
        placeholder="Search by product name"
        class="w-full p-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-indigo-500"
      />

      @if($search && $results->isEmpty() && $showDropdown)
        <div class="mt-1 text-xs text-gray-500">No products found</div>
      @endif

      @if($showDropdown && $results->isNotEmpty())
        <div class="absolute z-20 mt-1 w-full bg-gray-200 border-2 border-gray-400 rounded-md shadow-lg max-h-60 overflow-y-auto">
          @foreach($results as $res)
            <button
              type="button"
              wire:click.prevent="toggle({{ $res->id }})"
              class="w-full px-4 py-3 flex justify-between items-center bg-white hover:bg-blue-50 border-b border-gray-200 last:border-b-0 text-left transition-colors"
            >
              <div class="flex-1">
                <div class="font-medium text-sm text-gray-900">{{ $res->product_name }}</div>
                <div class="flex gap-3 mt-1">
                  <span class="text-xs text-gray-600">€{{ number_format($res->price, 2, ',', '.') }} / year</span>
                  <span class="text-xs {{ $res->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                    Stock: {{ $res->stock }}
                  </span>
                </div>
              </div>
              <div class="ml-4 px-3 py-1 bg-green-600 text-white rounded-md text-xs font-semibold">
                + ADD
              </div>
            </button>
          @endforeach
        </div>
      @endif
    </div>

    {{-- Selected products list (shopping cart style) --}}
    @if(!empty($selected) && count($selected) > 0)
      <div class="border border-gray-300 rounded-md overflow-hidden mt-4">
        <div class="bg-gray-100 px-4 py-2 border-b border-gray-300">
          <div class="flex justify-between items-center">
            <span class="text-sm font-medium text-gray-800">Selected products</span>
            <span class="text-xs text-gray-600">{{ count($selected) }} item(s)</span>
          </div>
        </div>
        <div class="divide-y divide-gray-200 bg-white">
          @foreach($selected as $productId)
            @php
              $product = \App\Models\Product::find($productId);
            @endphp
            @if($product)
              <div class="px-4 py-3 hover:bg-blue-50 flex justify-between items-center bg-white">
                <div class="flex-1">
                  <div class="font-medium text-sm">{{ $product->product_name }}</div>
                  <div class="flex gap-3 mt-0.5">
                    <span class="text-xs text-gray-500">€{{ number_format($product->price, 2, ',', '.') }} / year</span>
                    <span class="text-xs {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                      Stock: {{ $product->stock }}
                    </span>
                  </div>
                </div>
                <div class="flex items-center gap-2">
                  <button type="button" wire:click="decrement({{ $product->id }})" class="px-2 py-1 bg-gray-200 rounded text-sm font-bold">-</button>
                  <input type="number" min="1" wire:model.live="quantities.{{ $product->id }}" class="w-12 text-center border border-gray-300 rounded text-sm" name="product_quantities[{{ $product->id }}]" value="{{ $quantities[$product->id] ?? 1 }}" />
                  <button type="button" wire:click="increment({{ $product->id }})" class="px-2 py-1 bg-gray-200 rounded text-sm font-bold">+</button>
                  <button
                    type="button"
                    wire:click="remove({{ $product->id }})"
                    wire:confirm="Are you sure you want to remove this product?"
                    class="ml-2 text-red-600 hover:text-red-800 text-sm font-medium"
                  >Remove</button>
                </div>
              </div>
              <input type="hidden" name="product_ids[]" value="{{ $product->id }}" />
            @endif
          @endforeach
        </div>
        <div class="bg-gray-100 px-4 py-3 border-t border-gray-300 space-y-2">
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
            <span class="text-gray-600">Subtotal (per year)</span>
            <span class="text-gray-900">€{{ number_format($subtotal, 2, ',', '.') }}</span>
          </div>
          <div class="flex justify-between items-center text-sm">
            <span class="text-gray-600">BTW (21%)</span>
            <span class="text-gray-900">€{{ number_format($vat, 2, ',', '.') }}</span>
          </div>
          <div class="flex justify-between items-center pt-2 border-t border-gray-400">
            <span class="text-sm font-semibold text-gray-900">Total incl. BTW (per year)</span>
            <span class="text-sm font-semibold text-gray-900">€{{ number_format($total, 2, ',', '.') }}</span>
          </div>
        </div>
      </div>
    @endif
  </div>
</div>

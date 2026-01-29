<x-layouts.app title="Productvoorraad">
    <div class="max-w-6xl mx-auto p-6 bg-gray-100 min-h-screen">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Productvoorraad</h1>
                <p class="text-gray-500 text-sm">Overzicht van alle producten en voorraadniveaus</p>
            </div>
            <div>
                <a href="{{ route('products.order') }}" class="inline-flex items-center px-4 py-2 bg-yellow-400 text-black rounded-md text-sm font-medium hover:bg-yellow-300 transition shadow-sm">
                    + Nieuwe Bestelling
                </a>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
            <div class="grid grid-cols-5 font-semibold text-sm bg-gray-50 text-gray-600 p-4 border-b border-gray-200">
                <div>Productnaam</div>
                <div>Voorraad</div>
                <div>Prijs (per stuk)</div>
                <div>Type</div>
                @if(optional(auth()->user())->department === 'Management')
                <div>Acties</div>
                @else
                <div></div>
                @endif
            </div>

            <div class="divide-y divide-gray-100">
                @foreach ($products as $product)
                <div class="grid grid-cols-5 p-4 items-center text-sm hover:bg-gray-50 transition">
                    <div class="font-medium text-gray-900">{{ $product->product_name }}</div>
                    <div>
                         @if($product->stock < 5)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">{{ $product->stock }} (Kritiek)</span>
                        @elseif($product->stock < 15)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">{{ $product->stock }} (Laag)</span>
                        @else
                            <span class="text-gray-700">{{ $product->stock }}</span>
                        @endif
                    </div>
                    <div class="text-gray-600">€ {{ number_format($product->price, 2, ',', '.') }}</div>
                    <div class="capitalize text-gray-600">{{ $product->type }}</div>

                    @if(optional(auth()->user())->department === 'Management')
                    <div class="flex gap-2">
                            </svg>
                            </svg>
                                <a href="{{ route('products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                    ✏️
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        🗑️
                                    </button>
                                </form>
                    </div>
                    @else
                    <div></div>
                    @endif
                </div>
                @endforeach
            </div>

            @if ($products->isEmpty())
            <div class="p-8 text-center text-gray-500">
                <p>Geen producten gevonden.</p>
            </div>
            @endif
        </div>

        @if(optional(auth()->user())->department === 'Management')
        <div class="bg-white p-6 rounded-lg shadow-sm mt-6 border border-gray-200">
            <div class="mb-4">
                <div class="flex items-center gap-2 mb-2">
                    <h2 class="text-lg font-semibold text-gray-900">Productbeheer</h2>
                    <!-- Info tooltip -->
                    <div class="relative group cursor-help">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400 hover:text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25v3.75m0-7.5h.008v.008H11.25V7.5zm0 12a8.25 8.25 0 110-16.5 8.25 8.25 0 010 16.5z" />
                        </svg>
                        <span class="invisible group-hover:visible absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-900 text-white text-xs p-2 rounded shadow-lg text-center z-10">
                            Hier kun je nieuwe producten toevoegen aan het assortiment.
                        </span>
                    </div>
                </div>
                <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-400 text-black rounded-md text-sm font-medium hover:bg-yellow-300 transition shadow-sm">
                    Product Toevoegen
                </a>
            </div>
        </div>
        @endif
    </div>
</x-layouts.app>

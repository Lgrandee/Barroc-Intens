<x-layouts.app :title="'Product bewerken'">
    <div class="max-w-6xl mx-auto p-6 bg-gray-100 min-h-screen">

        <div class="max-w-6xl mx-auto p-6 bg-gray-100 min-h-screen">
        <header class="mb-6">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-semibold text-black dark:text-white">Product bewerken</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">Pas de gegevens van het product aan</p>
            </div>
            <a href="{{ route('product.stock') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                Terug naar voorraad
            </a>
        </header>
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded p-4">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->has('order'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded p-4">
                {{ $errors->first('order') }}
            </div>
        @endif

        <form action="{{ route('products.order.store') }}" method="POST" class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
            @csrf

            <div class="grid grid-cols-5 font-semibold text-sm bg-gray-50 text-gray-600 p-4 border-b border-gray-200">
                <div class="text-black">Productnaam</div>
                <div class="text-black">Voorraad</div>
                <div class="text-black">Prijs (per stuk)</div>
                <div class="text-black">Type</div>
                <div class=" text-black">Aantal</div>
            </div>

            @foreach ($products as $product)
            <div class="grid grid-cols-5 items-center p-4 border-b border-gray-200 text-sm gap-2 hover:bg-gray-50 transition">
                <div class="text-black font-medium">{{ $product->product_name }}</div>
                <div class="text-black">{{ $product->stock }}</div>
                <div class="text-black">€ {{ number_format($product->price ?? 0, 2, ',', '.') }}</div>
                <div class="text-black capitalize">{{ $product->type }}</div>

                <div class="flex justify-end items-center gap-2 text-black">
                    <div class="inline-flex items-center border rounded-md overflow-hidden bg-white">
                        <button type="button" class="px-3 py-1 text-gray-700 hover:bg-gray-100 qty-btn" data-id="{{ $product->id }}" data-delta="-1">−</button>
                        <input
                            type="number"
                            name="quantities[{{ $product->id }}]"
                            id="qty-{{ $product->id }}"
                            value="0"
                            min="0"
                            class="w-16 text-center border-l border-r border-gray-200 focus:outline-none focus:ring-0"
                        >
                        <button type="button" class="px-3 py-1 text-gray-700 hover:bg-gray-100 qty-btn" data-id="{{ $product->id }}" data-delta="1">＋</button>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="flex flex-col items-center gap-3 px-4 py-3 border-t border-gray-200 bg-gray-50">
                <div class="text-sm text-gray-700">
                    Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
                </div>
                <div class="flex gap-1 items-center">
                    @if($products->onFirstPage())
                        <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">‹</span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">‹</a>
                    @endif

                    @php
                        $currentPage = $products->currentPage();
                        $lastPage = $products->lastPage();
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $products->url(1) }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">1</a>
                        @if ($start > 2)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $currentPage)
                            <span class="px-3 py-1 border border-yellow-400 bg-yellow-400 text-black rounded text-sm font-medium">{{ $page }}</span>
                        @else
                            <a href="{{ $products->url($page) }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">{{ $page }}</a>
                        @endif
                    @endfor

                    @if ($end < $lastPage)
                        @if ($end < $lastPage - 1)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                        <a href="{{ $products->url($lastPage) }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">{{ $lastPage }}</a>
                    @endif

                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">›</a>
                    @else
                        <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">›</span>
                    @endif
                </div>
            </div>
            @endif

            <div class="p-4 flex justify-between items-center bg-gray-50 border-t border-gray-200">
                <a href="{{ route('product.stock') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline">Annuleer</a>
                <button type="submit" class="px-4 py-2 bg-yellow-400 text-black rounded-md text-sm font-medium hover:bg-yellow-300 transition shadow-sm inline-flex items-center gap-2">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"/></svg>
                    Opslaan
                </button>
            </div>
            <div id="product-warning" class="hidden text-red-600 text-sm mt-2"></div>
        </form>
    </div>

    <script>
        document.querySelectorAll('.qty-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const delta = parseInt(this.dataset.delta, 10);
                const input = document.getElementById('qty-' + id);
                let v = parseInt(input.value || '0', 10);
                v = Math.max(0, v + delta);
                input.value = v;
            });
        });

        // Laat numerieke input niet onder 0 komen
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', () => {
                if (input.value === '') return;
                let v = parseInt(input.value, 10);
                if (isNaN(v) || v < 0) input.value = 0;
            });
        });

        // Validatie: minstens één product geselecteerd
        document.querySelector('form').addEventListener('submit', function(e) {
            let hasProduct = false;
            document.querySelectorAll('input[type="number"][name^="quantities["]').forEach(input => {
                if (parseInt(input.value, 10) > 0) {
                    hasProduct = true;
                }
            });
            const warning = document.getElementById('product-warning');
            if (!hasProduct) {
                e.preventDefault();
                warning.textContent = 'Selecteer minstens één product om te bestellen.';
                warning.classList.remove('hidden');
            } else {
                warning.classList.add('hidden');
            }
        });
    </script>
</x-layouts.app>

<x-layouts.app :title="'Product bewerken'">
    <div class="max-w-6xl mx-auto p-6 bg-gray-100 min-h-screen">

        <div class="max-w-6xl mx-auto p-6 bg-gray-100 min-h-screen">
        <header class="mb-6">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-semibold text-black dark:text-white">Product Bestellen</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">Producten voorraad verhogen</p>
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

        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6 flex flex-wrap items-center gap-4 shadow-md">
            <div class="flex-1 relative min-w-[240px]">
                <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
                <input
                    type="text"
                    id="product-search"
                    placeholder="Zoek op productnaam of type..."
                    class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-yellow-500 focus:border-yellow-500"
                />
            </div>

            <select
                id="product-type-filter"
                class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-600 focus:ring-yellow-500 focus:border-yellow-500"
            >
                <option value="all">Alle types</option>
                <option value="beans">Boon (Beans)</option>
                <option value="parts">Onderdeel (Parts)</option>
                <option value="machines">Machine</option>
            </select>

            <select
                id="product-stock-filter"
                class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-600 focus:ring-yellow-500 focus:border-yellow-500"
            >
                <option value="all">Alle voorraad</option>
                <option value="low">Lage voorraad</option>
                <option value="critical">Kritiek laag</option>
            </select>

            <button
                type="button"
                id="product-reset"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-300 hidden"
            >Reset</button>
        </div>

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
                @php
                    $stockLevel = $product->stock < 5 ? 'critical' : ($product->stock < 15 ? 'low' : 'normal');
                @endphp
              <div class="grid grid-cols-5 items-center p-4 border-b border-gray-200 text-sm gap-2 hover:bg-gray-50 transition product-row"
                  data-name="{{ strtolower($product->product_name) }}"
                  data-type="{{ strtolower($product->type) }}"
                  data-product-id="{{ $product->id }}"
                  data-product-name="{{ $product->product_name }}"
                  data-price="{{ $product->price ?? 0 }}"
                  data-stock-level="{{ $stockLevel }}">
                <div class="text-black font-medium product-name">{{ $product->product_name }}</div>
                <div>
                    @if($product->stock < 5)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">{{ $product->stock }} (Kritiek)</span>
                    @elseif($product->stock < 15)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">{{ $product->stock }} (Laag)</span>
                    @else
                        <span class="text-gray-700">{{ $product->stock }}</span>
                    @endif
                </div>
                <div class="text-black">€ {{ number_format($product->price ?? 0, 2, ',', '.') }}</div>
                <div class="text-black capitalize product-type">{{ $product->type }}</div>

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

            <div id="no-results" class="hidden p-6 text-center text-gray-500">
                Geen producten gevonden voor de huidige zoekopdracht.
            </div>

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

            <div class="p-4 border-t border-gray-200 bg-gray-50" id="selected-summary">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Geselecteerde producten
                    </h3>
                    <button type="button" id="clear-all-btn" class="hidden text-xs text-red-600 hover:text-red-800 hover:underline">
                        Alles wissen
                    </button>
                </div>
                <div id="selected-empty" class="text-sm text-gray-500 py-4 text-center">Nog geen producten geselecteerd.</div>
                <div id="selected-list" class="hidden">
                    <div class="grid grid-cols-5 text-xs font-semibold text-gray-500 border-b border-gray-200 pb-2 mb-2">
                        <div>Product</div>
                        <div class="text-right">Prijs</div>
                        <div class="text-center">Aantal</div>
                        <div class="text-right">Totaal</div>
                        <div class="text-right">Actie</div>
                    </div>
                    <div id="selected-items" class="divide-y divide-gray-100"></div>
                    <div class="flex justify-end mt-3 pt-3 border-t-2 border-gray-300">
                        <div class="text-sm font-semibold text-gray-700">Subtotaal:</div>
                        <div id="selected-total" class="ml-3 text-base font-bold text-gray-900">€ 0,00</div>
                    </div>
                </div>
            </div>

            <div id="selected-hidden-inputs" class="hidden"></div>
            <div class="p-4 flex justify-between items-center bg-gray-50 border-t border-gray-200">
                <a href="{{ route('product.stock') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline">Annuleer</a>
                <button type="submit" class="px-4 py-2 bg-yellow-400 text-black rounded-md text-sm font-medium hover:bg-yellow-300 transition shadow-sm inline-flex items-center gap-2">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"/></svg>
                    Product(en) Bestellen
                </button>
            </div>
            <div id="product-warning" class="hidden text-red-600 text-sm mt-2"></div>
        </form>
    </div>

    <script>
        const selectedEmpty = document.getElementById('selected-empty');
        const selectedList = document.getElementById('selected-list');
        const selectedItems = document.getElementById('selected-items');
        const selectedTotal = document.getElementById('selected-total');
        const hiddenInputs = document.getElementById('selected-hidden-inputs');
        const storageKey = 'orderSelections';
        let selections = {};

        function formatPrice(value) {
            return new Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(value || 0);
        }

        function loadSelections() {
            try {
                const raw = localStorage.getItem(storageKey);
                selections = raw ? JSON.parse(raw) : {};
            } catch (e) {
                selections = {};
            }
        }

        function applyPreselectFromQuery() {
            const params = new URLSearchParams(window.location.search);
            const preselectId = params.get('preselect');
            if (!preselectId) return;

            const row = document.querySelector(`.product-row[data-product-id="${preselectId}"]`);
            if (!row) return;

            const name = row.dataset.productName || row.querySelector('.product-name')?.textContent?.trim() || '';
            const price = parseFloat(row.dataset.price || '0');
            const existingQty = selections[preselectId]?.qty || 0;
            const qty = Math.max(existingQty, 1);

            selections[preselectId] = { id: preselectId, name, price, qty };
            const input = document.getElementById('qty-' + preselectId);
            if (input) {
                input.value = qty;
            }

            saveSelections();
        }

        function saveSelections() {
            localStorage.setItem(storageKey, JSON.stringify(selections));
        }

        function updateHiddenInputs() {
            if (!hiddenInputs) return;
            hiddenInputs.innerHTML = '';
            Object.values(selections).forEach(item => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `quantities[${item.id}]`;
                input.value = item.qty;
                hiddenInputs.appendChild(input);
            });
        }

        function updateSelectedSummary() {
            if (!selectedItems || !selectedTotal || !selectedEmpty || !selectedList) return;

            let total = 0;
            let hasItems = false;
            selectedItems.innerHTML = '';

            Object.values(selections).forEach(itemData => {
                if (!itemData.qty || itemData.qty <= 0) return;
                hasItems = true;
                const lineTotal = itemData.price * itemData.qty;
                total += lineTotal;

                const item = document.createElement('div');
                item.className = 'grid grid-cols-5 py-3 text-sm text-gray-700 items-center hover:bg-gray-100 transition rounded';
                item.innerHTML = `
                    <div class="font-medium">${itemData.name}</div>
                    <div class="text-right">${formatPrice(itemData.price)}</div>
                    <div class="flex justify-center">
                        <div class="inline-flex items-center border rounded-md overflow-hidden bg-white shadow-sm">
                            <button type="button" class="px-2 py-1 text-gray-700 hover:bg-gray-100 selected-qty-btn" data-id="${itemData.id}" data-delta="-1">−</button>
                            <span class="px-3 py-1 text-center border-l border-r border-gray-200 min-w-[40px] font-medium">${itemData.qty}</span>
                            <button type="button" class="px-2 py-1 text-gray-700 hover:bg-gray-100 selected-qty-btn" data-id="${itemData.id}" data-delta="1">＋</button>
                        </div>
                    </div>
                    <div class="text-right font-semibold text-gray-900">${formatPrice(lineTotal)}</div>
                    <div class="text-right">
                        <button type="button" class="text-red-500 hover:text-red-700 selected-remove-btn" data-id="${itemData.id}" title="Verwijder">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                `;
                selectedItems.appendChild(item);
            });

            // Voeg event listeners toe aan de nieuwe knoppen
            document.querySelectorAll('.selected-qty-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const delta = parseInt(this.dataset.delta, 10);
                    updateQuantityFromSummary(id, delta);
                });
            });

            document.querySelectorAll('.selected-remove-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    removeProductFromSummary(id);
                });
            });

            selectedTotal.textContent = formatPrice(total);
            selectedEmpty.classList.toggle('hidden', hasItems);
            selectedList.classList.toggle('hidden', !hasItems);

            // Toggle "Alles wissen" knop
            const clearAllBtn = document.getElementById('clear-all-btn');
            if (clearAllBtn) {
                clearAllBtn.classList.toggle('hidden', !hasItems);
            }

            updateHiddenInputs();
        }

        function updateQuantityFromSummary(productId, delta) {
            if (!selections[productId]) return;

            const newQty = Math.max(0, selections[productId].qty + delta);

            if (newQty === 0) {
                delete selections[productId];
            } else {
                selections[productId].qty = newQty;
            }

            // Sync met de hoofdinput
            const mainInput = document.getElementById('qty-' + productId);
            if (mainInput) {
                mainInput.value = newQty;
            }

            saveSelections();
            updateSelectedSummary();
        }

        function removeProductFromSummary(productId) {
            delete selections[productId];

            // Reset de hoofdinput
            const mainInput = document.getElementById('qty-' + productId);
            if (mainInput) {
                mainInput.value = 0;
            }

            saveSelections();
            updateSelectedSummary();
        }
        function clearAllSelections() {
            if (!confirm('Weet je zeker dat je alle geselecteerde producten wilt verwijderen?')) {
                return;
            }

            // Reset alle inputs
            Object.keys(selections).forEach(productId => {
                const mainInput = document.getElementById('qty-' + productId);
                if (mainInput) {
                    mainInput.value = 0;
                }
            });

            selections = {};
            saveSelections();
            updateSelectedSummary();
        }
        function syncSelectionsFromInputs() {
            document.querySelectorAll('.product-row').forEach(row => {
                const input = row.querySelector('input[type="number"]');
                const qty = parseInt(input?.value || '0', 10);
                const id = row.dataset.productId;
                const name = row.dataset.productName || '';
                const price = parseFloat(row.dataset.price || '0');

                if (!id) return;
                if (qty > 0) {
                    selections[id] = { id, name, price, qty };
                } else if (selections[id]) {
                    delete selections[id];
                }
            });
            saveSelections();
        }

        function syncInputsFromSelections() {
            document.querySelectorAll('.product-row').forEach(row => {
                const input = row.querySelector('input[type="number"]');
                const id = row.dataset.productId;
                const selected = selections[id];
                if (input && id && selected) {
                    input.value = selected.qty;
                }
            });
        }

        document.querySelectorAll('.qty-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const delta = parseInt(this.dataset.delta, 10);
                const input = document.getElementById('qty-' + id);
                let v = parseInt(input.value || '0', 10);
                v = Math.max(0, v + delta);
                input.value = v;
                syncSelectionsFromInputs();
                updateSelectedSummary();
            });
        });

        // Laat numerieke input niet onder 0 komen
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', () => {
                if (input.value === '') return;
                let v = parseInt(input.value, 10);
                if (isNaN(v) || v < 0) input.value = 0;
                syncSelectionsFromInputs();
                updateSelectedSummary();
            });
        });

        // Validatie: minstens één product geselecteerd
        document.querySelector('form').addEventListener('submit', function(e) {
            const hasProduct = Object.keys(selections).length > 0;
            const warning = document.getElementById('product-warning');
            if (!hasProduct) {
                e.preventDefault();
                warning.textContent = 'Selecteer minstens één product om te bestellen.';
                warning.classList.remove('hidden');
            } else {
                warning.classList.add('hidden');
            }
        });

        // Zoek & filter functionaliteit
        const searchInput = document.getElementById('product-search');
        const typeFilter = document.getElementById('product-type-filter');
        const stockFilter = document.getElementById('product-stock-filter');
        const rows = Array.from(document.querySelectorAll('.product-row'));
        const noResults = document.getElementById('no-results');

        function toggleResetButton() {
            const hasSearch = (searchInput.value || '').trim().length > 0;
            const hasFilter = typeFilter.value !== 'all';
            const hasStockFilter = stockFilter && stockFilter.value !== 'all';
            if (resetButton) {
                resetButton.classList.toggle('hidden', !(hasSearch || hasFilter || hasStockFilter));
            }
        }

        function applyFilters() {
            const query = (searchInput.value || '').toLowerCase().trim();
            const type = typeFilter.value;
            const stock = stockFilter ? stockFilter.value : 'all';
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.dataset.name || '';
                const rowType = row.dataset.type || '';
                const stockLevel = row.dataset.stockLevel || 'normal';
                const matchesQuery = !query || name.includes(query) || rowType.includes(query);
                const matchesType = type === 'all' || rowType === type;
                const matchesStock = stock === 'all'
                    || (stock === 'low' && (stockLevel === 'low' || stockLevel === 'critical'))
                    || (stock === 'critical' && stockLevel === 'critical');

                if (matchesQuery && matchesType && matchesStock) {
                    row.classList.remove('hidden');
                    visibleCount += 1;
                } else {
                    row.classList.add('hidden');
                }
            });

            if (noResults) {
                noResults.classList.toggle('hidden', visibleCount > 0);
            }

            toggleResetButton();
        }

        const resetButton = document.getElementById('product-reset');

        if (searchInput && typeFilter) {
            searchInput.addEventListener('input', applyFilters);
            typeFilter.addEventListener('change', applyFilters);
        }

        if (stockFilter) {
            stockFilter.addEventListener('change', applyFilters);
        }

        if (resetButton) {
            resetButton.addEventListener('click', () => {
                if (searchInput) searchInput.value = '';
                if (typeFilter) typeFilter.value = 'all';
                if (stockFilter) stockFilter.value = 'all';
                applyFilters();
            });
        }

        // "Alles wissen" knop in geselecteerde producten
        const clearAllBtn = document.getElementById('clear-all-btn');
        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', clearAllSelections);
        }

        loadSelections();
        applyPreselectFromQuery();
        syncInputsFromSelections();
        syncSelectionsFromInputs();
        applyFilters();
        updateSelectedSummary();
    </script>
</x-layouts.app>

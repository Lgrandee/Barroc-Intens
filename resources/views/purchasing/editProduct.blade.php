<x-layouts.app :title="'Product bewerken'">
    <main class="p-6 min-h-screen max-w-2xl mx-auto">
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

        <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
            <div class="p-6">
                <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="product_name" class="block font-medium text-sm text-gray-700 mb-1">Productnaam</label>
                        <input type="text" name="product_name" id="product_name" value="{{ old('product_name', $product->product_name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900 text-sm" required>
                    </div>
                    <div>
                        <label for="stock" class="block font-medium text-sm text-gray-700 mb-1">Voorraad</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900 text-sm" required>
                    </div>
                    <div>
                        <label for="price" class="block font-medium text-sm text-gray-700 mb-1">Prijs (per stuk)</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">€</span>
                            </div>
                            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" class="block w-full rounded-md border-gray-300 pl-7 focus:border-gray-900 focus:ring-gray-900 text-sm" required>
                        </div>
                    </div>
                    <div>
                        <label for="type" class="block font-medium text-sm text-gray-700 mb-1">Type</label>
                        <select name="type" id="type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900 text-sm" required>
                            <option value="beans" {{ old('type', $product->type) == 'beans' ? 'selected' : '' }}>Boon (Beans)</option>
                            <option value="parts" {{ old('type', $product->type) == 'parts' ? 'selected' : '' }}>Onderdeel (Parts)</option>
                            <option value="machines" {{ old('type', $product->type) == 'machines' ? 'selected' : '' }}>Machine</option>
                        </select>
                    </div>
                    <div class="flex justify-between items-center pt-4">
                        <a href="{{ route('product.stock') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline">Terug</a>
                        <button type="submit" class="px-4 py-2 bg-yellow-400 text-black rounded-md text-sm font-medium hover:bg-yellow-300 transition shadow-sm inline-flex items-center gap-2">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"/></svg>
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</x-layouts.app>

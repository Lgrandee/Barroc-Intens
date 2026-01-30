<x-layouts.app title="Product Toevoegen">
    <div class="max-w-3xl mx-auto p-6 bg-gray-100 min-h-screen">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <div class="border-b border-gray-100 pb-4 mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Product Toevoegen</h1>
                <p class="text-gray-500 text-sm mt-1">Voeg een nieuw product toe aan het assortiment</p>
            </div>

            <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="product_name" class="block font-medium text-sm text-gray-700 mb-1">Productnaam</label>
                    <input type="text" name="product_name" id="product_name" placeholder="Bijv. Koffiebonen Extra Dark" class="w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900 text-sm" required>
                </div>

                <div>
                    <label for="stock" class="block font-medium text-sm text-gray-700 mb-1">Initiële Voorraad</label>
                    <input type="number" name="stock" id="stock" placeholder="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900 text-sm" required>
                </div>

                <div>
                    <label for="price" class="block font-medium text-sm text-gray-700 mb-1">Prijs (per stuk)</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 sm:text-sm">€</span>
                        </div>
                        <input type="number" step="0.01" name="price" id="price" placeholder="0.00" class="block w-full rounded-md border-gray-300 pl-7 focus:border-gray-900 focus:ring-gray-900 text-sm" required>
                    </div>
                </div>

                <div>
                    <label for="type" class="block font-medium text-sm text-gray-700 mb-1">Type</label>
                    <select name="type" id="type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900 text-sm" required>
                        <option value="beans">Boon (Beans)</option>
                        <option value="parts">Onderdeel (Parts)</option>
                        <option value="machines">Machine</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('product.stock') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium underline-offset-4 hover:underline">Annuleren</a>
                    <button type="submit" class="inline-flex justify-center border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 rounded-md transition-colors">
                        Product Opslaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

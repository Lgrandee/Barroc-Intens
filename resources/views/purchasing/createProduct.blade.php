<x-layouts.app title="Product Toevoegen">
    <main class="p-6 min-h-screen max-w-4xl mx-auto">
        <header class="mb-6">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-semibold text-black dark:text-white">Product Toevoegen</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">Voeg een nieuw product toe aan het assortiment</p>
            </div>
            <a href="{{ route('product.stock') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                Terug naar overzicht
            </a>
        </header>

        <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
            <div class="p-6">
                <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="product_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Productnaam <span class="text-red-500">*</span></label>
                        <input type="text" name="product_name" id="product_name" placeholder="Bijv. Koffiebonen Extra Dark" class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 focus:border-transparent" required>
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Initiële Voorraad <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" id="stock" placeholder="0" class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 focus:border-transparent" required>
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prijs (per stuk) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 dark:text-gray-300 sm:text-sm">€</span>
                            </div>
                            <input type="number" step="0.01" name="price" id="price" placeholder="0.00" class="block w-full rounded-lg border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white pl-7 pr-3 py-2 focus:ring-2 focus:ring-gray-900 focus:border-transparent" required>
                        </div>
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type <span class="text-red-500">*</span></label>
                        <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 focus:border-transparent" required>
                            <option value="beans">Boon (Beans)</option>
                            <option value="parts">Onderdeel (Parts)</option>
                            <option value="machines">Machine</option>
                        </select>
                    </div>

                    <div class="flex gap-3 justify-between items-center pt-4 border-t border-gray-200 dark:border-zinc-700">
                        <a href="{{ route('product.stock') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline">
                            Annuleren
                        </a>
                        <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-black bg-yellow-400 hover:bg-yellow-300 rounded-lg shadow-sm transition-all transform hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                            Product Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
            Productbeheer — voeg producten zorgvuldig toe aan het assortiment
        </div>
    </main>
</x-layouts.app>

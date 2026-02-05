<x-layouts.app title="Nieuwe Klant">
    <main class="p-6 min-h-screen max-w-4xl mx-auto">
        <!-- Header -->
        <header class="mb-6">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-semibold text-black dark:text-white">Nieuwe Klant Aanmaken</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">Voeg een nieuw klantrecord toe aan het systeem</p>
            </div>
            <a href="{{ route('customers.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                Terug naar overzicht
            </a>
        </header>

        <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
            <div class="p-6">
                <!-- Form -->
                <form action="{{ route('customers.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Bedrijfsgegevens -->
                    <div class="pb-6 border-b border-gray-200 dark:border-zinc-700">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Bedrijfsgegevens</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name_company" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bedrijfsnaam <span class="text-red-500">*</span></label>
                                <input type="text" id="name_company" name="name_company" placeholder="Bedrijfsnaam..." class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 focus:border-transparent" required>
                                @error('name_company')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="contact_person" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contactpersoon <span class="text-red-500">*</span></label>
                                <input type="text" id="contact_person" name="contact_person" placeholder="Contactpersoon..." class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 focus:border-transparent" required>
                                @error('contact_person')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contactgegevens -->
                    <div class="pb-6 border-b border-gray-200 dark:border-zinc-700">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Contactgegevens</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">E-mailadres <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" placeholder="E-mailadres..." class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 focus:border-transparent" required>
                                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telefoonnummer <span class="text-red-500">*</span></label>
                                <input type="tel" id="phone_number" name="phone_number" placeholder="0612345678" 
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 focus:border-transparent" 
                                       required pattern="[0-9]+" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @error('phone_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- BKR Informatie -->
                    <div class="pb-6 border-b border-gray-200 dark:border-zinc-700">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">BKR Informatie</h3>
                        <div>
                            <label for="bkr_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">BKR Nummer <span class="text-red-500">*</span></label>
                            <input type="text" id="bkr_number" name="bkr_number" placeholder="BKR nummer..." class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 focus:border-transparent" required>
                            @error('bkr_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Adresgegevens -->
                    <div class="pb-6">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Adresgegevens</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adres <span class="text-red-500">*</span></label>
                                <input type="text" id="address" name="address" placeholder="Adres..." class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 focus:border-transparent" required>
                                @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Plaats <span class="text-red-500">*</span></label>
                                <input type="text" id="city" name="city" placeholder="Plaats..." class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 focus:border-transparent" required>
                                @error('city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="zipcode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Postcode <span class="text-red-500">*</span></label>
                                <input type="text" id="zipcode" name="zipcode" placeholder="Postcode..." class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 focus:border-transparent" required>
                                @error('zipcode')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-3 justify-between items-center pt-4 border-t border-gray-200 dark:border-zinc-700">
                        <a href="{{ route('customers.index') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline">
                            Annuleren
                        </a>
                        <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-black bg-yellow-400 hover:bg-yellow-300 rounded-lg shadow-sm transition-all transform hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 flex items-center gap-2">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"/></svg>
                            Klant toevoegen
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer text -->
        <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
            Klantgegevens — vul zorgvuldig alle gegevens in voor een nieuwe klant
        </div>
    </main>
</x-layouts.app>

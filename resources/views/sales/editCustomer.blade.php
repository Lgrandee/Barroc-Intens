<x-layouts.app title="Klant Bewerken">
    <div class="p-6 bg-[#f3f4f6] min-h-screen">
        <div class="max-w-3xl mx-auto">
            <!-- Header Section -->
            <header class="mb-6 flex flex-col items-center gap-2">
                <h1 class="text-3xl font-semibold text-black dark:text-white text-center">Klant Bewerken</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 text-center">Beheer de gegevens van {{ $customer->name_company }}</p>
                <div class="w-full flex flex-row gap-2 mt-4">
                    <a href="{{ route('customers.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 text-sm">← Terug</a>
                </div>
            </header>

            <!-- Edit Form Container -->
            <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
                <form action="{{ route('customers.update', ['customer' => $customer->id]) }}" method="POST" class="flex flex-col gap-5">
                    @csrf
                    @method('PUT')

                    <div class="p-6 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
                        <h2 class="text-lg font-semibold text-black dark:text-white">Klantgegevens</h2>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="flex flex-col gap-1">
                            <label for="name_company" class="font-medium text-gray-700 dark:text-gray-300 text-sm">Bedrijfsnaam</label>
                            <input type="text" id="name_company" name="name_company" value="{{ $customer->name_company }}" placeholder="Bedrijfsnaam..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:border-zinc-600 dark:text-white dark:focus:ring-blue-400" required>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="contact_person" class="font-medium text-gray-700 dark:text-gray-300 text-sm">Contactpersoon</label>
                            <input type="text" id="contact_person" name="contact_person" value="{{ $customer->contact_person }}" placeholder="Contactpersoon..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:border-zinc-600 dark:text-white dark:focus:ring-blue-400" required>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="email" class="font-medium text-gray-700 dark:text-gray-300 text-sm">E-mailadres</label>
                            <input type="email" id="email" name="email" value="{{ $customer->email }}" placeholder="E-mailadres..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:border-zinc-600 dark:text-white dark:focus:ring-blue-400" required>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="phone_number" class="font-medium text-gray-700 dark:text-gray-300 text-sm">Telefoonnummer</label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ $customer->phone_number }}" placeholder="Telefoonnummer..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:border-zinc-600 dark:text-white dark:focus:ring-blue-400" required>
                        </div>

                        <div class="flex flex-col gap-1 md:col-span-2">
                            <label for="bkr_number" class="font-medium text-gray-700 dark:text-gray-300 text-sm">BKR Nummer</label>
                            <input type="text" id="bkr_number" name="bkr_number" value="{{ $customer->bkr_number }}" placeholder="BKR nummer..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:border-zinc-600 dark:text-white dark:focus:ring-blue-400">
                        </div>

                        <div class="flex flex-col gap-1 md:col-span-2">
                            <label for="notes" class="font-medium text-gray-700 dark:text-gray-300 text-sm">Notities</label>
                            <textarea id="notes" name="notes" rows="4" placeholder="Voeg notities toe over deze klant..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:border-zinc-600 dark:text-white dark:focus:ring-blue-400">{{ $customer->notes }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100 dark:border-zinc-700">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"/></svg>
                            Wijzigingen Opslaan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete Warning Section -->
            <div class="bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 rounded-lg p-6 shadow">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-red-100 dark:bg-red-900 rounded-full text-red-600 dark:text-red-400">
                        ⚠️
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-red-800 dark:text-red-300 mb-1">Klant Verwijderen</h3>
                        <p class="text-red-700 dark:text-red-400 mb-4 text-sm">Dit zal de klant en alle gerelateerde gegevens permanent verwijderen. Deze actie kan niet ongedaan worden gemaakt.</p>

                        <form action="{{ route('customers.destroy', ['customer' => $customer->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 dark:bg-red-700 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-red-700 dark:hover:bg-red-600 transition shadow-sm">Bevestig Verwijdering</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

  </main>

</x-layouts.app>


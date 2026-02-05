<x-layouts.app :title="$customer->name_company">
    <main class="p-6 min-h-screen max-w-4xl mx-auto">
        <!-- Header -->
        <header class="mb-6">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-semibold text-black dark:text-white">{{ $customer->name_company }}</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">Klantgegevens overzicht</p>
            </div>
            <a href="{{ route('customers.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                Terug naar overzicht
            </a>
        </header>

        <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
            <div class="p-6">
                <!-- Details grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <!-- Kolom 1 -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Bedrijfsnaam</h3>
                            <p class="text-lg font-medium text-black dark:text-white">{{ $customer->name_company }}</p>
                        </div>

                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Contactpersoon</h3>
                            <p class="text-gray-900 dark:text-gray-100">{{ $customer->contact_person ?? '-' }}</p>
                        </div>

                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">BKR Nummer</h3>
                            <p class="text-gray-900 dark:text-gray-100">{{ $customer->bkr_number ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Kolom 2 -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">E-mailadres</h3>
                            <a href="mailto:{{ $customer->email }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 break-all">
                                {{ $customer->email }}
                            </a>
                        </div>

                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Telefoonnummer</h3>
                            <a href="tel:{{ $customer->phone_number }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                                {{ $customer->phone_number ?? '-' }}
                            </a>
                        </div>

                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Plaats</h3>
                            <p class="text-gray-900 dark:text-gray-100">{{ $customer->city ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Kolom 3 -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Adres</h3>
                            <p class="text-gray-900 dark:text-gray-100">{{ $customer->address ?? '-' }}</p>
                        </div>

                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Postcode</h3>
                            <p class="text-gray-900 dark:text-gray-100">{{ $customer->zipcode ?? '-' }}</p>
                        </div>

                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">BKR Status</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($customer->bkr_status === 'approved')
                                    bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                @elseif($customer->bkr_status === 'denied')
                                    bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                @elseif($customer->bkr_status === 'pending')
                                    bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                @else
                                    bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                @endif">
                                {{ ucfirst($customer->bkr_status ?? 'pending') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Notes (readonly textarea) -->
                <div class="border-t border-gray-100 dark:border-zinc-700 pt-6">
                    <label for="notes" class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                        Notities
                    </label>

                    <textarea
                        id="notes"
                        rows="4"
                        readonly
                        class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg text-sm
                               bg-gray-50 dark:bg-zinc-700 text-gray-800 dark:text-gray-100 resize-none
                               focus:outline-none focus:ring-0 focus:border-gray-300 dark:focus:border-zinc-600"
                    >{{ $customer->notes ?: 'Geen notities toegevoegd.' }}</textarea>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center px-6 py-4 border-t border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
                <a href="{{ route('customers.index') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline">
                    Annuleren
                </a>
                <a href="{{ route('customers.edit', $customer->id) }}"
                   class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                    Bewerken
                </a>
            </div>
        </div>

        <!-- Footer text -->
        <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
            Klantgegevens overzicht — contactinformatie en BKR status
        </div>
    </main>
</x-layouts.app>

<x-layouts.app :title="$customer->name_company">
    <style>
        /* Light-only page background override */
        html:not(.dark) body { background-color: #f3f4f6 !important; }
    </style>
    <main class="p-6 min-h-screen">
        <!-- Header -->
        <header class="mb-6 flex flex-col items-center gap-2">
            <h1 class="text-3xl font-semibold text-black dark:text-white text-center">{{ $customer->name_company }}</h1>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 text-center">Klantgegevens overzicht</p>
            <div class="w-full flex justify-center">
                <div class="max-w-3xl w-full mx-auto flex flex-row gap-2 mt-4">
                    <a href="{{ route('customers.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 text-sm">← Terug</a>
                </div>
            </div>
        </header>

        <div class="max-w-3xl mx-auto">
            <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
            <!-- Header bar -->
            <div class="p-6 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
                <h2 class="text-lg font-semibold text-black dark:text-white">Klantgegevens</h2>
            </div>

            <div class="p-6">
                <!-- Details grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Left -->
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
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">E-mailadres</h3>
                            <a href="mailto:{{ $customer->email }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                                {{ $customer->email }}
                            </a>
                        </div>
                    </div>

                    <!-- Right -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Telefoonnummer</h3>
                            <a href="tel:{{ $customer->phone_number }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                                {{ $customer->phone_number ?? '-' }}
                            </a>
                        </div>

                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">BKR Nummer</h3>
                            <p class="text-gray-900 dark:text-gray-100">{{ $customer->bkr_number ?? '-' }}</p>
                        </div>

                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">BKR Status</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($customer->bkr_status === 'approved')
                                    bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                @elseif($customer->bkr_status === 'rejected')
                                    bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                @else
                                    bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                @endif">
                                {{ ucfirst($customer->bkr_status ?? 'pending') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Notes (readonly textarea) -->
                <div class="border-t border-gray-100 dark:border-zinc-700 pt-8">
                    <label for="notes" class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                        Notities
                    </label>

                    <textarea
                        id="notes"
                        rows="6"
                        readonly
                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md text-sm
                               bg-gray-50 dark:bg-zinc-700 text-gray-800 dark:text-gray-100 resize-none
                               focus:outline-none focus:ring-0 focus:border-gray-300 dark:focus:border-zinc-600"
                    >{{ $customer->notes ?: 'Geen notities toegevoegd.' }}</textarea>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end px-6 py-4 border-t border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900 flex gap-3">
                <a href="{{ route('customers.edit', $customer->id) }}"
                   class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                    ✏️ Bewerken
                </a>
            </div>
        </div>
        </div>
    </main>
</x-layouts.app>

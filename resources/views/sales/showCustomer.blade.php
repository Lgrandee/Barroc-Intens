<x-layouts.app>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klant Details — Tailwind</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Topbar -->
    <header class="p-6 max-w-5xl mx-auto">
        <h1 class="text-2xl font-semibold">{{ $customer->name_company }}</h1>
        <p class="text-gray-500">Klantgegevens overzicht</p>
    </header>

    <!-- Nav -->
    <nav class="bg-white border-y border-gray-200">
        <ul class="p-4 max-w-5xl mx-auto flex gap-4">
            <li>
                <a href="{{ route('customers.index') }}" class="text-blue-600 hover:underline">
                    ← Terug naar overzicht
                </a>
            </li>
            <li>
                <a href="{{ route('customers.edit', $customer->id) }}" class="text-blue-600 hover:underline">
                    ✏️ Klant bewerken
                </a>
            </li>
        </ul>
    </nav>

    <main class="p-6 max-w-5xl mx-auto">

        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">

            <!-- Details grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Left -->
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Bedrijfsnaam</h3>
                        <p class="text-base font-medium">{{ $customer->name_company }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Contactpersoon</h3>
                        <p>{{ $customer->contact_person ?? '-' }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">E-mailadres</h3>
                        <a href="mailto:{{ $customer->email }}" class="text-blue-600 hover:underline">
                            {{ $customer->email }}
                        </a>
                    </div>
                </div>

                <!-- Right -->
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Telefoonnummer</h3>
                        <a href="tel:{{ $customer->phone_number }}" class="text-blue-600 hover:underline">
                            {{ $customer->phone_number ?? '-' }}
                        </a>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">BKR Nummer</h3>
                        <p>{{ $customer->bkr_number ?? '-' }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">BKR Status</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($customer->bkr_status === 'approved')
                                bg-green-100 text-green-800
                            @elseif($customer->bkr_status === 'rejected')
                                bg-red-100 text-red-800
                            @else
                                bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($customer->bkr_status ?? 'pending') }}
                        </span>
                    </div>
                </div>

            </div>

            <!-- Notes (readonly textarea) -->
            <div class="mt-8">
                <label for="notes" class="block text-sm font-medium text-gray-500 mb-2">
                    Notities
                </label>

                <textarea
                    id="notes"
                    rows="6"
                    readonly
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm
                           bg-gray-50 text-gray-800 resize-none
                           focus:outline-none focus:ring-0 focus:border-gray-300"
                >{{ $customer->notes ?: 'Geen notities toegevoegd.' }}</textarea>
            </div>

            <!-- Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex gap-3">
                <a href="{{ route('customers.edit', $customer->id) }}"
                   class="flex-1 bg-blue-600 text-white py-2.5 rounded-md text-sm font-medium hover:bg-blue-700 transition text-center">
                    ✏️ Bewerken
                </a>

                <a href="{{ route('customers.index') }}"
                   class="flex-1 bg-gray-300 text-gray-800 py-2.5 rounded-md text-sm font-medium hover:bg-gray-400 transition text-center">
                    Terug
                </a>
            </div>

        </div>

    </main>

</body>
</html>
</x-layouts.app>

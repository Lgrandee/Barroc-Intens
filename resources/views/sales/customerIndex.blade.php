<x-layouts.app title="Klantenoverzicht">
    <div class="p-6 bg-[#f3f4f6]">
        
        <!-- Header Section similar to dashboards -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold mb-1">Klantenoverzicht</h1>
            <p class="text-gray-500 text-sm">Beheer en zoek door alle klanten</p>
        </div>

        <!-- Filters -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6 flex items-center gap-4 shadow-sm">
            <!-- Search field -->
            <div class="flex-1 relative">
                <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
                <input type="text" placeholder="Zoek op naam, bedrijf, e-mail..." class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-600 hover:border-blue-500 hover:text-blue-600 transition">
                🏷️ Status <span class="text-blue-600">(1)</span>
            </button>

            <button class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-600 hover:border-blue-500 hover:text-blue-600 transition">
                📅 Datum
            </button>

            <button class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-600 hover:border-blue-500 hover:text-blue-600 transition">
                💰 Omzet
            </button>

            <a href="{{ route('customers.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700 flex items-center gap-2 transition shadow-sm">
                ＋ Nieuwe Klant
            </a>
        </div>

        <!-- Customers Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($customers as $customer)
                <div class="bg-white border border-gray-200 rounded-lg p-5 hover:border-blue-500 hover:shadow-md transition group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-semibold text-lg group-hover:bg-indigo-600 group-hover:text-white transition">
                                {{ substr($customer->name_company, 0, 2) }}
                            </div>
                            <div>
                                <h3 class="font-medium text-lg">{{ $customer->name_company }}</h3>
                                <p class="text-gray-500 text-sm">{{ $customer->contact_person }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded bg-green-100 text-green-700">Actief</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                        <div>
                            <span class="text-gray-500 block text-xs uppercase tracking-wide">BKR Status</span>
                            <p class="font-semibold {{ $customer->bkr_status === 'approved' ? 'text-green-600' : 'text-yellow-600' }}">{{ ucfirst($customer->bkr_status) }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-xs uppercase tracking-wide">Telefoon</span>
                            <p class="font-semibold">{{ $customer->phone_number }}</p>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-500 block text-xs uppercase tracking-wide">Email</span>
                            <p class="font-semibold truncate">{{ $customer->email }}</p>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-500 block text-xs uppercase tracking-wide">Adres</span>
                            <p class="font-semibold truncate">{{ $customer->address }}, {{ $customer->zipcode }}</p>
                        </div>
                    </div>

                    <div class="flex gap-2 pt-4 border-t border-gray-100">
                        <a href="{{ route('customers.show', ['customer' => $customer->id]) }}" class="flex-1 text-center border border-gray-200 rounded-md py-2 text-sm text-gray-600 hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50 transition">
                            Details
                        </a>
                        <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" class="flex-1 text-center border border-gray-200 rounded-md py-2 text-sm text-gray-600 hover:border-yellow-500 hover:text-yellow-600 hover:bg-yellow-50 transition">
                            Bewerken
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-between items-center bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <span class="text-gray-500 text-sm">Toont alle klanten</span>
            <!-- Pagination logic would go here -->
        </div>
    </div>
</x-layouts.app>

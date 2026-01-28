<x-layouts.app title="Klant Bewerken">
    <div class="p-6 bg-[#f3f4f6] min-h-screen">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <a href="{{ route('customers.index') }}" class="text-gray-500 hover:text-gray-700 text-sm mb-2 inline-block">← Terug naar overzicht</a>
                <h1 class="text-2xl font-semibold">Klant Bewerken</h1>
                <p class="text-gray-500 text-sm">Beheer de gegevens van {{ $customer->name_company }}</p>
            </div>

            <!-- Edit Form Container -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8 shadow-sm">
                <form action="{{ route('customers.update', ['customer' => $customer->id]) }}" method="POST" class="flex flex-col gap-5">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="flex flex-col gap-1">
                            <label for="name_company" class="font-medium text-gray-700 text-sm">Bedrijfsnaam</label>
                            <input type="text" id="name_company" name="name_company" value="{{ $customer->name_company }}" placeholder="Bedrijfsnaam..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="contact_person" class="font-medium text-gray-700 text-sm">Contactpersoon</label>
                            <input type="text" id="contact_person" name="contact_person" value="{{ $customer->contact_person }}" placeholder="Contactpersoon..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="email" class="font-medium text-gray-700 text-sm">E-mailadres</label>
                            <input type="email" id="email" name="email" value="{{ $customer->email }}" placeholder="E-mailadres..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="phone_number" class="font-medium text-gray-700 text-sm">Telefoonnummer</label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ $customer->phone_number }}" placeholder="Telefoonnummer..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div class="flex flex-col gap-1 md:col-span-2">
                            <label for="bkr_number" class="font-medium text-gray-700 text-sm">BKR Nummer</label>
                            <input type="text" id="bkr_number" name="bkr_number" value="{{ $customer->bkr_number }}" placeholder="BKR nummer..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="flex flex-col gap-1 md:col-span-2">
                            <label for="notes" class="font-medium text-gray-700 text-sm">Notities</label>
                            <textarea id="notes" name="notes" rows="4" placeholder="Voeg notities toe over deze klant..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">{{ $customer->notes }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition shadow-sm">Wijzigingen Opslaan</button>
                    </div>
                </form>
            </div>

            <!-- Delete Warning Section -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-red-100 rounded-full text-red-600">
                        ⚠️
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-red-800 mb-1">Klant Verwijderen</h3>
                        <p class="text-red-700 mb-4 text-sm">Dit zal de klant en alle gerelateerde gegevens permanent verwijderen. Deze actie kan niet ongedaan worden gemaakt.</p>
                        
                        <form action="{{ route('customers.destroy', ['customer' => $customer->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-red-700 transition shadow-sm">Bevestig Verwijdering</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

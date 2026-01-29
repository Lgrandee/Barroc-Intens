<x-layouts.app title="Nieuwe Klant">
    <div class="p-6 bg-[#f3f4f6] min-h-screen flex justify-center">
        <div class="w-full max-w-xl">
            <!-- Header -->
            <div class="mb-6">
                <a href="{{ route('customers.index') }}" class="text-gray-500 hover:text-gray-700 text-sm mb-2 inline-block">← Terug naar overzicht</a>
                <h1 class="text-2xl font-semibold">Nieuwe Klant Aanmaken</h1>
                <p class="text-gray-500 text-sm">Voeg een nieuw klantrecord toe aan het systeem</p>
            </div>

            <!-- Form -->
            <form action="{{ route('customers.store') }}" method="POST" class="bg-white border border-gray-200 rounded-lg p-6 shadow-xl">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name_company" class="block font-medium text-gray-700 mb-1 text-sm">Bedrijfsnaam</label>
                        <input type="text" id="name_company" name="name_company" placeholder="Bedrijfsnaam..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div>
                        <label for="contact_person" class="block font-medium text-gray-700 mb-1 text-sm">Contactpersoon</label>
                        <input type="text" id="contact_person" name="contact_person" placeholder="Contactpersoon..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div>
                        <label for="email" class="block font-medium text-gray-700 mb-1 text-sm">E-mailadres</label>
                        <input type="email" id="email" name="email" placeholder="E-mailadres..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div>
                        <label for="phone_number" class="block font-medium text-gray-700 mb-1 text-sm">Telefoonnummer</label>
                        <input type="text" id="phone_number" name="phone_number" placeholder="Telefoonnummer..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>


                    <div>
                        <label for="bkr_number" class="block font-medium text-gray-700 mb-1 text-sm">BKR Nummer</label>
                        <input type="text" id="bkr_number" name="bkr_number" placeholder="BKR nummer..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div>
                        <label for="address" class="block font-medium text-gray-700 mb-1 text-sm">Adres</label>
                        <input type="text" id="address" name="address" placeholder="Adres..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="city" class="block font-medium text-gray-700 mb-1 text-sm">Plaats</label>
                        <input type="text" id="city" name="city" placeholder="Plaats..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="zipcode" class="block font-medium text-gray-700 mb-1 text-sm">Postcode</label>
                        <input type="text" id="zipcode" name="zipcode" placeholder="Postcode..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                </div>

      <button type="submit" class="mt-4 w-full flex items-center justify-center gap-2 bg-yellow-400 text-black py-2 rounded-md hover:bg-yellow-300 transition">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"/></svg>
        Klant toevoegen
      </button>

    </form>

  </main>

</x-layouts.app>

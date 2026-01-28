<x-layouts.app title="Nieuwe Klant">
    <div class="p-6 bg-[#FAF9F6] min-h-screen flex justify-center">
        <div class="w-full max-w-xl">
            <!-- Header -->
            <div class="mb-6">
                <a href="{{ route('customers.index') }}" class="text-gray-500 hover:text-gray-700 text-sm mb-2 inline-block">← Terug naar overzicht</a>
                <h1 class="text-2xl font-semibold">Nieuwe Klant Aanmaken</h1>
                <p class="text-gray-500 text-sm">Voeg een nieuw klantrecord toe aan het systeem</p>
            </div>

            <!-- Form -->
            <form action="{{ route('customers.store') }}" method="POST" class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
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
                </div>

      <button type="submit" class="mt-4 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
        ➕ Klant toevoegen
      </button>

    </form>

  </main>

</body>
</html>

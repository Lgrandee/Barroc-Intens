<x-layouts.app>
<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Klant Bewerken — Tailwind</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

  <!-- Topbar -->
  <header class="p-6">
    <h1 class="text-2xl font-semibold">Klant bewerken</h1>
    <p class="text-gray-500">Werk klantgegevens bij</p>
  </header>

  <!-- Nav -->
  <nav class="bg-white border-y border-gray-200">
    <ul class="p-4">
      <li>
        <a href="{{ route('customers.index') }}" class="text-blue-600 hover:underline">← Terug naar overzicht</a>
      </li>
    </ul>
  </nav>

  <main class="p-6 max-w-3xl mx-auto">

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

        <button type="submit" class="mt-2 bg-blue-600 text-white py-2.5 rounded-md text-sm font-medium hover:bg-blue-700 transition">Wijzigingen opslaan</button>
      </form>
    </div>

    <!-- Delete Warning Section -->
    <div class="bg-red-50 border border-red-200 rounded-lg p-6 shadow-sm">
      <h3 class="text-lg font-semibold text-red-700 mb-2">Klant verwijderen</h3>
      <p class="text-gray-600 mb-4 text-sm">Dit kan niet ongedaan worden gemaakt. Weet je het zeker?</p>

      <form action="{{ route('customers.destroy', ['customer' => $customer->id]) }}" method="POST">
        @csrf
        @method('DELETE')

        <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-red-700 transition">Klant verwijderen</button>
      </form>
    </div>

  </main>

</body>
</html>
</x-layouts.app>

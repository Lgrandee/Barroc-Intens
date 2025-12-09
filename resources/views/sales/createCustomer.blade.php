<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nieuwe Klant — Tailwind</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

  <!-- Topbar -->
  <header class="p-6">
    <h1 class="text-2xl font-semibold">Nieuwe Klant Aanmaken</h1>
    <p class="text-gray-500">Voeg een nieuw klantrecord toe</p>
  </header>

  <!-- Nav -->
  <nav class="bg-white border-y border-gray-200">
    <ul class="p-4">
      <li>
        <a href="{{ route('customers.index') }}" class="text-blue-600 hover:underline">← Terug naar overzicht</a>
      </li>
    </ul>
  </nav>

  <main class="p-6 flex justify-center">

    <form action="{{ route('customers.store') }}" method="POST" class="bg-white border border-gray-200 rounded-lg p-6 w-full max-w-xl shadow-sm">
      @csrf

      <div class="mb-4">
        <label for="name_company" class="block font-semibold text-gray-700 mb-1">Bedrijfsnaam</label>
        <input type="text" id="name_company" name="name_company" placeholder="Bedrijfsnaam..." class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
      </div>

      <div class="mb-4">
        <label for="contact_person" class="block font-semibold text-gray-700 mb-1">Contactpersoon</label>
        <input type="text" id="contact_person" name="contact_person" placeholder="Contactpersoon..." class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
      </div>

      <div class="mb-4">
        <label for="email" class="block font-semibold text-gray-700 mb-1">E-mailadres</label>
        <input type="email" id="email" name="email" placeholder="E-mailadres..." class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
      </div>

      <div class="mb-4">
        <label for="phone_number" class="block font-semibold text-gray-700 mb-1">Telefoonnummer</label>
        <input type="text" id="phone_number" name="phone_number" placeholder="Telefoonnummer..." class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
      </div>

      <div class="mb-4">
        <label for="bkr_number" class="block font-semibold text-gray-700 mb-1">BKR Nummer</label>
        <input type="text" id="bkr_number" name="bkr_number" placeholder="BKR nummer..." class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
      </div>

      <button type="submit" class="mt-4 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
        ➕ Klant toevoegen
      </button>

    </form>

  </main>

</body>
</html>

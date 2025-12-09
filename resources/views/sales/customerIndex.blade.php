<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Klantenoverzicht — Tailwind</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

  <!-- Topbar -->
  <header class="p-6">
    <h1 class="text-2xl font-semibold">Klantenoverzicht</h1>
    <p class="text-gray-500">Beheer en zoek door alle klanten</p>
  </header>

  <!-- Nav -->
  <nav class="bg-white border-y border-gray-200">
    <ul class="p-4">
      <li>
        <a href="index.html" class="text-blue-600 hover:underline">← Terug naar Index</a>
      </li>
    </ul>
  </nav>

  <main class="p-6">

    <!-- Filters -->
    <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6 flex items-center gap-4">

      <!-- Search field -->
      <div class="flex-1 relative">
        <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
        <input
          type="text"
          placeholder="Zoek op naam, bedrijf, e-mail..."
          class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
        >
      </div>

      <button class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-600 hover:border-blue-500 hover:text-blue-600">
        🏷️ Status <span class="text-blue-600">(1)</span>
      </button>

      <button class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-600 hover:border-blue-500 hover:text-blue-600">
        📅 Datum
      </button>

      <button class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-600 hover:border-blue-500 hover:text-blue-600">
        💰 Omzet
      </button>

      <button class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700 flex items-center gap-2">
        ＋ Nieuwe Klant
      </button>
    </div>

    <!-- Customers Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach ($customers as $customer) <!-- For each customer card ding -->
            <div class="bg-white border border-gray-200 rounded-lg p-5 hover:border-blue-500 hover:shadow-md transition">
                <div class="flex justify-between items-start mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-semibold text-lg">
                    VD
                    </div>
                    <div>
                    <h3 class="font-medium text-lg">{{ $customer->name_company }}</h3>
                    <p class="text-gray-500 text-sm">Water squirmy user</p>
                    </div>
                </div>
                <span class="px-2 py-1 text-xs font-medium rounded bg-green-100 text-green-700">Actief</span>
                </div>

                <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                <div>
                    <span class="text-gray-500">Bkr check</span>
                    <p class="font-semibold">{{ $customer->bkr_status }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Contact persoon</span>
                    <p class="font-semibold">{{ $customer->contact_person }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Phone number</span>
                    <p class="font-semibold">{{ $customer->phone_number }}</p>
                    <span class="text-gray-500">e-mailadres</span>
                    <p class="font-semibold">{{ $customer->email }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Adres</span>
                    <p class="font-semibold">{{ $customer->address }}</p>
                    <span class="text-gray-500">Zipcode</span>
                    <p class="font-semibold">{{ $customer->zipcode }}</p>
                </div>
                </div>
                <div class="flex gap-2">
                <a href="{{ route('customers.show', ['customer' => $customer->id]) }}" class="flex-1 text-center border border-gray-300 rounded-md py-2 text-sm text-gray-600 hover:border-blue-500 hover:text-blue-600">
                    👁️ Details bekijken
                </a>
                <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" class="flex-1 text-center border border-gray-300 rounded-md py-2 text-sm text-gray-600 hover:border-blue-500 hover:text-blue-600">
                    ✏️ Bewerken
                </a>
                <a href="mailto:{{ $customer->email }}" class="flex-1 text-center border border-gray-300 rounded-md py-2 text-sm text-gray-600 hover:border-blue-500 hover:text-blue-600">
                    ✉️ Contact
                </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-between items-center bg-white border border-gray-200 rounded-lg p-4">
      <span class="text-gray-500 text-sm">Toont 1–12 van 48 klanten</span>

      <div class="flex gap-2">
        <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:border-blue-500 hover:text-blue-600">←</button>
        <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm">1</button>
        <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:border-blue-500 hover:text-blue-600">2</button>
        <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:border-blue-500 hover:text-blue-600">3</button>
        <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:border-blue-500 hover:text-blue-600">4</button>
        <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:border-blue-500 hover:text-blue-600">→</button>
      </div>
    </div>

  </main>

</body>
</html>

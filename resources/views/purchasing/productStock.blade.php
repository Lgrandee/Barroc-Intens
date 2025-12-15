<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Producten</title>
</head>
<body class="bg-gray-100">
  <header class="p-6 bg-white shadow">
    <h1 class="text-2xl font-semibold">Producten</h1>
    <p class="text-gray-500">Overzicht van alle producten</p>
    <div class="mt-4">
      <a href="{{ route('products.order') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">Bestel producten</a>
    </div>
  </header>

  <main class="max-w-6xl mx-auto p-6">

    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
      <div class="grid grid-cols-5 font-semibold text-sm bg-gray-50 text-gray-600 p-4 border-b border-gray-200">
        <div>Productnaam</div>
        <div>Voorraad</div>
        <div>Prijs</div>
        <div>Type</div>
        <div>Acties</div>
      </div>

      @foreach ($products as $product)
      <div class="grid grid-cols-5 p-4 border-b border-gray-200 items-center text-sm">
        <div>{{ $product->product_name }}</div>
        <div>{{ $product->stock }}</div>
        <div>€ {{ number_format($product->price, 2, ',', '.') }}</div>
        <div class="capitalize">{{ $product->type }}</div>

        @if(optional(auth()->user())->department === 'Management')
        <div class="flex gap-2">
          <a href="#" class="px-2 py-1 border rounded text-gray-600 hover:bg-gray-100">✏️</a>
          <a href="#" class="px-2 py-1 border rounded text-gray-600 hover:bg-gray-100">🗑️</a>
        </div>
        @endif
      </div>
      @endforeach

      @if ($products->isEmpty())
      <div class="p-4 text-gray-500 text-sm">Geen producten gevonden.</div>
      @endif

    </div>

    @if(optional(auth()->user())->department === 'Management')
    <div class="bg-white p-6 rounded-xl shadow-md mt-6">
        <div class="flex items-center gap-2 mb-6">
            <h2 class="text-xl font-semibold">Manage Products</h2>

            <!-- Info wrapper -->
            <div class="relative group cursor-pointer">
                <!-- Info icon -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-5 h-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.25 11.25v3.75m0-7.5h.008v.008H11.25V7.5zm0 12a8.25 8.25 0 110-16.5 8.25 8.25 0 010 16.5z" />
                </svg>

                <!-- Info message -->
                <span class="invisible group-hover:visible absolute bottom-6 left-1/2 -translate-x-1/2 z-10
             w-[160px] bg-black text-white text-xs text-center py-1 px-2 rounded-md shadow-lg">
                    Hier kan je producten beschikbaar stellen voor inkoop, bewerken of verwijderen.
                </span>
            </div>

        </div>

        <!-- buttons -->
        <div class="flex gap-3">
            <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
                Product toevoegen
            </a>
        </div>
    </div>

    @endif

  </main>
</body>
</html>

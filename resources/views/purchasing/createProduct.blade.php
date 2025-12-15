<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Nieuw Product</title>
</head>
<body class="bg-gray-100">
  <header class="p-6 bg-white shadow">
    <h1 class="text-2xl font-semibold">Product toevoegen</h1>
    <p class="text-gray-500">Voeg een nieuw product toe aan het systeem.</p>
  </header>

  <main class="max-w-3xl mx-auto p-6">
    <div class="bg-white border border-gray-200 rounded-lg p-6">
      <form action="{{ route('products.store') }}" method="POST" class="flex flex-col gap-4">
        @csrf

        <div class="flex flex-col gap-1">
          <label for="product_name" class="font-medium text-gray-700 text-sm">Productnaam</label>
          <input type="text" name="product_name" id="product_name" placeholder="Productnaam" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div class="flex flex-col gap-1">
          <label for="stock" class="font-medium text-gray-700 text-sm">Voorraad</label>
          <input type="number" name="stock" id="stock" placeholder="Voorraad" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div class="flex flex-col gap-1">
          <label for="price" class="font-medium text-gray-700 text-sm">Prijs</label>
          <input type="text" name="price" id="price" placeholder="Prijs" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div class="flex flex-col gap-1">
          <label for="type" class="font-medium text-gray-700 text-sm">Type</label>
          <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
            <option value="beans">Beans</option>
            <option value="parts">Parts</option>
            <option value="machines">Machines</option>
          </select>
        </div>

        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">Product Toevoegen</button>
      </form>
    </div>
  </main>
</body>
</html>

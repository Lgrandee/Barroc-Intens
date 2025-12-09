<x-layouts.app>
<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Product Bestellen</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 text-gray-800">


  <main class="max-w-6xl mx-auto p-6">
    @if(session('success'))
      <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded p-4">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('products.order.store') }}" method="POST" class="bg-white border border-gray-200 rounded-lg overflow-hidden">
      @csrf

      <div class="grid grid-cols-5 font-semibold text-sm bg-gray-50 text-gray-600 p-4 border-b border-gray-200">
        <div class="text-black">Productnaam</div>
        <div class="text-black">Voorraad</div>
        <div class="text-black">Prijs</div>
        <div class="text-black">Type</div>
        <div class=" text-black">Aantal</div>
      </div>

      @foreach ($products as $product)
      <div class="grid grid-cols-5 items-center p-4 border-b border-gray-200 text-sm gap-2">
        <div class="text-black">{{ $product->product_name }}</div>
        <div class="text-black">{{ $product->stock }}</div>
        <div class="text-black">€ {{ number_format($product->price ?? 0, 2, ',', '.') }}</div>
        <div class="text-black">{{ $product->type }}</div>

        <div class="flex justify-end items-center gap-2 text-black">
          <div class="inline-flex items-center border rounded-md overflow-hidden">
            <button type="button" class="px-3 py-1 text-gray-700 hover:bg-gray-100 qty-btn" data-id="{{ $product->id }}" data-delta="-1">−</button>
            <input
              type="number"
              name="quantities[{{ $product->id }}]"
              id="qty-{{ $product->id }}"
              value="0"
              min="0"
              class="w-16 text-center border-l border-r border-transparent focus:outline-none"
            >
            <button type="button" class="px-3 py-1 text-gray-700 hover:bg-gray-100 qty-btn" data-id="{{ $product->id }}" data-delta="1">＋</button>
          </div>
        </div>
      </div>
      @endforeach

      <div class="p-4 flex justify-end gap-3">
        <a href="{{ route('product.stock') }}" class="px-4 py-2 border rounded text-sm text-gray-600 hover:bg-gray-50">Terug</a>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">Bestel</button>
      </div>
    </form>
  </main>

  <script>
    document.querySelectorAll('.qty-btn').forEach(btn => {
      btn.addEventListener('click', function () {
        const id = this.dataset.id;
        const delta = parseInt(this.dataset.delta, 10);
        const input = document.getElementById('qty-' + id);
        let v = parseInt(input.value || '0', 10);
        v = Math.max(0, v + delta);
        input.value = v;
      });
    });

    // Laat numerieke input niet onder 0 komen (bescherming bij direct typen)
    document.querySelectorAll('input[type="number"]').forEach(input => {
      input.addEventListener('input', () => {
        if (input.value === '') return;
        let v = parseInt(input.value, 10);
        if (isNaN(v) || v < 0) input.value = 0;
      });
    });
  </script>
</body>
</html>
</x-layouts.app>

<x-layouts.app>
<div class="max-w-6xl mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">Bestellingen backlog</h1>

  <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
    <div class="grid grid-cols-5 gap-0 font-semibold text-sm bg-gray-50 text-gray-600 p-4 border-b border-gray-200">
      <div class="text-black">Product</div>
      <div class="text-black">Aantal</div>
      <div class="text-black">Prijs (per stuk)</div>
      <div class="text-black">Totaal</div>
      <div class="text-black">Wanneer</div>
    </div>

    @forelse($logs as $log)
      <div class="grid grid-cols-5 items-center p-4 border-b border-gray-100 text-sm">
        <div class="text-black">{{ $log->product?->product_name ?? '—' }}</div>
        <div class="text-black">{{ $log->amount }}</div>
        <div class="text-black">€ {{ number_format($log->price ?? 0, 2, ',', '.') }}</div>
        <div class="text-black">€ {{ number_format(($log->price ?? 0) * ($log->amount ?? 0), 2, ',', '.') }}</div>
        <div class="text-gray-500 text-xs">{{ $log->created_at?->format('d-m-Y H:i') ?? '-' }}</div>
      </div>
    @empty
      <div class="p-6 text-center text-gray-500">Er zijn nog geen bestellingen in de backlog.</div>
    @endforelse
  </div>

  <div class="mt-4">
    <a href="{{ route('products.order') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Nieuwe bestelling</a>
    <a href="{{ route('product.stock') }}" class="ml-2 px-4 py-2 border rounded text-gray-700 hover:bg-gray-50">Voorraad</a>
  </div>
</div>
</x-layouts.app>

<x-layouts.app :title="'Bestellingen backlog'">
    <div class="max-w-6xl mx-auto p-6 bg-gray-100 min-h-screen">
        <header class="mb-6">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-semibold text-black dark:text-white">Bestellingen backlog</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">Overzicht van alle bestellingen in de backlog</p>
            </div>
            <a href="{{ route('product.stock') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                Terug naar voorraad
            </a>
        </header>

        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
            <div class="grid grid-cols-5 font-semibold text-sm bg-gray-50 text-gray-600 p-4 border-b border-gray-200">
                <div class="text-black">Product</div>
                <div class="text-black">Aantal</div>
                <div class="text-black">Prijs (per stuk)</div>
                <div class="text-black">Totaal</div>
                <div class="text-black">Wanneer</div>
            </div>

            @forelse($logs as $log)
                <div class="grid grid-cols-5 items-center p-4 border-b border-gray-200 text-sm gap-2 hover:bg-gray-50 transition">
                    <div class="text-black">{{ $log->product?->product_name ?? '—' }}</div>
                    <div class="text-black">{{ $log->amount }}</div>
                    <div class="text-black">€ {{ number_format($log->price ?? 0, 2, ',', '.') }}</div>
                    <div class="text-black">€ {{ number_format(($log->price ?? 0) * ($log->amount ?? 0), 2, ',', '.') }}</div>
                    <div class="text-gray-500 text-xs">{{ $log->created_at?->setTimezone('Europe/Amsterdam')->format('d-m-Y H:i') ?? '-' }}</div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">Er zijn nog geen bestellingen in de backlog.</div>
            @endforelse

            <!-- Pagination -->
            @if($logs->hasPages())
            <div class="flex flex-col items-center gap-3 px-4 py-3 border-t border-gray-200 bg-gray-50">
                <div class="text-sm text-gray-700">
                    Showing {{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }}
                </div>
                <div class="flex gap-1 items-center">
                    @if($logs->onFirstPage())
                        <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">‹</span>
                    @else
                        <a href="{{ $logs->previousPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">‹</a>
                    @endif

                    @php
                        $currentPage = $logs->currentPage();
                        $lastPage = $logs->lastPage();
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $logs->url(1) }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">1</a>
                        @if ($start > 2)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $currentPage)
                            <span class="px-3 py-1 border border-yellow-400 bg-yellow-400 text-black rounded text-sm font-medium">{{ $page }}</span>
                        @else
                            <a href="{{ $logs->url($page) }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">{{ $page }}</a>
                        @endif
                    @endfor

                    @if ($end < $lastPage)
                        @if ($end < $lastPage - 1)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                        <a href="{{ $logs->url($lastPage) }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">{{ $lastPage }}</a>
                    @endif

                    @if($logs->hasMorePages())
                        <a href="{{ $logs->nextPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">›</a>
                    @else
                        <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">›</span>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="p-4 flex justify-between items-center bg-gray-50 border-t border-gray-200 mt-4">
            <a href="{{ route('product.stock') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline">Voorraad</a>
            <a href="{{ route('products.order') }}" class="px-4 py-2 bg-yellow-400 text-black rounded-md text-sm font-medium hover:bg-yellow-300 transition shadow-sm inline-flex items-center gap-2">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"/></svg>
                Nieuwe bestelling
            </a>
        </div>
    </div>
</x-layouts.app>

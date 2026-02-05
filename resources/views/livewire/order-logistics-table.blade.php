<div>
  <!-- Search and filter bar -->
  <div class="p-4 border-b border-gray-100 bg-gray-50">
    <div class="flex flex-wrap gap-3">
      <input
        type="text"
        wire:model.live.debounce.300ms="search"
        placeholder="Zoek op productnaam..."
        class="flex-1 min-w-[300px] px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent"
      />

      @if($search)
        <button wire:click="resetFilters" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-300">
          Reset
        </button>
      @endif
    </div>
  </div>

  <!-- Table -->
  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-gray-50 border-b border-gray-200">
        <tr>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aantal</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prijs (per stuk)</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Totaal</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wanneer</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @forelse($logs as $log)
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-4 text-sm text-gray-900 font-medium">{{ $log->product?->product_name ?? '—' }}</td>
            <td class="px-4 py-4 text-sm text-gray-900">{{ $log->amount }}</td>
            <td class="px-4 py-4 text-sm text-gray-900">€{{ number_format($log->price ?? 0, 2, ',', '.') }}</td>
            <td class="px-4 py-4 text-sm text-gray-900 font-semibold">€{{ number_format(($log->price ?? 0) * ($log->amount ?? 0), 2, ',', '.') }}</td>
            <td class="px-4 py-4 text-sm text-gray-500">{{ $log->created_at?->setTimezone('Europe/Amsterdam')->format('d-m-Y H:i') ?? '-' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-4 py-8 text-center text-gray-500 text-sm">
              Er zijn nog geen bestellingen in de backlog.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Footer with pagination -->
  <div class="flex flex-col items-center gap-3 px-4 py-3 border-t border-gray-200 bg-gray-50">
    <div class="text-sm text-gray-700">
      Showing {{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }}
    </div>
    <div class="flex gap-1 items-center">
      @if ($logs->onFirstPage())
        <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">‹</span>
      @else
        <button wire:click="previousPage" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">‹</button>
      @endif

      @php
        $currentPage = $logs->currentPage();
        $lastPage = $logs->lastPage();
        $start = max(1, $currentPage - 2);
        $end = min($lastPage, $currentPage + 2);
      @endphp

      @if ($start > 1)
        <button wire:click="gotoPage(1)" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">1</button>
        @if ($start > 2)
          <span class="px-2 text-gray-500">...</span>
        @endif
      @endif

      @for ($page = $start; $page <= $end; $page++)
        @if ($page == $currentPage)
          <span class="px-3 py-1 border border-yellow-400 bg-yellow-400 text-black rounded text-sm font-medium">{{ $page }}</span>
        @else
          <button wire:click="gotoPage({{ $page }})" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">{{ $page }}</button>
        @endif
      @endfor

      @if ($end < $lastPage)
        @if ($end < $lastPage - 1)
          <span class="px-2 text-gray-500">...</span>
        @endif
        <button wire:click="gotoPage({{ $lastPage }})" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">{{ $lastPage }}</button>
      @endif

      @if ($logs->hasMorePages())
        <button wire:click="nextPage" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">›</button>
      @else
        <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">›</span>
      @endif
    </div>
  </div>
</div>

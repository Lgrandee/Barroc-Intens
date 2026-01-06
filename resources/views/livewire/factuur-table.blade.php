<div>
  <!-- Search and filter bar -->
  <div class="p-4 border-b border-gray-100 bg-gray-50">
    <div class="flex flex-wrap gap-3">
      <select wire:model.live="status" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="all">Alle statussen</option>
        <option value="concept">Concept</option>
        <option value="verzonden">Verzonden</option>
        <option value="betaald">Betaald</option>
        <option value="verlopen">Verlopen</option>
      </select>

      <select wire:model.live="period" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="all">Alle periodes</option>
        <option value="this_month">Deze maand</option>
        <option value="last_30_days">Laatste 30 dagen</option>
        <option value="last_90_days">Laatste 90 dagen</option>
      </select>

      <input
        type="text"
        wire:model.live.debounce.300ms="search"
        placeholder="Zoek op factuurnummer, klantnaam..."
        class="flex-1 min-w-[300px] px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
      />

      @if($search || $status !== 'all' || $period !== 'this_month')
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
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Factuurnr.</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klant</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vervaldatum</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bedrag</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @forelse($facturen as $factuur)
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-4">
              <div class="font-medium text-indigo-600">F{{ date('Y', strtotime($factuur->invoice_date)) }}-{{ str_pad($factuur->id, 3, '0', STR_PAD_LEFT) }}</div>
              @if($factuur->offerte_id)
                <div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                  🔗 <a href="{{ route('offertes.show', $factuur->offerte_id) }}" class="text-indigo-600 hover:text-indigo-800">Offerte</a>
                </div>
              @endif
            </td>
            <td class="px-4 py-4">
              <div class="font-medium text-gray-900">{{ $factuur->customer->name_company ?? 'Onbekend' }}</div>
              <div class="text-sm text-gray-500">{{ $factuur->customer->email ?? '' }}</div>
            </td>
            <td class="px-4 py-4 text-sm text-gray-900">
              {{ \Carbon\Carbon::parse($factuur->invoice_date)->format('d M Y') }}
            </td>
            <td class="px-4 py-4 text-sm">
              @php
                $dueDate = \Carbon\Carbon::parse($factuur->due_date);
                $isOverdue = $dueDate->isPast() && $factuur->status !== 'betaald';
              @endphp
              <span class="{{ $isOverdue ? 'text-red-600 font-medium' : 'text-gray-900' }}">
                {{ $dueDate->format('d M Y') }}
              </span>
            </td>
            <td class="px-4 py-4 text-sm text-gray-900 font-medium">
              €{{ number_format($factuur->total_amount ?? 0, 2, ',', '.') }}
            </td>
            <td class="px-4 py-4">
              @php
                $statusColors = [
                  'betaald' => 'bg-green-100 text-green-700',
                  'verlopen' => 'bg-red-100 text-red-700',
                  'verzonden' => 'bg-yellow-100 text-yellow-700',
                  'concept' => 'bg-gray-100 text-gray-700'
                ];
                $statusLabels = [
                  'betaald' => 'Betaald',
                  'verlopen' => 'Verlopen',
                  'verzonden' => 'Verzonden',
                  'concept' => 'Concept'
                ];
              @endphp
              <span class="inline-flex items-center gap-1 px-3 py-1 rounded text-xs font-medium {{ $statusColors[$factuur->status] ?? 'bg-gray-100 text-gray-800' }}">
                {{ $statusLabels[$factuur->status] ?? ucfirst($factuur->status) }}
              </span>
            </td>
            <td class="px-4 py-4">
              <div class="flex gap-2">
                <a href="{{ route('facturen.send', $factuur->id) }}" class="text-gray-600 hover:text-gray-900" title="Bekijken">👁️</a>
                <a href="{{ route('facturen.edit', $factuur->id) }}" class="text-gray-600 hover:text-gray-900" title="Bewerken">✏️</a>
                <button
                  wire:click="delete({{ $factuur->id }})"
                  wire:confirm="Weet je zeker dat je deze factuur wilt verwijderen?"
                  class="text-red-600 hover:text-red-900"
                  title="Verwijderen"
                >🗑️</button>
                <a href="{{ route('facturen.pdf', $factuur->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Downloaden">⬇️</a>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="px-4 py-8 text-center text-gray-500 text-sm">
              Geen facturen gevonden
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Footer with pagination -->
  <div class="flex flex-col items-center gap-3 px-4 py-3 border-t border-gray-200 bg-gray-50">
    <div class="text-sm text-gray-700">
      Toont {{ $facturen->firstItem() ?? 0 }}–{{ $facturen->lastItem() ?? 0 }} van {{ $facturen->total() }}
    </div>
    <div class="flex gap-1 items-center">
      @if ($facturen->onFirstPage())
        <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">‹</span>
      @else
        <button wire:click="previousPage" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">‹</button>
      @endif

      @php
        $currentPage = $facturen->currentPage();
        $lastPage = $facturen->lastPage();
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
          <span class="px-3 py-1 border border-indigo-600 bg-indigo-600 text-white rounded text-sm font-medium">{{ $page }}</span>
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

      @if ($facturen->hasMorePages())
        <button wire:click="nextPage" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">›</button>
      @else
        <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">›</span>
      @endif
    </div>
  </div>
</div>

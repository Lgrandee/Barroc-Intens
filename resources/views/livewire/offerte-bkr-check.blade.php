<div class="flex items-start gap-3 p-3 rounded-md transition-colors {{ $isApproved ? 'bg-green-50 border border-green-200' : 'bg-gray-50 border border-gray-200' }}">
    <div class="text-xl {{ $isApproved ? 'text-green-600' : 'text-gray-600' }}">{{ $isApproved ? '✓' : '?' }}</div>
    <div class="flex-1">
        <div class="font-medium text-gray-900">BKR check</div>
        <div class="text-sm {{ $isApproved ? 'text-green-700' : 'text-gray-600' }}">
            {{ $isApproved ? 'BKR check staat op goedgekeurd' : 'BKR check is nog niet uitgevoerd voor deze klant' }}
        </div>
    </div>
    @if (!$isApproved)
        <button
            type="button"
            wire:click="approve"
            class="px-3 py-1 text-sm font-medium bg-indigo-600 text-white rounded hover:bg-indigo-700 disabled:opacity-50"
        >BKR check uitvoeren</button>
    @else
        <div class="px-3 py-1 text-sm font-medium text-green-700">Goedgekeurd</div>
    @endif
</div>

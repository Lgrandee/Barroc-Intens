<div class="flex items-start gap-3 p-3 rounded-md transition-colors {{ $isApproved ? 'bg-green-50 border border-green-200' : ($isDenied ? 'bg-red-50 border border-red-200' : 'bg-gray-50 border border-gray-200') }}">
    <div class="text-xl {{ $isApproved ? 'text-green-600' : ($isDenied ? 'text-red-600' : 'text-gray-600') }}">{{ $isApproved ? '✓' : ($isDenied ? '✗' : '?') }}</div>
    <div class="flex-1">
        <div class="font-medium text-gray-900">BKR Check</div>
        <div class="text-sm {{ $isApproved ? 'text-green-700' : ($isDenied ? 'text-red-700' : 'text-gray-600') }}">
            @if ($isApproved)
                BKR check staat op goedgekeurd
            @elseif ($isDenied)
                BKR check staat op afgekeurd
            @else
                BKR check is nog niet uitgevoerd voor deze klant
            @endif
        </div>
        <div class="flex gap-2 mt-2">
            <button
                type="button"
                wire:click="approve"
                class="px-4 py-2 text-sm font-semibold bg-yellow-400 text-black rounded-md shadow hover:bg-yellow-300 hover:shadow-md hover:scale-105 transition-all disabled:opacity-50"
            >{{ $isUnknown ? 'BKR Check Uitvoeren' : 'Opnieuw Controleren' }}</button>
            @if (!$isUnknown)
                <button
                    type="button"
                    wire:click="resetBkrStatus"
                    class="px-4 py-2 text-sm font-semibold bg-gray-400 text-black rounded-md shadow hover:bg-gray-300 hover:shadow-md hover:scale-105 transition-all disabled:opacity-50"
                >Resetten</button>
            @endif
        </div>
    </div>
</div>

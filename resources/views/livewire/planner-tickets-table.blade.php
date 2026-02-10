<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-black">Alle tickets</h2>
        <a href="{{ route('planner.tickets.create') }}" class="px-4 py-2 bg-yellow-400 text-black rounded-md text-sm font-medium hover:bg-yellow-300 transition shadow-sm inline-flex items-center gap-2">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"/></svg>
            Nieuw ticket
        </a>
    </div>

    <div class="flex flex-wrap gap-3 mb-6">
        <input
            type="text"
            wire:model.live.debounce.200ms="search"
            placeholder="Zoek op onderwerp, klant of ticketnummer"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm"
        />

        <select wire:model.live="status" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 text-gray-700 text-sm">
            <option value="">Alle statussen</option>
            <option value="open">Open</option>
            <option value="te_laat">In behandeling</option>
            <option value="voltooid">Gesloten</option>
        </select>

        <select wire:model.live="priority" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 text-gray-700 text-sm">
            <option value="">Alle prioriteiten</option>
            <option value="hoog">Hoog</option>
            <option value="medium">Medium</option>
            <option value="laag">Laag</option>
        </select>

        <select wire:model.live="department" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 text-gray-700 text-sm">
            <option value="">Alle afdelingen</option>
            <option value="service">Service</option>
            <option value="installation">Installatie</option>
            <option value="meeting">Meeting</option>
        </select>

        @if($search || $status || $priority || $department)
            <button wire:click="resetFilters" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-300">
                Reset
            </button>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Onderwerp</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klant</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Afspraakdatum</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioriteit</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Laatste update</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actie</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tickets as $ticket)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="font-medium text-black">{{ $ticket->feedback?->description ?? 'Geen onderwerp' }}</div>
                        <div class="text-sm text-gray-500">{{ ucfirst($ticket->catagory) }} — #TCK-{{ date('Y') }}-{{ str_pad($ticket->id, 3, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-black">{{ $ticket->feedback?->customer?->name_company ?? 'Onbekend' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-black">{{ $ticket->appointment_date ? \Carbon\Carbon::parse($ticket->appointment_date)->format('d M Y') : '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $priorityLabel = $ticket->priority ?? 'medium';
                        @endphp
                        @if($priorityLabel === 'hoog')
                            <span class="text-red-600 font-medium">Hoog</span>
                        @elseif($priorityLabel === 'medium')
                            <span class="text-orange-600 font-medium">Medium</span>
                        @elseif($priorityLabel === 'laag')
                            <span class="text-green-600 font-medium">Laag</span>
                        @else
                            <span class="text-gray-600 font-medium">Geen</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-black">{{ \Carbon\Carbon::parse($ticket->updated_at)->format('d M Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($ticket->status === 'voltooid')
                            <span class="text-green-600 font-medium">Gesloten</span>
                        @elseif($ticket->status === 'te_laat')
                            <span class="text-orange-600 font-medium">In behandeling</span>
                        @else
                            <span class="text-blue-600 font-medium">Open</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        <a href="{{ route('planner.tickets.show', $ticket->id) }}" class="text-indigo-600 hover:text-indigo-900 underline font-medium">Bekijk</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="mt-2">Geen tickets gevonden</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tickets->hasPages())
    <div class="flex flex-col items-center gap-3 px-4 py-3 border-t border-gray-200 bg-gray-50 mt-6">
        <div class="text-sm text-gray-700">
            Showing {{ $tickets->firstItem() ?? 0 }}–{{ $tickets->lastItem() ?? 0 }} of {{ $tickets->total() }}
        </div>
        <div class="flex gap-1 items-center">
            @if($tickets->onFirstPage())
                <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">‹</span>
            @else
                <button wire:click="previousPage" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">‹</button>
            @endif

            @php
                $currentPage = $tickets->currentPage();
                $lastPage = $tickets->lastPage();
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

            @if($tickets->hasMorePages())
                <button wire:click="nextPage" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">›</button>
            @else
                <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">›</span>
            @endif
        </div>
    </div>
    @endif

    <div class="mt-6 pt-4 border-t border-gray-200">
        <a href="{{ route('planner.dashboard') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline">
            Terug naar dashboard
        </a>
    </div>
</div>

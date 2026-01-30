<x-layouts.app :title="'Mijn Planning'">
    <!-- Header -->
    <div class="p-6 pb-4">
        <h1 class="text-2xl font-semibold text-gray-900">Mijn Planning</h1>
        <p class="text-sm text-gray-600 mt-1">Overzicht van al je geplande taken: onderhoud, installaties en afspraken</p>
    </div>

    <div class="mx-6 mb-6 bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <!-- Search and filter bar -->
        <div class="p-4 border-b border-gray-100 bg-gray-50">
            <form method="GET" action="{{ route('technician.planning') }}" class="flex flex-wrap gap-3" id="filterForm">
                <input type="text" name="search" placeholder="Zoek op klant of locatie..."
                    value="{{ request('search') }}"
                    class="flex-1 min-w-[300px] px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">

                <select name="period" onchange="document.getElementById('filterForm').submit()" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                    <option value="">Alle periodes</option>
                    <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Vandaag</option>
                    <option value="tomorrow" {{ request('period') === 'tomorrow' ? 'selected' : '' }}>Morgen</option>
                    <option value="this_week" {{ request('period') === 'this_week' ? 'selected' : '' }}>Deze week</option>
                    <option value="next_week" {{ request('period') === 'next_week' ? 'selected' : '' }}>Volgende week</option>
                    <option value="this_month" {{ request('period') === 'this_month' ? 'selected' : '' }}>Deze maand</option>
                </select>

                <select name="status" onchange="document.getElementById('filterForm').submit()" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                    <option value="">Alle statussen</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="te_laat" {{ request('status') === 'te_laat' ? 'selected' : '' }}>Te laat</option>
                    <option value="voltooid" {{ request('status') === 'voltooid' ? 'selected' : '' }}>Voltooid</option>
                    <option value="probleem" {{ request('status') === 'probleem' ? 'selected' : '' }}>Probleem</option>
                </select>

                <select name="category" onchange="document.getElementById('filterForm').submit()" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                    <option value="">Alle types</option>
                    <option value="service" {{ request('category') === 'service' ? 'selected' : '' }}>Onderhoud</option>
                    <option value="installation" {{ request('category') === 'installation' ? 'selected' : '' }}>Installatie</option>
                    <option value="meeting" {{ request('category') === 'meeting' ? 'selected' : '' }}>Afspraak</option>
                </select>

                @if(request('search') || request('status') || request('category') || request('period'))
                <a href="{{ route('technician.planning') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-300">
                    Reset
                </a>
                @endif
            </form>
        </div>

        @if($periodLabel && $periodStart && $periodEnd)
        <div class="px-4 py-3 bg-blue-50 border-b border-blue-100">
            <div class="flex items-center gap-2 text-sm">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="font-medium text-blue-900">{{ $periodLabel }}:</span>
                <span class="text-blue-700">{{ $periodStart->format('d-m-Y') }} tot {{ $periodEnd->format('d-m-Y') }}</span>
            </div>
        </div>
        @endif

        <!-- Table -->
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klant</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Beschrijving</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locatie</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tijd</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($planningTickets as $task)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if($task->catagory === 'service')
                            <span class="px-3 py-1 text-sm font-medium rounded-md bg-blue-100 text-blue-800">Onderhoud</span>
                            @elseif($task->catagory === 'installation')
                            <span class="px-3 py-1 text-sm font-medium rounded-md bg-purple-100 text-purple-800">Installatie</span>
                            @else
                            <span class="px-3 py-1 text-sm font-medium rounded-md bg-gray-100 text-gray-800">Afspraak</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-medium text-gray-900">{{ $task->feedback?->customer?->name_company ?? 'Intern' }}</div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-900">
                            {{ $task->feedback?->description ?? '-' }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-900">
                            {{ $task->location }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($task->scheduled_time)->format('d-m-Y') }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($task->scheduled_time)->format('H:i') }}
                        </td>
                        <td class="px-4 py-4">
                            @if($task->status === 'voltooid')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Voltooid</span>
                            @elseif($task->status === 'probleem')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Probleem</span>
                            @elseif($task->status === 'te_laat')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Te laat</span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">Open</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('technician.onderhoud.show', $task->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-yellow-400 text-black rounded-md text-xs font-semibold hover:bg-yellow-300 transition-colors shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Bekijk
                                </a>
                                @if($task->status === 'open' || $task->status === 'te_laat')
                                <a href="{{ route('technician.onderhoud.rapport', $task->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-600 text-white rounded-md text-xs font-semibold hover:bg-red-700 hover:shadow-md transition-all shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Rapport
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500 text-sm">
                            Geen taken gevonden
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer with pagination -->
        @if($planningTickets->hasPages())
        <div class="flex flex-col items-center gap-3 px-4 py-3 border-t border-gray-200 bg-gray-50">
            <div class="text-sm text-gray-700">
                Toont {{ $planningTickets->firstItem() ?? 0 }}–{{ $planningTickets->lastItem() ?? 0 }} van {{ $planningTickets->total() }}
            </div>
            {{ $planningTickets->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</x-layouts.app>

<x-layouts.app :title="'Ticket overzicht'">
    <main class="p-6">
        <!-- Header -->
        <header class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Ticket overzicht</h1>
        </header>

        <!-- Main Content -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Alle tickets</h2>
                <a href="{{ route('planner.tickets.create') }}"
                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium text-sm">
                    Nieuw ticket
                </a>
            </div>

            <!-- Filters -->
            <form method="GET" action="{{ route('planner.tickets.index') }}" class="flex gap-3 mb-6" id="filterForm">
                <input type="text" name="search" placeholder="Zoek op onderwerp, klant of ticketnummer"
                    value="{{ request('search') }}"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent">

                <select name="status" onchange="document.getElementById('filterForm').submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 text-gray-700">
                    <option value="">Alle statussen</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="te_laat" {{ request('status') === 'te_laat' ? 'selected' : '' }}>In behandeling</option>
                    <option value="voltooid" {{ request('status') === 'voltooid' ? 'selected' : '' }}>Gesloten</option>
                </select>

                <select name="priority" onchange="document.getElementById('filterForm').submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 text-gray-700">
                    <option value="">Alle prioriteiten</option>
                    <option value="hoog" {{ request('priority') === 'hoog' ? 'selected' : '' }}>Hoog</option>
                    <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="laag" {{ request('priority') === 'laag' ? 'selected' : '' }}>Laag</option>
                </select>

                <select name="department" onchange="document.getElementById('filterForm').submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 text-gray-700">
                    <option value="">Alle afdelingen</option>
                    <option value="service" {{ request('department') === 'service' ? 'selected' : '' }}>Service</option>
                    <option value="installation" {{ request('department') === 'installation' ? 'selected' : '' }}>Installatie</option>
                    <option value="meeting" {{ request('department') === 'meeting' ? 'selected' : '' }}>Meeting</option>
                </select>

                <button type="submit" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm">
                    Filteren
                </button>
            </form>

            <!-- Tickets Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Onderwerp</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klant</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioriteit</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Laatste update</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actie</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $ticket->feedback?->description ?? 'Geen onderwerp' }}</div>
                                <div class="text-sm text-gray-500">{{ ucfirst($ticket->catagory) }} — #TCK-{{ date('Y') }}-{{ str_pad($ticket->id, 3, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $ticket->feedback?->customer?->name_company ?? 'Onbekend' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $priority = $ticket->priority ?? 'medium';
                                @endphp
                                @if($priority === 'hoog')
                                    <span class="text-red-600 font-medium">Hoog</span>
                                @elseif($priority === 'medium')
                                    <span class="text-orange-600 font-medium">Medium</span>
                                @elseif($priority === 'laag')
                                    <span class="text-green-600 font-medium">Laag</span>
                                @else
                                    <span class="text-gray-600 font-medium">Geen</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($ticket->updated_at)->format('d M Y') }}</div>
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
                                <a href="{{ route('planner.tickets.show', $ticket->id) }}"
                                   class="text-indigo-600 hover:text-indigo-900 underline font-medium">
                                    Bekijk
                                </a>
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

            <!-- Pagination -->
            @if($tickets->hasPages())
            <div class="mt-6 flex justify-between items-center">
                <div class="text-sm text-gray-700">
                    Tonen {{ $tickets->firstItem() ?? 0 }}–{{ $tickets->lastItem() ?? 0 }} van {{ $tickets->total() }}
                </div>
                <div class="flex gap-1">
                    {{ $tickets->appends(request()->query())->links() }}
                </div>
            </div>
            @endif

            <!-- Bottom Link -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <a href="{{ route('planner.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium underline">
                    Terug naar wireframe
                </a>
            </div>
        </div>
    </main>
</x-layouts.app>

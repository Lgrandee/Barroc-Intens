<x-layouts.app :title="'Onderhoud overzicht'">
        <main class="p-6">
            <!-- Header -->
            <header class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Onderhoud overzicht</h1>
            </header>

            <!-- Main Content -->
            <div class="bg-[#f3f4f6] rounded-lg border border-gray-200 p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Onderhoudsactiviteiten</h2>
                    <p class="text-sm text-gray-600">Alle geplande en uitgevoerde onderhoudstaken</p>
                </div>

                <!-- Search and Filter -->
                <form method="GET" action="{{ route('technician.overzicht') }}" class="flex gap-3 mb-6" id="filterForm">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" id="searchInput" placeholder="Zoek op klant, taak of technicus..."
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                    </div>
                    <select name="status" id="statusFilter" onchange="document.getElementById('filterForm').submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 text-gray-700">
                        <option value="">Alle statussen</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="voltooid" {{ request('status') === 'voltooid' ? 'selected' : '' }}>Voltooid</option>
                    </select>
                    <button type="submit" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium text-sm">
                        Filter
                    </button>
                    <a href="{{ route('technician.planning') }}"
                       class="px-4 py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 font-medium text-sm whitespace-nowrap">
                        Naar planning
                    </a>
                    @if(request('search') || request('status'))
                    <a href="{{ route('technician.overzicht') }}"
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm">
                        Reset
                    </a>
                    @endif
                </form>

                <!-- Tasks Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#f3f4f6]">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taak</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technicus</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#f3f4f6] divide-y divide-gray-200">
                            @forelse($maintenanceTasks as $task)
                            <tr class="hover:bg-[#f3f4f6]"
                                data-customer="{{ $task->feedback?->customer?->name_company ?? 'Onbekend' }}"
                                data-technician="{{ $task->user?->name ?? 'Niet toegewezen' }}"
                                data-task="{{ $task->feedback?->description ?? 'Onderhoud' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($task->scheduled_time)->format('Y-m-d') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $task->feedback?->customer?->name_company ?? 'Onbekend' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $task->feedback?->description ?? 'Filter vervanging' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $task->user?->name ?? 'Niet toegewezen' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($task->status === 'voltooid')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#f3f4f6] text-green-800">
                                            Voltooid
                                        </span>
                                    @elseif($task->status === 'probleem')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#f3f4f6] text-red-800">
                                            Probleem
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#f3f4f6] text-orange-800">
                                            Open
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('technician.onderhoud.show', $task->id) }}"
                                       class="text-indigo-600 hover:text-indigo-900 underline">
                                        Bekijk
                                    </a>
                                    @if(\Carbon\Carbon::parse($task->scheduled_time)->isFuture())
                                    <span class="mx-2 text-gray-300">|</span>
                                    <a href="{{ route('technician.onderhoud.show', $task->id) }}#rapport"
                                       class="text-indigo-600 hover:text-indigo-900 underline">
                                        Rapport
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="mt-2">Geen onderhoudstaken gevonden</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($maintenanceTasks->hasPages())
                <div class="flex flex-col items-center gap-3 px-4 py-3 border-t border-gray-200 bg-[#f3f4f6] mt-4">
                    <div class="text-sm text-gray-700">
                        Showing {{ $maintenanceTasks->firstItem() ?? 0 }}–{{ $maintenanceTasks->lastItem() ?? 0 }} of {{ $maintenanceTasks->total() }}
                    </div>
                    <div class="flex gap-1 items-center">
                        @if($maintenanceTasks->onFirstPage())
                            <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">‹</span>
                        @else
                            <a href="{{ $maintenanceTasks->previousPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-[#f3f4f6]">‹</a>
                        @endif

                        @php
                            $currentPage = $maintenanceTasks->currentPage();
                            $lastPage = $maintenanceTasks->lastPage();
                            $start = max(1, $currentPage - 2);
                            $end = min($lastPage, $currentPage + 2);
                        @endphp

                        @if ($start > 1)
                            <a href="{{ $maintenanceTasks->url(1) }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-[#f3f4f6]">1</a>
                            @if ($start > 2)
                                <span class="px-2 text-gray-500">...</span>
                            @endif
                        @endif

                        @for ($page = $start; $page <= $end; $page++)
                            @if ($page == $currentPage)
                                <span class="px-3 py-1 border border-indigo-600 bg-indigo-600 text-white rounded text-sm font-medium">{{ $page }}</span>
                            @else
                                <a href="{{ $maintenanceTasks->url($page) }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-[#f3f4f6]">{{ $page }}</a>
                            @endif
                        @endfor

                        @if ($end < $lastPage)
                            @if ($end < $lastPage - 1)
                                <span class="px-2 text-gray-500">...</span>
                            @endif
                            <a href="{{ $maintenanceTasks->url($lastPage) }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-[#f3f4f6]">{{ $lastPage }}</a>
                        @endif

                        @if($maintenanceTasks->hasMorePages())
                            <a href="{{ $maintenanceTasks->nextPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-[#f3f4f6]">›</a>
                        @else
                            <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">›</span>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Bottom Link -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <a href="{{ route('technician.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium underline">
                        Terug naar Sitemap
                    </a>
                </div>
            </div>
        </main>
</x-layouts.app>

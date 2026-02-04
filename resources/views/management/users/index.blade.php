<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikersbeheer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Light-only page background override */
    </style>
</head>
<body class="bg-gray-50">
    <x-layouts.app :title="'Werknemers Beheer'">
        <main class="p-6 min-h-screen">
            <header class="mb-6 flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-semibold text-black dark:text-white">Werknemers Beheer</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Beheer alle werknemers en hun rechten</p>
                </div>
            </header>

            <!-- Action Buttons -->
            <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow overflow-hidden mb-6">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900 flex-wrap gap-3">
                    <a href="{{ route('management.users.create') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-3 py-1.5 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                        <span class="inline-block h-2 w-2 rounded-full bg-black"></span>
                        Nieuwe Werknemer
                    </a>
                    <button onclick="openImportModal()" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-semibold text-black dark:text-white border border-gray-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                        Bulk Import
                    </button>
                    <a href="{{ route('management.users.export') }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-semibold text-black dark:text-white border border-gray-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                        Export Lijst
                    </a>
                    <div class="ml-auto">
                        <a href="{{ route('management.roles.index') }}" class="inline-flex items-center gap-2 rounded-md border border-gray-300 dark:border-zinc-600 px-3 py-1.5 text-sm font-semibold text-black dark:text-white bg-white dark:bg-zinc-800 shadow hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                            👑 Bekijk Rollen
                        </a>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden mb-6 p-4">
                <div class="flex gap-3 flex-wrap">
                    <div class="relative flex-1 min-w-48">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" id="searchInput" placeholder="Zoek op naam of e-mail..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-200 dark:border-zinc-700 rounded-lg bg-gray-50 dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 focus:border-transparent dark:focus:border-transparent">
                    </div>
                    <select id="roleFilter" class="px-4 py-2 border border-gray-200 dark:border-zinc-700 rounded-lg bg-gray-50 dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900">
                        <option value="">Alle Rollen</option>
                        <option value="Sales">Sales</option>
                        <option value="Purchasing">Purchasing</option>
                        <option value="Finance">Finance</option>
                        <option value="Technician">Technician</option>
                        <option value="Planner">Planner</option>
                        <option value="Management">Management</option>
                    </select>
                    <select id="statusFilter" class="px-4 py-2 border border-gray-200 dark:border-zinc-700 rounded-lg bg-gray-50 dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900">
                        <option value="">Alle Statussen</option>
                        <option value="active">Actief</option>
                        <option value="inactive">Inactief</option>
                        <option value="vacation">Vakantie</option>
                    </select>
                    <button id="resetFiltersButton" type="button" onclick="resetFilters()" class="hidden px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-300 dark:bg-zinc-700 dark:text-gray-200 dark:hover:bg-zinc-600">
                        Reset
                    </button>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                    <thead class="bg-gray-50 dark:bg-zinc-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Werknemer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Rol</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Laatst Actief</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-zinc-700">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700" data-role="{{ $user->department }}" data-status="{{ $user->status }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @php
                                            $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#14b8a6'];
                                            $avatarColor = $colors[$user->id % count($colors)];
                                        @endphp
                                        <div class="h-10 w-10 rounded-full flex items-center justify-center text-white font-semibold text-lg"
                                            style="background-color: {{ $avatarColor }}">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">ID: #{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $user->email }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->phone_num ?? 'Geen telefoon' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($user->department === 'Sales') bg-green-100 text-green-800
                                    @elseif($user->department === 'Purchasing') bg-purple-100 text-purple-800
                                    @elseif($user->department === 'Finance') bg-yellow-100 text-yellow-800
                                    @elseif($user->department === 'Technician') bg-pink-100 text-pink-800
                                    @elseif($user->department === 'Planner') bg-indigo-100 text-indigo-800
                                    @elseif($user->department === 'Management') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $user->department }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->status === 'active')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Actief
                                    </span>
                                @elseif($user->status === 'vacation')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Vakantie
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactief
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->last_active ? $user->last_active->format('d-m-Y, H:i') : 'Nooit' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('management.users.edit', $user->id) }}"
                                        class="text-orange-500 hover:text-orange-700 text-lg" title="Bewerken">
                                        ✏️
                                    </a>
                                    <form method="POST" action="{{ route('management.users.destroy', $user->id) }}" onsubmit="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-lg" title="Verwijderen">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <p class="mt-2">Geen werknemers gevonden</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="flex flex-col items-center gap-3 px-4 py-3 border-t border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        Showing {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} of {{ $users->total() }}
                    </div>
                    <div class="flex gap-1 items-center">
                        @if($users->onFirstPage())
                            <span class="px-3 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm text-gray-400 dark:text-gray-600 cursor-not-allowed">‹</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="px-3 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700">‹</a>
                        @endif

                        @php
                            $currentPage = $users->currentPage();
                            $lastPage = $users->lastPage();
                            $start = max(1, $currentPage - 2);
                            $end = min($lastPage, $currentPage + 2);
                        @endphp

                        @if ($start > 1)
                            <a href="{{ $users->url(1) }}" class="px-3 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700">1</a>
                            @if ($start > 2)
                                <span class="px-2 text-gray-500 dark:text-gray-400">...</span>
                            @endif
                        @endif

                        @for ($page = $start; $page <= $end; $page++)
                            @if ($page == $currentPage)
                                <span class="px-3 py-1 border border-yellow-400 bg-yellow-400 text-black rounded text-sm font-medium">{{ $page }}</span>
                            @else
                                <a href="{{ $users->url($page) }}" class="px-3 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700">{{ $page }}</a>
                            @endif
                        @endfor

                        @if ($end < $lastPage)
                            @if ($end < $lastPage - 1)
                                <span class="px-2 text-gray-500 dark:text-gray-400">...</span>
                            @endif
                            <a href="{{ $users->url($lastPage) }}" class="px-3 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700">{{ $lastPage }}</a>
                        @endif

                        @if($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="px-3 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700">›</a>
                        @else
                            <span class="px-3 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm text-gray-400 dark:text-gray-600 cursor-not-allowed">›</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Import Modal (New) -->
            <div id="importModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen px-4 text-center">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="closeImportModal()" style="background-color: rgba(0, 0, 0, 0.2); backdrop-filter: blur(4px);"></div>

                    <!-- Modal Panel -->
                    <div class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl dark:bg-zinc-900 rounded-2xl ring-1 ring-black/5">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="modal-title">Werknemers Importeren</h3>
                            <button onclick="closeImportModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <form action="{{ route('management.users.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-6">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    Upload een CSV bestand om meerdere werknemers tegelijk te importeren.
                                </p>

                                <div class="relative flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-zinc-700 rounded-xl hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors cursor-pointer group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-yellow-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik om te uploaden</span> of sleep bestand</p>
                                    </div>
                                    <input type="file" name="file" required accept=".csv,.txt" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                </div>
                                <div class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                                    Verwacht formaat: <code class="bg-gray-100 dark:bg-zinc-800 px-1 py-0.5 rounded text-gray-600 dark:text-gray-300 font-mono">ID;Naam;Email;Telefoon;Afdeling;Status</code>
                                </div>
                            </div>

                            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                                <button type="button" onclick="closeImportModal()" class="w-full sm:w-auto px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-700 border border-gray-200 dark:border-zinc-700 rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200">
                                    Annuleren
                                </button>
                                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 text-sm font-semibold text-black bg-yellow-400 hover:bg-yellow-300 rounded-xl shadow-sm transition-all transform hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                                    Importeren
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer text -->
            <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
                Werknemers overzicht — beheer en rechten
            </div>
        </main>
    </x-layouts.app>

    <script>
        function openImportModal() {
            document.getElementById('importModal').classList.remove('hidden');
        }

        function closeImportModal() {
            document.getElementById('importModal').classList.add('hidden');
        }

        // Combined search and filter functionality
        const searchInput = document.getElementById('searchInput');
        const roleFilter = document.getElementById('roleFilter');
        const statusFilter = document.getElementById('statusFilter');
        const resetFiltersButton = document.getElementById('resetFiltersButton');

        function updateResetButton() {
            const hasFilters = (searchInput?.value || roleFilter?.value || statusFilter?.value);
            if (resetFiltersButton) {
                resetFiltersButton.classList.toggle('hidden', !hasFilters);
            }
        }

        function filterTable() {
            const searchTerm = searchInput?.value.toLowerCase() || '';
            const selectedRole = roleFilter?.value || '';
            const selectedStatus = statusFilter?.value || '';
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                // Skip empty state row
                if (!row.dataset.role && !row.dataset.status) {
                    return;
                }

                const text = row.textContent.toLowerCase();
                const rowRole = row.dataset.role || '';
                const rowStatus = row.dataset.status || '';

                const matchesSearch = text.includes(searchTerm);
                const matchesRole = !selectedRole || rowRole === selectedRole;
                const matchesStatus = !selectedStatus || rowStatus === selectedStatus;

                row.style.display = (matchesSearch && matchesRole && matchesStatus) ? '' : 'none';
            });

            updateResetButton();
        }

        function resetFilters() {
            if (searchInput) searchInput.value = '';
            if (roleFilter) roleFilter.value = '';
            if (statusFilter) statusFilter.value = '';
            filterTable();
        }

        // Attach event listeners
        searchInput?.addEventListener('input', filterTable);
        roleFilter?.addEventListener('change', filterTable);
        statusFilter?.addEventListener('change', filterTable);

        updateResetButton();
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikersbeheer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <x-layouts.app :title="'Werknemers Beheer'">
        <main class="p-6">
            <header class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Werknemers Beheer</h1>
                <p class="text-sm text-gray-500">Beheer alle werknemers en hun rechten</p>
            </header>

            <!-- Action Buttons -->
            <div class="flex gap-3 mb-6">
                <a href="{{ route('management.users.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 font-medium text-sm">
                    + Nieuwe Werknemer
                </a>
                <button class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50 font-medium text-sm">
                    Bulk Import
                </button>
                <button class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50 font-medium text-sm">
                    Export Lijst
                </button>
                <div class="ml-auto">
                    <a href="{{ route('management.roles.index') }}" class="px-4 py-2 border border-indigo-600 text-indigo-600 rounded hover:bg-indigo-50 font-medium text-sm">
                        👑 Bekijk Rollen
                    </a>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="flex gap-3 mb-6">
                <div class="relative flex-1 max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" id="searchInput" placeholder="Zoek op naam of e-mail..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <select id="roleFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-700">
                    <option value="">Alle Rollen</option>
                    <option value="Sales">Sales</option>
                    <option value="Purchasing">Purchasing</option>
                    <option value="Finance">Finance</option>
                    <option value="Technician">Technician</option>
                    <option value="Planner">Planner</option>
                    <option value="Management">Management</option>
                </select>
                <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-700">
                    <option value="">Alle Statussen</option>
                    <option value="active">Actief</option>
                    <option value="inactive">Inactief</option>
                    <option value="vacation">Vakantie</option>
                </select>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Werknemer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Laatst Actief</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50" data-role="{{ $user->department }}" data-status="{{ $user->status }}">
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
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">ID: #{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                <div class="text-xs text-gray-500">{{ $user->phone_num ?? 'Geen telefoon' }}</div>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->last_active ? $user->last_active->format('d-m-Y, H:i') : 'Nooit' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('management.users.edit', $user->id) }}"
                                        class="text-orange-500 hover:text-orange-700 text-lg" title="Bewerken">
                                        ✏️
                                    </a>
                                    <button class="text-orange-500 hover:text-orange-700 text-lg" title="Reset wachtwoord">
                                        🔑
                                    </button>
                                    <button class="text-gray-400 hover:text-gray-600 text-lg" title="Meer opties">
                                        ⋮
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
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
                <div class="flex flex-col items-center gap-3 px-4 py-3 border-t border-gray-200 bg-gray-50">
                    <div class="text-sm text-gray-700">
                        Showing {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} of {{ $users->total() }}
                    </div>
                    <div class="flex gap-1 items-center">
                        @if($users->onFirstPage())
                            <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">‹</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">‹</a>
                        @endif

                        @php
                            $currentPage = $users->currentPage();
                            $lastPage = $users->lastPage();
                            $start = max(1, $currentPage - 2);
                            $end = min($lastPage, $currentPage + 2);
                        @endphp

                        @if ($start > 1)
                            <a href="{{ $users->url(1) }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">1</a>
                            @if ($start > 2)
                                <span class="px-2 text-gray-500">...</span>
                            @endif
                        @endif

                        @for ($page = $start; $page <= $end; $page++)
                            @if ($page == $currentPage)
                                <span class="px-3 py-1 border border-indigo-600 bg-indigo-600 text-white rounded text-sm font-medium">{{ $page }}</span>
                            @else
                                <a href="{{ $users->url($page) }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">{{ $page }}</a>
                            @endif
                        @endfor

                        @if ($end < $lastPage)
                            @if ($end < $lastPage - 1)
                                <span class="px-2 text-gray-500">...</span>
                            @endif
                            <a href="{{ $users->url($lastPage) }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">{{ $lastPage }}</a>
                        @endif

                        @if($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">›</a>
                        @else
                            <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">›</span>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </x-layouts.app>

    <script>
        // Combined search and filter functionality
        const searchInput = document.getElementById('searchInput');
        const roleFilter = document.getElementById('roleFilter');
        const statusFilter = document.getElementById('statusFilter');

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
        }

        // Attach event listeners
        searchInput?.addEventListener('input', filterTable);
        roleFilter?.addEventListener('change', filterTable);
        statusFilter?.addEventListener('change', filterTable);
    </script>
</body>
</html>

<div class="p-6">
    <header class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Rollen Beheer</h1>
        <p class="text-sm text-gray-500">Beheer gebruikersrollen en permissies</p>
    </header>

    @if (session()->has('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex gap-3 mb-6">
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 font-medium text-sm transition flex items-center gap-2">
            <span>+</span> Nieuwe Rol
        </button>
        <!-- Removed "Rolgroepen" and "Permissie Instellingen" buttons as requested -->
        <div class="ml-auto">
            <a href="{{ route('management.users.index') }}" class="px-4 py-2 border border-indigo-600 text-indigo-600 rounded hover:bg-indigo-50 font-medium text-sm transition">
                👥 Bekijk Werknemers
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" placeholder="Zoek op rol of permissie..."
                class="w-full md:w-96 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
    </div>

    <!-- Roles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($roles as $role)
        <div class="bg-white rounded-lg border border-gray-200 p-6 flex flex-col h-full shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-4">
                <div class="text-3xl">
                    @if(stripos($role->name, 'Admin') !== false) 👑
                    @elseif(stripos($role->name, 'Sales') !== false) 💼
                    @elseif(stripos($role->name, 'Finance') !== false) 💰
                    @elseif(stripos($role->name, 'Technician') !== false || stripos($role->name, 'Service') !== false) 🔧
                    @elseif(stripos($role->name, 'Planner') !== false) 📅
                    @else 🛡️
                    @endif
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $role->label ?? $role->name }}</h3>
                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-800 rounded">{{ $role->name }}</span>
                </div>
            </div>

            <div class="mb-4 grow">
                <p class="text-sm text-gray-600">{{ $role->description ?? 'Geen beschrijving' }}</p>
                <div class="mt-2">
                    <span class="text-xs text-gray-500">{{ is_array($role->permissions) ? count($role->permissions) : 0 }} permissies actief</span>
                </div>
            </div>

            <div class="flex gap-2 pt-4 border-t mt-auto">
                <button wire:click="edit({{ $role->id }})" class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded text-gray-700 hover:bg-gray-50 transition">
                    Bewerken
                </button>
                <button wire:click="edit({{ $role->id }})" class="flex-1 px-3 py-2 text-sm border border-indigo-200 text-indigo-700 hover:bg-indigo-50 transition">
                    Permissies
                </button>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 text-gray-500">
            Geen rollen gevonden. Maak er een aan!
        </div>
        @endforelse
    </div>

    <!-- Role Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showModal', false)"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="relative z-10 inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full" x-on:click.stop>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ $isEditing ? 'Rol Bewerken' : 'Nieuwe Rol Aanmaken' }}
                            </h3>
                            
                            <div class="mt-4 space-y-4">
                                <!-- Basic Info -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Display Naam</label>
                                        <input type="text" wire:model="label" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Bijv. Administratie">
                                        @error('label') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Systeem Naam (Uniek)</label>
                                        <input type="text" wire:model="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Bijv. Admin">
                                        @error('name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-span-full">
                                        <label class="block text-sm font-medium text-gray-700">Beschrijving</label>
                                        <textarea wire:model="description" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Korte beschrijving van de rol..."></textarea>
                                    </div>
                                </div>

                                <!-- Permissions Section -->
                                <div class="mt-6 border-t pt-4">
                                    <h4 class="text-md font-medium text-gray-900 mb-3">Permissies & Toegang</h4>
                                    <div class="h-64 overflow-y-auto border rounded-md p-4 bg-gray-50">
                                        @foreach($availablePermissions as $category => $perms)
                                            <div class="mb-4">
                                                <h5 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-2 border-b">{{ $category }}</h5>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                    @foreach($perms as $key => $label)
                                                        <label class="inline-flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-1 rounded">
                                                            <input type="checkbox" wire:model="selectedPermissions" value="{{ $key }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                            <span class="text-sm text-gray-700">{{ $label }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse justify-between">
                    <div class="flex flex-row-reverse gap-2">
                        <button type="button" wire:click="save" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ $isEditing ? 'Wijzigingen Opslaan' : 'Aanmaken' }}
                        </button>
                        <button type="button" wire:click="$set('showModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Annuleren
                        </button>
                    </div>
                    @if($isEditing)
                    <button type="button" wire:confirm="Weet je zeker dat je deze rol wilt verwijderen?" wire:click="delete({{ $roleId }})" class="mt-3 w-full inline-flex justify-center rounded-md border border-red-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Verwijderen
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

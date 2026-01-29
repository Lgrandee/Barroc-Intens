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

    <!-- Action Buttons, Search and Filters in one bar -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <div class="flex items-center justify-between px-5 py-4 bg-gray-50 flex-wrap gap-3">
            <div class="relative flex-1 min-w-48 max-w-sm">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" wire:model.live="search" wire:model.debounce.10ms="search" placeholder="Zoek op rol of permissie..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
            </div>

            <div class="flex items-center gap-3 ml-auto">
                <a href="{{ route('management.users.index') }}" class="inline-flex items-center gap-2 rounded-md border border-gray-300 px-3 py-1.5 text-sm font-semibold text-black bg-white shadow hover:bg-gray-50 transition-colors">
                    👥 Bekijk Werknemers
                </a>
                <button wire:click="create" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-3 py-1.5 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                    <span class="inline-block h-2 w-2 rounded-full bg-black"></span>
                    Nieuwe Rol
                </button>
            </div>
        </div>
    </div>

    <!-- Roles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($roles as $role)
        <div class="bg-white rounded-lg border border-gray-200 p-6 flex flex-col h-full shadow-md hover:shadow-lg transition">
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
                <button wire:click="edit({{ $role->id }})" class="flex-1 px-3 py-2 text-sm rounded-md bg-yellow-400 text-black hover:bg-yellow-300 transition font-semibold shadow">
                    Bewerken
                </button>
                <button wire:click="preview({{ $role->id }})" class="flex-1 px-3 py-2 text-sm rounded-md bg-gray-200 text-black hover:bg-gray-300 transition">
                    Bekijk Rechten
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
            <div class="fixed inset-0 transition-opacity" style="background-color: rgba(0, 0, 0, 0.3);" aria-hidden="true" wire:click="$set('showModal', false)"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="relative z-10 inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full ring-1 ring-black ring-opacity-5" x-on:click.stop>
                <!-- Modal Header -->
                <div class="bg-white/80 backdrop-blur-md px-8 py-6 border-b border-gray-100 flex items-center justify-between sticky top-0 z-20">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 tracking-tight" id="modal-title">
                            @if($viewOnly)
                                Rol Details & Rechten
                            @else
                                {{ $isEditing ? 'Rol Bewerken' : 'Nieuwe Rol Aanmaken' }}
                            @endif
                        </h3>
                        <p class="text-sm text-gray-500 mt-1 font-medium">
                            @if($viewOnly)
                                Bekijk de details en gekoppelde permissies van deze rol.
                            @else
                                Beheer de instellingen en toegangsrechten voor deze rol.
                            @endif
                        </p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="p-2 -mr-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-all focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-8 py-8 max-h-[70vh] overflow-y-auto custom-scrollbar bg-white">
                    <div class="space-y-8">
                        <!-- Basic Info Section -->
                        <div>
                            <h3 class="text-base font-bold text-gray-900 mb-6 pb-3 border-b-2 border-gray-200">Rol Informatie</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Display Naam</label>
                                        <input type="text" wire:model="label"
                                        class="block w-full rounded-lg border border-gray-300 bg-white focus:bg-white focus:border-gray-400 focus:ring-2 focus:ring-gray-300/20 sm:text-sm transition-all py-3 px-4
                                            disabled:opacity-60 disabled:cursor-not-allowed"
                                            placeholder="Bijv. Administratie" {{ $viewOnly ? 'disabled' : '' }}>
                                        @error('label') <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Systeem Naam <span class="text-xs text-gray-400 font-normal ml-1">(Uniek)</span>
                                        </label>
                                        <input type="text" wire:model="name"
                                            class="block w-full rounded-lg border border-gray-300 bg-white focus:bg-white focus:border-gray-400 focus:ring-2 focus:ring-gray-300/20 sm:text-sm transition-all py-3 px-4
                                            disabled:opacity-60 disabled:cursor-not-allowed"
                                            placeholder="Bijv. Admin" {{ $viewOnly ? 'disabled' : '' }}>
                                        @error('name') <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Beschrijving</label>
                                    <textarea wire:model="description" rows="5"
                                        class="block w-full rounded-lg border border-gray-300 bg-white focus:bg-white focus:border-gray-400 focus:ring-2 focus:ring-gray-300/20 sm:text-sm transition-all py-3 px-4 resize-none
                                        disabled:opacity-60 disabled:cursor-not-allowed"
                                        placeholder="Beschrijf het doel en de verantwoordelijkheden van deze rol..." {{ $viewOnly ? 'disabled' : '' }}></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Permissions Section -->
                        <div>
                            <h3 class="text-base font-bold text-gray-900 mb-6 pb-3 border-b-2 border-gray-200">Permissies & Toegang</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($availablePermissions as $category => $perms)
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:border-gray-300 transition-colors group">
                                        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-200">
                                            <span class="text-xs font-bold text-gray-700 bg-gray-200 px-3 py-1.5 rounded-md uppercase tracking-wider">{{ $category }}</span>
                                        </div>
                                        <div class="space-y-2">
                                            @foreach($perms as $key => $label)
                                                <label class="flex items-center p-2 rounded-xl transition-all duration-200 {{ $viewOnly ? 'cursor-default opacity-75' : 'cursor-pointer hover:bg-white hover:shadow-sm' }} group/checkbox">
                                                    <div class="relative flex items-center justify-center">
                                                        <input type="checkbox" wire:model="selectedPermissions" value="{{ $key }}"
                                                            class="peer sr-only"
                                                            {{ $viewOnly ? 'disabled' : '' }}>

                                                        <!-- Custom Checkbox Visual -->
                                                        <div class="h-5 w-5 rounded-md border-2 border-gray-300 bg-white transition-all duration-200
                                                            peer-checked:bg-yellow-400 peer-checked:border-yellow-400
                                                            peer-focus:ring-2 peer-focus:ring-yellow-400/30 peer-focus:ring-offset-1
                                                            {{ $viewOnly ? 'peer-checked:bg-gray-400 peer-checked:border-gray-400' : '' }}">
                                                        </div>

                                                        <!-- Checkmark Icon -->
                                                        <svg class="absolute w-3.5 h-3.5 pointer-events-none hidden peer-checked:block text-black stroke-current transition-opacity duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M20 6L9 17l-5-5"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="ml-3 text-sm font-medium text-gray-700 peer-checked:text-gray-900 transition-colors">
                                                        {{ $label }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50/50 backdrop-blur-sm px-8 py-5 flex items-center justify-between border-t border-gray-100">
                    <div>
                        @if($isEditing && !$viewOnly)
                        <button type="button" wire:confirm="Weet je zeker dat je deze rol wilt verwijderen?" wire:click="delete({{ $roleId }})"
                            class="group inline-flex items-center justify-center px-4 py-2 border border-red-100 text-sm font-medium rounded-xl text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all">
                            <svg class="w-4 h-4 mr-2 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Verwijderen
                        </button>
                        @endif
                    </div>
                    <div class="flex gap-4">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="inline-flex items-center px-5 py-2.5 border border-gray-200 shadow-sm text-sm font-semibold rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all">
                            {{ $viewOnly ? 'Sluiten' : 'Annuleren' }}
                        </button>
                        @if(!$viewOnly)
                        <button type="button" wire:click="save"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-semibold rounded-xl shadow-lg shadow-yellow-400/30 text-black bg-yellow-400 hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition-all transform hover:-translate-y-0.5">
                            {{ $isEditing ? 'Wijzigingen Opslaan' : 'Rol Aanmaken' }}
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

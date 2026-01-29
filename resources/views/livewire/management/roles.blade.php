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
                <button wire:click="preview({{ $role->id }})" class="flex-1 px-3 py-2 text-sm border border-indigo-200 text-indigo-700 hover:bg-indigo-50 transition">
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
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showModal', false)"></div>

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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Display Naam</label>
                                    <input type="text" wire:model="label" 
                                        class="block w-full rounded-xl border-transparent bg-gray-100 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:text-sm transition-all py-3 px-4
                                        disabled:opacity-60 disabled:cursor-not-allowed" 
                                        placeholder="Bijv. Administratie" {{ $viewOnly ? 'disabled' : '' }}>
                                    @error('label') <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Systeem Naam <span class="text-xs text-gray-400 font-normal ml-1">(Uniek)</span>
                                    </label>
                                    <input type="text" wire:model="name" 
                                        class="block w-full rounded-xl border-transparent bg-gray-100 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:text-sm transition-all py-3 px-4
                                        disabled:opacity-60 disabled:cursor-not-allowed" 
                                        placeholder="Bijv. Admin" {{ $viewOnly ? 'disabled' : '' }}>
                                    @error('name') <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Beschrijving</label>
                                <textarea wire:model="description" rows="5" 
                                    class="block w-full rounded-xl border-transparent bg-gray-100 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:text-sm transition-all py-3 px-4 resize-none
                                    disabled:opacity-60 disabled:cursor-not-allowed" 
                                    placeholder="Beschrijf het doel en de verantwoordelijkheden van deze rol..." {{ $viewOnly ? 'disabled' : '' }}></textarea>
                            </div>
                        </div>

                        <!-- Permissions Section -->
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <h4 class="text-lg font-bold text-gray-900 tracking-tight">Permissies & Toegang</h4>
                                <div class="h-px flex-1 bg-gray-100"></div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($availablePermissions as $category => $perms)
                                    <div class="bg-gray-50/50 rounded-2xl p-4 border border-gray-100 hover:border-indigo-100 transition-colors group">
                                        <div class="flex items-center gap-2 mb-3 pb-2 border-b border-gray-100">
                                            <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg uppercase tracking-wider">{{ $category }}</span>
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
                                                            peer-checked:bg-indigo-600 peer-checked:border-indigo-600 
                                                            peer-focus:ring-2 peer-focus:ring-indigo-500/30 peer-focus:ring-offset-1
                                                            {{ $viewOnly ? 'peer-checked:bg-gray-400 peer-checked:border-gray-400' : '' }}">
                                                        </div>

                                                        <!-- Checkmark Icon -->
                                                        <svg class="absolute w-3.5 h-3.5 pointer-events-none hidden peer-checked:block text-white stroke-current transition-opacity duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
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
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/30 text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
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

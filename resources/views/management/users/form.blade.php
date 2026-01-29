<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($user) ? 'Werknemer Bewerken' : 'Nieuwe Werknemer' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Light-only page background override */
    </style>
</head>
<body class="bg-gray-50">
    <x-layouts.app :title="isset($user) ? 'Werknemer Bewerken' : 'Nieuwe Werknemer'">
        <main class="p-6 min-h-screen max-w-4xl mx-auto">
            <!-- Header -->
            <header class="mb-6">
                <div class="text-center mb-4">
                    <h1 class="text-3xl font-semibold text-black dark:text-white">
                        {{ isset($user) ? 'Werknemer Bewerken' : 'Nieuwe Werknemer Aanmaken' }}
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        {{ isset($user) ? 'Pas de werknemergegevens aan' : 'Vul de gegevens in voor de nieuwe werknemer' }}
                    </p>
                </div>
                <a href="{{ route('management.users.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                    Terug naar overzicht
                </a>
            </header>

            <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
                <div class="p-6">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif

                    <!-- Profile Picture -->
                    <div class="mb-6 pb-6 border-b border-gray-200 dark:border-zinc-700">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Profielfoto</label>
                        <div class="flex items-center gap-4">
                        <div class="h-20 w-20 rounded-full overflow-hidden bg-gray-100 dark:bg-zinc-700 flex items-center justify-center">
                                @php
                                    $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#14b8a6'];
                                    $avatarColor = isset($user) ? $colors[$user->id % count($colors)] : '#6366f1';
                                @endphp
                                <div id="avatarPreview" class="h-full w-full flex items-center justify-center text-white font-bold text-2xl"
                                     style="background-color: {{ $avatarColor }}">
                                    {{ isset($user) ? strtoupper(substr($user->name, 0, 1)) : '?' }}
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Avatar wordt automatisch gegenereerd op basis van de eerste letter van de naam.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="mb-6 pb-6 border-b border-gray-200 dark:border-zinc-700">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Persoonlijke Gegevens</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Volledige Naam <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Vul hier uw naam in...">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    E-mailadres <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="naam@barroc.nl">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Telefoonnummer
                                </label>
                                <input type="tel" name="phone_num" value="{{ old('phone_num', $user->phone_num ?? '') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="+31 6 12345678">
                                @error('phone_num')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @if(isset($user))
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Werknemer ID
                                </label>
                                <input type="text" value="#{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}" disabled
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-gray-50 dark:bg-zinc-700 text-gray-500 dark:text-gray-400">
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Role and Access -->
                    <div class="mb-6 pb-6 border-b border-gray-200 dark:border-zinc-700">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Rol en Toegang</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Rol/Afdeling <span class="text-red-500">*</span>
                                </label>
                                <select name="department" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                    <option value="">Selecteer rol...</option>
                                    <option value="Sales" {{ (old('department', $user->department ?? '') === 'Sales') ? 'selected' : '' }}>Sales - Verkoop medewerker</option>
                                    <option value="Purchasing" {{ (old('department', $user->department ?? '') === 'Purchasing') ? 'selected' : '' }}>Purchasing - Inkoop medewerker</option>
                                    <option value="Finance" {{ (old('department', $user->department ?? '') === 'Finance') ? 'selected' : '' }}>Finance - Financieel medewerker</option>
                                    <option value="Technician" {{ (old('department', $user->department ?? '') === 'Technician') ? 'selected' : '' }}>Technician - Technische dienst</option>
                                    <option value="Planner" {{ (old('department', $user->department ?? '') === 'Planner') ? 'selected' : '' }}>Planner - Planning medewerker</option>
                                    <option value="Management" {{ (old('department', $user->department ?? '') === 'Management') ? 'selected' : '' }}>Management - Management</option>
                                </select>
                                @error('department')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                    <option value="active" {{ (old('status', $user->status ?? 'active') === 'active') ? 'selected' : '' }}>🟢 Actief</option>
                                    <option value="vacation" {{ (old('status', $user->status ?? '') === 'vacation') ? 'selected' : '' }}>🟡 Vakantie</option>
                                    <option value="inactive" {{ (old('status', $user->status ?? '') === 'inactive') ? 'selected' : '' }}>🔴 Inactief</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Password Section -->
                    @if(!isset($user))
                    <div class="mb-6 pb-6 border-b border-gray-200 dark:border-zinc-700">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Wachtwoord</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Wachtwoord <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent pr-10"
                                        placeholder="••••••••" oninput="checkPasswordStrength()">
                                    <button type="button" onclick="togglePassword('password', this)" tabindex="-1" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 dark:text-gray-500 hover:text-yellow-500 dark:hover:text-yellow-400">
                                        <svg id="icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-2 mb-1">
                                    <span class="block text-xs font-semibold text-gray-700 mb-1">Wachtwoord Criteria</span>
                                    <ul class="text-xs text-gray-600 list-disc list-inside">
                                        <li>Minimaal 8 tekens lang</li>
                                        <li>Minimaal 1 hoofdletter</li>
                                        <li>Minimaal 1 cijfer</li>
                                        <li>Minimaal 1 speciaal teken</li>
                                        <li>Mag niet overeenkomen met persoonsinformatie</li>
                                    </ul>
                                </div>
                                <p id="password-strength-message" class="text-xs mt-1"></p>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Bevestig Wachtwoord <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent pr-10"
                                        placeholder="••••••••" onblur="checkPasswordMatch()">
                                    <button type="button" onclick="togglePassword('password_confirmation', this)" tabindex="-1" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 dark:text-gray-500 hover:text-yellow-500 dark:hover:text-yellow-400">
                                        <svg id="icon-password_confirmation" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <p id="password-match-message" class="text-xs mt-1"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="mb-6 pb-6 border-b border-gray-200 dark:border-zinc-700">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Wachtwoord Wijzigen (optioneel)</h3>
                        <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                            <p class="text-sm text-blue-800 dark:text-blue-200">Laat leeg om het huidige wachtwoord te behouden.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Nieuw Wachtwoord
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="edit_password"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent pr-10"
                                        placeholder="••••••••" oninput="checkEditPasswordStrength()">
                                    <button type="button" onclick="togglePassword('edit_password', this)" tabindex="-1" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 dark:text-gray-500 hover:text-yellow-500 dark:hover:text-yellow-400">
                                        <svg id="icon-edit_password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-2 mb-1">
                                    <span class="block text-xs font-semibold text-gray-700 mb-1">Wachtwoord Criteria</span>
                                    <ul class="text-xs text-gray-600 list-disc list-inside">
                                        <li>Minimaal 8 tekens lang</li>
                                        <li>Minimaal 1 hoofdletter</li>
                                        <li>Minimaal 1 cijfer</li>
                                        <li>Minimaal 1 speciaal teken</li>
                                        <li>Mag niet overeenkomen met naam of e-mail</li>
                                    </ul>
                                </div>
                                <p id="edit-password-strength-message" class="text-xs mt-1"></p>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Bevestig Nieuw Wachtwoord
                                </label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="edit_password_confirmation"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent pr-10"
                                        placeholder="••••••••" onblur="checkPasswordMatch()">
                                    <button type="button" onclick="togglePassword('edit_password_confirmation', this)" tabindex="-1" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 dark:text-gray-500 hover:text-yellow-500 dark:hover:text-yellow-400">
                                        <svg id="icon-edit_password_confirmation" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <p id="password-match-message" class="text-xs mt-1"></p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Additional Options -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Extra Opties</h3>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="send_welcome_email" value="1" checked
                                    class="rounded border-gray-300 dark:border-zinc-600 text-yellow-500 focus:ring-yellow-400">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Stuur welkomst e-mail naar werknemer</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="force_password_change" value="1"
                                    class="rounded border-gray-300 dark:border-zinc-600 text-yellow-500 focus:ring-yellow-400">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Verplicht wachtwoord wijzigen bij eerste login</span>
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center pt-4">
                        <a href="{{ route('management.users.index') }}"
                            class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline">
                            Annuleren
                        </a>
                        @if(isset($user))
                            <button type="button" onclick="confirmDelete()"
                                class="px-6 py-2 border border-red-700 bg-red-600 text-white rounded hover:bg-red-700 font-bold transition">
                                Verwijderen
                            </button>
                        @endif
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"/></svg>
                            {{ isset($user) ? 'Wijzigingen Opslaan' : 'Werknemer Aanmaken' }}
                        </button>
                    </div>
                </form>

                @if(isset($user))
                <!-- Delete Form (hidden) -->
                <form id="deleteForm" action="{{ route('management.users.destroy', $user->id) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
                @endif
                </div>
            </div>

            <!-- Footer text -->
            <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
                Werknemers — vul zorgvuldig alle gegevens in voor een nieuwe werknemer
            </div>
        </main>
    </x-layouts.app>

    <script>
        // Show/hide password fields
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            if (!input) return;
            if (input.type === 'password') {
                input.type = 'text';
                btn.querySelector('svg').classList.add('text-yellow-500');
            } else {
                input.type = 'password';
                btn.querySelector('svg').classList.remove('text-yellow-500');
            }
        }

        // Password match check
        function checkPasswordMatch() {
            const pw = document.getElementById('password') || document.getElementById('edit_password');
            const pwConf = document.getElementById('password_confirmation') || document.getElementById('edit_password_confirmation');
            const msg = document.getElementById('password-match-message');
            if (!pw || !pwConf || !msg) return;
            if (pw.value.length === 0) {
                msg.textContent = '';
                msg.className = 'text-xs mt-1';
                return;
            }
            if (pw.value === pwConf.value) {
                msg.textContent = 'Wachtwoorden komen overeen';
                msg.className = 'text-xs mt-1 text-green-600';
            } else {
                msg.textContent = 'Wachtwoorden komen niet overeen';
                msg.className = 'text-xs mt-1 text-red-600';
            }
        }

        // Password strength check
        function checkPasswordStrength() {
            const pw = document.getElementById('password');
            const name = document.querySelector('input[name="name"]');
            const email = document.querySelector('input[name="email"]');
            const msg = document.getElementById('password-strength-message');
            if (!pw || !msg) return;
            const value = pw.value;
            let errors = [];
            if (value.length < 8) errors.push('Minimaal 8 tekens');
            if (!/[A-Z]/.test(value)) errors.push('Hoofdletter');
            if (!/[0-9]/.test(value)) errors.push('Cijfer');
            if (!/[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/.test(value)) errors.push('Speciaal teken');
            if (name && value && name.value && value.toLowerCase().includes(name.value.toLowerCase())) errors.push('Mag niet overeenkomen met naam');
            if (email && value && email.value && value.toLowerCase().includes(email.value.toLowerCase().split('@')[0])) errors.push('Mag niet overeenkomen met e-mail');
            if (errors.length === 0) {
                msg.textContent = 'Sterk wachtwoord';
                msg.className = 'text-xs mt-1 text-green-600';
            } else {
                msg.textContent = 'Wachtwoord moet bevatten: ' + errors.join(', ');
                msg.className = 'text-xs mt-1 text-red-600';
            }
        }

        // Password strength check for edit
        function checkEditPasswordStrength() {
            const pw = document.getElementById('edit_password');
            const name = document.querySelector('input[name="name"]');
            const email = document.querySelector('input[name="email"]');
            const msg = document.getElementById('edit-password-strength-message');
            if (!pw || !msg) return;
            const value = pw.value;
            if (value.length === 0) {
                msg.textContent = '';
                msg.className = 'text-xs mt-1';
                return;
            }
            let errors = [];
            if (value.length < 8) errors.push('Minimaal 8 tekens');
            if (!/[A-Z]/.test(value)) errors.push('Hoofdletter');
            if (!/[0-9]/.test(value)) errors.push('Cijfer');
            if (!/[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/.test(value)) errors.push('Speciaal teken');
            if (name && value && name.value && value.toLowerCase().includes(name.value.toLowerCase())) errors.push('Mag niet overeenkomen met naam');
            if (email && value && email.value && value.toLowerCase().includes(email.value.toLowerCase().split('@')[0])) errors.push('Mag niet overeenkomen met e-mail');
            if (errors.length === 0) {
                msg.textContent = 'Sterk wachtwoord';
                msg.className = 'text-xs mt-1 text-green-600';
            } else {
                msg.textContent = 'Wachtwoord moet bevatten: ' + errors.join(', ');
                msg.className = 'text-xs mt-1 text-red-600';
            }
        }
        // Delete confirmation
        function confirmDelete() {
            if (confirm('Weet je zeker dat je deze werknemer wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</body>
</html>

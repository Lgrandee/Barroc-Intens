<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rollen Beheer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <x-layouts.app :title="'Rollen Beheer'">
        <main class="p-6">
            <header class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Rollen Beheer</h1>
                <p class="text-sm text-gray-500">Beheer gebruikersrollen en permissies</p>
            </header>

            <!-- Action Buttons -->
            <div class="flex gap-3 mb-6">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 font-medium text-sm">
                    + Nieuwe Rol
                </button>
                <button class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50 font-medium text-sm">
                    Rolgroepen
                </button>
                <button class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50 font-medium text-sm">
                    Permissie Instellingen
                </button>
                <div class="ml-auto">
                    <a href="{{ route('management.users.index') }}" class="px-4 py-2 border border-indigo-600 text-indigo-600 rounded hover:bg-indigo-50 font-medium text-sm">
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
                <!-- Admin Role -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="text-3xl">👑</div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Admin</h3>
                            <span class="inline-block px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded">Admin</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Systeembeheerder</p>
                        <p class="text-xs text-gray-500">Volledige systeem toegang met alle permissies</p>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Beheer van alle gebruikers en rollen</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Systeem configuratie en instellingen</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Audit logs en systeem rapportages</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Backup en restore functionaliteit</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">API en integratie instellingen</span>
                        </div>
                    </div>

                    <div class="flex gap-2 pt-4 border-t">
                        <button class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                            Bewerken
                        </button>
                        <button class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                            Permissies
                        </button>
                    </div>
                </div>

                <!-- Sales Role -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="text-3xl">💼</div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Sales</h3>
                            <span class="inline-block px-2 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded">Sales</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Sales Medewerker</p>
                        <p class="text-xs text-gray-500">Verkoop en klantrelatie management</p>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Klantgegevens bekijken en bewerken</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Offertes aanmaken en beheren</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Contract voorstellen maken</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Verkooprapportages inzien</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Klant communicatie beheren</span>
                        </div>
                    </div>

                    <div class="flex gap-2 pt-4 border-t">
                        <button class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                            Bewerken
                        </button>
                        <button class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                            Permissies
                        </button>
                    </div>
                </div>

                <!-- Finance Role -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="text-3xl">💰</div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Finance</h3>
                            <span class="inline-block px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">Finance</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Financieel Medewerker</p>
                        <p class="text-xs text-gray-500">Financiële administratie en boekhouding</p>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Facturen aanmaken en beheren</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Betalingen verwerken</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Financiële rapportages</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Creditnota's verwerken</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">BTW en belasting administratie</span>
                        </div>
                    </div>

                    <div class="flex gap-2 pt-4 border-t">
                        <button class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                            Bewerken
                        </button>
                        <button class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                            Permissies
                        </button>
                    </div>
                </div>

                <!-- Service Role -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="text-3xl">🔧</div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Service</h3>
                            <span class="inline-block px-2 py-0.5 text-xs font-medium bg-pink-100 text-pink-800 rounded">Service</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Service Medewerker</p>
                        <p class="text-xs text-gray-500">Technische ondersteuning en planning</p>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Tickets beheren en toewijzen</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Onderhoud inplannen</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Installaties registreren</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Service rapportages inzien</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Voorraad levels bekijken</span>
                        </div>
                    </div>

                    <div class="flex gap-2 pt-4 border-t">
                        <button class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                            Bewerken
                        </button>
                        <button class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                            Permissies
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </x-layouts.app>
</body>
</html>

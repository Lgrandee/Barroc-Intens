<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rollen Beheer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Light-only page background override */
    </style>
</head>
<body class="bg-gray-50">
    <x-layouts.app :title="'Rollen Beheer'">
        <main class="p-6 min-h-screen">
            <header class="mb-6 flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-semibold text-black dark:text-white">Rollen Beheer</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Beheer gebruikersrollen en permissies</p>
                </div>
            </header>

            <!-- Action Buttons -->
            <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden mb-6">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900 flex-wrap gap-3">
                    <button class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-3 py-1.5 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                        <span class="inline-block h-2 w-2 rounded-full bg-black"></span>
                        Nieuwe Rol
                    </button>
                    <button class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-semibold text-black dark:text-white border border-gray-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                        Rolgroepen
                    </button>
                    <button class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-semibold text-black dark:text-white border border-gray-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                        Permissie Instellingen
                    </button>
                    <div class="ml-auto">
                        <a href="{{ route('management.users.index') }}" class="inline-flex items-center gap-2 rounded-md border border-gray-300 dark:border-zinc-600 px-3 py-1.5 text-sm font-semibold text-black dark:text-white bg-white dark:bg-zinc-800 shadow hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                            👥 Bekijk Werknemers
                        </a>
                    </div>
                </div>
            </div>

            <!-- Roles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Admin Role -->
                <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg shadow-xl p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="text-3xl">👑</div>
                        <div>
                            <h3 class="font-semibold text-black dark:text-white">Admin</h3>
                            <span class="inline-block px-2 py-0.5 text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded">Admin</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Systeembeheerder</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Volledige systeem toegang met alle permissies</p>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Beheer van alle gebruikers en rollen</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Systeem configuratie en instellingen</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Audit logs en systeem rapportages</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Backup en restore functionaliteit</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">API en integratie instellingen</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200 dark:border-zinc-700">
                        <button class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded text-gray-700 dark:text-gray-300 bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                            Bewerken
                        </button>
                    </div>
                </div>

                <!-- Sales Role -->
                <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg shadow-xl p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="text-3xl">💼</div>
                        <div>
                            <h3 class="font-semibold text-black dark:text-white">Sales</h3>
                            <span class="inline-block px-2 py-0.5 text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded">Sales</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Sales Medewerker</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Verkoop en klantrelatie management</p>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Klantgegevens bekijken en bewerken</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Offertes aanmaken en beheren</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Contract voorstellen maken</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Verkooprapportages inzien</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Klant communicatie beheren</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200 dark:border-zinc-700">
                        <button class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded text-gray-700 dark:text-gray-300 bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                            Bewerken
                        </button>
                    </div>
                </div>

                <!-- Finance Role -->
                <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg shadow-xl p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="text-3xl">💰</div>
                        <div>
                            <h3 class="font-semibold text-black dark:text-white">Finance</h3>
                            <span class="inline-block px-2 py-0.5 text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded">Finance</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Financieel Medewerker</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Financiële administratie en boekhouding</p>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Facturen aanmaken en beheren</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Betalingen verwerken</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Financiële rapportages</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Creditnota's verwerken</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">BTW en belasting administratie</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200 dark:border-zinc-700">
                        <button class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded text-gray-700 dark:text-gray-300 bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                            Bewerken
                        </button>
                    </div>
                </div>

                <!-- Service Role -->
                <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg shadow-xl p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="text-3xl">🔧</div>
                        <div>
                            <h3 class="font-semibold text-black dark:text-white">Service</h3>
                            <span class="inline-block px-2 py-0.5 text-xs font-medium bg-pink-100 dark:bg-pink-900 text-pink-800 dark:text-pink-200 rounded">Service</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Service Medewerker</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Technische ondersteuning en planning</p>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Tickets beheren en toewijzen</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Onderhoud inplannen</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Installaties registreren</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Service rapportages inzien</span>
                        </div>
                        <div class="flex items-start gap-2 text-sm">
                            <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Voorraad levels bekijken</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200 dark:border-zinc-700">
                        <button class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded text-gray-700 dark:text-gray-300 bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                            Bewerken
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer text -->
            <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
                Rollen en permissies — beheer en configuratie
            </div>
        </main>
    </x-layouts.app>
</body>
</html>

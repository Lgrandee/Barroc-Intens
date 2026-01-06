<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factuur versturen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Light-only page background override */
        html:not(.dark) body { background-color: #f3f4f6 !important; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-zinc-900">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-white dark:bg-zinc-800 border-b border-gray-200 dark:border-zinc-700 px-6 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-black dark:text-white">Factuur versturen</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Stuur de factuur naar de klant</p>
                </div>
                <a href="{{ route('facturen.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                    Terug naar overzicht
                </a>
            </div>
        </div>

        <div class="max-w-3xl mx-auto px-6 py-8">
            <!-- Offerte Link -->
            @if($factuur->offerte)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="text-yellow-600 text-xl">🔗</div>
                        <div>
                            <div class="font-medium text-yellow-900">Gekoppeld aan offerte</div>
                            <div class="text-sm text-yellow-800">
                                Deze factuur is automatisch aangemaakt vanuit offerte
                                <a href="{{ route('offertes.show', $factuur->offerte->id) }}" class="underline hover:text-yellow-900 font-medium">
                                    OFF-{{ date('Y', strtotime($factuur->offerte->created_at)) }}-{{ str_pad($factuur->offerte->id, 3, '0', STR_PAD_LEFT) }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Email Form -->
            <div class="space-y-6">
                    <!-- Email Section -->
                    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl p-6 border border-gray-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-black dark:text-white mb-4">Verstuur factuur naar klant</h2>

                        <form action="{{ route('facturen.send', $factuur->id) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <!-- Email Address -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Aan (e-mail)</label>
                                    <input type="email" name="email" value="{{ $factuur->customer->email ?? '' }}" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                </div>

                                <!-- Subject -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Onderwerp</label>
                                    <input type="text" name="subject" value="Factuur {{ $factuur->factuurnr }} via" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                </div>

                                <!-- Message -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bericht</label>
                                    <textarea name="message" rows="10" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-black dark:text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">Beste {{ $factuur->customer->name_company ?? 'klant' }},

Bijgevoegd ontvangt u factuur {{ $factuur->factuurnr }} met een totaalbedrag van €{{ number_format($factuur->total_amount * 1.21, 2, ',', '.') }}.

Graag ontvangen wij de betaling binnen {{ \Carbon\Carbon::parse($factuur->invoice_date)->diffInDays(\Carbon\Carbon::parse($factuur->due_date)) }} dagen (uiterlijk {{ \Carbon\Carbon::parse($factuur->due_date)->format('d-m-Y') }}) via {{ $factuur->payment_method === 'bank_transfer' ? 'bankoverschrijving' : ($factuur->payment_method === 'ideal' ? 'iDEAL' : $factuur->payment_method) }}.

Rekeningnummer: NL12 RABO 0123 4567 89
Onder vermelding van: {{ $factuur->factuurnr }}

Voor vragen kunt u contact opnemen via info@barrocintens.nl of 076-5877400.

Met vriendelijke groet,
Barroc Intens B.V.</textarea>
                                </div>

                                <!-- Hidden field for PDF attachment (always included) -->
                                <input type="hidden" name="attach_pdf" value="1">

                                <!-- Send copy option -->
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="send_copy" value="1" class="rounded border-gray-300 text-yellow-500 focus:ring-yellow-400">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Stuur ook kopie naar administratie</span>
                                    </label>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3 pt-4">
                                    <button type="submit" name="action" value="send"
                                        class="px-6 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-300 font-semibold shadow">
                                        Verstuur & Log
                                    </button>
                                    <a href="{{ route('facturen.edit', $factuur->id) }}"
                                        class="px-6 py-2 border border-blue-300 dark:border-blue-700 rounded bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-900 font-medium inline-flex items-center transition-colors">
                                        Terug naar bewerken
                                    </a>
                                    <a href="{{ route('facturen.index') }}"
                                        class="px-6 py-2 border border-red-300 dark:border-red-700 rounded bg-red-50 dark:bg-red-950 text-red-700 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-900 font-medium inline-flex items-center transition-colors">
                                        Annuleren
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Betaalstatus & Herinneringen -->
                    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl p-6 border border-gray-200 dark:border-zinc-700">
                        <h3 class="text-lg font-semibold text-black dark:text-white mb-4">Betaalstatus & Herinneringen</h3>

                        <div class="space-y-4">
                            <!-- Today's Date -->
                            <div class="p-3 bg-yellow-50 rounded border border-yellow-200">
                                <div class="text-xs text-yellow-700 mb-1">📅 Datum vandaag</div>
                                <div class="font-medium text-yellow-900">
                                    {{ now()->format('d-m-Y') }}
                                </div>
                            </div>

                            <!-- Current Status -->
                            <div class="p-3 bg-gray-50 dark:bg-zinc-900 rounded border border-gray-200 dark:border-zinc-600">
                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Huidige status</div>
                                <div class="font-medium text-black dark:text-white">
                                    @switch($factuur->status)
                                        @case('betaald')
                                            ✅ Betaald
                                            @break
                                        @case('verzonden')
                                            📧 Verzonden
                                            @break
                                        @case('verlopen')
                                            ⚠️ Verlopen
                                            @break
                                        @case('concept')
                                            📝 Concept
                                            @break
                                    @endswitch
                                </div>
                                @if($factuur->sent_at)
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        Verstuurd op: {{ \Carbon\Carbon::parse($factuur->sent_at)->format('d-m-Y H:i') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Payment Deadline -->
                            <div class="p-3 {{ \Carbon\Carbon::parse($factuur->due_date)->isPast() && $factuur->status !== 'betaald' ? 'bg-red-50 border-red-200' : 'bg-yellow-50 border-yellow-200' }} rounded border">
                                <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">Betaaltermijn</div>
                                <div class="font-medium {{ \Carbon\Carbon::parse($factuur->due_date)->isPast() && $factuur->status !== 'betaald' ? 'text-red-700' : 'text-yellow-900' }}">
                                    {{ \Carbon\Carbon::parse($factuur->due_date)->format('d-m-Y') }}
                                    @if(\Carbon\Carbon::parse($factuur->due_date)->isPast() && $factuur->status !== 'betaald')
                                        ({{ \Carbon\Carbon::parse($factuur->due_date)->diffForHumans() }})
                                    @else
                                        ({{ \Carbon\Carbon::parse($factuur->due_date)->diffForHumans() }})
                                    @endif
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            @if($factuur->status === 'verzonden' || $factuur->status === 'verlopen')
                                <div class="space-y-2 pt-2 border-t border-gray-200 dark:border-zinc-600">
                                    <button type="button" onclick="alert('Herinnering versturen functionaliteit komt binnenkort')"
                                        class="w-full px-4 py-2 text-sm border border-yellow-500 rounded text-yellow-700 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20">
                                        📩 Verstuur betalingsherinnering
                                    </button>
                                    @if($factuur->status === 'verlopen')
                                        <button type="button" onclick="alert('Aanmaning versturen functionaliteit komt binnenkort')"
                                            class="w-full px-4 py-2 text-sm border border-red-500 rounded text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                            ⚠️ Verstuur aanmaning
                                        </button>
                                    @endif
                                    <button type="button" onclick="if(confirm('Markeer deze factuur als betaald?')) { alert('Betaald markeren functionaliteit komt binnenkort'); }"
                                        class="w-full px-4 py-2 text-sm border border-green-500 rounded text-green-700 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20">
                                        ✅ Markeer als betaald
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

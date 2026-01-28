<x-layouts.app :title="'Factuur versturen'">
  <style>
    /* Light-only page background override for consistency */
    html:not(.dark) body { background-color: #f3f4f6 !important; }
  </style>
  <main class="p-6 min-h-screen max-w-4xl mx-auto">
    <header class="mb-6">
      <div class="text-center mb-4">
        <h1 class="text-3xl font-semibold text-black dark:text-white">Factuur versturen</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">Stuur de factuur naar de klant</p>
      </div>
      <a href="{{ route('facturen.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
        Terug naar overzicht
      </a>
    </header>

    <!-- Offerte Link -->
    @if($factuur->offerte)
      <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <div class="flex items-center gap-3">
          <div class="text-yellow-600 text-xl">🔗</div>
          <div>
            <div class="font-medium text-yellow-900">Gekoppeld aan offerte</div>
            <div class="text-sm text-yellow-800">
              Dit factuur is automatisch aangemaakt vanuit offerte
              <a href="{{ route('offertes.show', $factuur->offerte->id) }}" class="underline hover:text-yellow-900 font-medium">
                OFF-{{ date('Y', strtotime($factuur->offerte->created_at)) }}-{{ str_pad($factuur->offerte->id, 3, '0', STR_PAD_LEFT) }}
              </a>
            </div>
          </div>
        </div>
      </div>
    @endif

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
      <div class="p-6">
        <form action="{{ route('facturen.send', $factuur->id) }}" method="POST" class="space-y-6">
          @csrf

          <div>
            <label for="email" class="font-semibold text-gray-800 dark:text-gray-200">Aan (e-mail)</label>
            <input type="email" id="email" name="email" value="{{ $factuur->customer->email ?? '' }}" required class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md" />
          </div>

          <div>
            <label for="subject" class="font-semibold text-gray-800 dark:text-gray-200">Onderwerp</label>
            <input type="text" id="subject" name="subject" value="Factuur {{ $factuur->factuurnr }} via" required class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md" />
          </div>

          <div>
            <label for="message" class="font-semibold text-gray-800 dark:text-gray-200">Bericht</label>
            <textarea id="message" name="message" rows="10" required class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md">Beste {{ $factuur->customer->name_company ?? 'klant' }},

Bijgevoegd ontvangt u factuur {{ $factuur->factuurnr }} met een totaalbedrag van €{{ number_format($factuur->total_amount * 1.21, 2, ',', '.') }}.

Graag ontvangen wij de betaling binnen {{ \Carbon\Carbon::parse($factuur->invoice_date)->diffInDays(\Carbon\Carbon::parse($factuur->due_date)) }} dagen (uiterlijk {{ \Carbon\Carbon::parse($factuur->due_date)->format('d-m-Y') }}) via {{ $factuur->payment_method === 'bank_transfer' ? 'bankoverschrijving' : ($factuur->payment_method === 'ideal' ? 'iDEAL' : $factuur->payment_method) }}.

Rekeningnummer: NL12 RABO 0123 4567 89
Onder vermelding van: {{ $factuur->factuurnr }}

Voor vragen kunt u contact opnemen via info@barrocintens.nl of 076-5877400.

Met vriendelijke groet,
Barroc Intens B.V.</textarea>
          </div>

          <input type="hidden" name="attach_pdf" value="1">

          <div>
            <label class="flex items-center">
              <input type="checkbox" name="send_copy" value="1" class="rounded border-gray-300 text-yellow-500 focus:ring-yellow-400">
              <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Stuur ook kopie naar administratie</span>
            </label>
          </div>

          <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
            <h3 class="font-semibold text-yellow-900 mb-2">Betaalstatus & Herinneringen</h3>
            <div class="space-y-3">
              <div class="flex justify-between items-center text-sm">
                <span class="text-yellow-800">📅 Datum vandaag</span>
                <span class="font-medium text-yellow-900">{{ now()->format('d-m-Y') }}</span>
              </div>
              <div class="flex justify-between items-center text-sm">
                <span class="text-yellow-800">Huidige status</span>
                <span class="font-medium text-yellow-900">
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
                </span>
              </div>
              @if($factuur->sent_at)
                <div class="text-xs text-yellow-800">
                  Verstuurd op: {{ \Carbon\Carbon::parse($factuur->sent_at)->format('d-m-Y H:i') }}
                </div>
              @endif
              <div class="flex justify-between items-center text-sm">
                <span class="text-yellow-800">Betaaltermijn</span>
                <span class="font-medium {{ \Carbon\Carbon::parse($factuur->due_date)->isPast() && $factuur->status !== 'betaald' ? 'text-red-700' : 'text-yellow-900' }}">
                  {{ \Carbon\Carbon::parse($factuur->due_date)->format('d-m-Y') }}
                  ({{ \Carbon\Carbon::parse($factuur->due_date)->diffForHumans() }})
                </span>
              </div>
            </div>

            @if($factuur->status === 'verzonden' || $factuur->status === 'verlopen')
              <div class="space-y-2 mt-4 pt-4 border-t border-yellow-300">
                <button type="button" onclick="alert('Herinnering versturen functionaliteit komt binnenkort')" class="w-full px-4 py-2 text-sm border border-yellow-500 rounded text-yellow-700 hover:bg-yellow-100">
                  📩 Verstuur betalingsherinnering
                </button>
                @if($factuur->status === 'verlopen')
                  <button type="button" onclick="alert('Aanmaning versturen functionaliteit komt binnenkort')" class="w-full px-4 py-2 text-sm border border-red-500 rounded text-red-700 hover:bg-red-100">
                    ⚠️ Verstuur aanmaning
                  </button>
                @endif
                <button type="button" onclick="if(confirm('Markeer deze factuur als betaald?')) { alert('Betaald markeren functionaliteit komt binnenkort'); }" class="w-full px-4 py-2 text-sm border border-green-500 rounded text-green-700 hover:bg-green-100">
                  ✅ Markeer als betaald
                </button>
              </div>
            @endif
          </div>

          <div class="flex justify-between items-center pt-4">
            <div class="flex gap-3">
              <a href="{{ route('facturen.edit', $factuur->id) }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline">
                Terug naar bewerken
              </a>
              <a href="{{ route('facturen.index') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline">
                Annuleren
              </a>
            </div>
            <button type="submit" name="action" value="send" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
              <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"/></svg>
              Verstuur & Log
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
      Verstuur facturen zorgvuldig — betalingsinformatie wordt naar de klant gestuurd
    </div>
  </main>
</x-layouts.app>

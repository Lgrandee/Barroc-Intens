<x-layouts.app :title="'Contract Details'">
  <style>
    /* Light-only page background override for consistency */
  </style>
  <main class="p-6 min-h-screen max-w-5xl mx-auto">
    <header class="mb-6 flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl font-semibold text-black dark:text-white">Contract Details</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">Details and acties voor dit contract</p>
      </div>
      <a href="{{ route('contracts.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
        Terug naar overzicht
      </a>
    </header>

    @if(session('success'))
      <div class="mb-4 p-3 rounded-md bg-green-50 border border-green-100 text-green-800">
        {{ session('success') }}
      </div>
    @endif

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
      <!-- Contract nummer header -->
      <div class="p-6 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
        <div class="flex justify-between items-start">
          <div>
            <div class="text-sm text-gray-500 mb-1">Contract nummer</div>
            <h2 class="text-2xl font-semibold mb-2">CON-{{ date('Y', strtotime($contract->start_date)) }}-{{ str_pad($contract->id, 3, '0', STR_PAD_LEFT) }}</h2>
            <p class="text-gray-700 dark:text-gray-300">{{ $contract->products->pluck('product_name')->join(', ') ?: ($contract->product->product_name ?? 'N/A') }} — Locatie: {{ $contract->customer->city ?? 'Onbekend' }}</p>
          </div>
          <div class="flex gap-2">
            @php
              $statusColors = [
                'active' => 'bg-green-100 text-green-800',
                'inactive' => 'bg-red-100 text-red-800',
                'pending' => 'bg-yellow-100 text-yellow-800'
              ];
              $statusLabels = [
                'active' => 'active',
                'inactive' => 'inactive',
                'pending' => 'pending'
              ];
            @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$contract->status] ?? 'bg-gray-100 text-gray-800' }}">
              {{ $statusLabels[$contract->status] ?? ucfirst($contract->status) }}
            </span>
          </div>
        </div>
        <div class="flex gap-3 mt-4">
          <a href="{{ route('contracts.pdf', $contract->id) }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-3 py-1.5 text-xs font-semibold text-black shadow hover:bg-yellow-300 transition-colors">Download PDF</a>
        </div>
      </div>

      <!-- Twee kolommen layout -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
        <!-- Left column: Contract information -->
        <div>
          <h3 class="font-semibold mb-4 text-black dark:text-white">Contract Informatie</h3>
          <div class="space-y-3 text-sm">
            <div class="flex justify-between">
              <span class="text-gray-600 dark:text-gray-300">Contract nummer</span>
              <span class="font-medium">CON-{{ date('Y', strtotime($contract->start_date)) }}-{{ str_pad($contract->id, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600 dark:text-gray-300">Start datum</span>
              <span class="font-medium">{{ \Carbon\Carbon::parse($contract->start_date)->format('d M Y') }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600 dark:text-gray-300">Eind datum</span>
              <span class="font-medium">{{ \Carbon\Carbon::parse($contract->end_date)->format('d M Y') }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600 dark:text-gray-300">Opzegtermijn</span>
              <span class="font-medium">1 maand</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600 dark:text-gray-300">Type</span>
              <span class="font-medium">Service & Onderhoud</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600 dark:text-gray-300">Prijs (per jaar)</span>
              <span class="font-medium">€{{ number_format($contract->products->sum('price') ?: ($contract->product->price ?? 1250), 2, ',', '.') }}</span>
            </div>
          </div>

          <h3 class="font-semibold mt-6 mb-4 text-black dark:text-white">Status & Data</h3>
          <div class="space-y-3 text-sm">
            <div class="flex justify-between items-center">
              <span class="text-gray-600 dark:text-gray-300">Klantinformatie</span>
            </div>
            <div>
              <div class="font-medium">{{ $contract->customer->name_company ?? 'Unknown' }}</div>
              <div class="text-gray-600 dark:text-gray-300">{{ $contract->customer->contact_person ?? 'Mark van Dijk' }}</div>
              <div class="text-gray-600 dark:text-gray-300">{{ $contract->customer->email ?? 'm.vandijk@vandijk.nl' }}</div>
              <div class="text-gray-600 dark:text-gray-300">Adres: {{ $contract->customer->address ?? 'Keizerstraat 12' }}, {{ $contract->customer->zipcode ?? '1012 AB' }} {{ $contract->customer->city ?? 'Amsterdam' }}</div>
              <a href="#" class="text-gray-700 dark:text-gray-300 hover:underline text-sm">Contact</a>
            </div>
          </div>
        </div>

        <!-- Right column: Terms & Remarks -->
        <div>
          <h3 class="font-semibold mb-4 text-black dark:text-white">Voorwaarden & Opmerkingen</h3>
          <div class="text-sm text-gray-700 dark:text-gray-300 space-y-2 mb-6">
            <p>Dit contract bevat standaard onderhoudsdiensten, onderdelen en jaarlijkse inspectie. Extra werk wordt apart in rekening gebracht.</p>
            <ul class="list-disc list-inside space-y-1">
              <li>Levertijd/reactie: 48 uur</li>
              <li>Garantie: 2 jaar op uitgevoerde werkzaamheden</li>
              <li>Betaling: Jaarlijkse factuur 30 dagen</li>
            </ul>
          </div>

          <h3 class="font-semibold mb-4 text-black dark:text-white">Betaling & Serviceplanning</h3>
          <div class="space-y-3">
            <div class="flex justify-between items-center text-sm">
              <span class="text-gray-600 dark:text-gray-300">Omschrijving</span>
              <span class="text-gray-600 dark:text-gray-300">Datum</span>
              <span class="text-gray-600 dark:text-gray-300 font-medium">Bedrag</span>
            </div>
            <div class="flex justify-between items-center text-sm">
              <span>Jaarlijkse factuur 2025</span>
              <span>{{ \Carbon\Carbon::parse($contract->start_date)->format('d M Y') }}</span>
              <span class="font-medium">€{{ number_format($contract->products->sum('price') ?: ($contract->product->price ?? 1250), 2, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center text-sm">
              <span>Interim service</span>
              <span>{{ \Carbon\Carbon::parse($contract->start_date)->addMonths(6)->format('d M Y') }}</span>
              <span class="font-medium">Included</span>
            </div>
          </div>

          <h3 class="font-semibold mt-6 mb-4 text-black dark:text-white">Onderhoudsbeleid</h3>
          <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 text-sm">
            <p class="font-semibold text-yellow-900 mb-2">Maandelijks onderhoud inbegrepen</p>
            <p class="text-yellow-800 mb-2">Klanten ontvangen <strong>1 gratis onderhoudsbezoek per maand</strong> als onderdeel van dit contract.</p>
            <p class="text-yellow-800 mb-2">Extra onderhoud buiten het maandelijkse bezoek brengt extra kosten met zich mee, tenzij het probleem wordt veroorzaakt door een defect van Barroc Intens.</p>
            <p class="text-yellow-800">Contact: <strong>service@barroc.nl</strong> of <strong>+31 (0)20 123 4567</strong></p>
          </div>

          <h3 class="font-semibold mt-6 mb-4 text-black dark:text-white">Bijlagen</h3>
          <div class="space-y-2">
            <a href="{{ route('contracts.pdf', $contract->id) }}" class="text-gray-700 dark:text-gray-300 hover:underline text-sm flex items-center gap-2">
              <span>📄</span>
              <span>Contract-CON-{{ date('Y', strtotime($contract->start_date)) }}-{{ str_pad($contract->id, 3, '0', STR_PAD_LEFT) }}.pdf</span>
            </a>
          </div>

          <h3 class="font-semibold mt-6 mb-4 text-black dark:text-white">Activiteit & Notities</h3>
          <div class="space-y-3 text-sm">
            <div>
              <div class="flex justify-between items-start">
                <div>
                  <div class="font-medium">{{ \Carbon\Carbon::now()->subDays(7)->format('d M Y') }} — Klant bevestigde verlenging via e-mail</div>
                </div>
                <div class="text-gray-600 dark:text-gray-300">M.v.dijk</div>
              </div>
            </div>
            <div>
              <div class="flex justify-between items-start">
                <div>
                  <div class="font-medium">{{ \Carbon\Carbon::now()->subDays(45)->format('d M Y') }} — Inspectie voltooid</div>
                </div>
                <div class="text-gray-600 dark:text-gray-300">Technicus</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
      Contract details — actions and history
    </div>
  </main>
</x-layouts.app>

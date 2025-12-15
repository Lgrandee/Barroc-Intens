<x-layouts.app :title="'Offerte Goedkeuren & Verzenden'">
  <main class="p-6 max-w-6xl mx-auto">
    <header class="mb-6">
      <h1 class="text-2xl font-semibold">Offerte Goedkeuren & Verzenden</h1>
      <p class="text-sm text-gray-500">Laatste controle en verzending naar klant</p>
    </header>

    <a href="{{ route('offertes.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 text-sm font-medium mb-6">
      ← Terug naar Index
    </a>

    <!-- Offerte info header -->
    <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6">
      <div class="grid grid-cols-4 gap-4 text-sm">
        <div>
          <div class="text-gray-500 mb-1">Offerte nummer</div>
          <div class="font-medium">OFF-{{ date('Y', strtotime($offerte->created_at)) }}-{{ str_pad($offerte->id, 3, '0', STR_PAD_LEFT) }}</div>
        </div>
        <div>
          <div class="text-gray-500 mb-1">Klant</div>
          <div class="font-medium">{{ $offerte->customer->name_company ?? 'Onbekend' }}</div>
        </div>
        <div>
          <div class="text-gray-500 mb-1">Bedrag</div>
          @php
            $totalExVat = $offerte->products->sum(function($product) {
              return $product->price * $product->pivot->quantity;
            });
            $totalIncVat = $totalExVat * 1.21;
          @endphp
          <div class="font-medium">€{{ number_format($totalIncVat, 2, ',', '.') }}</div>
        </div>
        <div>
          <div class="text-gray-500 mb-1">Verstuurd op</div>
          <div class="font-medium">{{ \Carbon\Carbon::parse($offerte->created_at)->format('d M Y') }}</div>
        </div>
      </div>
    </div>

    <!-- Factuur Status -->
    @if($offerte->status === 'accepted' && $offerte->factuur)
      <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="text-green-600 text-2xl">✓</div>
            <div>
              <div class="font-medium text-green-900">Factuur automatisch aangemaakt</div>
              <div class="text-sm text-green-700">
                Factuur FACT-{{ date('Y', strtotime($offerte->factuur->invoice_date)) }}-{{ str_pad($offerte->factuur->id, 3, '0', STR_PAD_LEFT) }}
                is aangemaakt op {{ \Carbon\Carbon::parse($offerte->factuur->created_at)->format('d-m-Y H:i') }}
              </div>
            </div>
          </div>
          <a href="{{ route('facturen.edit', $offerte->factuur->id) }}"
            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-medium">
            📄 Bekijk Factuur
          </a>
        </div>
      </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Left: Controle Checklist -->
      <div class="bg-white border border-gray-200 rounded-lg">
        <div class="p-4 border-b border-gray-100">
          <h2 class="text-lg font-medium flex items-center gap-2">
            ✓ Controle Checklist
          </h2>
        </div>
        <div class="p-4 space-y-3">
          <!-- Klantgegevens compleet -->
          <div class="flex items-start gap-3 p-3 bg-green-50 border border-green-200 rounded-md">
            <div class="text-green-600 text-xl">✓</div>
            <div class="flex-1">
              <div class="font-medium text-green-900">Klantgegevens compleet</div>
              <div class="text-sm text-green-700">Alle verplichte velden zijn ingevuld</div>
            </div>
          </div>

          <!-- Producten en prijzen -->
          <div class="flex items-start gap-3 p-3 bg-green-50 border border-green-200 rounded-md">
            <div class="text-green-600 text-xl">✓</div>
            <div class="flex-1">
              <div class="font-medium text-green-900">Producten en prijzen</div>
              <div class="text-sm text-green-700">Alle producten hebben correcte prijzen en aantallen</div>
            </div>
          </div>

          <!-- Leveringsvoorwaarden -->
          <div class="flex items-start gap-3 p-3 bg-green-50 border border-green-200 rounded-md">
            <div class="text-green-600 text-xl">✓</div>
            <div class="flex-1">
              <div class="font-medium text-green-900">Leveringsvoorwaarden</div>
              <div class="text-sm text-green-700">Levertijd en leveringsvoorwaarden zijn ingesteld</div>
            </div>
          </div>

          <livewire:offerte-bkr-check :offerte="$offerte" />
        </div>
      </div>

      <!-- Right: E-mail Preview -->
      <div class="bg-white border border-gray-200 rounded-lg">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
          <h2 class="text-lg font-medium flex items-center gap-2">
            📧 E-mail Preview
          </h2>
          <a href="{{ route('offertes.edit', $offerte->id) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">✏️ Bewerk</a>
        </div>
        <div class="p-4 space-y-4 text-sm">
          <div>
            <div class="text-gray-500 mb-1">Aan:</div>
            <div class="font-medium">{{ $offerte->customer->email ?? 'm.vandijk@vandijk.nl' }}</div>
          </div>
          <div>
            <div class="text-gray-500 mb-1">CC:</div>
            <div class="font-medium">administratie@vandijk.nl</div>
          </div>
          <div>
            <div class="text-gray-500 mb-1">Onderwerp:</div>
            <div class="font-medium">Offerte OFF-{{ date('Y', strtotime($offerte->created_at)) }}-{{ str_pad($offerte->id, 3, '0', STR_PAD_LEFT) }}: Warmtepomp en Zonnepanelen</div>
          </div>

          <div class="border-t border-gray-200 pt-4">
            <div class="text-gray-700 leading-relaxed">
              <p class="mb-3"><strong>Beste team Van Dijk,</strong></p>

              <p class="mb-3">Hartelijk dank voor uw interesse in onze producten. Zoals besproken stuur ik u hierbij onze offerte voor de warmtepomp en zonnepanelen installatie.</p>

              <p class="mb-3">In de bijgevoegde offerte vindt u een gedetailleerd overzicht van:</p>
              <ul class="list-disc list-inside mb-3 space-y-1">
                <li>De gekozen producten en specificaties</li>
                <li>Installatiekosten en voorwaarden</li>
                <li>Garantieverplichtingen</li>
                <li>Levertijd en planning</li>
              </ul>

              <p class="mb-3">De offerte is 30 dagen geldig. U kunt de offerte eenvoudig accepteren via de beveiligde <span class="text-indigo-600 underline">link</span> in de PDF.</p>

              <p class="mb-3">Heeft u nog vragen? Neem dan gerust contact met mij op.</p>

              <p class="mb-3">Met vriendelijke groet,<br>
              <strong>Lisa Bakker</strong><br>
              Sales Advisor<br>
              Tel: +31 (0)6 12345678</p>
            </div>
          </div>

          <div class="border-t border-gray-200 pt-4 space-y-2">
            <a href="{{ route('offertes.pdf', $offerte->id) }}" class="flex items-center gap-2 text-indigo-600 hover:text-indigo-800">
              <span>📄</span>
              <div>
                <div class="font-medium">Offerte-OFF-{{ date('Y', strtotime($offerte->created_at)) }}-{{ str_pad($offerte->id, 3, '0', STR_PAD_LEFT) }}.pdf</div>
                <div class="text-xs text-indigo-500">PDF Document • Klik om te downloaden</div>
              </div>
            </a>
            <div class="flex items-center gap-2 text-gray-600">
              <span>📄</span>
              <div>
                <div class="font-medium">Algemene-voorwaarden-2025.pdf</div>
                <div class="text-xs text-gray-500">PDF Document • 880 KB</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-between items-center mt-6">
      <a href="{{ route('offertes.edit', $offerte->id) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
        🔙 Terug naar bewerken
      </a>
      <div class="flex gap-3">
        <a href="{{ route('offertes.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 font-medium">
          ← Terug naar overzicht
        </a>
          <form method="POST" action="{{ route('offertes.send', $offerte->id) }}">
            @csrf
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
              📤 Verstuur naar klant
            </button>
          </form>
      </div>
    </div>
  </main>
  <script>
    function markBkrApproved() {
      const card = document.getElementById('bkr-card');
      const icon = document.getElementById('bkr-icon');
      const text = document.getElementById('bkr-text');
      const button = document.getElementById('bkr-button');

      // Update styles to indicate success
      card.classList.remove('bg-gray-50', 'border-gray-200');
      card.classList.add('bg-green-50', 'border-green-200');
      icon.classList.remove('text-gray-600');
      icon.classList.add('text-green-600');
      icon.textContent = '✓';
      text.classList.remove('text-gray-600');
      text.classList.add('text-green-700');
      text.textContent = 'BKR check gemarkeerd als goedgekeurd';

      // Disable button after marking
      button.disabled = true;
      button.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
      button.classList.add('bg-green-600', 'cursor-default');
      button.textContent = 'Goedgekeurd';
    }
  </script>
</x-layouts.app>

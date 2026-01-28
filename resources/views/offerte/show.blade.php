<x-layouts.app :title="'Offerte Goedkeuren & Verzenden'">
  <style>
    /* Light-only page background override */
    html:not(.dark) body { background-color: #f3f4f6 !important; }

    /* Slide up animation */
    @keyframes slideUpIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Fade out animation */
    @keyframes fadeOut {
      from {
        opacity: 1;
        transform: translateY(0);
      }
      to {
        opacity: 0;
        transform: translateY(30px);
      }
    }

    .notification-popup {
      animation: slideUpIn 0.5s ease-out forwards;
    }

    .notification-popup.fade-out {
      animation: fadeOut 1.5s ease-out forwards;
    }
  </style>
  <main class="p-6 max-w-6xl mx-auto">
    <header class="mb-6">
      <div class="text-center mb-4">
        <h1 class="text-3xl font-semibold text-black dark:text-white">Offerte Goedkeuren & Verzenden</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">Laatste controle en verzending naar klant</p>
      </div>
      <a href="{{ route('offertes.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
        Terug naar overzicht
      </a>
    </header>

    <!-- Offerte info header -->
    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden mb-6">
      <div class="p-5 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
        <h2 class="text-lg font-semibold text-black dark:text-white">Offertegegevens</h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-5">
        <div>
          <div class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Offerte nummer</div>
          <div class="text-lg font-semibold text-black dark:text-white">OFF-{{ date('Y', strtotime($offerte->created_at)) }}-{{ str_pad($offerte->id, 3, '0', STR_PAD_LEFT) }}</div>
        </div>
        <div>
          <div class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Klant</div>
          <div class="text-lg font-semibold text-black dark:text-white">{{ $offerte->customer->name_company ?? 'Onbekend' }}</div>
        </div>
        <div>
          <div class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Bedrag</div>
          @php
            $totalExVat = $offerte->products->sum(function($product) {
              return $product->price * $product->pivot->quantity;
            });
            $totalIncVat = $totalExVat * 1.21;
          @endphp
          <div class="text-lg font-semibold text-black">€{{ number_format($totalIncVat, 2, ',', '.') }}</div>
        </div>
        <div>
          <div class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Offertedatum</div>
          <div class="text-lg font-semibold text-black dark:text-white">{{ \Carbon\Carbon::parse($offerte->created_at)->format('d M Y') }}</div>
        </div>
      </div>
    </div>

    <!-- Producten Table -->
    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden mb-6">
      <div class="p-5 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
        <h2 class="text-lg font-semibold text-black dark:text-white">Producten</h2>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-gray-200 dark:border-zinc-700">
              <th class="px-5 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Productnaam</th>
              <th class="px-5 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Prijs per stuk</th>
              <th class="px-5 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Aantal</th>
              <th class="px-5 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Totaal</th>
            </tr>
          </thead>
          <tbody>
            @forelse($offerte->products as $product)
              @php
                $qty = $product->pivot->quantity ?? 1;
                $lineTotal = $product->price * $qty;
              @endphp
              <tr class="border-b border-gray-100 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-700">
                <td class="px-5 py-3 text-sm text-black dark:text-white">{{ $product->product_name }}</td>
                <td class="px-5 py-3 text-sm text-right text-gray-700 dark:text-gray-300">€{{ number_format($product->price, 2, ',', '.') }}</td>
                <td class="px-5 py-3 text-sm text-right text-gray-700 dark:text-gray-300">{{ $qty }}</td>
                <td class="px-5 py-3 text-sm text-right font-semibold text-black dark:text-white">€{{ number_format($lineTotal, 2, ',', '.') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="px-5 py-3 text-center text-sm text-gray-600 dark:text-gray-400">Geen producten gevonden</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="px-5 py-3 bg-gray-50 dark:bg-zinc-900 border-t border-gray-200 dark:border-zinc-700">
        <div class="flex justify-end gap-8">
          <div>
            <div class="text-sm text-gray-600 dark:text-gray-400">Subtotaal (excl. BTW)</div>
            <div class="text-lg font-semibold text-black dark:text-white">€{{ number_format($totalExVat, 2, ',', '.') }}</div>
          </div>
          <div>
            <div class="text-sm text-gray-600 dark:text-gray-400">BTW (21%)</div>
            <div class="text-lg font-semibold text-black dark:text-white">€{{ number_format($totalExVat * 0.21, 2, ',', '.') }}</div>
          </div>
          <div class="pl-8 border-l border-gray-200 dark:border-zinc-700">
            <div class="text-sm text-gray-600 dark:text-gray-400">Totaal (incl. BTW)</div>
            <div class="text-xl font-semibold text-black dark:text-white">€{{ number_format($totalIncVat, 2, ',', '.') }}</div>
          </div>
        </div>
      </div>
    </div>

    @if(session('success') && str_contains(session('success'), 'Contract aangemaakt'))
      <div id="contract-notification" class="notification-popup bg-green-50 dark:bg-green-950 border border-green-200 dark:border-green-800 rounded-xl shadow p-5 mb-6">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="text-green-600 dark:text-green-400 text-3xl">✓</div>
            <div>
              <div class="font-semibold text-green-900 dark:text-green-100">Contract automatisch aangemaakt</div>
              <div class="text-sm text-green-700 dark:text-green-300">
                Contract CON-{{ date('Y', strtotime($offerte->contract->start_date ?? now())) }}-{{ str_pad($offerte->contract->id ?? '', 3, '0', STR_PAD_LEFT) }}
                is aangemaakt op {{ \Carbon\Carbon::parse($offerte->contract->created_at ?? now())->format('d-m-Y H:i') }}
                voor {{ $offerte->customer->name_company ?? 'Onbekend' }} • Duur: {{ \Carbon\Carbon::parse($offerte->contract->start_date)->diffInMonths(\Carbon\Carbon::parse($offerte->contract->end_date)) }} maanden
              </div>
            </div>
          </div>
          @if($offerte->contract)
            <a href="{{ route('contracts.show', $offerte->contract->id) }}"
              class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-400 text-black rounded-md hover:bg-yellow-300 text-sm font-semibold transition-colors">
              <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 011 1v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7z"/></svg>
              Bekijk Contract
            </a>
          @endif
        </div>
      </div>
    @endif

    <!-- Factuur Status -->
    @if(session('success') && str_contains(session('success'), 'Factuur aangemaakt') && $offerte->factuur)
      <div id="factuur-notification" class="notification-popup bg-green-50 dark:bg-green-950 border border-green-200 dark:border-green-800 rounded-xl shadow p-5 mb-6">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="text-green-600 dark:text-green-400 text-3xl">✓</div>
            <div>
              <div class="font-semibold text-green-900 dark:text-green-100">Factuur automatisch aangemaakt</div>
              <div class="text-sm text-green-700 dark:text-green-300">
                Factuur FACT-{{ date('Y', strtotime($offerte->factuur->invoice_date)) }}-{{ str_pad($offerte->factuur->id, 3, '0', STR_PAD_LEFT) }}
                is aangemaakt op {{ \Carbon\Carbon::parse($offerte->factuur->created_at)->format('d-m-Y H:i') }}
                voor {{ $offerte->customer->name_company ?? 'Onbekend' }} • Bedrag: €{{ number_format($totalIncVat, 2, ',', '.') }}
              </div>
            </div>
          </div>
          <a href="{{ route('facturen.edit', $offerte->factuur->id) }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-400 text-black rounded-md hover:bg-yellow-300 text-sm font-semibold transition-colors">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 012-2h4l4 4v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
            Bekijk Factuur
          </a>
        </div>
      </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Left: Controle Checklist -->
      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
        <div class="p-5 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
          <h2 class="text-lg font-semibold text-black dark:text-white flex items-center gap-2">
            <svg class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            Controle Checklist
          </h2>
        </div>
        <div class="p-5 space-y-3">
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
      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
        <div class="p-5 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
          <h2 class="text-lg font-semibold text-black dark:text-white flex items-center gap-2">
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
            E-mail Preview
          </h2>
        </div>
        <div class="p-5 space-y-4 text-sm">
          <div>
            <div class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Aan:</div>
            <div class="font-medium text-black dark:text-white">{{ $offerte->customer->email ?? 'm.vandijk@vandijk.nl' }}</div>
          </div>
          <div>
            <div class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">CC:</div>
            <div class="font-medium text-black dark:text-white">administratie@vandijk.nl</div>
          </div>
          <div>
            <div class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Onderwerp:</div>
            <div class="font-medium text-black dark:text-white">Offerte OFF-{{ date('Y', strtotime($offerte->created_at)) }}-{{ str_pad($offerte->id, 3, '0', STR_PAD_LEFT) }}: Warmtepomp en Zonnepanelen</div>
          </div>

          <div class="border-t border-gray-200 dark:border-zinc-700 pt-4">
            <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
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

          <div class="border-t border-gray-200 dark:border-zinc-700 pt-4 space-y-2">
            <a href="{{ route('offertes.pdf', $offerte->id) }}" class="flex items-center gap-2 text-black dark:text-white hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
              <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 012-2h4l4 4v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
              <div>
                <div class="font-medium">Offerte-OFF-{{ date('Y', strtotime($offerte->created_at)) }}-{{ str_pad($offerte->id, 3, '0', STR_PAD_LEFT) }}.pdf</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">PDF Document • Klik om te downloaden</div>
              </div>
            </a>
            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
              <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 012-2h4l4 4v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
              <a href="{{ route('general-terms.pdf') }}" class="flex-1">
                <div class="font-medium text-black dark:text-white hover:text-gray-700 dark:hover:text-gray-200">Algemene-voorwaarden-2025.pdf</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">PDF Document • Klik om te downloaden</div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-between items-center mt-6">
      <a href="{{ route('offertes.edit', $offerte->id) }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 text-sm font-semibold transition-colors">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
        Terug naar bewerken
      </a>
      <div class="flex gap-3">
        <form method="POST" action="{{ route('offertes.send', $offerte->id) }}">
          @csrf
          <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
            Verstuur naar klant
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

  <script>
    // Auto-hide notifications after 10 seconds
    document.addEventListener('DOMContentLoaded', function() {
      const notifications = document.querySelectorAll('.notification-popup');
      notifications.forEach(notification => {
        setTimeout(() => {
          notification.classList.add('fade-out');
          setTimeout(() => {
            notification.style.display = 'none';
          }, 1500); // Wait for fade-out animation to complete (1.5s)
        }, 10000); // 10 seconds
      });
    });
  </script>
</x-layouts.app>

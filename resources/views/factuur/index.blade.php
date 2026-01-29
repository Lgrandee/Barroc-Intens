<x-layouts.app :title="'Factuur Overzicht'">
  <style>
    /* Light-only page background override */
  </style>
  <main class="p-6 min-h-screen">
    <header class="mb-6 flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl font-semibold text-black dark:text-white">Factuur Overzicht</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">Beheer en monitor alle facturen</p>
      </div>
    </header>

    @if (session('success'))
      <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded-md">
        {{ session('success') }}
      </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      @php
        $facturen = \App\Models\Factuur::with('products')->get();
        $totalAmount = $facturen->sum(function($f) { return $f->total_amount; });
        $openstaand = $facturen->whereIn('status', ['verzonden', 'concept'])->sum(function($f) { return $f->total_amount; });
        $verlopen = $facturen->where('status', 'verlopen')->sum(function($f) { return $f->total_amount; });

        // Calculate average overdue days
        $verlopenFacturen = \App\Models\Factuur::where('status', 'verlopen')
          ->where('due_date', '<', now())
          ->get();
        $overdueDays = $verlopenFacturen->count() > 0
          ? $verlopenFacturen->avg(function($f) {
              return \Carbon\Carbon::parse($f->due_date)->diffInDays(now());
            })
          : 0;
      @endphp

      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Totaal Facturen</div>
        <div class="text-2xl font-semibold text-black dark:text-white">€{{ number_format($totalAmount, 0, ',', '.') }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ \App\Models\Factuur::count() }} facturen deze maand</div>
      </div>

      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Openstaand</div>
        <div class="text-2xl font-semibold text-black dark:text-white">€{{ number_format($openstaand, 0, ',', '.') }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ \App\Models\Factuur::whereIn('status', ['verzonden', 'concept'])->count() }} facturen te betalen</div>
      </div>

      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Verlopen</div>
        <div class="text-2xl font-semibold text-red-600">€{{ number_format($verlopen, 0, ',', '.') }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ \App\Models\Factuur::where('status', 'verlopen')->count() }} facturen > 30 dagen</div>
      </div>

      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Gemiddelde Betaaltijd</div>
        <div class="text-2xl font-semibold text-black dark:text-white">{{ number_format($overdueDays ?? 0, 1) }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">dagen in november</div>
      </div>
    </div>

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
      <!-- Header with New factuur button -->
      <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
        <h2 class="text-lg font-semibold text-black dark:text-white">Facturen</h2>
        <a href="{{ route('facturen.create') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-3 py-1.5 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
          <span class="inline-block h-2 w-2 rounded-full bg-black"></span>
          Nieuwe Factuur
        </a>
      </div>

      <div class="p-4">
        <div class="rounded-lg border border-gray-100 dark:border-zinc-700 bg-white dark:bg-zinc-900">
          @livewire('factuur-table')
        </div>
      </div>
    </div>

    <!-- Footer text -->
    <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
      Factuur overzicht — beheer en monitor
    </div>
  </main>
</x-layouts.app>

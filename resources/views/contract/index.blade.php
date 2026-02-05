<x-layouts.app :title="'Contract Overview'">
  <style>
    /* Light-only page background override */
  </style>
  <main class="p-6 min-h-screen">
    <header class="mb-6 flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl font-semibold text-black dark:text-white">Contract Overzicht</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">Bekijk actieve, verlopen en binnenkort verlopen contracten</p>
      </div>
    </header>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Actieve Contracten</div>
        <div class="text-2xl font-semibold text-black dark:text-white">{{ $totalActive ?? 0 }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Momenteel actief</div>
      </div>

      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Alle Contracten</div>
        <div class="text-2xl font-semibold text-black dark:text-white">{{ \App\Models\Contract::count() }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Alle contracten</div>
      </div>

      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Binnenkort Verlopen</div>
        <div class="text-2xl font-semibold text-orange-600">0</div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Volgende 30 dagen</div>
      </div>

      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Verlopen</div>
        <div class="text-2xl font-semibold text-red-600">0</div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Inactief</div>
      </div>
    </div>

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
      <!-- Header with New contract button -->
      <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
        <h2 class="text-lg font-semibold text-black dark:text-white">Contracten</h2>
        <a href="{{ route('contracts.create') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-3 py-1.5 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
          <span class="inline-block h-2 w-2 rounded-full bg-black"></span>
          Nieuw contract
        </a>
      </div>

      <div class="p-4">
        <div class="rounded-lg border border-gray-100 dark:border-zinc-700 bg-white dark:bg-zinc-900">
          @livewire('contract-table')
        </div>
      </div>
    </div>

    <!-- Footer text -->
    <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
      Contract overzicht — beheer en acties
    </div>
  </main>
</x-layouts.app>

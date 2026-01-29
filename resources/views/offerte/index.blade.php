<x-layouts.app :title="'Offerte Overzicht'">
  <style>
    /* Light-only page background override */
  </style>
  <main class="p-6 min-h-screen">
    <header class="mb-6 flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl font-semibold text-black dark:text-white">Offerte Overzicht</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">Beheer en bekijk alle offertes</p>
      </div>
    </header>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Geaccepteerd</div>
        <div class="text-2xl font-semibold text-green-600">{{ \App\Models\Offerte::where('status', 'accepted')->count() ?? 0 }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Geaccepteerde offertes</div>
      </div>

      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">In Behandeling</div>
        <div class="text-2xl font-semibold text-black dark:text-white">{{ \App\Models\Offerte::where('status', 'pending')->count() ?? 0 }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Verzonden offertes</div>
      </div>

      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Concepten</div>
        <div class="text-2xl font-semibold text-black dark:text-white">{{ \App\Models\Offerte::where('status', 'draft')->count() ?? 0 }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Nog niet verzonden</div>
      </div>

      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Afgewezen</div>
        <div class="text-2xl font-semibold text-red-600">{{ \App\Models\Offerte::where('status', 'rejected')->count() ?? 0 }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Afgewezen offertes</div>
      </div>
    </div>

    @if (session('success'))
      <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded-md">
        {{ session('success') }}
      </div>
    @endif

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
      <!-- Header with New offerte button -->
      <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
        <h2 class="text-lg font-semibold text-black dark:text-white">Offertes</h2>
        <a href="{{ route('offertes.create') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-3 py-1.5 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
          <span class="inline-block h-2 w-2 rounded-full bg-black"></span>
          Nieuwe Offerte
        </a>
      </div>

      <div class="p-4">
        <div class="rounded-lg border border-gray-100 dark:border-zinc-700 bg-white dark:bg-zinc-900">
          @livewire('offerte-table')
        </div>
      </div>
    </div>

    <!-- Footer text -->
    <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
      Offerte overzicht — beheer en monitor
    </div>
  </main>
</x-layouts.app>

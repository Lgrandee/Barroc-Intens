<x-layouts.app :title="'Offerte Overzicht'">
  <style>
    /* Light-only page background override */
    html:not(.dark) body { background-color: #f3f4f6 !important; }
  </style>
  <main class="p-6 min-h-screen">
    <header class="mb-6 flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl font-semibold text-black dark:text-white">Offerte Overzicht</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">Beheer en bekijk alle offertes</p>
      </div>
      <a href="{{ route('offertes.create') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
        <span class="inline-block h-2 w-2 rounded-full bg-black"></span>
        Nieuwe Offerte
      </a>
    </header>

    @if (session('success'))
      <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded-md">
        {{ session('success') }}
      </div>
    @endif

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
      <!-- Header with New offerte button -->
      <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
        <h2 class="text-lg font-semibold text-black dark:text-white">Offertes</h2>
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

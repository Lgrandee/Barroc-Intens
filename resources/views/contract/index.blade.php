<x-layouts.app :title="'Contract Overview'">
  <style>
    /* Light-only page background override */
    html:not(.dark) body { background-color: #f3f4f6 !important; }
  </style>
  <main class="p-6 min-h-screen">
    <header class="mb-6 flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl font-semibold text-black dark:text-white">Contract Overview</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">View active, expired and upcoming expiring contracts</p>
      </div>
      <a href="{{ route('contracts.create') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
        <span class="inline-block h-2 w-2 rounded-full bg-black"></span>
        New contract
      </a>
    </header>

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
      <!-- Header with New contract button -->
      <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
        <h2 class="text-lg font-semibold text-black dark:text-white">Contracts</h2>
        <div class="inline-flex items-center gap-2 rounded-full bg-green-400 text-black py-1 pr-3 text-xs font-semibold">
          <span class="inline-block h-2 w-2 rounded-full bg-green-400"></span>
          Active: {{ $totalActive ?? 0 }}
        </div>
      </div>

      <div class="p-4">
        <div class="rounded-lg border border-gray-100 dark:border-zinc-700 bg-white dark:bg-zinc-900">
          @livewire('contract-table')
        </div>
      </div>
    </div>

    <!-- Footer text -->
    <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
      Contract overview — management and actions
    </div>
  </main>
</x-layouts.app>

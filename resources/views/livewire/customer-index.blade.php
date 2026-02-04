<div>
    <header class="mb-6 flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl font-semibold text-black dark:text-white">Klanten Overzicht</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">Bekijk, bewerk of voeg nieuwe klanten toe</p>
      </div>
    </header>

    <!-- Filters -->
    <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6 flex flex-wrap items-center gap-4 shadow-md">

        <!-- Search -->
        <div class="flex-1 relative min-w-[240px]">
            <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
            <input
                wire:model.live="search"
                type="text"
                placeholder="Zoek op naam, bedrijf, e-mail..."
                class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-yellow-500 focus:border-yellow-500"
            >
        </div>

        <select wire:model.live="bkrStatus" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-600 focus:ring-yellow-500 focus:border-yellow-500">
            <option value="">Alle BKR statussen</option>
            <option value="approved">Goedgekeurd</option>
            <option value="denied">Afgekeurd</option>
            <option value="pending">In behandeling</option>
            <option value="unknown">Onbekend</option>
        </select>

        @if($search || $bkrStatus !== '')
            <button wire:click="resetFilters" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-300">
                Reset
            </button>
        @endif

        <a href="{{ route('customers.create') }}" class="ml-auto px-4 py-2 bg-yellow-300 text-black rounded-md text-sm font-semibold hover:bg-yellow-400 flex items-center gap-2">
            <span class="inline-block h-2 w-2 rounded-full bg-black"></span> Nieuwe Klant
        </a>
    </div>

    <!-- Customers Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach ($customers as $customer)

            <!-- Customer Card -->
            <div class="bg-white border border-gray-200 rounded-lg p-5 hover:border-yellow-500 hover:shadow-md transition shadow-md">

                <!-- Header -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-yellow-200 text-yellow-800 flex items-center justify-center font-semibold text-lg">
                        {{ strtoupper(substr($customer->name_company, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="font-medium text-lg">{{ $customer->name_company }}</h3>
                        <p class="text-gray-500 text-sm">{{ $customer->email }}</p>
                    </div>
                </div>

                <!-- Info -->
                <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                    <div>
                        <span class="text-gray-500">BKR status</span>
                        <p class="font-semibold capitalize">{{ $customer->bkr_status }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Contactpersoon</span>
                        <p class="font-semibold">{{ $customer->contact_person ?? '-' }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-2">
                    <a href="{{ route('customers.show', $customer->id) }}"
                       class="flex-1 text-center border border-gray-300 rounded-md py-2 text-sm text-gray-600 hover:border-yellow-500 hover:text-yellow-600">
                        Details
                    </a>

                    <a href="{{ route('customers.edit', $customer->id) }}"
                       class="flex-1 text-center border border-gray-300 rounded-md py-2 text-sm text-gray-600 hover:border-yellow-500 hover:text-yellow-600">
                        Bewerken
                    </a>

                    <a href="mailto:{{ $customer->email }}"
                       class="flex-1 text-center border border-gray-300 rounded-md py-2 text-sm text-gray-600 hover:border-yellow-500 hover:text-yellow-600">
                        Contact
                    </a>
                </div>

            </div>
            <!-- End Card -->

        @endforeach

    </div>

    <!-- Pagination -->
    <div class="mt-6 flex flex-col items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3">
        <div class="text-sm text-gray-700">
            Showing {{ $customers->firstItem() ?? 0 }}–{{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }}
        </div>
        <div class="flex gap-1 items-center">
            @if($customers->onFirstPage())
                <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">‹</span>
            @else
                <button wire:click="previousPage" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">‹</button>
            @endif

            @php
                $currentPage = $customers->currentPage();
                $lastPage = $customers->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
            @endphp

            @if ($start > 1)
                <button wire:click="gotoPage(1)" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">1</button>
                @if ($start > 2)
                    <span class="px-2 text-gray-500">...</span>
                @endif
            @endif

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $currentPage)
                    <span class="px-3 py-1 border border-yellow-400 bg-yellow-400 text-black rounded text-sm font-medium">{{ $page }}</span>
                @else
                    <button wire:click="gotoPage({{ $page }})" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">{{ $page }}</button>
                @endif
            @endfor

            @if ($end < $lastPage)
                @if ($end < $lastPage - 1)
                    <span class="px-2 text-gray-500">...</span>
                @endif
                <button wire:click="gotoPage({{ $lastPage }})" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">{{ $lastPage }}</button>
            @endif

            @if($customers->hasMorePages())
                <button wire:click="nextPage" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">›</button>
            @else
                <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">›</span>
            @endif
        </div>
    </div>
</div>

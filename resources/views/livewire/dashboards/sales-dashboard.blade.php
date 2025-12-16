{{--
    PERFORMANCE OPTIMIZATION:
    wire:poll.2s refreshes every 2 seconds (currently set for testing).
    For production with many concurrent users, consider:
    - Increase interval: wire:poll.5s or wire:poll.10s
    - Use wire:poll.keep-alive to only poll when browser tab is visible
    - Use Laravel Echo + Pusher for event-driven real-time updates (recommended for production)
--}}
<div wire:poll.2s>
@php($title = 'Sales Dashboard')

<main class="p-6 bg-[#FAF9F6]">
    <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl p-6 mb-6 shadow-lg">
        <h1 class="text-xl font-semibold mb-1">Goedemorgen, {{ auth()->user()->name ?? 'Gebruiker' }} 👋</h1>
        <p class="text-sm text-white/90 mb-4">Je hebt {{ $openTasksCount }} openstaande taken en {{ $newLeads }} nieuwe leads deze maand</p>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('offertes.create') }}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">+ Nieuwe Offerte</a>
            <a href="{{ route('customers.create') }}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">+ Contact Toevoegen</a>
            <a href="{{ route('offertes.index') }}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">Alle Offertes</a>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:space-x-6 gap-6 mb-6">
        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Totaal Offertes</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded">📝</div>
            </div>
            <p class="text-2xl font-semibold mt-3">{{ $totalOffertes }}</p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Conversie Ratio</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded">📈</div>
            </div>
            <p class="text-2xl font-semibold mt-3">{{ $conversionRatio }}%</p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Nieuwe Leads</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded">👥</div>
            </div>
            <p class="text-2xl font-semibold mt-3">{{ $newLeads }}</p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Gem. Dealwaarde</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded">💰</div>
            </div>
            <p class="text-2xl font-semibold mt-3">€{{ number_format($avgDealValue, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Sales Pipeline</h2>
                    <button class="text-sm text-gray-600">Grafiek Weergave</button>
                </div>
                <div class="p-4">
                    <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg p-8 text-center">
                        <p class="text-gray-500">Hier komt een pipeline grafiek met verkoop prestaties</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Recente Deals</h2>
                    <a href="{{ route('offertes.index') }}" class="text-sm text-gray-600">Alle Deals</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentDeals as $deal)
                    <div class="flex items-center p-4">
                        <div class="flex-1">
                            <h4 class="font-medium">Offerte #{{ $deal->id }}</h4>
                            <p class="text-sm text-gray-500">{{ $deal->customer->name_company ?? 'Onbekend' }} - Status: {{ $deal->status }}</p>
                        </div>
                        <div class="text-right">
                            <div class="font-medium">{{ $deal->valid_until ? \Carbon\Carbon::parse($deal->valid_until)->format('d M Y') : '-' }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-gray-500 text-center">Geen recente deals.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Taken & Activiteiten</h2>
                    <button class="text-sm text-gray-600">+ Taak</button>
                </div>
                <div class="p-4 space-y-4">
                    @forelse($recentTasks as $task)
                    <div class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg">
                        <div class="w-4 h-4 border-2 border-gray-300 rounded mt-1"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">{{ $task->catagory }} - {{ $task->location ?? 'Geen locatie' }}</p>
                            <p class="text-xs text-gray-500">Gepland: {{ $task->scheduled_time ? \Carbon\Carbon::parse($task->scheduled_time)->format('d M Y H:i') : 'Niet gepland' }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-gray-500 text-center">Geen taken gevonden.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>
</div>

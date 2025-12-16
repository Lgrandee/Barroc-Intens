{{--
    PERFORMANCE OPTIMIZATION:
    wire:poll.2s refreshes every 2 seconds (currently set for testing).
    For production with many concurrent users, consider:
    - Increase interval: wire:poll.5s or wire:poll.10s
    - Use wire:poll.keep-alive to only poll when browser tab is visible
    - Use Laravel Echo + Pusher for event-driven real-time updates (recommended for production)
--}}
<div wire:poll.2s>
@php($title = 'Technician Dashboard')

<main class="p-6 bg-[#FAF9F6]">
    <div class="bg-gradient-to-br from-red-500 to-red-700 text-white rounded-xl p-6 mb-6 shadow-lg">
        <h1 class="text-xl font-semibold mb-1">Goedemorgen, {{ auth()->user()->name ?? 'Gebruiker' }} 👋</h1>
        <p class="text-sm text-white/90 mb-4">Je hebt {{ $scheduledServicesCount }} geplande services en {{ $urgentTickets->where('priority', 'hoog')->count() }} urgente tickets voor deze week</p>
        <div class="flex flex-wrap gap-3">
            <button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">+ Nieuwe Afspraak</button>
            <button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">+ Ticket Aanmaken</button>
            <button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">📅 Planning</button>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:space-x-6 gap-6 mb-6">
        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Open Tickets</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-700 rounded">🎫</div>
            </div>
            <p class="text-2xl font-semibold mt-3">{{ $openTicketsCount }}</p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Geplande Service</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-700 rounded">🔧</div>
            </div>
            <p class="text-2xl font-semibold mt-3">{{ $scheduledServicesCount }}</p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Gemiddelde Responstijd</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-700 rounded">⏱️</div>
            </div>
            <p class="text-2xl font-semibold mt-3">{{ number_format($avgResponseTime, 1) }}d</p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Voorraad Alerts</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-700 rounded">⚠️</div>
            </div>
            <p class="text-2xl font-semibold mt-3">{{ $stockAlertsCount }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Planning Deze Week</h2>
                    <div class="flex gap-2">
                        <button class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded border border-red-200">Week</button>
                        <button class="px-3 py-1 text-sm bg-white text-gray-600 rounded border border-gray-200">Maand</button>
                    </div>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($weeklyPlanning as $day => $tickets)
                    <div class="border border-gray-200 rounded-lg p-3 shadow-sm">
                        <div class="font-medium text-sm mb-2">{{ $day }}</div>
                        <div class="space-y-2">
                            @foreach($tickets as $ticket)
                            <div class="flex items-center gap-2 p-2 bg-gray-50 rounded text-sm">
                                <span class="font-medium min-w-12">{{ \Carbon\Carbon::parse($ticket->scheduled_time)->format('H:i') }}</span>
                                <span>{{ $ticket->catagory }} - {{ $ticket->location ?? 'Geen locatie' }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-gray-500 text-center">Geen planning voor deze week.</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Urgente Tickets</h2>
                    <button class="text-sm text-gray-600">Alle Tickets</button>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($urgentTickets as $ticket)
                    <div class="flex items-start p-4 gap-3">
                        <div class="w-2 h-2 {{ $ticket->priority === 'hoog' ? 'bg-red-500' : ($ticket->priority === 'medium' ? 'bg-yellow-500' : 'bg-green-500') }} rounded-full mt-2"></div>
                        <div class="flex-1">
                            <h4 class="font-medium text-sm">{{ $ticket->catagory }} - {{ $ticket->location ?? 'Onbekend' }}</h4>
                            <p class="text-sm text-gray-500">Toegewezen aan: {{ $ticket->user->name ?? 'Niet toegewezen' }}</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $ticket->status === 'open' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-800' }}">{{ ucfirst($ticket->status ?? 'Open') }}</span>
                    </div>
                    @empty
                    <div class="p-4 text-gray-500 text-center">Geen urgente tickets.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Voorraad Status</h2>
                    <button class="text-sm text-gray-600">Alles Bekijken</button>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($stockAlerts as $product)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <div class="text-sm">{{ $product->product_name }}</div>
                        <div class="text-sm font-medium {{ $product->stock < 5 ? 'text-red-600' : 'text-yellow-600' }}">
                            {{ $product->stock < 5 ? 'Kritiek' : 'Laag' }}: {{ $product->stock }} stuks
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-gray-500 text-center">Geen voorraad alerts.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>
</div>

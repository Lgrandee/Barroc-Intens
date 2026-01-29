<div>
@php($title = 'Sales Dashboard')

<div class="p-6 bg-[#f3f4f6]">
    <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl p-6 mb-6 shadow-lg">
        {{-- ... header ... --}}
        <h1 class="text-xl font-semibold mb-1">Goedemorgen, {{ auth()->user()->name ?? 'Gebruiker' }} 👋</h1>
        <p class="text-sm text-white/90 mb-4">Je hebt {{ $openTasksCount }} openstaande taken en {{ $newLeads }} nieuwe leads deze maand</p>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('offertes.create') }}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">+ Nieuwe Offerte</a>
            <a href="{{ route('customers.create') }}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">+ Contact Toevoegen</a>
            <a href="{{ route('offertes.index') }}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">Alle Offertes</a>
        </div>
    </div>

    {{-- ... stats ... --}}
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
                <!-- Alpine Component -->
                <div x-data="salesChart()" x-init="initChart()" class="flex flex-col">
                    <div class="flex items-center justify-between p-4 border-b border-gray-100">
                        <h2 class="text-lg font-medium">Sales Pipeline</h2>
                        <div class="flex gap-2">
                            <button @click="setFilter('maand')" :class="filter === 'maand' ? 'bg-blue-100 text-blue-700 border-blue-200' : 'bg-white text-gray-600 border-gray-200'" class="px-3 py-1 text-sm rounded border">Maand</button>
                            <button @click="setFilter('kwartaal')" :class="filter === 'kwartaal' ? 'bg-blue-100 text-blue-700 border-blue-200' : 'bg-white text-gray-600 border-gray-200'" class="px-3 py-1 text-sm rounded border">Kwartaal</button>
                            <button @click="setFilter('jaar')" :class="filter === 'jaar' ? 'bg-blue-100 text-blue-700 border-blue-200' : 'bg-white text-gray-600 border-gray-200'" class="px-3 py-1 text-sm rounded border">Jaar</button>
                        </div>
                    </div>
                    <div class="p-4" wire:ignore>
                        <div class="relative h-64 w-full">
                            <canvas x-ref="canvas"></canvas>
                        </div>
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
</div>
</div>
<script>
    function salesChart() {
        return {
            chart: null,
            filter: 'maand',
            initChart() {
                if (typeof Chart === 'undefined') { console.error('Chart.js not loaded'); return; }
                
                const ctx = this.$refs.canvas.getContext('2d');
                this.chart = new Chart(ctx, {
                    type: 'line',
                    data: { labels: [], datasets: [] },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        scales: {
                            y: { beginAtZero: true, grid: { display: true, borderDash: [2, 4] } },
                            x: { grid: { display: false } }
                        },
                        plugins: { legend: { display: true, position: 'bottom' }, tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.8)', padding: 12, cornerRadius: 8 } }
                    }
                });
                
                this.fetchData();
            },
            setFilter(val) {
                this.filter = val;
                this.fetchData();
            },
            fetchData() {
                this.$wire.getChartData(this.filter).then(data => {
                    this.chart.data = data;
                    this.chart.update();
                });
            }
        }
    }
</script>

<div>
@php($title = 'Finance Dashboard')

<div class="p-6 bg-[#f3f4f6]">
    <div class="bg-gradient-to-br from-yellow-500 to-orange-600 text-white rounded-xl p-6 mb-6 shadow-lg">
        <h1 class="text-xl font-semibold mb-1">Welkom, {{ auth()->user()->name ?? '' }}</h1>
        <p class="text-sm text-white/90 mb-4">Je hebt {{ $recentInvoices->where('status', '!=', 'betaald')->count() }} openstaande facturen en {{ $reminders->count() }} herinneringen voor deze week</p>
        <div class="flex flex-wrap gap-3">
            <button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">Nieuwe Factuur</button>
            <button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">Factuur Overzicht</button>
            <button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">Ticket Overzicht</button>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:space-x-6 gap-6 mb-6">
        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Omzet Deze Maand</h3>
            </div>
            <p class="text-2xl font-semibold mt-3">€{{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Openstaande Facturen</h3>
            </div>
            <p class="text-2xl font-semibold mt-3">€{{ number_format($outstandingAmount, 0, ',', '.') }}</p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Vervallen Facturen</h3>
            </div>
            <p class="text-2xl font-semibold mt-3">{{ $overduePercentage }}%</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <!-- Chart with Alpine handling everything -->
                <div x-data="{
                    chart: null,
                    filter: 'maand',
                    loading: false,
                    chartOptions: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { display: true, borderDash: [2, 4] },
                                ticks: {
                                    callback: function(value) {
                                        return '€' + value.toLocaleString('nl-NL');
                                    }
                                }
                            },
                            x: { grid: { display: false } }
                        },
                        plugins: {
                            legend: { display: true, position: 'bottom' },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': €' + context.parsed.y.toLocaleString('nl-NL');
                                    }
                                }
                            }
                        }
                    },
                    createChart(data) {
                        if (this.chart) {
                            this.chart.destroy();
                        }
                        const ctx = this.$refs.canvas.getContext('2d');
                        this.chart = new Chart(ctx, {
                            type: 'line',
                            data: data,
                            options: this.chartOptions
                        });
                    },
                    initChart() {
                        if (typeof Chart === 'undefined') return;
                        this.createChart(@js($chartData));
                    },
                    setFilter(newFilter) {
                        if (this.loading) return;
                        this.filter = newFilter;
                        this.loading = true;
                        $wire.getChartData(newFilter).then(data => {
                            if (data && data.labels && data.datasets) {
                                this.createChart(data);
                            }
                            this.loading = false;
                        }).catch(err => {
                            console.error('Chart data error:', err);
                            this.loading = false;
                        });
                    }
                }" x-init="initChart()" class="flex flex-col">
                    <div class="flex items-center justify-between p-4 border-b border-gray-100">
                        <h2 class="text-lg font-medium">Cashflow Overzicht</h2>
                        <div class="flex gap-2">
                            <button @click="setFilter('maand')" :class="filter === 'maand' ? 'bg-yellow-100 text-yellow-700 border-yellow-200' : 'bg-white text-gray-600 border-gray-200'" class="px-3 py-1 text-sm rounded border">Maand</button>
                            <button @click="setFilter('kwartaal')" :class="filter === 'kwartaal' ? 'bg-yellow-100 text-yellow-700 border-yellow-200' : 'bg-white text-gray-600 border-gray-200'" class="px-3 py-1 text-sm rounded border">Kwartaal</button>
                            <button @click="setFilter('jaar')" :class="filter === 'jaar' ? 'bg-yellow-100 text-yellow-700 border-yellow-200' : 'bg-white text-gray-600 border-gray-200'" class="px-3 py-1 text-sm rounded border">Jaar</button>
                        </div>
                    </div>
                    <div class="p-4 relative">
                        <div x-show="loading" class="absolute inset-0 bg-white/50 flex items-center justify-center z-10">
                            <span class="text-gray-500">Laden...</span>
                        </div>
                        <div class="relative h-64 w-full">
                            <canvas x-ref="canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Recente Facturen</h2>
                    <button class="text-sm text-gray-600">Alles Bekijken</button>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentInvoices as $invoice)
                    <div class="flex items-center p-4">
                        <div class="flex-1 mr-4">
                            <h4 class="font-medium">Factuur #{{ $invoice->id }}</h4>
                            <p class="text-sm text-gray-500">{{ $invoice->customer->name_company ?? 'Onbekend' }} - Vervaldatum: {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <div class="font-medium">€{{ number_format($invoice->total_amount, 0, ',', '.') }}</div>
                            @if(in_array($invoice->status, ['betaald', 'paid']))
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700">{{ ucfirst($invoice->status) }}</span>
                            @elseif($invoice->status === 'verlopen')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-50 text-red-700">{{ ucfirst($invoice->status) }}</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-50 text-yellow-800">{{ ucfirst($invoice->status) }}</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-gray-500 text-center">Geen recente facturen.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Betalingsherinneringen</h2>
                    <button class="text-sm text-gray-600">+ Herinnering</button>
                </div>
                <div class="p-3 space-y-2">
                    @forelse($reminders as $reminder)
                    <div class="flex items-start gap-3 p-4 border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex-1">
                            <p class="text-sm font-medium mb-1">Herinnering sturen naar {{ $reminder->customer->name_company ?? 'Onbekend' }}</p>
                            <p class="text-xs text-gray-500">Vervaldatum: {{ \Carbon\Carbon::parse($reminder->due_date)->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-gray-500 text-center">Geen betalingsherinneringen.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div>
<?php ($title = 'Admin Dashboard'); ?>

<div class="p-6 bg-[#F3F4F6]">
    <div class="bg-gradient-to-br from-blue-700 to-blue-500 text-white rounded-xl p-6 mb-6 shadow-lg">
        <h1 class="text-xl font-semibold mb-1">Welkom, <?php echo e(auth()->user()->name ?? ''); ?></h1>
        <p class="text-sm text-white/90 mb-4">Je hebt <?php echo e($openInvoicesCount); ?> openstaande facturen en <?php echo e($reminders->count()); ?> herinneringen voor deze week</p>
        <div class="flex flex-wrap gap-3">
            <a href="<?php echo e(route('management.users.index')); ?>" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">Gebruikers Beheren</a>
            <a href="<?php echo e(route('management.roles.index')); ?>" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">Rollen Overzicht</a>
            <a href="<?php echo e(route('planner.dashboard')); ?>" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">Planner Dashboard</a>
            <a href="<?php echo e(route('product.stock')); ?>" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">Voorraadbeheer</a>
            <a href="<?php echo e(route('customers.index')); ?>" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">Klanten Beheren</a>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:space-x-6 gap-6 mb-6">
        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Omzet Deze Maand</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-yellow-100 text-yellow-700 rounded">💰</div>
            </div>
            <p class="text-2xl font-semibold mt-3">€<?php echo e(number_format($monthlyRevenue, 0, ',', '.')); ?></p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Actieve Collega's</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-yellow-100 text-yellow-700 rounded">📝</div>
            </div>
            <p class="text-2xl font-semibold mt-3"><?php echo e($activeUsers); ?></p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Openstaande tickets</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-yellow-100 text-yellow-700 rounded">⏱️</div>
            </div>
            <p class="text-2xl font-semibold mt-3"><?php echo e($openTicketsCount); ?></p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Achterstallige Facturen</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-700 rounded">⚠️</div>
            </div>
            <p class="text-2xl font-semibold mt-3"><?php echo e($lateInvoicesCount); ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
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
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return '€' + context.parsed.y.toLocaleString('nl-NL');
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
                        this.createChart(<?php echo \Illuminate\Support\Js::from($chartData)->toHtml() ?>);
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

            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Recente Facturen</h2>
                    <button class="text-sm text-gray-600">Alles Bekijken</button>
                </div>
                <div class="divide-y divide-gray-100">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $recentInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center p-4">
                        <div class="flex-1 mr-4">
                            <h4 class="font-medium">Factuur #<?php echo e($invoice->id); ?></h4>
                            <p class="text-sm text-gray-500"><?php echo e($invoice->customer->name_company ?? 'Onbekend'); ?> - Vervaldatum: <?php echo e(\Carbon\Carbon::parse($invoice->due_date)->format('d M Y')); ?></p>
                        </div>
                        <div class="text-right">
                            <div class="font-medium">€<?php echo e(number_format($invoice->total_amount, 2, ',', '.')); ?></div>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-50 text-yellow-800"><?php echo e($invoice->status); ?></span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-4 text-gray-500 text-center">Geen recente facturen.</div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Betalingsherinneringen</h2>
                </div>
                <div class="p-3 space-y-2">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $reminders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reminder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg">
                        <div class="w-8 h-8 bg-yellow-100 rounded flex items-center justify-center text-yellow-700">💰</div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">Herinnering versturen naar <?php echo e($reminder->customer->name_company ?? 'Onbekend'); ?></p>
                            <p class="text-xs text-gray-500">Vervaldatum: <?php echo e(\Carbon\Carbon::parse($reminder->due_date)->diffForHumans()); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-4 text-gray-500 text-center">Geen betalingsherinneringen.</div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/livewire/dashboards/admin-dashboard.blade.php ENDPATH**/ ?>
<div wire:poll.2s>
<?php ($title = 'Finance Dashboard'); ?>

<div class="p-6 bg-[#FAF9F6]">
    <div class="bg-gradient-to-br from-yellow-500 to-orange-600 text-white rounded-xl p-6 mb-6 shadow-lg">
        <h1 class="text-xl font-semibold mb-1">Welkom, <?php echo e(auth()->user()->name ?? ''); ?></h1>
        <p class="text-sm text-white/90 mb-4">Je hebt <?php echo e($recentInvoices->where('status', '!=', 'betaald')->count()); ?> openstaande facturen en <?php echo e($reminders->count()); ?> herinneringen voor deze week</p>
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
            <p class="text-2xl font-semibold mt-3">€<?php echo e(number_format($monthlyRevenue, 0, ',', '.')); ?></p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Openstaande Facturen</h3>
            </div>
            <p class="text-2xl font-semibold mt-3">€<?php echo e(number_format($outstandingAmount, 0, ',', '.')); ?></p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Vervallen Facturen</h3>
            </div>
            <p class="text-2xl font-semibold mt-3"><?php echo e($overduePercentage); ?>%</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Cashflow Overzicht</h2>
                    <div class="flex gap-2">
                        <button class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded border border-yellow-200">Maand</button>
                        <button class="px-3 py-1 text-sm bg-white text-gray-600 rounded border border-gray-200">Kwartaal</button>
                        <button class="px-3 py-1 text-sm bg-white text-gray-600 rounded border border-gray-200">Jaar</button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg p-8 text-center">
                        <p class="text-gray-500">Hier komt een lijngrafiek met inkomsten vs uitgaven</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
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
                            <div class="font-medium">€<?php echo e(number_format($invoice->total_amount, 0, ',', '.')); ?></div>
                            <!--[if BLOCK]><![endif]--><?php if(in_array($invoice->status, ['betaald', 'paid'])): ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700"><?php echo e(ucfirst($invoice->status)); ?></span>
                            <?php elseif($invoice->status === 'verlopen'): ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-50 text-red-700"><?php echo e(ucfirst($invoice->status)); ?></span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-50 text-yellow-800"><?php echo e(ucfirst($invoice->status)); ?></span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-4 text-gray-500 text-center">Geen recente facturen.</div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $reminders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reminder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-start gap-3 p-4 border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex-1">
                            <p class="text-sm font-medium mb-1">Herinnering sturen naar <?php echo e($reminder->customer->name_company ?? 'Onbekend'); ?></p>
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
<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/livewire/dashboards/finance-dashboard.blade.php ENDPATH**/ ?>
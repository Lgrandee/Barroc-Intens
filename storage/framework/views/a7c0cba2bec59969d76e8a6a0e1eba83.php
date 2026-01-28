<div wire:poll.2s>
<?php ($title = 'Technician Dashboard'); ?>

<div class="p-6 bg-[#FAF9F6]">
    <div class="bg-gradient-to-br from-red-500 to-red-700 text-white rounded-xl p-6 mb-6 shadow-lg">
        <h1 class="text-xl font-semibold mb-1">Goedemorgen, <?php echo e(auth()->user()->name ?? 'Gebruiker'); ?> 👋</h1>
        <p class="text-sm text-white/90 mb-4">Je hebt <?php echo e($scheduledServicesCount); ?> geplande services en <?php echo e($urgentTickets->where('priority', 'hoog')->count()); ?> urgente tickets voor deze week</p>
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
            <p class="text-2xl font-semibold mt-3"><?php echo e($openTicketsCount); ?></p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Geplande Service</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-700 rounded">🔧</div>
            </div>
            <p class="text-2xl font-semibold mt-3"><?php echo e($scheduledServicesCount); ?></p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Gemiddelde Responstijd</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-700 rounded">⏱️</div>
            </div>
            <p class="text-2xl font-semibold mt-3"><?php echo e(number_format($avgResponseTime, 1)); ?>d</p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Voorraad Alerts</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-700 rounded">⚠️</div>
            </div>
            <p class="text-2xl font-semibold mt-3"><?php echo e($stockAlertsCount); ?></p>
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
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $weeklyPlanning; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day => $tickets): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border border-gray-200 rounded-lg p-3 shadow-sm">
                        <div class="font-medium text-sm mb-2"><?php echo e($day); ?></div>
                        <div class="space-y-2">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center gap-2 p-2 bg-gray-50 rounded text-sm">
                                <span class="font-medium min-w-12"><?php echo e(\Carbon\Carbon::parse($ticket->scheduled_time)->format('H:i')); ?></span>
                                <span><?php echo e($ticket->catagory); ?> - <?php echo e($ticket->location ?? 'Geen locatie'); ?></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-4 text-gray-500 text-center">Geen planning voor deze week.</div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Urgente Tickets</h2>
                    <button class="text-sm text-gray-600">Alle Tickets</button>
                </div>
                <div class="divide-y divide-gray-100">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $urgentTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-start p-4 gap-3">
                        <div class="w-2 h-2 <?php echo e($ticket->priority === 'hoog' ? 'bg-red-500' : ($ticket->priority === 'medium' ? 'bg-yellow-500' : 'bg-green-500')); ?> rounded-full mt-2"></div>
                        <div class="flex-1">
                            <h4 class="font-medium text-sm"><?php echo e($ticket->catagory); ?> - <?php echo e($ticket->location ?? 'Onbekend'); ?></h4>
                            <p class="text-sm text-gray-500">Toegewezen aan: <?php echo e($ticket->user->name ?? 'Niet toegewezen'); ?></p>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium <?php echo e($ticket->status === 'open' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-800'); ?>"><?php echo e(ucfirst($ticket->status ?? 'Open')); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-4 text-gray-500 text-center">Geen urgente tickets.</div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $stockAlerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <div class="text-sm"><?php echo e($product->product_name); ?></div>
                        <div class="text-sm font-medium <?php echo e($product->stock < 5 ? 'text-red-600' : 'text-yellow-600'); ?>">
                            <?php echo e($product->stock < 5 ? 'Kritiek' : 'Laag'); ?>: <?php echo e($product->stock); ?> stuks
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-4 text-gray-500 text-center">Geen voorraad alerts.</div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/livewire/dashboards/technician-dashboard.blade.php ENDPATH**/ ?>
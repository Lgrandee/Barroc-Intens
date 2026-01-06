<div wire:poll.2s>
<?php ($title = 'Planner Dashboard'); ?>

<div class="p-6 bg-[#FAF9F6]">
    <div class="bg-gradient-to-br from-purple-600 to-purple-800 text-white rounded-xl p-6 mb-6 shadow-lg">
        <h1 class="text-xl font-semibold mb-1">Goedemorgen, <?php echo e(auth()->user()->name ?? 'Gebruiker'); ?> 👋</h1>
        <p class="text-sm text-white/90 mb-4">Je hebt <?php echo e($plannedTasksCount); ?> taken ingepland voor deze week en <?php echo e($backlogCount); ?> achterstallige taken</p>
        <div class="flex flex-wrap gap-3">
            <button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">+ Nieuwe Planning</button>
            <button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">👥 Teamcapaciteit</button>
            <button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">📊 Overzicht</button>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:space-x-6 gap-6 mb-6">
        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Geplande Taken</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-purple-100 text-purple-700 rounded">📅</div>
            </div>
            <p class="text-2xl font-semibold mt-3"><?php echo e($plannedTasksCount); ?></p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Voltooide Taken</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-purple-100 text-purple-700 rounded">✅</div>
            </div>
            <p class="text-2xl font-semibold mt-3"><?php echo e($completedTasksCount); ?></p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Team Capaciteit</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-purple-100 text-purple-700 rounded">👥</div>
            </div>
            <p class="text-2xl font-semibold mt-3"><?php echo e($teamCapacityPercent); ?>%</p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Achterstand</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-700 rounded">⚠️</div>
            </div>
            <p class="text-2xl font-semibold mt-3"><?php echo e($backlogCount); ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Wekelijks Overzicht</h2>
                    <div class="flex gap-2">
                        <button class="px-3 py-1 text-sm bg-purple-100 text-purple-700 rounded border border-purple-200">Deze Week</button>
                        <button class="px-3 py-1 text-sm bg-white text-gray-600 rounded border border-gray-200">Volgende Week</button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $weeklyOverview; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-medium text-sm"><?php echo e($day['label']); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($day['tasks']); ?> taken gepland</div>
                            </div>
                            <div class="text-sm <?php echo e($day['percent'] > 100 ? 'text-red-600' : ($day['percent'] > 80 ? 'text-yellow-600' : 'text-green-600')); ?>"><?php echo e($day['percent']); ?>% capaciteit</div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Team Planning</h2>
                    <button class="text-sm text-gray-600">Kalender Weergave</button>
                </div>
                <div class="divide-y divide-gray-100">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $teamSchedule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-medium text-sm"><?php echo e($member->name); ?></div>
                            <div class="text-xs <?php echo e($member->planningTickets->count() > 3 ? 'text-yellow-600' : 'text-green-600'); ?>">
                                <?php echo e($member->planningTickets->count() > 3 ? 'Bijna vol' : 'Beschikbaar'); ?>

                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            <!--[if BLOCK]><![endif]--><?php if($member->planningTickets->count() > 0): ?>
                                Vandaag: <?php echo e($member->planningTickets->count()); ?> afspraken - <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $member->planningTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e(\Carbon\Carbon::parse($t->scheduled_time)->format('H:i')); ?><!--[if BLOCK]><![endif]--><?php if(!$loop->last): ?>, <?php endif; ?><!--[if ENDBLOCK]><![endif]--> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php else: ?>
                                Vandaag: Geen afspraken
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-4 text-gray-500 text-center">Geen teamleden gevonden.</div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Urgente Aanpassingen</h2>
                    <button class="text-sm text-gray-600">Alle Meldingen</button>
                </div>
                <div class="divide-y divide-gray-100">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $urgentChanges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $change): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-4">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 <?php echo e($change->priority === 'hoog' ? 'bg-red-500' : 'bg-blue-500'); ?> rounded-full mt-2"></div>
                            <div class="flex-1">
                                <div class="font-medium text-sm"><?php echo e($change->catagory); ?> - <?php echo e($change->location ?? 'Geen locatie'); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($change->user->name ?? 'Niet toegewezen'); ?></div>
                                <div class="text-xs text-gray-400"><?php echo e($change->created_at->diffForHumans()); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-4 text-gray-500 text-center">Geen urgente aanpassingen.</div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/livewire/dashboards/planner-dashboard.blade.php ENDPATH**/ ?>
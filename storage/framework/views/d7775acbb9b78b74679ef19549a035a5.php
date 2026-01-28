<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Mijn Planning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Mijn Planning')]); ?>
        <main class="p-6">
            <!-- Header -->
            <header class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Mijn Planning</h1>
                <p class="text-sm text-gray-600 mt-1">Overzicht van al je geplande taken: onderhoud, installaties en afspraken</p>
            </header>

            <!-- Main Content -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <!-- Search and Filter -->
                <form method="GET" action="<?php echo e(route('technician.planning')); ?>" class="flex gap-3 mb-6" id="filterForm">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" placeholder="Zoek op klant of locatie..."
                            value="<?php echo e(request('search')); ?>"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <select name="category" onchange="document.getElementById('filterForm').submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-700">
                        <option value="">Alle types</option>
                        <option value="service" <?php echo e(request('category') === 'service' ? 'selected' : ''); ?>>Onderhoud</option>
                        <option value="installation" <?php echo e(request('category') === 'installation' ? 'selected' : ''); ?>>Installatie</option>
                        <option value="meeting" <?php echo e(request('category') === 'meeting' ? 'selected' : ''); ?>>Afspraak</option>
                    </select>
                    <select name="status" onchange="document.getElementById('filterForm').submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-700">
                        <option value="">Alle statussen</option>
                        <option value="open" <?php echo e(request('status') === 'open' ? 'selected' : ''); ?>>Open</option>
                        <option value="te_laat" <?php echo e(request('status') === 'te_laat' ? 'selected' : ''); ?>>Te laat</option>
                        <option value="voltooid" <?php echo e(request('status') === 'voltooid' ? 'selected' : ''); ?>>Voltooid</option>
                        <option value="probleem" <?php echo e(request('status') === 'probleem' ? 'selected' : ''); ?>>Probleem</option>
                    </select>
                    <button type="submit" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium text-sm">
                        Filter
                    </button>
                    <?php if(request('search') || request('status') || request('category')): ?>
                    <a href="<?php echo e(route('technician.planning')); ?>"
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm">
                        Reset
                    </a>
                    <?php endif; ?>
                </form>

                <!-- Tasks Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klant</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Beschrijving</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locatie</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $planningTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($task->catagory === 'service'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-800">Onderhoud</span>
                                    <?php elseif($task->catagory === 'installation'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-purple-100 text-purple-800">Installatie</span>
                                    <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-800">Afspraak</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($task->feedback?->customer?->name_company ?? 'Intern'); ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900"><?php echo e($task->feedback?->description ?? '-'); ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900"><?php echo e($task->location); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo e(\Carbon\Carbon::parse($task->scheduled_time)->format('d-m-Y H:i')); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($task->status === 'voltooid'): ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Voltooid</span>
                                    <?php elseif($task->status === 'probleem'): ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Probleem</span>
                                    <?php elseif($task->status === 'te_laat'): ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Te laat</span>
                                    <?php else: ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Open</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="<?php echo e(route('technician.onderhoud.show', $task->id)); ?>"
                                       class="text-indigo-600 hover:text-indigo-900 mr-3">Bekijk</a>
                                    <?php if($task->status === 'open' || $task->status === 'te_laat'): ?>
                                    <a href="<?php echo e(route('technician.onderhoud.rapport', $task->id)); ?>"
                                       class="text-green-600 hover:text-green-900">Rapport</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p>Geen taken gevonden</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($planningTickets->hasPages()): ?>
                <div class="mt-4">
                    <?php echo e($planningTickets->appends(request()->query())->links()); ?>

                </div>
                <?php endif; ?>
            </div>
        </main>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/technician/planning.blade.php ENDPATH**/ ?>
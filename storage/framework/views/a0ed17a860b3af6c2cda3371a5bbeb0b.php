<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Ticket overzicht']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Ticket overzicht')]); ?>
    <main class="p-6">
        <!-- Header -->
        <header class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Ticket overzicht</h1>
        </header>

        <!-- Main Content -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Alle tickets</h2>
                <a href="<?php echo e(route('planner.tickets.create')); ?>"
                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium text-sm">
                    Nieuw ticket
                </a>
            </div>

            <!-- Filters -->
            <form method="GET" action="<?php echo e(route('planner.tickets.index')); ?>" class="flex gap-3 mb-6" id="filterForm">
                <input type="text" name="search" placeholder="Zoek op onderwerp, klant of ticketnummer"
                    value="<?php echo e(request('search')); ?>"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

                <select name="status" onchange="document.getElementById('filterForm').submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-700">
                    <option value="">Alle statussen</option>
                    <option value="open" <?php echo e(request('status') === 'open' ? 'selected' : ''); ?>>Open</option>
                    <option value="te_laat" <?php echo e(request('status') === 'te_laat' ? 'selected' : ''); ?>>In behandeling</option>
                    <option value="voltooid" <?php echo e(request('status') === 'voltooid' ? 'selected' : ''); ?>>Gesloten</option>
                </select>

                <select name="priority" onchange="document.getElementById('filterForm').submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-700">
                    <option value="">Alle prioriteiten</option>
                    <option value="hoog" <?php echo e(request('priority') === 'hoog' ? 'selected' : ''); ?>>Hoog</option>
                    <option value="medium" <?php echo e(request('priority') === 'medium' ? 'selected' : ''); ?>>Medium</option>
                    <option value="laag" <?php echo e(request('priority') === 'laag' ? 'selected' : ''); ?>>Laag</option>
                </select>

                <select name="department" onchange="document.getElementById('filterForm').submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-700">
                    <option value="">Alle afdelingen</option>
                    <option value="service" <?php echo e(request('department') === 'service' ? 'selected' : ''); ?>>Service</option>
                    <option value="installation" <?php echo e(request('department') === 'installation' ? 'selected' : ''); ?>>Installatie</option>
                    <option value="meeting" <?php echo e(request('department') === 'meeting' ? 'selected' : ''); ?>>Meeting</option>
                </select>

                <button type="submit" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm">
                    Filteren
                </button>
            </form>

            <!-- Tickets Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Onderwerp</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klant</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioriteit</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Laatste update</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actie</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900"><?php echo e($ticket->feedback?->description ?? 'Geen onderwerp'); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e(ucfirst($ticket->catagory)); ?> — #TCK-<?php echo e(date('Y')); ?>-<?php echo e(str_pad($ticket->id, 3, '0', STR_PAD_LEFT)); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo e($ticket->feedback?->customer?->name_company ?? 'Onbekend'); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                    $priority = $ticket->priority ?? 'medium';
                                ?>
                                <?php if($priority === 'hoog'): ?>
                                    <span class="text-red-600 font-medium">Hoog</span>
                                <?php elseif($priority === 'medium'): ?>
                                    <span class="text-orange-600 font-medium">Medium</span>
                                <?php elseif($priority === 'laag'): ?>
                                    <span class="text-green-600 font-medium">Laag</span>
                                <?php else: ?>
                                    <span class="text-gray-600 font-medium">Geen</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo e(\Carbon\Carbon::parse($ticket->updated_at)->format('d M Y')); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($ticket->status === 'voltooid'): ?>
                                    <span class="text-green-600 font-medium">Gesloten</span>
                                <?php elseif($ticket->status === 'te_laat'): ?>
                                    <span class="text-orange-600 font-medium">In behandeling</span>
                                <?php else: ?>
                                    <span class="text-blue-600 font-medium">Open</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <a href="<?php echo e(route('planner.tickets.show', $ticket->id)); ?>"
                                   class="text-indigo-600 hover:text-indigo-900 underline font-medium">
                                    Bekijk
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="mt-2">Geen tickets gevonden</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($tickets->hasPages()): ?>
            <div class="mt-6 flex justify-between items-center">
                <div class="text-sm text-gray-700">
                    Tonen <?php echo e($tickets->firstItem() ?? 0); ?>–<?php echo e($tickets->lastItem() ?? 0); ?> van <?php echo e($tickets->total()); ?>

                </div>
                <div class="flex gap-1">
                    <?php echo e($tickets->appends(request()->query())->links()); ?>

                </div>
            </div>
            <?php endif; ?>

            <!-- Bottom Link -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <a href="<?php echo e(route('planner.dashboard')); ?>" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium underline">
                    Terug naar wireframe
                </a>
            </div>
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
<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/planner/tickets/index.blade.php ENDPATH**/ ?>
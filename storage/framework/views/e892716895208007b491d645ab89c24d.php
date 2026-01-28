<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Contract Overview']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Contract Overview')]); ?>
  <style>
    /* Light-only page background override */
    html:not(.dark) body { background-color: #f3f4f6 !important; }
  </style>
  <main class="p-6 min-h-screen">
    <header class="mb-6 flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl font-semibold text-black dark:text-white">Contract Overview</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">View active, expired and upcoming expiring contracts</p>
      </div>
    </header>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Active Contracts</div>
        <div class="text-2xl font-semibold text-black dark:text-white"><?php echo e($totalActive ?? 0); ?></div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Currently active</div>
      </div>

      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Total Contracts</div>
        <div class="text-2xl font-semibold text-black dark:text-white"><?php echo e(\App\Models\Contract::count()); ?></div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">All contracts</div>
      </div>

      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Expiring Soon</div>
        <div class="text-2xl font-semibold text-orange-600">0</div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Next 30 days</div>
      </div>

      <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-4 shadow">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Expired</div>
        <div class="text-2xl font-semibold text-red-600">0</div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Inactive</div>
      </div>
    </div>

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
      <!-- Header with New contract button -->
      <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
        <h2 class="text-lg font-semibold text-black dark:text-white">Contracts</h2>
        <a href="<?php echo e(route('contracts.create')); ?>" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-3 py-1.5 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
          <span class="inline-block h-2 w-2 rounded-full bg-black"></span>
          New contract
        </a>
      </div>

      <div class="p-4">
        <div class="rounded-lg border border-gray-100 dark:border-zinc-700 bg-white dark:bg-zinc-900">
          <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('contract-table');

$__html = app('livewire')->mount($__name, $__params, 'lw-2843083551-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>
      </div>
    </div>

    <!-- Footer text -->
    <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
      Contract overview — management and actions
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
<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/contract/index.blade.php ENDPATH**/ ?>
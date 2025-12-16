<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Factuur Overzicht']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Factuur Overzicht')]); ?>
  <main class="p-6">
    <header class="mb-6">
      <a href="<?php echo e(route('finance.dashboard')); ?>" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium mb-2 inline-block">← Terug naar Index</a>
      <h1 class="text-2xl font-semibold">Factuur Overzicht</h1>
      <p class="text-sm text-gray-500">Beheer en monitor alle facturen</p>
    </header>

    <?php if(session('success')): ?>
      <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded-md">
        <?php echo e(session('success')); ?>

      </div>
    <?php endif; ?>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <?php
        $facturen = \App\Models\Factuur::with('products')->get();
        $totalAmount = $facturen->sum(function($f) { return $f->total_amount; });
        $openstaand = $facturen->whereIn('status', ['verzonden', 'concept'])->sum(function($f) { return $f->total_amount; });
        $verlopen = $facturen->where('status', 'verlopen')->sum(function($f) { return $f->total_amount; });

        // Calculate average overdue days
        $verlopenFacturen = \App\Models\Factuur::where('status', 'verlopen')
          ->where('due_date', '<', now())
          ->get();
        $overdueDays = $verlopenFacturen->count() > 0
          ? $verlopenFacturen->avg(function($f) {
              return \Carbon\Carbon::parse($f->due_date)->diffInDays(now());
            })
          : 0;
      ?>

      <div class="bg-white border border-gray-200 rounded-lg p-4">
        <div class="text-sm text-gray-500 mb-1">Totaal Facturen</div>
        <div class="text-2xl font-semibold text-gray-900">€<?php echo e(number_format($totalAmount, 0, ',', '.')); ?></div>
        <div class="text-xs text-gray-500 mt-1"><?php echo e(\App\Models\Factuur::count()); ?> facturen deze maand</div>
      </div>

      <div class="bg-white border border-gray-200 rounded-lg p-4">
        <div class="text-sm text-gray-500 mb-1">Openstaand</div>
        <div class="text-2xl font-semibold text-gray-900">€<?php echo e(number_format($openstaand, 0, ',', '.')); ?></div>
        <div class="text-xs text-gray-500 mt-1"><?php echo e(\App\Models\Factuur::whereIn('status', ['verzonden', 'concept'])->count()); ?> facturen te betalen</div>
      </div>

      <div class="bg-white border border-gray-200 rounded-lg p-4">
        <div class="text-sm text-gray-500 mb-1">Verlopen</div>
        <div class="text-2xl font-semibold text-red-600">€<?php echo e(number_format($verlopen, 0, ',', '.')); ?></div>
        <div class="text-xs text-gray-500 mt-1"><?php echo e(\App\Models\Factuur::where('status', 'verlopen')->count()); ?> facturen > 30 dagen</div>
      </div>

      <div class="bg-white border border-gray-200 rounded-lg p-4">
        <div class="text-sm text-gray-500 mb-1">Gemiddelde Betaaltijd</div>
        <div class="text-2xl font-semibold text-gray-900"><?php echo e(number_format($overdueDays ?? 0, 1)); ?></div>
        <div class="text-xs text-gray-500 mt-1">dagen in november</div>
      </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
      <!-- Header with New factuur button -->
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <div class="flex items-center gap-4">
          <h2 class="text-lg font-medium">📄 Facturen</h2>
          <div class="flex gap-2">
            <button class="text-sm text-gray-600 hover:text-gray-900">📤 Verzenden</button>
            <button class="text-sm text-gray-600 hover:text-gray-900">🗑️ Verwijderen</button>
            <button class="text-sm text-gray-600 hover:text-gray-900">👤 Exporteren</button>
          </div>
        </div>
        <a href="<?php echo e(route('facturen.create')); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
          + Nieuwe Factuur
        </a>
      </div>

      <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('factuur-table');

$__html = app('livewire')->mount($__name, $__params, 'lw-931365682-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
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
<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/factuur/index.blade.php ENDPATH**/ ?>
<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div class="max-w-6xl mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">Bestellingen backlog</h1>

  <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
    <div class="grid grid-cols-5 gap-0 font-semibold text-sm bg-gray-50 text-gray-600 p-4 border-b border-gray-200">
      <div class="text-black">Product</div>
      <div class="text-black">Aantal</div>
      <div class="text-black">Prijs (per stuk)</div>
      <div class="text-black">Totaal</div>
      <div class="text-black">Wanneer</div>
    </div>

    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="grid grid-cols-5 items-center p-4 border-b border-gray-100 text-sm">
        <div class="text-black"><?php echo e($log->product?->product_name ?? '—'); ?></div>
        <div class="text-black"><?php echo e($log->amount); ?></div>
        <div class="text-black">€ <?php echo e(number_format($log->price ?? 0, 2, ',', '.')); ?></div>
        <div class="text-black">€ <?php echo e(number_format(($log->price ?? 0) * ($log->amount ?? 0), 2, ',', '.')); ?></div>
        <div class="text-gray-500 text-xs"><?php echo e($log->created_at?->format('d-m-Y H:i') ?? '-'); ?></div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="p-6 text-center text-gray-500">Er zijn nog geen bestellingen in de backlog.</div>
    <?php endif; ?>
  </div>

  <div class="mt-4">
    <a href="<?php echo e(route('products.order')); ?>" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Nieuwe bestelling</a>
    <a href="<?php echo e(route('product.stock')); ?>" class="ml-2 px-4 py-2 border rounded text-gray-700 hover:bg-gray-50">Voorraad</a>
  </div>
</div>
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
<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/purchasing/orderLogistics.blade.php ENDPATH**/ ?>
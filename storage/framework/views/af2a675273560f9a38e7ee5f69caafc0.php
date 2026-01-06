<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Product Bestellen']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Product Bestellen']); ?>
    <div class="max-w-6xl mx-auto p-6 bg-gray-100 min-h-screen">
        <?php if(session('success')): ?>
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded p-4">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('products.order.store')); ?>" method="POST" class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-5 font-semibold text-sm bg-gray-50 text-gray-600 p-4 border-b border-gray-200">
                <div class="text-black">Productnaam</div>
                <div class="text-black">Voorraad</div>
                <div class="text-black">Prijs (per stuk)</div>
                <div class="text-black">Type</div>
                <div class=" text-black">Aantal</div>
            </div>

            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="grid grid-cols-5 items-center p-4 border-b border-gray-200 text-sm gap-2 hover:bg-gray-50 transition">
                <div class="text-black font-medium"><?php echo e($product->product_name); ?></div>
                <div class="text-black"><?php echo e($product->stock); ?></div>
                <div class="text-black">€ <?php echo e(number_format($product->price ?? 0, 2, ',', '.')); ?></div>
                <div class="text-black capitalize"><?php echo e($product->type); ?></div>

                <div class="flex justify-end items-center gap-2 text-black">
                    <div class="inline-flex items-center border rounded-md overflow-hidden bg-white">
                        <button type="button" class="px-3 py-1 text-gray-700 hover:bg-gray-100 qty-btn" data-id="<?php echo e($product->id); ?>" data-delta="-1">−</button>
                        <input
                            type="number"
                            name="quantities[<?php echo e($product->id); ?>]"
                            id="qty-<?php echo e($product->id); ?>"
                            value="0"
                            min="0"
                            class="w-16 text-center border-l border-r border-gray-200 focus:outline-none focus:ring-0"
                        >
                        <button type="button" class="px-3 py-1 text-gray-700 hover:bg-gray-100 qty-btn" data-id="<?php echo e($product->id); ?>" data-delta="1">＋</button>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="p-4 flex justify-end gap-3 bg-gray-50 border-t border-gray-200">
                <a href="<?php echo e(route('product.stock')); ?>" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-white transition bg-white shadow-sm">Terug</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition shadow-sm">Bestelling Plaatsen</button>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('.qty-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const delta = parseInt(this.dataset.delta, 10);
                const input = document.getElementById('qty-' + id);
                let v = parseInt(input.value || '0', 10);
                v = Math.max(0, v + delta);
                input.value = v;
            });
        });

        // Laat numerieke input niet onder 0 komen
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', () => {
                if (input.value === '') return;
                let v = parseInt(input.value, 10);
                if (isNaN(v) || v < 0) input.value = 0;
            });
        });
    </script>
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
<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/purchasing/orderProduct.blade.php ENDPATH**/ ?>
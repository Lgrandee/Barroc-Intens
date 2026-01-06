<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Productvoorraad']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Productvoorraad']); ?>
    <div class="max-w-6xl mx-auto p-6 bg-gray-100 min-h-screen">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Productvoorraad</h1>
                <p class="text-gray-500 text-sm">Overzicht van alle producten en voorraadniveaus</p>
            </div>
            <div>
                <a href="<?php echo e(route('products.order')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                    + Nieuwe Bestelling
                </a>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
            <div class="grid grid-cols-5 font-semibold text-sm bg-gray-50 text-gray-600 p-4 border-b border-gray-200">
                <div>Productnaam</div>
                <div>Voorraad</div>
                <div>Prijs (per stuk)</div>
                <div>Type</div>
                <?php if(optional(auth()->user())->department === 'Management'): ?>
                <div>Acties</div>
                <?php else: ?>
                <div></div>
                <?php endif; ?>
            </div>

            <div class="divide-y divide-gray-100">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="grid grid-cols-5 p-4 items-center text-sm hover:bg-gray-50 transition">
                    <div class="font-medium text-gray-900"><?php echo e($product->product_name); ?></div>
                    <div>
                         <?php if($product->stock < 5): ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800"><?php echo e($product->stock); ?> (Kritiek)</span>
                        <?php elseif($product->stock < 15): ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800"><?php echo e($product->stock); ?> (Laag)</span>
                        <?php else: ?>
                            <span class="text-gray-700"><?php echo e($product->stock); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="text-gray-600">€ <?php echo e(number_format($product->price, 2, ',', '.')); ?></div>
                    <div class="capitalize text-gray-600"><?php echo e($product->type); ?></div>

                    <?php if(optional(auth()->user())->department === 'Management'): ?>
                    <div class="flex gap-2">
                        <a href="#" class="p-1 text-gray-400 hover:text-blue-600 transition" title="Bewerken">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                        <a href="#" class="p-1 text-gray-400 hover:text-red-600 transition" title="Verwijderen">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </a>
                    </div>
                    <?php else: ?>
                    <div></div>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php if($products->isEmpty()): ?>
            <div class="p-8 text-center text-gray-500">
                <p>Geen producten gevonden.</p>
            </div>
            <?php endif; ?>
        </div>

        <?php if(optional(auth()->user())->department === 'Management'): ?>
        <div class="bg-white p-6 rounded-lg shadow-sm mt-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <h2 class="text-lg font-semibold text-gray-900">Productbeheer</h2>
                    <!-- Info tooltip -->
                    <div class="relative group cursor-help">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400 hover:text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25v3.75m0-7.5h.008v.008H11.25V7.5zm0 12a8.25 8.25 0 110-16.5 8.25 8.25 0 010 16.5z" />
                        </svg>
                        <span class="invisible group-hover:visible absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-900 text-white text-xs p-2 rounded shadow-lg text-center z-10">
                            Hier kun je nieuwe producten toevoegen aan het assortiment.
                        </span>
                    </div>
                </div>
                <a href="<?php echo e(route('products.create')); ?>" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Product Toevoegen
                </a>
            </div>
        </div>
        <?php endif; ?>
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
<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/purchasing/productStock.blade.php ENDPATH**/ ?>
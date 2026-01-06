<div wire:poll.2s>
    <?php ($title = 'Inkoop Dashboard'); ?>

    <div class="p-6 bg-[#FAF9F6]">
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 text-white rounded-xl p-6 mb-6 shadow-lg">
            <h1 class="text-xl font-semibold mb-1">Goedemorgen, <?php echo e(auth()->user()->name ?? 'Gebruiker'); ?> 👋</h1>
            <p class="text-sm text-white/90 mb-4">Je hebt <?php echo e($lowStockCount); ?> producten met lage voorraad en <?php echo e($openOrdersCount); ?> openstaande bestellingen</p>
            <div class="flex flex-wrap gap-3">
                <a href="<?php echo e(route('products.order')); ?>" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">+ Nieuwe Bestelling</a>
                <a href="<?php echo e(route('product.stock')); ?>" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">Voorraad bekijken</a>
                <a href="<?php echo e(route('orders.logistics')); ?>" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">Bestellingen backlog</a>
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:space-x-6 gap-6 mb-6">
            <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-start">
                    <h3 class="text-sm text-gray-500">Totaal Voorraadwaarde</h3>
                    <div class="w-8 h-8 flex items-center justify-center bg-indigo-100 text-indigo-700 rounded">💰</div>
                </div>
                <p class="text-2xl font-semibold mt-3">€<?php echo e(number_format($totalStockValue, 0, ',', '.')); ?></p>
            </div>

            <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-start">
                    <h3 class="text-sm text-gray-500">Producten op Voorraad</h3>
                    <div class="w-8 h-8 flex items-center justify-center bg-indigo-100 text-indigo-700 rounded">📦</div>
                </div>
                <p class="text-2xl font-semibold mt-3"><?php echo e(number_format($productCount, 0, ',', '.')); ?></p>
            </div>

            <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-start">
                    <h3 class="text-sm text-gray-500">Openstaande Orders</h3>
                    <div class="w-8 h-8 flex items-center justify-center bg-indigo-100 text-indigo-700 rounded">🚚</div>
                </div>
                <p class="text-2xl font-semibold mt-3"><?php echo e($openOrdersCount); ?></p>
            </div>

            <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-start">
                    <h3 class="text-sm text-gray-500">Lage Voorraad</h3>
                    <div class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-700 rounded">⚠️</div>
                </div>
                <p class="text-2xl font-semibold mt-3"><?php echo e($lowStockCount); ?></p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                    <div class="flex items-center justify-between p-4 border-b border-gray-100">
                        <h2 class="text-lg font-medium">Voorraad Overzicht</h2>
                        <button class="text-sm text-indigo-600">+ Product</button>
                    </div>
                    <div class="flex gap-2 p-3 border-b border-gray-100 bg-gray-50">
                        <button class="px-3 py-1 text-sm bg-indigo-100 text-indigo-700 rounded border border-indigo-200">Alle Producten</button>
                        <button class="px-3 py-1 text-sm bg-white text-gray-600 rounded border border-gray-200">Lage Voorraad</button>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $allProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="grid grid-cols-4 items-center p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded flex items-center justify-center">📦</div>
                                <div>
                                    <div class="font-medium text-sm"><?php echo e($product->product_name); ?></div>
                                </div>
                            </div>
                            <div class="text-sm"><?php echo e($product->stock); ?> stuks</div>
                            <div>
                                <!--[if BLOCK]><![endif]--><?php if($product->stock < 5): ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-50 text-red-700">Kritiek laag</span>
                                <?php elseif($product->stock < 15): ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-50 text-yellow-800">Lage voorraad</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700">Op voorraad</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="text-sm">€<?php echo e(number_format($product->price, 2, ',', '.')); ?>/stuk</div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-4 text-gray-500 text-center">Geen producten gevonden.</div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="flex items-center justify-between p-4 border-b border-gray-100">
                        <h2 class="text-lg font-medium">Lage Voorraad Producten</h2>
                        <button class="text-sm text-gray-600">Alle Producten</button>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-4">
                            <div>
                                <div class="font-medium"><?php echo e($product->product_name); ?></div>
                                <div class="text-sm text-gray-500">Voorraad: <?php echo e($product->stock); ?> stuks</div>
                            </div>
                            <div class="text-sm text-red-600">Bestel nodig</div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-4 text-gray-500 text-center">Geen producten met lage voorraad.</div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="flex items-center justify-between p-4 border-b border-gray-100">
                        <h2 class="text-lg font-medium">Recente Bestellingen</h2>
                        <button class="text-sm text-gray-600">Alle Orders</button>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-4 space-y-2">
                            <div class="flex justify-between items-center">
                                <div class="font-medium text-sm">Order #<?php echo e($order->id); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($order->created_at->format('d M Y')); ?></div>
                            </div>
                            <div class="space-y-1 text-sm">
                                <div class="flex justify-between">
                                    <span><?php echo e($order->amount); ?>x <?php echo e($order->product->product_name ?? 'Onbekend product'); ?></span>
                                    <span>€<?php echo e(number_format($order->price * $order->amount, 0, ',', '.')); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-4 text-gray-500 text-center">Geen recente bestellingen.</div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/livewire/dashboards/purchasing-dashboard.blade.php ENDPATH**/ ?>
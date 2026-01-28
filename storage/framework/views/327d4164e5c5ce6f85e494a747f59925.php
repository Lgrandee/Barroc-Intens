<div>
  <!-- Search and filter bar -->
  <div class="p-4 border-b border-gray-100 bg-gray-50">
    <div class="flex flex-wrap gap-3">
      <input
        type="text"
        wire:model.live.debounce.100ms="search"
        placeholder="Search by contract number, customer or project"
        class="flex-1 min-w-[300px] px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
      />

      <select wire:model.live="status" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="all">All statuses</option>
        <option value="active">active</option>
        <option value="inactive">inactive</option>
        <option value="pending">pending</option>
      </select>

      <select class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option>All types</option>
      </select>

      <!--[if BLOCK]><![endif]--><?php if($search || $status !== 'all'): ?>
        <button wire:click="resetFilters" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-300">
          Reset
        </button>
      <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
  </div>

  <!-- Table -->
  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-gray-50 border-b border-gray-200">
        <tr>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contract</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-4">
              <div class="font-medium text-gray-900">CON-<?php echo e(date('Y', strtotime($contract->start_date))); ?>-<?php echo e(str_pad($contract->id, 3, '0', STR_PAD_LEFT)); ?></div>
              <div class="text-sm text-gray-500"><?php echo e($contract->products->pluck('product_name')->join(', ') ?: ($contract->product->product_name ?? 'N/A')); ?> — Location: <?php echo e($contract->customer->city ?? 'Unknown'); ?></div>
            </td>
            <td class="px-4 py-4 text-sm text-gray-900">
              <?php echo e($contract->customer->name_company ?? 'Unknown'); ?>

            </td>
            <td class="px-4 py-4 text-sm text-gray-900">
              <?php echo e(\Carbon\Carbon::parse($contract->start_date)->format('d M Y')); ?>

            </td>
            <td class="px-4 py-4 text-sm text-gray-900">
              <?php echo e(\Carbon\Carbon::parse($contract->end_date)->format('d M Y')); ?>

            </td>
            <td class="px-4 py-4">
              <?php
                $statusColors = [
                  'active' => 'bg-green-100 text-green-800',
                  'inactive' => 'bg-red-100 text-red-800',
                  'pending' => 'bg-yellow-100 text-yellow-800'
                ];
                $statusLabels = [
                  'active' => 'active',
                  'inactive' => 'inactive',
                  'pending' => 'pending'
                ];
              ?>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($statusColors[$contract->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                <?php echo e($statusLabels[$contract->status] ?? ucfirst($contract->status)); ?>

              </span>
            </td>
            <td class="px-4 py-4 text-left">
              <div class="flex items-center gap-4 text-xl">
                <!-- Bekijken -->
                <a href="<?php echo e(route('contracts.show', $contract->id)); ?>" title="Bekijken" class="hover:opacity-80">👁️</a>
                <!-- Bewerken (nog niet beschikbaar) -->
                <span title="Bewerken (niet beschikbaar)" class="opacity-40 cursor-not-allowed">✏️</span>
                <!-- Verwijderen (nog niet beschikbaar) -->
                <span title="Verwijderen (niet beschikbaar)" class="opacity-40 cursor-not-allowed">🗑️</span>
                <!-- Download PDF -->
                <a href="<?php echo e(route('contracts.pdf', $contract->id)); ?>" title="Download PDF" class="hover:opacity-80">⬇️</a>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="6" class="px-4 py-8 text-center text-gray-500 text-sm">
              No contracts found
            </td>
          </tr>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
      </tbody>
    </table>
  </div>

  <!-- Footer with pagination -->
  <div class="flex flex-col items-center gap-3 px-4 py-3 border-t border-gray-200 bg-gray-50">
    <div class="text-sm text-gray-700">
      Showing <?php echo e($contracts->firstItem() ?? 0); ?>–<?php echo e($contracts->lastItem() ?? 0); ?> of <?php echo e($contracts->total()); ?>

    </div>
    <div class="flex gap-1 items-center">
      <!--[if BLOCK]><![endif]--><?php if($contracts->onFirstPage()): ?>
        <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">‹</span>
      <?php else: ?>
        <button wire:click="previousPage" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">‹</button>
      <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

      <?php
        $currentPage = $contracts->currentPage();
        $lastPage = $contracts->lastPage();
        $start = max(1, $currentPage - 2);
        $end = min($lastPage, $currentPage + 2);
      ?>

      <!--[if BLOCK]><![endif]--><?php if($start > 1): ?>
        <button wire:click="gotoPage(1)" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">1</button>
        <!--[if BLOCK]><![endif]--><?php if($start > 2): ?>
          <span class="px-2 text-gray-500">...</span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
      <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

      <!--[if BLOCK]><![endif]--><?php for($page = $start; $page <= $end; $page++): ?>
        <!--[if BLOCK]><![endif]--><?php if($page == $currentPage): ?>
          <span class="px-3 py-1 border border-indigo-600 bg-indigo-600 text-white rounded text-sm font-medium"><?php echo e($page); ?></span>
        <?php else: ?>
          <button wire:click="gotoPage(<?php echo e($page); ?>)" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100"><?php echo e($page); ?></button>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
      <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->

      <!--[if BLOCK]><![endif]--><?php if($end < $lastPage): ?>
        <!--[if BLOCK]><![endif]--><?php if($end < $lastPage - 1): ?>
          <span class="px-2 text-gray-500">...</span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <button wire:click="gotoPage(<?php echo e($lastPage); ?>)" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100"><?php echo e($lastPage); ?></button>
      <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

      <!--[if BLOCK]><![endif]--><?php if($contracts->hasMorePages()): ?>
        <button wire:click="nextPage" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">›</button>
      <?php else: ?>
        <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">›</span>
      <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
  </div>
</div>

<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/livewire/contract-table.blade.php ENDPATH**/ ?>
<div>
  <!-- Search and filter bar -->
  <div class="p-4 border-b border-gray-100 bg-gray-50">
    <div class="flex flex-wrap gap-3">
      <select wire:model.live="status" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="all">Alle statussen</option>
        <option value="pending">Verstuurd</option>
        <option value="accepted">Goedgekeurd</option>
        <option value="rejected">Verlopen</option>
      </select>

      <select wire:model.live="period" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="last_7_days">Laatste 7 dagen</option>
        <option value="last_30_days">Laatste 30 dagen</option>
        <option value="last_90_days">Laatste 90 dagen</option>
        <option value="all">Alle periodes</option>
      </select>

      <input
        type="text"
        wire:model.live.debounce.300ms="search"
        placeholder="Zoek op nummer of klantnaam"
        class="flex-1 min-w-[300px] px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
      />

      <!--[if BLOCK]><![endif]--><?php if($search || $status !== 'all' || $period !== 'last_7_days'): ?>
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
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nummer</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klant</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bedrag</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verloopt op</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $offertes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offerte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-4">
              <div class="font-medium text-indigo-600">OFF-<?php echo e(date('Y', strtotime($offerte->created_at))); ?>-<?php echo e(str_pad($offerte->id, 3, '0', STR_PAD_LEFT)); ?></div>
              <!--[if BLOCK]><![endif]--><?php if($offerte->status === 'accepted' && $offerte->factuur): ?>
                <div class="text-xs text-green-600 flex items-center gap-1 mt-1">
                  ✓ <a href="<?php echo e(route('facturen.edit', $offerte->factuur->id)); ?>" class="hover:text-green-800">Factuur aangemaakt</a>
                </div>
              <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </td>
            <td class="px-4 py-4">
              <div class="font-medium text-gray-900"><?php echo e($offerte->customer->name_company ?? 'Onbekend'); ?></div>
              <div class="text-sm text-gray-500"><?php echo e($offerte->customer->email ?? ''); ?></div>
            </td>
            <td class="px-4 py-4 text-sm text-gray-900 font-medium">
              <?php
                $totalExVat = $offerte->products->sum(function($product) {
                  return $product->price * $product->pivot->quantity;
                });
                $totalIncVat = $totalExVat * 1.21;
              ?>
              €<?php echo e(number_format($totalIncVat, 2, ',', '.')); ?>

            </td>
            <td class="px-4 py-4 text-sm text-gray-900">
              <?php echo e(\Carbon\Carbon::parse($offerte->created_at)->format('d M Y')); ?>

            </td>
            <td class="px-4 py-4 text-sm">
              <?php
                $expiryDate = \Carbon\Carbon::parse($offerte->created_at)->addDays(30);
                $isExpired = $expiryDate->isPast() || $offerte->status === 'rejected';
              ?>
              <span class="<?php echo e($isExpired ? 'text-red-600 font-medium' : 'text-gray-900'); ?>">
                <?php echo e($isExpired && $expiryDate->isPast() ? 'Verlopen (' . $expiryDate->format('d M') . ')' : $expiryDate->format('d M Y')); ?>

              </span>
            </td>
            <td class="px-4 py-4">
              <?php
                $statusColors = [
                  'accepted' => 'bg-green-100 text-green-700',
                  'rejected' => 'bg-red-100 text-red-700',
                  'pending' => 'bg-blue-100 text-blue-700',
                  'draft' => 'bg-gray-100 text-gray-700'
                ];
                $statusLabels = [
                  'accepted' => 'Goedgekeurd',
                  'rejected' => 'Verlopen',
                  'pending' => 'Verstuurd',
                  'draft' => 'Concept'
                ];
                $statusIcons = [
                  'accepted' => '✓',
                  'rejected' => '!',
                  'pending' => '🔵',
                  'draft' => '📝'
                ];
              ?>
              <span class="inline-flex items-center gap-1 px-3 py-1 rounded text-xs font-medium <?php echo e($statusColors[$offerte->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                <span><?php echo e($statusIcons[$offerte->status] ?? ''); ?></span> <?php echo e($statusLabels[$offerte->status] ?? ucfirst($offerte->status)); ?>

              </span>
            </td>
            <td class="px-4 py-4">
              <div class="flex gap-2">
                <a href="<?php echo e(route('offertes.show', $offerte->id)); ?>" class="text-gray-600 hover:text-gray-900" title="Bekijken">👁️</a>
                <a href="<?php echo e(route('offertes.edit', $offerte->id)); ?>" class="text-gray-600 hover:text-gray-900" title="Bewerken">✏️</a>
                <button
                  wire:click="delete(<?php echo e($offerte->id); ?>)"
                  wire:confirm="Weet je zeker dat je deze offerte wilt verwijderen?"
                  class="text-red-600 hover:text-red-900"
                  title="Verwijderen"
                >🗑️</button>
                <a href="<?php echo e(route('offertes.pdf', $offerte->id)); ?>" class="text-indigo-600 hover:text-indigo-900" title="Downloaden">⬇️</a>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="7" class="px-4 py-8 text-center text-gray-500 text-sm">
              Geen offertes gevonden
            </td>
          </tr>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
      </tbody>
    </table>
  </div>

  <!-- Footer with pagination -->
  <div class="flex flex-col items-center gap-3 px-4 py-3 border-t border-gray-200 bg-gray-50">
    <div class="text-sm text-gray-700">
      Showing <?php echo e($offertes->firstItem() ?? 0); ?>–<?php echo e($offertes->lastItem() ?? 0); ?> of <?php echo e($offertes->total()); ?>

    </div>
    <div class="flex gap-1 items-center">
      <!--[if BLOCK]><![endif]--><?php if($offertes->onFirstPage()): ?>
        <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">‹</span>
      <?php else: ?>
        <button wire:click="previousPage" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">‹</button>
      <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

      <?php
        $currentPage = $offertes->currentPage();
        $lastPage = $offertes->lastPage();
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

      <!--[if BLOCK]><![endif]--><?php if($offertes->hasMorePages()): ?>
        <button wire:click="nextPage" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">›</button>
      <?php else: ?>
        <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">›</span>
      <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
  </div>
</div>
<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/livewire/offerte-table.blade.php ENDPATH**/ ?>
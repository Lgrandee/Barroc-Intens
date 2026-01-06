<div>
  <!-- Search and filter bar -->
  <div class="p-4 border-b border-gray-100 bg-gray-50">
    <div class="flex flex-wrap gap-3">
      <select wire:model.live="status" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="all">Alle statussen</option>
        <option value="concept">Concept</option>
        <option value="verzonden">Verzonden</option>
        <option value="betaald">Betaald</option>
        <option value="verlopen">Verlopen</option>
      </select>

      <select wire:model.live="period" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="all">Alle periodes</option>
        <option value="this_month">Deze maand</option>
        <option value="last_30_days">Laatste 30 dagen</option>
        <option value="last_90_days">Laatste 90 dagen</option>
      </select>

      <input
        type="text"
        wire:model.live.debounce.300ms="search"
        placeholder="Zoek op factuurnummer, klantnaam..."
        class="flex-1 min-w-[300px] px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
      />

      <!--[if BLOCK]><![endif]--><?php if($search || $status !== 'all' || $period !== 'this_month'): ?>
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
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Factuurnr.</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klant</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vervaldatum</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bedrag</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $facturen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $factuur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-4">
              <div class="font-medium text-indigo-600">F<?php echo e(date('Y', strtotime($factuur->invoice_date))); ?>-<?php echo e(str_pad($factuur->id, 3, '0', STR_PAD_LEFT)); ?></div>
              <!--[if BLOCK]><![endif]--><?php if($factuur->offerte_id): ?>
                <div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                  🔗 <a href="<?php echo e(route('offertes.show', $factuur->offerte_id)); ?>" class="text-indigo-600 hover:text-indigo-800">Offerte</a>
                </div>
              <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </td>
            <td class="px-4 py-4">
              <div class="font-medium text-gray-900"><?php echo e($factuur->customer->name_company ?? 'Onbekend'); ?></div>
              <div class="text-sm text-gray-500"><?php echo e($factuur->customer->email ?? ''); ?></div>
            </td>
            <td class="px-4 py-4 text-sm text-gray-900">
              <?php echo e(\Carbon\Carbon::parse($factuur->invoice_date)->format('d M Y')); ?>

            </td>
            <td class="px-4 py-4 text-sm">
              <?php
                $dueDate = \Carbon\Carbon::parse($factuur->due_date);
                $isOverdue = $dueDate->isPast() && $factuur->status !== 'betaald';
              ?>
              <span class="<?php echo e($isOverdue ? 'text-red-600 font-medium' : 'text-gray-900'); ?>">
                <?php echo e($dueDate->format('d M Y')); ?>

              </span>
            </td>
            <td class="px-4 py-4 text-sm text-gray-900 font-medium">
              €<?php echo e(number_format($factuur->total_amount ?? 0, 2, ',', '.')); ?>

            </td>
            <td class="px-4 py-4">
              <?php
                $statusColors = [
                  'betaald' => 'bg-green-100 text-green-700',
                  'verlopen' => 'bg-red-100 text-red-700',
                  'verzonden' => 'bg-yellow-100 text-yellow-700',
                  'concept' => 'bg-gray-100 text-gray-700'
                ];
                $statusLabels = [
                  'betaald' => 'Betaald',
                  'verlopen' => 'Verlopen',
                  'verzonden' => 'Verzonden',
                  'concept' => 'Concept'
                ];
              ?>
              <span class="inline-flex items-center gap-1 px-3 py-1 rounded text-xs font-medium <?php echo e($statusColors[$factuur->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                <?php echo e($statusLabels[$factuur->status] ?? ucfirst($factuur->status)); ?>

              </span>
            </td>
            <td class="px-4 py-4">
              <div class="flex gap-2">
                <a href="<?php echo e(route('facturen.send', $factuur->id)); ?>" class="text-gray-600 hover:text-gray-900" title="Bekijken">👁️</a>
                <a href="<?php echo e(route('facturen.edit', $factuur->id)); ?>" class="text-gray-600 hover:text-gray-900" title="Bewerken">✏️</a>
                <button
                  wire:click="delete(<?php echo e($factuur->id); ?>)"
                  wire:confirm="Weet je zeker dat je deze factuur wilt verwijderen?"
                  class="text-red-600 hover:text-red-900"
                  title="Verwijderen"
                >🗑️</button>
                <a href="<?php echo e(route('facturen.pdf', $factuur->id)); ?>" class="text-indigo-600 hover:text-indigo-900" title="Downloaden">⬇️</a>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="7" class="px-4 py-8 text-center text-gray-500 text-sm">
              Geen facturen gevonden
            </td>
          </tr>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
      </tbody>
    </table>
  </div>

  <!-- Footer with pagination -->
  <div class="flex flex-col items-center gap-3 px-4 py-3 border-t border-gray-200 bg-gray-50">
    <div class="text-sm text-gray-700">
      Toont <?php echo e($facturen->firstItem() ?? 0); ?>–<?php echo e($facturen->lastItem() ?? 0); ?> van <?php echo e($facturen->total()); ?>

    </div>
    <div class="flex gap-1 items-center">
      <!--[if BLOCK]><![endif]--><?php if($facturen->onFirstPage()): ?>
        <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">‹</span>
      <?php else: ?>
        <button wire:click="previousPage" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">‹</button>
      <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

      <?php
        $currentPage = $facturen->currentPage();
        $lastPage = $facturen->lastPage();
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

      <!--[if BLOCK]><![endif]--><?php if($facturen->hasMorePages()): ?>
        <button wire:click="nextPage" class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">›</button>
      <?php else: ?>
        <span class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-400 cursor-not-allowed">›</span>
      <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
  </div>
</div>
<?php /**PATH C:\Users\PowerHouse V2\Herd\Barocc-intens\resources\views/livewire/factuur-table.blade.php ENDPATH**/ ?>
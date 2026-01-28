<x-layouts.app :title="'New contract'">
  <style>
    /* Light-only page background override for consistency */
    html:not(.dark) body { background-color: #f3f4f6 !important; }
  </style>
  <main class="p-6 min-h-screen max-w-4xl mx-auto">
    <header class="mb-6">
      <div class="text-center mb-4">
        <h1 class="text-3xl font-semibold text-black dark:text-white">Create new contract</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300">Create a new contract for an existing customer and product</p>
      </div>
      <a href="{{ route('contracts.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
        Back to overview
      </a>
    </header>

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
      <div class="p-6">
        <form id="contract-form" action="{{ route('contracts.store') }}" method="POST" class="space-y-6">
          @csrf

          @livewire('customer-search', ['initialId' => old('name_company_id')])

          <div>
            @livewire('product-multi-select', ['initialSelected' => old('product_ids', [])])
            @error('product_ids')
              <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
              <label for="start_date" class="font-semibold text-gray-800 dark:text-gray-200">Start date</label>
              <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-black dark:text-white rounded-md" />
              @error('start_date')
                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
              @enderror
              <input type="hidden" id="end_date" name="end_date" value="{{ old('end_date') }}" />
              <div id="end-date-display" class="mt-2 text-sm text-gray-600 dark:text-gray-300"></div>
            </div>
          </div>
          <script>
            document.addEventListener('DOMContentLoaded', function() {
              const startInput = document.getElementById('start_date');
              const endInput = document.getElementById('end_date');
              const endDisplay = document.getElementById('end-date-display');
              function setEndDate() {
                if (startInput.value) {
                  const start = new Date(startInput.value);
                  const end = new Date(start);
                  end.setFullYear(end.getFullYear() + 2);
                  // Format as yyyy-mm-dd
                  const yyyy = end.getFullYear();
                  const mm = String(end.getMonth() + 1).padStart(2, '0');
                  const dd = String(end.getDate()).padStart(2, '0');
                  const endDateStr = `${yyyy}-${mm}-${dd}`;
                  endInput.value = endDateStr;
                  // Format for display: dd-mm-yyyy
                  endDisplay.textContent = `End date: ${dd}-${mm}-${yyyy}`;
                } else {
                  endInput.value = '';
                  endDisplay.textContent = '';
                }
              }
              startInput.addEventListener('change', setEndDate);
              setEndDate();
            });
          </script>

          <div>
            <label class="font-semibold text-gray-800 dark:text-gray-200">Status</label>
            <div class="mt-1 inline-flex items-center gap-2">
              <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">pending</span>
              <span class="text-sm text-gray-600 dark:text-gray-300">The status is automatically set to <strong>pending</strong> on creation.</span>
            </div>
          </div>

          <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
            <h3 class="font-semibold text-yellow-900 mb-2">Maintenance Policy</h3>
            <p class="text-sm text-yellow-800 mb-2">This contract includes <strong>1 free maintenance visit per month</strong>.</p>
            <p class="text-sm text-yellow-800">Additional maintenance visits will be charged unless caused by a Barroc Intens defect. Customer must contact: <strong>service@barroc.nl</strong></p>
          </div>

          <div class="flex justify-between items-center pt-4">
            <a href="{{ route('contracts.index') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline">Cancel</a>
            <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
              <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"/></svg>
              Create contract
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
      Manage new contracts via finance — be careful when filling in contract data
    </div>
  </main>
</x-layouts.app>

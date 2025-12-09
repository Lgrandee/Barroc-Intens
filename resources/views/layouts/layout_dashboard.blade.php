<x-layouts.app :title="$title ?? 'Dashboard'">
  <main class="p-6 bg-[#FAF9F6]">

    <div class="@yield('welcome_classes','bg-gradient-to-br from-indigo-800 to-indigo-900') text-white rounded-xl p-6 mb-6 shadow-lg">
      @hasSection('welcome')
        @yield('welcome')
      @else
        <h1 class="text-xl font-semibold mb-1">Welkom, {{ auth()->user()->name ?? '' }}</h1>
        <p class="text-sm opacity-90 mb-4">Beheer alle systeemmodules en monitor de prestaties</p>
        <div class="flex flex-wrap gap-3">
          <button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">Gebruikers Beheren</button>
          <button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">Rollen Configureren</button>
          <button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">Systeemrapporten</button>
          <button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">Instellingen</button>
        </div>
      @endif
    </div>

    {{-- Stats row wrapper (always rendered). Child views can override classes via `stats_classes`
         and content via `@section('stats')`. If no section provided, default stat cards are shown. --}}
    <div class="@yield('stats_classes','flex flex-col md:flex-row md:space-x-6 gap-6 mb-6')">
      @hasSection('stats')
        @yield('stats')
      @else
        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
          <div class="flex justify-between items-start">
            <h3 class="text-sm text-gray-500">Actieve Gebruikers</h3>
            <div class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded">👥</div>
          </div>
          <p class="text-2xl font-semibold mt-3">24</p>
          <div class="flex items-center gap-2 text-sm text-green-600 mt-2">↑ 2 <span class="text-gray-400">deze week</span></div>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
          <div class="flex justify-between items-start">
            <h3 class="text-sm text-gray-500">Systeembelasting</h3>
            <div class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded">📊</div>
          </div>
          <p class="text-2xl font-semibold mt-3">32%</p>
          <div class="flex items-center gap-2 text-sm text-red-600 mt-2">↓ 5% <span class="text-gray-400">vs piek</span></div>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
          <div class="flex justify-between items-start">
            <h3 class="text-sm text-gray-500">API Requests</h3>
            <div class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded">🔄</div>
          </div>
          <p class="text-2xl font-semibold mt-3">2.4k</p>
          <div class="flex items-center gap-2 text-sm text-green-600 mt-2">↑ 12% <span class="text-gray-400">vandaag</span></div>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
          <div class="flex justify-between items-start">
            <h3 class="text-sm text-gray-500">Response Tijd</h3>
            <div class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded">⚡</div>
          </div>
          <p class="text-2xl font-semibold mt-3">238ms</p>
          <div class="flex items-center gap-2 text-sm text-green-600 mt-2">↓ 15ms <span class="text-gray-400">gemiddeld</span></div>
        </div>
      @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="lg:col-span-2 space-y-6">
        {{-- Alerts list - Only show if defined by child views --}}
        @hasSection('alerts')
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
          <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <h2 class="text-lg font-medium">@yield('alerts_title', 'Systeem Alerts')</h2>
            <button class="text-sm text-gray-600">@yield('alerts_action', 'Alle Alerts')</button>
          </div>
          <div class="p-4 divide-y divide-gray-100">
            @yield('alerts')
          </div>
        </div>
        @endif

        {{-- Module grid (default) --}}
        @section('modules')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start mb-3">
              <h3 class="font-medium">Sales Module</h3>
              <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700">Actief</span>
            </div>
            <div class="flex gap-4">
              <div class="flex-1">
                <div class="text-sm text-gray-500">Actieve Offertes</div>
                <div class="text-xl font-semibold">45</div>
              </div>
              <div class="flex-1">
                <div class="text-sm text-gray-500">Conversie</div>
                <div class="text-xl font-semibold">68%</div>
              </div>
            </div>
          </div>

          <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start mb-3">
              <h3 class="font-medium">Finance Module</h3>
              <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-50 text-yellow-800">Actief</span>
            </div>
            <div class="flex gap-4">
              <div class="flex-1">
                <div class="text-sm text-gray-500">Open Facturen</div>
                <div class="text-xl font-semibold">28</div>
              </div>
              <div class="flex-1">
                <div class="text-sm text-gray-500">Te Ontvangen</div>
                <div class="text-xl font-semibold">€45k</div>
              </div>
            </div>
          </div>

          <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex justify-between items-start mb-3">
              <h3 class="font-medium">Service Module</h3>
              <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-pink-50 text-pink-700">Actief</span>
            </div>
            <div class="flex gap-4">
              <div class="flex-1">
                <div class="text-sm text-gray-500">Open Tickets</div>
                <div class="text-xl font-semibold">12</div>
              </div>
              <div class="flex-1">
                <div class="text-sm text-gray-500">Gem. Responstijd</div>
                <div class="text-xl font-semibold">2.4u</div>
              </div>
            </div>
          </div>

          <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex justify-between items-start mb-3">
              <h3 class="font-medium">Systeem Status</h3>
              <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-50 text-blue-700">Optimaal</span>
            </div>
            <div class="flex gap-4">
              <div class="flex-1">
                <div class="text-sm text-gray-500">CPU Gebruik</div>
                <div class="text-xl font-semibold">28%</div>
              </div>
              <div class="flex-1">
                <div class="text-sm text-gray-500">Geheugen</div>
                <div class="text-xl font-semibold">42%</div>
              </div>
            </div>
          </div>
        </div>
        @show
      </div>

      {{-- Activity sidebar (default) --}}
      <div>
        @section('activity')
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
          <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <h2 class="text-lg font-medium">Recente Activiteit</h2>
            <button class="text-sm text-gray-600">Filter</button>
          </div>
          <div class="p-4 divide-y divide-gray-100">
            <div class="py-3">
              <div class="flex justify-between items-start">
                <div>
                  <div class="font-medium">Nieuwe Gebruiker</div>
                  <div class="text-sm text-gray-500">Peter Jansen toegevoegd aan Sales team</div>
                </div>
                <div class="text-sm text-gray-400">14:25</div>
              </div>
            </div>
            <div class="py-3">
              <div class="flex justify-between items-start">
                <div>
                  <div class="font-medium">Rol Gewijzigd</div>
                  <div class="text-sm text-gray-500">Finance rol permissies bijgewerkt</div>
                </div>
                <div class="text-sm text-gray-400">13:15</div>
              </div>
            </div>
            <div class="py-3">
              <div class="flex justify-between items-start">
                <div>
                  <div class="font-medium">Systeem Update</div>
                  <div class="text-sm text-gray-500">Database backup voltooid</div>
                </div>
                <div class="text-sm text-gray-400">12:00</div>
              </div>
            </div>
            <div class="py-3">
              <div class="flex justify-between items-start">
                <div>
                  <div class="font-medium">Module Status</div>
                  <div class="text-sm text-gray-500">Facturatie module geoptimaliseerd</div>
                </div>
                <div class="text-sm text-gray-400">11:30</div>
              </div>
            </div>
            <div class="py-3">
              <div class="flex justify-between items-start">
                <div>
                  <div class="font-medium">Beveiliging</div>
                  <div class="text-sm text-gray-500">2-Factor authenticatie ingeschakeld</div>
                </div>
                <div class="text-sm text-gray-400">10:15</div>
              </div>
            </div>
            <div class="py-3">
              <div class="flex justify-between items-start">
                <div>
                  <div class="font-medium">API</div>
                  <div class="text-sm text-gray-500">Nieuwe API sleutels gegenereerd</div>
                </div>
                <div class="text-sm text-gray-400">09:45</div>
              </div>
            </div>
          </div>
        </div>
        @show
      </div>
    </div>

    {{-- Additional dashboard sections from HTML files - Only show if defined by child views --}}

    {{-- Product/Inventory List Section (for Purchasing) --}}
    @hasSection('product_list')
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-medium">@yield('product_list_title', 'Voorraad Overzicht')</h2>
        <button class="text-sm text-indigo-600">@yield('product_list_action', '+ Product')</button>
      </div>
      <div class="flex gap-2 p-3 border-b border-gray-100 bg-gray-50">
        @yield('product_filters', '')
      </div>
      <div class="divide-y divide-gray-100">
        @yield('product_list')
      </div>
    </div>
    @endif

    {{-- Chart/Graph Section (for Sales & Finance) --}}
    @hasSection('chart_section')
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6 shadow-sm">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-medium">@yield('chart_title', 'Prestatie Overzicht')</h2>
        <div class="flex gap-2">
          @yield('chart_actions', '')
        </div>
      </div>
      <div class="p-4">
        @yield('chart_section')
      </div>
    </div>
    @endif

    {{-- Invoice/Financial List Section (for Finance) --}}
    @hasSection('invoice_list')
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6 shadow-sm">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-medium">@yield('invoice_list_title', 'Recente Facturen')</h2>
        <button class="text-sm text-gray-600">@yield('invoice_list_action', 'Alles Bekijken')</button>
      </div>
      <div class="divide-y divide-gray-100">
        @yield('invoice_list')
      </div>
    </div>
    @endif

    {{-- Calendar/Planning Section (for Technician/Planner) --}}
    @hasSection('calendar_section')
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6 shadow-sm">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-medium">@yield('calendar_title', 'Planning Deze Week')</h2>
        <div class="flex gap-2">
          @yield('calendar_actions', '')
        </div>
      </div>
      <div class="p-4">
        @yield('calendar_section')
      </div>
    </div>
    @endif

    {{-- Ticket List Section (for Technician) --}}
    @hasSection('ticket_list')
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6 shadow-sm">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-medium">@yield('ticket_list_title', 'Urgente Tickets')</h2>
        <button class="text-sm text-gray-600">@yield('ticket_list_action', 'Alle Tickets')</button>
      </div>
      <div class="divide-y divide-gray-100">
        @yield('ticket_list')
      </div>
    </div>
    @endif

    {{-- Deal/Sales List Section (for Sales) --}}
    @hasSection('deals_list')
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6 shadow-sm">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-medium">@yield('deals_list_title', 'Recente Deals')</h2>
        <button class="text-sm text-gray-600">@yield('deals_list_action', 'Alles Bekijken')</button>
      </div>
      <div class="divide-y divide-gray-100">
        @yield('deals_list')
      </div>
    </div>
    @endif

    {{-- Tasks Section (for Sales/Planner) --}}
    @hasSection('tasks_section')
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6 shadow-sm">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-medium">@yield('tasks_title', 'Mijn Taken')</h2>
        <button class="text-sm text-gray-600">@yield('tasks_action', '+ Taak')</button>
      </div>
      <div class="p-3 space-y-2">
        @yield('tasks_section')
      </div>
    </div>
    @endif

    {{-- Order List Section (for Purchasing) --}}
    @hasSection('order_list')
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6 shadow-sm">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-medium">@yield('order_list_title', 'Recente Bestellingen')</h2>
        <button class="text-sm text-gray-600">@yield('order_list_action', 'Alle Orders')</button>
      </div>
      <div class="divide-y divide-gray-100">
        @yield('order_list')
      </div>
    </div>
    @endif

    {{-- Suppliers Section (for Purchasing) --}}
    @hasSection('suppliers_section')
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6 shadow-sm">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-medium">@yield('suppliers_title', 'Top Leveranciers')</h2>
        <button class="text-sm text-gray-600">@yield('suppliers_action', 'Alle Leveranciers')</button>
      </div>
      <div class="divide-y divide-gray-100">
        @yield('suppliers_section')
      </div>
    </div>
    @endif

    {{-- Reminders Section (for Finance) --}}
    @hasSection('reminders_section')
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6 shadow-sm">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-medium">@yield('reminders_title', 'Betalingsherinneringen')</h2>
        <button class="text-sm text-gray-600">@yield('reminders_action', '+ Herinnering')</button>
      </div>
      <div class="p-3 space-y-2">
        @yield('reminders_section')
      </div>
    </div>
    @endif

    {{-- Inventory Status Section (for Technician) --}}
    @hasSection('inventory_section')
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6 shadow-sm">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-medium">@yield('inventory_title', 'Voorraad Status')</h2>
        <button class="text-sm text-gray-600">@yield('inventory_action', 'Alles Bekijken')</button>
      </div>
      <div class="p-4 space-y-3">
        @yield('inventory_section')
      </div>
    </div>
    @endif

    {{-- Activity Feed Section (for Sales) --}}
    @hasSection('activity_feed')
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6 shadow-sm">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-medium">@yield('activity_feed_title', 'Recente Activiteiten')</h2>
        <button class="text-sm text-gray-600">@yield('activity_feed_action', 'Filter')</button>
      </div>
      <div class="p-4 space-y-4">
        @yield('activity_feed')
      </div>
    </div>
    @endif

    {{-- Team Planning Section (for Planner) --}}
    @hasSection('team_planning')
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6 shadow-sm">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-medium">@yield('team_planning_title', 'Team Planning')</h2>
        <button class="text-sm text-gray-600">@yield('team_planning_action', 'Kalender Weergave')</button>
      </div>
      <div class="divide-y divide-gray-100">
        @yield('team_planning')
      </div>
    </div>
    @endif

    {{-- Weekly Overview Section (for Planner) --}}
    @hasSection('weekly_overview')
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-medium">@yield('weekly_overview_title', 'Wekelijks Overzicht')</h2>
        <div class="flex gap-2">
          @yield('weekly_overview_actions', '')
        </div>
      </div>
      <div class="p-4">
        @yield('weekly_overview')
      </div>
    </div>
    @endif

  </main>
</x-layouts.app>

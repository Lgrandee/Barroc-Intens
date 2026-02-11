<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            /* Sleek Sidebar Navigation Styles - Override Flux UI */

            /* Target all possible nav item selectors */
            [data-flux-navlist-item],
            [data-flux-navlist] a,
            [data-flux-navlist] button,
            .flux-navlist-item,
            nav a[href],
            [data-flux-sidebar] a[href] {
                position: relative !important;
                border-radius: 0.5rem !important;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
                margin: 2px 0 !important;
            }

            /* Hover effect - Neutral interaction */
            [data-flux-navlist-item]:hover,
            [data-flux-navlist] a:hover,
            [data-flux-sidebar] a[href]:hover {
                background: rgba(0, 0, 0, 0.04) !important; /* Neutral gray hover */
                transform: translateX(4px) !important;
                color: #1f2937 !important;
            }
            .dark [data-flux-navlist-item]:hover,
            .dark [data-flux-navlist] a:hover,
            .dark [data-flux-sidebar] a[href]:hover {
                background: rgba(255, 255, 255, 0.05) !important;
                color: #f3f4f6 !important;
            }

            /* Active/clicked state - pressed */
            [data-flux-navlist-item]:active,
            [data-flux-navlist] a:active,
            [data-flux-sidebar] a[href]:active {
                transform: translateX(2px) scale(0.98) !important;
                background: rgba(0, 0, 0, 0.08) !important;
            }

            /* Current page - The "Yellow Tint" Effect */
            [data-flux-navlist-item][aria-current="page"],
            [data-flux-navlist] a[aria-current="page"],
            [data-flux-sidebar] a[aria-current="page"],
            [data-flux-navlist-item][data-current],
            [data-flux-navlist] a[data-current],
            a[data-current],
            .flux-navlist-item[data-current] {
                background: rgba(251, 191, 36, 0.15) !important; /* Solid-ish tint */
                color: #b45309 !important;
                font-weight: 600 !important;
                border: 1px solid rgba(251, 191, 36, 0.3) !important; /* Adding border to match outline variant */
                border-left: 4px solid #f59e0b !important;
                transform: translateX(0) !important;
            }

            .dark [data-flux-navlist-item][aria-current="page"],
            .dark [data-flux-navlist] a[aria-current="page"],
            .dark [data-flux-navlist-item][data-current],
            .dark [data-flux-navlist] a[data-current] {
                color: #fbbf24 !important; /* Amber-400 text for dark mode */
                background: linear-gradient(to right, rgba(251, 191, 36, 0.2), rgba(251, 191, 36, 0.05)) !important;
            }

            /* Hovering over the active item - keep it stable or slightly enhance */
            [data-flux-navlist-item][aria-current="page"]:hover,
            [data-flux-navlist] a[aria-current="page"]:hover {
                background: linear-gradient(to right, rgba(251, 191, 36, 0.15), rgba(251, 191, 36, 0.1)) !important;
                transform: translateX(0) !important;
            }

            /* Icon styling for current page */
            [data-flux-navlist-item][aria-current="page"] svg,
            [data-flux-navlist] a[aria-current="page"] svg,
            [data-flux-sidebar] a[aria-current="page"] svg {
                color: #1f2937 !important;
            }

            /* Group headings styling */
            [data-flux-navlist-group] > button,
            [data-flux-navlist-group] > [data-flux-heading],
            [data-flux-navlist] [data-flux-heading] {
                font-size: 0.7rem !important;
                text-transform: uppercase !important;
                letter-spacing: 0.05em !important;
                opacity: 0.7 !important;
                font-weight: 600 !important;
            }

            /* Subtle left border indicator for items */
            [data-flux-navlist-item]::before,
            [data-flux-navlist] a::before {
                content: '';
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 3px;
                height: 0;
                background: linear-gradient(180deg, #FBBF24 0%, #F59E0B 100%);
                border-radius: 0 2px 2px 0;
                transition: height 0.2s ease;
            }

            [data-flux-navlist-item]:hover::before,
            [data-flux-navlist] a:hover::before {
                height: 60%;
            }

            [data-flux-navlist-item][aria-current="page"]::before,
            [data-flux-navlist] a[aria-current="page"]::before {
                height: 80%;
                width: 4px;
            }

            /* Smooth icon transitions */
            [data-flux-navlist-item] svg,
            [data-flux-navlist] a svg,
            [data-flux-sidebar] a svg {
                transition: transform 0.2s ease, color 0.2s ease !important;
            }

            [data-flux-navlist-item]:hover svg,
            [data-flux-navlist] a:hover svg,
            [data-flux-sidebar] a:hover svg {
                transform: scale(1.1) !important;
                color: #FBBF24 !important;
            }

            /* Focus states for accessibility */
            [data-flux-navlist-item]:focus-visible,
            [data-flux-navlist] a:focus-visible {
                outline: 2px solid #FBBF24 !important;
                outline-offset: 2px !important;
            }

            /* Sleek Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }

            ::-webkit-scrollbar-track {
                background: transparent;
                border-radius: 3px;
            }

            ::-webkit-scrollbar-thumb {
                background: linear-gradient(180deg, #D4D4D8 0%, #A1A1AA 100%);
                border-radius: 3px;
                transition: background 0.2s ease;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(180deg, #FBBF24 0%, #F59E0B 100%);
            }

            .dark ::-webkit-scrollbar-thumb {
                background: linear-gradient(180deg, #52525B 0%, #3F3F46 100%);
            }

            .dark ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(180deg, #FBBF24 0%, #F59E0B 100%);
            }

            /* Firefox scrollbar */
            * {
                scrollbar-width: thin;
                scrollbar-color: #A1A1AA transparent;
            }

            .dark * {
                scrollbar-color: #52525B transparent;
            }

            /* Sidebar specific scrollbar */
            [data-flux-sidebar] {
                scrollbar-width: thin;
            }

            [data-flux-sidebar]::-webkit-scrollbar {
                width: 4px;
            }

            [data-flux-sidebar]::-webkit-scrollbar-thumb {
                background: rgba(161, 161, 170, 0.5);
                border-radius: 2px;
            }

            [data-flux-sidebar]::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(180deg, #FBBF24 0%, #F59E0B 100%);
            }
            html body { background-color: #f3f4f6 !important; }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body class="min-h-screen bg-[#FAF9F6] dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="flex items-center justify-center w-full px-5" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                @if(auth()->user()->department === 'Management')
                <flux:navlist.group :heading="__('Platform')" expandable>
                    <flux:navlist.item icon="pencil" :href="route('management')" :current="request()->routeIs('management')" wire:navigate>{{ __('Admin Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="user-group" :href="route('management.roles.index')" :current="request()->routeIs('management.roles.*')" wire:navigate>{{ __('Rollen') }}</flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('management.users.index')" :current="request()->routeIs('management.users.*')" wire:navigate>{{ __('Gebruikers') }}</flux:navlist.item>
                </flux:navlist.group>
                @endif

                @if(auth()->user()->department === 'Sales' || auth()->user()->department === 'Management')
                <flux:navlist.group :heading="__('Verkoop')" expandable>
                    <flux:navlist.item icon="banknotes" :href="route('sales.dashboard')" :current="request()->routeIs('sales.dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="document-text" :href="route('offertes.index')" :current="request()->routeIs('offertes.*')" wire:navigate>{{ __('Offertes') }}</flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('customers.index')" :current="request()->routeIs('customers.*')" wire:navigate>{{ __('Klanten') }}</flux:navlist.item>
                </flux:navlist.group>
                @endif

                @if(auth()->user()->department === 'Purchasing' || auth()->user()->department === 'Management')
                <flux:navlist.group :heading="__('Inkoop')" expandable>
                    <flux:navlist.item icon="plus" :href="route('purchasing.dashboard')" :current="request()->routeIs('purchasing.dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="cube" :href="route('product.stock')" :current="request()->routeIs('product.stock')" wire:navigate>{{ __('Voorraad') }}</flux:navlist.item>
                    <flux:navlist.item icon="shopping-cart" :href="route('products.order')" :current="request()->routeIs('products.order') || request()->routeIs('products.store')">{{ __('Bestellingen') }}</flux:navlist.item>
                    <flux:navlist.item icon="truck" :href="route('orders.logistics')" :current="request()->routeIs('orders.logistics')" wire:navigate>{{ __('Logistics') }}</flux:navlist.item>
                </flux:navlist.group>
                @endif

                @if(auth()->user()->department === 'Finance' || auth()->user()->department === 'Management')
                <flux:navlist.group :heading="__('Financiën')" expandable>
                    <flux:navlist.item icon="wallet" :href="route('finance.dashboard')" :current="request()->routeIs('finance.dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="document-text" :href="route('contracts.index')" :current="request()->routeIs('contracts.*')" wire:navigate>{{ __('Contracten') }}</flux:navlist.item>
                    <flux:navlist.item icon="receipt-percent" :href="route('facturen.index')" :current="request()->routeIs('facturen.*')" wire:navigate>{{ __('Facturen') }}</flux:navlist.item>
                </flux:navlist.group>
                @endif

                @if(auth()->user()->department === 'Technician' || auth()->user()->department === 'Management')
                <flux:navlist.group :heading="__('Techniek')" expandable>
                    <flux:navlist.item icon="wrench" :href="route('technician.dashboard')" :current="request()->routeIs('technician.dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="calendar-days" :href="route('technician.planning')" :current="request()->routeIs('technician.planning') || request()->routeIs('technician.onderhoud.*')" wire:navigate>{{ __('Planning') }}</flux:navlist.item>
                </flux:navlist.group>
                @endif

                @if(auth()->user()->department === 'Planner' || auth()->user()->department === 'Management')
                <flux:navlist.group :heading="__('Planner')" expandable>
                    <flux:navlist.item icon="calendar" :href="route('planner.dashboard')" :current="request()->routeIs('planner.dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="ticket" :href="route('planner.tickets.index')" :current="request()->routeIs('planner.tickets.*')" wire:navigate>{{ __('Tickets') }}</flux:navlist.item>
                </flux:navlist.group>
                @endif
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    data-test="sidebar-menu-button"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            /* Highlight voor actieve menu items */
            [data-flux-navlist-item][aria-current="page"],
            .dark [data-flux-navlist-item][aria-current="page"] {
                @apply bg-gray-400 dark:bg-zinc-600 font-semibold;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body class="min-h-screen bg-[#FAF9F6] dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                @if(auth()->user()->department === 'Management')
                <flux:navlist.group :heading="__('Platform')" expandable>
                    <flux:navlist.item icon="pencil" :href="route('management')" :current="request()->routeIs('management') || request()->routeIs('management.*')" wire:navigate>{{ __('Admin dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="user-group" :href="route('management.roles.index')" :current="request()->routeIs('management.roles.*')" wire:navigate>{{ __('Roles') }}</flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('management.users.index')" :current="request()->routeIs('management.users.*')" wire:navigate>{{ __('Users') }}</flux:navlist.item>
                </flux:navlist.group>
                @endif

                @if(auth()->user()->department === 'Sales' || auth()->user()->department === 'Management')
                <flux:navlist.group :heading="__('Sales')" expandable>
                    <flux:navlist.item icon="banknotes" :href="route('sales.dashboard')" :current="request()->routeIs('sales.dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="document-text" :href="route('offertes.index')" :current="request()->routeIs('offertes.*')" wire:navigate>{{ __('Offertes') }}</flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('customers.index')" :current="request()->routeIs('customers.*')" wire:navigate>{{ __('Customers') }}</flux:navlist.item>
                </flux:navlist.group>
                @endif

                @if(auth()->user()->department === 'Purchasing' || auth()->user()->department === 'Management')
                <flux:navlist.group :heading="__('Purchasing')" expandable>
                    <flux:navlist.item icon="plus" :href="route('purchasing.dashboard')" :current="request()->routeIs('purchasing.dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="cube" :href="route('product.stock')" :current="request()->routeIs('product.stock')" wire:navigate>{{ __('Stock') }}</flux:navlist.item>
                    <flux:navlist.item icon="shopping-cart" :href="route('products.order')" :current="request()->routeIs('products.order')" wire:navigate>{{ __('Order') }}</flux:navlist.item>
                    <flux:navlist.item icon="truck" :href="route('orders.logistics')" :current="request()->routeIs('orders.logistics')" wire:navigate>{{ __('Logistics') }}</flux:navlist.item>
                </flux:navlist.group>
                @endif

                @if(auth()->user()->department === 'Finance' || auth()->user()->department === 'Management')
                <flux:navlist.group :heading="__('Finance')" expandable>
                    <flux:navlist.item icon="wallet" :href="route('finance.dashboard')" :current="request()->routeIs('finance.dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="document-text" :href="route('contracts.index')" :current="request()->routeIs('contracts.*')" wire:navigate>{{ __('Contracts') }}</flux:navlist.item>
                    <flux:navlist.item icon="receipt-percent" :href="route('facturen.index')" :current="request()->routeIs('facturen.*')" wire:navigate>{{ __('Invoices') }}</flux:navlist.item>
                </flux:navlist.group>
                @endif

                @if(auth()->user()->department === 'Technician' || auth()->user()->department === 'Management')
                <flux:navlist.group :heading="__('Technician')" expandable>
                    <flux:navlist.item icon="wrench" :href="route('technician.dashboard')" :current="request()->routeIs('technician.dashboard') || request()->routeIs('technician.*')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="calendar-days" :href="route('technician.planning')" :current="request()->routeIs('technician.planning')" wire:navigate>{{ __('Planning') }}</flux:navlist.item>
                </flux:navlist.group>
                @endif

                @if(auth()->user()->department === 'Planner' || auth()->user()->department === 'Management')
                <flux:navlist.group :heading="__('Planner')" expandable>
                    <flux:navlist.item icon="calendar" :href="route('planner.dashboard')" :current="request()->routeIs('planner.dashboard') || request()->routeIs('planner.*')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
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
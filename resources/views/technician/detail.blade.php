<x-layouts.app :title="'Onderhoud Details'">
    <main class="p-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Onderhoud Details</h1>
                    <p class="text-sm text-gray-600 mt-1">Taak #{{ $task->id }}</p>
                </div>
                <a href="{{ route('technician.planning') }}"
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm">
                    Terug naar overzicht
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Section: Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Klant Informatie -->
                <div class="bg-[#f3f4f6] rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Klant Informatie</h2>
                    <dl class="grid grid-cols-1 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Bedrijfsnaam</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $task->feedback?->customer?->name_company ?? 'Onbekend' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Contactpersoon</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $task->feedback?->customer?->contact_person ?? 'Niet beschikbaar' }}</dd>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $task->feedback?->customer?->email ?? 'Niet beschikbaar' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Telefoon</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $task->feedback?->customer?->phone_number ?? 'Niet beschikbaar' }}</dd>
                            </div>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Adres</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $task->feedback?->customer?->address ?? 'Niet beschikbaar' }}, {{ $task->feedback?->customer?->zipcode ?? '' }} {{ $task->feedback?->customer?->city ?? '' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Taak Informatie -->
                <div class="bg-[#f3f4f6] rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Taak Informatie</h2>
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Datum & Tijd</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($task->scheduled_time)->format('d-m-Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    @if(\Carbon\Carbon::parse($task->scheduled_time)->isFuture())
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#f3f4f6] text-orange-800">
                                            Open
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#f3f4f6] text-green-800">
                                            Voltooid
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Locatie</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $task->location }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($task->catagory) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Beschrijving</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $task->feedback?->description ?? 'Geen beschrijving beschikbaar' }}</dd>
                        </div>
                        @if($task->feedback?->feedback)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Feedback</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $task->feedback->feedback }}</dd>
                        </div>
                        @endif
                        @if($task->feedback?->products && $task->feedback->products->count() > 0)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Product(en) voor onderhoud</dt>
                            <dd class="mt-2 space-y-2">
                                @foreach($task->feedback->products as $product)
                                <div class="flex items-center justify-between p-2 bg-[#f3f4f6] rounded text-sm">
                                    <div class="flex-1">
                                        <span class="font-medium text-gray-900">{{ $product->product_name }}</span>
                                        @if($product->pivot->quantity > 1)
                                        <span class="text-xs text-gray-500 ml-2">({{ $product->pivot->quantity }}x)</span>
                                        @endif
                                    </div>
                                    <span class="text-gray-600">€{{ number_format($product->price, 2, ',', '.') }}</span>
                                </div>
                                @endforeach
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Right Section: Technicus Info -->
            <div class="lg:col-span-1">
                <div class="bg-[#f3f4f6] rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Toegewezen Technicus</h2>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                @php
                                    $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#14b8a6'];
                                    $avatarColor = $colors[$task->user_id % count($colors)];
                                @endphp
                                <div class="h-12 w-12 rounded-full flex items-center justify-center text-white font-semibold text-lg"
                                    style="background-color: {{ $avatarColor }}">
                                    {{ strtoupper(substr($task->user?->name ?? 'N', 0, 1)) }}
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $task->user?->name ?? 'Niet toegewezen' }}</div>
                                <div class="text-xs text-gray-500">{{ $task->user?->department ?? 'Technician' }}</div>
                            </div>
                        </div>
                        @if($task->user)
                        <div class="pt-4 border-t border-gray-200">
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $task->user->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Telefoon</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $task->user->phone_num ?? 'Niet beschikbaar' }}</dd>
                                </div>
                            </dl>
                        </div>
                        @endif
                    </div>

                    <!-- Status & Rapport -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        @if($task->status !== 'open')
                        <div class="mb-3">
                            <span class="text-xs font-medium text-gray-500">Status:</span>
                            @if($task->status === 'voltooid')
                            <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-[#f3f4f6] text-green-800">
                                Voltooid
                            </span>
                            @elseif($task->status === 'probleem')
                            <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-[#f3f4f6] text-red-800">
                                Probleem
                            </span>
                            @elseif($task->status === 'te_laat')
                            <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-[#f3f4f6] text-yellow-800">
                                Te laat
                            </span>
                            @endif
                        </div>
                        @endif

                        @if($task->status === 'open' || $task->status === 'te_laat')
                        <a href="{{ route('technician.onderhoud.rapport', $task->id) }}"
                           class="block w-full px-4 py-2 bg-indigo-600 text-white text-center rounded-lg hover:bg-indigo-700 font-medium text-sm">
                            Maak Rapport
                        </a>
                        @else
                        <a href="{{ route('technician.onderhoud.rapport', $task->id) }}"
                           class="block w-full px-4 py-2 border border-indigo-600 text-indigo-600 text-center rounded-lg hover:bg-indigo-50 font-medium text-sm">
                            Bekijk / Wijzig Rapport
                        </a>
                        @endif
                    </div>

                </div>

                <!-- Rapport Weergave (indien ingevuld) -->
                @if($task->feedback?->feedback)
                <div class="bg-[#f3f4f6] rounded-lg border border-gray-200 p-6 mt-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Rapport</h3>
                    <div class="prose prose-sm max-w-none">
                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $task->feedback->feedback }}</p>
                    </div>

                    @if($task->used_materials)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Gebruikte materialen</h4>
                        <p class="text-sm text-gray-600 whitespace-pre-line">{{ $task->used_materials }}</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </main>
</x-layouts.app>

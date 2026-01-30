<x-layouts.app :title="'Onderhoud Details'">
    <main class="p-6 max-w-6xl mx-auto">
        <!-- Header -->
        <header class="mb-6">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-semibold text-black">Onderhoud Details</h1>
                <p class="text-sm text-gray-600">Taak #{{ $task->id }}</p>
            </div>
            <a href="{{ route('technician.planning') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                Terug naar overzicht
            </a>
        </header>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Section: Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Klant Informatie -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50">
                        <h2 class="text-lg font-semibold text-black">Klant Informatie</h2>
                    </div>
                    <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-base font-medium text-gray-900">Bedrijfsnaam</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-600">{{ $task->feedback?->customer?->name_company ?? 'Onbekend' }}</dd>
                        </div>
                        <div>
                            <dt class="text-base font-medium text-gray-900">Contactpersoon</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-600">{{ $task->feedback?->customer?->contact_person ?? 'Niet beschikbaar' }}</dd>
                        </div>
                        <div>
                            <dt class="text-base font-medium text-gray-900">Email</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-600">{{ $task->feedback?->customer?->email ?? 'Niet beschikbaar' }}</dd>
                        </div>
                        <div>
                            <dt class="text-base font-medium text-gray-900">Telefoon</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-600">{{ $task->feedback?->customer?->phone_number ?? 'Niet beschikbaar' }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-base font-medium text-gray-900">Adres</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-600">{{ $task->feedback?->customer?->address ?? 'Niet beschikbaar' }}, {{ $task->feedback?->customer?->zipcode ?? '' }} {{ $task->feedback?->customer?->city ?? '' }}</dd>
                        </div>
                    </dl>
                    </div>
                </div>

                <!-- Taak Informatie -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50">
                        <h2 class="text-lg font-semibold text-black">Taak Informatie</h2>
                    </div>
                    <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-base font-medium text-gray-900">Datum & Tijd</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-600">{{ \Carbon\Carbon::parse($task->scheduled_time)->format('d-m-Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-base font-medium text-gray-900">Status</dt>
                            <dd class="mt-1">
                                @if(\Carbon\Carbon::parse($task->scheduled_time)->isFuture())
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                        Open
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Voltooid
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-base font-medium text-gray-900">Locatie</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-600">{{ $task->location }}</dd>
                        </div>
                        <div>
                            <dt class="text-base font-medium text-gray-900">Type</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-600">{{ ucfirst($task->catagory) }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-base font-medium text-gray-900">Beschrijving</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-600">{{ $task->feedback?->description ?? 'Geen beschrijving beschikbaar' }}</dd>
                        </div>
                        @if($task->feedback?->feedback)
                        <div class="md:col-span-2">
                            <dt class="text-base font-medium text-gray-900">Feedback</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-600">{{ $task->feedback->feedback }}</dd>
                        </div>
                        @endif
                        @if($task->feedback?->products && $task->feedback->products->count() > 0)
                        <div class="md:col-span-2">
                            <dt class="text-base font-medium text-gray-900">Product(en) voor onderhoud</dt>
                            <dd class="mt-3 overflow-hidden rounded-lg border border-gray-200">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-3 py-2 text-left font-medium text-gray-700">Product</th>
                                            <th class="px-3 py-2 text-right font-medium text-gray-700">Aantal</th>
                                            <th class="px-3 py-2 text-right font-medium text-gray-700">Prijs</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($task->feedback->products as $product)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 py-2 text-gray-900">{{ $product->product_name }}</td>
                                            <td class="px-3 py-2 text-right text-gray-600">{{ $product->pivot->quantity ?? 1 }}x</td>
                                            <td class="px-3 py-2 text-right text-gray-600">€{{ number_format($product->price, 2, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </dd>
                        </div>
                        @endif
                    </dl>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        @if($task->status === 'open' || $task->status === 'te_laat')
                        <a href="{{ route('technician.onderhoud.rapport', $task->id) }}"
                           class="inline-flex items-center px-3 py-1.5 bg-yellow-400 text-black rounded-md hover:bg-yellow-300 font-semibold text-sm shadow-sm transition-colors">
                            Maak Rapport
                        </a>
                        @else
                        <a href="{{ route('technician.onderhoud.rapport', $task->id) }}"
                           class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 font-semibold text-sm transition-colors">
                            Bekijk / Wijzig Rapport
                        </a>
                        @endif
                    </div>
                    </div>
                </div>
            </div>

            <!-- Right Section: Technicus Info -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50">
                        <h2 class="text-lg font-semibold text-black">Toegewezen Technicus</h2>
                    </div>
                    <div class="p-6 space-y-4">
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
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-base font-medium text-gray-900">Email</dt>
                                    <dd class="mt-1 text-sm font-medium text-gray-600">{{ $task->user->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-base font-medium text-gray-900">Telefoon</dt>
                                    <dd class="mt-1 text-sm font-medium text-gray-600">{{ $task->user->phone_num ?? 'Niet beschikbaar' }}</dd>
                                </div>
                            </dl>
                        </div>
                        @endif
                    </div>

                </div>

                <!-- Rapport Weergave (indien ingevuld) -->
                @if($task->feedback?->feedback)
                <div class="bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden mt-4">
                    <div class="p-5 border-b border-gray-100 bg-gray-50">
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="text-lg font-semibold text-black">Rapport</h3>
                            <div>
                                <span class="text-xs font-medium text-gray-500">Status:</span>
                                @if($task->status === 'voltooid')
                                <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Voltooid</span>
                                @elseif($task->status === 'probleem')
                                <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Probleem</span>
                                @elseif($task->status === 'te_laat')
                                <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Te laat</span>
                                @else
                                <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Open</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
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
                </div>
                @endif
            </div>
        </div>
    </main>
</x-layouts.app>

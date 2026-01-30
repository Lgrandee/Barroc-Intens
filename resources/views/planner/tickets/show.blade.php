<x-layouts.app :title="'Ticket detail'">
    <main class="p-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Ticket detail</h1>
                </div>
                <div class="flex gap-3">
                    <button onclick="alert('Ticket toegewezen')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm">
                        Toewijzen
                    </button>
                    <button onclick="alert('Ticket geëscaleerd')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm">
                        Escaleren
                    </button>
                    <button onclick="confirm('Ticket sluiten?') && alert('Ticket gesloten')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm">
                        Sluit ticket
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Section: Communication & Updates -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Ticket Header -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-gray-900 mb-2">
                                #TCK-{{ date('Y') }}-{{ str_pad($ticket->id, 3, '0', STR_PAD_LEFT) }} — {{ $ticket->feedback?->description ?? 'Geen onderwerp' }}
                            </h2>
                            <p class="text-sm text-gray-600">
                                Aangemaakt door: {{ $ticket->feedback?->employee?->name ?? 'Onbekend' }} • Status:
                                @if(\Carbon\Carbon::parse($ticket->scheduled_time)->isFuture())
                                    <span class="text-orange-600 font-medium">Open</span>
                                @else
                                    <span class="text-green-600 font-medium">Gesloten</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            @if(\Carbon\Carbon::parse($ticket->scheduled_time)->isFuture())
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                    Open
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Gesloten
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Communication & Updates -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Communicatie & updates</h3>

                    <div class="space-y-4">
                        <!-- Example Update -->
                        <div class="border-l-4 border-indigo-500 pl-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-medium text-gray-900">{{ $ticket->user?->name ?? 'Technicus' }}</span>
                                <span class="text-xs text-gray-500">— {{ \Carbon\Carbon::parse($ticket->scheduled_time)->format('d M Y') }}</span>
                            </div>
                            <p class="text-sm text-gray-700">{{ $ticket->feedback?->feedback ?? 'Ticket geregistreerd en in behandeling genomen.' }}</p>
                        </div>

                        @if($ticket->user)
                        <div class="border-l-4 border-green-500 pl-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-medium text-gray-900">Technieker</span>
                                <span class="text-xs text-gray-500">— {{ \Carbon\Carbon::parse($ticket->scheduled_time)->addDay()->format('d M Y') }}</span>
                            </div>
                            <p class="text-sm text-gray-700">Gepland voor inspectie op {{ \Carbon\Carbon::parse($ticket->scheduled_time)->format('d M') }}. Eerste check: {{ $ticket->location }}.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- New Message -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Nieuw bericht</h3>

                    <form>
                        <textarea rows="4" placeholder="Antwoord of update toevoegen"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent mb-3"></textarea>
                        <div class="flex gap-3">
                            <button type="button" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm">
                                Plaats bericht
                            </button>
                            <button type="button" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm">
                                Opslaan als intern
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Internal Notes -->
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Interne notities</h3>
                    <p class="text-sm text-gray-700">Technieker checklist toegevoegd: {{ $ticket->location }}.</p>
                </div>

                <!-- Rapport Section -->
                @if(in_array($ticket->status, ['voltooid', 'probleem', 'te_laat']))
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Rapport van technicus</h3>

                    @if($ticket->feedback?->feedback || $ticket->used_materials)
                        <!-- Status -->
                        <div class="mb-4">
                            <dt class="text-sm font-medium text-gray-700 mb-1">Status</dt>
                            <dd>
                                @if($ticket->status === 'voltooid')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Voltooid
                                    </span>
                                @elseif($ticket->status === 'probleem')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Probleem
                                    </span>
                                @elseif($ticket->status === 'te_laat')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                        Te laat
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <!-- Feedback from technician -->
                        @if($ticket->feedback?->feedback)
                        <div class="mb-4">
                            <dt class="text-sm font-medium text-gray-700 mb-1">Opmerkingen</dt>
                            <dd class="text-sm text-gray-900 whitespace-pre-line">{{ $ticket->feedback->feedback }}</dd>
                        </div>
                        @endif

                        <!-- Used Materials -->
                        @if($ticket->used_materials)
                        <div class="mb-4">
                            <dt class="text-sm font-medium text-gray-700 mb-1">Gebruikte materialen</dt>
                            <dd class="text-sm text-gray-900 whitespace-pre-line">{{ $ticket->used_materials }}</dd>
                        </div>
                        @endif

                        <!-- Products worked on -->
                        @if($ticket->feedback?->products && $ticket->feedback->products->count() > 0)
                        <div>
                            <dt class="text-sm font-medium text-gray-700 mb-2">Producten</dt>
                            <dd>
                                <div class="space-y-2">
                                    @foreach($ticket->feedback->products as $product)
                                        <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded border border-gray-200">
                                            <span class="text-sm text-gray-900">{{ $product->product_name }}</span>
                                            <span class="text-xs text-gray-500">Aantal: {{ $product->pivot->quantity }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </dd>
                        </div>
                        @endif

                        <!-- Technician info -->
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <dt class="text-xs font-medium text-gray-500">Afgehandeld door</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $ticket->user?->name ?? 'Onbekend' }}</dd>
                            <dd class="mt-1 text-xs text-gray-500">Laatste update: {{ \Carbon\Carbon::parse($ticket->updated_at)->format('d M Y H:i') }}</dd>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Nog geen rapport beschikbaar.</p>
                    @endif
                </div>
                @endif
            </div>

            <!-- Right Section: Ticket Details -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ticket details</h3>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Klant</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $ticket->feedback?->customer?->name_company ?? 'Onbekend' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Afdeling</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($ticket->catagory) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Prioriteit</dt>
                            <dd class="mt-1">
                                <span class="text-sm text-red-600 font-medium">Hoog</span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Aangemaakt</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($ticket->created_at)->format('d M Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Laatste update</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($ticket->updated_at)->format('d M Y') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 pt-4 border-t border-gray-200 flex gap-2">
                        <button onclick="alert('Status gewijzigd')" class="flex-1 px-3 py-2 border border-gray-300 text-gray-700 rounded text-sm hover:bg-gray-50">
                            Wijzig status
                        </button>
                        <button onclick="alert('Bijlage toegevoegd')" class="flex-1 px-3 py-2 border border-gray-300 text-gray-700 rounded text-sm hover:bg-gray-50">
                            Voeg bijlage toe
                        </button>
                    </div>

                    @if($ticket->feedback?->customer)
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Bijlagen</h4>
                        <div class="text-xs text-gray-500">Geen bijlagen beschikbaar</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bottom Link -->
        <div class="mt-6">
            <a href="{{ route('planner.tickets.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium underline">
                Terug naar ticket overzicht
            </a>
        </div>
    </main>
</x-layouts.app>

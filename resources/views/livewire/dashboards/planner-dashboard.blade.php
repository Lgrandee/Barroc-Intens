<div wire:poll.2s>
@php($title = 'Planner Dashboard')

<div class="p-6 bg-[#FAF9F6]">
    <div class="bg-gradient-to-br from-purple-600 to-purple-800 text-white rounded-xl p-6 mb-6 shadow-lg">
        <h1 class="text-xl font-semibold mb-1">Goedemorgen, {{ auth()->user()->name ?? 'Gebruiker' }} 👋</h1>
        <p class="text-sm text-white/90 mb-4">Je hebt {{ $plannedTasksCount }} taken ingepland voor deze week en {{ $backlogCount }} achterstallige taken</p>
        <div class="flex flex-wrap gap-3">
             <a href="{{ route('planner.tickets.create') }}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">+ Nieuwe Planning</a>
             <a href="{{ route('planner.tickets.index') }}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">📊 Overzicht</a>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:space-x-6 gap-6 mb-6">
        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Geplande Taken</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-purple-100 text-purple-700 rounded">📅</div>
            </div>
            <p class="text-2xl font-semibold mt-3">{{ $plannedTasksCount }}</p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Voltooide Taken</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-purple-100 text-purple-700 rounded">✅</div>
            </div>
            <p class="text-2xl font-semibold mt-3">{{ $completedTasksCount }}</p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Team Capaciteit</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-purple-100 text-purple-700 rounded">👥</div>
            </div>
            <p class="text-2xl font-semibold mt-3">{{ $teamCapacityPercent }}%</p>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm text-gray-500">Achterstand</h3>
                <div class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-700 rounded">⚠️</div>
            </div>
            <p class="text-2xl font-semibold mt-3">{{ $backlogCount }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Wekelijks Overzicht</h2>
                    <div class="flex gap-2">
                        <!-- Toggles removed: dead -->
                    </div>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        @foreach($weeklyOverview as $day)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-medium text-sm">{{ $day['label'] }}</div>
                                <div class="text-xs text-gray-500">{{ $day['tasks'] }} taken gepland</div>
                            </div>
                            <div class="text-sm {{ $day['percent'] > 100 ? 'text-red-600' : ($day['percent'] > 80 ? 'text-yellow-600' : 'text-green-600') }}">{{ $day['percent'] }}% capaciteit</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium">Team Planning</h2>
                    <!-- Button removed: dead -->
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($teamSchedule as $member)
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-medium text-sm">{{ $member->name }}</div>
                            <div class="text-xs {{ $member->planningTickets->count() > 3 ? 'text-yellow-600' : 'text-green-600' }}">
                                {{ $member->planningTickets->count() > 3 ? 'Bijna vol' : 'Beschikbaar' }}
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            @if($member->planningTickets->count() > 0)
                                Vandaag: {{ $member->planningTickets->count() }} afspraken - @foreach($member->planningTickets as $t){{ \Carbon\Carbon::parse($t->scheduled_time)->format('H:i') }}@if(!$loop->last), @endif @endforeach
                            @else
                                Vandaag: Geen afspraken
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-gray-500 text-center">Geen teamleden gevonden.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="flex items-center justify-between p-4 border-b border-gray-100">
                        <h2 class="text-lg font-medium">Urgente Aanpassingen</h2>
                        <a href="{{ route('planner.tickets.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Alle Meldingen</a>
                    </div>
                <div class="divide-y divide-gray-100">
                    @forelse($urgentChanges as $change)
                    <div class="p-4">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 {{ $change->priority === 'hoog' ? 'bg-red-500' : 'bg-blue-500' }} rounded-full mt-2"></div>
                            <div class="flex-1">
                                <div class="font-medium text-sm">{{ $change->catagory }} - {{ $change->location ?? 'Geen locatie' }}</div>
                                <div class="text-sm text-gray-500">{{ $change->user->name ?? 'Niet toegewezen' }}</div>
                                <div class="text-xs text-gray-400">{{ $change->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-gray-500 text-center">Geen urgente aanpassingen.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
</div>

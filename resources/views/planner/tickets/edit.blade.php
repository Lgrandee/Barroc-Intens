<x-layouts.app :title="'Ticket bewerken'">
	<div class="max-w-6xl mx-auto p-6 bg-gray-100 min-h-screen">
		<header class="mb-6">
			<div class="flex items-center justify-between mb-4">
				<div>
					<h1 class="text-3xl font-semibold text-black dark:text-white">Ticket bewerken</h1>
					<p class="text-sm text-gray-600 dark:text-gray-300">Pas de details van dit ticket aan</p>
				</div>
				<div class="flex gap-2">
					<a href="{{ route('planner.tickets.show', $ticket->id) }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-black hover:bg-gray-100 transition" title="Bekijk ticket">
						👁️ <span class="text-gray-400">View</span>
						<span class="sr-only">Bekijk ticket</span>
					</a>
					<a href="{{ route('planner.tickets.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
						<svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
						Terug naar tickets
					</a>
				</div>
			</div>
		</header>

		<div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
			<div class="p-6">
				<form method="POST" action="{{ route('planner.tickets.update', $ticket->id) }}">
					@csrf
					@method('PUT')
					<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
						<!-- Linker sectie -->
						<div class="lg:col-span-2 space-y-6">
							<div class="bg-white rounded-lg border border-gray-200 p-6">
								<h3 class="text-lg font-semibold text-black mb-4">Ticket informatie</h3>
								<div class="mb-4">
									<label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-1">Afspraakdatum</label>
									<input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date', $ticket->appointment_date ? \Carbon\Carbon::parse($ticket->appointment_date)->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
								</div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Klant</label>
									<select name="customer_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
										@foreach($customers as $customer)
											<option value="{{ $customer->id }}" @if($ticket->feedback?->customer?->id == $customer->id) selected @endif>{{ $customer->name_company }}</option>
										@endforeach
									</select>
								</div>
								<div class="mb-4">
									<label class="block text-sm font-medium text-gray-700 mb-1">Onderwerp</label>
									<input type="text" name="subject" value="{{ old('subject', $ticket->feedback?->description) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
								</div>
								<div class="mb-4">
									<label class="block text-sm font-medium text-gray-700 mb-1">Beschrijving</label>
									<textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>{{ old('description', $ticket->feedback?->feedback) }}</textarea>
								</div>
								<div class="mb-4">
									<label class="block text-sm font-medium text-gray-700 mb-1">Categorie</label>
									<select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
										<option value="meeting" @if($ticket->catagory == 'meeting') selected @endif>Meeting</option>
										<option value="installation" @if($ticket->catagory == 'installation') selected @endif>Installatie</option>
										<option value="service" @if($ticket->catagory == 'service') selected @endif>Service</option>
									</select>
								</div>
								<div class="mb-4">
									<label class="block text-sm font-medium text-gray-700 mb-1">Prioriteit</label>
									<select name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
										<option value="laag" @if($ticket->priority == 'laag') selected @endif>Laag</option>
										<option value="medium" @if($ticket->priority == 'medium') selected @endif>Middel</option>
										<option value="hoog" @if($ticket->priority == 'hoog') selected @endif>Hoog</option>
									</select>
								</div>
								<div class="mb-4">
									<label class="block text-sm font-medium text-gray-700 mb-1">Technieker</label>
									<select name="technician_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
										<option value="">-- Geen --</option>
										@foreach($technicians as $technician)
											<option value="{{ $technician->id }}" @if($ticket->user_id == $technician->id) selected @endif>{{ $technician->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<!-- Rechter sectie -->
						<div class="lg:col-span-1">
							<div class="bg-white rounded-lg border border-gray-200 p-6">
								<h3 class="text-lg font-semibold text-black mb-4">Ticket details</h3>
								<dl class="space-y-3">
									<div>
										<dt class="text-xs font-medium text-gray-500">Aangemaakt</dt>
										<dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($ticket->created_at)->format('d M Y') }}</dd>
									</div>
									<div>
										<dt class="text-xs font-medium text-gray-500">Laatste update</dt>
										<dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($ticket->updated_at)->format('d M Y') }}</dd>
									</div>
								</dl>
								<div class="mt-6 pt-4 border-t border-gray-200 space-y-3">
									<!-- Opslaan en Annuleren knoppen -->
									<div class="flex gap-2">
										<a href="{{ route('planner.tickets.show', $ticket->id) }}" class="flex-1 text-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors">
											Annuleren
										</a>
										<button type="submit" class="flex-1 px-4 py-2 rounded-md bg-yellow-400 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
											Opslaan
										</button>
									</div>
									<!-- Verwijder knop -->
									<div class="pt-2 border-t border-gray-100">
										<button type="button" onclick="if(confirm('Weet je zeker dat je dit ticket wilt verwijderen?')) { document.getElementById('delete-form').submit(); }" class="w-full text-gray-400 text-sm py-2 hover:text-gray-600 transition-colors" title="Verwijder ticket">
											Ticket verwijderen
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
				
				<!-- Verborgen verwijder-formulier -->
				<form id="delete-form" method="POST" action="{{ route('planner.tickets.destroy', $ticket->id) }}" style="display: none;">
					@csrf
					@method('DELETE')
				</form>
			</div>
		</div>
	</div>
</x-layouts.app>

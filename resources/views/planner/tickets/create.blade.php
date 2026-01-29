<x-layouts.app :title="'Ticket aanmaken'">
    <div class="max-w-3xl mx-auto p-6 bg-gray-100 min-h-screen">
        <header class="mb-6">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-semibold text-black dark:text-white">Ticket aanmaken</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">Registreer een nieuw ticket voor een klant</p>
            </div>
            <a href="{{ route('planner.tickets.index') }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                Terug naar tickets
            </a>
        </header>

        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
            <div class="flex items-center justify-center min-h-screen bg-white p-8">
                <div class="w-full max-w-2xl">
                <!-- Linker sectie: formulier -->
                <div class="lg:col-span-2">
                    <h2 class="text-lg font-semibold text-black mb-4">Nieuw ticket registreren</h2>
                    <p class="text-sm text-gray-600 mb-6">Gebruik dit formulier om klantvragen snel te registreren</p>
                    <form method="POST" action="{{ route('planner.tickets.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Customer Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kies klant of zoek...</label>
                            <select name="customer_id" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
                                <option value="">Selecteer een klant</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name_company }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Ticket Number (auto) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ticketnummer (auto)</label>
                            <input type="text" readonly value="#TCK-{{ date('Y') }}-{{ str_pad(\App\Models\PlanningTicket::count() + 1, 3, '0', STR_PAD_LEFT) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-500 text-sm">
                        </div>
                        <!-- Subject -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Onderwerp</label>
                            <input type="text" name="subject" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
                        </div>
                        <!-- Category and Priority -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Categorie: Technisch</label>
                                <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
                                    <option value="service">Service</option>
                                    <option value="installation">Installatie</option>
                                    <option value="meeting">Meeting</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Prioriteit</label>
                                <select name="priority" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">Hoog</option>
                                    <option value="low">Laag</option>
                                </select>
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Omschrijving</label>
                            <textarea name="description" rows="5" required placeholder="Beschrijf het probleem of verzoek" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm"></textarea>
                        </div>
                        <!-- Attachments -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bijlagen</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                                <input type="file" name="attachments[]" multiple class="hidden" id="fileInput">
                                <label for="fileInput" class="cursor-pointer">
                                    <div class="text-center">
                                        <button type="button" onclick="document.getElementById('fileInput').click()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium text-sm">Bestand kiezen</button>
                                        <span class="ml-3 text-sm text-gray-500">Geen bestand gekozen</span>
                                    </div>
                                </label>
                                <p class="text-xs text-gray-500 mt-2">Max 10 MB per bestand</p>
                            </div>
                        </div>
                        <!-- Technician Assignment -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Toewijzen aan technicus (optioneel)</label>
                            <select name="technician_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
                                <option value="">Automatisch toewijzen</option>
                                @foreach($technicians as $tech)
                                <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Actions -->
                        <div class="flex justify-between items-center gap-3 mt-8">
                            <a href="{{ route('planner.tickets.index') }}" class="text-sm text-gray-500 hover:text-gray-800 hover:underline">Annuleer</a>
                            <div class="flex gap-3">
                                <button type="button" onclick="alert('Opgeslagen als concept')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 font-medium text-sm transition">Opslaan als concept</button>
                                <button type="submit" class="px-4 py-2 bg-yellow-400 text-black rounded-md text-sm font-medium hover:bg-yellow-300 transition shadow-sm inline-flex items-center gap-2">Maak ticket aan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- SLA & Tips onderaan als grijze tekst -->
                <div class="col-span-full mt-8">
                    <div class="text-xs text-gray-500 text-center">
                        Standaard reactietijd: 48 uur (Service). 
                    </div>
                                        <div class="text-xs text-gray-500 text-center">
                        Technische tickets worden binnen 2 werkdagen opgepakt.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

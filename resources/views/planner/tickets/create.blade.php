<x-layouts.app :title="'Ticket aanmaken'">
    <main class="p-6">
        <!-- Header -->
        <header class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Ticket aanmaken</h1>
        </header>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Section: Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Nieuw ticket registreren</h2>
                    <p class="text-sm text-gray-600 mb-6">Gebruik dit formulier om klantvragen snel te registreren</p>

                    <form method="POST" action="{{ route('planner.tickets.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Customer Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kies klant of zoek...</label>
                            <select name="customer_id" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                <option value="">Selecteer een klant</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name_company }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ticket Number (auto) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ticketnummer (auto)</label>
                            <input type="text" readonly value="#TCK-{{ date('Y') }}-{{ str_pad(\App\Models\PlanningTicket::count() + 1, 3, '0', STR_PAD_LEFT) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                        </div>

                        <!-- Subject -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Onderwerp</label>
                            <input type="text" name="subject" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        </div>

                        <!-- Category and Priority -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Categorie: Technisch</label>
                                <select name="category" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                    <option value="service">Service</option>
                                    <option value="installation">Installatie</option>
                                    <option value="meeting">Meeting</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Prioriteit</label>
                                <select name="priority"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">Hoog</option>
                                    <option value="low">Laag</option>
                                </select>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Omschrijving</label>
                            <textarea name="description" rows="5" required placeholder="Beschrijf het probleem of verzoek"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent"></textarea>
                        </div>

                        <!-- Attachments -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bijlagen</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                                <input type="file" name="attachments[]" multiple class="hidden" id="fileInput">
                                <label for="fileInput" class="cursor-pointer">
                                    <div class="text-center">
                                        <button type="button" onclick="document.getElementById('fileInput').click()"
                                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium text-sm">
                                            Bestand kiezen
                                        </button>
                                        <span class="ml-3 text-sm text-gray-500">Geen bestand gekozen</span>
                                    </div>
                                </label>
                                <p class="text-xs text-gray-500 mt-2">Max 10 MB per bestand</p>
                            </div>
                        </div>

                        <!-- Technician Assignment -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Toewijzen aan technicus (optioneel)</label>
                            <select name="technician_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                <option value="">Automatisch toewijzen</option>
                                @foreach($technicians as $tech)
                                <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <button type="button" onclick="alert('Opgeslagen als concept')"
                                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm">
                                Opslaan als concept
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium text-sm">
                                Maak ticket aan
                            </button>
                        </div>
                    </form>

                    <!-- Bottom Link -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <a href="{{ route('planner.tickets.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium underline">
                            Terug naar ticket overzicht
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Section: SLA & Tips -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">SLA & Tips</h2>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">Standaard reactietijd: 48 uur (Service)</h3>
                            <p class="text-xs text-gray-600">Technische tickets worden binnen 2 werkdagen opgepakt</p>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <a href="{{ route('planner.tickets.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium underline">
                                Terug naar overzicht
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>

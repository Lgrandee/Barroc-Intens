<x-layouts.app :title="'Rapport maken'">
    <main class="p-6 max-w-6xl mx-auto">
        <!-- Header -->
        <header class="mb-6">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-semibold text-black">Rapport maken</h1>
                <p class="text-sm text-gray-600">Taak #{{ $task->id }} - {{ $task->feedback?->customer?->name_company ?? 'Onbekend' }}</p>
            </div>
            <a href="{{ route('technician.onderhoud.show', $task->id) }}" class="inline-flex items-center gap-2 rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 transition-colors">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 0110.707 6.293L8.414 8.586H16a1 1 0 110 2H8.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                Terug naar details
            </a>
        </header>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Section: Rapport Form -->
            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50">
                        <h2 class="text-lg font-semibold text-black">Rapport invullen</h2>
                    </div>
                    <div class="p-6">

                    @if(session('success'))
                    <div class="mb-4 p-3 bg-gray-50 border border-green-200 text-green-800 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('technician.onderhoud.rapport.update', $task->id) }}">
                        @csrf

                        <!-- Status -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status van de taak <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="status"
                                id="status"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('status') border-red-500 @enderror">
                                <option value="">-- Selecteer status --</option>
                                <option value="voltooid" {{ old('status', $task->status) === 'voltooid' ? 'selected' : '' }}>
                                    ✓ Voltooid - Taak is succesvol afgerond
                                </option>
                                <option value="probleem" {{ old('status', $task->status) === 'probleem' ? 'selected' : '' }}>
                                    ⚠ Probleem - Er zijn problemen aangetroffen
                                </option>
                            </select>
                            @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Kies "Probleem" als er complicaties waren of vervolgacties nodig zijn</p>
                        </div>

                        <!-- Rapport -->
                        <div class="mb-6">
                            <label for="feedback" class="block text-sm font-medium text-gray-700 mb-2">
                                Rapport van werkzaamheden <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                name="feedback"
                                id="feedback"
                                rows="8"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('feedback') border-red-500 @enderror"
                                placeholder="Beschrijf uitgebreid:&#10;- Welke werkzaamheden zijn uitgevoerd&#10;- Wat waren de bevindingen&#10;- Zijn er problemen geconstateerd&#10;- Welke vervolgacties zijn nodig&#10;- Eventuele aanbevelingen voor de klant">{{ old('feedback', $task->feedback?->feedback) }}</textarea>
                            @error('feedback')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gebruikte Materialen -->
                        <div class="mb-6">
                            <label for="used_materials" class="block text-sm font-medium text-gray-700 mb-2">
                                Gebruikte materialen
                            </label>
                            <textarea
                                name="used_materials"
                                id="used_materials"
                                rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('used_materials') border-red-500 @enderror"
                                placeholder="Bijvoorbeeld:&#10;- 2x Filter type A&#10;- 1x Koelmiddel R32 (2kg)&#10;- 3x Schroeven M6&#10;- 1x Dichting 50mm">{{ old('used_materials', $task->used_materials) }}</textarea>
                            @error('used_materials')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Optioneel: Geef aan welke materialen je hebt gebruikt</p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-3 pt-4 border-t border-gray-200">
                            <button
                                type="submit"
                                class="px-6 py-2 bg-yellow-400 text-black rounded-lg hover:bg-yellow-300 font-medium text-sm shadow-sm transition-colors">
                                Rapport opslaan en afronden
                            </button>
                            <a
                                href="{{ route('technician.onderhoud.show', $task->id) }}"
                                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-[#f3f4f6] font-medium text-sm">
                                Annuleren
                            </a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

            <!-- Right Section: Task Info -->
            <div class="lg:col-span-1">
                <!-- Taak Samenvatting -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden mb-4">
                    <div class="p-5 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-lg font-semibold text-black">Taak samenvatting</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-4">
                            <div>
                                <dt class="text-base font-medium text-gray-900">Klant</dt>
                                <dd class="mt-1 text-sm font-medium text-gray-600">{{ $task->feedback?->customer?->name_company ?? 'Onbekend' }}</dd>
                            </div>
                            <div>
                                <dt class="text-base font-medium text-gray-900">Datum & Tijd</dt>
                                <dd class="mt-1 text-sm font-medium text-gray-600">{{ \Carbon\Carbon::parse($task->scheduled_time)->format('d-m-Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-base font-medium text-gray-900">Locatie</dt>
                                <dd class="mt-1 text-sm font-medium text-gray-600">{{ $task->location }}</dd>
                            </div>
                            <div>
                                <dt class="text-base font-medium text-gray-900">Beschrijving</dt>
                                <dd class="mt-1 text-sm font-medium text-gray-600">{{ $task->feedback?->description ?? 'Geen beschrijving' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Producten -->
                @if($task->feedback?->products && $task->feedback->products->count() > 0)
                <div class="bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-lg font-semibold text-black">Product(en)</h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-hidden rounded-lg border border-gray-200">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left font-medium text-gray-700">Product</th>
                                        <th class="px-3 py-2 text-right font-medium text-gray-700">Aantal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($task->feedback->products as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 text-gray-900">{{ $product->product_name }}</td>
                                        <td class="px-3 py-2 text-right text-gray-600">{{ $product->pivot->quantity ?? 1 }}x</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </main>
</x-layouts.app>

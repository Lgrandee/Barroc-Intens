<x-layouts.app :title="'Rapport maken'">
    <main class="p-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Rapport maken</h1>
                    <p class="text-sm text-gray-600 mt-1">Taak #{{ $task->id }} - {{ $task->feedback?->customer?->name_company ?? 'Onbekend' }}</p>
                </div>
                <a href="{{ route('technician.onderhoud.show', $task->id) }}"
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm">
                    Terug naar details
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Section: Rapport Form -->
            <div class="lg:col-span-2">
                <div class="bg-[#f3f4f6] rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Rapport invullen</h2>

                    @if(session('success'))
                    <div class="mb-4 p-3 bg-[#f3f4f6] border border-green-200 text-green-800 rounded-lg text-sm">
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
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('status') border-red-500 @enderror">
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
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('feedback') border-red-500 @enderror"
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
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('used_materials') border-red-500 @enderror"
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
                                class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium text-sm">
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

            <!-- Right Section: Task Info -->
            <div class="lg:col-span-1">
                <!-- Taak Samenvatting -->
                <div class="bg-[#f3f4f6] rounded-lg border border-gray-200 p-6 mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Taak samenvatting</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Klant</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $task->feedback?->customer?->name_company ?? 'Onbekend' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Datum & Tijd</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($task->scheduled_time)->format('d-m-Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Locatie</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $task->location }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Beschrijving</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $task->feedback?->description ?? 'Geen beschrijving' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Producten -->
                @if($task->feedback?->products && $task->feedback->products->count() > 0)
                <div class="bg-[#f3f4f6] rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Product(en)</h3>
                    <div class="space-y-2">
                        @foreach($task->feedback->products as $product)
                        <div class="flex items-center justify-between p-2 bg-[#f3f4f6] rounded text-sm">
                            <div class="flex-1">
                                <span class="font-medium text-gray-900">{{ $product->product_name }}</span>
                                @if($product->pivot->quantity > 1)
                                <span class="text-xs text-gray-500 ml-2">({{ $product->pivot->quantity }}x)</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </main>
</x-layouts.app>

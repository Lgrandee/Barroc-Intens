@php($title = 'Sales Dashboard')
@extends('layouts.layout_dashboard')

@section('welcome_classes', 'bg-gradient-to-br from-blue-600 to-blue-800')
@section('welcome')
	<h1 class="text-xl font-semibold mb-1">Goedemorgen, Lisa 👋</h1>
	<p class="text-sm text-white/90 mb-4">Je hebt 3 openstaande taken en 2 nieuwe leads voor vandaag</p>
	<div class="flex flex-wrap gap-3">
		<a href="{{ route('offertes.create') }}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">+ Nieuwe Offerte</a>
		<a href="{{ route('customers.create') }}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">+ Contact Toevoegen</a>
		<a href="{{ route('offertes.index') }}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded hover:bg-white/20 transition">Alle Offertes</a>
	</div>
@endsection

@section('stats')
	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Totaal Offertes</h3>
			<div class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded">📝</div>
		</div>
		<p class="text-2xl font-semibold mt-3">{{ $totalOffertes }}</p>
		<div class="flex items-center gap-2 text-sm text-green-600 mt-2">↑ 12% <span class="text-gray-400">vs vorige maand</span></div>
	</div>

	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Conversie Ratio</h3>
			<div class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded">📈</div>
		</div>
		<p class="text-2xl font-semibold mt-3">{{ $conversionRatio }}%</p>
		<div class="flex items-center gap-2 text-sm text-green-600 mt-2">↑ 4% <span class="text-gray-400">vs vorige maand</span></div>
	</div>

	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Nieuwe Leads</h3>
			<div class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded">👥</div>
		</div>
		<p class="text-2xl font-semibold mt-3">{{ $newLeads }}</p>
		<div class="flex items-center gap-2 text-sm text-red-600 mt-2">↓ 2% <span class="text-gray-400">vs vorige maand</span></div>
	</div>

	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Gem. Dealwaarde</h3>
			<div class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded">💰</div>
		</div>
		<p class="text-2xl font-semibold mt-3">€3.602</p>
		<div class="flex items-center gap-2 text-sm text-green-600 mt-2">↑ 8% <span class="text-gray-400">vs vorige maand</span></div>
	</div>
@endsection

@section('alerts')
<div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
	<div class="flex items-center justify-between p-4 border-b border-gray-100">
		<h2 class="text-lg font-medium">Sales Pipeline</h2>
		<button class="text-sm text-gray-600">Grafiek Weergave</button>
	</div>
	<div class="p-4">
		<div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg p-8 text-center">
			<p class="text-gray-500">Hier komt een pipeline grafiek met verkoop prestaties</p>
		</div>
	</div>
</div>
@endsection

@section('modules')
<div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
	<div class="flex items-center justify-between p-4 border-b border-gray-100">
		<h2 class="text-lg font-medium">Recente Deals</h2>
		<a href="{{ route('offertes.index') }}" class="text-sm text-gray-600">Alle Deals</a>
	</div>
	<div class="divide-y divide-gray-100">
		@forelse($recentDeals as $deal)
		<div class="flex items-center p-4">
			<div class="flex-1">
				<h4 class="font-medium">Offerte #{{ $deal->id }}</h4>
				<p class="text-sm text-gray-500">{{ $deal->customer->name_company ?? 'Onbekend' }} - Status: {{ $deal->status }}</p>
			</div>
			<div class="text-right">
				<div class="font-medium">{{ $deal->valid_until }}</div>
			</div>
		</div>
		@empty
		<div class="p-4 text-gray-500 text-center">Geen recente deals.</div>
		@endforelse
	</div>
	</div>
</div>
@endsection

@section('activity')
<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
	<div class="flex items-center justify-between p-4 border-b border-gray-100">
		<h2 class="text-lg font-medium">Taken & Activiteiten</h2>
		<button class="text-sm text-gray-600">+ Taak</button>
	</div>
	<div class="p-4 space-y-4">
		<div class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg">
			<div class="w-4 h-4 border-2 border-gray-300 rounded mt-1"></div>
			<div class="flex-1">
				<p class="text-sm font-medium">Follow-up bellen Familie van der Berg</p>
				<p class="text-xs text-gray-500">Vervaldatum: Vandaag 14:00</p>
			</div>
		</div>
		<div class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg">
			<div class="w-4 h-4 border-2 border-gray-300 rounded mt-1"></div>
			<div class="flex-1">
				<p class="text-sm font-medium">Offerte aanpassen voor Bakkerij Jansen</p>
				<p class="text-xs text-gray-500">Vervaldatum: Morgen 10:00</p>
			</div>
		</div>
		<div class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg">
			<div class="w-4 h-4 border-2 border-gray-300 rounded mt-1"></div>
			<div class="flex-1">
				<p class="text-sm font-medium">Contract opsturen naar gemeente</p>
				<p class="text-xs text-gray-500">Vervaldatum: Vrijdag 12:00</p>
			</div>
		</div>
	</div>
</div>
@endsection

@php($title = 'Finance Dashboard')
@extends('layouts.layout_dashboard')

@section('welcome_classes', 'bg-gradient-to-br from-blue-700 to-blue-500')
@section('welcome')
  <h1 class="text-xl font-semibold mb-1">Welkom, {{ auth()->user()->name ?? '' }}</h1>
	<p class="text-sm text-white/90 mb-4">Je hebt 5 openstaande facturen en 3 herinneringen voor deze week</p>
	<div class="flex flex-wrap gap-3">
		<a href="{{route('management.users.index')}}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">Gebruikers Beheren</a>
        <a href="{{route('customers.index')}}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">klanten Beheren</a>
	</div>
@endsection

@section('stats')
	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Omzet Deze Maand</h3>
			<div class="w-8 h-8 flex items-center justify-center bg-yellow-100 text-yellow-700 rounded">💰</div>
		</div>
		<p class="text-2xl font-semibold mt-3">€184.320</p>
	</div>

	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Actieve Colegas</h3>
			<div class="w-8 h-8 flex items-center justify-center bg-yellow-100 text-yellow-700 rounded">📝</div>
		</div>
		<p class="text-2xl font-semibold mt-3">24</p>
	</div>

	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Openstaande tickets</h3>
			<div class="w-8 h-8 flex items-center justify-center bg-yellow-100 text-yellow-700 rounded">⏱️</div>
		</div>
		<p class="text-2xl font-semibold mt-3">18 dagen</p>
		<div class="flex items-center gap-2 text-sm text-red-600 mt-2">↑ 2 dagen <span class="text-gray-400">vs vorige maand</span></div>
	</div>

	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Facturen Te Laat</h3>
			<div class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-700 rounded">⚠️</div>
		</div>
		<p class="text-2xl font-semibold mt-3">8.4%</p>
		<div class="flex items-center gap-2 text-sm text-red-600 mt-2">↑ 1.2% <span class="text-gray-400">vs vorige maand</span></div>
	</div>
@endsection

@section('alerts')
<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
	<div class="flex items-center justify-between p-4 border-b border-gray-100">
		<h2 class="text-lg font-medium">Cashflow Overzicht</h2>
		<div class="flex gap-2">
			<button class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded border border-yellow-200">Maand</button>
			<button class="px-3 py-1 text-sm bg-white text-gray-600 rounded border border-gray-200">Kwartaal</button>
			<button class="px-3 py-1 text-sm bg-white text-gray-600 rounded border border-gray-200">Jaar</button>
		</div>
	</div>
	<div class="p-4">
		<div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg p-8 text-center">
			<p class="text-gray-500">Hier komt een lijngrafiek met inkomsten vs uitgaven</p>
		</div>
	</div>
</div>
@endsection

@section('modules')
<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
	<div class="flex items-center justify-between p-4 border-b border-gray-100">
		<h2 class="text-lg font-medium">Recente Facturen</h2>
		<button class="text-sm text-gray-600">Alles Bekijken</button>
	</div>
	<div class="divide-y divide-gray-100">
		<div class="flex items-center p-4">
			<div class="flex-1 mr-4">
				<h4 class="font-medium">Factuur #2024-1187</h4>
				<p class="text-sm text-gray-500">Familie van der Berg - Vervaldatum: 22 nov 2024</p>
			</div>
			<div class="text-right">
				<div class="font-medium">€12.450</div>
				<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-50 text-yellow-800">In behandeling</span>
			</div>
		</div>
		<div class="flex items-center p-4">
			<div class="flex-1 mr-4">
				<h4 class="font-medium">Factuur #2024-1186</h4>
				<p class="text-sm text-gray-500">Bakkerij Jansen - Vervaldatum: 18 nov 2024</p>
			</div>
			<div class="text-right">
				<div class="font-medium">€8.950</div>
				<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700">Betaald</span>
			</div>
		</div>
		<div class="flex items-center p-4">
			<div class="flex-1 mr-4">
				<h4 class="font-medium">Factuur #2024-1185</h4>
				<p class="text-sm text-gray-500">Gemeente Utrecht - Vervaldatum: 10 nov 2024</p>
			</div>
			<div class="text-right">
				<div class="font-medium">€42.000</div>
				<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-50 text-red-700">Achterstallig</span>
			</div>
		</div>
	</div>
</div>
@endsection

@section('activity')
<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
	<div class="flex items-center justify-between p-4 border-b border-gray-100">
		<h2 class="text-lg font-medium">Betalingsherinneringen</h2>
		<button class="text-sm text-gray-600">Instellingen</button>
	</div>
	<div class="p-3 space-y-2">
		<div class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg">
			<div class="w-8 h-8 bg-yellow-100 rounded flex items-center justify-center text-yellow-700">💰</div>
			<div class="flex-1">
				<p class="text-sm font-medium">Herinnering versturen naar Familie van der Berg</p>
				<p class="text-xs text-gray-500">Vervaldatum: Morgen</p>
			</div>
		</div>
		<div class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg">
			<div class="w-8 h-8 bg-yellow-100 rounded flex items-center justify-center text-yellow-700">📞</div>
			<div class="flex-1">
				<p class="text-sm font-medium">Telefonisch contact opnemen met Gemeente Utrecht</p>
				<p class="text-xs text-gray-500">Vervaldatum: Deze week</p>
			</div>
		</div>
		<div class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg">
			<div class="w-8 h-8 bg-yellow-100 rounded flex items-center justify-center text-yellow-700">📊</div>
			<div class="flex-1">
				<p class="text-sm font-medium">Maandrapport voorbereiden</p>
				<p class="text-xs text-gray-500">Vervaldatum: Einde van de week</p>
			</div>
		</div>
	</div>
</div>
@endsection

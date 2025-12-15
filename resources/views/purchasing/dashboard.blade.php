@php($title = 'Inkoop Dashboard')
@extends('layouts.layout_dashboard')

@section('welcome_classes', 'bg-gradient-to-br from-indigo-600 to-indigo-800')
@section('welcome')
	<h1 class="text-xl font-semibold mb-1">Goedemorgen, Jan 👋</h1>
	<p class="text-sm text-white/90 mb-4">Je hebt 6 producten met lage voorraad en 3 openstaande bestellingen</p>
	<div class="flex flex-wrap gap-3">
		<a href="{{route('products.order')}}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">+ Nieuwe Bestelling</a>
		<a href="{{route('product.stock')}}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded"> Voorraad bekijken</a>
        <a href="{{route('orders.logistics')}}" class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded"> Bestellingen backlog</a>
	</div>
@endsection

@section('stats')
	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Totaal Voorraadwaarde</h3>
			<div class="w-8 h-8 flex items-center justify-center bg-indigo-100 text-indigo-700 rounded">💰</div>
		</div>
		<p class="text-2xl font-semibold mt-3">€284.650</p>
		<div class="flex items-center gap-2 text-sm text-green-600 mt-2">↑ 5% <span class="text-gray-400">vs vorige maand</span></div>
	</div>

	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Producten op Voorraad</h3>
			<div class="w-8 h-8 flex items-center justify-center bg-indigo-100 text-indigo-700 rounded">📦</div>
		</div>
		<p class="text-2xl font-semibold mt-3">1.284</p>
		<div class="flex items-center gap-2 text-sm text-green-600 mt-2">↑ 12 <span class="text-gray-400">vs vorige week</span></div>
	</div>

	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Openstaande Orders</h3>
			<div class="w-8 h-8 flex items-center justify-center bg-indigo-100 text-indigo-700 rounded">🚚</div>
		</div>
		<p class="text-2xl font-semibold mt-3">8</p>
		<div class="flex items-center gap-2 text-sm text-red-600 mt-2">↓ 2 <span class="text-gray-400">vs gisteren</span></div>
	</div>

	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Lage Voorraad</h3>
			<div class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-700 rounded">⚠️</div>
		</div>
		<p class="text-2xl font-semibold mt-3">6</p>
		<div class="flex items-center gap-2 text-sm text-red-600 mt-2">↑ 2 <span class="text-gray-400">vs gisteren</span></div>
	</div>
@endsection

@section('alerts')
<div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
	<div class="flex items-center justify-between p-4 border-b border-gray-100">
		<h2 class="text-lg font-medium">Voorraad Overzicht</h2>
		<button class="text-sm text-indigo-600">+ Product</button>
	</div>
	<div class="flex gap-2 p-3 border-b border-gray-100 bg-gray-50">
		<button class="px-3 py-1 text-sm bg-indigo-100 text-indigo-700 rounded border border-indigo-200">Alle Producten</button>
		<button class="px-3 py-1 text-sm bg-white text-gray-600 rounded border border-gray-200">Lage Voorraad</button>
		<button class="px-3 py-1 text-sm bg-white text-gray-600 rounded border border-gray-200">Zonnepanelen</button>
		<button class="px-3 py-1 text-sm bg-white text-gray-600 rounded border border-gray-200">Warmtepompen</button>
	</div>
	<div class="divide-y divide-gray-100">
		<div class="grid grid-cols-4 items-center p-4">
			<div class="flex items-center gap-3">
				<div class="w-10 h-10 bg-gray-100 rounded flex items-center justify-center">📱</div>
				<div>
					<div class="font-medium text-sm">SolarMax Pro 400W</div>
					<div class="text-xs text-gray-500">Zonnepanelen</div>
				</div>
			</div>
			<div class="text-sm">12 stuks</div>
			<div><span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-50 text-red-700">Lage voorraad</span></div>
			<div class="text-sm">€2.450/stuk</div>
		</div>
		<div class="grid grid-cols-4 items-center p-4">
			<div class="flex items-center gap-3">
				<div class="w-10 h-10 bg-gray-100 rounded flex items-center justify-center">🔥</div>
				<div>
					<div class="font-medium text-sm">HeatPump Elite 12kW</div>
					<div class="text-xs text-gray-500">Warmtepompen</div>
				</div>
			</div>
			<div class="text-sm">28 stuks</div>
			<div><span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-50 text-yellow-800">Medium voorraad</span></div>
			<div class="text-sm">€8.950/stuk</div>
		</div>
	</div>
</div>
@endsection

@section('modules')
<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
	<div class="flex items-center justify-between p-4 border-b border-gray-100">
		<h2 class="text-lg font-medium">Leveranciers</h2>
		<button class="text-sm text-gray-600">Alle Leveranciers</button>
	</div>
	<div class="divide-y divide-gray-100">
		<div class="flex items-center justify-between p-4">
			<div>
				<div class="font-medium">GreenTech Solutions</div>
				<div class="text-sm text-gray-500">Laatste levering: 3 dagen geleden</div>
			</div>
			<div class="text-sm text-green-600">Actief</div>
		</div>
		<div class="flex items-center justify-between p-4">
			<div>
				<div class="font-medium">EcoEnergy B.V.</div>
				<div class="text-sm text-gray-500">Laatste levering: 1 week geleden</div>
			</div>
			<div class="text-sm text-green-600">Actief</div>
		</div>
		<div class="flex items-center justify-between p-4">
			<div>
				<div class="font-medium">SustainableParts Ltd</div>
				<div class="text-sm text-gray-500">Laatste levering: 2 weken geleden</div>
			</div>
			<div class="text-sm text-yellow-600">Wachtend</div>
		</div>
	</div>
</div>
@endsection

@section('activity')
<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
	<div class="flex items-center justify-between p-4 border-b border-gray-100">
		<h2 class="text-lg font-medium">Recente Bestellingen</h2>
		<button class="text-sm text-gray-600">Alle Orders</button>
	</div>
	<div class="divide-y divide-gray-100">
		<div class="p-4 space-y-2">
			<div class="flex justify-between items-center">
				<div class="font-medium text-sm">Order #2024-0892</div>
				<div class="text-xs text-gray-500">15 nov 2024</div>
			</div>
			<div class="space-y-1 text-sm">
				<div class="flex justify-between"><span>20x SolarMax Pro 400W</span><span>€49.000</span></div>
				<div class="flex justify-between"><span>5x Omvormer kit</span><span>€2.500</span></div>
			</div>
			<div class="text-xs"><span class="inline-flex items-center px-2 py-1 rounded bg-blue-50 text-blue-700">In behandeling</span></div>
		</div>
		<div class="p-4 space-y-2">
			<div class="flex justify-between items-center">
				<div class="font-medium text-sm">Order #2024-0891</div>
				<div class="text-xs text-gray-500">12 nov 2024</div>
			</div>
			<div class="space-y-1 text-sm">
				<div class="flex justify-between"><span>3x HeatPump Elite 12kW</span><span>€26.850</span></div>
			</div>
			<div class="text-xs"><span class="inline-flex items-center px-2 py-1 rounded bg-green-50 text-green-700">Geleverd</span></div>
		</div>
	</div>
</div>
@endsection

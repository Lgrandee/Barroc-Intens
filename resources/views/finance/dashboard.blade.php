@extends('layouts.layout_dashboard')

@section('welcome_classes', 'bg-gradient-to-br from-yellow-500 to-orange-600')
@section('welcome')
     <h1 class="text-xl font-semibold mb-1">Welcome, {{ auth()->user()->name ?? '' }}</h1>
	<p class="text-sm text-white/90 mb-4">You have {{ $recentInvoices->where('status', '!=', 'betaald')->count() }} outstanding invoices and {{ $reminders->count() }} reminders for this week</p>
	<div class="flex flex-wrap gap-3">
		<button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">New Invoice</button>
		<button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">Invoice Overview</button>
		<button class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded">Ticket Overview</button>
	</div>
@endsection

@section('stats')
	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Revenue This Month</h3>
		</div>
		<p class="text-2xl font-semibold mt-3">€{{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
	</div>

	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Outstanding Invoices</h3>
		</div>
		<p class="text-2xl font-semibold mt-3">€{{ number_format($outstandingAmount, 0, ',', '.') }}</p>
	</div>


	<div class="flex-1 min-w-0 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
		<div class="flex justify-between items-start">
			<h3 class="text-sm text-gray-500">Overdue Invoices</h3>
		</div>
		<p class="text-2xl font-semibold mt-3">{{ $overduePercentage }}%</p>
	</div>
@endsection

@section('alerts')
<div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
	<div class="flex items-center justify-between p-4 border-b border-gray-100">
		<h2 class="text-lg font-medium">Cashflow Overview</h2>
		<div class="flex gap-2">
			<button class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded border border-yellow-200">Month</button>
			<button class="px-3 py-1 text-sm bg-white text-gray-600 rounded border border-gray-200">Quarter</button>
			<button class="px-3 py-1 text-sm bg-white text-gray-600 rounded border border-gray-200">Year</button>
		</div>
	</div>
	<div class="p-4">
		<div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg p-8 text-center">
			<p class="text-gray-500">Here will be a line chart with income vs expenses</p>
		</div>
	</div>
</div>
@endsection
@section('modules')
<div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
	<div class="flex items-center justify-between p-4 border-b border-gray-100">
		<h2 class="text-lg font-medium">Recent Invoices</h2>
		<button class="text-sm text-gray-600">View All</button>
	</div>
	<div class="divide-y divide-gray-100">
		@forelse($recentInvoices as $invoice)
		<div class="flex items-center p-4">
			<div class="flex-1 mr-4">
				<h4 class="font-medium">Invoice #{{ $invoice->id }}</h4>
				<p class="text-sm text-gray-500">{{ $invoice->customer->name_company ?? 'Unknown' }} - Due date: {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
			</div>
			<div class="text-right">
				<div class="font-medium">€{{ number_format($invoice->total_amount, 0, ',', '.') }}</div>
				@if(in_array($invoice->status, ['betaald', 'paid']))
					<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700">{{ ucfirst($invoice->status) }}</span>
				@elseif($invoice->status === 'verlopen')
					<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-50 text-red-700">{{ ucfirst($invoice->status) }}</span>
				@else
					<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-50 text-yellow-800">{{ ucfirst($invoice->status) }}</span>
				@endif
			</div>
		</div>
		@empty
		<div class="p-4 text-gray-500 text-center">No recent invoices.</div>
		@endforelse
	</div>
</div>
@endsection
@section('reminders_section')
@forelse($reminders as $reminder)
<div class="flex items-start gap-3 p-4 border border-gray-200 rounded-lg shadow-sm mb-3">
	<div class="flex-1">
		<p class="text-sm font-medium mb-1">Send reminder to {{ $reminder->customer->name_company ?? 'Unknown' }}</p>
		<p class="text-xs text-gray-500">Due date: {{ \Carbon\Carbon::parse($reminder->due_date)->diffForHumans() }}</p>
	</div>
</div>
@empty
<div class="p-4 text-gray-500 text-center">No payment reminders.</div>
@endforelse
@endsection



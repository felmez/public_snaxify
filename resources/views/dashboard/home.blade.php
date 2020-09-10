@extends('layouts.dashboard')

@section('content')

@if(auth()->user()->role_id == 'Admin')
<div class="row">
	<div class="col-12 grid-margin">
		<div class="card card-statistics">
			<div class="row">

				<div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
							<i class="mdi mdi-account-multiple-outline text-primary mr-0 mr-sm-4 icon-lg"></i>
							<div class="wrapper text-center text-sm-left">
								<p class="card-text mb-0">{{ __('messages.dashboard.users') }}</p>
								<div class="fluid-container">
									<h3 class="card-title mb-0">{{ $new_customers }}</h3>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
							<i class="mdi mdi-trophy-outline text-primary mr-0 mr-sm-4 icon-lg"></i>
							<div class="wrapper text-center text-sm-left">
								<p class="card-text mb-0">{{ __('messages.dashboard.bills') }}</p>
								<div class="fluid-container">
									<h3 class="card-title mb-0">{{ $orders_count }}</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
							<i class="mdi mdi-target text-primary mr-0 mr-sm-4 icon-lg"></i>
							<div class="wrapper text-center text-sm-left">
								<p class="card-text mb-0">{{ __('messages.dashboard.sales') }}</p>
								<div class="fluid-container">
									<h3 class="card-title mb-0">{{ \App\Settings::currency($orders_sum) }}</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- koudify TODO:--}}
			</div>
		</div>
	</div>
</div>

@if ($range != 'today' && $range != 'yesterday')
<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('messages.dashboard.sales_int')</h4>
				<canvas id="barChart" style="height:330px; width: 100%;"
					dir="{{ localization()->getCurrentLocaleDirection() }}"></canvas>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script>
	$(document).ready(function () {
		var ctx = document.getElementById("barChart").getContext('2d');
		var barChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: {
					!!json_encode($days_stats['days']) !!
				},
				datasets: [{
					label: " ",
					data: {
						!!json_encode($days_stats['sums']) !!
					},
					borderWidth: 1
				}],
			},
			options: {
				responsive: true,
				maintainAspectRatio: true,
				animation: {
					easing: 'easeInOutQuad',
					duration: 520
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				},
				legend: {
					display: false
				},
				elements: {
					point: {
						radius: 0
					}
				}
			},
		});
	});
</script>
@endpush
@endif

<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title font-weight-bold">@lang('messages.orders.menu_title')</h4>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th class="font-weight-bold">{{__('messages.orders.id') }}</th>
								<th class="font-weight-bold">{{__('messages.orders.f_created')}}</th>
								<th class="font-weight-bold">{{__('messages.orders.f_name')}}</th>
								<th class="font-weight-bold">{{__('messages.orders.f_address')}}</th>
								<th class="font-weight-bold">{{__('messages.orders.f_area')}}</th>
								<th class="font-weight-bold">{{__('messages.orders.f_phone')}}</th>
								{{-- FIXME section not showing ass order index blade --}}
								{{-- <th class="font-weight-bold">{{__('messages.orders.f_promo_code')}}</th> --}}
								<th class="font-weight-bold">{{__('messages.orders.f_sum')}}</th>
								<th class="font-weight-bold">{{__('messages.orders.f_payment_method')}}</th>
								<th class="font-weight-bold">{{__('messages.orders.f_status')}}</th>
								<th class="font-weight-bold">{{__('messages.orders.f_is_paid')}}</th>
								<th class="font-weight-bold"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($orders as $item)
							<tr>
								<td>{{ $item->id }}</td>
								<td>
									<span data-toggle="tooltip" data-placement="top" title="{{ Date::parse($item->created_at)->ago() }}">
										{{ $item->created_at->format(\App\Settings::getSettings()->time_format_backend) }}
									</span>
								</td>
								<td>{{ $item->name }}</td>
								<td>
									{{$item->address}}
									{{-- <td width="30"> --}}
									{{-- <address data-toggle="popover" title="Popover title" data-content="{{ $item->address }}">
									{{ str_limit($item->address, 25) }}
									</address> --}}
								</td>
								<td>{{ optional($item->deliveryArea)->name }}</td>
								<td>{{ $item->phone }}</td>
								<td>{{ \App\Settings::currency($item->total_with_tax + $item->delivery_price) }}</td>
								<td>{{ __('messages.orders.payment_methods')[$item->payment_method] }}</td>
								<td>{{ optional($item->orderStatus)->name }}</td>
								<td>
									@if ($item->is_paid)
									<span class="badge badge-success">{{ __('messages.common.yes') }}</span>
									@else
									<span class="badge badge-default">{{ __('messages.common.no') }}</span>
									@endif
								</td>
								<td>
									@can('update', $item)
									<a href="{{ route('dashboard.orders.show', ['id' => $item->id]) }}"
										class="btn btn-success btn-xs">{{__('messages.actions.show')}}</a>
									<a href="{{ route('dashboard.orders.edit', ['id' => $item->id]) }}"
										class="btn btn-primary btn-xs">{{__('messages.actions.edit')}}</a>
									@endcan
									@can('delete', $item)
									<a href="{{ route('dashboard.ordered_products.index', ['filter' => ['order_id' => $item->id]]) }}"
										class="btn btn-info btn-xs">{{__('messages.actions.edit_products')}}</a>
									@endcan
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
@endsection
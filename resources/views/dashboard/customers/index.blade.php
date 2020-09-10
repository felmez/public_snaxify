@extends('layouts.dashboard')
@section('subtitle', __('messages.customers.menu_title'))
{{-- filter and search section removed --}}

@section('content')
	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<div class="clearfix">
						<h3 class="card-title font-weight-bold float-{{ $align }}">@lang('messages.customers.menu_title')</h3>
					</div>
					<hr>

					<div class="table-responsive mt-2">
						<table class="table table-striped">
							<thead>
							<tr>
								<th>{{__('messages.customers.f_name')}}</th>
								<th>{{__('messages.customers.f_email')}}</th>
								<th>{{__('messages.customers.f_phone')}}</th>
								@if (\App\Settings::getSettings()->multiple_cities)
									<th>{{__('messages.customers.f_city')}}</th>
								@endif
								<th>{{__('messages.customers.f_orders_count')}}</th>
								<th>{{__('messages.customers.f_orders_sum')}}</th>
								<th></th>
							</tr>
							</thead>
							<tbody>
							@foreach($items as $item)
								<tr>
									<td>{{ $item->name }}</td>
									<td>{{ $item->email }}</td>
									<td>{{ $item->phone }}</td>
									@if (\App\Settings::getSettings()->multiple_cities)
										<td>
											@if ($item->city != null)
												{{ $item->city->name }}
											@endif
										</td>
									@endif
									<td>{{ $item->orders->count() }}</td>
									<td>{{ \App\Settings::currency($item->orders()->sum('total_with_tax')) }}</td>
									@can ('create', App\Order::class)
										<td>
											<a href="{{ route('dashboard.orders.index', ['filter' => ['customer_id' => $item->id]]) }}"
											   class="btn btn-primary">{{ __('messages.customers.orders_list') }}</a>
										</td>
									@endcan
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="text-center mx-auto d-table">
		{{ $items->appends(['filter' => $filter])->links() }}
	</div>
@endsection
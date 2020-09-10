@extends('layouts.dashboard')
@section('subtitle', __('messages.orders.menu_title'))
{{-- filter and search section removed --}}

@section('content')
<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="clearfix">
					<h3 class="card-title font-weight-bold float-{{ $align }}">@lang('messages.orders.menu_title')</h3>
					{{-- create new order section removed --}}
					{{-- <a class="btn btn-secondary float-{{ $align }} btn-xs ml-3" href="{{ route('dashboard.orders.create') }}">
						@lang('messages.orders.new')
					</a> --}}
				</div>
				<hr>

				<div class="table-responsive mt-2">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>{{__('messages.orders.id') }}</th>
								<th>{{__('messages.orders.f_created')}}</th>
								<th>{{__('messages.orders.f_name')}}</th>
								<th>{{__('messages.orders.f_address')}}</th>
								{{-- <th>{{__('messages.orders.f_area')}}</th> --}}
								<th>{{__('messages.orders.f_phone')}}</th>
								{{-- <th>{{__('messages.orders.f_promo_code')}}</th> --}}
								<th>{{__('messages.orders.f_sum')}}</th>
								<th>{{__('messages.orders.f_payment_method')}}</th>
								{{-- <th>{{__('messages.orders.f_status')}}</th> --}}
								{{-- <th>{{__('messages.orders.f_is_paid')}}</th> --}}
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($items as $item)
							<tr>
								<td>{{ $item->id }}</td>
								<td>{{ Date::parse($item->created_at)->format(\App\Settings::getSettings()->time_format_backend) }}</td>
								<td>{{ $item->name }}</td>
								<td>{{ $item->address }}</td>
								<td>{{ $item->phone }}</td>
								<td>{{ \App\Settings::currency($item->total_with_tax + $item->delivery_price) }}</td>
								<td>{{ __('messages.orders.payment_methods')[$item->payment_method] }}</td>
								{{-- show details button added on orders index TODO: --}}
								<td>
									@can('update', $item)
									<a href="{{ route('dashboard.orders.show', ['id' => $item->id]) }}"
										class="btn btn-success btn-xs">{{__('messages.actions.show')}}</a>
									@endcan
								</td>
								{{-- TODO: non used fields removed for later --}}
								{{-- <td>
									@if ($item->deliveryArea != null)
									{{ $item->deliveryArea->name }}
									@endif
								</td> --}}
								{{-- <td>{{ $item->promo_code }}</td>
								<td>
									@if ($item->orderStatus != null)
									{{ $item->orderStatus->name }}
									@endif
								</td>
								<td>
									@if ($item->is_paid)
									<span class="label label-success">{{ __('messages.common.yes') }}</span>
									@else
									<span class="label label-default">{{ __('messages.common.no') }}</span>
									@endif
								</td>
								<td>
									@can('update', $item)
									<a href="{{ route('dashboard.orders.show', ['id' => $item->id]) }}"
										class="btn btn-success btn-xs">{{__('messages.actions.show')}}</a>
									<a href="{{ route('dashboard.orders.edit', ['id' => $item->id]) }}"
										class="btn btn-primary btn-xs">@lang('messages.actions.edit')</a>
									@endcan
									@can('delete', $item)
									<a href="{{ route('dashboard.ordered_products.index', ['filter' => ['order_id' => $item->id]]) }}"
										class="btn btn-info btn-xs">{{__('messages.actions.edit_products')}}</a>
									@endcan
								</td> --}}
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

@push('scripts')
@if (\App\Settings::getSettings()->multiple_cities || \App\Settings::getSettings()->multiple_restaurants)
<script src="/custom_js/products.js"></script>
@endif
@endpush
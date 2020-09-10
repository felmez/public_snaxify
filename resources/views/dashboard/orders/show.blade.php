@extends('layouts.dashboard')

@section('content')
<h2>{{ __('messages.orders.show_title', ['id' => $item->id]) }}</h2>
{{-- TODO: select delivery boy removed from orders details  --}}
{{-- <p>
	<b>{{ __('messages.orders.delivery_boy') }}</b>
	<form action="{{ route('dashboard.orders.update_boy', ['id' => $item->id]) }}" method="post" class="inline-form">
		{{ csrf_field() }}
		@if ($item->id != null)
		{{ method_field('PUT') }}
		@endif
		<select name="delivery_boy_id" class="js-delivery-boy">
			<option value=""></option>
			@foreach (\App\DeliveryBoy::all() as $deliveryBoy)
			<option @if ($deliveryBoy->id == $item->delivery_boy_id) selected
				@endif value="{{ $deliveryBoy->id }}">{{ $deliveryBoy->name }}</option>
			@endforeach
		</select>
	</form>
</p> --}}
<p>
	<b>{{__('messages.orders.d_client_name')}}</b> {{ $item->name }}
</p>
<p>
	<b>{{__('messages.orders.d_address')}}</b> {{ $item->address }}
</p>
@if (\App\Settings::getSettings()->multiple_cities && $item->city != null)
<p>
	<b>{{ __('messages.orders.f_city') }}</b> {{ $item->city->name }}
</p>
@endif
@if (\App\Settings::getSettings()->multiple_restaurants && $item->restaurant != null)
<p>
	<b>{{ __('messages.orders.f_restaurant') }}</b> {{ $item->restaurant->name }}
</p>
@endif
{{-- TODO: delivery area removed from order details --}}
{{-- <p>
	<b>{{__('messages.orders.d_area')}}</b>
	@if ($item->deliveryArea != null)
	{{ $item->deliveryArea->name }} ({{\App\Settings::currency($item->delivery_price)}})
	@endif
</p> --}}
<p>
	<b>{{__('messages.orders.d_phone')}}</b> {{ $item->phone }}
</p>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>{{__('messages.ordered_products.f_name')}}</th>
			<th>{{__('messages.ordered_products.f_price')}}</th>
			<th>{{__('messages.ordered_products.f_count')}}</th>
			<th>{{__('messages.ordered_products.f_total')}}</th>
		</tr>
	</thead>
	<tbody>
		@foreach($item->orderedProducts as $op)
		<tr>
			<td>{{ $op->product->name }}</td>
			<td>{{ \App\Settings::currency($op->price) }}</td>
			<td>{{ $op->count }}</td>
			<td>{{ \App\Settings::currency($op->price * $op->count) }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@if ($item->deliveryArea != null)
<p class="text-right">
	<b>{{ __('messages.orders.delivery_title') }}</b>
	{{\App\Settings::currency($item->delivery_price)}}
</p>
@endif
@if ($item->promo_code != '')
<p class="text-right">
	<b>{{ __('messages.orders.f_promo_code') }}</b>
	{{ $item->promo_code }}
</p>
<p class="text-right">
	<b>{{ __('messages.orders.d_promo_discount') }}</b>
	{{ \App\Settings::currency($item->promo_discount) }}
</p>
@endif
<p class="text-right">
	<b>{{__('messages.orders.total_title')}}</b> {{ \App\Settings::currency($item->total) }}
</p>
<p class="text-right">
	<b>{{__('messages.orders.tax_title')}}</b> {{ \App\Settings::currency($item->tax) }}
</p>
<p class="text-right">
	<b>{{__('messages.orders.total_with_tax_title')}}</b> {{ \App\Settings::currency($item->getGrandTotal()) }}
</p>
@endsection
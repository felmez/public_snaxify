@extends('layouts.dashboard')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<h3 class="card-title mb-4">@lang('messages.orders.new')</h3>
				{!! Form::model($item, [
				'route' => $item->id == null ? 'dashboard.orders.store' : ['dashboard.orders.update', 'id' => $item->id],
				'method' => $item->id == null ? 'post' : 'patch',
				'files' => true,
				'class' => 'validate',
				'novalidate',
				]) !!}

				@component('components.form-group', ['name' => 'name', 'type' => 'text'])
				@slot('label', 'orders.f_name')
				@slot('attributes', ['required'])
				@endcomponent

				@component('components.form-group', ['name' => 'address', 'type' => 'text'])
				@slot('label', 'orders.f_address')
				@slot('attributes', ['required'])
				@endcomponent

				@if (\App\Settings::getSettings()->multiple_cities)
				@component('components.form-group', ['name' => 'city_id', 'type' => 'select'])
				@slot('label', 'orders.f_city')
				@slot('options', \App\City::policyScope()->get()->pluck('name', 'id'))
				@slot('attributes', ['required'])
				@endcomponent
				@endif

				@if (\App\Settings::getSettings()->multiple_restaurants)
				@component('components.form-group', ['name' => 'restaurant_id', 'type' => 'select'])
				@slot('label', 'orders.f_restaurant')
				@slot('options', \App\Restaurant::policyScope()->get()->pluck('name', 'id'))
				@slot('attributes', ['required'])
				@endcomponent
				@endif

				@component('components.form-group', ['name' => 'phone', 'type' => 'text'])
				@slot('label', 'orders.f_phone')
				@slot('attributes', ['required'])
				@endcomponent

				@component('components.form-group', ['name' => 'delivery_area_id', 'type' => 'select'])
				@slot('label', 'orders.f_area')
				@slot('options', \App\DeliveryArea::get()->push([
				'id' => '',
				'name' => '',
				])->pluck('name', 'id'))
				@endcomponent

				@component('components.form-group', ['name' => 'promo_code', 'type' => 'text'])
				@slot('label', 'orders.f_promo_code')
				@endcomponent

				@component('components.form-group', ['name' => 'payment_method', 'type' => 'select'])
				@slot('label', 'orders.f_payment_method')
				@slot('options', [
				'' => '',
				'cash' => trans('messages.orders.payment_methods.cash'),
				// 'paypal' => trans('messages.orders.payment_methods.paypal'),
				// 'stripe' => trans('messages.orders.payment_methods.stripe'),
				])
				@endcomponent

				@component('components.form-group', ['name' => 'order_status_id', 'type' => 'select'])
				@slot('label', 'orders.f_status')
				@slot('options', \App\OrderStatus::get()->pluck('name', 'id'))
				@endcomponent

				@component('components.form-group', ['name' => 'is_paid', 'type' => 'checkbox'])
				@slot('label', 'orders.f_is_paid')
				@endcomponent

				@if ($item->id != null)
				<a href="{{ route('dashboard.ordered_products.index', ['filter' => ['order_id' => $item->id]]) }}"
					class="btn btn-info btn-block">{{__('messages.actions.edit_products')}}</a>
				@endif

				<button type="submit" class="btn btn-primary">@lang('messages.actions.save')</button>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
@if (\App\Settings::getSettings()->multiple_cities || \App\Settings::getSettings()->multiple_restaurants)
<script src="/custom_js/products.js"></script>
@endif
@endpush
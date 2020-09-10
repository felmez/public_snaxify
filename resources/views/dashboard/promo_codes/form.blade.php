@extends('layouts.dashboard')
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title mb-4">@lang('messages.promo_codes.new')</h3>
					{!! Form::model($item, [
						'route' => $item->id == null ? 'dashboard.promo_codes.store' : ['dashboard.promo_codes.update', 'id' => $item->id],
						'method' => $item->id == null ? 'post' : 'patch',
						'files' => true,
						'class' => 'validate',
						'novalidate',
					]) !!}

					<div class="row">
						<div class="col-sm-6">
							@component('components.form-group', ['name' => 'name', 'type' => 'text'])
								@slot('label', 'promo_codes.f_name')
								@slot('attributes', ['required'])
							@endcomponent
						</div>

						<div class="col-sm-6">
							@component('components.form-group', ['name' => 'code', 'type' => 'text'])
								@slot('label', 'promo_codes.f_code')
								@slot('attributes', ['required'])
							@endcomponent
						</div>
					</div>

					@if (\App\Settings::getSettings()->multiple_cities)
						@component('components.form-group', ['name' => 'city_id', 'type' => 'select'])
							@slot('label', 'products.f_city')
							@slot('options', \App\City::policyScope()->get()->pluck('name', 'id'))
							@slot('attributes', ['required'])
						@endcomponent
					@endif

					@if (\App\Settings::getSettings()->multiple_restaurants)
						@component('components.form-group', ['name' => 'restaurant_id', 'type' => 'select'])
							@slot('label', 'products.f_restaurant')
							@slot('options', \App\Restaurant::policyScope()->get()->pluck('name', 'id'))
							@slot('attributes', ['required'])
						@endcomponent
					@endif

					<div class="row">
						<div class="col-sm-6">
							@component('components.form-group', ['name' => 'discount', 'type' => 'text'])
								@slot('label', 'promo_codes.f_discount')
								@slot('attributes', ['required'])
							@endcomponent
						</div>
						<div class="col-sm-6">
							@component('components.form-group', ['name' => 'discount_in_percent', 'type' => 'checkbox'])
								@slot('label', 'promo_codes.f_discount_in_percent')
								@slot('value', 1)
							@endcomponent
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							@component('components.form-group', ['name' => 'limit_use_count', 'type' => 'text'])
								@slot('label', 'promo_codes.f_limit')
							@endcomponent
						</div>
						<div class="col-sm-6">
							@component('components.form-group', ['name' => 'min_price', 'type' => 'text'])
								@slot('label', 'promo_codes.f_min_price')
							@endcomponent
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							@component('components.form-group', ['name' => 'active_from', 'type' => 'datepicker'])
								@slot('label', 'promo_codes.f_active_from')
							@endcomponent
						</div>
						<div class="col-sm-6">
							@component('components.form-group', ['name' => 'active_to', 'type' => 'datepicker'])
								@slot('label', 'promo_codes.f_active_to')
							@endcomponent
						</div>
					</div>

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
@extends('layouts.dashboard')
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title mb-4">@lang('messages.delivery_areas.new')</h3>
					{!! Form::model($item, [
						'route' => $item->id == null ? 'dashboard.delivery_areas.store' : ['dashboard.delivery_areas.update', 'id' => $item->id],
						'method' => $item->id == null ? 'post' : 'patch',
						'files' => true,
						'class' => 'validate',
						'novalidate',
					]) !!}

					@component('components.form-group', ['name' => 'name', 'type' => 'text'])
						@slot('label', 'delivery_areas.f_name')
						@slot('attributes', ['required'])
					@endcomponent

					@component('components.form-group', ['name' => 'price', 'type' => 'number'])
						@slot('label', 'delivery_areas.f_price')
						@slot('attributes', ['required'])
						@slot('inputGroup', \App\Settings::currencySymbol())
					@endcomponent

					@if (\App\Settings::getSettings()->multiple_cities)
						@component('components.form-group', ['name' => 'city_id', 'type' => 'select'])
							@slot('label', 'delivery_areas.f_city')
							@slot('options', \App\City::policyScope()->get()->pluck('name', 'id'))
							@slot('attributes', ['required'])
						@endcomponent
					@endif

					{{-- Restaurant Field for Area Added --}}

					@if (\App\Settings::getSettings()->multiple_restaurants)
						@component('components.form-group', ['name' => 'restaurant_id', 'type' => 'select'])
							@slot('label', 'categories.f_restaurant')
							@slot('options', \App\Restaurant::policyScope()->get()->pluck('name', 'id'))
							@slot('attributes', ['required'])
						@endcomponent
					@endif

					@component('components.form-group', ['name' => 'coords', 'type' => 'hidden'])
						@slot('label', 'delivery_areas.f_coords')
						@slot('attributes', ['class' => 'js-area-coords'])
						<div id="delivery_area_map"></div>
					@endcomponent

					<button type="submit" class="btn btn-primary">@lang('messages.actions.save')</button>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endsection
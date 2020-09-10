@extends('layouts.dashboard')

@section('content')
	<form method="post" action="{{ route('dashboard.products.bulk') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="form-group">
			<label>{{ __('messages.products.bulk_file') }}</label>
			<input type="file" name="fl">
		</div>
		<div class="row">
			@if (\App\Settings::getSettings()->multiple_cities)
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">{{ __('messages.products.f_city') }}</label>
						<select name="city_id" id="cities" class="form-control">
							<option value=""></option>
							@foreach(\App\City::policyScope()->get() as $item)
								<option value="{{ $item->id }}">
									{{ $item->name }}
								</option>
							@endforeach
						</select>
					</div>
				</div>
			@endif
			@if (\App\Settings::getSettings()->multiple_restaurants)
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">{{ __('messages.products.f_restaurant') }}</label>
						<select name="restaurant_id" id="restaurants" class="form-control">
							<option value=""></option>
							@foreach(\App\Restaurant::policyScope()->get() as $item)
								<option data-city="{{ $item->city_id }}" value="{{ $item->id }}">
									{{ $item->name }}
								</option>
							@endforeach
						</select>
					</div>
				</div>
			@endif
		</div>
		<button class="btn btn-primary" type="submit">Import</button>
	</form>
	@if (\App\Settings::getSettings()->multiple_cities || \App\Settings::getSettings()->multiple_restaurants)
		<script src="/custom_js/products.js"></script>
	@endif
@endsection
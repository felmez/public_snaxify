@extends('layouts.dashboard')
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title mb-4">@lang('messages.products.new')</h3>
					{!! Form::model($item, [
						'route' => $item->id == null ? 'dashboard.products.store' : ['dashboard.products.update', 'id' => $item->id],
						'method' => $item->id == null ? 'post' : 'patch',
						'files' => true,
						'class' => 'validate',
						'novalidate',
					]) !!}

					@component('components.form-group', ['name' => 'name', 'type' => 'text'])
						@slot('label', 'products.f_name')
						@slot('attributes', ['required'])
					@endcomponent

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

					@component('components.form-group', ['name' => 'category_id', 'type' => 'select'])
						@slot('label', 'products.f_category')
						@slot('options', $categories->pluck('name', 'id'))
						@slot('attributes', ['required'])
					@endcomponent
						{{-- tax group select section removed --}}
					{{-- @component('components.form-group', ['name' => 'tax_group_id', 'type' => 'select'])
						@slot('label', 'products.f_tax_group')
						@slot('options', \App\TaxGroup::get()->push([
							'id' => '',
							'name' => '',
						])->pluck('name', 'id'))
					@endcomponent --}}

					<div class="row">
						<div class="col-sm-6">
							@component('components.form-group', ['name' => 'price', 'type' => 'number'])
								@slot('label', 'products.f_price')
								@slot('attributes', ['required'])
								@slot('inputGroup', \App\Settings::currencySymbol())
							@endcomponent
						</div>

						<div class="col-sm-6">
							@component('components.form-group', ['name' => 'price_old', 'type' => 'number'])
								@slot('label', 'products.f_price_old')
								@slot('inputGroup', \App\Settings::currencySymbol())
							@endcomponent
						</div>
					</div>

					@component('components.form-group', ['name' => 'description', 'type' => 'editor'])
						@slot('label', 'products.f_description')
						@slot('value', $item->description)
					@endcomponent

					{{-- TODO: image field removed on add product to fix later and add fix images to products --}}
					{{-- @component('components.form-group', ['name' => 'image[]', 'type' => 'file'])
						@slot('label', 'products.f_image')
						@slot('attributes', [
							'fileuploader',
							'data-fileuploader-files' => $item->getMedia('thumbnails')->map(function ($media) {
					            return [
					                'name' => $media->name,
					                'type' => $media->mime_type,
					                'size' => $media->size,
					                'file' => $media->getUrl(),
					            ];
					        })->toJson(),
							'data-fileuploader-extensions' => 'jpg, jpeg, png, gif, bmp',
							// 'data-fileuploader-limit' => 1,
						])
					@endcomponent --}}

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
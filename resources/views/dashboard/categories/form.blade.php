@extends('layouts.dashboard')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title mb-4">@lang('messages.categories.new')</h3>
					{!! Form::model($item, [
						'route' => $item->id == null ? 'dashboard.categories.store' : ['dashboard.categories.update', 'id' => $item->id],
						'method' => $item->id == null ? 'post' : 'patch',
						'files' => true,
						'class' => 'validate',
						'novalidate',
					]) !!}

					@component('components.form-group', ['name' => 'name', 'type' => 'text'])
						@slot('label', 'categories.f_name')
						@slot('attributes', ['required'])
					@endcomponent
					{{-- removed parent category option --}}
					{{-- @component('components.form-group', ['name' => 'parent_id', 'type' => 'select'])
						@slot('label', 'categories.f_parent')
						@slot('options', $categories)
					@endcomponent --}}

					@if (\App\Settings::getSettings()->multiple_cities)
						@component('components.form-group', ['name' => 'city_id', 'type' => 'select'])
							@slot('label', 'categories.f_city')
							@slot('options', \App\City::policyScope()->get()->pluck('name', 'id'))
							@slot('attributes', ['required'])
						@endcomponent
					@endif
						 {{-- fix this please TODO: --}}
					@if (\App\Settings::getSettings()->multiple_restaurants)
						@component('components.form-group', ['name' => 'restaurant_id', 'type' => 'select'])
							@slot('label', 'categories.f_restaurant')
							@slot('options', \App\Restaurant::policyScope()->get()->pluck('name', 'id'))
							@slot('attributes', ['required'])
						@endcomponent
					@endif

					@component('components.form-group', ['name' => 'image', 'type' => 'file'])
						@slot('label', 'categories.f_image')
						@slot('attributes', [
							'class' => 'dropify',
							'data-default-file' => $item->image
						])
					@endcomponent

					<button type="submit" class="btn btn-primary">@lang('messages.actions.save')</button>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@stop

@push('scripts')
	@if (\App\Settings::getSettings()->multiple_cities && \App\Settings::getSettings()->multiple_restaurants)
		<script>
            $(document).ready(function () {
                $('#cities').change(function () {
                    var c = $('#cities').val();
                    $('#restaurants option').hide();
                    $('#restaurants option[data-city=' + c + ']').show();
                });
                $('#cities').trigger('change');
            });
		</script>
	@endif
	@if (\App\Settings::getSettings()->multiple_cities || \App\Settings::getSettings()->multiple_restaurants)
		<script>
            $(document).ready(function () {
                $('#parent').change(function () {
                    var c = $('#parent option:selected');
                    $('#cities').val(c.data('city'));
                    $('#restaurants').val(c.data('restaurant'));
                });
            });
		</script>
	@endif
@endpush
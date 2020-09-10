@extends('layouts.dashboard')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<h3 class="card-title mb-4">@lang('messages.restaurants.new')</h3>
				{!! Form::model($item, [
				'route' => $item->id == null ? 'dashboard.restaurants.store' : ['dashboard.restaurants.update', 'id' =>
				$item->id],
				'method' => $item->id == null ? 'post' : 'patch',
				'files' => true,
				'class' => 'validate',
				'novalidate',
				]) !!}
				@component('components.form-group', ['name' => 'name', 'type' => 'text'])
				@slot('label', 'restaurants.f_name')
				@slot('attributes', ['required'])
				@endcomponent
				{{-- username field --}}
				@component('components.form-group', ['name' => 'username', 'type' => 'text'])
				@slot('label', 'restaurants.f_username')
				@slot('attributes', ['required'])
				@endcomponent
				{{-- owner_username field --}}
				@component('components.form-group', ['name' => 'owner_username', 'type' => 'text'])
				@slot('label', 'restaurants.f_owner_username')
				@slot('attributes', ['required'])
				@endcomponent

				@component('components.form-group', ['name' => 'sort', 'type' => 'text'])
				@slot('label', 'restaurants.f_sort')
				@slot('attributes', ['required'])
				@endcomponent

				@if (\App\Settings::getSettings()->multiple_cities)
				@component('components.form-group', ['name' => 'city_id', 'type' => 'select'])
				@slot('label', 'restaurants.f_city')
				@slot('options', \App\City::policyScope()->get()->pluck('name', 'id'))
				@slot('attributes', ['required'])
				@endcomponent
				@endif

				@component('components.form-group', ['name' => 'image', 'type' => 'file'])
				@slot('label', 'restaurants.f_image')
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
@endsection
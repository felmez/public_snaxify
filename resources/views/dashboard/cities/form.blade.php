@extends('layouts.dashboard')
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title mb-4">@lang('messages.cities.new')</h3>
					{!! Form::model($item, [
						'route' => $item->id == null ? 'dashboard.cities.store' : ['dashboard.cities.update', 'id' => $item->id],
						'method' => $item->id == null ? 'post' : 'patch',
						'files' => true,
						'class' => 'validate',
						'novalidate',
					]) !!}

					@component('components.form-group', ['name' => 'name', 'type' => 'text'])
						@slot('label', 'cities.f_name')
						@slot('attributes', ['required'])
					@endcomponent

					@component('components.form-group', ['name' => 'sort', 'type' => 'number'])
						@slot('label', 'cities.f_sort')
					@endcomponent

					<button type="submit" class="btn btn-primary">@lang('messages.actions.save')</button>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endsection
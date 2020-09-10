@extends('layouts.dashboard')
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title mb-4">@lang('messages.order_statuses.new')</h3>
					{!! Form::model($item, [
						'route' => $item->id == null ? 'dashboard.order_statuses.store' : ['dashboard.order_statuses.update', 'id' => $item->id],
						'method' => $item->id == null ? 'post' : 'patch',
						'files' => true,
						'class' => 'validate',
						'novalidate',
					]) !!}

					@component('components.form-group', ['name' => 'name', 'type' => 'text'])
						@slot('label', 'order_statuses.f_name')
						@slot('attributes', ['required'])
					@endcomponent

					@component('components.form-group', ['name' => 'sort', 'type' => 'number'])
						@slot('label', 'order_statuses.f_sort')
						@slot('attributes', ['required'])
					@endcomponent

					@component('components.form-group', ['name' => 'is_default', 'type' => 'checkbox'])
						@slot('label', 'order_statuses.f_is_default')
						@slot('value', '1')
					@endcomponent

					<button type="submit" class="btn btn-primary">@lang('messages.actions.save')</button>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endsection
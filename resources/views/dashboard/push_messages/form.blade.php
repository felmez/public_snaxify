@extends('layouts.dashboard')
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title mb-4">@lang('messages.push_messages.new')</h3>
					{!! Form::model($item, [
						'route' => $item->id == null ? 'dashboard.push_messages.store' : ['dashboard.push_messages.update', 'id' => $item->id],
						'method' => $item->id == null ? 'post' : 'patch',
						'files' => true,
						'class' => 'validate',
						'novalidate',
					]) !!}

					@component('components.form-group', ['name' => 'message', 'type' => 'textarea'])
						@slot('label', 'push_messages.f_message')
					@endcomponent

					<button type="submit" class="btn btn-primary">@lang('messages.actions.save')</button>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endsection

@extends('layouts.dashboard')
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title mb-4">@lang('messages.news.new')</h3>
					{!! Form::model($item, [
						'route' => $item->id == null ? 'dashboard.news_items.store' : ['dashboard.news_items.update', 'id' => $item->id],
						'method' => $item->id == null ? 'post' : 'patch',
						'files' => true,
						'class' => 'validate',
						'novalidate',
					]) !!}

					@component('components.form-group', ['name' => 'title', 'type' => 'text'])
						@slot('label', 'news.f_title')
						@slot('attributes', ['required'])
					@endcomponent

					@if (\App\Settings::getSettings()->multiple_cities)
						@component('components.form-group', ['name' => 'city_id', 'type' => 'select'])
							@slot('label', 'restaurants.f_city')
							@slot('options', \App\City::policyScope()->get()->pluck('name', 'id'))
							@slot('attributes', ['required'])
						@endcomponent
					@endif

					<div class="row">
						<div class="col-md-6">
							@component('components.form-group', ['name' => 'image', 'type' => 'file'])
								@slot('label', 'news.f_image')
								@slot('attributes', [
									'class' => 'dropify',
									'required',
									'data-default-file' => $item->image
								])
							@endcomponent
						</div>
						<div class="col-md-6">
							@component('components.form-group', ['name' => 'announce', 'type' => 'textarea'])
								@slot('label', 'news.f_announce')
								@slot('attributes', ['required', 'rows' => 13])
							@endcomponent
						</div>
					</div>

					@component('components.form-group', ['name' => 'full_text', 'type' => 'editor'])
						@slot('label', 'news.f_full_text')
						@slot('value', $item->full_text)
					@endcomponent

					<button type="submit" class="btn btn-primary">@lang('messages.actions.save')</button>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endsection
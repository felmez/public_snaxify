@extends('layouts.dashboard')
@section('subtitle', __('messages.news.menu_title'))
@section('filter')
	<div class="col-sm-4">
		@component('components.form-group', ['name' => 'filter[q]', 'type' => 'text'])
			@slot('label', 'news.filter_text')
			@slot('value', isset($filter['q']) ? $filter['q'] : null)
		@endcomponent
	</div>
	@if (\App\Settings::getSettings()->multiple_cities)
		<div class="col-sm-4">
			@component('components.form-group', ['name' => 'filter[city_id]', 'type' => 'select'])
				@slot('label', 'news.f_city')
				@slot('options', \App\City::policyScope()->get()->push([
					'id' => null,
					'name' => null
				])->pluck('name', 'id'))
				@slot('selected', isset($filter['city_id']) ? $filter['city_id'] : null)
			@endcomponent
		</div>
	@endif
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<div class="clearfix">
						<h3 class="card-title font-weight-bold float-{{ $align }}">@lang('messages.news.menu_title')</h3>
						<a class="btn btn-secondary float-{{ $align }} btn-xs ml-3"
						   href="{{ route('dashboard.news_items.create') }}">
							@lang('messages.news.new')
						</a>
					</div>
					<hr>

					<div class="table-responsive mt-2">
						<table class="table table-striped">
							<thead>
							<tr>
								<th class="font-weight-bold">#</th>
								<th class="font-weight-bold">@lang('messages.news.f_image')</th>
								<th class="font-weight-bold">@lang('messages.news.f_title')</th>
								@if (\App\Settings::getSettings()->multiple_cities)
									<th class="font-weight-bold">{{__('messages.news.f_city')}}</th>
								@endif
								<th></th>
							</tr>
							</thead>
							<tbody>
							@foreach($items as $item)
								<tr>
									<td>{{ $item->id }}</td>
									<td>
										@if ($item->image != null)
											<img src="{{ $item->image }}" alt=""
											     class="img-responsive product-image-table">
										@endif
									</td>
									<td>{{ $item->title }}</td>
									@if (\App\Settings::getSettings()->multiple_cities)
										<td>
											@if ($item->city != null)
												{{ $item->city->name }}
											@endif
										</td>
									@endif
									<td>
										<a href="{{ route('dashboard.news_items.edit', ['id' => $item->id]) }}"
										   class="btn btn-info btn-xs">@lang('messages.actions.edit')</a>
										<a href="{{ route('dashboard.news_items.destroy', ['id' => $item->id]) }}"
										   class="btn btn-danger btn-xs" data-destroy>
											@lang('messages.actions.delete')
										</a>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="text-center mx-auto d-table">
		{{ $items->appends(['filter' => $filter])->links() }}
	</div>
@endsection
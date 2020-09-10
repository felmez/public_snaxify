@extends('layouts.dashboard')
@section('subtitle', __('messages.delivery_areas.menu_title'))

@section('filter')
@if (\App\Settings::getSettings()->multiple_cities)
<div class="col-sm-4">
	@component('components.form-group', ['name' => 'filter[city_id]', 'type' => 'select'])
	@slot('label', 'delivery_areas.f_city')
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
					<h3 class="card-title font-weight-bold float-{{ $align }}">@lang('messages.delivery_areas.menu_title')</h3>
					<a class="btn btn-secondary float-{{ $align }} btn-xs ml-3"
						href="{{ route('dashboard.delivery_areas.create') }}">
						@lang('messages.delivery_areas.new')
					</a>
				</div>
				<hr>

				<div class="table-responsive mt-2">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>{{__('messages.delivery_areas.f_name')}}</th>
								<th>{{__('messages.delivery_areas.f_price')}}</th>
								@if (\App\Settings::getSettings()->multiple_cities)
								<th>{{ __('messages.delivery_areas.f_city') }}</th>
								@endif
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($items as $item)
							{{-- authorize added for username --}}
							{{-- TODO: fixed by policy --}}
							{{-- @if(auth()->user()->username == $item->owner_username) --}}
							<tr>
								<td>{{ $item->name }}</td>
								<td>{{ \App\Settings::currency($item->price) }}</td>
								@if (\App\Settings::getSettings()->multiple_cities)
								<td>
									@if ($item->city != null)
									{{ $item->city->name }}
									@endif
								</td>
								@endif
								<td>
									<a href="{{ route('dashboard.delivery_areas.edit', ['id' => $item->id]) }}"
										class="btn btn-info btn-xs">@lang('messages.actions.edit')</a>
									<a href="{{ route('dashboard.delivery_areas.destroy', ['id' => $item->id]) }}"
										class="btn btn-danger btn-xs" data-destroy>
										@lang('messages.actions.delete')
									</a>
								</td>
							</tr>
							{{-- @endif --}}
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
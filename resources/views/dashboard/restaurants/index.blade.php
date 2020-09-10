@extends('layouts.dashboard')
@section('subtitle', __('messages.restaurants.menu_title'))
{{-- filter and search section removed --}}
{{-- @section('filter')
<div class="col-sm-4">
	@component('components.form-group', ['name' => 'filter[q]', 'type' => 'text'])
	@slot('label', 'restaurants.filter_text')
	@slot('value', isset($filter['q']) ? $filter['q'] : null)
	@endcomponent
</div>
@if (\App\Settings::getSettings()->multiple_cities)
<div class="col-sm-4">
	@component('components.form-group', ['name' => 'filter[city_id]', 'type' => 'select'])
	@slot('label', 'restaurants.f_city')
	@slot('options', \App\City::policyScope()->get()->push([
	'id' => null,
	'name' => null
	])->pluck('name', 'id'))
	@slot('selected', isset($filter['city_id']) ? $filter['city_id'] : null)
	@endcomponent
</div>
@endif
@endsection --}}

@section('content')
<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="clearfix">
					<h3 class="card-title font-weight-bold float-{{ $align }}">@lang('messages.restaurants.menu_title')</h3>
					@can('create', App\Restaurant::class)
					<a class="btn btn-secondary float-{{ $align }} btn-xs ml-3"
						href="{{ route('dashboard.restaurants.create') }}">
						@lang('messages.restaurants.new')
					</a>
					@endcan

				</div>
				<hr>

				<div class="table-responsive mt-2">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>@lang('messages.restaurants.f_image')</th>
								{{-- FIXME user name element does not show --}}
								<th>@lang('messages.restaurants.f_name')</th>
								{{-- for username field koudify --}}
								{{-- <th>@lang('messages.restaurants.f_username')</th> --}}
								@if (\App\Settings::getSettings()->multiple_cities)
								<th>@lang('messages.restaurants.f_city')</th>
								@endif
								<th></th>
							</tr>
						</thead>
						<tbody>
							{{-- NEED AUTH HERE  --}}
							{{-- @can('can-view', $restaurant) --}}
							@foreach($items as $item)
							{{-- FIX if current user role is owner and if restaurant owner show --}}
							{{-- TODO: removed if auth because fixed on policyscope --}}
							{{-- @if(auth()->user()->username == $item->owner_username) --}}
							{{-- FIXME  show on username --}}
							{{-- @can('view', App\Restaurant::class) --}}
							<tr>
								<td>
									@if (!empty($item->image))
									<img src="{{ $item->image }}" alt="" class="img-responsive product-image-table">
									@endif
								</td>
								<td>{{ $item->name }}
									{{-- FIXME implement this pagination to orders in homepage and order page / when this is disabled pagination from restaurant pages gone --}}
									{{-- TODO:  --}}
									@if (\App\Settings::getSettings()->multiple_cities)
								<td>{{ $item->city == null ? '' : $item->city->name }}</td>
								@endif
								</td>
								{{-- FIX pagination here --}}
								<td>
									<a href="{{ route('dashboard.restaurants.edit', ['id' => $item->id]) }}"
										class="btn btn-info btn-xs">@lang('messages.actions.edit')</a>
									<a href="{{ route('dashboard.restaurants.destroy', ['id' => $item->id]) }}"
										class="btn btn-danger btn-xs" data-destroy>
										@lang('messages.actions.delete')
									</a>
								</td>
							</tr>
							{{-- @endcan --}}
							{{-- @endif --}}
							@endforeach
							{{-- @endcan --}}
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
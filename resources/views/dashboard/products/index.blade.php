@extends('layouts.dashboard')
@section('subtitle', __('messages.products.menu_title'))
{{-- filter and search section removed --}}

@section('content')
<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="clearfix">
					<h3 class="card-title font-weight-bold float-{{ $align }}">@lang('messages.products.menu_title')</h3>
					<a class="btn btn-secondary float-{{ $align }} btn-xs ml-3" href="{{ route('dashboard.products.create') }}">
						@lang('messages.products.new')
					</a>
				</div>
				<hr>

				<div class="table-responsive mt-2">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>@lang('messages.products.f_image')</th>
								<th>@lang('messages.products.f_name')</th>
								<th>@lang('messages.products.f_category')</th>
								<th>@lang('messages.products.f_price')</th>
								<th>@lang('messages.products.f_price_old')</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($items as $item)
							{{-- authorize added for username --}}
							{{-- TODO: fixed by policy --}}
							{{-- @if(auth()->user()->username == $item->owner_username) --}}
							<tr>
								<td>{{ $item->id }}</td>
								<td>
									@if ($item->hasMedia('thumbnails'))
									<img src="{{ $item->getFirstMedia('thumbnails')->getUrl() }}"
										alt="{{ $item->getFirstMedia('thumbnails')->name }}" class="img-responsive product-image-table">
									@endif
								</td>
								<td>{{ $item->name }}</td>
								<td>{{ $item->category->name }}</td>
								<td>{{ \App\Settings::currency($item->price) }}</td>
								<td>{{ \App\Settings::currency($item->price_old) }}</td>
								<td>
									@can('update', $item)
									<a href="{{ route('dashboard.products.edit', ['id' => $item->id]) }}"
										class="btn btn-info btn-xs">@lang('messages.actions.edit')</a>
									@endcan
									@can('delete', $item)
									<a href="{{ route('dashboard.products.destroy', ['id' => $item->id]) }}" class="btn btn-danger btn-xs"
										data-destroy>
										@lang('messages.actions.delete')
									</a>
									@endcan
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

@push('scripts')
@if (\App\Settings::getSettings()->multiple_cities || \App\Settings::getSettings()->multiple_restaurants)
<script src="/custom_js/products.js"></script>
@endif
@endpush
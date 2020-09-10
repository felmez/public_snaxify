@extends('layouts.dashboard')
@section('subtitle', __('messages.promo_codes.menu_title'))
{{-- filter and search section removed --}}

@section('content')
	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<div class="clearfix">
						<h3 class="card-title font-weight-bold float-{{ $align }}">@lang('messages.promo_codes.menu_title')</h3>
						<a class="btn btn-secondary float-{{ $align }} btn-xs ml-3"
						   href="{{ route('dashboard.promo_codes.create') }}">
							@lang('messages.promo_codes.new')
						</a>
					</div>
					<hr>

					<div class="table-responsive mt-2">
						<table class="table table-striped">
							<thead>
							<tr>
								<th>@lang('messages.promo_codes.f_name')</th>
								<th>@lang('messages.promo_codes.f_code')</th>
								<th>@lang('messages.promo_codes.f_discount')</th>
								<th>@lang('messages.promo_codes.f_limit')</th>
								<th>@lang('messages.promo_codes.f_used')</th>
								<th>@lang('messages.promo_codes.f_min_price')</th>
								<th>@lang('messages.promo_codes.f_active_from')</th>
								<th>@lang('messages.promo_codes.f_active_to')</th>
								<th></th>
							</tr>
							</thead>
							<tbody>
							@foreach($items as $item)
								<tr>
									<td>{{ $item->name }}</td>
									<td>{{ $item->code }}</td>
									<td>
										{{ $item->discount }}@if ($item->discount_in_percent)% @endif
									</td>
									<td>{{ $item->limit_use_count }}</td>
									<td>{{ $item->times_used }}</td>
									<td>
										{{ \App\Settings::currency($item->min_price) }}
									</td>
									<td>
										{{ $item->active_from }}
									</td>
									<td>
										@if ($item->active_to != null)
											{{ $item->active_to }}
										@endif
									</td>
									<td>
										<a href="{{ route('dashboard.promo_codes.edit', ['id' => $item->id]) }}"
										   class="btn btn-info btn-xs">@lang('messages.actions.edit')</a>
										<a href="{{ route('dashboard.promo_codes.destroy', ['id' => $item->id]) }}"
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

@push('scripts')
	@if (\App\Settings::getSettings()->multiple_cities || \App\Settings::getSettings()->multiple_restaurants)
		<script src="/custom_js/products.js"></script>
	@endif
@endpush

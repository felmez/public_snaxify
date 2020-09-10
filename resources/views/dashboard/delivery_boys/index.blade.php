@extends('layouts.dashboard')
@section('subtitle', __('messages.delivery_boys.menu_title'))
@section('content')
	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<div class="clearfix">
						<h3 class="card-title font-weight-bold float-{{ $align }}">@lang('messages.delivery_boys.menu_title')</h3>
						<a class="btn btn-secondary float-{{ $align }} btn-xs ml-3"
						   href="{{ route('dashboard.delivery_boys.create') }}">
							@lang('messages.delivery_boys.new')
						</a>
					</div>
					<hr>

					<div class="table-responsive mt-2">
						<table class="table table-striped">
							<thead>
							<tr>
								<th>@lang('messages.delivery_boys.f_name')</th>
								<th>@lang('messages.delivery_boys.f_orders_count')</th>
								<th></th>
							</tr>
							</thead>
							<tbody>
							@foreach($items as $item)
								<tr>
									<td>{{ $item->name }}</td>
									<td>{{ $item->orders->count() }}</td>
									<td>
										<a href="{{ route('dashboard.delivery_boys.edit', ['id' => $item->id]) }}"
										   class="btn btn-info btn-xs">@lang('messages.actions.edit')</a>
										<a href="{{ route('dashboard.delivery_boys.destroy', ['id' => $item->id]) }}"
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
@extends('layouts.dashboard')
@section('subtitle', __('messages.order_statuses.menu_title'))

@section('content')
<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="clearfix">
					<h3 class="card-title font-weight-bold float-{{ $align }}">@lang('messages.order_statuses.menu_title')</h3>
					<a class="btn btn-secondary float-{{ $align }} btn-xs ml-3"
						href="{{ route('dashboard.order_statuses.create') }}">
						@lang('messages.order_statuses.new')
					</a>
				</div>
				<hr>

				<div class="table-responsive mt-2">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>@lang('messages.order_statuses.f_name')</th>
								<th>@lang('messages.order_statuses.f_is_default')</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($items as $item)
							{{-- authorize added for username --}}
							@if(auth()->user()->username == $item->owner_username)
							<tr>
								<td>{{ $item->name }}</td>
								<td>
									@if ($item->is_default)
									<span class="label label-success">{{ __('messages.common.yes') }}</span>
									@else
									<span class="label label-default">{{ __('messages.common.no') }}</span>
									@endif
								</td>
								<td>
									<a href="{{ route('dashboard.order_statuses.edit', ['id' => $item->id]) }}"
										class="btn btn-info btn-xs">@lang('messages.actions.edit')</a>
									<a href="{{ route('dashboard.order_statuses.destroy', ['id' => $item->id]) }}"
										class="btn btn-danger btn-xs" data-destroy>
										@lang('messages.actions.delete')
									</a>
								</td>
							</tr>
							@endif
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
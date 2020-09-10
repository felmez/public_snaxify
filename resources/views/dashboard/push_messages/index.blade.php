@extends('layouts.dashboard')
@section('subtitle', __('messages.push_messages.menu_title'))

@section('content')
	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<div class="clearfix">
						<h3 class="card-title font-weight-bold float-{{ $align }}">@lang('messages.push_messages.menu_title')</h3>
						<a class="btn btn-secondary float-{{ $align }} btn-xs ml-3"
						   href="{{ route('dashboard.push_messages.create') }}">
							@lang('messages.push_messages.new')
						</a>
					</div>
					<hr>

					<div class="table-responsive mt-2">
						<table class="table table-striped">
							<thead>
							<tr>
								<th>@lang('messages.push_messages.f_message')</th>
								<th>@lang('messages.push_messages.f_created_at')</th>
								<th>@lang('messages.push_messages.f_status')</th>
								<th></th>
							</tr>
							</thead>
							<tbody>
							@foreach($items as $item)
								<tr>
									<td>{{ $item->message }}</td>
									<td>{{ Date::parse($item->created_at)->format(\App\Settings::getSettings()->time_format_backend) }}</td>
									<td>{{ __('messages.push_messages.status')[$item->status] }}</td>
									<td>{{ $item->error }}</td>
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

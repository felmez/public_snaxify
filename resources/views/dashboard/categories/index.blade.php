@extends('layouts.dashboard')
@section('subtitle', __('messages.categories.menu_title'))
{{-- filter and search section removed --}}

@section('content')
<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="clearfix">
					<h3 class="card-title font-weight-bold float-{{ $align }}">@lang('messages.categories.menu_title')</h3>
					<a class="btn btn-secondary float-{{ $align }} btn-xs ml-3" href="{{ route('dashboard.categories.create') }}">
						{{__('messages.categories.new')}}
					</a>
				</div>
				<hr>

				<div class="col-md-6 mt-2">
					@foreach($items as $item)
					{{-- authorize added for username --}}
					{{-- TODO: done by policy --}}
					{{-- @if(auth()->user()->username == $item->owner_username) --}}
					<div class="card rounded border mb-2" style="margin-left: {{ 30 * $item->depth }}px;">
						<div class="card-body p-3">
							<div class="media">
								@if($item->image)
								<img src="{{ $item->image }}" alt="{{ $item->name }}" width="40" height="40"
									class="rounded-circle align-self-center mr-3">
								@endif
								{{--<i class="mdi mdi-cellphone-link icon-sm align-self-center mr-3"></i>--}}
								<div class="media-body">
									<h5 class="mb-1 float-left">{{ $item->name }}</h5>
									<div class="btn-group float-right">
										@can('update', $item)
										<a href="{{ route('dashboard.categories.edit', ['id' => $item->id]) }}"
											class="btn btn-info btn-xs">@lang('messages.actions.edit')</a>
										@endcan
										@can('delete', $item)
										<a href="{{ route('dashboard.categories.destroy', ['id' => $item->id]) }}"
											class="btn btn-danger btn-xs" data-destroy=".card.rounded">
											@lang('messages.actions.delete')
										</a>
										@endcan
									</div>
								</div>
							</div>
						</div>
					</div>
					{{-- @endif --}}
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>

<div class="text-center mx-auto d-table">
	{{ $items->appends(['filter' => $filter])->links() }}
</div>
@endsection
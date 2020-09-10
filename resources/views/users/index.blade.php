@extends('layouts.dashboard')

@section('content')
<a class="btn btn-primary" href="{{ route('users.create') }}">{{__('messages.users.new')}}</a>
<br>
<br>
<form action="{{ route('users.index') }}" method="get">
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label class="control-label">{{ __('messages.users.filter_text') }}</label>
				<input name="filter[q]" type="text" class="form-control"
					value="{{ is_array($filter) && isset($filter['q']) ? $filter['q'] : '' }}">
			</div>
		</div>
		@if (\App\Settings::getSettings()->multiple_cities)
		<div class="col-sm-6">
			<div class="form-group">
				<label class="control-label">{{ __('messages.users.f_city') }}</label>
				<select name="filter[city_id]" id="" class="form-control">
					<option value=""></option>
					@foreach(\App\City::orderBy('sort', 'ASC')->get() as $item)
					<option value="{{ $item->id }}" @if(is_array($filter) && isset($filter['city_id']) &&
						$filter['city_id']==$item->id) selected @endif>
						{{ $item->name }}
					</option>
					@endforeach
				</select>
			</div>
		</div>
		@endif
	</div>
	<button class="btn btn-primary">{{ __('messages.actions.filter') }}</button>
	<a href="{{ route('users.index') }}" class="btn btn-default">{{ __('messages.actions.clear_filter') }}</a>
</form>
<br>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>{{__('messages.users.access_full')}}</th>
			<th>{{__('messages.users.f_name')}}</th>
			<th>{{__('messages.users.f_email')}}</th>
			@if (\App\Settings::getSettings()->multiple_cities)
			<th>{{__('messages.users.f_cities')}}</th>
			@endif
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $item)
		<tr>
			<td>
				@if ($item->access_full)
				<span class="label label-danger">{{ __('messages.common.yes') }}</span>
				@else
				<span class="label label-info">{{ __('messages.common.no') }}</span>
				@endif
			</td>
			<td>{{ $item->name }}</td>
			<td>{{ $item->email }}</td>
			@if (\App\Settings::getSettings()->multiple_cities)
			<td>
				<ul>
					@foreach ($item->cities as $city)
					<li>{{ $city->name }}</li>
					@endforeach
				</ul>
			</td>
			@endif
			<td>
				<a href="{{ route('users.edit', ['id' => $item->id]) }}"
					class="btn btn-info btn-xs">{{__('messages.actions.edit')}}</a>
				<form action="{{ route('users.destroy', ['id' => $item->id]) }}" class="inline-form" method="post">
					{{ method_field('DELETE') }}
					{{ csrf_field() }}
					<button class="btn btn-danger btn-xs" type="submit">{{__('messages.actions.delete')}}</button>
				</form>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
{{ $items->appends(['filter' => $filter])->links() }}
@endsection
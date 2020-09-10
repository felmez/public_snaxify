@extends('layouts.dashboard')

@section('content')
	<form method="post"
	      action="@if ($item->id == null) {{ route('users.store') }} @else {{ route('users.update', ['id' => $item->id]) }} @endif"
	      enctype="multipart/form-data">
		{{ csrf_field() }}
		@if ($item->id != null)
			{{ method_field('PUT') }}
		@endif

		<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
			<label for="" class="control-label">{{__('messages.users.f_name')}}</label>
			<input type="text" class="form-control" value="{{$item->name}}" name="name"/>
			@if ($errors->has('name'))
				<span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
			@endif
		</div>

		<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
			<label for="" class="control-label">{{__('messages.users.f_email')}}</label>
			<input type="email" class="form-control" value="{{$item->email}}" name="email"/>
			@if ($errors->has('email'))
				<span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
			@endif
		</div>

		<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
			<label for="" class="control-label">{{__('messages.users.f_password')}}</label>
			<input type="password" class="form-control" name="password"/>
			@if ($errors->has('password'))
				<span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
			@endif
		</div>

		<div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
			<label for="" class="control-label">{{__('messages.users.f_password_confirmation')}}</label>
			<input type="password" class="form-control" name="password_confirmation"/>
			@if ($errors->has('password_confirmation'))
				<span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
			@endif
		</div>

		<div class="form-group">
			<div class="checkbox">
				<label>
					<input type="checkbox" value="1" name="access_full" @if ($item->access_full) checked @endif>
					{{__('messages.users.access_full')}}
				</label>
			</div>
		</div>

		<h3>{{__('messages.users.access_to_cities')}}</h3>
		<div class="row">
			@foreach (\App\City::all() as $city)
				<div class="col-sm-4">
					<div class="form-group">
						<div class="checkbox">
							<label>
								<input type="checkbox" value="{{ $city->id }}" name="cities_ids[]"
								       @if (in_array($city->id, $item->cities->pluck('id')->all())) checked @endif>
								{{ $city->name}}
							</label>
						</div>
					</div>
				</div>
			@endforeach
		</div>

		<h3>{{__('messages.users.access_to_system_parts')}}</h3>
		<div class="row">
			@foreach (['access_news', 'access_categories', 'access_products',
				'access_orders', 'access_customers', 'access_pushes', 'access_delivery_areas',
				'access_promo_codes', 'access_tax_groups', 'access_cities', 'access_restaurants',
				'access_settings', 'access_users', 'access_delivery_boys', 'access_order_statuses'] as $role)
				<div class="col-sm-4">
					<div class="form-group">
						<div class="checkbox">
							<label>
								<input type="checkbox" value="1" name="{{$role}}" @if ($item->$role) checked @endif>
								{{__('messages.users.' . $role)}}
							</label>
						</div>
					</div>
				</div>
			@endforeach
		</div>


		<button type="submit" class="btn btn-primary btn-block">{{__('messages.actions.save')}}</button>
	</form>
@endsection
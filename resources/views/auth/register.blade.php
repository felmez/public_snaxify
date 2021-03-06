@extends('layouts.login')

@section('content')
<div class="panel panel-default">
	<div class="panel-heading">Register</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
			{{ csrf_field() }}

			<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
				<label for="name" class="col-md-4 control-label">Name</label>

				<div class="col-md-6">
					<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

					@if ($errors->has('name'))
					<span class="help-block">
						<strong>{{ $errors->first('name') }}</strong>
					</span>
					@endif
				</div>
			</div>
			{{-- username field --}}
			<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
				<label for="username" class="col-md-4 control-label">Username</label>

				<div class="col-md-6">
					<input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required
						autofocus>

					@if ($errors->has('username'))
					<span class="help-block">
						<strong>{{ $errors->first('username') }}</strong>
					</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				<label for="email" class="col-md-4 control-label">E-Mail Address</label>

				<div class="col-md-6">
					<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

					@if ($errors->has('email'))
					<span class="help-block">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
				<label for="password" class="col-md-4 control-label">Password</label>

				<div class="col-md-6">
					<input id="password" type="password" class="form-control" name="password" required>

					@if ($errors->has('password'))
					<span class="help-block">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
					@endif
				</div>
			</div>

			<div class="form-group">
				<label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

				<div class="col-md-6">
					<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
				</div>
			</div>
			{{-- old roles selection FIXME: --}}
			{{-- <div class="form-group">
				<label for="type" class="col-md-4 control-label">Static Role</label>
				<div class="col-md-6">
					<select class="form-control" name="role" id="role">

						<option value="admin">Admin</option>
						<option value="owner">Owner</option>

					</select>
				</div>
			</div> --}}

			{{-- new roles selection TODO: --}}
			<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
				<label for="role" class="col-md-4 control-label">Role</label>
				<div class="col-md-6">
					<select id="role" type="text" class="form-control" name="role" value="{{ old('role') }}" required autofocus>
						@foreach ($roles as $role)
						<option value="{{$role}}">{{$role}}</option>
						@endforeach
					</select>
					@if ($errors->has('role'))
					<span class="help-block">
						<strong>{{ $errors->first('role') }}</strong>
					</span>
					@endif
				</div>
			</div>

			{{-- TODO: restaurant field for assigning to owner --}}
			<div class="form-group{{ $errors->has('restaurant') ? ' has-error' : '' }}">
				<label for="restaurant" class="col-md-4 control-label">Restaurant</label>
				<div class="col-md-6">
					<select id="restaurant" type="text" class="form-control" name="restaurant" value=""
						autofocus>
						<option></option>
						@foreach ($restaurants as $id=>$restaurant)
						<option value="{{$id}}">{{$restaurant}}</option>
						@endforeach
						
					</select>
					@if ($errors->has('restaurant'))
					<span class="help-block">
						<strong>{{ $errors->first('restaurant') }}</strong>
					</span>
					@endif
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<button type="submit" class="btn btn-primary">
						Register
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
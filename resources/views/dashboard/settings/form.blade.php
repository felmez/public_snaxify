@extends('layouts.dashboard')
@section('content')
	{!! Form::model($item, [
		'route' => $item->id == null ? 'dashboard.settings.store' : ['dashboard.settings.update', 'id' => $item->id],
		'method' => $item->id == null ? 'post' : 'patch',
		'files' => true,
		'class' => 'validate row',
		'novalidate',
	]) !!}
	<div class="col-lg-9">
		<div class="card">
			<div class="card-body pb-2">
				<h3 class="card-title mb-4">@lang('messages.settings.general')</h3>
				<div class="row">
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'currency_format', 'type' => 'text'])
							@slot('label', 'settings.f_currency_format')
							@slot('attributes', ['required'])
						@endcomponent
					</div>

					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'tax_included', 'type' => 'checkbox'])
							@slot('label', 'settings.f_tax_included')
							@slot('value', '1')
						@endcomponent
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'time_format_backend', 'type' => 'text'])
							@slot('label', 'settings.f_time_format_backend')
							@slot('attributes', ['required'])
						@endcomponent
					</div>
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'time_format_app', 'type' => 'text'])
							@slot('label', 'settings.f_time_format_app')
							@slot('attributes', ['required'])
						@endcomponent
					</div>
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'date_format', 'type' => 'text'])
							@slot('label', 'settings.f_date_format')
							@slot('attributes', ['required'])
						@endcomponent
					</div>
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'date_format_app', 'type' => 'text'])
							@slot('label', 'settings.f_date_format_app')
							@slot('attributes', ['required'])
						@endcomponent
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'signup_required', 'type' => 'checkbox'])
							@slot('label', 'settings.f_signup_required')
							@slot('value', '1')
						@endcomponent
					</div>
				</div>
			</div>
		</div><!--/.card-->

		<div class="card mt-4">
			<div class="card-body pb-2">
				<h3 class="card-title mb-4">@lang('messages.settings.multi_location')</h3>
				<div class="row">
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'multiple_restaurants', 'type' => 'checkbox'])
							@slot('label', 'settings.f_multiple_restaurants')
							@slot('value', '1')
						@endcomponent
					</div>
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'multiple_cities', 'type' => 'checkbox'])
							@slot('label', 'settings.f_multiple_cities')
							@slot('value', '1')
						@endcomponent
					</div>
				</div>
			</div>
		</div><!--/.card-->

		<div class="card mt-4">
			<div class="card-body pb-2">
				<h3 class="card-title mb-4">@lang('messages.settings.push')</h3>
				<div class="row">
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'pushwoosh_id', 'type' => 'text'])
							@slot('label', 'settings.f_pushwoosh_id')
						@endcomponent
					</div>
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'pushwoosh_token', 'type' => 'text'])
							@slot('label', 'settings.f_pushwoosh_token')
						@endcomponent
					</div>
				</div>
			</div>
		</div><!--/.card-->

		<div class="card mt-4">
			<div class="card-body pb-2">
				<h3 class="card-title mb-4">@lang('messages.settings.notifications')</h3>
				<div class="row">
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'notification_email', 'type' => 'email'])
							@slot('label', 'settings.f_notification_email')
						@endcomponent
					</div>
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'mail_from_new_order_subject', 'type' => 'text'])
							@slot('label', 'settings.f_mail_from_new_order_subject')
						@endcomponent
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'mail_from_name', 'type' => 'text'])
							@slot('label', 'settings.f_mail_from_name')
						@endcomponent
					</div>
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'mail_from_mail', 'type' => 'email'])
							@slot('label', 'settings.f_mail_from_mail')
						@endcomponent
					</div>
				</div>
			</div>
		</div><!--/.card-->

		<!-- <div class="card mt-4">
			<div class="card-body pb-2">
				<h3 class="card-title mb-4">@lang('messages.settings.stripe')</h3>
				<div class="row">
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'stripe_publishable', 'type' => 'text'])
							@slot('label', 'settings.f_stripe_publishable')
						@endcomponent
					</div>
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'stripe_private', 'type' => 'text'])
							@slot('label', 'settings.f_stripe_private')
						@endcomponent
					</div>
				</div>
			</div>
		</div> -->
		<!--/.card-->

		<!-- <div class="card mt-4">
			<div class="card-body pb-2">
				<h3 class="card-title mb-4">@lang('messages.settings.paypal')</h3>
				<div class="row">
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'paypal_client_id', 'type' => 'text'])
							@slot('label', 'settings.f_paypal_client_id')
						@endcomponent
					</div>
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'paypal_client_secret', 'type' => 'text'])
							@slot('label', 'settings.f_paypal_client_secret')
						@endcomponent
					</div>
					<div class="col-sm-6">
						@component('components.form-group', ['name' => 'paypal_currency', 'type' => 'text'])
							@slot('label', 'settings.f_paypal_currency')
						@endcomponent
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							@component('components.form-group', ['name' => 'paypal_production', 'type' => 'checkbox'])
								@slot('label', 'settings.f_paypal_production')
								@slot('value', '1')
							@endcomponent
						</div>
					</div>
				</div>
			</div>
		</div> -->
		<!--/.card-->
	</div>

	<div class="col-lg-3 position-relative">
		<div class="card position-fixed">
			<div class="card-body px-5">
				<button type="submit" class="btn btn-primary btn-lg">
					@lang('messages.actions.save')
				</button>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
@endsection
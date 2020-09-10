<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
	@if (preg_match('/^delivery_areas/', \Route::currentRouteName()))
		<script type="text/javascript"
		        src="//maps.googleapis.com/maps/api/js?libraries=drawing,geometry&key=AIzaSyCulxWb_EzHIYN8FNu5SsFmgzCNMlmg1Nk"></script>
@endif
<!-- Scripts -->
	<script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
	</script>
	<script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
<form class="hidden" id="logout-form" action="{{ route('logout') }}" method="POST">{{ csrf_field() }}</form>
<div class="container">
	<div class="row">
		<div class="col-md-3 sidenav">
			<ul class="nav nav-pills nav-stacked">
				<li @if (preg_match('/^home/', \Route::currentRouteName())) class="active" @endif>
					<a href="{{ route('home') }}">{{__('messages.dashboard.menu_title')}}</a>
				</li>
				@can('create', App\NewsItem::class)
					<li @if (preg_match('/^news_items/', \Route::currentRouteName())) class="active" @endif>
						<a href="{{ route('news_items.index') }}">{{__('messages.news.menu_title')}}</a>
					</li>
				@endcan
				@can('create', \App\Category::class)
					<li @if (preg_match('/^categories/', \Route::currentRouteName())) class="active" @endif>
						<a href="{{ route('categories.index') }}">{{__('messages.categories.menu_title')}}</a>
					</li>
				@endcan
				@can('create', App\Product::class)
					<li @if (preg_match('/^products/', \Route::currentRouteName())) class="active" @endif>
						<a href="{{ route('products.index') }}">{{__('messages.products.menu_title')}}</a>
					</li>
				@endcan
				@can('create', App\Order::class)
					<li @if (preg_match('/^orders/', \Route::currentRouteName())) class="active" @endif>
						<a href="{{ route('orders.index') }}">{{__('messages.orders.menu_title')}}</a>
					</li>
				@endcan
				@can('create', App\Customer::class)
					<li @if (preg_match('/^customers/', \Route::currentRouteName())) class="active" @endif>
						<a href="{{ route('customers.index') }}">{{__('messages.customers.menu_title')}}</a>
					</li>
				@endcan
				@can('create', App\PushMessage::class)
					<li @if (preg_match('/^push_messages/', \Route::currentRouteName())) class="active" @endif>
						<a href="{{ route('push_messages.index') }}">{{__('messages.push_messages.menu_title')}}</a>
					</li>
				@endcan
				@can('create', App\DeliveryArea::class)
					<li @if (preg_match('/^delivery_areas/', \Route::currentRouteName())) class="active" @endif>
						<a href="{{ route('delivery_areas.index') }}">{{__('messages.delivery_areas.menu_title')}}</a>
					</li>
				@endcan
				@can('create', App\DeliveryBoy::class)
					<li @if (preg_match('/^delivery_boys/', \Route::currentRouteName())) class="active" @endif>
						<a href="{{ route('delivery_boys.index') }}">{{__('messages.delivery_boys.menu_title')}}</a>
					</li>
				@endcan
				@can('create', App\PromoCode::class)
					<li @if (preg_match('/^promo_codes/', \Route::currentRouteName())) class="active" @endif>
						<a href="{{ route('promo_codes.index') }}">{{__('messages.promo_codes.menu_title')}}</a>
					</li>
				@endcan
				@can('create', App\TaxGroup::class)
					<li @if (preg_match('/^tax_groups/', \Route::currentRouteName())) class="active" @endif>
						<a href="{{ route('tax_groups.index') }}">{{__('messages.tax_groups.menu_title')}}</a>
					</li>
				@endcan
				@can('create', App\OrderStatus::class)
					<li @if (preg_match('/^order_statuses/', \Route::currentRouteName())) class="active" @endif>
						<a href="{{ route('order_statuses.index') }}">{{__('messages.order_statuses.menu_title')}}</a>
					</li>
				@endcan
				@if (\App\Settings::getSettings()->multiple_cities)
					@can('create', App\City::class)
						<li @if (preg_match('/^cities/', \Route::currentRouteName())) class="active" @endif>
							<a href="{{ route('cities.index') }}">{{__('messages.cities.menu_title')}}</a>
						</li>
					@endcan
				@endif
				@if (\App\Settings::getSettings()->multiple_restaurants)
					@can('create', App\Restaurant::class)
						<li @if (preg_match('/^restaurants/', \Route::currentRouteName())) class="active" @endif>
							<a href="{{ route('restaurants.index') }}">{{__('messages.restaurants.menu_title')}}</a>
						</li>
					@endcan
				@endif
				@can('create', App\Settings::class)
					<li @if (preg_match('/^settings/', \Route::currentRouteName())) class="active" @endif>
						<a href="{{ route('settings.index') }}">{{__('messages.settings.menu_title')}}</a>
					</li>
				@endcan
				@can('create', App\User::class)
					<li @if (preg_match('/^users/', \Route::currentRouteName())) class="active" @endif>
						<a href="{{ route('users.index') }}">{{__('messages.users.menu_title')}}</a>
					</li>
				@endcan
				<li class="divider">
					<hr>
				</li>
				<li>
					<a href="{{ route('logout') }}"
					   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
						{{__('auth.logout')}}
					</a>
				</li>
			</ul>
		</div>
		<div class="col-md-9">
			@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
			@endif
			@yield('content')
		</div>
	</div>
</div>

<script>
    window.locale = {
        confirm: '{{ __("messages.common.confirm") }}'
    };
</script>
</body>
</html>

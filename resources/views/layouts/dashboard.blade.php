<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ localization()->getCurrentLocaleDirection() }}">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	@if(route_is('dashboard.index'))
	<title>@yield('title', config('app.name'))
		- @yield('subtitle', config('app.name'))</title>
	@else
	<title>@yield('subtitle', config('app.name'))
		- @yield('title', config('app.name'))</title>
	@endif

	<link rel="shortcut icon" href="/dashboard/images/favicon.png">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- plugins:css -->
	<link rel="stylesheet" href="/dashboard/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="/dashboard/vendors/css/vendor.bundle.base.css">
	<link rel="stylesheet" href="/dashboard/vendors/css/vendor.bundle.addons.css">
	<link rel="stylesheet" href="/dashboard/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
	<link rel="stylesheet" href="/dashboard/vendors/iconfonts/ti-icons/css/themify-icons.css">
	<link rel="stylesheet" href="/dashboard/css/style.css">

	<link href="https://fonts.googleapis.com/css?family=Nunito:300,300i,400,400i,600,600i,700,700i,800,800i"
		rel="stylesheet">

	@if(route_is('dashboard.delivery_areas.create') || route_is('dashboard.delivery_areas.edit'))
	<script type="text/javascript"
		src="//maps.googleapis.com/maps/api/js?libraries=drawing,geometry&key=AIzaSyCulxWb_EzHIYN8FNu5SsFmgzCNMlmg1Nk">
	</script>
	@endif

	<script>
		window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'env' => app()->environment(),
            'locale' => app()->getLocale(),
            'dir' => localization()->getCurrentLocaleDirection(),
            'align' => localization()->getCurrentLocaleDirection() == 'rtl' ? 'right' : 'left',
        ]) !!};

        window.locale = {
            confirm: "@lang('messages.common.confirm')"
        };
	</script>

	@stack('head')
	
</head>

<body class="{{ $bodyClasses }} @yield('body-class')">

	{{-- koudify old style sidebar --}}
	{{-- @include('dashboard.partials.sidebar') --}}

	<div class="container-scroller">
		@include('dashboard.partials.navbar')
		<div class="container-fluid page-body-wrapper">
			<div class="main-panel">
				<div class="content-wrapper">
					{{-- navbar button start --}}
					<a href="{{ route('dashboard.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-home"></i>
							<strong>@lang('messages.dashboard.menu_title')</strong>
						</button>
					</a>
					{{--  --}}
					@can('create', \App\Category::class)
					<a href="{{ route('dashboard.categories.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-folder"></i>
							<strong>@lang('messages.categories.menu_title')</strong>
						</button>
					</a>
					@endcan
					{{--  --}}
					@can('create', App\Product::class)
					<a href="{{ route('dashboard.products.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-package"></i>
							<strong>@lang('messages.products.menu_title')</strong>
						</button>
					</a>
					@endcan
					{{--  --}}
					@can('create', App\Order::class)
					<a href="{{ route('dashboard.orders.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-truck"></i>
							<strong>@lang('messages.orders.menu_title')</strong>
						</button>
					</a>
					@endcan
					{{--  --}}
					@can('create', App\Customer::class)
					<a href="{{ route('dashboard.customers.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-user"></i>
							<strong>@lang('messages.customers.menu_title')</strong>
						</button>
					</a>
					@endcan
					{{--  --}}
					@if (\App\Settings::getSettings()->multiple_restaurants)
					@can('create', App\Restaurant::class)
					<a href="{{ route('dashboard.restaurants.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-layers"></i>
							<strong>@lang('messages.restaurants.menu_title')</strong>
						</button>
					</a>
					@endcan
					@endif
					{{--  --}}
					@can('create', App\DeliveryArea::class)
					<a href="{{ route('dashboard.delivery_areas.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-map-alt"></i>
							<strong>@lang('messages.delivery_areas.menu_title')</strong>
						</button>
					</a>
					@endcan
					{{--  --}}
					@if (\App\Settings::getSettings()->multiple_cities)
					@can('create', App\City::class)
					<a href="{{ route('dashboard.cities.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-location-pin"></i>
							<strong>@lang('messages.cities.menu_title')</strong>
						</button>
					</a>
					@endcan
					@endif
					{{--  --}}
					@can('create', App\Settings::class)
					<a href="{{ route('dashboard.settings.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-settings"></i>
							<strong>@lang('messages.settings.menu_title')</strong>
						</button>
					</a>
					@endcan
					{{--  --}}
					@can('create', App\OrderStatus::class)
					<a href="{{ route('dashboard.order_statuses.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-smallcap"></i>
							<strong>@lang('messages.order_statuses.menu_title')</strong>
						</button>
					</a>
					@endcan
					{{--  --}}
					@can('create', App\NewsItem::class)
					<a href="{{ route('dashboard.news_items.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-write"></i>
							<strong>@lang('messages.news.menu_title')</strong>
						</button>
					</a>
					@endcan
					{{-- FIXME commented for no need YET --}}
					{{--  --}}
					@can('create', App\PushMessage::class)
					<a href="{{ route('dashboard.push_messages.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-bell"></i>
							<strong>@lang('messages.push_messages.menu_title')</strong>
						</button>
					</a>
					@endcan
					{{--  --}}
					@can('create', App\DeliveryBoy::class)
					<a href="{{ route('dashboard.delivery_boys.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-id-badge"></i>
							<strong>@lang('messages.delivery_boys.menu_title')</strong>
						</button>
					</a>
					@endcan
					{{--  --}}
					@can('create', App\PromoCode::class)
					<a href="{{ route('dashboard.promo_codes.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-wallet"></i>
							<strong>@lang('messages.promo_codes.menu_title')</strong>
						</button>
					</a>
					@endcan
					{{--  --}}
					@can('create', App\TaxGroup::class)
					<a href="{{ route('dashboard.tax_groups.index') }}">
						<button type="button" class="btn btn-primary btn-fw">
							<i class="ti-money"></i>
							<strong>@lang('messages.tax_groups.menu_title')</strong>
						</button>
					</a>
					@endcan

					{{-- navbar button end --}}

					@include('dashboard.partials.breadcrumb')

					@if(session('status'))
					<div class="alert alert-fill-success">
						<i class="mdi mdi-alert-circle"></i>
						{{ session('status') }}
					</div>
					@endif

					@hasSection('filter')
					{{ Form::open(['url' => request()->url(), 'method' => 'get', 'class' => 'row']) }}
					@yield('filter')
					<div class="col-sm-4 mt-4">
						<div class="btn-group">
							<button class="btn btn-primary">{{ __('messages.actions.filter') }}</button>
							<a href="{{ request()->url() }}" class="btn btn-success">
								{{ __('messages.actions.clear_filter') }}
							</a>
						</div>
					</div>
					{{ Form::close() }}
					@endif

					@yield('content')
					</li>
					<!-- content-wrapper ends -->


					<!-- partial -->
				</div>
				<!-- main-panel ends -->
			</div>

			<!-- page-body-wrapper ends -->
		</div>

		<!-- container-scroller -->

		<!-- plugins:js -->
		<script src="/dashboard/vendors/js/vendor.bundle.base.js"></script>
		<script src="/dashboard/vendors/js/vendor.bundle.addons.js"></script>
		<script src="/dashboard/js/jquery.fileuploader.js"></script>
		<!-- endinject -->
		<!-- Plugin js for this page-->
		<!-- End plugin js for this page-->
		<!-- inject:js -->
		<script src="/dashboard/js/template.js"></script>
		<!-- endinject -->
		<!-- Custom js for this page-->
		@if(app()->getLocale() != 'en')
		<script src="/dashboard/vendors/jquery-validation/localization/messages_{{ app()->getLocale() }}.js"></script>
		@endif
		<script src="/dashboard/js/dashboard.js"></script>
		@stack('scripts')
</body>

</html>
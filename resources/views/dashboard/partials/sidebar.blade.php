<div class="sidebar">
	<ul class="col float-{{ $align }} menu">
		<li class="@active(route('dashboard.index'))">
			<a href="{{ route('dashboard.index') }}">
				<i class="ti-home"></i>
				<strong>@lang('messages.dashboard.menu_title')</strong>
			</a>
		</li>
		@can('create', \App\Category::class)
		<li class="@active(route('dashboard.categories.index'))">
			<a href="{{ route('dashboard.categories.index') }}">
				<i class="ti-folder"></i>
				<strong>@lang('messages.categories.menu_title')</strong>
			</a>
		</li>
		@endcan
		@can('create', App\Product::class)
		<li class="@active(route('dashboard.products.index'))">
			<a href="{{ route('dashboard.products.index') }}">
				<i class="ti-package"></i>
				<strong>@lang('messages.products.menu_title')</strong>
			</a>
		</li>
		@endcan
		@can('create', App\Order::class)
		<li class="@active(route('dashboard.orders.index'))">
			<a href="{{ route('dashboard.orders.index') }}">
				<i class="ti-truck"></i>
				<strong>@lang('messages.orders.menu_title')</strong>
			</a>
		</li>
		@endcan
		@can('create', App\Customer::class)
		<li class="@active(route('dashboard.customers.index'))">
			<a href="{{ route('dashboard.customers.index') }}">
				<i class="ti-user"></i>
				<strong>@lang('messages.customers.menu_title')</strong>
			</a>
		</li>
		@endcan
		@if (\App\Settings::getSettings()->multiple_restaurants)
		@can('create', App\Restaurant::class)
		<li class="@active(route('dashboard.restaurants.index'))">
			<a href="{{ route('dashboard.restaurants.index') }}">
				<i class="ti-layers"></i>
				<strong>@lang('messages.restaurants.menu_title')</strong>
			</a>
		</li>
		@endcan
		@endif
		@can('create', App\DeliveryArea::class)
		<li class="@active(route('dashboard.delivery_areas.index'))">
			<a href="{{ route('dashboard.delivery_areas.index') }}">
				<i class="ti-map-alt"></i>
				<strong>@lang('messages.delivery_areas.menu_title')</strong>
			</a>
		</li>
		@endcan
		@if (\App\Settings::getSettings()->multiple_cities)
		@can('create', App\City::class)
		<li class="@active(route('dashboard.cities.index'))">
			<a href="{{ route('dashboard.cities.index') }}">
				<i class="ti-location-pin"></i>
				<strong>@lang('messages.cities.menu_title')</strong>
			</a>
		</li>
		@endcan
		@endif
		@can('create', App\Settings::class)
		<li class="@active(route('dashboard.settings.index'))">
			<a href="{{ route('dashboard.settings.index') }}">
				<i class="ti-settings"></i>
				<strong>@lang('messages.settings.menu_title')</strong>
			</a>
		</li>
		@endcan
		@can('create', App\OrderStatus::class)
		<li class="@active(route('dashboard.order_statuses.index'))">
			<a href="{{ route('dashboard.order_statuses.index') }}">
				<i class="ti-smallcap"></i>
				<strong>@lang('messages.order_statuses.menu_title')</strong>
			</a>
		</li>
		@endcan
		@can('create', App\NewsItem::class)
		<li class="@active(route('dashboard.news_items.index'))">
			<a href="{{ route('dashboard.news_items.index') }}">
				<i class="ti-write"></i>
				<strong>@lang('messages.news.menu_title')</strong>
			</a>
		</li>
		@endcan
		{{-- FIXME commented for no need YET --}}
		@can('create', App\PushMessage::class)
		<li class="@active(route('dashboard.push_messages.index'))">
			<a href="{{ route('dashboard.push_messages.index') }}">
				<i class="ti-bell"></i>
				<strong>@lang('messages.push_messages.menu_title')</strong>
			</a>
		</li>
		@endcan
		@can('create', App\DeliveryBoy::class)
		<li class="@active(route('dashboard.delivery_boys.index'))">
			<a href="{{ route('dashboard.delivery_boys.index') }}">
				<i class="ti-id-badge"></i>
				<strong>@lang('messages.delivery_boys.menu_title')</strong>
			</a>
		</li>
		@endcan
		@can('create', App\PromoCode::class)
		<li class="@active(route('dashboard.promo_codes.index'))">
			<a href="{{ route('dashboard.promo_codes.index') }}">
				<i class="ti-wallet"></i>
				<strong>@lang('messages.promo_codes.menu_title')</strong>
			</a>
		</li>
		@endcan
		@can('create', App\TaxGroup::class)
		<li class="@active(route('dashboard.tax_groups.index'))">
			<a href="{{ route('dashboard.tax_groups.index') }}">
				<i class="ti-money"></i>
				<strong>@lang('messages.tax_groups.menu_title')</strong>
			</a>
		</li>
		@endcan
	</ul>
	<!-- /.menu -->
</div>
<!-- /.sidebar -->
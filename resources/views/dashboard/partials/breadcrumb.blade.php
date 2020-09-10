@php($breadcrumb = explode('.', Route::currentRouteName()))
@php(array_splice($breadcrumb, 0, 1))
<nav aria-label="breadcrumb">
	<ol class="breadcrumb breadcrumb-custom mb-4">
		<li class="breadcrumb-item">
			<a href="{{ route("dashboard.index") }}">
				<strong>@lang("messages.breadcrumb.dashboard")</strong>
			</a>
		</li>
		@foreach($breadcrumb as $breadcrumbItem)
			@if(Route::has("dashboard.{$breadcrumbItem}.index"))
				<li class="breadcrumb-item">
					<a href="{{ route("dashboard.{$breadcrumbItem}.index") }}">
						<strong>@lang("messages.breadcrumb.{$breadcrumbItem}")</strong>
					</a>
				</li>
			@else
				<li class="breadcrumb-item active">
					<strong>@lang("messages.breadcrumb.{$breadcrumbItem}")</strong>
				</li>
			@endif
		@endforeach
	</ol>
</nav>
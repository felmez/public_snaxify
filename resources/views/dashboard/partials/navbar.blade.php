<nav class="navbar horizontal-layout col-lg-12 col-12 p-0">
	<div class="container d-flex flex-row">
		<div class="text-center navbar-brand-wrapper d-flex align-items-top">
			<a class="navbar-brand brand-logo" href="{{ route('dashboard.index') }}">
				<img src="/dashboard/images/logo-inverse.svg" alt="logo"/>
			</a>
			<a class="navbar-brand brand-logo-mini" href="{{ route('dashboard.index') }}">
				<img src="/dashboard/images/logo-inverse.svg" alt="logo"/>
			</a>
		</div>
		<a class="btn btn-primary" href="/logout" role="button">{{ Auth::user()->username }} / Log Out</a>
		{{-- FIXME --}}
		{{-- logged user name display koudify --}}
		{{-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> --}}
				
		{{-- </a> --}}
		<!-- koudify, log out and settings button will be here -->
	</div>
</nav>
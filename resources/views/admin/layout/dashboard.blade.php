<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Basil: Hotel - Admin</title>

	<link href="{{ mix('/css/app.css') }}" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

	<meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
	{{-- FIRST NAVBAR --}}
	<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary" style='z-index:2000'>
		<div class='container px-2'>
			<a class="navbar-brand" href="{{ route('dashboard.index') }}">
	            <img src='{{ asset('images/logo-white.png') }}' height='25'>
			</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item mr-3"><a class="nav-link active" href="{{ route('settings.index') }}"><i class='fa fa-cogs'></i></a></li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle no-caret active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class='fa fa-user-circle-o'></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{ route('me.index') }}">My Account</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	{{-- SECOND NAVBAR --}}
	<nav class="navbar fixed-top navbar-expand navbar-light" style="margin-top:55px; background: #fff">
		<div class='container'>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item mr-3"><a class="nav-link" href="{{ route('dashboard.index') }}"><i class='fa fa-bar-chart'></i> Dashboard</a></li>
					<li class="nav-item mr-3"><a class="nav-link" href="{{ route('user.index') }}"><i class='fa fa-users'></i> User</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class='container'  style='margin-top:130px'>
		@alerts()
	</div>


	{{-- CONTENT --}}
	<div class='container px-4'>
		<div class='float-right'>
			@stack('page_actions')
		</div>

		<h5 class='text-muted pt-2'>
			{{ $title ?? 'title' }}
			
			@if (isset($subtitle))
				<small class='text-muted'><br>{{ $subtitle ?? 'subtitle' }}</small>
			@endif
		</h5>
	</div>

	<div class='container mt-4' id='app'>
		@stack('content')
	</div>

	<div class='container mt-5 mb-5 pt-5'>
	</div>

	<script src="{{ mix('/js/app.js') }}" ></script>

</body>
</html>

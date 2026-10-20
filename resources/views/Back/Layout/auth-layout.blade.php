
<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>@yield('pageTitle')</title>

		<!-- Site favicon -->
		@php 
			$general_settings = \App\Models\GeneralSetting::first(); 
			$favicon = $general_settings && $general_settings->blog_favicon ? asset('images/settings/' . $general_settings->blog_favicon) : asset('Back/vendors/images/favicon-32x32.png');
		@endphp
		<link
			rel="apple-touch-icon"
			sizes="180x180"
			href="{{ $favicon }}"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="{{ $favicon }}"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="{{ $favicon }}"
		/>

		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/core.css') }}" />
		<link
			rel="stylesheet"
			type="text/css"
			href="{{ asset('Back/vendors/styles/icon-font.min.css') }}"
		/>
		<link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/style.css') }}" />

		@stack('styles')

		<style>
			/* Smooth Page Transitions */
			body {
				animation: pageFadeIn 0.4s ease-in-out;
			}
			@keyframes pageFadeIn {
				from {
					opacity: 0;
					transform: translateY(10px);
				}
				to {
					opacity: 1;
					transform: translateY(0);
				}
			}
		</style>
	</head>
	<body class="login-page">
		<div class="login-header box-shadow">
			<div
				class="container-fluid d-flex justify-content-between align-items-center"
			>
				<div class="brand-logo">
				<a href="login.html">
					@php $general_settings = \App\Models\GeneralSetting::first(); @endphp
					<img src="{{ $general_settings && $general_settings->blog_logo ? asset('images/settings/' . $general_settings->blog_logo) : asset('Back/vendors/images/deskapp-logo.svg') }}" alt="" style="max-height: 45px; width: auto;" />
				</a>
			</div>
				<div class="login-menu">
					
				</div>
			</div>
		</div>
		<div
			class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
		>
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6 col-lg-7">
						<img src="{{ asset('Back/vendors/images/login-page-img.png') }}" alt="" />
					</div>
					<div class="col-md-6 col-lg-5">
						@yield('content')
					</div>
				</div>
			</div>
		</div>
		
		<!-- js -->
		<script src="{{ asset('Back/vendors/scripts/core.js') }}"></script>
		<script src="{{ asset('Back/vendors/scripts/script.min.js') }}"></script>
		<script src="{{ asset('Back/vendors/scripts/process.js') }}"></script>
		<script src="{{ asset('Back/vendors/scripts/layout-settings.js') }}"></script>
		@stack('scripts')
	</body>
</html>


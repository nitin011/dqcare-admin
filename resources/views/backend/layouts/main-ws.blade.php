<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
	<title>@yield('title','') | {{ getSetting('app_name') }}</title>
	<!-- initiate head with meta tags, css and script -->
	@include('backend.include.head')

</head>
<body id="app"style="overflow-x:hidden !important" >
	<div class="wrapper">
		@if(!request()->routeIs('panel.setting.maintanance') == true)
			@include('backend.include.header')
			<div class="page-wrap">
				<!-- initiate sidebar-->

				<div class="main-content px-4">
					@include('backend.include.logged-in-as')
					<!-- yeild contents here -->
					@yield('content')
				</div>

				<!-- initiate chat section-->
				{{-- @include('backend.include.chat') --}}


				<!-- initiate footer section-->
				{{-- @include('backend.include.footer') --}}

			</div>
		@endif
    </div>
    
	<!-- initiate modal menu section-->
	@include('backend.include.modalmenu')

	<!-- initiate scripts-->
	@include('backend.include.script')	
</body>
</html>
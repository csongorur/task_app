<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Tasks</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
		<link rel="stylesheet" href="{{ asset('css/site.css') }}">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		@yield('content-scripts')
	</head>
	<body>
		@include('components._header')
		<div class="container marginT30">
			<div class="row">
				@yield('content')
			</div>
			<div class="row">
				<div id="alert-container"><div class="alert"></div></div>
			</div>
		</div>

		@if (Session::has('success_msg'))
        <script type="text/javascript">	<!--
            jQuery(document).ready(function($) {
                var alert_container = $('#alert-container');
                alert_container.find('.alert').attr('class', '').addClass('alert alert-success').html('{{ Session::get('success_msg') }}')
                alert_container.slideDown().delay(4000).slideUp();
            });
            //-->
        </script>
	    @endif

	    @if (Session::has('error_msg'))
	        <script type="text/javascript">	<!--
	            jQuery(document).ready(function($) {
	                var alert_container = $('#alert-container');
	                alert_container.find('.alert').attr('class', '').addClass('alert alert-danger').html('{{ Session::get('error_msg') }}');
	                alert_container.slideDown().delay(4000).slideUp();
	            });
	            //-->
	        </script>
	    @endif
	</body>
</html>

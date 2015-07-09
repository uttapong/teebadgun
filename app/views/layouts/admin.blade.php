<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

<title>@yield('title', 'Teebadgun.com: Administrator')</title>

<!-- Bootstrap core CSS -->

<link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/teebadgun.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/bootstrap-formhelpers.min.css') }}" rel="stylesheet">

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-formhelpers.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/nicEdit.js') }}"></script>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
@section('script')
@show
@section('style')
@show
</head>
<body>
<div class="container">
<div class="row">


	<div class="col-md-3 left">
		<ul class="nav nav-pills nav-stacked">
		  <li class="active"><a href="{{route('admin')}}">Home</a></li>
		  <li><a href="{{route('admin')}}">Content</a></li>
		  <li><a href="#">Badges</a></li>
		</ul>
	</div>

	<div class="col-md-8 left col-md-offset-1">
		<div class="row">
        @section('content')
        
		@show
	</div>
	</div>
</div>
</div>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootbox.min.js') }}"></script>
</body>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ config('app.name', 'Laravel') }}</title>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Sistem Informasi Peramalan Penjualan">
	<meta name="author" content="Ahmad Nur Fawaid">
	<meta name="love" content="Crafted with ♥ by Ahmad Nur Fawaid">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ Auth::user()->id }}">
    <meta name="user-nama" content="{{ Auth::user()->nama }}">
	<meta name="user-role" content="{{ Auth::user()->role }}">

    <!-- favicon -->
    <link href="{{ asset('favicon.png') }}" rel="shortcut icon">

	<!-- styles -->
	<link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <!-- fonts -->
    <link href="{{ asset('fonts/skripsweet.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('fonts/circular.css') }}" rel="stylesheet"> -->

    <!-- vendors -->
    <link href="{{ asset('css/vendor/metismenu.min.css') }}" rel="stylesheet">

	<!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="app">
        <div class="wrapper">
            <sidebar></sidebar>
            <router-view></router-view>
        </div>
    </div>

    <!-- scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- vendors -->
    <script src="{{ asset('js/vendor/metismenu.min.js') }}"></script>
    <script src="{{ asset('js/vendor/slimscroll.min.js') }}"></script>

    <script>
        $(function() {
            $('#menu').metisMenu({
                toggle: false
            });
        });
        $('.slimscroll').slimScroll({
            height: $('.sidebar').height()+'px',
            color: '#465368'
        })
    </script>
</body>
</html>
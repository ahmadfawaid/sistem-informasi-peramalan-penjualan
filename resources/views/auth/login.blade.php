<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login - {{ config('app.name', 'Laravel') }}</title>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Sistem Informasi Peramalan Penjualan">
	<meta name="author" content="Ahmad Nur Fawaid">
	<meta name="love" content="Crafted with ♥ by Ahmad Nur Fawaid">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- favicon -->
    <link href="{{ asset('favicon.png') }}" rel="shortcut icon">

	<!-- styles -->
	<link href="{{ asset('css/login.css') }}" rel="stylesheet">

    <!-- fonts -->
    <link href="{{ asset('fonts/skripsweet.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/circular.css') }}" rel="stylesheet">

	<!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <?php
        date_default_timezone_set("Asia/Jakarta");
        $hour = date("G", time());
        $text = '';

        if ($hour >= 0 && $hour <= 11) {
            $text = "Selamat Pagi";
        } elseif ($hour >= 12 && $hour <= 14) {
            $text = "Selamat Siang";
        } elseif ($hour >= 15 && $hour <= 17) {
            $text = "Selamat Sore";
        } elseif ($hour >= 17 && $hour <= 23) {
            $text = "Selamat Malam";
        }
    ?>
    <div class="wrapper">
        <div class="left">
            <div class="logo">
                <img src="{{ asset('images/logo-single.svg') }}">
                <span class="title">Klinik Pratama</span>
                <span class="subtitle">Rolas Medika</span>
            </div>
        </div>
        <div class="right">
            <div class="content">
                <div class="heading">
                    <h2 class="title">Halo,</h2>
                    <span class="subtitle">{{ $text }}</span>
                </div>
                <form class="form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label class="label">username</label>
                        <input type="text" name="username" class="input" value="{{ old('username') }}" placeholder="masukkan username anda">
                        @if ($errors->has('username'))
                            <span class="help">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="label">password</label>
                        <input type="password" name="password" class="input password" placeholder="masukkan password anda">
                        @if ($errors->has('password'))
                            <span class="help">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <button type="submit" class="button">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ url('img/ic/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ url('img/ic/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('img/ic/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('img/ic/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url('img/ic/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url('img/ic/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url('img/ic/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('img/ic/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('img/ic/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ url('img/ic/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('img/ic/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ url('img/ic/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('img/ic/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ url('img/ic/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ url('img/ic/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <title> @yield('title'){{ config('app.name', '') }}</title>

    @section('header')
        @include('default.components.header')
    @show

</head>

<body class="fixed-header" style="background-color: #f2f2f2;overflow-x: hidden">

@yield('button')
<div style="background: rgba(0,0,0,.8);min-height: 100vh;">
    <div class="lock-container full-height">
        <div class="container-sm-height full-height sm-p-t-50">
            <div class="row row-sm-height">
                <div class="col-sm-10 col-sm-height col-middle">

                    @yield("content")

                </div>
            </div>
        </div>
    </div>
    <div class="row text-center">
        <div class="text-white small" style="margin-top: 5.5vh;font-family: 'Lato', sans-serif;">
            Copyright &copy; 2017 Vendu Media Creative, All rights reserved
        </div>
    </div>
</div>

@section('scripts')
    @include('default.components.script')
    @stack('script')

</body>
</html>

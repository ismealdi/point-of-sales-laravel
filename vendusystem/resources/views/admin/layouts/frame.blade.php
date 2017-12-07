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


    <title>{{ config('app.name', '') }} - @yield('title')</title>

    @section('header')
        @include('admin.components.header')
    @show

</head>

<body class="fixed-header dashboard" onload="startTime();">
<nav class="page-sidebar" data-pages="sidebar">
    <div class="sidebar-header"></div>

    <div class="sidebar-menu">
        <ul class="menu-items">
            @include('admin.components.menus')
        </ul>
        <div class="clearfix"></div>
    </div>
</nav>

<div class="page-container" >
    <div class="header">
        <div class="container-fluid relative">
            <div class="pull-left full-height visible-sm visible-xs">
                <div class="header-inner">
                    <a class="btn-link toggle-sidebar visible-sm-inline-block visible-xs-inline-block padding-5" data-toggle="sidebar" href="#"><span class="icon-set menu-hambuger"></span></a>
                </div>
            </div>


            <div class="pull-center">
                <div class="header-inner">
                    <div class="brand inline">{{ config('app.name', '') }}</div>
                </div>
            </div>

            <div class=" pull-right">
                <div class="header-inner">
                    <div class="dropdown pull-right" style="">
                        <button aria-expanded="false" aria-haspopup="true" class="profile-dropdown-toggle fs-16" data-toggle="dropdown" type="button"><span class="semi-bold p-t-10 font-heading">
                <i class="fa fa-user" style="background:#ddd;width: 25px;height: 25px;border-radius: 25px;padding: 5px;
                text-align: center;color: #fff;"></i></span></button>

                        <ul class="dropdown-menu profile-dropdown" role="menu">
                            <li>
                                <a class="clearfix" href="{{ url('admin/setting') }}"><i class="pg-settings_small"></i> Settings</a>
                                <a class="clearfix" href="{{ url('logout') }}"><i class="pg-power"></i> Sign Out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="page-content-wrapper">
        <div class="content">
            <div class="container-fluid container-fixed-lg">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    @yield("title", "Title")
                                </div>
                                <div class="pull-right">
                                    <div class="col-xs-12 no-padding">
                                        <div class="export-options-container"></div>
                                    </div>
                                </div>

                                <p>@yield("description", "") &nbsp; @yield('button')</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @yield("content")

        </div>

        <!-- MODAL STICK UP DELETE  -->
        <div class="modal fade stick-up" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Hapus <span class="semi-bold">Data?</span></h5>
                    </div>
                    <div class="modal-body text-center">
                        <button class="btn btn-danger btn-sm" onclick="hapus()">Ya, hapus</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade stick-up" id="modalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm alert-warning">
                <div class="modal-content">
                    <div class="modal-header p-b-25">
                        <h5>Data Sudah <span class="semi-bold">Tersimpan!</span></h5>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.components.footer')
    </div>

</div>



@section('scripts')
    @include('admin.components.script')
    <script>
        $(document).ajaxStart(function() { Pace.restart(); });
        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            $('.timess').html("<div class='row'><div class='col-xs-4 no-padding'><div class='time-box'>" + h + "</div></div><div class='col-xs-4 no-padding'><div class='time-box'>" + m + "</div></div><div class='col-xs-4 no-padding'><div class='time-box'>" + s + "</div></div></div>");
            var t = setTimeout(startTime, 500);
        }

        function checkTime(i) {
            if (i < 10) {i = "0" + i};
            return i;
        }

    </script>
    @stack('script')
</body>
</html>

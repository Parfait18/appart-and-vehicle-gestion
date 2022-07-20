<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Gestion Dashboard</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
    <link rel="icon" href="{{ asset('assets/img/logo_resto.png') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">

    <!-- Template CSS -->

    <script type="text/javascript" src="{{ asset('assets/js/jquery-3.6.0.min.js') }}" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-11.3.min.js') }}"></script>


    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">


    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">

    <!-- Template CSS -->
    <!-- Start GA -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>


    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>

    <style>
        .navbar-bg {
            background-color: rgb(163 10 10 / 75%);
        }

        .main-sidebar .sidebar-menu li.active a {
            color: rgb(163 10 10 / 75%);
        }

        body.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
            box-shadow: 0 4px 8px #acb5f6;
            background-color: #c82d35;
            color: #fff;
        }

        .btn-primary,
        .btn-primary.disabled {
            background-color: #48aaff !important;
            font-size: 15px;
            padding: 6px;
            border-color: #48aaff !important;

        }

        .btn-primary:hover,
        .btn-primary.disabled :hover {
            background-color: #48aaff !important;
            font-size: 15px;
            padding: 6px;
            border-color: #48aaff !important;

        }

        .btn-danger {
            background-color: rgb(163 10 10 / 75%);
            font-size: 15px;

        }

        bg-primary {

            background-color: #38bd4e !important;
        }

        .badge.badge-success,
        .btn-success,
        .btn-success.disabled {
            background-color: #05af21 !important;
            padding: -6px;
            padding-top: 6px;
            padding-right: 6px;
            padding-bottom: 6px;
            padding-left: 6px;
        }



        .custum-border {
            /* background: linear-gradient(to right, #06a3da 4px, transparent 4px) 0 0,
                linear-gradient(to right, #06a3da 4px, transparent 4px) 0 100%,
                linear-gradient(to left, #06a3da 4px, transparent 4px) 100% 0,
                linear-gradient(to left, #06a3da 4px, transparent 4px) 100% 100%,
                linear-gradient(to bottom, #06a3da 4px, transparent 4px) 0 0,
                linear-gradient(to bottom, #06a3da 4px, transparent 4px) 100% 0,
                linear-gradient(to top, #06a3da 4px, transparent 4px) 0 100%,
                linear-gradient(to top, #06a3da 4px, transparent 4px) 100% 100%;

            background-repeat: no-repeat;
            background-size: 20px 20px; */
            background-color: #edecef;
            transition: all 0.5s;
            text-align: center;
            /* offset-x | offset-y | blur-radius | spread-radius | color */
            box-shadow: rgba(0, 0, 0, 0.56) 0px 2px 5px 2px;
            background-color: #edecef;
        }

        .custum-border:hover {
            text-align: center;
            /* offset-x | offset-y | blur-radius | spread-radius | color */
            box-shadow: rgba(0, 0, 0, 0.56) 0px 0px 1px 2px;

        }

        .card-title {
            text-align: center;
        }

        * {
            font-weight: 900 !important;
            font-size: 1rem;
        }

        /*
        #first-card {
            background-color: #48aaff;
            color: white !important;
        }

        #second-card {
            background-color: #ffb100;
            color: white !important;
        }

        #third-card {
            background-color: #20b941;
            color: white !important;
        }

        #forth-card {
            background-color: #48aaff;
            color: white !important;
        }

        #first-card {
            background-color: #48aaff;
            color: white !important;
        }

        .text-muted {
            color: #ffffff !important;
        } */
    </style>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @include('partials.navbar')

            @include('partials.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>

        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>


    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/cleave-js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('assets/modules/cleave-js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/page/index.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>


</body>

</html>

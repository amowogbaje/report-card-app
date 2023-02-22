
<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{URL::asset('assets/vendor/fonts/circular-std/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{URL::asset('assets/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/charts/chartist-bundle/chartist.css') }}">
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/charts/morris-bundle/morris.css') }}">
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/charts/c3charts/c3.css') }}">
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/fonts/flag-icon-css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/inputmask/css/inputmask.css') }}">
    <style>
        body {
            background-image: url("{{URL::asset('assets/images/background-grey.jpg') }}");
            background-position: center center;
            background-size: cover;
        }
    </style>
    {{-- <script src="{{URL::asset('assets/vendor/easy-v-toast-master/dist/toast.min.css') }}"></script> --}}
    <script src="{{URL::asset('assets/vendor/easy-v-toast-master/dist/toast.with.css.js') }}"></script>
    @livewireStyles
    <title>{{config('app.name')}}</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            @if(Auth::user()->role == 'admin')
                @include('layouts.admin-header-navigation')
            @endif
            @if(Auth::user()->role == 'teacher')
                @include('layouts.teacher-header-navigation')
            @endif
            @if(Auth::user()->role == 'student')
                @include('layouts.student-header-navigation')
            @endif
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            @if(Auth::user()->role == 'admin')
                @include('layouts.admin-menu-navigation')
            @endif
            @if(Auth::user()->role == 'teacher')
                @include('layouts.teacher-menu-navigation')
            @endif
            @if(Auth::user()->role == 'student')
                @include('layouts.student-menu-navigation')
            @endif
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="container-fluid py-5 my-5">
                        <div class="row">
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-10 col-10 mx-auto">
                                <div class="card">
                                    {{-- <img class="card-img-top img-fluid" src="{{URL::asset('assets/images/holidays.png')}}" alt="Card image cap"> --}}
                                    <div class="card-body">
                                        <h3 class="display-3 card-title text-center">Kindly Come back</h3>
                                        <p class="display-5 card-text text-center">The school has not yet activated the session</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer fixed-bottom">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                             Copyright © 2018 Concept. All rights reserved. Dashboard by <a href="https://colorlib.com/wp/">Colorlib</a>.
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="{{URL::asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <!-- bootstap bundle js -->
    <script src="{{URL::asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <!-- slimscroll js -->
    <script src="{{URL::asset('assets/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
    <!-- main js -->
    <script src="{{URL::asset('assets/libs/js/main-js.js') }}"></script>
    <!-- chart chartist js -->
    <script src="{{URL::asset('assets/vendor/charts/chartist-bundle/chartist.min.js') }}"></script>
    <!-- sparkline js -->
    <script src="{{URL::asset('assets/vendor/charts/sparkline/jquery.sparkline.js') }}"></script>
    <!-- morris js -->
    <script src="{{URL::asset('assets/vendor/charts/morris-bundle/raphael.min.js') }}"></script>
    <script src="{{URL::asset('assets/vendor/charts/morris-bundle/morris.js') }}"></script>
    <!-- chart c3 js -->
    <script src="{{URL::asset('assets/vendor/charts/c3charts/c3.min.js') }}"></script>
    <script src="{{URL::asset('assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
    <script src="{{URL::asset('assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>
    <script src="{{URL::asset('assets/libs/js/dashboard-ecommerce.js') }}"></script>
    <script src="{{URL::asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    @livewireScripts

    
</body>
 
</html>

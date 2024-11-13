
<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <!-- Favicon -->
    <link href="{{URL::asset('assets/images/favicon.ico') }}" rel="shortcut icon" />
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">
    <!--<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">-->
    {{-- <script src="{{URL::asset('assets/vendor/easy-v-toast-master/dist/toast.min.css') }}"></script> --}}
    <script src="{{URL::asset('assets/vendor/easy-v-toast-master/dist/toast.with.css.js') }}"></script>
    <style>
        /*label{margin-left: 20px;}*/
        #datepicker{width:100%; margin:none;}
        #datepicker > span:hover{cursor: pointer;}
    </style>
    @stack('css')
    
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
                    {{ $slot }}
                    
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer fixed-bottom">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                             Copyright © 2023 Grace Filled College. All rights reserved. Dashboard by <a href="https://academicreportcard.gracefilledcollege.com">Grace Filled College</a>.
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
    <!--<script src="{{URL::asset('assets/vendor/charts/chartist-bundle/chartist.min.js') }}"></script>-->
    <!-- sparkline js -->
    <script src="{{URL::asset('assets/vendor/charts/sparkline/jquery.sparkline.js') }}"></script>
    <!-- morris js -->
    <script src="{{URL::asset('assets/vendor/charts/morris-bundle/raphael.min.js') }}"></script>
    <!--<script src="{{URL::asset('assets/vendor/charts/morris-bundle/morris.js') }}"></script>-->
    <!-- chart c3 js -->
    <!--<script src="{{URL::asset('assets/vendor/charts/c3charts/c3.min.js') }}"></script>-->
    <!--<script src="{{URL::asset('assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>-->
    <!--<script src="{{URL::asset('assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>-->
    <!--<script src="{{URL::asset('assets/libs/js/dashboard-ecommerce.js') }}"></script>-->
    <script src="{{URL::asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{URL::asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="{{URL::asset('assets/vendor/datatables/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{URL::asset('assets/vendor/datatables/js/data-table.js') }}" data-turbo-eval="true" data-turbolinks-eval="true"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.min.js"></script>
    <!--<script src="{{URL::asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    
    @livewireScripts

    
    <script>
        // const toast = new EasyToast();
        let config = {
            duration: 4,
            position: 'top-right',
            hasCloseButton: false
        }

        toast.configure(config)
        // toast.success("Hello it's easy success toast!")
        // toast.show('Here we are');
        
        document.addEventListener('DOMContentLoaded', () => {
            this.livewire.on('toast:success', data => {
                toast.success(data.text)
                $(data.modalID).modal('hide');
            })
            this.livewire.on('toast:warning', data => {
                toast.warning(data.text)
                $(data.modalID).modal('hide');
            })
            this.livewire.on('toast:notify', data => {
                toast.notify(data.text)
                // $(data.modalID).modal('hide');
            })
            this.livewire.on('swal:notify', data => {
                Swal.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.text,
                    footer: data.footer
                })
            })
            this.livewire.on('toast:failure', data => {
                toast.danger(data.text)
                $(data.modalID).modal('hide');
            })
            this.livewire.on('toast:closeModal', data => {
                $(data.modalID).modal('hide');
            })

            this.livewire.on('swal:confirm', data => {
                SwalConfirm(data.type, data.title, data.text, data.confirmText, data.method, data.params,
                    data.callback)
            })

            this.livewire.on('swal:alert', data => {
                Swal.fire(data)
            })
            this.livewire.on('reload', () => {
                $('table.first').DataTable();
            })
            
        })
        
        
        

        
        

        window.addEventListener('teacher-added', event => {
            alert('Save Event Fired: ');
        })
        
        </script>
    <script>
            document.getElementById('stamp_img_file').addEventListener('change', function (event) {
                var file = event.target.files[0];
                var reader = new FileReader();
    
                reader.onload = function (e) {
                    document.getElementById('stamp_img_url_hidden').src = e.target.result;
    
                    // Wait for the image to load
                    document.getElementById('stamp_img_url_hidden').onload = function () {
                        extractColor();
                    };
                };
    
                reader.readAsDataURL(file);
            });
    
            function extractColor() {
                var image = document.getElementById('stamp_img_url_hidden');
                var colorThief = new ColorThief();
                var dominantColor = colorThief.getColor(image);
                var hexColor = rgbToHex(dominantColor[0], dominantColor[1], dominantColor[2]);
    
                $('#school_colors').val(hexColor);
                Livewire.emit('updateSchoolColor', hexColor);
            }
    
            function rgbToHex(r, g, b) {
                return '#' + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
            }
    </script>
    @yield('extra-script')
    @stack('js')
</body>
 
</html>
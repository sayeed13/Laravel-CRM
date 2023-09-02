<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex">

        <title>{{ config('app.name', 'Wolf CRM') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="favicon.io">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.min.css') }}">
		
		<!-- Lineawesome CSS -->
        <link rel="stylesheet" href="{{ URL::asset('assets/css/line-awesome.min.css') }}">

        <!-- Select2 CSS -->
        <link rel="stylesheet" href="{{ URL::asset('assets/css/select2.min.css') }}">

        <!-- Datetimepicker CSS -->
        <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap-datetimepicker.min.css') }}">

        <!-- Datatable CSS -->
		<link rel="stylesheet" href="{{ URL::asset('assets/css/dataTables.bootstrap4.min.css') }}">

        <!-- Tagsinput CSS -->
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
		
		<!-- Chart CSS -->
		<link rel="stylesheet" href="{{ URL::asset('assets/plugins/morris/morris.css') }}">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
        
        @yield('styles')
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
	
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
        

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .page-wrapper > .content {
                padding-top: 0px;
            }
            .page-header {
                margin-bottom: 10px;
            }
            .submit-section {
                text-align: center;
                margin-top: 15px;
            }
            .dash-widget-info {
                margin-top: 12px;
            }
            .punch-hours {
                height: 150px !important;
                width: 150px !important;
            }
            .agent-label {
                margin-right: 10px;
            }
            .agent-name {
                margin-right: 5px;
            }
        </style>
    </head>


    <body>
        
        
        
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			@include('layouts.header')
			
			@include('layouts.sidebar');
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                            <!-- Page Heading -->
                    @if (isset($header))
                        <div class="page-header">
                            <div class="row">
                                <div class="col-sm-12">
                                    {{ $header }}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{ $slot }}
				
				</div>
				<!-- /Page Content -->

            </div>
			<!-- /Page Wrapper -->
			
        </div>
		<!-- /Main Wrapper -->

        
        <!-- jQuery -->
        <script src="{{ URL::asset('assets/js/jquery-3.5.1.min.js') }}"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="{{ URL::asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
		
		<!-- Slimscroll JS -->
		<script src="{{ URL::asset('assets/js/jquery.slimscroll.min.js') }}"></script>

        <!-- Select2 JS -->
        <script src="{{ URL::asset('assets/js/select2.min.js') }}"></script>

        <!-- Datetimepicker JS -->
        <script src="{{ URL::asset('assets/js/moment.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>

        <!-- Tagsinput JS -->
        <script src="{{ URL::asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>

        <!-- Datatable JS -->
		<script src="{{ URL::asset('assets/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ URL::asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
		
		<!-- Chart JS -->
		<script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/morris/morris.min.js') }}"></script>
		<script src="{{ URL::asset('assets/js/chart.js') }}"></script>
        <script src="//cdn.jsdelivr.net/spinjs/1.3.0/spin.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
        
        
        {{-- pusher.js --}}
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        
        
		@yield('script')
		<!-- Custom JS -->
		<script src="{{ URL::asset('assets/js/app.js') }}"></script>
        
        
    </body>
</html>

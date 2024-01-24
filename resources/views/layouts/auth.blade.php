<!DOCTYPE html>

<html lang="en" class="default-style">

<head>
    <title>Frobel Dashboard</title>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900"
        rel="stylesheet">

    <!-- Icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/open-iconic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/pe-icon-7-stroke.css') }}">

    <!-- Core stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" class="theme-settings-bootstrap-css">
    <link rel="stylesheet" href="{{ asset('assets/css/appwork.css') }}" class="theme-settings-appwork-css">
    <link rel="stylesheet" href="{{ asset('assets/css/theme-corporate.css') }}" class="theme-settings-theme-css">
    <link rel="stylesheet" href="{{ asset('assets/css/colors.css') }}" class="theme-settings-colors-css">
    <link rel="stylesheet" href="{{ asset('assets/css/uikit.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    @yield('styles')
    {{-- <link rel="" href="{{ asset('css/admin.css') }}"> --}}

    <!-- Load polyfills -->
    <script src="{{ asset('assets/js/polyfills.js') }}"></script>
    <script>
        document['documentMode'] === 10 && document.write(
            '<script src="https://polyfill.io/v3/polyfill.min.js?features=Intl.~locale.en"><\/script>')
    </script>

    <script src="{{ asset('assets/js/material-ripple.js') }}"></script>
    <script src="{{ asset('assets/js/layout-helpers.js') }}"></script>

    <!-- Theme settings -->
    <!-- This file MUST be included after core stylesheets and layout-helpers.js in the <head> section -->

    <style>
        #nav-color {
            background-color: #2f3337a3 !important;
        }

        body {
            /* background-image: url('{{ asset('img/istockphoto-539953664-612x612.jpg') }}'); */
            background-image: url('');


            background-repeat: no-repeat;
            background-position: 250px -30px;
            background-size: auto 130%;
            background-attachment: fixed;
            /* background-position: center center; */
            /* background-position: 160px -30px; */
            height: 900px;
        }

        .foot {
            margin-left: 350px !important;
        }

        <style>.sidenav-menu {
            display: none;
            list-style: none;
            padding-left: 15px;
            /* Adjust as needed for indentation */
            margin-left: 10px;
            /* Adjust margin for left positioning */
        }

        .sidenav-item.active .sidenav-menu {
            display: block;
            animation: slideIn 0.3s ease;
            /* Adjust animation duration and easing */
        }

        /* Styles for menu items */
        .sidenav-item,
        .sidenav-item.hover:hover {
            margin-left: -5px;
            cursor: pointer;
            background-color: #0d74f5;
            color: white;
        }

        .sidenav-link {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: inherit;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                margin-left: -10px;
                /* Starting position for left positioning */
            }

            to {
                opacity: 1;
                margin-left: 10px;
                /* Final position for left positioning */
            }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.sidenav-toggle').click(function() {
                $(this).parent().toggleClass('active');
                $(this).next('.sidenav-menu').slideToggle(); /* Use slideToggle for smooth animation */
            });
        });
    </script>
    <!-- Core scripts -->
    <script src="{{ asset('assets/js/pace.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Libs -->
    <link rel="stylesheet" href="{{ asset('assets/css/perfect-scrollbar.css') }}">
</head>

<body>


    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">

            <!-- Layout sidenav -->
            <div id="layout-sidenav nav-color" class="layout-sidenav sidenav sidenav-vertical bg-primary"
                style="background-color:#0d74f5 !important;
            ">

                <!-- Brand demo (see assets/css/demo/demo.css) -->
                <div class="app-brand demo">
                    <span class="" style="margin-left: 20px;">
                        <img src="{{ asset('img/logo4-img.png') }}" width="35px" alt="Frobel Logo">
                    </span>
                    <a href="{{ route('admin.home') }}"
                        class="app-brand-text demo sidenav-text font-weight-normal ml-2" style="margin-left: 15px;">
                        @if (auth()->user())
                            {{-- @foreach (auth()->user()->roles as $role)
                                @if ($role->name == 'Super Admin')
                                    Super Admin
                                @elseif ($role->name == 'Admin')
                                    Admin
                                @elseif ($role->name == 'Supervisor')
                                    Supervisor
                                @else
                                    User
                                @endif
                            @endforeach --}}

                            @if (Auth::user()->usertype == 'Master-User')
                                Master Admin
                            @endif

                            @if (Auth::user()->usertype == 'Admin')
                                Admin
                            @endif

                            @if (Auth::user()->usertype == 'Supervisors')
                                Supervisor
                            @endif
                            @if (Auth::user()->usertype == 'student')
                            Parents Dashboard
                        @endif
                        @endif
                    </a>
                    <a href="javascript:void(0)" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
                        <i class="ion ion-md-menu align-middle"></i>
                    </a>
                </div>
                <style>
                    .hover a:hover {
                        background-color: #e4e4e4;
                        transform: scale(1.1);
                    }
                </style>
                <div class="sidenav-divider mt-0"></div>

                <!-- Links -->

                @if(Auth::user()->password != 'khadijaamina')
                @if(Auth::user()->password != 'irfanfinance')

                @if (auth()->user() )
                    <ul class="sidenav-inner  py-1">

                        @if (auth()->user()->usertype == 'Office' ||
                                auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Admin' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'Resources' ||
                                auth()->user()->usertype == 'TimeTable')
                            <li class="sidenav-item hover {{ request()->is('admin/home') ? 'active' : '' }}">
                                <a href="{{ route('admin.home') }}" class="sidenav-link active"
                                    onmouseover="this.style.backgroundColor='white';
                        this.style.color='#2a72d6';"
                                    onfocus="this.style.color='red';" onblur="this.style.color='2px solid grey';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                         this.style.color='white';">
                                    <i class="sidenav-icon ion ion-md-speedometer"></i>
                                    <div>Dashboard</div>
                                </a>
                            </li>
                        @endif

                        {{-- <li class="sidenav-divider mb-1"></li> --}}


                        {{-- @foreach (auth()->user()->roles as $role)
                            @if ($role->name == 'Attendance' || $role->name == 'Super Admin' || $role->name == 'Admin' || $role->name == 'Supervisor') --}}


                        @if (auth()->user()->usertype == 'Office' ||
                                auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'TimeTable')
                            {{-- <li
                                class="sidenav-item hover {{ Route::currentRouteName() == 'admin.attendance.index' ? 'active' : '' }}">
                                <a href="{{ route('admin.attendance.index') }}" class="sidenav-link"
                                    onmouseover="this.style.backgroundColor='white';
                                    this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                                     this.style.color='white';"><i
                                        class="sidenav-icon fas fa-user"></i>
                                    <div>Attendance </div>
                                </a>
                            </li> --}}
                        @endif

                        @if (auth()->user()->usertype == 'Office' ||
                                auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'Resources' ||
                                auth()->user()->usertype == 'TimeTable')
                            <li class="sidenav-item hover">
                                <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"
                                    onmouseover="this.style.backgroundColor='white';
                                        this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                                        this.style.color='white';"><i
                                        class="sidenav-icon fas fa-chalkboard-teacher"></i>
                                    <div>Attendence</div>
                                </a>
                                <ul class="sidenav-menu" style=" margin-left: -20px;">
                                    <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.attendance.index' ? 'active' : '' }}"">
                                        <a href="{{ route('admin.attendance.index') }}" class="sidenav-link">
                                            <div><i class="fas fa-user"></i> Attendance</div>
                                        </a>
                                    </li>
                                    <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.attendance.view' ? 'active' : '' }}">
                                        <a href="{{ route('admin.attendance.view') }}" class="sidenav-link">
                                            <div><i class="fas fa-eye"></i> View Attendance
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            {{-- <li
                                class="sidenav-item hover {{ Route::currentRouteName() == 'admin.attendance.view' ? 'active' : '' }}">
                                <a href="{{ route('admin.attendance.view') }}" class="sidenav-link"
                                    onmouseover="this.style.backgroundColor='white';
                                    this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                                     this.style.color='white';"><i
                                        class="sidenav-icon fas fa-eye"></i>
                                    <div>View Attendance </div>
                                </a>

                            </li> --}}
                        @endif
                        {{--  @endforeach --}}




                        {{-- @foreach (auth()->user()->roles as $role) --}}
                        {{-- @if ($role->name == 'Super Admin') --}}
                        @if (auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User' ||

                                auth()->user()->usertype == 'TimeTablez')
                            <li
                                class="sidenav-item hover {{ Route::currentRouteName() == 'admin.user.index' ? 'active' : '' }}">
                                <a href="{{ route('admin.user.index') }}" class="sidenav-link"><i
                                        class="sidenav-icon fas fa-user"></i>
                                    <div>Add Users</div>
                                </a>
                            </li>
                        @endif
                        {{-- @endforeach --}}


                        {{-- @foreach (auth()->user()->roles as $role) --}}
                        {{-- @if ($role->name == 'Admin' || $role->name == 'Super Admin') --}}
                        @if (auth()->user()->usertype == 'Office' ||
                                auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Admin' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'Resources' ||
                                auth()->user()->usertype == 'TimeTable')
                            {{-- <li class="sidenav-header small font-weight-semibold">ELEMENTS</li> --}}


                            <li
                                class="sidenav-item hover {{ Route::currentRouteName() == 'admin.admission.index' ? 'active' : '' }}">
                                <a href="{{ route('admin.admission.index') }}" class="sidenav-link"
                                    onmouseover="this.style.backgroundColor='white';
                                    this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                                     this.style.color='white';">
                                    <i class="sidenav-icon fas fa-search"></i>
                                    <div>Search Student</div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User')
                            <li
                                class="sidenav-item hover {{ Route::currentRouteName() == 'admin.role.index' ? 'active' : '' }}">
                                <a href="{{ route('admin.role.index') }}" class="sidenav-link"
                                    onmouseover="this.style.backgroundColor='white';
                                    this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                                     this.style.color='white';"><i
                                        class="sidenav-icon fas fa-address-card"></i>
                                    <div>Add Roles</div>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'TimeTable')
                            <li
                                class="sidenav-item hover {{ Route::currentRouteName() == 'subjects.index' ? 'active' : '' }}">
                                <a href="{{ route('subjects.index') }}" class="sidenav-link"
                                    onmouseover="this.style.backgroundColor='white';
                                    this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                                     this.style.color='white';"><i
                                        class="sidenav-icon fas fa-address-card"></i>
                                    <div>Add Subjects</div>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Admin' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'Office' ||
                                auth()->user()->usertype == 'TimeTable')
                            <li
                                class="sidenav-item hover {{ Route::currentRouteName() == 'admin.admission.create' ? 'active' : '' }}">
                                <a href="{{ route('admin.admission.create') }}" class="sidenav-link"
                                    onmouseover="this.style.backgroundColor='white';
                                    this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                                     this.style.color='white';"><i
                                        class="sidenav-icon fas fa-book"></i>
                                    <div>Admission</div>
                                </a>
                            </li>
                        @endif
                        {{-- @endforeach --}}




                        {{-- @foreach (auth()->user()->roles as $role) --}}
                        {{-- @if ($role->name == 'Student Fee' || $role->name == 'Super Admin' || $role->name == 'Admin') --}}
                        @if (auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Admin' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'TimeTable')
                            {{-- <li
                                class="sidenav-item hover {{ Route::currentRouteName() == 'admin.payment.create' ? 'active' : '' }}">
                                <a href="{{ route('admin.payment.create') }}" class="sidenav-link"
                                    onmouseover="this.style.backgroundColor='white';
                                    this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                                     this.style.color='white';"><i
                                        class="sidenav-icon fab fa-paypal"></i>
                                    <div>Pay Student Fee</div>
                                </a>
                            </li> --}}
                        @endif
                        @if(auth()->user()->username == 'yen'||
                        auth()->user()->username == 'ayo'||
                        auth()->user()->username == 'Jo'||
                        auth()->user()->username == 'jo'||
                        auth()->user()->username == 'Fozia'||
                        auth()->user()->username == 'fozia'||
                        auth()->user()->usertype == 'Office' ||
                        auth()->user()->username == 'amber')

                        <li class="sidenav-item hover">
                            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"
                                onmouseover="this.style.backgroundColor='white';
                        this.style.color='#2a72d6';"
                                onmouseout="this.style.backgroundColor='#0d74f5';
                        this.style.color='white';"><i
                                    class="sidenav-icon ffab fa-paypal"></i>
                                <div>Payments</div>
                            </a>

                            <ul class="sidenav-menu" style=" margin-left: -35px;">

                                <li
                                    class="sidenav-item hover {{ Route::currentRouteName() == 'admin.payment.create' ? 'active' : '' }}">
                                    <a href="{{ route('admin.payment.create') }}" class="sidenav-link">
                                        <div><i class="fas fa-dollar-sign"></i> Pay Student Fee</div>
                                    </a>
                                </li>
                                @if(auth()->user()->username == 'ayo' || (auth()->user()->username == 'yen') || auth()->user()->usertype == 'Office' )
                            <li
                            class="sidenav-item hover {{ Route::currentRouteName() == 'admin.payment.previous' ? 'active' : '' }}">
                            <a href="{{ route('admin.payment.previous') }}" class="sidenav-link">
                                <div><i class="far fa-money-bill-alt"></i> Previous Payments
                                </div>
                            </a>
                            </li>
                            @if(auth()->user()->username == 'ayo')
                            <li
                            class="sidenav-item hover {{ Route::currentRouteName() == 'admin.defaulter.list' ? 'active' : '' }}">
                            <a href="{{ route('admin.defaulter.list') }}" class="sidenav-link"
                              >
                                <div><i class="fas fa-money-check"></i> Defaulter List</div>
                            </a>
                        </li>
                        @endif
                            @endif
                            </ul>

                        </li>


                        @endif







                        @if (auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'Resources' ||
                                auth()->user()->usertype == 'Office' ||
                                auth()->user()->usertype == 'TimeTable')
                            <li class="sidenav-item hover">
                                <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"
                                    onmouseover="this.style.backgroundColor='white';
                                    this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                                     this.style.color='white';"><i
                                        class="sidenav-icon fas fa-chalkboard-teacher"></i>
                                    <div>Student Tests</div>
                                </a>

                                <ul class="sidenav-menu" style=" margin-left: -35px;">

                                    <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.student.test.manual.create' ? 'active' : '' }}">
                                        <a href="{{ route('admin.student.test.manual.create') }}"
                                            class="sidenav-link">
                                            <div><i class="fas fa-plus"></i> Add Record</div>
                                        </a>
                                    </li>

                                    <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.student.test.create' ? 'active' : '' }}">
                                        <a href="{{ route('admin.student.test.create') }}" class="sidenav-link">
                                            <div><i class="fas fa-plus"></i> Add Records <small>(excel)</small>
                                            </div>
                                        </a>
                                    </li>

                                    <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.student.test.index' ? 'active' : '' }}">
                                        <a href="{{ route('admin.student.test.index') }}" class="sidenav-link">
                                            <div><i class="fas fa-eye"></i> View Records</div>
                                        </a>
                                    </li>

                                    <li class="sidenav-item hover">
                                        <a href="{{ route('admin.comment.index') }}" class="sidenav-link"
                                            onmouseover="this.style.backgroundColor='white';
                                            this.style.color='#2a72d6';">
                                            <div><i class="fas fa-comment"></i> Teacher Comments</div>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif

                        @if (auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User'
                                // auth()->user()->usertype == 'Admin' ||
                                // auth()->user()->usertype == 'Supervisors' ||
                                // auth()->user()->usertype == 'TimeTable'
                                )

                            <li class="sidenav-item hover">
                                <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"
                                    onmouseover="this.style.backgroundColor='white';
        this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
         this.style.color='white';"><i
                                        class="sidenav-icon ffab fa-paypal"></i>
                                    <div>Payments</div>
                                </a>

                                <ul class="sidenav-menu" style=" margin-left: -35px;">
                                    @if (auth()->user()->usertype == 'Master-Admin' ||
                                    auth()->user()->usertype == 'Master-User' ||
                                    auth()->user()->usertype == 'Admin' ||
                                    auth()->user()->usertype == 'Supervisors' ||
                                    auth()->user()->usertype == 'TimeTable')
                                    <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.payment.create' ? 'active' : '' }}">
                                        <a href="{{ route('admin.payment.create') }}" class="sidenav-link">
                                            <div><i class="fas fa-dollar-sign"></i> Pay Student Fee</div>
                                        </a>
                                    </li>
                                    @endif
                                    @if (auth()->user()->usertype == 'Master-Admin' ||
                                    auth()->user()->usertype == 'Master-User'
                                 )
                                    <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.payment.previous' ? 'active' : '' }}">
                                        <a href="{{ route('admin.payment.previous') }}" class="sidenav-link">
                                            <div><i class="far fa-money-bill-alt"></i> Previous Payments
                                            </div>
                                        </a>
                                    </li>
                                    @endif
                                    @if (auth()->user()->usertype == 'Master-Admin' ||
                                    auth()->user()->usertype == 'Master-User'
                                    )

                                    <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.payment.old' ? 'active' : '' }}">
                                        <a href="{{ route('admin.payment.old') }}" class="sidenav-link">
                                            <div><i class="fas fa-eye"></i> Track Payments</div>
                                        </a>
                                    </li>

                                    <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.payment.export' ? 'active' : '' }}">
                                        <a href="{{ route('admin.payment.export') }}" class="sidenav-link"
                                          >
                                            <div><i class="fas fa-money-check"></i> Payment Export</div>
                                        </a>
                                    </li>

                                    <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.defaulter.list' ? 'active' : '' }}">
                                        <a href="{{ route('admin.defaulter.list') }}" class="sidenav-link"
                                          >
                                            <div><i class="fas fa-money-check"></i> Defaulter List</div>
                                        </a>
                                    </li>

                                    @endif

                                    @if (
                                    auth()->user()->usertype == 'Master-User' ||

                                    auth()->user()->usertype == 'Supervisors' ||
                                    auth()->user()->usertype == 'TimeTable' ||
                                    auth()->user()->username == 'admin')

                                    <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.payment.log.form' ? 'active' : '' }}">
                                        <a href="{{ route('admin.payment.log.form') }}" class="sidenav-link"
                                        >
                                            <div><i class="fas fa-money-check-alt"></i> Payment Logs</div>
                                        </a>
                                    </li>
                                    @endif





                                </ul>
                            </li>


                        @endif

                        @if (auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Admin' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'TimeTable')

                        @endif

                        @if (auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'TimeTable')

                        @endif
                        {{-- @endforeach --}}
                        @if (auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Admin' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'Resources' ||
                                auth()->user()->usertype == 'Office' ||
                                auth()->user()->usertype == 'TimeTable')
                            <li class="sidenav-item hover">
                                <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"
                                    onmouseover="this.style.backgroundColor='white';
this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
this.style.color='white';"><i
                                        class="sidenav-icon fas fa-clock"></i>
                                    <div>TimeTable</div>
                                </a>

                                <ul class="sidenav-menu" style=" margin-left: -35px;">

                                    <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.timetable.index' ? 'active' : '' }}">
                                        <a href="{{ route('admin.timetable.index') }}" class="sidenav-link">
                                            <div><i class="fas fa-calendar-alt"></i> Manage Timetable</div>
                                        </a>
                                    </li>

                                    <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.timetable.view' ? 'active' : '' }}">
                                        <a href="{{ route('admin.timetable.view') }}" class="sidenav-link">
                                            <div><i class="fas fa-calendar-check"></i> View Timetable
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        @endif

                        @if (auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'TimeTable')

                        @endif

                        @if (auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'TimeTable' ||
                                auth()->user()->usertype == 'Office' ||
                                auth()->user()->usertype == 'Admin')

                            <li class="sidenav-item hover">
                                <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"
                                    onmouseover="this.style.backgroundColor='white';
                            this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                            this.style.color='white';"><i
                                        class="sidenav-icon fas fa-calendar"></i>
                                    <div>Staff Management</div>
                                </a>

                                <ul class="sidenav-menu" style=" margin-left: -35px;">

                                    <li
                                        class="sidenav-item hover  {{ Route::currentRouteName() == 'admin.teacher.roster' ? 'active' : '' }}">
                                        <a href="{{ route('admin.teacher.roster') }}" class="sidenav-link">
                                            <div><i class="fas fa-calendar"></i> Teacher Roster</div>
                                        </a>
                                    </li>

                                </ul>
                                </li>

                        @endif
                        {{-- @endforeach --}}



                        {{-- @foreach (auth()->user()->roles as $role) --}}
                        {{-- @if ($role->name == 'Student Fee' || $role->name == 'Super Admin' || $role->name == 'Admin') --}}
                        @if (auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'TimeTable')
                            <li
                                class="sidenav-item hover {{ Route::currentRouteName() == 'admin.system.log' ? 'active' : '' }}">
                                <a href="{{ route('admin.system.log') }}" class="sidenav-link"
                                    onmouseover="this.style.backgroundColor='white';
                                    this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                                     this.style.color='white';"><i
                                        class="sidenav-icon fa fa-history"></i>
                                    <div>Logs</div>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'TimeTable')

                        @endif
                            @if (auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'TimeTable')
                            <li
                                class="sidenav-item hover  {{ Route::currentRouteName() == 'user.note.index' ? 'active' : '' }} ">
                                <a href="{{ route('user.note.index') }}" class="sidenav-link"
                                    onmouseover="this.style.backgroundColor='white';
                        this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                         this.style.color='white';"><i
                                        class="sidenav-icon fas fa-sticky-note "></i>
                                    <div>Diaries</div>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->usertype == 'Master-Admin' ||
                                auth()->user()->usertype == 'Master-User' ||
                                auth()->user()->usertype == 'Supervisors' ||
                                auth()->user()->usertype == 'Resources' ||
                                auth()->user()->usertype == 'Office' ||
                                auth()->user()->usertype == 'TimeTable')


                                 <li class="sidenav-item hover">
                                    <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"
                                        onmouseover="this.style.backgroundColor='white';
                                this.style.color='#2a72d6';"
                                        onmouseout="this.style.backgroundColor='#0d74f5';
                                this.style.color='white';"><i
                                            class="sidenav-icon fa fa-file"></i>
                                        <div>Reports</div>
                                    </a>

                                    <ul class="sidenav-menu" style=" margin-left: -35px;">

                                        <li
                                            class="sidenav-item hover  {{ Route::currentRouteName() == 'student.report' ? 'active' : '' }}">
                                            <a href="{{ route('student.report') }}" class="sidenav-link">
                                                <div><i class="fa fa-file"></i> Students Reports</div>
                                            </a>
                                        </li>
                                        <li
                                        class="sidenav-item hover  {{ Route::currentRouteName() == 'teacher.report' ? 'active' : '' }}">
                                        <a href="{{ route('teacher.report') }}" class="sidenav-link">
                                            <div><i class="fa fa-file"></i> Teacher Reports</div>
                                        </a>
                                    </li>

                                    </ul>
                                    </li>

                            {{-- <li class="sidenav-item hover  ">
                                <a href="{{ route('student.report') }}" class="sidenav-link"
                                    onmouseover="this.style.backgroundColor='white';
                        this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                         this.style.color='white';"><i
                                        class="sidenav-icon fa fa-file "></i>
                                    <div>Reports</div>
                                </a>
                            </li> --}}
                            @if( auth()->user()->usertype !== 'Resources' && auth()->user()->usertype !== 'Office' )
                            <li class="sidenav-item hover  ">
                                <a href="{{ route('student.ActiveInactive') }}" class="sidenav-link"
                                    onmouseover="this.style.backgroundColor='white';
                        this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                         this.style.color='white';"><i
                                        class="sidenav-icon fa fa-file "></i>
                                    <div>Active/Inactive Students</div>
                                </a>
                            </li>
                            @endif
                            <li class="sidenav-item hover  ">
                                <a href="{{ route('student.logins') }}" class="sidenav-link"
                                    onmouseover="this.style.backgroundColor='white';
                        this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                         this.style.color='white';"><i
                                        class="sidenav-icon fa fa-file "></i>
                                    <div>Student Logins</div>
                                </a>
                            </li>
                        @endif

                    </ul>
                    {{--khadija check comment--}}
                    @endif
                @endif
                @endif

                @if(Auth::user()->password == 'khadijaamina' || Auth::user()->username == 'finance')
                <ul class="sidenav-inner  py-1">
                    <li class="sidenav-item hover {{ request()->is('admin/home') ? 'active' : '' }}">
                        <a href="{{ route('admin.home') }}" class="sidenav-link active"
                            onmouseover="this.style.backgroundColor='white';
                this.style.color='#2a72d6';"
                            onfocus="this.style.color='red';" onblur="this.style.color='2px solid grey';"
                            onmouseout="this.style.backgroundColor='#0d74f5';
                 this.style.color='white';">
                            <i class="sidenav-icon ion ion-md-speedometer"></i>
                            <div>Dashboard</div>
                        </a>
                    </li>
                    <li
                    class="sidenav-item hover {{ Route::currentRouteName() == 'admin.attendance.view' ? 'active' : '' }}">
                    <a href="{{ route('admin.attendance.view') }}" class="sidenav-link">
                        <div><i class="fas fa-eye"></i> View Attendance
                        </div>
                    </a>
                </li>
                <li
                class="sidenav-item hover {{ Route::currentRouteName() == 'admin.user.index' ? 'active' : '' }}">
                <a href="{{ route('admin.user.index') }}" class="sidenav-link"><i
                        class="sidenav-icon fas fa-user"></i>
                    <div>Add Users</div>
                </a>
            </li>
            <li
            class="sidenav-item hover {{ Route::currentRouteName() == 'admin.role.index' ? 'active' : '' }}">
            <a href="{{ route('admin.role.index') }}" class="sidenav-link"
                onmouseover="this.style.backgroundColor='white';
                this.style.color='#2a72d6';"
                onmouseout="this.style.backgroundColor='#0d74f5';
                 this.style.color='white';"><i
                    class="sidenav-icon fas fa-address-card"></i>
                <div>Add Roles</div>
            </a>
        </li>
        <li
        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.admission.create' ? 'active' : '' }}">
        <a href="{{ route('admin.admission.create') }}" class="sidenav-link"
            onmouseover="this.style.backgroundColor='white';
            this.style.color='#2a72d6';"
            onmouseout="this.style.backgroundColor='#0d74f5';
             this.style.color='white';"><i
                class="sidenav-icon fas fa-book"></i>
            <div>Admission</div>
        </a>
    </li>
    <li
    class="sidenav-item hover {{ Route::currentRouteName() == 'admin.admission.index' ? 'active' : '' }}">
    <a href="{{ route('admin.admission.index') }}" class="sidenav-link"
        onmouseover="this.style.backgroundColor='white';
        this.style.color='#2a72d6';"
        onmouseout="this.style.backgroundColor='#0d74f5';
         this.style.color='white';">
        <i class="sidenav-icon fas fa-search"></i>
        <div>Search Student</div>
    </a>
</li>
    <li
                            class="sidenav-item hover {{ Route::currentRouteName() == 'admin.payment.previous' ? 'active' : '' }}">
                            <a href="{{ route('admin.payment.previous') }}" class="sidenav-link">
                                <div><i class="far fa-money-bill-alt"></i> Previous Payments
                                </div>
                            </a>
                            </li>

                            <li
                            class="sidenav-item hover {{ Route::currentRouteName() == 'admin.payment.old' ? 'active' : '' }}">
                            <a href="{{ route('admin.payment.old') }}" class="sidenav-link">
                                <div><i class="fas fa-eye"></i> Track Payments</div>
                            </a>
                        </li>
                        <li
                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.payment.create' ? 'active' : '' }}">
                        <a href="{{ route('admin.payment.create') }}" class="sidenav-link">
                            <div><i class="fas fa-dollar-sign"></i> Pay Student Fee</div>
                        </a>
                    </li>
                        <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.payment.export' ? 'active' : '' }}">
                                        <a href="{{ route('admin.payment.export') }}" class="sidenav-link"
                                          >
                                            <div><i class="fas fa-money-check"></i> Payment Export</div>
                                        </a>
                                    </li>
                                    <li class="sidenav-item hover  ">
                                        <a href="{{ route('student.report') }}" class="sidenav-link"
                                            onmouseover="this.style.backgroundColor='white';
                                this.style.color='#2a72d6';"
                                            onmouseout="this.style.backgroundColor='#0d74f5';
                                 this.style.color='white';"><i
                                                class="sidenav-icon fa fa-file "></i>
                                            <div>Reports</div>
                                        </a>
                                    </li>
                                    <li class="sidenav-item hover  ">
                                        <a href="{{ route('student.ActiveInactive') }}" class="sidenav-link"
                                            onmouseover="this.style.backgroundColor='white';
                                this.style.color='#2a72d6';"
                                            onmouseout="this.style.backgroundColor='#0d74f5';
                                 this.style.color='white';"><i
                                                class="sidenav-icon fa fa-file "></i>
                                            <div>Active/Inactive Students</div>
                                        </a>
                                    </li>

                                    <li
                                    class="sidenav-item hover {{ Route::currentRouteName() == 'admin.payment.log.form' ? 'active' : '' }}">
                                    <a href="{{ route('admin.payment.log.form') }}" class="sidenav-link"
                                    >
                                        <div><i class="fas fa-money-check-alt"></i> Payment Logs</div>
                                    </a>
                                </li>
                                <li
                                class="sidenav-item hover {{ Route::currentRouteName() == 'admin.system.log' ? 'active' : '' }}">
                                <a href="{{ route('admin.system.log') }}" class="sidenav-link"
                                    onmouseover="this.style.backgroundColor='white';
                                    this.style.color='#2a72d6';"
                                    onmouseout="this.style.backgroundColor='#0d74f5';
                                     this.style.color='white';"><i
                                        class="sidenav-icon fa fa-history"></i>
                                    <div>Logs</div>
                                </a>
                            </li>
                            <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.timetable.view' ? 'active' : '' }}">
                                        <a href="{{ route('admin.timetable.view') }}" class="sidenav-link">
                                            <div><i class="fas fa-calendar-check"></i> View Timetable
                                            </div>
                                        </a>
                                    </li>
                                    <li
                                        class="sidenav-item hover {{ Route::currentRouteName() == 'admin.timetable.index' ? 'active' : '' }}">
                                        <a href="{{ route('admin.timetable.index') }}" class="sidenav-link">
                                            <div><i class="fas fa-calendar-alt"></i> Manage Timetable</div>
                                        </a>
                                    </li>


                </ul>
                @endif




            </div>


            <!-- / Layout sidenav -->

            <!-- Layout container -->
            <div class="layout-container">
                <!-- Layout navbar -->
                <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-white container-p-x "
                    style="position: relative;top: -9px;height:110px" id="layout-navbar">

                    <!-- Brand demo (see assets/css/demo/demo.css) -->
                    <a href="{{ route('admin.home') }}" class="navbar-brand app-brand demo d-lg-none py-0 mr-4">
                        <span class="">
                            <img src="{{ asset('img/logo4-img.png') }}" width="35px" alt="Frobel Logo">
                        </span>
                        <span class="app-brand-text demo font-weight-normal ml-2">
                            @if (auth()->user())
                                {{-- @foreach (auth()->user()->roles as $role)
                                    @if ($role->name == 'Super Admin')
                                        Super Admin
                                    @elseif ($role->name == 'Admin')
                                        Admin
                                    @elseif ($role->name == 'Supervisor')
                                        Supervisor
                                    @else
                                        User
                                    @endif
                                @endforeach --}}
                                @if (Auth::user()->usertype == 'Master-User')
                                    Master Admin
                                @endif

                                @if (Auth::user()->usertype == 'Admin')
                                    Admin
                                @endif

                                @if (Auth::user()->usertype == 'Supervisors')
                                    Supervisor
                                @endif
                            @endif
                        </span>
                    </a>

                    <!-- Sidenav toggle (see assets/css/demo/demo.css) -->
                    <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto">
                        <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:void(0)">
                            <i class="ion ion-md-menu text-large align-middle"></i>
                        </a>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#layout-navbar-collapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="navbar-collapse collapse"
                        style=" background-image: linear-gradient(#393e42,#393e42);width: 100%;
                        margin-left: -32px; margin-right: -32px;"
                        id="layout-navbar-collapse">
                        <!-- Divider -->
                        <hr class="d-lg-none w-100 my-2">

                        <div class="navbar-nav align-items-lg-center" style="margin-left: auto !important">
                            <!-- Search -->
                            <label class="nav-item navbar-text navbar-search-box p-0 active">
                                {{-- <i class="ion ion-ios-search navbar-icon align-middle"></i> --}}
                                <span class="navbar-search-input pl-2">
                                    {{-- <input type="text" class="form-control navbar-text mx-2" placeholder="Search..." style="width:200px"> --}}
                                </span>
                            </label>
                            <div style="

                                margin: 20px 0;">

                                <img src="{{ asset('img/header.jpg') }}"
                                    style="height:70px !important;
                                        padding:10px !important;
                                         margin-left:50px;
                                         max-width: 100%;

                                         " />


                            </div>


                        </div>

                        <div class="navbar-nav align-items-lg-center ml-auto" style="margin-right:40px;">

                            <div class="demo-navbar-user nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                        <img src="{{ asset('img/avatars/user-default-img.png') }}" alt
                                            class="d-block ui-w-30 rounded-circle">
                                        <span class="px-1 mr-lg-2 ml-2 ml-lg-0">

                                            @auth
                                                {{ auth()->user()->name }}
                                            @else
                                                Guest
                                            @endauth
                                        </span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    {{-- <a href="javascript:void(0)" class="dropdown-item"><i class="ion ion-ios-person text-lightest"></i> &nbsp; My profile</a>
                  <a href="javascript:void(0)" class="dropdown-item"><i class="ion ion-ios-mail text-lightest"></i> &nbsp; Messages</a>
                  <a href="javascript:void(0)" class="dropdown-item"><i class="ion ion-md-settings text-lightest"></i> &nbsp; Account settings</a> --}}
                                    {{-- <div class="dropdown-divider"></div> --}}

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i
                                                class="ion ion-ios-log-out text-danger"></i> &nbsp; Log Out</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- / Layout navbar -->

                <!-- Layout content -->
                <div class="layout-content">

                    <!-- Content -->
                    @yield('content')
                    <!-- / Content -->

                    <!-- Layout footer -->
                    <nav class="layout-footer footer bg-footer-theme">
                        <div
                            class="container-fluid d-flex flex-wrap justify-content-between text-center container-p-x pb-3">
                            <div class="pt-3">
                                <span class="footer-text font-weight-bolder foot">Copyright © <span
                                        id="copy-year"></span> Frobel School Management System</span>
                            </div>
                        </div>
                    </nav>

                    <script>
                        var d = new Date();
                        var year = d.getFullYear();
                        document.getElementById("copy-year").innerHTML = year;
                    </script>
                    <!-- / Layout footer -->

                </div>
                <!-- Layout content -->

            </div>
            <!-- / Layout container -->

        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core scripts -->


    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/sidenav.js') }}"></script>
    <!-- Libs -->
    <script src="{{ asset('assets/js/perfect-scrollbar.js') }}"></script>
    @yield('scripts')
    <script src="{{ asset('assets/js/demo.js') }}"></script>
    <script>
        $("html").removeClass("layout-collapsed");
    </script>
</body>

</html>

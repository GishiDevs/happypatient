<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Happy Patient | @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Moment Plugin -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.1/dist/sweetalert2.all.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11 -->
  <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  
  <!-- Datatables Paginate button -->
  <style>
    .paginate_button{
      z-index:0;
    }
    .stepwizard-step p {
    margin-top: 0px;
    color:#666;
    }
    .stepwizard-row {
        display: table-row;
    }
    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
    }
    .stepwizard-step button[disabled] {
        /*opacity: 1 !important;
        filter: alpha(opacity=100) !important;*/
    }
    .stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
        opacity:1 !important;
        color:#bbb;
    }
    .stepwizard-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content:" ";
        width: 100%;
        height: 1px;
        background-color: #ccc;
        z-index: 0;
    }
    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }
    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }

  </style>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" href="{{ route('logout') }}"                
          onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{ asset('dist/img/siteicon4.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Happy Patient</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/user-default.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">@if(!empty(Auth::user()->name)) {{Auth::user()->name}} @endif</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/" class="nav-link {{ (request()->is('/')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('transactions.index') }}" class="nav-link {{ (request()->is('transactions')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Transactions
              </p>
            </a>
          </li>
          @canany(['patient-list','patient-create'])
          <li class="nav-item has-treeview {{ (request()->is('patient/create') || request()->is('patient/index') || request()->is('patient/edit/*') || request()->is('patient/history/*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('patient/create') || request()->is('patient/index') || request()->is('patient/edit/*') || request()->is('patient/history/*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-wheelchair"></i>
              <p>
                Patient
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('patient-create')
              <li class="nav-item">
                <a href="{{ route('patient.create') }}" class="nav-link {{ (request()->is('patient/create')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              @endcan
              @can('patient-list')
              <li class="nav-item">
                <a href="{{ route('patient.index') }}" class="nav-link {{ (request()->is('patient/index')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Patients Record</p>
                </a> 
              </li>
              @endcan
            </ul>
          </li>
          @endcanany
          @canany(['patientservices-list','patientservices-create'])
          <li class="nav-item has-treeview {{ (request()->is('patientservice/create') || request()->is('patientservice/index') || request()->is('patientservice/edit/*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('patientservice/create') || request()->is('patientservice/index') || request()->is('patientservice/edit/*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-stethoscope"></i>
              <p>
                Services
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('patientservices-create')
              <li class="nav-item">
                <a href="{{ route('patientservice.create') }}" class="nav-link {{ (request()->is('patientservice/create')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Services</p>
                </a>
              </li>
              @endcan
            </ul>
            <ul class="nav nav-treeview">
              @can('patientservices-list')
              <li class="nav-item">
                <a href="{{ route('patientservice.index') }}" class="nav-link {{ (request()->is('patientservice/index')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Services List</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcanany
          @canany(['user-list','user-create'])
          <li class="nav-item has-treeview {{ (request()->is('user/create') || request()->is('user/index') || request()->is('user/edit/*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('user/create') || request()->is('user/index') || request()->is('user/edit/*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-circle"></i>
              <p>
                User
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('user-create')
              <li class="nav-item">
                <a href="{{ route('user.create') }}" class="nav-link {{ (request()->is('user/create')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              @endcan
              @can('user-list')
              <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link {{ (request()->is('user/index')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users Record</p>
                </a> 
              </li>
              @endcan
            </ul>
          </li>
          @endcanany
          @canany(['service-list','service-create','serviceprocedure-list','serviceprocedure-create','permission-list','permission-create','role-list','role-create'])
          <li class="nav-item has-treeview {{ (request()->is('service/index') || request()->is('serviceprocedure/index') || request()->is('serviceprocedure/create') || request()->is('permission/index') || request()->is('role/index')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('service/index') || request()->is('serviceprocedure/index') || request()->is('serviceprocedure/create') || request()->is('permission/index') || request()->is('role/index')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @canany(['service-list','service-create'])
              <li class="nav-item">
                <a href="{{ route('service.index') }}" class="nav-link {{ (request()->is('service/index')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Services</p>
                </a> 
              </li>
              @endcanany
              @canany(['serviceprocedure-list','serviceprocedure-create'])
              <li class="nav-item">
                <a href="{{ route('serviceprocedure.index') }}" class="nav-link {{ (request()->is('serviceprocedure/index') || request()->is('serviceprocedure/create')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Service Procedures</p>
                </a> 
              </li>
              @endcanany
              @role('Admin')
              <li class="nav-item">
                <a href="{{ route('permission.index') }}" class="nav-link {{ (request()->is('permission/index')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permissions</p>
                </a> 
              </li>
              @endrole
              @canany(['role-list','role-create'])
              <li class="nav-item">
                <a href="{{ route('role.index') }}" class="nav-link {{ (request()->is('role/index')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roles</p>
                </a> 
              </li>
              @endcanany
            </ul>
          </li>
          @endcanany
          <li class="nav-item">
            <a href="/" class="nav-link {{ (request()->is('/logs')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Activity Logs
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  

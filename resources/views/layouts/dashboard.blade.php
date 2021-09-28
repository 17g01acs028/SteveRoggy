<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SynqAfrica</title>
 <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js">
  </script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js">
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
  <link href="https://cdn.datatables.net/1.10.17/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
  <script src="https://cdn.datatables.net/1.10.17/js/jquery.dataTables.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="{{url('vendor/sweetalert/sweetalert.all.js')}}"></script>
  <link rel="stylesheet" href="{{url('vendor/select2.min.css')}}">
  <link rel="stylesheet" href="{{url('vendor/select2-bootstrap4.min.css')}}">
  <script src="{{url('vendor/select2.min.js')}}"></script>



  <link rel="stylesheet" href="{{url('vendor/jquery.btnswitch.css')}}">
  <script src="{{url('vendor/jquery.btnswitch.js')}}"></script>

  <script src="{{url('vendor/table.js')}}"></script>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script> -->
  <script src="{{url('vendor/jstz.min.js')}}"></script>
  <script src="{{url('vendor/jquery.session.js')}}"></script>

  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

  <script src="{{url('vendor/moment/moment.min.js')}}"></script>
  <link rel="stylesheet" href="{{url('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <script src="{{url('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
  <link href="{{url('vendor/font-awesome-4.7.0/css/font-awesome.min.css')}}" rel="stylesheet" />

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

  <!-- Optional: include a polyfill for ES6 Promises for IE11 -->
  <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <!-- <link rel="stylesheet" href="{{url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}"> -->
  <!-- iCheck -->
  <link rel="stylesheet" href="{{url('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{url('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{url('plugins/summernote/summernote-bs4.css')}}">
    <!-- Scripts -->
    <script src="{{ asset('js/range.js') }}" defer></script>
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    @yield('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed" >

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <span title="set timezone"><i class="fas fa-globe-africa" aria-hidden="true"></i> {{ Auth::user()->timezone }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <div class="info">
                <h3 class="dropdown-item-title">
                  <strong>Profile Timezone</strong>
                </h3>
                <p class="text-md"> {{ Auth::user()->timezone }} </p>
              </div>
            </div>
            <!-- Message End -->
          </div>
          <div class="dropdown-divider"></div>
          <div class="card-footer" align="center ">
            <a href="{{ url('users') }}/{{ id(Auth::user()->id) }}/edit_user">Change Timezone</a>
          </div>
        </div>
      </li>
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <span title="user"><i class="fa fa-user" aria-hidden="true"></i></span>
        </a>
        <form id="myForm" method="POST" action="{{ route('logout') }}">
          @csrf
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{url('dist/img/missing.jpg')}}" class="img-size-70 mr-4 img-rectangle" alt="User Avatar">
              <div class="info">
                <h3 class="dropdown-item-title" style="color:blue;font-size:25px;">
                  <strong>{{ Auth::user()->username }}</strong>
                </h3>
                <p class="text-md" style="font-size:15px;"> <i>{{ Auth::user()->email }}</i> </p>
                <p class="text-md" style="text-transform: uppercase;">{{ Auth::user()->client->clientName }}</p>
                <p><a href="{{ url('users/show_user') }}/{{ id(Auth::user()->id) }}">My Profile</a></p>
                <p><a href="{{ url('users/show_client') }}/{{ id(Auth::user()->client_id) }}">Account Settings</a></p>
              </div>
            </div>
            <!-- Message End -->
          </div>
          <div class="dropdown-divider"></div>
          <div class="card-footer" align="right ">
            <a class="btn btn-default btn-sm" href="#" onclick="document.getElementById('myForm').submit();">Logout</a>
          </div>
        </div>
        </form>
      </li>

      <li class="nav-item">
        <form id="myForm1" method="POST" action="{{ route('logout') }}">
          @csrf
        <a class="nav-link" data-slide="true" href="#" onclick="document.getElementById('myForm1').submit();">
          <span title="logout"><i class="fas fa-sign-out-alt" aria-hidden="true"></i></span>
        </a>
        </form>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-slide="true" href="#">
          <img src="{{url('dist/img/synqimage.png')}}" alt="Synq Logo" class="brand-image elevation-0">
        </a>
      </li>
      <!-- Notifications Dropdown Menu -->
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

@include('layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    @include('sweetalert::alert')
    @include('flash-message')
        @yield('content')
  </div>

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="https://synqafrica.co.ke">SynqAfrica</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Contact Us:</b> support@synqafrica.co.ke
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script type="text/javascript">
//Initialize Select2 Elements
$('.select2').select2({
  theme: 'bootstrap4'
})
</script>

<script type="text/javascript">
  const url = window.location;
  /*remove all active and menu open classes(collapse)*/
  $('ul.nav-sidebar a').removeClass('active').parent().siblings().removeClass('menu-open');
  /*find active element add active class ,if it is inside treeview element, expand its elements and select treeview*/
  $('ul.nav-sidebar a').filter(function () {
      return this.href == url;
  }).addClass('active').closest(".has-treeview").addClass('menu-open').find("> a").addClass('active');

</script>

<!-- jQuery -->
<!-- jQuery UI 1.11.4 -->
<script src="{{url('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{url('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{url('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{url('plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{url('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{url('plugins/jqvmap/maps/jquery.vmap.world.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<!-- <script src="{{url('plugins/moment/moment.min.js')}}"></script> -->
<script src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<!-- <script src="{{url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script> -->
<!-- Summernote -->
<script src="{{url('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('dist/js/demo.js')}}"></script>
@yield('scripts')

</body>
</html>

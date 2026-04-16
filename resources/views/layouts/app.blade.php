<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png') }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  @stack('css')   
  <title>
    @if(View::hasSection('title'))

      {{-- @yield('title') - {{'|| AIA ||'}} --}}
      @yield('title') 
    @else
    
      
    @endif
  </title>
  {{-- <meta name="keywords" content="creative tim, html dashboard, html css dashboard, web dashboard, bootstrap 5 dashboard, bootstrap 5, css3 dashboard, bootstrap 5 admin, Material Dashboard bootstrap 5 dashboard, frontend, responsive bootstrap 5 dashboard, free dashboard, free admin dashboard, free bootstrap 5 admin dashboard"> --}}
  {{-- <meta name="description" content="Material Dashboard 2 is a beautiful Bootstrap 5 admin dashboard with a large number of components, designed to look beautiful and organized. If you are looking for a tool to manage and visualize data about your business, this dashboard is the thing for you."> --}}
  
  {{-- <meta name="twitter:card" content="product"> --}}
  {{-- <meta name="twitter:site" content="@creativetim"> --}}
  {{-- <meta name="twitter:title" content="Material Dashboard 2 by Creative Tim"> --}}
  {{-- <meta name="twitter:description" content="Material Dashboard 2 is a beautiful Bootstrap 5 admin dashboard with a large number of components, designed to look beautiful and organized. If you are looking for a tool to manage and visualize data about your business, this dashboard is the thing for you."> --}}
  {{-- <meta name="twitter:creator" content="@creativetim"> --}}
  {{-- <meta name="twitter:image" content="https://s3.amazonaws.com/creativetim_bucket/products/450/original/material-dashboard.jpg"> --}}
  
  {{-- <meta property="fb:app_id" content="655968634437471"> --}}
  {{-- <meta property="og:title" content="Material Dashboard 2 by Creative Tim" /> --}}
  {{-- <meta property="og:type" content="article" /> --}}
  {{-- <meta property="og:url" content="http://demos.creative-tim.com/material-dashboard/pages/dashboard.html" /> --}}
  {{-- <meta property="og:image" content="https://s3.amazonaws.com/creativetim_bucket/products/450/original/material-dashboard.jpg" /> --}}
  {{-- <meta property="og:description" content="Material Dashboard 2 is a beautiful Bootstrap 5 admin dashboard with a large number of components, designed to look beautiful and organized. If you are looking for a tool to manage and visualize data about your business, this dashboard is the thing for you." /> --}}
  {{-- <meta property="og:site_name" content="Creative Tim" /> --}}
  <!-- Twitter Card data -->

  <!-- Open Graph data -->
  <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/views_css/header_heartbeat.css')}}">
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
  integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
  crossorigin="anonymous"/> --}}


  <!--     Fonts and icons     -->

  {{-- <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script> --}}


  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
<script src="{{asset('assets/js/font.js')}}"></script>
  {{-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" /> --}}
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/css.css')}}" />
  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"> --}}
  {{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.min.css')}}" /> --}}
  <!-- CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/css/material-dashboard.min.css') }}">
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link rel="stylesheet" href="{{asset('assets/demo/demo.css') }}">
  <!-- Google Tag Manager -->
  {{-- <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-NKDMSK6');
  </script> --}}
  
  <!-- End Google Tag Manager -->


  <style>
    .sidebar .sidebar-wrapper {
      /* display: flex; */
      flex-direction: column;
      max-height: calc(100vh - 200px); /* Adjust based on your header height */
      overflow-y: auto; /* Enable vertical scrolling */
    }

    .sidebar .sidebar-wrapper .nav {
      flex-grow: 1; /* Allow nav to take available space */
      overflow-y: auto; /* Scroll inside nav if content overflows */
    }
    #dataTableBuilder{
        direction: rtl !important;
        font-size: 15px;
        font-weight: bold;
        
    }
    .card-body ,.card-body .row .form-group{
        direction:rtl;
        text-align:right;
    }
    .card-footer , .alert-danger{
        text-align:right;
    }
    .layout-fixed, .main-sidebar{
        direction: rtl;
    }
    .alert-success{
        text-align: center;
    }
    .layout-fixed ,.main-sidebar {
        right :0;
    }
    /* .sidebar-mini.sidebar-collapse .content-wrapper, .sidebar-mini.sidebar-collapse .main-footer, .sidebar-mini.sidebar-collapse .main-header{
        margin-right: 4.6rem!important;
    } */

    .ml-auto, .mx-auto {
        margin-right: auto!important;
        margin-left: 0!important;
    }
    .navbar-nav{
        padding-right: 0;
    }

    /* body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper, body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer, body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header{
        margin-right: 250px;
        margin-left: 0!important;
        transition: margin-left.3s ease-in-out;
    } */
    body{
        text-align: right;
        
    }
    .form-control{
        font-weight: bold !important;
    }
    .card-body, .card-body .row .form-group {
        font-size: medium;
    }
    /* .sidebar-mini .nav-sidebar, .sidebar-mini .nav-sidebar .nav-link, .sidebar-mini .nav-sidebar>.nav-header{
        display: -webkit-box;
    } */
    .main-footer {
        text-align: center;
    }

    div.dataTables_wrapper div.dataTables_filter{
        position: inherit;
        display: grid;

    }
    element.style {
        margin-left: 8px;
        margin-right: 8px;
    }
    .brand-link .brand-image {
        float: right;
    }
    div.dt-button-collection{
        position: initial;
        left: 0!important;
        
    }
    div.dt-button-collection div.dropdown-menu{
      display: contents !important;
    }
    .modal-dialog{
        margin :27.75rem auto;
    }

    .sidebar .sidebar-wrapper{
        direction: ltr;
    }
    .rtl .bootstrap-navbar .logo .simple-text, .rtl .sidebar .logo .simple-text{
        text-align: center;
    }
    .fixed-plugin{
        position: absolute;
        top: 8px;

    }
    
    .create{
        background-color: #007bff !important;
        color: white !important;
    }
    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 38px;
        user-select: none;
        -webkit-user-select: none;
    }


    .select2-container--default .select2-selection--single .select2-selection__rendered {
color: #444;
line-height: 20px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
color: #0a0000;
}
.select2-container--default .select2-selection--multiple .select2-selection__rendered{
    height: 38px;   
}
.select2-container--open .select2-dropdown--below{
        position: sticky;
        /* position: absolute;  */
        z-index: 9999;
    }
    .theme-light .select2-search__field {
        width:  -webkit-fill-available;
    } 
    .select2-selection--single .select2-selection__arrow{
        float: left;
        top:-15px;
    }
    .float-left {
    float: left;
}

.create{
background-color: #007bff;
color: white;
}

.bmd-form-group .form-control, .bmd-form-group input::placeholder, .bmd-form-group label{
  padding: 5px;
}
form .form-group select.form-control{
  padding: 5px;
}

.mb-2{
    background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;
}
h1{
    color:#9c27b0;
}

input[type="text"],
  input[type="number"],
  input[type="file"],
  select {
    height: 38px;
    font-size: medium;
  }

  .buttons-create:hover::after {
    content: "للاضافه اضغط +";
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-60%);
  padding: 5px 10px;
  background-color: rgba(0, 0, 0, 0.3); /* Set the background color with 30% opacity */
  color: #ffffff;
  font-size: 10px;
  border-radius: 4px;
  white-space: nowrap;
}

.btn-group a:hover {
        /* Add your hover styles here */
    }

    .get_receive_receipt:hover::after {
        /* Add styles specific to the get_receive_receipt button */
        /* content: "اذونات الاضافة من العميل"; */
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-60%);
  padding: 5px 10px;
  background-color: rgba(0, 0, 0, 0.3); /* Set the background color with 30% opacity */
  color: #ffffff;
  font-size: 10px;
  border-radius: 4px;
  white-space: nowrap;
    }

    .show:hover::after {
        /* content: "التفاصيل"; */
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-60%);
  padding: 5px 10px;
  background-color: rgba(0, 0, 0, 0.3); /* Set the background color with 30% opacity */
  color: #ffffff;
  font-size: 10px;
  border-radius: 4px;
  white-space: nowrap;
    }

    .edit:hover::after {
        /* content: "تعديل"; */
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-60%);
  padding: 5px 10px;
  background-color: rgba(0, 0, 0, 0.3); /* Set the background color with 30% opacity */
  color: #ffffff;
  font-size: 10px;
  border-radius: 4px;
  white-space: nowrap;
    }

    .destroy:hover::after {
        content: "حذف";
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-60%);
  padding: 5px 10px;
  background-color: rgba(0, 0, 0, 0.3); /* Set the background color with 30% opacity */
  color: #ffffff;
  font-size: 10px;
  border-radius: 4px;
  white-space: nowrap;
    }
    .print:hover::after {
        content: "طباعه";
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-60%);
  padding: 5px 10px;
  background-color: rgba(0, 0, 0, 0.3); /* Set the background color with 30% opacity */
  color: #ffffff;
  font-size: 10px;
  border-radius: 4px;
  white-space: nowrap;
    }

    table.dataTable>thead>tr>th:not(.sorting_disabled), table.dataTable>thead>tr>td:not(.sorting_disabled){
        padding-right: 30px !important;
        font-weight: 700;

    }
    .ps-scrollbar-y-rail{
      right: 0px !important;
    }
    .navbar-expand-lg .navbar-nav .dropdown-menu-right{
      right: auto !important;
      left: 0 !important;
    }

    .alert-container {
      display: flex;
      justify-content: center;
      align-items: center;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
    }

    /* Style the alert content */
    .alert-content {
      display: flex;
      align-items: center;
      gap: 8px; /* Space between icon and text */
      color: red; /* Red color for icon and text */
      padding: 8px 16px;
      background-color: rgba(255, 0, 0, 0.1); /* Light red background */
      border-radius: 4px;
      animation: fadeInOut 3s infinite; /* Fade in and out animation */
    }

    /* Heartbeat animation */
    @keyframes heartbeat {
      0% {
        transform: scale(1);
      }
      14% {
        transform: scale(1.3);
      }
      28% {
        transform: scale(1);
      }
      42% {
        transform: scale(1.3);
      }
      70% {
        transform: scale(1);
      }
    }

    /* Fade in and out animation */
    @keyframes fadeInOut {
      0% {
        opacity: 0;
      }
      50% {
        opacity: 1;
      }
      100% {
        opacity: 0;
      }
    }

    .heartbeat {
      animation: heartbeat 1.3s ease-in-out infinite;
    }

</style>
  @stack('third_party_stylesheets')

@stack('page_css')
</head>

<body class="g-sidenav-show rtl bg-gray-200">
  <!-- Extra details for Live View on GitHub Pages -->
  <!-- Google Tag Manager (noscript) -->
  {{-- <noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe>
  </noscript> --}}
  <!-- End Google Tag Manager (noscript) -->
  <div class="wrapper ">
    <div class="sidebar" data-color="rose" data-background-color="black" data-image="{{asset('assets/img/sidebar-1.jpg')}}">
      
      <div class="sidebar-wrapper">
        
        <ul class="nav">
          <li class="nav-item ">


            @include('layouts.menu_new')
            <div class="collapse" id="pagesExamples">
              <ul class="nav">

              </ul>
            </div>
          </li>

        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
              </button>
            </div>

          </div>

          <div class="collapse navbar-collapse justify-content-end">
            @if (session('database') == 'madco')
              <div class="alert-container">
                <div class="alert-content ">
                  <i class="material-icons">notification_important</i>
                  <span>{{ 'الموسم القديم' }}</span>
                </div>
              </div>
            @endif

            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <span>
                    {{auth()->user()->name}}
                    
                  </span>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  {{-- <a class="dropdown-item" href="#">الملف الشخصى</a> --}}
                  <a href="{{ route('users.edit', ['id' => auth()->user()->id]) }}" class="dropdown-item">
                    <span class="grid-nav-content">{{__('الملف الشخصي')}}</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    تسجيل خروج
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
                  
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          {{-- <div class="container-fluid"> --}}

            {{-- @if (session('database') == 'laundry_erp')
            <div style="color: #fff; background-color: #dc3545; text-align:center; height:45px; width:60%; margin: auto;">
                <h1 class="heart-beat" style="color: #fff;" >{{'انت الان داخل الموسم القديم (2024-2025)'}}</h1>
            </div>
            @endif --}}
                  @yield('content')
      
    
          {{-- </div> --}}
        </div>
      
  

        {{-- </div> --}}
      {{-- </div> --}}



      <footer class="footer">
        <div class="container-fluid">
    
          <div class="copyright">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script> Copyright  <i class="far fa-copyright"></i> 
            <a href="#">ERP</a>  All rights reserved.
          </div>
        </div>
    </footer>

   


    </div>
    {{-- <div class="ps-scrollbar-y" style="direction: ltr !important" > --}}
  </div>
  
  
    
  {{-- <div class="fixed-plugin">
    <div class="dropdown show-dropdown">
      <a href="#" data-toggle="dropdown">
        <i class="fa fa-cog fa-2x"> </i>
      </a>
      <ul class="dropdown-menu">
        <li class="header-title"> Sidebar Filters</li>
        <li class="adjustments-line">
          <a href="javascript:void(0)" class="switch-trigger active-color">
            <div class="badge-colors ml-auto mr-auto">
              <span class="badge filter badge-purple" data-color="purple"></span>
              <span class="badge filter badge-azure" data-color="azure"></span>
              <span class="badge filter badge-green" data-color="green"></span>
              <span class="badge filter badge-warning" data-color="orange"></span>
              <span class="badge filter badge-danger" data-color="danger"></span>
              <span class="badge filter badge-rose active" data-color="rose"></span>
            </div>
            <div class="clearfix"></div>
          </a>
        </li>
        <li class="header-title">Sidebar Background</li>
        <li class="adjustments-line">
          <a href="javascript:void(0)" class="switch-trigger background-color">
            <div class="ml-auto mr-auto">
              <span class="badge filter badge-black active" data-background-color="black"></span>
              <span class="badge filter badge-white" data-background-color="white"></span>
              <span class="badge filter badge-red" data-background-color="red"></span>
            </div>
            <div class="clearfix"></div>
          </a>
        </li>
        <li class="adjustments-line">
          <a href="javascript:void(0)" class="switch-trigger">
            <p>Sidebar Mini</p>
            <label class="ml-auto">
              <div class="togglebutton switch-sidebar-mini">
                <label>
                  <input type="checkbox">
                  <span class="toggle"></span>
                </label>
              </div>
            </label>
            <div class="clearfix"></div>
          </a>
        </li>
        <li class="adjustments-line">
          <a href="javascript:void(0)" class="switch-trigger">
            <p>Sidebar Images</p>
            <label class="switch-mini ml-auto">
              <div class="togglebutton switch-sidebar-image">
                <label>
                  <input type="checkbox" checked="">
                  <span class="toggle"></span>
                </label>
              </div>
            </label>
            <div class="clearfix"></div>
          </a>
        </li>
        <li class="header-title">Images</li>
        <li class="active">
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="../assets/img/sidebar-1.jpg" alt="">
          </a>
        </li>
        <li>
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="../assets/img/sidebar-2.jpg" alt="">
          </a>
        </li>
        <li>
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="../assets/img/sidebar-3.jpg" alt="">
          </a>
        </li>
        <li>
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="../assets/img/sidebar-4.jpg" alt="">
          </a>
        </li>


        <li class="header-title">Thank you </li>

      </ul>
    </div>
  </div> --}}

  
  <!--   Core JS Files   -->
  <script src="{{asset('assets/js/core/jquery.min.js') }}"></script>
  <script src="{{asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{asset('assets/js/core/bootstrap-material-design.min.js') }}"></script>
  <script src="{{asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<!-- Plugin for the momentJs  -->
<script src="{{asset('assets/js/plugins/moment.min.js') }}"></script>
<!--  Plugin for Sweet Alert -->
<script src="{{asset('assets/js/plugins/sweetalert2.js') }}"></script>
<!-- Forms Validations Plugin -->
<script src="{{asset('assets/js/plugins/jquery.validate.min.js') }}"></script>
<!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="{{asset('assets/js/plugins/jquery.bootstrap-wizard.js') }}"></script>
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="{{asset('assets/js/plugins/bootstrap-selectpicker.js') }}"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="{{asset('assets/js/plugins/bootstrap-datetimepicker.min.js') }}"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
<script src="{{asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="{{asset('assets/js/plugins/bootstrap-tagsinput.js') }}"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{{asset('assets/js/plugins/jasny-bootstrap.min.js') }}"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
{{-- <script src="{{asset('assets/js/plugins/fullcalendar.min.js') }}"></script> --}}
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="{{asset('assets/js/plugins/jquery-jvectormap.js') }}"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="{{asset('assets/js/plugins/nouislider.min.js') }}"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script> --}}
  <script src="{{asset('assets/js/core.js') }}"></script>

  <!-- Library for adding dinamically elements -->
  <script src="{{asset('assets/js/plugins/arrive.min.js') }}"></script>
  <!--  Google Maps Plugin    -->
  {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2Yno10-YTnLjjn_Vtk0V8cdcY5lC4plU"></script> --}}
  <!-- Place this tag in your head or just before your close body tag. -->
  {{-- <script async defer src="https://buttons.github.io/buttons.js"></script> --}}
  <script async defer src="{{asset('assets/js/buttons.js') }}"></script>

  <!-- Chartist JS -->
  <script src="{{asset('assets/js/plugins/chartist.min.js') }}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('assets/js/material-dashboard.min.js?v=2.1.0" type="text/javascript') }}"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="{{asset('assets/demo/demo.js') }}"></script>
  <script src="{{asset('js/select2.js')}}"></script>


  @stack('third_party_scripts')

  @stack('page_scripts')
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }

        }

        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>

  
 
  {{-- <script>
    $(document).ready(function() {
      md.initFullCalendar();
    });
  </script> --}}
  <script>
    $(document).ready(function() {
      $('.searchable').select2({
    });

    // Automatically detect and set dropdownParent for Select2 elements inside modals
    $('.searchable').each(function() {
        if ($(this).closest('.modal').length) {
            $(this).select2({
                dropdownParent: $(this).closest('.modal') // Set dropdownParent to the closest modal
            });
        }
    });
            
    });
    
    </script>
  @stack('js')
</body>

</html>
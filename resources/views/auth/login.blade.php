
{{-- ------------------------------------------------------------------------------------------------------------------------------- --}}
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Madco | تسجيل الدخول
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!-- Extra details for Live View on GitHub Pages -->
  <!-- Canonical SEO -->
  <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
  <!--  Social tags      -->
  <meta name="keywords" content="creative tim, html dashboard, html css dashboard, web dashboard, bootstrap 4 dashboard, bootstrap 4, css3 dashboard, bootstrap 4 admin, material dashboard bootstrap 4 dashboard, frontend, responsive bootstrap 4 dashboard, material design, material dashboard bootstrap 4 dashboard">
  <meta name="description" content="Material Dashboard PRO is a Premium Material Bootstrap 4 Admin with a fresh, new design inspired by Google's Material Design.">
  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="Material Dashboard PRO by Creative Tim">
  <meta itemprop="description" content="Material Dashboard PRO is a Premium Material Bootstrap 4 Admin with a fresh, new design inspired by Google's Material Design.">
  <meta itemprop="image" content="https://s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_thumbnail.jpg">
  <!-- Twitter Card data -->
  <meta name="twitter:card" content="product">
  <meta name="twitter:site" content="@creativetim">
  <meta name="twitter:title" content="Material Dashboard PRO by Creative Tim">
  <meta name="twitter:description" content="Material Dashboard PRO is a Premium Material Bootstrap 4 Admin with a fresh, new design inspired by Google's Material Design.">
  <meta name="twitter:creator" content="@creativetim">
  <meta name="twitter:image" content="https://s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_thumbnail.jpg">
  <!-- Open Graph data -->
  <meta property="fb:app_id" content="655968634437471">
  <meta property="og:title" content="Material Dashboard PRO by Creative Tim" />
  <meta property="og:type" content="article" />
  {{-- <meta property="og:url" content="http://demos.creative-tim.com/material-dashboard-pro/examples/dashboard.html" /> --}}
  <meta property="og:image" content="https://s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_thumbnail.jpg" />
  <meta property="og:description" content="Material Dashboard PRO is a Premium Material Bootstrap 4 Admin with a fresh, new design inspired by Google's Material Design." />
  <meta property="og:site_name" content="Creative Tim" />
  <!--     Fonts and icons     -->
  {{-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" /> --}}
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/css.css')}}" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../../assets/css/material-dashboard.min.css?v=2.1.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../../assets/demo/demo.css" rel="stylesheet" />

  <style>
    .input-group{
        margin-right: -20px;
    }
    .large-radio-buttons {
    display: flex;
    gap: 50px; /* Space between radio buttons */
}

.radio-button {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 12pt;
    margin-top:20px;
}

.radio-button input[type="radio"] {
    display: none; /* Hide the default radio button */
}

.radio-custom {
    width: 20px;
    height: 20px;
    border: 2px solid rgb(156, 39, 176);;
    border-radius: 50%;
    /* margin-right: 10px; */
    position: relative;
    transition: border-color 0.3s ease;
}

.radio-custom::after {
    content: '';
    width: 12px;
    height: 12px;
    background-color: rgb(156, 39, 176);;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0.3s ease;
}

.radio-button input[type="radio"]:checked + .radio-custom {
    border-color: rgb(156, 39, 176);;
}

.radio-button input[type="radio"]:checked + .radio-custom::after {
    transform: translate(-50%, -50%) scale(1);
}

.radio-label {
    color: #495057;
    padding:5px;
}
.radio-button:hover .radio-custom {
    border-color: rgb(156, 39, 176);;
}

.radio-button:hover .radio-label {
    color: rgb(156, 39, 176);;
}
  </style>
</head>

<body class="off-canvas-sidebar">
  <!-- Extra details for Live View on GitHub Pages -->

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
    <div class="container">
      
      <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
      </button>
     
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('../../assets/img/login.jpg'); background-size: cover; background-position: top center;">
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form method="POST" action="{{ route('login') }}">
                @csrf
              <div class="card card-login card-hidden">
                <div class="card-header card-header-rose text-center">
                    
                  <h4 class="card-title">تسجيل الدخول</h4>
                  
                </div>
                <div class="card-body" style="direction: rtl">
                    <div class="text-center mb-4">
                        <img src="{{asset('assets/img/faces/lundry.png') }}" alt="Logo" class="img-fluid" style="max-width: 120px;"> 
                    </div>
                    
                  {{-- <p class="card-description text-center">Or Be Classical</p> --}}
                  <span class="form-group mb-3">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">face</i>
                        </span>
                      </div>
                      <input type="text" style="text-align: center" name="username" id="username" class="form-control" placeholder="اسم المستخدم...." value="{{ old('username') }}" required autofocus >
                      <div class="invalid-feedback">
                        الرجاء إدخال اسم المستخدم.
                    </div>
                    </div>
                  </span>
                 
                  <span class="form-group mb-3">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">lock_outline</i>
                        </span>
                      </div>
                      <input type="password"  style="text-align: center" name="password" id="password" class="form-control" placeholder="كلمة المرور...." required>
                    </div>
                  </span>
                
                  <span class="form-group mb-3" hidden>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">storage</i>
                            </span>
                        </div>
                
                        <!-- Large Radio Buttons -->
                        <div class="large-radio-buttons" style="margin-left: 30px;">
                            {{-- <label class="radio-button">
                                <input type="radio" name="database" value="laundry_erp"  {{ old('database', 'laundry_erp') === 'laundry_erp' ? 'checked' : '' }} required>
                                <span class="radio-custom"></span>
                                <span class="radio-label">موسم قديم</span>
                            </label> --}}
                
                            <label class="radio-button">
                                <input type="radio" name="database" value="madco_26" {{ old('database', 'madco_26') === 'madco_26' ? 'checked' : '' }} required>
                                <span class="radio-custom"></span>
                                <span class="radio-label">موسم جديد</span>
                            </label>
                        </div>
                
                        @error('database')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </span>

                </div>
                {{-- <hr> --}}
        
                {{-- <label for="database" style="text-align: center;" >{{ __('اختر قاعدة البيانات') }}</label> --}}
              
                



                

                @if($errors->any())
                <div class="col-12" style="height: 30px; font-size:15px; font-weight:700;  color:red; background-color:transparent; text-align:center;" >{{$errors->first()}}</div>
                @endif

                <div class="card-footer justify-content-center">
                  {{-- <a href="#pablo" class="btn btn-rose btn-link btn-lg">Lets Go</a> --}}
                  <button type="submit" class="btn btn-primary" style="float: right;margin: 0 8rem;"> دخول</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
     
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="{{asset('assets/js/core/jquery.min.js') }}"></script>
  <script src="{{asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{asset('assets/js/core/bootstrap-material-design.min.js') }}"></script>
  <script src="{{asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>




  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('assets/js/material-dashboard.min.js?v=2.1.0" type="text/javascript') }}"></script>
  
 
 
 
  <script>
    $(document).ready(function() {

      // document.getElementById('div_select_database').style.display="block";

      md.checkFullPageBackgroundImage();
      setTimeout(function() {
        // after 1000 ms we add the class animated to the login/register card
        $('.card').removeClass('card-hidden');
      }, 700);
    });
  </script>
</body>

</html>

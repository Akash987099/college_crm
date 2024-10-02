
<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title> Admin Login</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="public//assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="public/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="public//assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="public//assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="public//assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- <script src="../assets/vendor/js/helpers.js"></script> -->
  <!-- <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfL72UpAAAAADTMEJczHyttGlAG3vFUaEJRHR8N"></script> -->
  <!-- Your code -->
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="public//assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    
                  </span>
                  <span class="app-brand-text demo text-body fw-bolder">
                      <img src="{{asset('public/frontend/logo.png')}}" style="width:200px;">
                  </span>
                </a>
              </div>
              <!-- /Logo -->
              <!-- <h4 class="mb-2">Welcome to Sneat! 👋</h4>
              <p class="mb-4">Please sign-in to your account and start the adventure</p> -->
              @if(session('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
@endif

@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

              <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
				@csrf
                <div class="mb-3">
                  <label for="email" class="form-label text-white">username</label>
                  <input
                    type="text"
                    class="form-control"
                    id="username"
                    value="{{ old('username') }}"
                    name="username"
                    placeholder="Enter your email"
                    autofocus
                  />
				  <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label text-white" for="password">Password</label>
                    <a href="auth-forgot-password-basic.html">
                      <small class="text-white">Forgot Password?</small>
                    </a>
                  </div>
                  
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />
					<x-input-error :messages="$errors->get('password')" class="mt-2" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                

               <div class="input-group input-group-merge">
            {!! captcha_img('flat') !!}
            <input id="captcha" type="text" class="form-control" name="captcha" required>
            @error('captcha')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
                
                <div class="mb-3">
                  <button type="submit" class="btn btn-primary d-grid w-100" type="submit">Login in</button>
                </div>
              </form>

            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <script src="public//assets/vendor/libs/jquery/jquery.js"></script>
    <script src="public/assets/vendor/libs/popper/popper.js"></script>
    <script src="public/assets/vendor/js/bootstrap.js"></script>
    <script src="public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="public/assets/vendor/js/menu.js"></script>
 
    <script src="public/assets/js/main.js"></script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>


@if(Auth::user()->user_type == 2)
{{Auth::logout()}}
@endif
<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{asset('assets/')}}"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>University</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('public/assets/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('public/assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('public/assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('public/assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <link rel="stylesheet" href="{{asset('public/assets/vendor/libs/apex-charts/apex-charts.css')}}" />

    <!-- Page CSS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>

    <script src="{{asset('public/assets/js/config.js')}}"></script>
    <script src="{{asset('public/assets/vendor/js/helpers.js')}}"></script>
    <script src="{{asset('public/assets/ckeditor/ckeditor.js')}}"></script>

    <!-- datatable -->

    <!-- Include jQuery -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<!-- datatable -->
<style>
  /* styles.css */
body {
    font-family: 'Times New Roman', Times, serif;
}
th{
      text-transform: capitalize!important;
      color:#fff!important;
      font-size: 15px!important;
    }
    dataTables_processing{
      color:#5F9EA0!important;
      display: block!important;
    }
    td{
      text-transform: capitalize!important;
      color:#000!important;
      font-size: 18px!important;
    }
    h5{
      color:#000!important;
      font-size: 18px!important;
    }
    label {
      color:#000!important;
      font-size: 14px!important;
      font-weight: bold!important;
      text-transform: capitalize!important;
    } 
    thead{
    backgroound-color:#5F9EA0!important;
    }
    i{
      font-size:20px!important;
    }
    a {
  text-decoration: none!important; /* no underline */
}
 .required{
  color: red; 
  
 }
</style>

  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="" class="app-brand-link">
              <span class="app-brand-logo demo">
           
              </span> 
              <span class="app-brand-text demo menu-text fw-bolder ms-2">
                  <img src="{{asset('public/frontend/logo.png')}}" style="width:200px;">
              </span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item ">
              <a href="{{route('admin_index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <!-- Layouts -->
            

            
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Masters</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{route('university')}}" class="menu-link">
                    <div data-i18n="Account">University</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{route('college-view')}}" class="menu-link">
                    <div data-i18n="Notifications">College</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{route('user')}}" class="menu-link">
                    <div data-i18n="Connections">User</div>
                  </a>
                </li>
              </ul>
            </li>

     @if(Auth::user()->user_type == 3)
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Common</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{route('country')}}" class="menu-link">
                    <div data-i18n="Account">Country</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{route('state')}}" class="menu-link">
                    <div data-i18n="Notifications">State</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{route('city')}}" class="menu-link">
                    <div data-i18n="Notifications">city</div>
                  </a>
                </li>

              </ul>
            </li>
                  @endif

            <li class="menu-item">
              <a href="{{route('program')}}" class="menu-link">
                <!-- <i class="menu-icon tf-icons bx bx-home-circle"></i> -->
                <i class="menu-icon fa fa-graduation-cap" aria-hidden="true"></i>
                <div data-i18n="Analytics">Program</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="{{route('view-facility')}}" class="menu-link">
                <!-- <i class="menu-icon tf-icons bx bx-home-circle"></i> -->
                <i class="menu-icon fa fa-graduation-cap" aria-hidden="true"></i>
                <div data-i18n="Analytics">Facility</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="{{route('articles')}}" class="menu-link">
                <!-- <i class="menu-icon tf-icons bx bx-home-circle"></i> -->
                <i class="menu-icon fa fa-graduation-cap" aria-hidden="true"></i>
                <div data-i18n="Analytics">Article</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="{{route('news')}}" class="menu-link">
                <!-- <i class="menu-icon tf-icons bx bx-home-circle"></i> -->
                <i class="menu-icon fa fa-graduation-cap" aria-hidden="true"></i>
                <div data-i18n="Analytics">News</div>
              </a>
            </li>

           @if(Auth::user()->user_type == 3)
            <li class="menu-item">
              <a href="{{route('contact')}}" class="menu-link">
                <!-- <i class="menu-icon tf-icons bx bx-home-circle"></i> -->
                <i class="menu-icon fa fa-graduation-cap" aria-hidden="true"></i>
                <div data-i18n="Analytics">Contact</div>
              </a>
            </li>
            @endif

            <li class="menu-item">
              <a href="{{route('privilege')}}" class="menu-link">
                <i class="menu-icon fa fa-braille" aria-hidden="true"></i></i>
                <div data-i18n="Analytics">Privilege</div>
              </a>
            </li>

     @if(Auth::user()->user_type == 3)
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">History</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item">
    <a href="{{ route('loginReport-view')}}" class="menu-link">
        <!-- <i class="menu-icon fa fa-braille" aria-hidden="true"></i> -->
        <div data-i18n="Analytics">Login Report</div>
    </a>
</li>

<li class="menu-item">
    <a href="{{ route('history')}}" class="menu-link">
        <!-- <i class="menu-icon fa fa-braille" aria-hidden="true"></i> -->
        <div data-i18n="Analytics">Data History</div>
    </a>
</li>

              </ul>
            </li>
            @endif

<li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Approved</div>
              </a>
              <ul class="menu-sub">

              <li class="menu-item">
              <a href="{{ route('Approved')}}" class="menu-link">
                <div data-i18n="Analytics">About Approve</div>
                  </a>
                      </li>

                <li class="menu-item">
                  <a href="{{route('facility-approved')}}" class="menu-link">
                    <div data-i18n="Notifications">Facility Approve</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{route('course-approved')}}" class="menu-link">
                    <div data-i18n="Notifications">Course Approve</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{route('events-approved')}}" class="menu-link">
                    <div data-i18n="Notifications">Events Approve</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{route('admission-approved')}}" class="menu-link">
                    <div data-i18n="Notifications">Admission Approve</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{route('tbl-approved')}}" class="menu-link">
                    <div data-i18n="Notifications">trainng & placement Approve</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{route('accreditations-approved')}}" class="menu-link">
                    <div data-i18n="Notifications">Accreditations Approve</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{route('recognitions-approved')}}" class="menu-link">
                    <div data-i18n="Notifications">Recognitions  Approve</div>
                  </a>
                </li>

                <li class="menu-item">
              <a href="{{route('bord-approved')}}" class="menu-link">
                <!-- <i class="menu-icon fa fa-braille" aria-hidden="true"></i> -->
                <div data-i18n="Analytics">Bord Of Director</div>
              </a>
            </li>

              </ul>
            </li>

            <li class="menu-item">
              <a href="{{route('delete-gallery-approved')}}" class="menu-link">
                <i class="menu-icon fa fa-braille" aria-hidden="true"></i></i>
                <div data-i18n="Analytics">Gallery Delete</div>
              </a>
            </li>
           
          </ul>

        </aside>
        <!-- / Menu -->

        <div class="layout-page">
      
          <!-- <nav
            class="layout-navbar container navbar navbar-expand-xl navbar-detached align-items-center "
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
           
              <ul class="navbar-nav flex-row align-items-center ms-auto" >
           
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{asset('img/logo.webp')}}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="{{asset('assets/img/avatars/1.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">
                            </span>
                            <small class="text-muted">Admin</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{route('profile')}}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    
                    <li>
                      <a class="dropdown-item" href="{{route('change-password')}}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">Change Password</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{route('logout')}}">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle" id="logout">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
              
              </ul>
            </div>
          </nav> -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
             

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">
                              <img src="{{asset('public/assets/img/avatars/1.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{Auth::user()->name}}</span>
                            <small class="text-muted">Admin</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{route('profile')}}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{route('logout')}}">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle" id="logout">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          
<script>
   $(document).ready(function() {
    var currentUrl = window.location.href;
    // alert(currentUrl);

    $('.menu-inner .menu-item a').filter(function() {
        return this.href === currentUrl;
    }).addClass('active');
});

    $(document).ready(function() {
        var currentUrl = window.location.href;
        $('.menu-inner .dropdown-item').each(function() {
            if ($(this).attr('href') === currentUrl) {
                $('.drop').toggle();
            }
        });
    });

    $(document).ready(function() {
        var currentUrl = window.location.href;
        $('nav #dropdown-item1').each(function() {
            if ($(this).attr('href') === currentUrl) {
                $('.drop1').toggle();
            }
        });

    });

</script>
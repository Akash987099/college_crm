<!-- <!DOCTYPE html> -->
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Edulinker</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Google Web Fonts -->
        <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap" rel="stylesheet">  -->

        <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI/tZ1e1k4pS6p1fGn9c/MKJnu3hhVovwQmiKvBU=" crossorigin="anonymous"></script>
        <!-- Template Stylesheet -->
        <link href="{{asset('frontend/css/style.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/css/new.js')}}" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        

    </head>

    <body>





        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <style>
      
        .nav-item.dropdown {
            position: relative;
            display: inline-block;
        }

        .nav-item.dropdown .nav-link {
            color: #ffffff;
            text-decoration: none;
            padding: 10px;
            display: inline-block;
        }

        .nav-item.dropdown  .university-drop{
            position: absolute;
            top: 100%;
            left: 0;
            display: none;
            background-color: #ffffff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 2px -2px gray;
            /* width: 100%;  */
        }
        
        .nav-item.dropdown  .college-drop{
            position: absolute;
            top: 100%;
            left: -150px;
            display: none;
            background-color: #ffffff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 2px -2px gray;
            /* width: 100%;  */
        }

        .nav-item.dropdown  .course-drop{
            position: absolute;
            top: 100%;
            left: -257px;
            display: none;
            background-color: #ffffff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 2px -2px gray;
            /* width: 100%;  */
        }

        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }

        .nav-item.dropdown .dropdown-menu button {
            color: #000000;
            padding: 10px;
            display: block;
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            cursor: pointer;
        }

        .nav-pills .active {
            background-color: #007bff;
            color: #ffffff;
        }

        .tab-content {
            width: 700px; 
            margin: 0 auto; 
        }
.menu_left_side_wrap{
    padding: 8px !important;
    background: #FAFAFA;
    border-radius: 8px 8px 8px 28px;
}
.nav-item .dropdown{
    position: relative;
    color: #fff;
    font-family: Lato;
    font-size: 12px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    text-transform: uppercase;
    padding: 23px 18px;
}
.menu_right_side_wrap{
    border-radius: 0 0 16px 16px;
    background: #FFF;
    padding: 16px 0 16px 20px;
}
.nav-link {
    font-size:20px;
}
.nav-link.active {
    color: #007bff!important; 
}
.nav_desktop li a{
position: relative;
    color: #fff;
    font-family: Lato;
    font-size: 12px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    text-transform: uppercase;
    /* padding: 23px 18px */
}
    </style>

      

        <!-- Navbar & Hero Start -->
        <div class="container-fluid position-relative p-0">
            
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="{{route('index')}}" class="navbar-brand p-0">
                     <h1 class="m-0"><i class="fa fa-building me-3"></i>Edulinker</h1> 
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{route('index')}}" class="nav-item nav-link active">Home</a>
                        <a href="" class="nav-item nav-link">About</a>
                        <a href="{{route('article-list')}}" class="nav-item nav-link">Articles</a>
                        <a href="{{route('get-all-news')}}" class="nav-item nav-link">news</a>
                        <!-- <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0">
                                <a href="destination.html" class="dropdown-item">Destination</a>
                                <a href="tour.html" class="dropdown-item">Explore Tour</a>
                                <a href="booking.html" class="dropdown-item">Travel Booking</a>
                                <a href="gallery.html" class="dropdown-item">Our Gallery</a>
                                <a href="guides.html" class="dropdown-item">Travel Guides</a>
                                <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                                <a href="404.html" class="dropdown-item">404 Page</a>
                            </div>
                        </div> -->
                        <a href="" class="nav-item nav-link">Contact</a>
                    </div>
                    <!-- <a href="" class="btn btn-primary rounded-pill py-2 px-4 ms-lg-4">Need Counceling</a> -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Need Counceling</button>
                </div>
            </nav>


            <div class="carousel-header">
                <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active"></li>
                        <li data-bs-target="#carouselId" data-bs-slide-to="1"></li>
                        <li data-bs-target="#carouselId" data-bs-slide-to="2"></li>
                    </ol>
                    
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img src="{{asset('front.jpg')}}" class="img-fluid" alt="Image">
                            <div class="carousel-caption">
                                <div class="p-3" style="max-width: 900px;">
                                    <h4 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Edulinker - Where Educational Choices Are Made Easy</h4>
                                    <!-- <h1 class="display-2 text-capitalize text-white mb-4"> - Where Educational Choices Are Made Easy</h1> -->
                                    <p class="mb-5 fs-5">
                                    Unlock your future. Start searching best colleges, courses, exams and more.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-center">
                                    <div class="position-relative  w-100 mx-auto p-5">

                                    <div class="text-center text-lg-start mb-2 mb-lg-0">
                                    <div class="row" id="mobileButtons">

                                   </div>
                                   <!-- <input type="text" name="user_name" id="user_name" class="form-control-lg" placeholder="Enter User Name..." /> -->
                                   <input class="form-control border-0 w-100 py-3 ps-4 pe-5" name="user_name" type="text" placeholder="Search Your University / College / Course" id="user_name">
                                    <div id="suggestions" class="form-control rounded border-0" style="position: absolute; top: 74%; left: 51px; width: 88%; background: #fff; border: 1px solid #ddd; display: none;">

                                </div>

                                   <!-- <button type="button" class="btn btn-primary rounded-pill py-2 px-4 position-absolute me-2" style="top: 50%; right: 46px; transform: translateY(-50%);">Search</button> -->
                </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>

            </div>
            <!-- Carousel End -->
        </div>
        </div>

            
         
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        
    <div class="bg-primary">
    <!-- <h5 class="card-header text-white">Featured</h5> -->
    <div class="row">
      <div class="col-6">
      {{-- <img src="{{asset('frontend/logo.png')}}" style="width:100px; margin-left:20px;" alt=""> --}}
      Edulinker
      </div>
      <div class="col-6">
      <h5 class=" text-white">Need a Call Back</h5>
      </div>
    </div>
  </div>
  
  <ul class="list-inline text-center text-dark p-2" style="background:#DAA520;">
      <li class="list-inline-item font-weight-bold">Scholarships</li>
      <li class="list-inline-item font-weight-bold">Application Deadlines</li>
      <li class="list-inline-item font-weight-bold">College Course Details</li>
      <li class="list-inline-item font-weight-bold">Shortlist Apply</li>
      <li class="list-inline-item font-weight-bold">24/7 Counceling</li>
  </ul>
  
  <div class="container mt-4">
      
      <form method="post" action="" id="needcounsellingform">
          @csrf
          <div class="form-row">
              <div class="col mb-3 col-6">
              <span style="color:red;">*</span>
                  <input type="text" name="name" id="inputname" class="form-control" placeholder="Enter Full Name">
              </div>
              <div class="col mb-3 col-6">
              <span style="color:red;">*</span>
                  <input type="text" name="email" id="inputemail" class="form-control" placeholder="Enter Email Address">
              </div>
              <div class="col mb-3 col-6">
              <span style="color:red;">*</span>
                  <input type="text" name="mobile" id="inputmobile" class="form-control" placeholder="Enter Mobile Number">
              </div>
              <div class="col mb-3 col-6">
              <span style="color:red;">*</span>
                  <input type="text" name="city" id="inputcity" class="form-control" placeholder="Enter city ">
                  <!-- <select name="city" id="" class="form-control" id="">
                      <option value="">Select City</option>
                  </select> -->
              </div>
              <div class="col mb-3 col-6">
              <span style="color:red;">*</span>
                  <input type="text" name="course" id="inputcourse" class="form-control" placeholder="Enter course ">
                  <!-- <select name="course" class="form-control" id="">
                      <option value="">Select Your Course</option>
                  </select> -->
              </div>
              <div class="col mb-3 col-12">
              <span style="color:red;">*</span>
                 <textarea name="message" id="description" class="form-control " id="" cols="30" rows="5">
                
                 </textarea>
              </div>
              <div class="col mb-3 col-10">
                <p class="font-weight-normal">By Submitting this form, you accept and agree to our Terms of Use</p>
              </div>
              <div class="col mb-3 col-2">
               <button class="btn-primary rounded" type="save" id="needsubmit">Submit</button>
              </div>
          </div>
      </form>
  
  </div>
  
  
  
      </div>
    </div>
  </div>
  
  </div>
  
  <script>
      $(document).ready(function(){
          $('#needsubmit').click(function(e){
              e.preventDefault();
              var formdata = $('#needcounsellingform').serialize();
              // alert(formdata);
              var headers = {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          };
              $.ajax({
                  url : "{{route('add-counsilling')}}",
                  type : "POST",
                   headers: headers,
                  data : formdata,
                  success : function(response){
                      console.log(response);
                      if(response.status == "success"){
                          alert('Thankyou for showing your intrest,We will call you soon.')
                          window.location.reload();
                      }else if (response.status == 'error') {
      $.each(response.message, function (i, message) {
          if (i == "city") {
              $('#inputcity').after('<div class="alert alert-danger">' + message + '</div>');
          } else if (i == "course") {
              $('#inputcourse').after('<div class="alert alert-danger">'+ message +'</div>');
          } else if (i == "email") {
              $('#inputemail').after('<div class="alert alert-danger">' + message + '</div>');
          }else if (i == "message") {
              $('#description').after('<div class="alert alert-danger">' + message + '</div>');
          }else if (i == "mobile") {
              $('#inputmobile').after('<div class="alert alert-danger">' + message + '</div>');
          }else if (i == "name") {
              $('#inputname').after('<div class="alert alert-danger">' + message + '</div>');
          }
      });
  }
                  }
              });
          });
      });
  </script>

<script>
   $(document).ready(function(){

    function generateUrlFriendlyName(name) {
    const urlFriendlyName = name.replace(/\s+/g, '/');
    return urlFriendlyName; 
}

    $('#user_name').keyup(function(){
        var query = $(this).val();

        if(query != ''){
            $.ajax({
                url: '{{ route("live-search") }}',
                method: 'POST',
                data: {query: query, '_token': '{{ csrf_token() }}'},
                success: function(data) {
    $('#suggestions').empty();

    if (data.length > 0) {
        $.each(data, function(index, result) {  
            const cleanedName = generateUrlFriendlyName(result.name);
            if (result.clickable !== false) { // Check if the suggestion is clickable
                $('#suggestions').append('<a href="javascript:void(0);" class="newurl" data-id="' + cleanedName + '"><p>' + result.name + '</p></a>');
            } else {
                $('#suggestions').append('<p style="color:blue;">' + result.name + '</p>'); // Append non-clickable suggestion
            }
        });
    } else {
        // If no results found, display "No results found" message in red color
        $('#suggestions').append('<p style="color:red;">No results found</p>');
    }

    $('#suggestions').show();
}

            });
        } else {
            $('#suggestions').hide();
        }
    });

    $(document).on('click', function(e){
        if(!$(e.target).closest('#suggestions').length && !$(e.target).is('#user_name')){
            $('#suggestions').hide();
        }
    });
});


  $(document).on('click', '.newurl', function () {
    var id = $(this).data('id');
    if (id !== null) {
        window.location.href = '{{ route("view-details") }}?id=' + id;
    }
});

</script>

<style>
    #exampleModalCommon .modal-content{
        padding: 0;
    }
    .modal-content{
        border: none;
    }
    .modal-content{
        position: relative;
    display: flex;
    flex-direction: column;
    width: 100%;
    pointer-events: auto;
    background-color: #fff;
    background-clip: padding-box;
    border-radius: 0.3rem;
    outline: 0;
    }
    .modal-header{
        display: flex;
    flex-shrink: 0;
    align-items: center;
    padding: 1rem 1rem;
    border-top-left-radius: calc(0.3rem - 1px);
    border-top-right-radius: calc(0.3rem - 1px);
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>

//  $(document).ready(function(){
//     $.ajax({
//         url: "{{ route('get-all-city') }}",
//         type: "GET",
//         dataType: "json",
//         success: function(response) {
           
//             $('#citySelect').empty();

//             $('#citySelect').append('<option value="">Select City</option>');

//             $.each(response.data, function(id, cityName) {
//                 $('#citySelect').append('<option value="' + id + '">' + cityName + '</option>');
//             });
//         },
//         error: function(xhr, status, error) {
//             console.error('Error:', error);
//         }
//     });
// });

</script>

@extends('master')

@section('frontend1')

<!-- <link rel="stylesheet" href="{{asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" /> -->
    <!-- <link rel="stylesheet" href="{{asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" /> -->

    <!-- Vendors CSS -->

    <div class="carousel-header">
                <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active"></li>
                        <li data-bs-target="#carouselId" data-bs-slide-to="1"></li>
                        <li data-bs-target="#carouselId" data-bs-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                        <img src="{{asset('/college')}}/{{$college->image ??''}}" class="img-fluid"  alt="Responsive image">
                            <div class="carousel-caption">
                                <div class="p-3" style="max-width: 900px;">
                                    <h4 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">{{$college->name}}</h4>
                                    <p class="mb-5 fs-5">
                                    Unlock your future. Start searching best colleges, courses, exams and more.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-center">
                                    <div class="position-relative  w-100 mx-auto p-5">

                                    <div class="text-center text-lg-start mb-2 mb-lg-0">
                                    <div class="row" id="mobileButtons">

                                   </div>
                                   <!-- <input type="text" name="user_name" id="user_name" class="form-control-lg" placeholder="Enter User Name..." /> -->
                                   <input class="form-control border-0 w-100 py-3 ps-4 pe-5" name="user_name" type="text" placeholder="Select Your University / College / Course" id="user_name">
                                   <div id="suggestions" class="form-control rounded border-0" style="position: absolute; top: 74%; left: 51px; width: 88%; background: #fff; border: 1px solid #ddd; display: none;">
                                
                                </div>

                                   <!--<button type="button" class="btn btn-primary rounded-pill py-2 px-4 position-absolute me-2" style="top: 50%; right: 46px; transform: translateY(-50%);">Search</button>-->
                </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>

            </div>

</div>

    
<style>
    .course-single-text ol{
        padding-left: 18px;
    }
    .heading.type-2{
        padding-top: 0;
    }
    #recognitions ul.p-placements-icon-list{
        justify-content: flex-start;
    }
    ul.p-placements-icon-list.d-flex.flex-wrap{

    }
    .p-placements-icon-list{
        margin-bottom: -20px;
    }
    li.p-placements-icon-item{
        flex: 0 0 31%;
    }
    .p-placements-icon-item{
        margin-right: 15px;
    margin-bottom: 20px;
    }
    
</style>

<!-- recognition end -->

<!--  rating start -->

<style>
    .course-single-text{
        font-size: 14px;
    line-height: 18px;
    color: #2D3E51;
    }
    .writrvws{
        padding: 30px 0;
    }
    .admsn_form{
        width: 80%;
        padding: 25px 0;
    }
    .admsn_form .row.side-query-form-box{
        padding-top: 20px;
    }
    .side-query-form-box{
        padding: 2px 10px 12px;
    }
</style>

<!-- rating end -->

<style>
    .eligibility-content {
    display: flex;
    align-items: center; /* Align items vertically in the center */
}

.eligibility-content p {
    margin-right: 10px; /* Adjust margin as needed */
}
    .sec-padd-sml{
        padding: 30px 0;
    }
    .heading.type-2{
        padding-top: 0;
    }
    .heading h3{
        font-weight: 600;
    color: #1D2C3A;
    margin-bottom: 0;
    }
    .heading.type-2 h3{
        font-size: 22px;
    line-height: 24px;
    }
    .heading p{
        margin-top: 4px;
    margin-bottom: 0;
    line-height: 20px;
    }
    nav .nav.nav-tabs{
        padding-bottom: 4px;
    margin-left: -5px;
    flex-wrap: nowrap;
    overflow: auto;
    overflow-y: hidden;
    }
    .tab-content>.active{
        display: block;
    }
    .s-stream-list{
        margin-left: -5px;
    margin-bottom: 0;
    }
    .s-stream-item{
        padding: 5px;
    width: 50%;
    }
    .s-stream-box{
        display: block;
    background-color: #EDFFD7;
    }
    a{
        text-decoration: none;
    }
    .s-stream-head{
        padding: 10px 10px 8px;
    background-color: #263238;
    color: #fff;
    transition: all .3s ease-in;
    }
    .s-stream-head h4{
        font-weight: 600;
    font-size: 16px;
    line-height: 20px;
    margin-bottom: 0;
    }
    s-stream-body{
        padding: 8px 10px;
    position: relative;
    padding-right: 160px;
    color: #263238;
    font-weight: 500;
    font-size: 14px;
    line-height: 16px;
    }
    .s-stream-body h6{
        font-weight: 500;
    font-size: 15px;
    line-height: 18px;
    margin-bottom: 4px;
    }
    .s-stream-body .btn{
        position: absolute;
    right: 858px;
    bottom: 80px;
    }
   
</style>

<style>
        .card-header{
            background:#000;
        }
        .card-body{
            background:#F0FFF0;
        }
    </style>


<link href="frontend/css/new.css" rel="stylesheet">
            <!-- Carousel Start -->
        
        
        <style>
            .intro-banner{
                padding: 35px 0;
            }
            .breadcrumb{
                margin-bottom: 6px;
    flex-wrap: nowrap;
    display: flex;
    list-style: none;
            }
            .breadcrumb-item{
                position: relative;
            }
            .breadcrumb-item{
                font-weight: 600;
    line-height: 15px;
    color: #2D3E51;
    transition: all .3s ease-in;
    white-space: nowrap;
    display: block;
            }
            .intro-banner-with-logo{
                position: relative;
    padding-left: 134px;
    margin-top: 16px;
    min-height: 133px;
    border-bottom: 1px solid #C1C1C1;
    padding-bottom: 12px;
    display: flex;
    flex-flow: column;
            }
            .intro-banner-logo{
                position: absolute;
    width: 120px;
    left: 0;
    height: 120px;
    background: #FFFFFF;
    box-shadow: 0px 0px 12px 3px rgba(0,0,0,0.1);
    border-radius: 4px;
            }
            .intro-banner-logo img{
                width: 100%;
    height: 100%;
    object-fit: contain;
            }
            img{
                max-width: 100%;
            }
            img{
                vertical-align: middle;
            }
            .intro-banner-icon{
                margin-bottom: 10px;
            }
            .intro-banner-icon li{
                font-weight: 600;
    font-size: 14px;
    line-height: 17px;
    color: #000;
    margin-top: 4px;
    display: flex;
    align-items: center;
    margin-right: 10px;
}
.intro-banner-with-logo .intro-banner-share-wrapper{
    padding-bottom: 0;
    border: 0;
    margin-top: auto;
}
.intro-banner-share{
    align-items: center;
}
        </style>

   
        <div class="intro-banner pb-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                      <a href="/">Home</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                        <a href="">{{$college->name ?? ''}}</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Info</li>
                    </ol>
                    <div class="intro-banner-with-logo">
                      <div class="intro-banner-logo">
                      <img src="college/logo/{{$college->logo ??''}}" alt="">
                     
                      </div>
                      <div class="intro-banner-heading">
                      <h1 id="nametitle">{{$college->name ?? ''}}</h1>
                      <ul class="intro-banner-icon d-flex flex-wrap">
                      <li>
<img src="https://universitykart.b-cdn.net/Contents/images/univrsity-icons/i32.png" alt="">
<span>{{$college->address ?? ''}} &nbsp; {{$city->city_name ?? ''}} &nbsp; {{$state->state_name ?? ''}}</span>
</li>
<li>
<img src="https://universitykart.b-cdn.net/Contents/images/univrsity-icons/i31.png" alt="">
<span>{{$college->type ?? ''}}</span>
</li>
<li>
<img src="https://universitykart.b-cdn.net/Contents/images/univrsity-icons/i29.png" alt="">
<span>{{$college->Established ?? ''}}</span>
</li>
<li>
<img src="https://universitykart.b-cdn.net/Contents/images/univrsity-icons/i33.png" alt="">
<span>{{$college->department ?? ''}}</span>
</li>
                      </ul>
                      </div>

                      <div class="intro-banner-share-wrapper">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="intro-banner-share d-flex flex-wrap">
                                <!-- <span>Share This:</span> -->
                                <ul class="intro-banner-share-links d-flex flex-wrap">
                                <span>Share This:</span> &nbsp;
                                <li>
<a href="https://www.facebook.com/intileotech/" target="_blank" class="intro-banner-share-link">
<i class="fab fa-facebook-f" aria-hidden="true"></i>
</a>
</li>
<li>
<a href="" target="_blank" class="intro-banner-share-link">
<i class="fab fa-instagram" aria-hidden="true"></i>
</a>
</li>
<li>
<a href="" target="_blank" class="intro-banner-share-link">
<i class="fab fa-twitter" aria-hidden="true"></i>
</a>
</li>
<li>
<a href="https://in.linkedin.com/company/intileotech" target="_blank" class="intro-banner-share-link">
<i class="fab fa-linkedin-in" aria-hidden="true"></i>
</a>
</li>
                                </ul>
                                </div>
                            </div>

                            <div class="col-md-7 text-md-end intro-banner-side-btns">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Apply Now</button>
                            <!-- <button class="btn btn-primary" onclick="if (!window.__cfRLUnblockHandlers) return false; RegisterPopup('universitydetails')" fdprocessedid="n0fpt">
                            <img src="https://universitykart.b-cdn.net/Contents/images/download-icon.png" alt="Brochure Download">Brochure</button> -->
                            </div>

                        </div>
                      </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>

       

        <style>
            .sec-padd-sml{
                padding: 30px 0;
            }
            div#nav-course-tab{
                padding: 0 40px;
    width: 100%;
    margin: 0 auto;
            }
            div#nav-course-tab{
                overflow: auto;
    overflow-y: hidden;
            }
         
            .slick-arrow.slick-disabled{
                background: #bfdb9c;
            }
            [type=button]:not(:disabled), [type=reset]:not(:disabled), [type=submit]:not(:disabled), button:not(:disabled){
                cursor: pointer;
            }
            .slick-list{
                position: relative;
    display: block;
    overflow: hidden;
    margin: 0;
    padding: 0;
            }
            .slick-slider .slick-track, .slick-slider .slick-list{

            }
            .slick-track{
                top: 0;
    left: 0;
    display: block;
    margin-left: auto;
    margin-right: auto;
            }
            nav .nav-tabs .nav-link.active{
                background: #86bc42;
    border-color: #86bc42;
    color: #fff;
            }
            nav .nav-tabs .nav-link{
                white-space: nowrap;
            }
            nav .nav-tabs .nav-link, nav .nav-tabs .nav-link:hover{
                font-weight: 500;
    font-size: 15px;
    color: #707070;
    border: 1px solid #c1c1c1;
    position: relative;
    padding: 4px 11px;
    border-radius: 5px;
    margin: 3px;
    text-transform: capitalize;
            }
            #nav-course-tab .slick-arrow, #nav-course-tab .slick-arrow{
                padding: 0 !important;
    width: 20px;
    height: 20px;
            }
        </style>

<div class="container-fluid testimonial p-1">


    <div class="container">
                
<div class="sec-padd-sml pb-0" role="tabpanel" aria-labelledby="courses-tab">
<nav class="mb-2">
<div class="nav nav-tabs" id="nav-streams-tab" role="tablist">
<button class="nav-link active info" id="collapse_1-tab" data-bs-toggle="tab" data-bs-target="#collapse_1">info</button>
<button class="nav-link corse"  id="collapse_2-tab" data-bs-toggle="tab" data-bs-target="#collapse_2">Course & Fee</button>
<button class="nav-link admissionbtn"  id="collapse_3-tab" data-bs-toggle="tab" data-bs-target="#collapse_3">Admission 2024-2025</button>
<button class="nav-link facilitybtn"  id="collapse_4-tab" data-bs-toggle="tab" data-bs-target="#collapse_4">Facilities</button>
<button class="nav-link trainingbtn"  id="collapse_5-tab" data-bs-toggle="tab" data-bs-target="#collapse_5">Training & Placement</button>
<button class="nav-link recognizationbtn"  id="collapse_6-tab" data-bs-toggle="tab" data-bs-target="#collapse_6">Recognization & Accreditations</button>
<button class="nav-link ratingbtn"  id="collapse_7-tab" data-bs-toggle="tab" data-bs-target="#collapse_7">Bord Of director</button>
<button class="nav-link eventbtn"  id="collapse_7-tab" data-bs-toggle="tab" data-bs-target="#collapse_7">Events</button>
</div>
</nav>
        </div>
      <hr>

    
     
        <div class="owl-carousel testimonial-carousel scrolltopcollege">
            <!-- Testimonial Item 1 -->

            <!-- Testimonial Item 2 -->
            @foreach($gallery as $key => $val)
            <div class="testimonial-item text-center rounded">
                    <div class="card" >
  <img class="card-img-top" src="{{asset('icons/')}}/{{$val->image}}"  style="width:100%!important; height: 200px;!important;" alt="Card image cap">
</div>
                    </div>
@endforeach
                    

        </div>

    </div>
</div>
<div>


<div class="container-fluid" id="information">
    <div class="container">
<div class="course-single-text informationdata">

</div>
</div>
</div>

<script>
               $('html, body').scrollTop($('#information').offset().top);
        </script>

<!-- information end -->



<!-- course start -->
<div id="courseandfees">
<div class="container-fluid" >
    <div class="container" id="coursefilldata">

</div>

<div class="container-fluid">
    
<div class="container">
<table class="table">
  <thead>
    <tr>
      <th scope="col">Course</th>
      <th scope="col">Fees</th>
      <th scope="col">Eligibility</th>
    </tr>
  </thead>
  <tbody id="coursetable">
   
  
  </tbody>
</table>
    <div class="sec-padd-sml pb-0" role="tabpanel" aria-labelledby="courses-tab">
<!-- <div class="heading type-2 mb-2">
<h3>Select Streams</h3>
<p>Amity University, Jaipur Fees &amp; Eligibility</p>
</div> -->

<!-- <nav class="mb-2">
<div class="nav nav-tabs" id="nav-streams-tab" role="tablist">
<button class="nav-link active" id="collapse_1-tab" data-bs-toggle="tab" data-bs-target="#collapse_1" type="button" role="tab" aria-controls="collapse_1" aria-selected="true" fdprocessedid="aczru">Management</button>
<button class="nav-link " id="collapse_2-tab" data-bs-toggle="tab" data-bs-target="#collapse_2" type="button" role="tab" aria-controls="collapse_2" aria-selected="true" fdprocessedid="slosd">Engineering</button>
<button class="nav-link " id="collapse_3-tab" data-bs-toggle="tab" data-bs-target="#collapse_3" type="button" role="tab" aria-controls="collapse_3" aria-selected="true" fdprocessedid="j7xh8">Medical</button>
<button class="nav-link " id="collapse_4-tab" data-bs-toggle="tab" data-bs-target="#collapse_4" type="button" role="tab" aria-controls="collapse_4" aria-selected="true" fdprocessedid="v2w8hp">Science</button>
<button class="nav-link " id="collapse_5-tab" data-bs-toggle="tab" data-bs-target="#collapse_5" type="button" role="tab" aria-controls="collapse_5" aria-selected="true" fdprocessedid="wcz2ah">Arts</button>
<button class="nav-link " id="collapse_6-tab" data-bs-toggle="tab" data-bs-target="#collapse_6" type="button" role="tab" aria-controls="collapse_6" aria-selected="true" fdprocessedid="upo8oq">Commerce</button>
<button class="nav-link " id="collapse_8-tab" data-bs-toggle="tab" data-bs-target="#collapse_8" type="button" role="tab" aria-controls="collapse_8" aria-selected="true" fdprocessedid="w1jtih">Pharmacy</button>
<button class="nav-link " id="collapse_9-tab" data-bs-toggle="tab" data-bs-target="#collapse_9" type="button" role="tab" aria-controls="collapse_9" aria-selected="true" fdprocessedid="rcah2e">Law</button>
<button class="nav-link " id="collapse_10-tab" data-bs-toggle="tab" data-bs-target="#collapse_10" type="button" role="tab" aria-controls="collapse_10" aria-selected="true" fdprocessedid="cp615v">Fashion Design and Technology</button>
<button class="nav-link " id="collapse_11-tab" data-bs-toggle="tab" data-bs-target="#collapse_11" type="button" role="tab" aria-controls="collapse_11" aria-selected="true" fdprocessedid="c2cm2q">Architecture</button>
<button class="nav-link " id="collapse_12-tab" data-bs-toggle="tab" data-bs-target="#collapse_12" type="button" role="tab" aria-controls="collapse_12" aria-selected="true" fdprocessedid="qmkbt">Agriculture</button>
<button class="nav-link " id="collapse_13-tab" data-bs-toggle="tab" data-bs-target="#collapse_13" type="button" role="tab" aria-controls="collapse_13" aria-selected="true" fdprocessedid="3uzte">Computer Science and IT</button>
<button class="nav-link " id="collapse_14-tab" data-bs-toggle="tab" data-bs-target="#collapse_14" type="button" role="tab" aria-controls="collapse_14" aria-selected="true">Paramedical Science</button>
<button class="nav-link " id="collapse_15-tab" data-bs-toggle="tab" data-bs-target="#collapse_15" type="button" role="tab" aria-controls="collapse_15" aria-selected="true">Library and Information Science</button>
<button class="nav-link " id="collapse_17-tab" data-bs-toggle="tab" data-bs-target="#collapse_17" type="button" role="tab" aria-controls="collapse_17" aria-selected="true">Journalism and Mass Communication</button>
<button class="nav-link " id="collapse_21-tab" data-bs-toggle="tab" data-bs-target="#collapse_21" type="button" role="tab" aria-controls="collapse_21" aria-selected="true">Aerospace and Aviation</button>
</div>
</nav> -->
<div class="tab-content"></div>
<div class="tab-pane fade active show">
<div class="stream-single-content">
        <ul class="s-stream-list flex-wrap" id="">
<li class="">
    <div class="row" id="allcoursedata">

    </div>
 

</li>



    </ul>
</div>
</div>
    </div>
</div>

</div>

</div>
</div>
<!-- course end -->

<style>
    .course-single-text{
        font-size: 14px;
    line-height: 18px;
    color: #2D3E51;
    }
</style>


<!-- information start -->

<script>
    $(document).ready(function () {
        // $('html, body').scrollTop($('.informationdata').height());
    
        function getUrlParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        var idFromUrl = getUrlParameter('id');
        // alert(idFromUrl);

        $.ajax({
            url: '{{ route("get-view-details") }}',
            type: 'GET',
            data: { id: idFromUrl },
            success: function (data) {
                console.log(data);
                if (data.about) {
                    data.about.forEach(function (item) {
                        // console.log(item.gallery);
                        var html = `
                            <h3>${item.title}</h3>
                            ${item.description}
                        `;

                    
                        $('.informationdata').append(html);
                    });
                }


                if (data.about) {
                    data.about.forEach(function (item) {
                        // console.log(item.gallery);
                        var html = `
                        
                            ${item.description}
                        `;

                    
                        $('#coursefilldata').append(html);
                    });
                }

                if (data.course) {
    data.course.forEach(function (item) {
        var html = `
          
                <div class="col-6">
                    <div class="card">
                        <h5 class="card-header text-white">${item.name}</h5>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">
                                    <h5> Eligibility: &nbsp; <small> ${item.eligibility} </small> </h5>
                                    </h5>
                                </div>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Get</button>
                            </div>
                        </div>
                    </div>
                </div>

        
        `;

        $('#allcoursedata').append(html);
    });
}

if (data.course) {
    // console.log(data.course);
    data.course.forEach(function (item) {
       
        var rowHtml = `
            <tr>
                <td>${item.name}</td>
                <td>${item.fees}</td>
                <td>${item.eligibility}</td>
            </tr>
        `;

        $('#coursetable').append(rowHtml);
    });
}


if (data.admission) {
    data.admission.forEach(function (item) {
        // console.log(item);

        if(item.description_tmp == null){
            var rowHtml = `
            <a href="${item.link}" target="_blank">
            <img src="http://127.0.0.1:8000/events/1710412159.png" alt="">
               ${item.link}</a>
                    ${item.content}
                `;
        }else{
            var rowHtml = `
                <a href="${item.link}" target="_blank"></a>
                <img src="" alt="">
                    
                `;
        }

       
                $('#admissiondata').append(rowHtml);
    });
}  


    },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

</script>




<!-- admission start -->

<div id="admissionform">

<div class="container-fluid">
    <div class="container" id="admissiondata">
  
</div>
</div>

</div>
</div>
        <script>
//          $(document).ready(function () {
//     var offset = 0;
//     var limit = 20;

//     function loadCities() {
//         $.ajax({
//             url: "{{ route('get-filter-search') }}",
//             type: "GET",
//             dataType: "json",
//             data: { offset: offset, limit: limit },
//             success: function (response) {
//                 $.each(response.cities, function (index, city) {
//                     $('#cityneeddata').append('<option value="' + city.id + '">' + city.city + '</option>');
//                 });

//                 offset += limit;
//             }
//         });
//     }

//     loadCities();

//     $(window).on('scroll', debounce(function () {
//         if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
//             loadCities();
//         }
//     }, 300));
//     function debounce(func, wait) {
//         var timeout;
//         return function () {
//             var context = this, args = arguments;
//             var later = function () {
//                 timeout = null;
//                 func.apply(context, args);
//             };
//             clearTimeout(timeout);
//             timeout = setTimeout(later, wait);
//         };
//     }
// });


// $(document).ready(function () {
   
//     $.ajax({
//         url: "{{ route('course-filter-search') }}",  
//         type: "GET",
//         data: { id: idFromUrl },  
//         dataType: "json",
//         success: function (response) {
//             $.each(response.program, function (index, program) {
//                 $('#courseneeddata').append('<option value="' + program.id + '">' + program.name + '</option>');
//             });
//         }
//     });
// });

//         </script>

   <!-- admission end -->


   <script>
    $(document).ready(function(){
        function getUrlParameter(name) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
    
    var idFromUrl = getUrlParameter('id');
    
    $.ajax({
    url: "{{ route('get-facility-data') }}",
    type: "GET",
    data: { id: idFromUrl },
    dataType: "json",
    success: function (response) {
            displayImageData(response);
    },
    error: function (xhr, status, error) {
        console.error(xhr.responseText);
    }
});

$.ajax({
    url: "{{ route('get-facility-data-trans') }}",
    type: "GET",
    data: { id: idFromUrl },
    dataType: "json",
    success: function (response) {
            displayDescriptionData(response);
    },
    error: function (xhr, status, error) {
        console.error(xhr.responseText);
    }
});

function displayDescriptionData(response) {

    $.each(response.facility, function (index, facility) {
        var descriptionHtml = `
          
            <h5>${facility.title}</h5>
            ${facility.description}
            `;

        $('#facilityalldata').append(descriptionHtml);
    });
}

function displayImageData(response) {

    $.each(response.facility, function (index, facility) {
        var imageHtml = `
            <li class="f-facilities-icon-item">
                <div class="f-facilities-icon">
                    <img style="width:150px;" src="icons/${facility.facility_image}">
                </div>
                <h5>${facility.facility_name}</h5>
            </li>`;

        $('#facilityimagedata').append(imageHtml);
    });
}

    });
   </script>

   <!-- facility start -->
<div id="facilityform">
   <div class="container-fluid">
    <div class="container" id="facilityalldata">

</div>
   </div>
   
   <div class="container-fluid">
    <div class="container">
     <div class="sec-padd-sml pb-0">
         <div class="heading type-2 mb-2">
         <h3>Facilities</h3>
         <p>Available Basic Facilities In The Campus</p>
         </div>
         <ul class="f-facilities-icon-list d-flex flex-wrap"  id="facilityimagedata">
        
        </ul>
     </div>
    </div>
   </div>

</div>
   <style>
.f-facilities-icon-list{
    justify-content: start;
    margin-bottom: -20px;s
}
.f-facilities-icon-item{
    width: auto;
    margin-right: 40px;
    text-align: center;
    margin-bottom: 20px;
}
   </style>

   </div>
   <!-- facility end -->



<style>
    .course-single-text p:last-child{
        margin-bottom: 0;
    }
</style>

<!-- admission end -->

<script>
    $(document).ready(function(){
        function getUrlParameter(name) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
    
    var idFromUrl = getUrlParameter('id');
    $.ajax({
    url: "{{ route('get-tbl-data') }}",
    type: "GET",
    data: { id: idFromUrl },
    dataType: "json",
    success: function (response) {
        tbldescriptiondata(response);
        tblImageData(response);
    },
    error: function (xhr, status, error) {
        console.error(xhr.responseText);
    }
});


function tbldescriptiondata(response) {
    $('#tblalldata').empty();

    $.each(response.tbl, function (index, tbl) {
        var imageHtml = `
           <h5>${tbl.link}</h5>
           ${tbl.content}
        `;

        $('#tblalldata').append(imageHtml);
    });
}

function tblImageData(response) {
    $('#imagealldata').empty(); // Clear existing content

    $.each(response.tbl, function (index, tbl) {
        // console.log(tbl);
        var imageHtml = `
            <li class="p-placements-icon-item">
                <div class="p-placements-icon">
                    <img src="placement/${tbl.image}" style="height:310px;" alt="${tbl.alt}">
                </div>
            </li>`;

        $('#imagealldata').append(imageHtml);
    });
}

});

</script>

<!--  training & placement start -->

<div id="trainingform">
    <div class="container-fluid">
        <div class="container" id="tblalldata">
       
        </div>
    </div>

    <div class="container-fluid">
        <div class="container">
            <div class="sec-padd-sml pb-0">
               <div class="heading type-2">
               <h3>Placements</h3>
               <!-- <p>Basic Information About The Training &amp; Placement</p> -->
               </div>
               <ul class="p-placements-icon-list d-flex flex-wrap" id="imagealldata">
                    
               </ul>
            </div>
        </div>
    </div>

</div>

<style>
    .sec-padd-sml{
        padding: 30px 0;
    }
    .heading.type-2{
        padding-top: 0;
    }
    .heading{
        margin-bottom: 18px;
        position: relative;
    }
    ul.p-placements-icon-list.d-flex.flex-wrap{
        justify-content: flex-start;
    }
    #placements li.p-placements-icon-item{
        flex: 0 0 16%;
    }
   
</style>

<!-- training & placeent end -->

<script>

$(document).ready(function(){
        function getUrlParameter(name) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
    
    var idFromUrl = getUrlParameter('id');
    $.ajax({
    url: "{{ route('get-accreditations-data') }}",
    type: "GET",
    data: { id: idFromUrl },
    dataType: "json",
    success: function (response) {
        $('#Recognitionformdata').empty(); 

$.each(response.accreditations, function (index, accreditations) {
    // console.log(tbl);
    var imageHtml = `
    <img src="accreditations/${accreditations.image}" style="width:200px;">
          <h5>${accreditations.title}</h5>   
          ${accreditations.content}
    `;

    $('#Recognitionformdata').append(imageHtml);
});
    },
   
});

});

$(document).ready(function(){
        function getUrlParameter(name) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
    
    var idFromUrl = getUrlParameter('id');
    $.ajax({
    url: "{{ route('get-Recognition-data') }}",
    type: "GET",
    data: { id: idFromUrl },
    dataType: "json",
    success: function (response) {
        $('#Recognitionimagedata').empty(); 

$.each(response.Recognition, function (index, Recognition) {
    // console.log(tbl);
    var imageHtml = `
    <li class="p-placements-icon-item">
<div class="plc_img_hdng">
<div class="p-placements-icon">
<img src="accreditations_master/${Recognition.image}" style="width:200px;">
</div>
</div>
<div class="card-block">
<br>
<h6>${Recognition.title}</h6>
<p class="card-text">
${Recognition.content}
</p>
</div>
</li>
    `;

    $('#Recognitionimagedata').append(imageHtml);
});
    },
   
});

});

</script>


<!-- recognition start -->

<div id="Recognitionform">

<div class="container-fluid">
    <div class="container" id="Recognitionformdata">
    
</div>
</div>

<div class="container-fluid">
    <div class="container">

    <div class="sec-padd-sml pb-0">
    <div class="heading type-2">
    <h3>Recognitions &amp; Accreditations</h3>
    <!-- <p>Ranking Of Indian Institute Of Management</p> -->
    </div>
    <ul class="p-placements-icon-list d-flex flex-wrap" id="Recognitionimagedata">

</ul>
</div>

    </div>
</div>
</div>

<script>
    $(document).ready(function(){
        function getUrlParameter(name) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
    
    var idFromUrl = getUrlParameter('id');
    $.ajax({
    url: "{{ route('get-bord-data') }}",
    type: "GET",
    data: { id: idFromUrl },
    dataType: "json",
    success: function (response) {
       
$.each(response.bord, function (index, bord) {
    var imageHtml = `
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100">
                <img class="card-img-top" src="image/${bord.image}" alt="">
                <div class="card-body">
                    <h5 class="card-title text-center">Name: ${bord.name}</h5>
                    <h5 class="card-title text-center">Designation: ${bord.designation}</h5>
                    <h5 class="card-title text-center">Qualification: ${bord.qualification}</h5>
                </div>
            </div>
        </div>
    `;

    $('.bordformdatafill').append(imageHtml);
});
    },
   
});

});
</script>

<div id="bordofdirectorform">
<div class="container-fluid">
    <div class="container">

    <div class="sec-padd-sml pb-0">
    <div class="heading type-2">
    <h3>Bord of Director</h3>
 </div>

 <div class="row bordformdatafill">
  

</div>

</div>
    </div>
</div>
</div>

<script>
    $(document).ready(function(){
        function getUrlParameter(name) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
    
    var idFromUrl = getUrlParameter('id');
    $.ajax({
    url: "{{ route('get-event-data') }}",
    type: "GET",
    data: { id: idFromUrl },
    dataType: "json",
    success: function (response) {
       
$.each(response.event, function (index, event) {
    var imageHtml = `
    <a href="${event.linnk}"> ${event.linnk}</a>
  
    <div class="row">
    <div class="col-5 col-lg-5">
        <!-- Image Container -->
        <img class="img-fluid" src="${event.image ? 'events/' + event.image : 'placeholder.jpg'}" style="max-width: 100%; height: auto;" alt="Event Image">
    </div>
    <div class="col-7 col-lg-7">
        <!-- Content Container -->
        <div class="content">
            <p>${event.content}</p>
        </div>
    </div>
</div>
               
    `;

    $('.eventformfill').append(imageHtml);
});
    },
   
});

});
</script>


    <div id="eventformdata">
<div class="container-fluid">
    <div class="container">

    <div class="sec-padd-sml pb-0">
    <div class="heading type-2">
    <h3>Events</h3>
 </div>

 <div class="row eventformfill">

</div>

</div>
    </div>

</div>
</div>

</div>

</div>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
       
    $(document).ready(function () {

        $('#courseandfees').hide();
        $('#admissionform').hide();
        $('#facilityform').hide();
        $('#trainingform').hide();
        $('#Recognitionform').hide();
        $('#ratingform').hide();
        $('#bordofdirectorform').hide();
        $('#eventformdata').hide();
      
        $('#information').show();

        $('.info').click(function () {
            toggleVisibility('#information');
        });

        $('.corse').click(function () {
            toggleVisibility('#courseandfees');
        });

        $('.recognizationbtn').click(function () {
            toggleVisibility('#Recognitionform');
        });

        $('.admissionbtn').click(function () {
            toggleVisibility('#admissionform');
        });

        $('.facilitybtn').click(function () {
            toggleVisibility('#facilityform');
        });

        $('.trainingbtn').click(function () {
            toggleVisibility('#trainingform');
        });

        $('.ratingbtn').click(function () {
            toggleVisibility('#bordofdirectorform');
        });

        $('.eventbtn').click(function () {
            toggleVisibility('#eventformdata');
        });

     
    });
    // bordofdirectorform
    function toggleVisibility(targetId) {
      
        $('#information, #courseandfees, #admissionform, #facilityform, #trainingform, #Recognitionform, #ratingform, #bordofdirectorform, #eventformdata').hide();

        $(targetId).show();
    }
</script>

<script>
  $(document).ready(function () {
        var owl = $('.new-carousel');

        owl.owlCarousel({
            loop: true,
            margin: 5,
            nav: false, 
            dots: true,  
            responsive: {
                0: { items: 1 },
                600: { items: 5 },
                1000: { items: 10 }
            },
        });

        $('.custom-next-btn').on('click', function () {
            owl.trigger('next.owl.carousel');
        });

        $('.custom-prev-btn').on('click', function () {
            owl.trigger('prev.owl.carousel');
        });
    });

</script>


<script>
            function toggleButtons() {
        if ($(window).width() <= 767) { 
            $('#desktopButtons').hide();
            $('#mobileButtons').show();
        } else {
            $('#desktopButtons').show();
            $('#mobileButtons').hide();
        }
    }

    toggleButtons();

    $(window).resize(function () {
        toggleButtons();
    });
        </script>
     

        @endsection
@extends('layouts.master')

@section('frontend')
<link href="public/frontend/css/new.css" rel="stylesheet">
            <!-- Carousel Start -->
          

      

        <style>
              .search-container {
            margin-top: 50px;
        }

        .search-input {
            padding: 10px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-right: 10px;
        }

        #search-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        </style>
        

        <script>
            function toggleButtons() {
        if ($(window).width() <= 767) { // Adjust the breakpoint according to your needs
            $('#desktopButtons').hide();
            $('#mobileButtons').show();
        } else {
            $('#desktopButtons').show();
            $('#mobileButtons').hide();
        }
    }

    // Initial call to set the initial state
    toggleButtons();

    // Call the function on window resize
    $(window).resize(function () {
        toggleButtons();
    });
        </script>

        <div class="container-fluid search-bar position-relative" style="top: -1%; transform: translateY(-50%);">
    <div class="container" id="newsalldataset">
        <div class="container-fluid packages">
            <div class="container">
                <div class="packages-carousel owl-carousel" id="">
                    

                @foreach($news as $key => $val)
                <div class="packages-item">
                    <div class="packages-content bg-white rounded">
                           <a href="{{route('news-single-data' , ['id' => $val->id])}}">
                           <div class="row bg-white rounded mx-0 p-2">
                               <div class="col-4 text-start">
                               <img id="" src="{{asset('public/news')}}/{{$val->image}}" style="width:100%;" class="img-fluid rounded" alt="Image">
                               </div>
                               <div class="col-8 text-start px-0">
                               <p class="text-dark truncate-text" id="anewstitledata">{{ $val->title }}</p>
                               </div>
                           </div>
                           </a>
                       </div>
                    </div>
           @endforeach

                   
                </div>
            </div>
        </div>
        
            </div>
        </div>

        <script>

$(document).ready(function() {
    $('.truncate-text').each(function(index, element) {
        var originalText = $(element).text();
        var truncatedText = originalText.length > 60 ? originalText.substring(0, 60) + '...' : originalText;
        $(element).text(truncatedText);
    });
});

//             $(document).ready(function () {
//     $.ajax({
//         url: "{{ route('get-news-data') }}",
//         dataType: "json",
//         success: function (response) {
//             // $('#newsalldataset').empty();
//             $.each(response.news, function (index, news) {
//                 // Create HTML elements dynamically
//                 var html = `
//                 <div class="container-fluid packages">
//             <div class="container">
//                 <div class="packages-carousel owl-carousel">
                    
//                 <div class="packages-item">
//                     <div class="packages-content bg-white rounded">
                           
//                            <div class="row bg-white rounded mx-0 p-2">
//                                <div class="col-4 text-start">
//                                <img id="dynamicImage" src="" style="width:100%;" class="img-fluid rounded" alt="Image">
//                                </div>
//                                <div class="col-8 text-start px-0">
//                                <p class="text-dark" id="anewstitledata">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Officia, alias?</p>
//                                </div>
//                            </div>
//                        </div>
//                     </div>
                   
//                 </div>
//             </div>
//         </div>
//                 `;

//                 // Append the dynamically created HTML to the container
//                 $('#newsalldataset').append(html);
//             });
//         }
//     });
// });

        </script>


     
        <!-- <div class="top-city"> -->
    <div class="container-fluid">
        <div class="container">
            <div class="mx-auto text-center" style="">
                <h5 class="section-title px-2">Top Cities</h5>
            </div>
            <div class="carousel">
                <!-- <button class="custom-prev-btn rounded">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <button class="custom-next-btn rounded">
                    <i class="bi bi-arrow-right"></i>
                </button> -->
                <div class="new-carousel owl-carousel" id="cityCarousel">
                    <!-- City items will be dynamically added here -->
                    
                </div>
            </div>
        </div>
    </div>
<!-- </div> -->

<script>
    $(document).ready(function () {
        $.ajax({
            url: "{{ route('get-top-city') }}",
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    displayCities(response.cities);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
            }
        });

        function displayCities(cities) {
    var carouselContainer = $("#cityCarousel");

    $.each(cities, function (index, city) {
        var card = $("<div>").addClass("text-center");
        var cardBody = $("<div>").addClass("card");
        var cardText = $("<div>").addClass("card-body");
        var image = $("<img>").attr("src", "public/frontend/img/india-gate.png")
            .addClass("mx-auto d-block")
            .attr("alt", city.city_name);
        var cityName = $("<p>").addClass("card-text").text(city.city_name);

        var link = $("<a>").attr("href", "{{ route('city-top-get', ['id' => '']) }}" + city.id);
        link.append(image, cityName);
// 
        cardText.append(link);
        cardBody.append(cardText);
        card.append(cardBody);

        carouselContainer.append(card);
    });

    // Initialize the Owl Carousel after adding items
    var owl = $('.new-carousel');
    owl.owlCarousel({
        items: 3,
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });

    // Custom navigation buttons
    $('.custom-next-btn').on('click', function () {
        owl.trigger('next.owl.carousel');
    });

    $('.custom-prev-btn').on('click', function () {
        owl.trigger('prev.owl.carousel');
    });
}


    });
</script>

<script>
    $(document).on('click' , '.mangamenbrowse' , function(){

        var id = $(this).attr('data-id');
        // alert(id);
        if(id === "Managment"){
            var mainID = ['BBA', 'MBA', 'PGDM', 'BMS', 'BHM', 'BBA LLB', 'MHA'];
        }else  if(id === "Engineering"){
            var mainID = ['BE', 'BTech', 'ME', 'MTech', 'B.Tech (Hons)', 'M.Tech (Hons)', 'PhD Engineering'];
        } else  if(id === "Science"){
            var mainID = ['bca', 'mca' ,  'BArch' , 'Bsc' , 'BPharma' , 'BE' , 'BTech'];
        } else  if(id === "Architecture"){
            var mainID = ['BSc Agriculture', 'MSc Agriculture', 'B.Tech Agriculture', 'M.Tech Agriculture'];
        } else  if(id === "Arts"){
            var mainID = ['BA', 'BFA' ,  'BSC' , 'BA LLB' , 'BHM' , 'BJMC' , 'BJ' , 'BMM' , 'D'];
        } else  if(id === "Pharmacy"){
            var mainID = ['DPharma', 'BPharma', 'MPharma', 'PhD Pharmacy'];
        } else  if(id === "Commerce"){
            var mainID = ['BCom', 'BBA', 'MCom', 'MBA', 'BCA (Commerce)']; 
        } else  if(id === "Medical"){
            var mainID = ['MBBS', 'BDS', 'BAMS', 'BHMS', 'BPT', 'B.Sc Nursing', 'MD', 'MS', 'MDS', 'MPT', 'M.Sc Nursing', 'PhD Medical Sciences'];
        } else  if(id === "Law"){
            var mainID = ['LLB', 'LLM', 'BA LLB', 'BBA LLB', 'BCom LLB', 'LLD'];
        } else  if(id === "Agriculture"){
            var mainID = ['BSc Agriculture', 'MSc Agriculture', 'B.Tech Agriculture', 'M.Tech Agriculture'];
        } else  if(id === "Fashion"){
            var mainID = ['BSc Fashion Design', 'B.Design in Fashion', 'MSc Fashion Technology', 'M.Design in Fashion'];
        }

        mainID = mainID.map(function (item) {
            return item.replace(/,/g, '/');
    });
        var mainIDString = mainID.join(',');
        var url = '{{ route('city-top-get') }}?id=' + encodeURIComponent(mainIDString);
        window.location.href = url;
    });

  

</script>

<div class="container-fluid testimonial">
            <div class="container py-5">
                <div class="mx-auto text-center mb-5" style="max-width: 900px;">
                <h5 class="section-title px-3">Browse for future</h5>
            <p>Search engine for students, parents, and education industry players who are seeking information.</p>
                </div>
                
                <div class="testimonial-carousel owl-carousel"> 
                         
                <div class="row">
                    
                <div class="testimonial-item text-center rounded pb-4">
                        <div class="testimonial-comment bg-white border rounded p-4">
                        <a href="javascript:void(0);" class="mangamenbrowse" data-id="Managment">
                            <div class="row">
                                <div class="col-2">
                                <img src="public/frontend/logo/test.webp" style="width:50px;" alt="">
                                </div>
                                <div class="col-8">
                                <p class="text-center text-dark">
                                   Management
                                    <br>
                                    {{$totalManagement}} Colleges
                                      </p>
                                </div>
                                <div class="col-2 text-align-center p-2">
                                <i class="fa fa-chevron-right text-dark" aria-hidden="true"></i>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>

                    <div class="testimonial-item text-center rounded pb-4">
                        <div class="testimonial-comment bg-white border rounded p-4">
                        <a href="javascript:void(0);" class="mangamenbrowse" data-id="Engineering">
                            <div class="row">
                                <div class="col-2">
                                <img src="public/top/test2.webp" style="width:50px;" alt="">
                                </div>
                                <div class="col-8">
                                <p class="text-center text-dark">
                                    Engineering
                                    <br>
                                    {{$totalEngineering}} Colleges
                                      </p>
                                </div>
                                <div class="col-2 text-align-center p-2">
                                <i class="fa fa-chevron-right text-dark" aria-hidden="true"></i>
                                </div>
                            </div>
                         </a>
                        </div>
                    </div>

                    <div class="testimonial-item text-center rounded pb-4">
                        <div class="testimonial-comment bg-white border rounded p-4">
                        <a href="javascript:void(0);" class="mangamenbrowse" data-id="Medical">
                            <div class="row">
                                <div class="col-2">
                                <img src="public/top/medical.webp" style="width:50px;" alt="">
                                </div>
                                <div class="col-8">
                                <p class="text-center text-dark">
                                   Medical
                                    <br>
                                    {{$totalMedical}} Colleges
                                      </p>
                                </div>
                                <div class="col-2 text-align-center p-2">
                                <i class="fa fa-chevron-right text-dark" aria-hidden="true"></i>
                                </div>
                            </div>
                          </a>
                        </div>
                    </div>

                    </div>

                    <div class="row">
                    
                    <div class="testimonial-item text-center rounded pb-4">
                        <div class="testimonial-comment bg-white border rounded p-4">
                        <a href="javascript:void(0);" class="mangamenbrowse" data-id="Science">
                            <div class="row">
                                <div class="col-2">
                                <img src="public/top/test1.webp" style="width:50px;" alt="">
                                </div>
                                <div class="col-8">
                                <p class="text-center text-dark">
                                    Science
                                    <br>
                                    {{$totalscience}} Colleges
                                      </p>
                                </div>
                                <div class="col-2 text-align-center p-2">
                                <i class="fa fa-chevron-right text-dark" aria-hidden="true"></i>
                                </div>
                            </div>
                           </a>
                        </div>
                    </div>
    
                    <div class="testimonial-item text-center rounded pb-4">
                        <div class="testimonial-comment bg-white border rounded p-4">
                        <a href="javascript:void(0);" class="mangamenbrowse" data-id="Arts">
                            <div class="row">
                                <div class="col-2">
                                <img src="public/top/arts.webp" style="width:50px;" alt="">
                                </div>
                                <div class="col-8">
                                <p class="text-center text-dark">
                                   Arts
                                    <br>
                                    {{$totalArts}} Colleges
                                      </p>
                                </div>
                                <div class="col-2 text-align-center p-2">
                                <i class="fa fa-chevron-right text-dark" aria-hidden="true"></i>
                                </div>
                            </div>
                         </a>
                        </div>
                    </div>

                       <div class="testimonial-item text-center rounded pb-4">
                        <div class="testimonial-comment bg-white border rounded p-4">
                        <a href="javascript:void(0);" class="mangamenbrowse" data-id="Commerce">
                            <div class="row">
                                <div class="col-2">
                                <img src="public/top/commerce.webp" style="width:50px;" alt="">
                                </div>
                                <div class="col-8">
                                <p class="text-center text-dark">
                                   Commerce
                                    <br>
                                    {{$totalCommerce}} Colleges
                                      </p>
                                </div>
                                <div class="col-2 text-align-center p-2">
                                <i class="fa fa-chevron-right text-dark" aria-hidden="true"></i>
                                </div>
                            </div> 
                        </a>
                        </div>
                    </div>
    
                        </div>

                        <div class="row">
                    
                        <div class="testimonial-item text-center rounded pb-4">
                        <div class="testimonial-comment bg-white border rounded p-4">
                        <a href="javascript:void(0);" class="mangamenbrowse" data-id="Education">
                            <div class="row">
                                <div class="col-2">
                                <img src="public/top/education.webp" style="width:50px;" alt="">
                                </div>
                                <div class="col-8">
                                <p class="text-center text-dark">
                                  Education
                                    <br>
                                    {{$totalEducation}} Colleges
                                      </p>
                                </div>
                                <div class="col-2 text-align-center p-2">
                                <i class="fa fa-chevron-right text-dark" aria-hidden="true"></i>
                                </div>
                            </div> 
                        </a>
                        </div>
                    </div>

                    <div class="testimonial-item text-center rounded pb-4">
                        <div class="testimonial-comment bg-white border rounded p-4">
                        <a href="javascript:void(0);" class="mangamenbrowse" data-id="Pharmacy">
                            <div class="row">
                                <div class="col-2">
                                <img src="public/top/pharmacy.webp" style="width:50px;" alt="">
                                </div>
                                <div class="col-8">
                                <p class="text-center text-dark">
                                    Pharmacy
                                    <br>
                                    {{$totalPharmacy}} Colleges
                                      </p>
                                </div>
                                <div class="col-2 text-align-center p-2">
                                <i class="fa fa-chevron-right text-dark" aria-hidden="true"></i>
                                </div>
                            </div> 
                        </a>
                        </div>
                    </div>

                    <div class="testimonial-item text-center rounded pb-4">
                        <div class="testimonial-comment bg-white border rounded p-4">
                        <a href="javascript:void(0);" class="mangamenbrowse" data-id="Law">
                            <div class="row">
                                <div class="col-2">
                                <img src="public/top/law.webp" style="width:50px;" alt="">
                                </div>
                                <div class="col-8">
                                <p class="text-center text-dark">
                                  Law
                                    <br>
                                    {{$totalLaw}} Colleges
                                      </p>
                                </div>
                                <div class="col-2 text-align-center p-2">
                                <i class="fa fa-chevron-right text-dark" aria-hidden="true"></i>
                                </div>
                            </div> 
                        </a>
                        </div>
                    </div>

                    </div>

                    <div class="row">
                    
                        <div class="testimonial-item text-center rounded pb-4">
                        <div class="testimonial-comment bg-white border rounded p-4">
                        <a href="javascript:void(0);" class="mangamenbrowse" data-id="Fashion">
                            <div class="row">
                                <div class="col-2">
                                <img src="public/top/fashion.webp" style="width:50px;" alt="">
                                </div>
                                <div class="col-8">
                                <p class="text-center text-dark">
                                  Fashion Design and Technology
                                    <br>
                                    {{$totalFashionDesign}} Colleges
                                      </p>
                                </div>
                                <div class="col-2 text-align-center p-2">
                                <i class="fa fa-chevron-right text-dark" aria-hidden="true"></i>
                                </div>
                            </div> 
                        </a>
                        </div>
                    </div>

                    <div class="testimonial-item text-center rounded pb-4">
                        <div class="testimonial-comment bg-white border rounded p-4">
                        <a href="javascript:void(0);" class="mangamenbrowse" data-id="Architecture">
                            <div class="row">
                                <div class="col-2">
                                <img src="public/top/archi.webp" style="width:50px;" alt="">
                                </div>
                                <div class="col-8">
                                <p class="text-center text-dark">
                                    Architecture
                                    <br>
                                    {{$totalArchitecture}} Colleges
                                      </p>
                                </div>
                                <div class="col-2 text-align-center p-2">
                                <i class="fa fa-chevron-right text-dark" aria-hidden="true"></i>
                                </div>
                            </div> 
                        </a>
                        </div>
                    </div>

                    <div class="testimonial-item text-center rounded pb-4">
                        <div class="testimonial-comment bg-white border rounded p-4">
                        <a href="javascript:void(0);" class="mangamenbrowse" data-id="Agriculture">
                            <div class="row">
                                <div class="col-2">
                                <img src="public/top/agri.webp" style="width:50px;" alt="">
                                </div>
                                <div class="col-8">
                                <p class="text-center text-dark">
                                  Agriculture
                                    <br>
                                    {{$totalAgriculture}} Colleges
                                      </p>
                                </div>
                                <div class="col-2 text-align-center p-2">
                                <i class="fa fa-chevron-right text-dark" aria-hidden="true"></i>
                                </div>
                            </div> 
                        </a>
                        </div>
                    </div>

                    </div>
                   
                </div>
            </div>
        </div>
        <!-- Testimonial End -->


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function(){
    var currentButton = null;

    $('#Management').on('click', function(){
        if (currentButton !== null) {
            currentButton.css('background-color', ''); 
        }

        currentButton = $(this);

        currentButton.css('background-color', 'gray');
        alert('Hello');
    });

    $('#Engineering').on('click', function(){
        if (currentButton !== null) {
            currentButton.css('background-color', '');
        }

        currentButton = $(this);

        currentButton.css('background-color', 'gray');
        alert('Hello');
    });
});

</script>






        <div class="container-fluid blog">
            <div class="container">
            
            <div class="row">
                <div class="col-6">
                <div class="mx-auto mb-5" style="max-width: 900px;">
                <h5 class="section-title p-2 text-center">Top colleges of India</h5>
                <p class="mb-0">
                    Choose the best future for yourself.
                </p>
            </div>
                </div>

                <div class="col-6">
                <div class="text-end">
                <!-- <button class="btn btn-white d-inline">View All</button> -->
                <a href="{{route('city-top-get')}}" class="btn btn-white d-inline">View All</a>
            </div>
                </div>
            </div>              

                <div class="d-flex justify-content-between">
    <div class="text-center" id="">
        <button class="btn btn-white d-inline custom-button topcustopmdata" data-id="Management">Management</button>
        <button class="btn btn-white d-inline custom-button topcustopmdata" data-id="Engineering">Engineering</button>
        <button class="btn btn-white d-inline custom-button topcustopmdata" data-id="Medical">Medical</button>
        <button class="btn btn-white d-inline custom-button topcustopmdata" data-id="Science">Science</button>
        <button class="btn btn-white d-inline custom-button topcustopmdata" data-id="Arts">Arts</button>
        <button class="btn btn-white d-inline custom-button topcustopmdata" data-id="Commerce">Commerce</button>
        <button class="btn btn-white d-inline custom-button topcustopmdata" data-id="Pharmacy">Pharmacy</button>
        <button class="btn btn-white d-inline custom-button topcustopmdata" data-id="Education">Education</button>
        <button class="btn btn-white d-inline custom-button topcustopmdata" data-id="Paramedical">Paramedical</button>
        <button class="btn btn-white d-inline custom-button topcustopmdata" data-id="Computer">Computer Applications</button>
       
    </div>

      </div>
      <hr>
     
                <div class="row justify-content-start" id="topcollgedatauseAjax">

                    </div>
               
                    <script>
                        $(document).ready(function(){
                            $(document).on('click' , '.topcustopmdata' , function(){ 
                                $('#topcollgedatauseAjax').empty();
                                var id = $(this).attr('data-id');
                                // alert(id);

                                if(id === "Science"){
            var mainId = ['BSc Agriculture', 'MSc Agriculture', 'B.Tech Agriculture', 'M.Tech Agriculture'];
        } else if (id === "Paramedical"){
            var  mainId = ['BArch', 'MArch', 'PhD Architecture'];
        } else if (id === "Arts"){
            var mainId = ['BA', 'BFA' ,  'BSC' , 'BA LLB' , 'BHM' , 'BJMC' , 'BJ' , 'BMM' , 'D'];
        }  else if (id === "Engineering"){
            var mainId = ['BE', 'BTech', 'ME', 'MTech', 'B.Tech (Hons)', 'M.Tech (Hons)', 'PhD Engineering'];
       }else if (id === "Commerce"){
            var mainId = ['BCom', 'BBA', 'MCom', 'MBA', 'BCA (Commerce)']; 
       }else if (id === "Education"){
            var mainId = ['BEd', 'MEd', 'Diploma in Education', 'MPhil Education', 'PhD Education'];
       }else if (id === "Fashion"){
            var mainId = ['BSc Fashion Design', 'B.Design in Fashion', 'MSc Fashion Technology', 'M.Design in Fashion'];
       }else if (id === "Computer"){
            var mainId = ['LLB', 'LLM', 'BA LLB', 'BBA LLB', 'BCom LLB', 'LLD'];
       }else if (id === "Management"){
            var mainId = ['BBA', 'MBA', 'PGDM', 'BMS', 'BHM', 'BBA LLB', 'MHA'];
       }else if (id === "Medical"){
            var mainId = ['MBBS', 'BDS', 'BAMS', 'BHMS', 'BPT', 'B.Sc Nursing', 'MD', 'MS', 'MDS', 'MPT', 'M.Sc Nursing', 'PhD Medical Sciences'];
       }else if (id === "Pharmacy"){
            var mainId = ['DPharma', 'BPharma', 'MPharma', 'PhD Pharmacy'];
       }else{
                  var mainId = id;
        }

                            $.ajax({
                                url : "{{route('top-college-ajax')}}",
                                type : "GET",
                                data : {id : mainId},
                                dataType : "json",
                                success : function(response){
                                    // console.log(response);

                                    if (response.collegedata.length === 0) {
                                        $('#topcollgedatauseAjax').empty();
           var html = `
               <p style="font-size:50px; text-align:center;">No Result Found!</p>
           `;

           $('#topcollgedatauseAjax').append(html);
        }else{
            loadcollegetopdata(response);
        }
                                   
                                   
                                }
                            });
                        });

                        $.ajax({
                                url : "{{route('top-college-ajax')}}",
                                type : "GET",
                                dataType : "json",
                                success : function(response){
                                    // console.log(response);
                                    loadcollegetopdata(response);
                                   
                                }
                            });

                        });

                        function generateUrlFriendlyName(name) {
const urlFriendlyName = name.replace(/\s+/g, '-');
return urlFriendlyName; 
}

                        function loadcollegetopdata(response){
                            // console.log(response);
                                    $.each(response.collegedata, function(index, result) {
                                        var cleanedName = generateUrlFriendlyName(result.name);
                                        var html = ` 
                                     
                                        <div class="col-lg-4 col-md-4 img-thumnail">
                        <div class="blog-item">
                            <div class="blog-img">
                                <div class="blog-img-inner">
                                    <img class="img-fluid w-100 rounded-top img-fluid img-thumbnail" src="public/college/${result.image}" alt="Image" style="height:200px;">
                                    <div class="blog-icon">
                                        <a href="{{route('view-details')}}?id=${result.user_id}" class="my-auto"><i class="fas fa-link fa-2x text-white"></i></a>
                                    </div>
                                </div>
                                <div class="blog-info d-flex align-items-center border border-start-0 border-end-0" style="background: linear-gradient(179.6deg, rgba(255, 255, 255, 0) 43.01%, rgba(0, 0, 0, 0.81) 75.94%); color: #FFFFFF;">
                                    <small class="flex-fill text-start border-start">
                                        <img src="public/college/${result.logo}"  alt="" style="height: 100px;">
                                    </small>
                                    
                                <h6 class="text-light font-weight-bold">
                                ${result.name}
                               <hr>
                                <span class="font-weight-bold">
                                 ${result.city_name} ,  ${result.state_name}
                                </span>  
                                </h6>   

                                    </div>
                            </div>
                            <div class="blog-content border border-top-0 rounded-bottom">
                            <ul class="intro-banner-icon d-flex flex-wrap">
                                <li>
                                    <img src="public/frontend/logo/i31.webp" alt="">
                                    <span>  ${result.uni_name}</span>
                                </li>
                                &nbsp;
                                <li>
                                    <img src="public/frontend/logo/i29.webp" alt="">
                                    <span>${result.Established}</span>
                                </li>
                                &nbsp;
                              
                            </ul>  
                            <div class="facility">
    <p>
        Facilities:
    </p>
    <div class="d-flex fcl_list">
    <!-- <div class="fac_wrp"> -->
        <div class="fac_wrp">
        <img src="public/icons/${result.fac_image ? result.fac_image : '1709719444.png'}" alt="" style="width: 35px; height: auto;">
         <span>${result.fac_name ? result.fac_name : 'Cricket'}</span>
        </div>
</div>
</div>

<div class="top-colleges-cta">
    <div class="flex_vw_btns">
    <a href="{{route('view-details')}}?id=${cleanedName}" class="btn btn-primary btn-sm">View Courses</a>
        <!-- <button class="btn btn-primary btn-sm">View Courses</button> -->
    </div>
    <div>
        <!-- <button class="btn btn-dark btn-sm">Read More</button> -->
        <a href="{{route('view-details')}}?id=${cleanedName}" class="btn btn-dark btn-sm">Read More</a>
        <!-- view-details -->
        <button class="btn btn-success btn-sm">Apply Now</button>
    </div>
</div>
</div>
</div>
</div>

                                        `;

                                        $('#topcollgedatauseAjax').append(html);

        });
                                

                        }
                    </script>

                    
<!-- <div class="container-fluid testimonial p-1">

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
<button class="nav-link ratingbtn"  id="collapse_7-tab" data-bs-toggle="tab" data-bs-target="#collapse_7">Rating</button>
</div>
</nav>
    </div>
    </div>
    </div> -->

   
<!-- 
    <div class="container-fluid testimonial">
        <div class="container">
        
        <div class="row">
                <div class="col-6">
                <div class="mx-auto mb-5" style="max-width: 900px;">
                <h5 class="section-title p-2 text-center">Top Exams</h5>
            </div>
                </div>

                <div class="col-6">
                <div class="text-end">
                <button class="btn btn-white d-inline">View All</button>
            </div>
                </div>
            </div>  

            <div class="carousel">
                <button class="custom-prev-btn rounded">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <button class="custom-next-btn rounded">
                    <i class="bi bi-arrow-right"></i>
                </button>
                <div class="new-carousel owl-carousel">
                
                <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Management</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Engineering</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Medical</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Science</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Arts</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Commerce</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Pharmacy</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Education</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Paramedical</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Law</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Design</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Dental</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Animation</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Aviation</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Computer Application</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Mass Communications</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Veterinary Sciences</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white d-inline custom-button">Hotel Management</button>
            </div>

            <div class="text-center">
            <button class="btn btn-white custom-button">Vocational Courses</button>
            </div>

                </div>
            </div>
        </div>
    </div>
</div>
<hr>



<style>


</style>


<div class="container-fluid bg-white service">
            <div class="container">
              
                <div class="row g-4">

                    <div class="col-lg-4">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="service-content-inner d-flex align-items-start bg-white border  rounded">
                                
                                <div class="service-icon">
                                    <div class="row">
                                        <div class="col-4" style="margin-left:15px;">
                                        <img src="frontend/logo/jnu.webp" alt="..." class="rounded-circle" style="width:80px;">
                                        </div>
                                        <div class="col-8 e-exam-head text-start">
                                        <h3 class="jnu-name">JNU CEEB</h3>
                                        <div class="e-exam-body">
                                        <p class="mb-0">JNU CEEB....</p>
                                        <a href="" class="reammore-btn" tabindex="0">Read More</a>
                                        </div>
                                    </div>
                               
                                    </div>
                                  
                                        <div class="e-exam-footer">
                                        <div class="card-footer text-muted">
   
                                            <div class="e-exam-form-time">
                                                <h6>Application Form:</h6>
                                                <ul class="flex-wrap d-inline-block">
    <li><span class="label">To:</span>
        <span class="date">Apr, 03, 2023</span>
        &nbsp;
        <span class="label">From:</span>
        <span class="date">Mar, 01, 2023</span>
    </li>
</ul>
                                            
  </div>

                                            <div class="e-exam-time">
    <ul class="d-flex flex-wrap">
        <li>
            <span class="label">Examination:</span>
            <span class="date">Apr, 23, 2023</span>
        </li>
       <a href="" class="sitebtn two" tabindex="0">Get Details</a>
    </ul>
</div>
</div>

                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                           
                            <div class="col-12">
                                <div class="service-content-inner d-flex align-items-start bg-white border rounded">
                                
                                <div class="service-icon">
                                    <div class="row">
                                        <div class="col-4" style="margin-left:15px;">
                                        <img src="frontend/logo/jnu.webp" alt="..." class="rounded-circle" style="width:80px;">
                                        </div>
                                        <div class="col-8 e-exam-head text-start">
                                        <h3 class="jnu-name">JNU CEEB</h3>
                                        <div class="e-exam-body">
                                        <p class="mb-0">JNU CEEB....</p>
                                        <a href="" class="reammore-btn" tabindex="0">Read More</a>
                                        </div>
                                    </div>
                               
                                    </div>
                                  
                                        <div class="e-exam-footer">
                                        <div class="card-footer text-muted">
   
                                            <div class="e-exam-form-time">
                                                <h6>Application Form:</h6>
                                                <ul class="flex-wrap d-inline-block">
    <li><span class="label">To:</span>
        <span class="date">Apr, 03, 2023</span>
        &nbsp;
        <span class="label">From:</span>
        <span class="date">Mar, 01, 2023</span>
    </li>
</ul>


                                            
  </div>

                                            <div class="e-exam-time">
    <ul class="d-flex flex-wrap">
        <li>
            <span class="label">Examination:</span>
            <span class="date">Apr, 23, 2023</span>
        </li>
        <a href="" class="sitebtn two" tabindex="0">Get Details</a>
    </ul>
</div>
</div>

                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                           
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="service-content-inner d-flex align-items-start bg-white border  rounded">
                                
                                <div class="service-icon">
                                    <div class="row">
                                        <div class="col-4" style="margin-left:15px;">
                                        <img src="frontend/logo/jnu.webp" alt="..." class="rounded-circle" style="width:80px;">
                                        </div>
                                        <div class="col-8 e-exam-head text-start">
                                        <h3 class="jnu-name">JNU CEEB</h3>
                                        
                                        <div class="e-exam-body">
                                        <p class="mb-0">JNU CEEB....</p>
                                        <a href="" class="reammore-btn" tabindex="0">Read More</a>
                                        </div>
                                    </div>
                               
                                    </div>
                                  
                                        <div class="e-exam-footer">
                                        <div class="card-footer text-muted">
   
                                            <div class="e-exam-form-time">
                                                <h6>Application Form:</h6>
                                                <ul class="flex-wrap d-inline-block">
    <li><span class="label">To:</span>
        <span class="date">Apr, 03, 2023</span>
        &nbsp;
        <span class="label">From:</span>
        <span class="date">Mar, 01, 2023</span>
    </li>
</ul>


  </div>

                                            <div class="e-exam-time">
    <ul class="d-flex flex-wrap">
        <li>
            <span class="label">Examination:</span>
            <span class="date">Apr, 23, 2023</span>
        </li>
        <a href="" class="sitebtn two" tabindex="0">Get Details</a>
    </ul>
</div>
</div>

                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                           
                            <div class="col-12">
                                <div class="service-content-inner d-flex align-items-start bg-white border  rounded">
                                
                                <div class="service-icon">
                                    <div class="row">
                                        <div class="col-4" style="margin-left:15px;">
                                        <img src="frontend/logo/jnu.webp" alt="..." class="rounded-circle" style="width:80px;">
                                        </div>
                                        <div class="col-8 e-exam-head text-start">
                                        <h3 class="jnu-name">JNU CEEB</h3>
                                       
                                        <div class="e-exam-body">
                                        <p class="mb-0">JNU CEEB....</p>
                                        <a href="" class="reammore-btn" tabindex="0">Read More</a>
                                        </div>
                                    </div>
                               
                                    </div>
                                  
                                        <div class="e-exam-footer">
                                        <div class="card-footer text-muted">
   
                                            <div class="e-exam-form-time">
                                                <h6>Application Form:</h6>
                                                <ul class="flex-wrap d-inline-block">
    <li><span class="label">To:</span>
        <span class="date">Apr, 03, 2023</span>
        &nbsp;
        <span class="label">From:</span>
        <span class="date">Mar, 01, 2023</span>
    </li>
</ul>


                                            
  </div>

                                            <div class="e-exam-time">
    <ul class="d-flex flex-wrap">
        <li>
            <span class="label">Examination:</span>
            <span class="date">Apr, 23, 2023</span>
        </li>
        <a href="" class="sitebtn two" tabindex="0">Get Details</a>
    </ul>
</div>
</div>

                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                         
                        </div>
                    </div>
                   

                    <div class="col-lg-4">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="service-content-inner d-flex align-items-start bg-white border rounded">
                                
                                <div class="service-icon">
                                    <div class="row">
                                        <div class="col-4" style="margin-left:15px;">
                                        <img src="frontend/logo/jnu.webp" alt="..." class="rounded-circle" style="width:80px;">
                                        </div>
                                        <div class="col-8 e-exam-head text-start">
                                        <h3 class="jnu-name">JNU CEEB</h3>
                                        <div class="e-exam-body">
                                        <p class="mb-0">JNU CEEB....</p>
                                        <a href="" class="reammore-btn" tabindex="0">Read More</a>
                                        </div>
                                    </div>
                               
                                    </div>
                                  
                                        <div class="e-exam-footer">
                                        <div class="card-footer text-muted">
   
                                            <div class="e-exam-form-time">
                                                <h6>Application Form:</h6>
                                                <ul class="flex-wrap d-inline-block">
    <li><span class="label">To:</span>
        <span class="date">Apr, 03, 2023</span>
        &nbsp;
        <span class="label">From:</span>
        <span class="date">Mar, 01, 2023</span>
    </li>
</ul>


                                            
  </div>

                                            <div class="e-exam-time">
    <ul class="d-flex flex-wrap">
        <li>
            <span class="label">Examination:</span>
            <span class="date">Apr, 23, 2023</span>
        </li>
        <a href="" class="sitebtn two" tabindex="0">Get Details</a>
    </ul>
</div>
</div>

                                        </div>
                                    </div>
                                  
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="service-content-inner d-flex align-items-start bg-white border  rounded">
                                
                                <div class="service-icon">
                                    <div class="row">
                                        <div class="col-4" style="margin-left:15px;">
                                        <img src="frontend/logo/jnu.webp" alt="..." class="rounded-circle" style="width:80px;">
                                        </div>
                                        <div class="col-8 e-exam-head text-start">
                                        <h3 class="jnu-name">JNU CEEB</h3>
                                        <div class="e-exam-body">
                                        <p class="mb-0">JNU CEEB....</p>
                                        <a href="" class="reammore-btn" tabindex="0">Read More</a>
                                        </div>
                                    </div>
                               
                                    </div>
                                  
                                        <div class="e-exam-footer">
                                        <div class="card-footer text-muted">
   
                                            <div class="e-exam-form-time">
                                                <h6>Application Form:</h6>
                                                <ul class="flex-wrap d-inline-block">
    <li><span class="label">To:</span>
        <span class="date">Apr, 03, 2023</span>
        &nbsp;
        <span class="label">From:</span>
        <span class="date">Mar, 01, 2023</span>
    </li>
</ul>
                                   
  </div>

                                            <div class="e-exam-time">
    <ul class="d-flex flex-wrap">
        <li>
            <span class="label">Examination:</span>
            <span class="date">Apr, 23, 2023</span>
        </li>
        <a href="" class="sitebtn two" tabindex="0">Get Details</a>
    </ul>
</div>
</div>

                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                           
                          
                        </div>
                    </div>
                    
                </div>
            </div>
        </div> -->



        <div class="container-fluid testimonial py-5" >
    <div class="container py-2" id="articlealldata">
        <div class="row">
            <div class="col-6">
                <div class="mx-auto" style="max-width: 900px;">
                    <h5 class="section-title p-2 text-center">Articles</h5>
                </div>
            </div>
            <div class="col-6">
                <div class="text-end">
                    <a href="{{route('article-list')}}" class="btn btn-white d-inline">View All</a>
                </div>
            </div>
        </div>
     
        <div class="owl-carousel testimonial-carousel">
        @foreach($articles as $key => $val)
            <div class="testimonial-item text-center rounded">
                <div class="card">
                    <img class="card-img-top" src="public/articles/{{$val->image}}" style="width:100%!important;" alt="Card image cap">
                    <div class="card-body text-white">
                        <p class="text-dark text-start" id="articletitle-${index}">{{$val->title}}</p>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-7">
                                <span>{{$val->created_at}}</span>
                            </div>
                            <div class="col-5 text-end">
                                <a href="{{route('artical-top-data', ['id' => $val->id])}}" class="btn btn-primary btn-sm">Read More</a>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>


    </div>
</div>

<div>

</div>
</div>
</div>
</div>
</div>

<script>
//     $(document).ready(function(){
//     $.ajax({
//         url: "{{ route('artical-top-data') }}",
//         type: "GET",
//         dataType: "json",
//         success: function(response){
          
//             var testimonialContainer = $('#articlealldata');

// $.each(response.article, function(index, article) {
//     console.log(article.title);
//     var html = `
//         <div class="owl-carousel testimonial-carousel">
//             <div class="testimonial-item text-center rounded">
//                 <div class="card">
//                     <img class="card-img-top" src="articles/${article.image}" style="width:100%!important;" alt="Card image cap">
//                     <div class="card-body text-white">
//                         <p class="text-dark text-start" id="articletitle-${index}">${article.title}</p>
//                     </div>
//                     <div class="card-header">
//                         <div class="row">
//                             <div class="col-7">
//                                 <span>${article.title}</span>
//                             </div>
//                             <div class="col-5 text-end">
//                                 <button class="btn btn-primary btn-sm">Read More</button>
//                             </div>
//                         </div>
//                     </div>
//                 </div>
//             </div>
//         </div>
//     `;
//     testimonialContainer.append(html);
// });

          
//         }
//     });
// });

</script>
     

        @endsection
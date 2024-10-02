@extends('layouts.master')

@section('frontend')


<style>
   
 span{font-size:19px;}
/* .overlay {
    background: rgb(0 0 0 / 55%);
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    z-index: 1030;
}
.filter-header {
  font-weight: bold;
  font-size: 30px;
}
.filter-title {
  font-weight: bold;
  font-size: 20px;
  padding-bottom: 14px;
  margin-bottom: 15px;
}
.title {
  font-weight: bold;
  font-size: 20px;
  padding-bottom: 0;
  margin-bottom: 15px;
}
.mb-30 {
  margin-bottom: 30px;
}
.row-grid img{margin-bottom:-17px;max-width:100%}
img{
    height: 70px;
} */
@media (max-width: 767.98px) {
 .filters-actions {
    position: fixed;
    background: #fff;
    display: flex;
    justify-content: center;
    border:0;
    bottom: 0;
    z-index: 1031;
    left: 0;
    right: 0;
    bottom: 0;
    box-shadow: 0px -2px 3px rgb(0 0 0 / 21%);
    -webkit-box-shadow: 0px -2px 3px rgb(0 0 0 / 21%);
    -moz-box-shadow: 0px -2px 3px rgb(0 0 0 / 21%);
    height: 50px;
   }
    .filters-actions>div {
        flex: 1;
        text-align: center;
       
    }
    .filters-actions>div:first-of-type{
    border-right: 1px solid #d6d1ce;
    }
    .filters-actions>div>* {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}
.filter-btn, .filter-btn:hover, .filter-btn:focus, .filter-btn:active {
    padding: 14px 20px;
    height: 50px;
    border: 0;
     position: relative;
    z-index: 1;
    background: #fff;
    border-radius: 0;
}
    /* .sort-drop .dropdown-menu{
   width: 100%;
    left: 0;
    position: fixed !important;
    transform: translateY(100%) !important;
    bottom: 50px !important;
    top: auto !important;
    text-align: center;
    border-radius: 6px 6px 0 0 !important;
    box-shadow: none !important;
    transition: .3s;
    display: block;
    z-index: -11;
    } */
     /* .sort-drop .dropdown-menu .dropdown-item{padding:15px 20px !important;}
    .sort-drop .dropdown-menu .dropdown-item:first-child{
      border-radius: 6px 6px 0 0 !important;
    }
    .sort-drop.show .dropdown-menu{
    transform: translateY(0) !important;
    } */
    /* .btn.sort-toggle{
     background-image: none;
     padding:10px !important;
     width: 100%;
    border: 0;
    height: 50px;
    position: relative;
    z-index: 1;
    background: #fff;
    border-radius: 0;
    font-size: 16px;
    line-height: 22px;
    } */
    .sidebar {
    position: fixed;
    transform: translateY(100%);
    -webkit-transform: translateY(100%);
    -moz-transform: translateY(100%);
    -o-transform: translateY(100%);
    transition: .3s;
    -webkit-transition: .3s;
    -moz-transition: .3s;
    -o-transition: .3s;
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;
   
     background: #fff;
    
   }
   .sidebar.open{
     z-index: 1032;
     transform: translateY(0);
    -webkit-transform: translateY(0);
    -moz-transform: translateY(0);
    -o-transform: translateY(0);
   }
   .sidebar__inner {
    padding: 15px;
    height: calc(100% - 58px);
    overflow-y: auto;
   }
   .filter-header{height: 58px;}
   .filter-body{padding-right: 0;}
} 
</style>

<br>


<div class="search-section">
  <div class="container-fluid container-xl">
    <div class="row main-content ml-md-0">
        
      <div class="sidebar col-md-3 px-2">
        <h1 class="border-bottom filter-header d-flex d-md-none p-3 mb-0 align-items-center">
          <span class="mr-2 filter-close-btn">
              X
          </span>
          Filters
          <span class="ml-auto text-uppercase">Reset Filters</span>
        </h1>
        <div class="sidebar__inner ">
          <div class="filter-body">
            <div>

            <div class="filter-header py-1 pr-3 border-bottom">
                <h1 class="my-0 heading">Filters</h1>
                <div class="d-flex align-items-center justify-content-between my-2">
                <!-- <span class="text-gray">Found  colleges</span> -->
                <!-- <span class="jsx-3589932326 reset-text text-sm text-primary pointer">Set Default</span> -->
                </div>
            </div>

            <div class="py-0 pr-3">
                <div style="display: contents;">
                <div class="border-bottom my-1 py-2">
                    <div class="accordion-container accordion-item-opened">
                        <div class="accordion-item-line">
                            <div class="accordion-item-title">
                            <h2 class="filter-title m-0">Course</h2>
                            </div>
                            <div class="accordion-item-ani">
                                <div class="toggle">

                                </div>
                            </div>
                        </div>


                        <div class="accordion-item-inner">
                         <div class="accordion-item-content">
                               <div class="course_tag_id">
                                <div class="search-wrap px-3 my-1">
                                <input type="text" placeholder="FIND COURSE" class="form-control course-box border-0 text-sm p-2" value="">
                                <span class="icon icon-search ">
                                    </span>
                                </div>
                                <ul class="jsx-3589932326 pr-0 pl-1 py-1 my-2 mx-0 filter-scroll text-secondary position-relative form-check" id="courselist">
                                    <li>
                                    
                                    </li>
                                   

                                </ul>
                               </div>
                         </div>
                        </div>

                    </div>
                </div>
            </div>
            </div>

      

            <div class="py-0 pr-3">
                <div style="display: contents;">
                <div class="border-bottom my-1 py-2">
                    <div class="accordion-container accordion-item-opened">
                        <div class="accordion-item-line">
                            <div class="accordion-item-title">
                            <h2 class="filter-title m-0">State</h2>
                            </div>
                            <div class="accordion-item-ani">
                                <div class="toggle">

                                </div>
                            </div>
                        </div>


                        <div class="accordion-item-inner">
                         <div class="accordion-item-content">
                               <div class="course_tag_id">
                                <div class="search-wrap px-3 my-1">
                                <input type="text" placeholder="Total {{$state}} FIND STATE"  class="form-control state-box border-0 text-sm p-2" value="">
                                <span class="icon icon-search ">
                                    </span>
                                </div>
                                <ul class="pr-0 pl-1 py-1 my-2 mx-0 filter-scroll text-secondary position-relative" id="statelist">
                                   
                                </ul>
                               </div>
                         </div>
                        </div>

                    </div>
                </div>
            </div>
            </div>

          



            <div class="py-0 pr-3">
                <div style="display: contents;">
                <div class="border-bottom my-1 py-2">
                    <div class="accordion-container accordion-item-opened">
                        <div class="accordion-item-line">
                            <div class="accordion-item-title">
                            <h2 class="filter-title m-0">City</h2>
                            </div>
                            <div class="accordion-item-ani">
                                <div class="toggle">

                                </div>
                            </div>
                        </div>


                        <div class="accordion-item-inner">
                         <div class="accordion-item-content">
                               <div class="course_tag_id">
                                <div class="search-wrap px-3 my-1">
                                <input type="text" placeholder=" Total City {{$totalcity}} FIND " class="form-control search-box border-0 text-sm p-2" value="">
                                <span class="icon icon-search ">
                                    </span>
                                </div>

                                <ul class="jsx-3589932326 pr-0 pl-1 py-1 my-2 mx-0 filter-scroll text-secondary position-relative" id="cityList">
                                   
                              

                                </ul>
                               </div>
                         </div>
                        </div>

                    </div>
                </div>
            </div>
            </div>

            <script>
// $(document).ready(function () {
//     var originalCities;
//     var cityList = $('#cityList');
//     var searchBox = $('.search-box');

//     $.ajax({
//         url: "{{ route('get-filter-search') }}",
//         type: "GET",
//         dataType: "json",
//         success: function (response) {
//             originalCities = response.cities;
//             var totalCityCount = originalCities.length;
//             searchBox.attr('placeholder', 'Total City ' + totalCityCount + ' FIND CITY');

//             updateCityList(originalCities.slice(0, 10));

//             searchBox.on('input', function () {
//                 var searchTerm = $(this).val().toLowerCase();
//                 var filteredCities = originalCities.filter(function (city) {
//                     return city.city.toLowerCase().includes(searchTerm);
//                 });

//                 updateCityList(filteredCities);
//             });
//         }
//     });

//     function updateCityList(cityArray) {
//         cityList.empty();

//         cityArray.forEach(function (city) {
//             var checkbox = $('<li>' +
//                 '<input type="checkbox"  name="city" class=" text-dark cityfilter" value="' + city.id + '">' +
//                 '<label for="' + city.id + '" class="font-weight-normal p-2 m-0">' +
//                 '' +
//                 '<span class="text-capitalize text-dark">' + city.city + ' ('+ city.totalrecord +') </span>' +
//                 '</label>' +
//                 '</li>');
// checkbox.find('input[type="checkbox"]').on('click', function() {
//         $('input[name="city"]').not(this).prop('checked', false);
//     });
//             cityList.append(checkbox);
//         });
//     }
// });

</script>




            <div class="py-0 pr-3">
                <div style="display: contents;">
                <div class="border-bottom my-1 py-2">
                    <div class="accordion-container accordion-item-opened">
                        <div class="accordion-item-line">
                            <div class="accordion-item-title">
                            <h2 class="filter-title m-0">Program Type</h2>
                            </div>
                            <div class="accordion-item-ani">
                                <div class="toggle">

                                </div>
                            </div>
                        </div>


                        <div class="accordion-item-inner">
                         <div class="accordion-item-content">
                               <div class="course_tag_id">
                                <div class="search-wrap px-3 my-1">
                                <input type="text" placeholder="FIND Program Type" class="jsx-4235027302 search-lavel  border-0 text-sm p-2" value="">
                                <span class="icon icon-search ">
                                    </span>
                                </div>
                                <ul class="jsx-3589932326 pr-0 pl-1 py-1 my-2 mx-0 filter-scroll text-secondary position-relative" id="programlaveluseajax">
                                   
                               
                                    
                                </ul>
                               </div>
                         </div>
                        </div>

                    </div>
                </div>
            </div>
            </div>

            <div class="py-0 pr-3">
                <div style="display: contents;">
                <div class="border-bottom my-1 py-2">
                    <div class="accordion-container accordion-item-opened">
                        <div class="accordion-item-line">
                            <div class="accordion-item-title">
                            <h2 class="filter-title m-0">Course Type</h2>
                            </div>
                            <div class="accordion-item-ani">
                                <div class="toggle">

                                </div>
                            </div>
                        </div>


                        <div class="accordion-item-inner">
                         <div class="accordion-item-content">
                               <div class="course_tag_id">
                                <div class="search-wrap px-3 my-1">
                                <input type="text" placeholder="FIND STREAM" class="jsx-4235027302  border-0 text-sm p-2" value="">
                                <span class="icon icon-search ">
                                    </span>
                                </div>
                                <ul class="jsx-3589932326 pr-0 pl-1 py-1 my-2 mx-0 filter-scroll text-secondary position-relative" id="coursetypedata">
                                    

                                </ul>
                               </div>
                         </div>
                        </div>

                    </div>
                </div>
            </div>
            </div>

         
<div class="py-0 pr-3">
                <div style="display: contents;">
                <div class="border-bottom my-1 py-2">
                    <div class="accordion-container accordion-item-opened">
                        <div class="accordion-item-line">
                            <div class="accordion-item-title">
                            <h2 class="filter-title m-0">Stream</h2>
                            </div>
                            <div class="accordion-item-ani">
                                <div class="toggle">

                                </div>
                            </div>
                        </div>


                        <div class="accordion-item-inner">
                         <div class="accordion-item-content">
                               <div class="course_tag_id">
                                <div class="search-wrap px-3 my-1">
                                <input type="text" placeholder="FIND STREAM" class="jsx-4235027302  border-0 text-sm p-2" value="">
                                <span class="icon icon-search ">
                                    </span>
                                </div>
                                <ul class="jsx-3589932326 pr-0 pl-1 py-1 my-2 mx-0 filter-scroll text-secondary position-relative" id="streamalldata">
                                    

                                </ul>
                               </div>
                         </div>
                        </div>

                    </div>
                </div>
            </div>
            </div>

          

            <style>
                .filter-scroll{
                    max-height: 200px;
    overflow: auto;
                }
                ul{
                    list-style-type: none;
                }
                .search-wrap{
                    border: 1px solid rgb(173, 181, 189);
    border-radius: 16px;
    margin: 0.25rem 0px;
    display: flex;
    width: 99%;
    -webkit-box-align: center;
    align-items: center;
                }
                /* [type="checkbox"]{
                    position: absolute;
    opacity: 0;
    pointer-events: none;
                }  */
                input[type=radio], input[type=checkbox]{
                    box-sizing: border-box;
    padding: 0;
                }
                input[type="checkbox" i] {
                    background-color: initial;
    cursor: default;
    appearance: auto;
    border: initial;
                }
                input{
                    margin: 0;
    font-family: inherit;
                }
                 .search-wrap .search-box{
                    -webkit-box-flex: 1;
    flex-grow: 1;
    color: rgb(73, 80, 87);
    box-shadow: none;
                }
                .icon{
                    display: inline-block;
    vertical-align: middle;
    line-height: initial;
                }
                .accordion-container .accordion-item-content.jsx-3058735975{
                    transition: all 0.5s ease 0s;
                }
                .accordion-container.accordion-item-opened .accordion-item-inner{
                    max-height: 1500rem;
    padding: 5px 0px;
                }
                .accordion-container .accordion-item-inner{
                    overflow: hidden;
    transition: all 0.5s ease 0s;
                }
                .accordion-container .accordion-item-line{
                    display: flex;
    -webkit-box-align: center;
    align-items: center;
    cursor: default;
    outline: none;
                }
                .accordion-container .accordion-item-title{
                    display: flex;
    -webkit-box-align: center;
    align-items: center;
    flex: 1 1 0%;
                }
                .filter-title{
                    letter-spacing: 0.4px;
    color: rgb(50, 60, 79);
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: justify;
    justify-content: space-between;
}
.accordion-container.jsx-3058735975 .accordion-item-ani.jsx-3058735975{
    width: 1.2rem;
    height: 1.2rem;
    display: flex;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
    opacity: 0.6;
    transition: -webkit-transform 0.2s linear 0s;
}
            </style>

             
             
            </div>
          </div>
        </div>
      </div>
      
      <div class="content col-md-9">
          
        <div class="d-flex justify-content-between border-bottom align-items-center">
          <h2 class="title" id="changeclicktitle"></h2>
          <div class="filters-actions">
            <div>
              <button class="btn filter-btn d-md-none"><svg xmlns="http://www.w3.org/2000/svg" class="mr-2" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M3 18h6v-2H3v2zM3 6v2h18V6H3zm0 7h12v-2H3v2z"/></svg>
     Filter</button>
            </div>
            
          </div>
        </div>

        <style>
         .col-8{
            flex: 0 0 auto;
    width: 70.666667%;
         }
         .media-rank{
            color: rgb(112, 117, 122);
    font-size: 0.875rem;
    clear: both;
    text-align: justify;
    height: 35px;
    overflow-x: auto;
    padding-right: 5px;
    margin-right: 1rem;
    white-space: nowrap;

         }
        </style>
        
        <!-- start -->

       
<div class="row row-grid"  id="collegeDataContainer" style="">
    
</div>


<div class="row row-grid"  id="universityDataContainer">
    
</div>
    
    </div>
  </div>
  </div>
</div>


<script>
// $('#loader').show();
$(document).ready(function () {
   
    var initialId = getUrlParameter('id');

$.ajax({
    url: '{{ route("view-college-search") }}',
    type: 'GET',
    data: { id: initialId },
    success: function (data) {
        $('#loader').hide();
        if (data.length === 0) {
           var html = `
               <p style="font-size:50px; text-align:center;">No Result Found!</p>
           `;

           $('#collegeDataContainer').append(html);
        }else{
            fillCollegeData(data);
        }
       
    },
    error: function (xhr, status, error) {
        console.error('Error:', error);
    }
});

// $(document).on('click', '.cityfilter', function () {
//         var id = $(this).val();

//         if (!id) {
//             id = getUrlParameter('id');
//         }

//         $.ajax({
//             url: '{{ route("view-college-search") }}',
//             type: 'GET',
//             data: { id: id },
//             success: function (data) {
//                 if (data.length === 0) {
//                     $('#collegeDataContainer').empty();
//            var html = `
//                <p style="font-size:50px; text-align:center;">No Result Found!</p>
//            `;

//            $('#collegeDataContainer').append(html);
//         }else{
//             fillCollegeData(data);
//         }
//             },
//             error: function (xhr, status, error) {
//                 $('#collegeDataContainer').empty();
//                 console.error('Error:', error);
//             }
//         });
//     });

    $(document).on('click', '.coursefilterdata', function () {
        var id = $(this).val();
        // alert(id);
        $('#changeclicktitle').text('List of institute based on '+id+' ');

        if (!id) {
            id = getUrlParameter('id');
        }
   
        $.ajax({
            url: '{{ route("view-course-fill-search") }}',
            type: 'GET',
            data: { course: id },
            success: function (data) {
                // fillCollegeData(data);
                if (data.length === 0) {
                $('#collegeDataContainer').empty();
           var html = `
               <p style="font-size:50px; text-align:center;">No Result Found!</p>
           `;

           $('#collegeDataContainer').append(html);
        }else{
            fillCollegeData(data);
        }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    $(document).on('click', '.total-in', function () {
        var id = $(this).val();
        // alert(id);
        $('#changeclicktitle').text('List of institute based on '+id+' ');
    //  alert(id);
        if(id === "Agriculture"){
            var mainId = ['BSc Agriculture', 'MSc Agriculture', 'B.Tech Agriculture', 'M.Tech Agriculture'];
        } else if (id === "Architecture"){
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
       }else if (id === "Law"){
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

        if (!id) {
            id = getUrlParameter('id');
        }
   
        $.ajax({
            url: '{{ route("view-course-stream-search") }}',
            type: 'GET',
            data: { course: mainId },
            success: function (data) {
                // fillCollegeData(data);
                if (data.length === 0) {
                $('#collegeDataContainer').empty();
           var html = `
               <p style="font-size:50px; text-align:center;">No Result Found!</p>
           `;

           $('#collegeDataContainer').append(html);
        }else{
            fillCollegeData(data);
        }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    $(document).on('click', '.stateListfilter', function () {
        var id = $(this).val();
        // $('#changeclicktitle').text('List of institute based on '+id+' ');

        if (!id) {
            id = getUrlParameter('id');
        }
   
        $.ajax({
            url: '{{ route("view-state-search") }}',
            type: 'GET',
            data: { state: id },
            success: function (data) {
                if (data.length === 0) {
                    $('#collegeDataContainer').empty();
           var html = `
               <p style="font-size:50px; text-align:center;">No Result Found!</p>
           `;

           $('#collegeDataContainer').append(html);
        }else{
            fillCollegeData(data);
        }
            },
            error: function (xhr, status, error) {
                $('#collegeDataContainer').empty();
                console.error('Error:', error);
            }
        });
    });

    $(document).on('change', '.filled-in', function() {
        if($(this).is(':checked')) {
            var checkedValue = $(this).val();
            $('#changeclicktitle').text('List of institute based on '+checkedValue+' ');

            $.ajax({
            url: '{{ route("view-lavel-search") }}',
            type: 'GET',
            data: { lavel: checkedValue },
            success: function (data) {
                if (data.length === 0) {
                    $('#collegeDataContainer').empty();
           var html = `
               <p style="font-size:50px; text-align:center;">No Result Found!</p>
           `;

           $('#collegeDataContainer').append(html);
        }else{
            fillCollegeData(data);
        }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
           
        }
    });

    $(document).on('change', '.course-in', function() {
        if($(this).is(':checked')) {
            var checkedValue = $(this).val();
            $('#changeclicktitle').text('List of institute based on '+checkedValue+' ');
            // alert(checkedValue);

            $.ajax({
            url: '{{ route("view-course-search") }}',
            type: 'GET',
            data: { type: checkedValue },
            success: function (data) {
                if (data.length === 0) {
                    $('#collegeDataContainer').empty();
           var html = `
               <p style="font-size:50px; text-align:center;">No Result Found!</p>
           `;

           $('#collegeDataContainer').append(html);
        }else{
            fillCollegeData(data);
        }
            },
        });
           
        }
    });

    function generateUrlFriendlyName(name) {
const urlFriendlyName = name.replace(/\s+/g, '/');
return urlFriendlyName; 
}

    function fillCollegeData(data) {
        var collegeDataContainer = $('#collegeDataContainer');
        collegeDataContainer.empty();
        

        $.each(data.data, function(index, college) {
    var cleanedName = generateUrlFriendlyName(college.name);

    var facilitiesHtml = '';
    $.each(college.facilities, function(index, facility) {
        facilitiesHtml += `
     
        <li class="text-start" id="facolityalldatafill">        
            <h6>
                <img src="icons/${facility.facility_image}" style="width:50px;" class="img-thumbnail" alt="">
                <span style="text-align:center;">
                ${facility.facility_name}
                </span>
            </h6>
            </li>
        
        `;
    });

    var assetUrl = "{{ asset('') }}";

    var html = `
        <div class="col-md-6 col-lg-6 col-xl-12">
            <div class="card" style="border-radius : 0!important;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="position-relative">
                                <div class="img-container rounded" style="height: auto!important;">
                                 <img src="` + assetUrl + `college/${college.image}" class="img-fluid" alt="">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="d-flex">
                                <div class="mr-2">
                                <div class="logo-container">
                            <img src="{{asset('college/logo/${college.logo}')}}" style="height:80px;" class=""  alt="">
                             </div>

                                </div>
                                <div class="flex-column">
                                    <div class="college-info">
                                        <a class="text-secondary" href="{{route('view-details')}}?id=${college.name}">
                                            <h4>${college.name}</h4>
                                            <p class="text-danger"><i class="fa fa-map-marker" aria-hidden="true"></i> 
                                            ${college.address} &nbsp; ${college.city} &nbsp; ${college.state}
                                            </p>
                                            <p class="text-dark">
                                            ${college.description} 
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <hr class="mt-2 mb-0">
                            <div class="d-flex align-items-center">
                                <div class="w-100 college-links mr-3">
                                    <ul class="border-right d-flex align-items-center">
                                   <h5> Facility:  </h5>
                                    ${facilitiesHtml}
                                    </ul>
                                </div>
                            </div>
                            <hr class="m-0 mb-2">
                            <div class="d-flex">
                                <div class="w-100 media-rank">
                                    <div class="rank-container">
                                        <div class="rankings">
                                            <h6>ESTB Year: ${college.Established}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100">
                                    <div class="d-flex card-buttons">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Apply Now</button>
                                        &nbsp;
                                        <a href="{{route('view-details')}}?id=${cleanedName}" class="btn w-100 btn-outline-secondary mr-1">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    collegeDataContainer.append(html);
});

      
    }

    function filluniversityData(data) {
        var universityDataContainer = $('#universityDataContainer');
        universityDataContainer.empty();

        var html = `
       
     

                            <div class="college-fees w-100 d-flex justify-content-between">
                                <div class="my-2 w-100">
                                    <h6>
M.Phil/Ph.D in Pharmacy</h6>
                                    <p class="jsx-393627179 text-muted text-capitalize mb-0">₹ 1.66 Lakhs</p>
                                </div>
                            </div>
                        </div>

                        <hr class="m-0 mb-2">

                        <div class="d-flex">
                            <div class="w-100 media-rank">
                                <div class="rank-container">
                                    <div class="rankings">
                                        <span class="jsx-393627179 agency-name mr-1">NIRF &nbsp;ranking 4 out of 40 in 2023</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-100">
                                <div class="d-flex card-buttons">
                                    <button type="button" data-csm-track="true" data-csm-href="javascript:void(0)" class="btn w-100 btn-outline-primary mr-1" >Apply Now</button>
                                  &nbsp;
                                    <button type="button" data-csm-track="true" data-csm-href="javascript:void(0)" class="btn w-100 btn-outline-secondary mr-1" >Read More</button>
                                    <!-- <button type="button" data-csm-track="true" data-csm-href="javascript:void(0)" class="btn w-100 btn-outline-light-dark mr-1" >Brochure</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        `;
        universityDataContainer.append(html);
    }

    function getUrlParameter(name) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

});

    </script>

<script>
 
$(".filter-btn").click(function () {
  $(".sidebar").addClass("open");
  $("body").addClass("overflow-hidden vh-100");
});


$(".filter-close-btn").click(function () {
  $(".sidebar").removeClass("open");
  $("body").removeClass("overflow-hidden vh-100");
});

</script>

<script>
                $(document).ready(function () {
    var originalCities;
    var cityList = $('#courselist');
    var searchBox = $('.coursefilterdata');
    // alert(searchBox);
    // <h2 class="title" iid="changeclicktitle">List of Top Colleges In India based on 2024</h2>  

    $.ajax({
        url: "{{ route('course-filter-search') }}",
        type: "GET",
        dataType: "json",
        success: function (response) {
            originalCities = response.program;
            var totalCityCount = originalCities.length;
            searchBox.attr('placeholder', 'Total Course ' + totalCityCount + ' FIND Course');

            updateCityList(originalCities.slice(0, 10));

            searchBox.on('input', function () {
                var searchTerm = $(this).val().toLowerCase();
                var filteredCities = originalCities.filter(function (program) {
                    return program.name.toLowerCase().includes(searchTerm);
                });

                updateCityList(filteredCities);
            });
        }
    });

    function updateCityList(cityArray) {
        cityList.empty();

        cityArray.forEach(function (program) {
            var checkbox = $('<li>' +
                '<input type="radio" name="city" class=" text-dark coursefilterdata" value="' + program.name + '">' +
                '<label for="' + program.id + '" class="font-weight-normal p-2 m-0">' +
                '<a href="#" class="text-dark">' +
                '<span class="text-capitalize">' + program.name + ' ('+ program.totalrecord +') </span></a>' +
                '</label>' +
                '</li>');

            cityList.append(checkbox);
        });
    }
});
            </script>

<script>
$(document).ready(function () {
    var originalCities;
    var cityList = $('#statelist');
    var searchBox = $('.state-box');

    $.ajax({
        url: "{{ route('state-filter-search') }}",
        type: "GET",
        dataType: "json",
        success: function (response) {
            originalCities = response.state;
            var totalCityCount = originalCities.length;
            searchBox.attr('placeholder', 'Total State ' + totalCityCount + ' FIND State');

            updateCityList(originalCities.slice(0, 10));

            searchBox.on('input', function () {
                var searchTerm = $(this).val().toLowerCase();
                var filteredCities = originalCities.filter(function (state) {
                    return state.state.toLowerCase().includes(searchTerm);
                });

                updateCityList(filteredCities);
            });
        }
    });

    function updateCityList(cityArray) {
        cityList.empty();

        cityArray.forEach(function (state) {
            var checkbox = $('<li>' +
                '<input type="radio" name="city" class=" text-dark stateListfilter" value="' + state.id + '">' +
                '<label for="' + state.id + '" class="font-weight-normal p-2 m-0">' +
                '<a href="#" class="text-dark">' +
                '<span class="text-capitalize">' + state.state + ' ('+ state.totalrecord +')</span></a>' +
                '</label>' +
                '</li>');
                checkbox.find('input[type="checkbox"]').on('click', function() {
        $('input[name="city"]').not(this).prop('checked', false);
    });
            cityList.append(checkbox);
        });
    }
});

</script>

<script>
$(document).ready(function () {

    $.ajax({
    url: "{{ route('get-program-level') }}",
    type: "GET",
    dataType: "json",
    success: function (response) {
        var html = `
            <li>
                <input id="certificate" type="radio" name="check" class="jsx-3589932326 filled-in" value="certificate">
                <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                    <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                        <span class="jsx-3589932326 text-capitalize">Certificate <span class="jsx-3589932326 text-raven">(${response.certificate})</span></span>
                    </a>
                </label>
            </li>
            <li>
                <input id="diploma" type="radio" name="check" class="jsx-3589932326 filled-in" value="diploma">
                <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                    <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                        <span class="jsx-3589932326 text-capitalize">Diploma <span class="jsx-3589932326 text-raven">(${response.Diploma})</span></span>
                    </a>
                </label>
            </li>
            <li>
                <input id="pg" type="radio" name="check" class="jsx-3589932326 filled-in" value="pg">
                <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                    <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                        <span class="jsx-3589932326 text-capitalize">Post Graduate <span class="jsx-3589932326 text-raven">(${response.PG})</span></span>
                    </a>
                </label>
            </li>
            <li>
                <input id="ug" type="radio" name="check" class="jsx-3589932326 filled-in" value="ug">
                <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                    <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                        <span class="jsx-3589932326 text-capitalize">Under Graduate <span class="jsx-3589932326 text-raven">(${response.UG})</span></span>
                    </a>
                </label>
            </li>
        `;

        var $html = $(html);

        $html.find('input[type="checkbox"]').on('click', function() {
            $('input[name="check"]').not(this).prop('checked', false);
        });

        $('#programlaveluseajax').append($html);
    }
});


});

</script>

<script>
$(document).ready(function () {

    $.ajax({
    url: "{{ route('get-course-type') }}",
    type: "GET",
    dataType: "json",
    success: function (response) {
        var html = `
            <li>
                <input id="certificate" type="radio" name="check" class="jsx-3589932326 course-in" value="Distance">
                <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                    <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                        <span class="jsx-3589932326 text-capitalize">Distance <span class="jsx-3589932326 text-raven">(${response.Distance})</span></span>
                    </a>
                </label>
            </li>
            <li>
                <input id="diploma" type="radio" name="check" class="jsx-3589932326 course-in" value="fulltime">
                <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                    <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                        <span class="jsx-3589932326 text-capitalize">Full Time <span class="jsx-3589932326 text-raven">(${response.fulltime})</span></span>
                    </a>
                </label>
            </li>
            <li>
                <input id="pg" type="radio" name="check" class="jsx-3589932326 course-in" value="online">
                <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                    <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                        <span class="jsx-3589932326 text-capitalize"> Online <span class="jsx-3589932326 text-raven">(${response.online})</span></span>
                    </a>
                </label>
            </li>
            <li>
                <input id="ug" type="radio" name="check" class="jsx-3589932326 course-in" value="parttime">
                <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                    <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                        <span class="jsx-3589932326 text-capitalize">Part Time <span class="jsx-3589932326 text-raven">(${response.parttime})</span></span>
                    </a>
                </label>
            </li>
        `;

        var $html = $(html);

        $html.find('input[type="checkbox"]').on('click', function() {
            $('input[name="check"]').not(this).prop('checked', false);
        });

        $('#coursetypedata').append($html);
    }
});


});

</script>

<script>
$(document).ready(function () {

    $.ajax({
    url: "{{ route('get-stream-type') }}",
    type: "GET",
    dataType: "json",
    success: function (response) {
        var html = `
            <li>
                <input id="certificate" type="radio" name="check" class="jsx-3589932326 total-in" value="Agriculture">
                <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                    <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                        <span class="jsx-3589932326 text-capitalize">Agriculture <span class="jsx-3589932326 text-raven">(${response.totalAgriculture})</span></span>
                    </a>
                </label>
            </li>
           
            <li>
                                    <input id="diploma" type="radio" name="check" class="jsx-3589932326 total-in" value="Architecture">
                                    <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                                        <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                                        <span class="jsx-3589932326 text-capitalize">Architecture <span class="jsx-3589932326 text-raven">(${response.totalArchitecture})</span></span></a></label>
                                    </li>

                                    <li>
                                    <input id="pg" type="radio" name="check" class="jsx-3589932326 total-in" value="Arts">
                                    <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                                        <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                                        <span class="jsx-3589932326 text-capitalize"> Arts <span class="jsx-3589932326 text-raven">(${response.totalArts})</span></span></a></label>
                                    </li>

                                    <li>
                                    <input id="ug" type="radio" name="check" class="jsx-3589932326 total-in" value="Commerce">
                                    <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                                        <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                                        <span class="jsx-3589932326 text-capitalize">Commerce <span class="jsx-3589932326 text-raven">(${response.totalCommerce})</span></span></a></label>
                                    </li>

                                    <li>
                                    <input id="ug" type="radio" name="check" class="jsx-3589932326 total-in" value="Education">
                                    <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                                        <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                                        <span class="jsx-3589932326 text-capitalize">Education <span class="jsx-3589932326 text-raven">(${response.totalEducation})</span></span></a></label>
                                    </li>

                                    <li>
                                    <input id="ug" type="radio" name="check" class="jsx-3589932326 total-in" value="Engineering">
                                    <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                                        <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                                        <span class="jsx-3589932326 text-capitalize">Engineering <span class="jsx-3589932326 text-raven">(${response.totalEngineering})</span></span></a></label>
                                    </li>

                                    <li>
                                    <input id="ug" type="radio" name="check" class="jsx-3589932326 total-in" value="Fashion">
                                    <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                                        <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                                        <span class="jsx-3589932326 text-capitalize">Fashion & Design <span class="jsx-3589932326 text-raven">(${response.totalFashionDesign})</span></span></a></label>
                                    </li>

                                    <li>
                                    <input id="ug" type="radio" name="check" class="jsx-3589932326 total-in" value="Law">
                                    <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                                        <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                                        <span class="jsx-3589932326 text-capitalize">Law <span class="jsx-3589932326 text-raven">(${response.totalLaw})</span></span></a></label>
                                    </li>

                                    <li>
                                    <input id="ug" type="radio" name="check" class="jsx-3589932326 total-in" value="Management">
                                    <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                                        <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                                        <span class="jsx-3589932326 text-capitalize">Management <span class="jsx-3589932326 text-raven">(${response.totalManagement})</span></span></a></label>
                                    </li>

                                    <li>
                                    <input id="ug" type="radio" name="check" class="jsx-3589932326 total-in" value="Medical">
                                    <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                                        <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                                        <span class="jsx-3589932326 text-capitalize">Medical <span class="jsx-3589932326 text-raven">(${response.totalMedical})</span></span></a></label>
                                    </li>

                                    <li>
                                    <input id="ug" type="radio" name="check" class="jsx-3589932326 total-in" value="Pharmacy">
                                    <label for="Course-120" title="MBA/PGDM" class="jsx-3589932326 font-weight-normal p-2 m-0 ">
                                        <a href="https://zollege.in/mba-colleges" class="jsx-3589932326 text-dark">
                                        <span class="jsx-3589932326 text-capitalize">Pharmacy <span class="jsx-3589932326 text-raven">(${response.totalPharmacy})</span></span></a></label>
                                    </li>
        `;

        var $html = $(html);

        $html.find('input[type="checkbox"]').on('click', function() {
            $('input[name="check"]').not(this).prop('checked', false);
        });

        $('#streamalldata').append($html);
    }
});


    

});

</script>

@endsection
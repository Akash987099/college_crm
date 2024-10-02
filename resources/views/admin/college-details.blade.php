@extends('admin.layouts.master')

@section('contant')


<div class="content-wrapper">
<div class="container-xxl flex-grow-1 container-p-y">
<button type="button" class="btn btn-primary mb-3 text-right" id="university_add">
        Add
    </button>
    
    <!-- <button  type="button" class="btn btn-primary mb-3 " id="university_search">Search</button> -->
    <form action="" method="POST" id="search">
    <div class="row">

    <div class="mb-2 col-md-4">
    <select class="form-control " id="type_search_input" name="">
        <option value="">Select University Type</option>
        <option value="Goverment">Government</option>
        <option value="Private">Private</option>
    </select>
</div>

                          <div class="mb-2 col-md-4">
                            <select class="form-control specialchar"  name="university_search_input" id="university_search_input">
                               <option value="">Select University</option>
                               @foreach($university as $key => $val)
                             <option value="{{$val->name}}">{{$val->name}}</option>
                             @endforeach
                            </select>
                          </div>

                          <div class="mb-2 col-md-4">
    <select class="form-control " id="state_search_input" name="state_search_input">
        <option value="">Select State </option>
        @foreach($state as $key => $val)
        <option value="{{$val->id}}">{{$val->state_name}}</option>
        @endforeach
    </select>
</div>

</div>
    </form>
   
                        <div class="card">
                <h5 class="card-header">College</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                  
                    <table class="table " id="datatable">
                    <thead class="">
                      <tr >
                      <th >S No.</th>
                      <th >College</th>
                      <th >University</th>
                      <th >Type</th>
                      <th >State</th>
                      <th >Top College</th>
                      <th >Action</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 table-bordered">
                     
                    </tbody>
                  </table>
                  </div>
                </div>
              <!-- </div> -->

      <!-- <div class="content-wrapper"> -->


<div class="container-xxl flex-grow-1 container-p-y">
             
              <div class="row" id="add_university">
                <div class="col-md-12">
                  <!-- <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0);"><i class="fa fa-university me-1"></i> University</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('college')}}"
                        ><i class="fa fa-graduation-cap me-1"></i> College</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('user')}}"
                        ><i class="bx bx-user me-1"></i> User</a
                      >
                    </li>
                  </ul> -->
                  <div class="card mb-4">
                    <!-- <h5 class="card-header">University Details</h5> -->
                    <!-- Account -->
                    
                    <div class="card-body">

                      <form id="collegeadd" method="POST" enctype="multipart/form-data">
                      @csrf
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">College Name<span class="required">*</span></label>
                            <input
                              class="form-control specialchar"
                              type="text"
                              id="college"
                              maxlength="100"
                              name="college"
                              placeholder = " Name"
                            />
                            <span id="showerrormessage"></span>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="University">University <span class="required">*</span></label>
                            <select id="university" name="university" class="select2 form-select">
                              <option value="">Select</option>
                             @foreach($university as $key => $val)
                             <option value="{{$val->id}}">{{$val->name}}</option>
                             @endforeach
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input onKeyPress="if(this.value.length==100) return false;" type="text" class="form-control addressallow" id="address" name="address" placeholder="Address" />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">Country<span class="required">*</span></label>
                            <select id="countrydata" name="country" class="select2 form-select">
                              <option value="">Select</option>
                              @foreach($Country as $key => $val)
                             <option value="{{$val->id}}">{{$val->country_name}}</option>
                             @endforeach
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">State<span class="required">*</span></label>
                            <select id="statedata" name="state" class="select2 form-select">
                              <option value="">Select</option>
                             
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="city" class="form-label">City<span class="required">*</span></label>
                            <select id="citydata" name="city" class="select2 form-select">
                              <option value="">Select</option>
                              
                            </select>
                          </div>
                          
                          <div class="mb-3 col-md-6">
    <label for="zipCode" class="form-label">Pincode Code</label>
    <input
        type="text"
        class="form-control"
        id="zipCode"
        name="zipCode"
        placeholder="Postalcode"
        maxlength="6"
        pattern="[0-9]*" 
        title="Please enter only numeric values"
        oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
        required
    />
</div>

<div class="mb-3 col-md-6">
    <label for="Established" class="form-label">Estb Year</label>
    <input
    type="text"
    class="form-control"
    id="Established"
    name="Established"
    placeholder="Established Year"
    maxlength="4"
    pattern="[0-9]*"
    min="1800"
    title="Please enter only numeric values"
    oninput="validateYear(this)"
    onkeypress="checkKeyPress(event)"
    required
/>

           </div>

                          <div class="mb-3 col-md-6">
                            <label for="zipCode" class="form-label">College Type</label>
                            <select id="college_type" name="college_type" class="select2 form-select">
                              <option value="">Select</option>
                              <option value="Goverment">Goverment</option>
                              <option value="Private">Private</option>
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="image" class="form-label">Image<span class="required">*</span></label>
                            <input class="form-control image" type="file" id="image" name="image" placeholder="Address" />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="logo" class="form-label">Logo<span class="required">*</span></label>
                            <input class="form-control logo" type="file" id="logo" name="logo" placeholder="Address" />
                          </div>
                        
                        


                          <div class="mb-3 col-md-12">
                            <label for="zipCode" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="5"></textarea>
                              
                            </textarea>
                          </div>
                         
                        <div class="mt-2">
                          <button type="submit" id="save" class="btn btn-primary me-2">Save</button>
                          <button type="reset" id="close" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                      </form>
                    <!-- /Account -->
                  </div>
                  
                </div>
              </div>
              </div>

  </div>


  <div class="row" id="collegeupdate">
    <div class="col-md-12">
      <div class="card mb-4">
       
        <div class="card-body">


          <form class="universityupdate" method="POST">
          @csrf
          <input type="text" id="update_update_id" name="id" hidden>
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label">College Name <span class="required">*</span></label>
                <input
                  class="form-control specialchar"
                  type="text"
                  id="update_college"
                  name="college"
                  placeholder = " Name"
                />
              </div>


              <div class="mb-3 col-md-6">
                <label for="state" class="form-label">University<span class="required">*</span></label>
                <select id="update_university" name="university" class="select2 form-select">
                  <option value="">Select</option>
                  @foreach($university as $key => $val)
                  <option value="{{$val->id}}">{{$val->name}}</option>
                  @endforeach
                </select>
              </div>
            
              <div class="mb-3 col-md-6">
                <label for="address" class="form-label">Address</label>
                <input onKeyPress="if(this.value.length==100) return false;" type="text"  class="form-control addressallow" id="update_address" name="address" placeholder="Address" />
              </div>

              <div class="mb-3 col-md-6">
                <label class="form-label" for="country">Country<span class="required">*</span></label>
                <select id="update_Country" name="Country" class="select2 form-select update_Country">
                  <option value="">Select</option>
                  @foreach($Country as $key => $val)
                             <option value="{{$val->id}}">{{$val->country_name}}</option>
                             @endforeach
                </select>
              </div>

              <div class="mb-3 col-md-6">
                <label for="state" class="form-label">State<span class="required">*</span></label>
                <select id="update_state" name="state" class="select2 form-select">
                  <option value="">Select</option>
                  
                </select>
              </div>

              <div class="mb-3 col-md-6">
                <label class="form-label" for="city">City<span class="required">*</span></label>
                <select id="update_city" name="city" class="select2 form-select">
                  <option value="">Select</option>
                
                </select>
              </div>

              <div class="mb-3 col-md-6">
<label for="zipCode" class="form-label">Postal Code</label>
<input
type="text"
class="form-control"
id="update_zipCode"
name="zipCode"
placeholder="231465"
maxlength="6"
pattern="[0-9]*" 
title="Please enter only numeric values"
oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
required
/>
</div>

              <div class="mb-3 col-md-6">
                <label for="Established" class="form-label">Estb year</label>
                <input
        type="text"
        class="form-control"
        id="update_Established"
        name="Established"
        placeholder="Established Year"
        maxlength="4"
        pattern="[0-9]*"
        min="1980"
        title="Please enter only numeric values"
        oninput="validateYear(this)"
        onkeypress="checkKeyPress(event)"
        required
    />
               
              </div>
              

              <div class="mb-3 col-md-6">
                <label for="zipCode" class="form-label">College Type</label>
                <select id="update_university_type" name="college_type" class="select2 form-select">
                  <option value="">Select</option>
                  <option value="Goverment">Goverment</option>
                  <option value="Private">Private</option>
                </select>
              </div>

              <div class="mb-3 col-md-12">
                <label for="zipCode" class="form-label">Description</label>
                <textarea class="form-control" name="update_description" id="update_description" id="exampleFormControlTextarea1" rows="5">
               </textarea>
              </div>

              <div class="mb-3 col-md-6">
                <label for="address" class="form-label">image<span class="required">*</span></label>
                <input  type="file"  class="form-control" id="image_update" name="image" />
                <img src="" alt="" style="width:100px;" id="imagePreview">
              </div>

              <div class="mb-3 col-md-6">
                <label for="address" class="form-label">Logo<span class="required">*</span></label>
                <input  type="file"  class="form-control" id="logo_update" name="logo" />
                <img src="" alt="" style="width:100px;" id="logoPreview">
              </div>

              
             
            <div class="mt-2">
              <button type="submit" id="submit" class="btn btn-primary me-2">Save</button>
              <button type="reset" id="close" class="btn btn-outline-secondary">Cancel</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>


            <script>

$('#add_university').hide();
$('#collegeupdate').hide();

// 

$(document).on('click', '#university_add', function() {
  $('html, body').scrollTop($(document).height());
    $('#add_university').show();
    $('#collegeupdate').hide();
});

$(document).on('click', '#close', function() {
  $('html, body').scrollTop($(document).height());
    $('#add_university').hide();
    $('#collegeupdate').hide();
});

     
$("#countrydata").change(function() {
         var countryId = $(this).val();
         $('#statedata').empty().append($('<option>', {
            value: '',
            text: 'Select State'
         }));
         $('#citydata').empty().append($('<option>', {
            value: '',
            text: 'Select City'
         }));
         $.ajax({
            url: "{{ route('getstate-bycountry-id') }}",
            dataType: "json",
            type: "get",
            data: { 'id': countryId },
            success: function(response) {
               if (response.status === 'success' && response.data.length > 0) {
                  $.each(response.data, function(index, state) {
                     $('#statedata').append($('<option>', {
                        value: state.id,
                        text: state.state_name
                     }));
                  });
               } else {

               }
            },
         });
      });


      $("#statedata").change(function() {
         var stateId = $(this).val();
         $('#citydata').empty().append($('<option>', {
            value: '',
            text: 'Select City'
         }));
         $.ajax({
            url: "{{ route('getcity-bystate-id') }}",
            dataType: "json",
            type: "get",
            data: { 'id': stateId },
            success: function(response) {
               if (response.status === 'success' && response.data.length > 0) {
                  $.each(response.data, function(index, city) {
                     $('#citydata').append($('<option>', {
                        value: city.id,
                        text: city.city_name
                     }));
                  });
               } else {
                  // Handle the case when no states are found for the selected country
               }
            },
         });
      });


      $('.specialchar').on('keypress',function(e){
  var regex = new RegExp("^[a-zA-Z., -]");
            var key=String.fromCharCode(!e.charCode ? e.which :e.charCode);
            if(!regex.test(key  )){
                e.preventDefault();
                return false;
            }
        });

        $('.addressallow').on('keypress', function (e) {
    var regex = new RegExp("^[a-zA-Z0-9., -]");
    var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (!regex.test(key)) {
        e.preventDefault();
        return false;
    }
});

                 $(document).ready(function(){
                  $(document).on('click' , '#save' , function(event){
                    event.preventDefault();
                    var formdata = new FormData($('#collegeadd')[0]);
                    $('.err').remove();
                    $.ajax({
                      url : "{{route('college-add')}}",
                      type : "POST",
                      contentType: false,
                      processData: false,
                      data : formdata,
                      success : function(response){
                        if (response.status == "success") {
                           alert(response.message);
                           table.ajax.reload();
                           $('#collegeadd')[0].reset();
                          //  $('html, body').scrollTop($('#collegeadd').offset().top);
                          $('html, body').scrollTop($(document).height());

                        } else if (response.status == 'error') {
    $.each(response.message, function(i, message) {
        if (i == "university") {
            updateErrorMessage('#university_error', message);
        }else if (i == "college") {
            updateErrorMessage('#college_error', message);
            
        } else if (i == "city") {
            updateErrorMessage('#citydata_error' ,'The college has already been taken. in this city');
        }
         else if (i == "Established") {
            updateErrorMessage('#Established_error', 'Year must be greater than 1800 or equal to the current year.');
        } else if (i == "zipCode") {
            updateErrorMessage('#zipCode_error', 'must be a 6-digit number required');
        } else if (i == "image") {
            updateErrorMessage('#image_error', message);
        } else if (i == "logo") {
            updateErrorMessage('#logo_error', message);
        }
        else if (i == "state") {
            updateErrorMessage('#statedata_error', message);
        }
        else if (i == "country") {
            updateErrorMessage('#countrydata_error', message);
        }
    });
}

function updateErrorMessage(elementId, errorMessage) {
    var errorMessageElement = $(elementId);
    if (errorMessageElement.length) {
        errorMessageElement.text(errorMessage);
    } else {
        $(elementId.replace('_error', '')).after('<span id="' + elementId.replace('#', '') + '" class="err" style="color:red">' + errorMessage + '</span>');
    }
}
                      }
                    });
                  });
                 });
         
    
                
   var table = $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    searching: true,
    ajax: {
        url: "{{ route('college-list') }}",
        type: 'GET',
        data: function (d) {
            d.university_search = $('#university_search_input').val();
            d.type_search_input = $('#type_search_input').val();
            d.state_search_input = $('#state_search_input').val();
        }
    },
    columns: [
        {
            data: 'id',
            orderable: false,
            className: 'text-center'
        },
        {
    data: 'name',
    orderable: true,
    className: 'text-left',
    render: function (data, type, row) {
        // Split the data into words
        var words = data.split(' ');

        // Use a newline character after every 20 words
        var result = '';
        for (var i = 0; i < words.length; i++) {
            result += words[i] + ' ';
            if ((i + 1) % 21 === 0 && i !== 0) {
                result += '<br>';
            }
        }

        return result.trim(); 
    }
},
        {
    data: 'university_name',
    orderable: true,
    className: 'text-left',
    render: function (data, type, row) {
        // Split the data into words
        var words = data.split(' ');

        // Use a newline character after every 20 words
        var result = '';
        for (var i = 0; i < words.length; i++) {
            result += words[i] + ' ';
            if ((i + 1) % 21 === 0 && i !== 0) {
                result += '<br>';
            }
        }

        return result.trim(); 
    }
},
        {
            data: 'type',
            orderable: true,
            className: 'text-center'
        },
        {
            data: 'address',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'status',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'action',
            orderable: false,
            className: 'text-center'
        }
    ],
    lengthMenu: [10, 25, 50, 100],
    pageLength: 25,
    scrollY: '800px',
    scrollCollapse: true,
    
});


  $('#university_search_input').on('input', function () {
    var universitySearchValue = $(this).val();
    console.log('University Search Value:', universitySearchValue);
    table.draw();
});

$('#type_search_input').on('input', function () {
    var universitySearchValue = $(this).val();
    console.log('University Search Value:', universitySearchValue);
    table.draw();
});

$('#state_search_input').on('input', function () {
    var universitySearchValue = $(this).val();
    console.log('University Search Value:', universitySearchValue);
    table.draw();
});


$('body').on('click' , '.tglbtn' , function(){
  var id = $(this).attr('data-id');
  var confirmation = confirm("Are you sure you want to Change this Record?");
  if(confirmation){

    $.ajax({
        url : "{{route('college-top-status')}}",
        type : "GET",
        data : {id : id},
        success : function(response){
          alert('Change Status successfully!')
          table.ajax.reload();
        }
    });
  }else{

  }
});


        $('body').on('click', '.delete', function() {
          var confirmation = confirm("Are you sure you want to Delete this Record?");
          if (confirmation) {
                var id = $(this).attr('data-id');
                    $.ajax({
                        url: "{{ route('college-delete') }}",
                        dataType: "json",
                        type: "GET",
                        data: {
                            'id': id
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                              table.ajax.reload();
                            } else if (response.status == 'error') {
                                alert(response.message);
                            } 
                        },
                    });
                  }else{

                  }
                return false;
            });

            

            $('body').on('click', '.edit', function() {
              $('#add_university').hide();
                var id = $(this).attr('data-id');
                    $.ajax({
                        url: "{{ route('college-edit') }}",
                        dataType: "json",
                        type: "GET",
                        data: {
                            'id': id
                        },
                        success: function(response) {
                            if (response) {    
                              // console.log(response.address); 
                        $('.createform').addClass('d-none');
                        $('.viewform').addClass('d-none');
                        $('.updateform').removeClass('d-none');

                  $.each(response, function(index, item){
                        var countryId=item.country;
                        var stateId = item.state;
                        var cityId = item.city;
                        var uni_id = item.uni_id;

                        $.ajax({
                            url: "{{ route('getstate-byuniversity-id') }}",
                            dataType: "json",
                            type: "get",
                            data: { 'id': uni_id },
                            success: function (response) {
                              // console.log(response);
                                if (response.status == 'success' && response.data.length > 0) {
                                    $.each(response.data, function (index, university) {
                                      // console.log(university.name);
                                        $('#update_university').append($('<option>', {
                                            value: university.id,
                                            text: university.name
                                        }));
                                        
                                    });
                                    $('#update_university option[value="' + uni_id + '"]').prop('selected', true);
                                }
                            },
                        });

                        $.ajax({
                            url: "{{ route('getstate-bycountry-id') }}",
                            dataType: "json",
                            type: "get",
                            data: { 'id': countryId },
                            success: function (response) {
                              // console.log(response);
                                if (response.status == 'success' && response.data.length > 0) {
                                    $.each(response.data, function (index, state) {
                                      // console.log(state.id);
                                        $('#update_state').append($('<option>', {
                                            value: state.id,
                                            text: state.state_name
                                        }));
                                        
                                    });
                                    $('#update_state option[value="' + stateId + '"]').prop('selected', true);
                                }
                            },
                        });

                        $.ajax({
                            url: "{{ route('getcity-bystate-id') }}",
                            dataType: "json",
                            type: "get",
                            data: { 'id': stateId },
                            success: function(response) {
                              // console.log(response);
                            if (response.status === 'success' && response.data.length > 0) {
                                $.each(response.data, function(index, city) {
                                  console.log(city);
                                    $('#update_city').append($('<option>', {
                                        value: city.id,
                                        text: city.city_name
                                    }));
                                    
                                });
                                $('#update_city option[value="' + cityId + '"]').prop('selected', true);

                            } 
                            },
                        });

                        console.log(item.country);

                                 var imageUrl = "{{ asset('college/') }}" + '/' +item.image; 
                                 $('#imagePreview').attr('src', imageUrl);

                                 var logourl = "{{ asset('college/logo/') }}" + '/' + item.logo; 
                                 $('#logoPreview').attr('src', logourl);
                              
                                 $('#update_update_id').val(item.id);
                                 $('#update_college').val(item.name);
                                 $('#update_address').val(item.address);
                                //  $('#update_state').val(item.state);
                                // $('#updatestate option[value="' + item.state + '"]').prop('selected', true);
                                 $('#update_Country').val(item.country);
                                 $('#update_zipCode').val(item.pincode);
                                 $('#update_Established').val(item.Established);
                                 $('#update_Department').val(item.department);
                                 $('#update_university_type').val(item.type);
                                 $('#update_description').val(item.description);
                                //  $('html, body').scrollTop($('#collegeupdate').offset().top);
                                 $('html, body').scrollTop($(document).height());
                                 $('#collegeupdate').show();
                                  });
                              
                            } else if (response.status == 'error') {

                                alert(response.message);
                            } 
                        },
                    });
                return false;
            });

          

            $("#update_Country").change(function() {
         var countryId = $(this).val();
         $('#update_state').empty().append($('<option>', {
            value: '',
            text: 'Select State'
         }));
         $('#update_city').empty().append($('<option>', {
            value: '',
            text: 'Select City'
         }));
         $.ajax({
            url: "{{ route('getstate-bycountry-id') }}",
            dataType: "json",
            type: "get",
            data: { 'id': countryId },
            success: function(response) {
               if (response.status === 'success' && response.data.length > 0) {
                  $.each(response.data, function(index, state) {
                     $('#update_state').append($('<option>', {
                        value: state.id,
                        text: state.state_name
                     }));
                  });
               } else {
                  // Handle the case when no states are found for the selected country
               }
            },
         });
      });

      $("#update_state").change(function() {
         var stateId = $(this).val();
         $('#update_city').empty().append($('<option>', {
            value: '',
            text: 'Select City'
         }));
         $.ajax({
            url: "{{ route('getcity-bystate-id') }}",
            dataType: "json",
            type: "get",
            data: { 'id': stateId },
            success: function(response) {
              // console.log(response);
               if (response.status === 'success' && response.data.length > 0) {
                  $.each(response.data, function(index, city) {
                     $('#update_city').append($('<option>', {
                        value: city.id,
                        text: city.city_name
                     }));
                  });
               } else {
                  // Handle the case when no states are found for the selected country
               }
            },
         });
      });

            
            $(document).on('click' , '#submit' , function(e){
              e.preventDefault();
              //  var formData = $('.universityupdate').serialize();
               var formData = new FormData($('.universityupdate')[0]);
               $('.err').remove();
                 $.ajax({
                    url: "{{ route('college-update') }}",
                        dataType: "json",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success : function (response){
                            if(response.status === "success"){
                alert('Updated Record Successfully');
                window.location.reload();
            }else if (response.status == 'error') {
                            $.each(response.message, function(i, message) {
                               if(i == "university"){
                                $('#update_university').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                               }else if(i == "college"){
                                $('#update_college').after(
                                        '<span id="Description_error" class="err" style="color:red">'+message+'</span>');
                               }else if(i == "Established"){
                                $('#update_Established').after(
                                        '<span id="Description_error" class="err" style="color:red">Year must be greater than 1800 or equal to the current year.</span>');
                               }else if(i == "zipCode"){
                                $('#update_zipCode').after(
                                        '<span id="Description_error" class="err" style="color:red">must be a 6-digit number required</span>');
                               }else if(i == "state"){
                                $('#update_state').after(
                                        '<span id="Description_error" class="err" style="color:red">must be a 6-digit number required</span>');
                               }else if(i == "country"){
                                $('#update_country').after(
                                        '<span id="Description_error" class="err" style="color:red">must be a 6-digit number required</span>');
                               }else if(i == "logo"){
                                $('#logo_update').after(
                                        '<span id="Description_error" class="err" style="color:red">'+ message +'</span>');
                               }else if(i == "image"){
                                $('#image_update').after(
                                        '<span id="Description_error" class="err" style="color:red">' + message + '</span>');
                               }
                            });
                        }
                        }
                 });
            });

</script>

@endsection

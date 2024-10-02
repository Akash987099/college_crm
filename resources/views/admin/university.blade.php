@extends('admin.layouts.master')

@section('contant')


  <div class="content-wrapper">

<div class="container-xxl flex-grow-1 container-p-y">
<button type="button" class="btn btn-primary mb-3" id="university_add">
        Add
    </button>

    <form action="" method="POST" id="search">
    <div class="row">
    <div class="mb-2 col-md-4">
    <select class="form-control " id="university_search_input" name="">
        <option value="">Select University Type</option>
        <option value="Goverment">Government</option>
        <option value="Private">Private</option>
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
                <h5 class="card-header">University</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                  
                    <table class="table" id="datatable">
                    <thead class="">
                      <tr >
                      <th >S No.</th>
                      <th >University</th>
                      <th >Type</th>
                      <th >Estb Year</th>
                      <th >City/State</th>
                      <th >Top University</th>
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

                      <form id="universityadd" method="POST" enctype="multipart/form-data">
                      @csrf
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">University Name<span class="required">*</span></label>
                            <input
                              class="form-control specialchar"
                              type="text"
                              id="university"
                              maxlength="100"
                              name="university"
                              placeholder = "University Name"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input onKeyPress="if(this.value.length==100) return false;" type="text" maxlength="100" class="form-control addressallow" id="address" name="address" placeholder="Address" />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="image" class="form-label">Image<span class="required">*</span></label>
                            <input  type="file"  class="form-control" id="image" name="image" placeholder="" />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="logo" class="form-label">Logo<span class="required">*</span></label>
                            <input  type="file" class="form-control" id="logo" name="logo" placeholder="" />
                          </div>


                          <div class="mb-3 col-md-6">
                            <label class="form-label" id="country" for="country">Country<span class="required">*</span></label>
                            <select id="countrydata" name="country" class="select2 form-select">
                              <option value="">Select</option>
                             @foreach($country as $key => $val)
                             <option value="{{$val->id}}">{{$val->country_name}}</option>
                             @endforeach
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="state" id="state" class="form-label">State<span class="required">*</span></label>
                            <select id="statedata" name="state" class="select2 form-select">
                              <option value="">Select</option>
                         
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="city" id="city" class="form-label">City<span class="required">*</span></label>
                            <select id="citydata" name="city" class="select2 form-select">
                              <option value="">Select</option>
                              
                            </select>
                          </div>
                          
                          <div class="mb-3 col-md-6">
    <label for="zipCode" class="form-label">Postal Code</label>
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
                            <label for="zipCode" class="form-label">University Type<span class="required">*</span></label>
                            <select id="university_type" name="university_type" class="select2 form-select">
                              <option value="">Select</option>
                              <option value="Goverment">Goverment</option>
                              <option value="Private">Private</option>
                            </select>
                          </div>
                        

                          <div class="mb-3 col-md-12">
                            <label for="zipCode" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="5">

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


  <div class="row" id="upadateuniverrsity">
    <div class="col-md-12">
      <div class="card mb-4">
       
        <div class="card-body">


          <form class="universityupdate" method="POST">
          @csrf
          <input type="text" id="update_update_id" name="id" hidden>
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label">University Name <span class="required">*</span></label>
                <input
                  class="form-control specialchar"
                  type="text"
                  id="update_university"
                  name="university"
                  placeholder = "University Name"
                />
              </div>
            
              <div class="mb-3 col-md-6">
                <label for="address" class="form-label">Address</label>
                <input onKeyPress="if(this.value.length==100) return false;" type="text" maxlength="100" class="form-control specialchar" id="update_address" name="address" placeholder="Address" />
              </div>

              <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Image<span class="required">*</span></label>
                            <input  type="file" class="form-control addressallow" id="image_update" name="imageupdate" placeholder="Address" />
                            <img id="imagePreview" src="" style="width:100px;" alt="Image Preview">

                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Logo<span class="required">*</span></label>
                            <input  type="file" class="form-control addressallow" id="logo_update" name="logoupdate" placeholder="Address" />
                            <img id="logoPreview" src="" style="width:100px;" alt="Image Preview">

                          </div>

              <div class="mb-3 col-md-6">
                <label class="form-label" id="country" for="country">Country<span class="required">*</span></label>
                <select id="update_Country" name="Country" class="select2 form-select update_Country">
                  <option value="">Select</option>
                  @foreach($country as $key => $val)
                             <option value="{{$val->id}}">{{$val->country_name}}</option>
                             @endforeach
                </select>
              </div>

              <div class="mb-3 col-md-6">
                <label for="state" id="state" class="form-label">State<span class="required">*</span></label>
                <select id="update_state" name="state" class="select2 form-select">
                  <option value="">Select</option>
                  
                </select>
              </div>

              <div class="mb-3 col-md-6">
                <label class="form-label" id="city" for="city">City<span class="required">*</span></label>
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
                <label for="zipCode" id="university_type" class="form-label">University Type <span class="required">*</span></label>
                <select id="update_university_type" name="university_type" class="select2 form-select">
                  <option value="">Select</option>
                  <option value="Goverment">Goverment</option>
                  <option value="Private">Private</option>
                </select>
              </div>

              <div class="mb-3 col-md-12">
                <label for="zipCode" class="form-label">Description</label>
                <textarea class="form-control" name="update_description" id="update_description"  rows="5">
               </textarea>
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
$('#upadateuniverrsity').hide();

// $(document).ready(function() {
//       var editor1=CKEDITOR.replace('exampleFormControlTextarea1',{
//         extraPlugins : ['colorbutton','floatpanel','font','panel','autogrow','table'],
//         height:250,
//         allowedContent :true,
//         uiColor : '#ffffff' , 
//       });
//         });

       
      // var editor2=CKEDITOR.replace('update_description',{
      //   extraPlugins : ['colorbutton','floatpanel','font','panel','autogrow','table'],
      //   height:250,
      //   allowedContent :true,
      //   uiColor : '#ffffff' , 
      // });
// 

$(document).on('click', '#university_add', function() {
  $('html, body').scrollTop($('#university_add').offset().top);
    $('#add_university').show();
    $('#upadateuniverrsity').hide();
});

$(document).on('click', '#close', function() {
  $('html, body').scrollTop($('#university_add').offset().top);
    $('#add_university').hide();
    $('#upadateuniverrsity').hide();
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
                  // Handle the case when no states are found for the selected country
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
              console.log(response);
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


function validateYear(input) {
        // Get the entered value
        var year = input.value;
        var isValid = /^[0-9]{4}$/.test(year) && parseInt(year, 10) >= 1800;

        if (isValid) {
            input.classList.remove('invalid-input');
            input.classList.add('valid-input');
        } else {
            input.classList.remove('valid-input');
            input.classList.add('invalid-input');
        }
    }

//     function checkKeyPress(event) {
//     // Ensure the pressed key is a number
//     if (!isNaN(event.key)) {
//         var currentInput = parseInt(event.target.value + event.key, 10);
// // inputValue < 1800 || inputValue > 2400
//         if (currentInput < 1800 || currentInput >2400) {
//             alert('Year must be 1800 or greater.');
//             event.preventDefault();
//         }
//     }
// }


$('.specialchar').on('keypress',function(e){
  var regex = new RegExp("^[a-zA-Z&., -]");
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

                    var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };
                      var formdata = new FormData($('#universityadd')[0]);

                    $('.err').remove();
                    $.ajax({
                      url : "{{route('university-add')}}",
                      type : "POST",
                      headers: headers,
                      data : formdata,
                      contentType: false,
                      processData: false,
                      success : function(response){
                        if (response.status == "success") {
                           alert(response.message);
                           table.ajax.reload();
                           $('#universityadd')[0].reset();
                           $('html, body').scrollTop($('#university_add').offset().top);
                        } else if (response.status == 'error') {
    $.each(response.message, function(i, message) {
    // alert(i);
        if (i == "university") {
            updateErrorMessage('#university_error', message);
        } else if (i == "Established") {
            updateErrorMessage('#Established_error', 'Year must be Greater than 1800 or equal to the current year.');
        } else if (i == "zipCode") {
            updateErrorMessage('#zipCode_error', 'must be a 6-digit number required');
        }else if (i == "image") {
            updateErrorMessage('#image_error', message);
        }else if (i == "logo") {
            updateErrorMessage('#logo_error', message);
        }else if (i == "city") {
            updateErrorMessage('#city_error', message);
        }else if (i == "country") {
            updateErrorMessage('#country_error', message);
        }else if (i == "state") {
            updateErrorMessage('#state_error', message);
        }else if (i == "university_type") {
            updateErrorMessage('#university_type_error', message);
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
        url: "{{ route('university-data') }}",
        type: 'GET',
        data: function (d) {
            d.university_search = $('#university_search_input').val();
            d.state_search = $('#state_search_input').val();
        }
    },
        // ajax: "{{ route('university-data') }}",
        columns: [
            {
                data: 'id',
                orderable: false,
                className: 'text-center'
            },
            {
                data: 'name',
                orderable: true,
                className: 'text-center'
            },
            {
                data: 'type',
                orderable: true,
                className: 'text-center'
            },
            {
                data: 'established',
                orderable: false,
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
        pageLength: 10,
        scrollY: '800px', 
        scrollCollapse: true, 
    });

    
    $('body').on('click' , '.tglbtn' , function(){
      var confirmation = confirm("Are you sure you want to Change this Record?");
          if (confirmation) {
                var id = $(this).attr('data-id');
                    $.ajax({
                        url: "{{ route('university-status-change') }}",
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

   $(document).ready(function(){
    $('#university_search_input').on('input', function () {
        var universitySearchValue = $(this).val();
        // alert('University Search Value:', universitySearchValue);
        table.draw();
    });

    $('#state_search_input').on('input', function () {
        var universitySearchValue = $(this).val();
        // alert('University Search Value:', universitySearchValue);
        table.draw();
    });

    
   });


        $('body').on('click', '.delete', function() {
          var confirmation = confirm("Are you sure you want to Delete this Record?");
          if (confirmation) {
                var id = $(this).attr('data-id');
                    $.ajax({
                        url: "{{ route('university-delete') }}",
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
                var id = $(this).attr('data-id');
                $('#add_university').hide();
                    $.ajax({
                        url: "{{ route('university-edit') }}",
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
                      // console.log(item.address);
                        var countryId=item.country;
                        var stateId = item.state;
                        var cityId = item.city;
                        // console.log(stateId);
                        // console.log(countryId);

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
                                  // console.log(city);
                                    $('#update_city').append($('<option>', {
                                        value: city.id,
                                        text: city.city_name
                                    }));
                                    
                                });
                                $('#update_city option[value="' + cityId + '"]').prop('selected', true);

                            } 
                            },
                        });

                               var imageUrl = "{{ asset('public/college/') }}" + '/' + item.image;
                                 $('#imagePreview').attr('src', imageUrl);

                                 var logourl = "{{ asset('public/college/logo/') }}" + '/' + item.logo; 
                                 $('#logoPreview').attr('src', logourl);

                                 $('#update_update_id').val(item.id);
                                 $('#update_university').val(item.name);
                                 $('#update_address').val(item.address);  
                                //  $('#update_state').val(item.state);
                                // $('#updatestate option[value="' + item.state + '"]').prop('selected', true);
                                 $('#update_Country').val(item.country);
                                 $('#update_zipCode').val(item.pincode);
                                 $('#update_Established').val(item.established);
                                 $('#update_Department').val(item.department);
                                 $('#update_university_type').val(item.university_type);
                                 $('#update_description').val(item.description);
                                 $('html, body').scrollTop($('#upadateuniverrsity').offset().top);
                                 $('#upadateuniverrsity').show();
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
        //  alert(countryId);
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
                    url: "{{ route('university-update') }}",
                        dataType: "json",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success : function (response){
                            if(response.status === "success"){
                alert(response.message);
                window.location.reload();
            }else if (response.status == 'error') {
    $.each(response.message, function (i, message) {
        if (i == "university" && $('#university_error').length == 0) {
            $('#update_university').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
        } else if (i == "Established" && $('#Established_error').length == 0) {
            $('#update_Established').after('<span id="Established_error" class="err" style="color:red">Year must be less than 1800 or equal to the current year.</span>');
        } else if (i == "zipCode" && $('#update_zipCode_error').length == 0) {
            $('#update_zipCode').after('<span id="update_zipCode_error" class="err" style="color:red">must be a 6-digit number required</span>');
        }
    });
}
                        }
                 });
            });

</script>

@endsection

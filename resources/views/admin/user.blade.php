@extends('admin.layouts.master')

@section('contant')

<style>
  .my-custom-link {
    color: #000;
    cursor: pointer;
    /* Add any other styles you need */
}


</style>
<div class="content-wrapper">

<div class="container-xxl flex-grow-1 container-p-y">
<button type="button" class="btn btn-primary mb-3" id="user_add">
        Add
    </button>
  
                        <div class="card">
                <h5 class="card-header">User</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                  <!-- {{$university}} -->
                    <table class="table" id="datatable" style="width:100%;">
                    <thead class="">
                      <tr >
                      <th >S No.</th>
                      <th >UserName</th>
                      <th >Name</th>
                      <th >University</th>
                      <th >College</th>
                      <th >Email</th>
                      <th >Phone</th>
                      <th >Status</th>
                      <th >User Type</th>
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
             
              <div class="row" id="adduserdata">
                <div class="col-md-12">
                 
                  <div class="card mb-4">
                    <!-- <h5 class="card-header">University Details</h5> -->
                    <!-- Account -->
                    
                    <div class="card-body">

                      <form id="useradd" method="POST">
                      @csrf
                        <div class="row">
                          
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">User name  <span class="required">*</span></label>
                            <input
                              class="form-control"
                              type="text"
                              id="username"
                              maxlength="100"
                              name="username"
                              onKeyPress="if(this.value.length==15) return false;"
                              placeholder = " Name"
                            />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Name <span class="required">*</span></label>
                            <input
                              class="form-control specialchar"
                              type="text"
                              id="name"
                              maxlength="100"
                              name="name"
                              placeholder = " Name"
                            />
                          </div>
                         
                          <div class="mb-3 col-md-6">
                            <label for="university" class="form-label">University <span class="required">*</span></label>
                            <select id="university" name="university" class="select2 form-select">
                              <option value="">Select</option>
                         @foreach($university as $key =>  $val)
                         <option value="{{$val->id}}">{{$val->name}}</option>
                         @endforeach
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="college" class="form-label">College</label>
                            <select id="college" name="college" class="select2 form-select">
                              <option value="">Select</option>
                              @foreach($college as $key =>  $val)
                         <option value="{{$val->id}}">{{$val->name}}</option>
                         @endforeach
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Email<span style="color: red; font-size:20px;">*</span></label>
                            <input  type="email" maxlength="100" class="form-control" id="email" name="email" placeholder="Email" />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="phone" class="form-label">Mobile</label>
                            <input onKeyPress="if(this.value.length==10) return false;" type="text"  class="form-control" id="phone" name="Phone" placeholder="Phone" />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input onKeyPress="if(this.value.length==100) return false;" type="text" maxlength="100" class="form-control" id="address" name="address" placeholder="Address" />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="country">Country</label>
                            <select id="countrydata" name="country" class="select2 form-select">
                              <option value="">Select</option>
                             @foreach($country as $key => $val)
                             <option value="{{$val->id}}">{{$val->country_name}}</option>
                             @endforeach
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">State</label>
                            <select id="statedata" name="state" class="select2 form-select">
                              <option value="">Select</option>
                         
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="city" class="form-label">City</label>
                            <select id="citydata" name="city" class="select2 form-select">
                              <option value="">Select</option>
                              
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="city" class="form-label">User Type<span class="required">*</span></label>
                            <select id="userplan" name="userplan" class="select2 form-select">
                                @if(Auth::user()->user_type == 3)
                              <option value="">Select</option>
                              <option value="1">Admin User</option>
                              @endif
                              <option value="2">General User</option>
                              
                            </select>
                          </div>
                          
                          <div class="mb-3 col-md-6">
    <label for="zipCode" class="form-label">Pin Code</label>
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

                        <div class="mt-2">
                          <button type="submit" id="save" class="btn btn-primary me-2">Save</button>
                          <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                      </form>
                    <!-- /Account -->
                  </div>
                  
                </div>
              </div>
              </div>

  </div>


  <div class="row" id="viewuser">
                <div class="col-md-12">
                 
                  <div class="card mb-4">
                    <!-- <h5 class="card-header">University Details</h5> -->
                    <!-- Account -->
                    
                    <div class="card-body">

                      <form id="">
                      @csrf
                        <div class="row">
                         
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">User name  </span></label>
                            <input
                              class="form-control"
                              type="text"
                              id="view_username"
                              maxlength="100"
                              name="username"
                              placeholder = " Name"
                              readonly
                            />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Name</label>
                            <input
                              class="form-control specialchar"
                              type="text"
                              id="view_name_data"
                              maxlength="100"
                              name="view_name"
                              placeholder = "Name"
                              readonly
                            />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="university" class="form-label">University </label>
                            <select disabled id="view_university"  name="university" class="select2 form-select">
                              <option value="">Select</option>
                         @foreach($university as $key =>  $val)
                         <option value="{{$val->id}}">{{$val->name}}</option>
                         @endforeach
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="college" class="form-label">College</label>
                            <select id="view_college" disabled name="college" class="select2 form-select">
                              <option value="">Select</option>
                              @foreach($college as $key =>  $val)
                         <option value="{{$val->id}}">{{$val->name}}</option>
                         @endforeach
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Email</label>
                            <input  type="email" maxlength="100" class="form-control" id="view_email" name="email" placeholder="Email" readonly/>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Mobile</label>
                            <input onKeyPress="if(this.value.length==10) return false;" readonly type="text" maxlength="100" class="form-control" id="view_phone" name="Phone" placeholder="Phone" />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input onKeyPress="if(this.value.length==100) return false;" readonly type="text" maxlength="100" class="form-control" id="view_address" name="address" placeholder="Address" />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="country">Country</label>
                            <select id="view_country" name="country" disabled class="select2 form-select">
                              <option value="">Select</option>
                             @foreach($country as $key => $val)
                             <option value="{{$val->id}}">{{$val->country_name}}</option>
                             @endforeach
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">State</label>
                            <select id="view_state" name="state" disabled readonly class="select2 form-select">
                              <option value="">Select</option>
                         
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="city" class="form-label">City</label>
                            <select id="view_city" name="city" disabled class="select2 form-select">
                              <option value="">Select</option>
                              
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="city" class="form-label">User Type</label>
                            <select id="userplan" name="userplan" class="select2 form-select">
                              <option value="">Select</option>
                              <option value="1">Admin User</option>
                              <option value="2">General User</option>
                              
                            </select>
                          </div>
                          
                          <div class="mb-3 col-md-6">
    <label for="zipCode" class="form-label">Pin Code</label>
    <input
        type="text"
        class="form-control"
        id="view_zipcode"
        name="zipCode"
        placeholder="Postalcode"
        maxlength="6"
        pattern="[0-9]*" 
        title="Please enter only numeric values"
        oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
        required
        readonly
    />
</div>                   

                        <div class="mt-2">
                          <!-- <button type="submit" id="save" class="btn btn-primary me-2">Save</button>
                          <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->
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


          <form class="userupdate" method="POST">
          @csrf
          <input type="text" id="update_update_id" name="id" hidden>
            <div class="row">
              
              <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">User name</span></label>
                            <input
                              class="form-control"
                              type="text"
                              id="update_username"
                              maxlength="100"
                              name="username"
                              placeholder = " Name"
                              readonly
                            />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="city" class="form-label">User Type<span class="required">*</span></label>
                            <select id="userplanupdate" name="userplanupdate" class="select2 form-select" disabled>
                              
                              
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label"> Name <span class="required">*</span></label>
                <input
                  class="form-control specialchar"
                  type="text"
                  id="update_name"
                  name="name"
                  placeholder = " Name"
                />
              </div>

              <div class="mb-3 col-md-6">
                <label for="state" class="form-label">University<span class="required">*</span></label>
                <select id="update_university" name="university" class="select2 form-select" disabled>
                  <option value="">Select</option>
                  @foreach($university as $key =>  $val)
                         <option value="{{$val->id}}">{{$val->name}}</option>
                         @endforeach
                </select>
              </div>

              <div class="mb-3 col-md-6">
                <label for="state" class="form-label">College</label>
                <select id="update_college" name="college" class="select2 form-select" disabled>
                  <option value="">Select</option>
                  @foreach($college as $key =>  $val)
                         <option value="{{$val->id}}">{{$val->name}}</option>
                         @endforeach
                </select>
              </div>
            
              <div class="mb-3 col-md-6">
                <label for="email" class="form-label">Email<span class="required">*</span></label>
                <input  type="text" maxlength="100" class="form-control" id="update_email" name="update_email" placeholder="Email"/>
              </div>

              <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label">Mobile</span></label>
                <input
                  class="form-control"
                  type="text"
                  id="update_phone"
                  name="phone"
                  maxlength="10"
                  placeholder = "Phone"
                />
              </div>

              <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label"> Address </label>
                <input
                  class="form-control specialchar"
                  type="text"
                  id="update_address"
                  name="address"
                  placeholder = "Address"
                />
              </div>

              <div class="mb-3 col-md-6">
                <label class="form-label" for="country">Country</label>
                <select id="update_Country" name="Country" class="select2 form-select update_Country">
                  <option value="">Select</option>
                  @foreach($country as $key => $val)
                             <option value="{{$val->id}}">{{$val->country_name}}</option>
                             @endforeach
                </select>
              </div>

              <div class="mb-3 col-md-6">
                <label for="state" class="form-label">State</label>
                <select id="update_state" name="state" class="select2 form-select">
                  <option value="">Select</option>
                  
                </select>
              </div>

              <div class="mb-3 col-md-6">
                <label class="form-label" for="city">City</label>
                <select id="update_city" name="city" class="select2 form-select">
                  <option value="">Select</option>
                
                </select>
              </div>

             

              <div class="mb-3 col-md-6">
<label for="zipCode" class="form-label">Pincode Code</label>
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

$('#adduserdata').hide();
$('#upadateuniverrsity').hide();
$('#viewdata').hide();
$('#viewuser').hide();



$(document).on('click', '#user_add', function() {
  // $('html, body').scrollTop($('#adduserdata').offset().top);
  $('html, body').scrollTop($(document).height());
    $('#adduserdata').show();
    $('#upadateuniverrsity').hide();
    $('#viewuser').hide();
});

$(document).on('click', '#close', function() {
  // $('html, body').scrollTop($('#university_add').offset().top);
  $('html, body').scrollTop($(document).height());
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

      $("#university").change(function() {
         var uniId = $(this).val();
        //  alert(uniId);
         $('#college').empty().append($('<option>', {
            value: '',
            text: 'Select college'
         }));
         $.ajax({
            url: "{{ route('getcollege-byuni-id') }}",
            dataType: "json",
            type: "get",
            data: { 'id': uniId },
            success: function(response) {
              // console.log(response);
               if (response.status === 'success' && response.data.length > 0) {
                  $.each(response.data, function(index, city) {
                     $('#college').append($('<option>', {
                        value: city.id,
                        text: city.name
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

    function checkKeyPress(event) {
    if (!isNaN(event.key)) {
        var currentInput = parseInt(event.target.value + event.key, 10);

        if (currentInput == 1800) {
            alert('Year must be 1800 or greater.');
            event.preventDefault();
        }
    }
}


$('.specialchar').on('keypress',function(e){
            var regex=new RegExp("^[a-zA-Z& ]");
            var key=String.fromCharCode(!e.charCode ? e.which :e.charCode);
            if(!regex.test(key  )){
                e.preventDefault();
                return false;
            }
        });
       

                 $(document).ready(function(){
                  $(document).on('click' , '#save' , function(event){
                    event.preventDefault();
                    var formdata = $('#useradd').serialize();
                    $('.err').remove();
                    // alert(formdata);
                    $.ajax({
                      url : "{{route('user-create')}}",
                      type : "POST",
                      data : formdata,
                      success : function(response){
                        if (response.status == "success") {
                           alert(response.message);
                           table.ajax.reload();
                          //  $('html, body').scrollTop($('#adduserdata').offset().top);
                          $('html, body').scrollTop($(document).height());
                           $('#useradd')[0].reset();
                        }
                        else {
    $('#username').after('<span id="update_username_error" class="err" style="color:red">' + response.message + '</span>');
}

                        $.each(response.message, function (i, message) {
        if (i == "university" && $('#university_error').length == 0) {
            $('#university').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
        }else if (i == "name" && $('#university_error').length == 0) {
            $('#name').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
        } else if (i == "email" && $('#Established_error').length == 0) {
            $('#email').after('<span id="Established_error" class="err" style="color:red">'+message+'</span>');
        } else if (i == "zipCode" && $('#update_zipCode_error').length == 0) {
            $('#zipCode').after('<span id="update_zipCode_error" class="err" style="color:red">must be a 6-digit number required</span>');
        }else if (i == "Phone" && $('#update_phone_error').length == 0) {
            $('#phone').after('<span id="update_zipCode_error" class="err" style="color:red">'+message+'</span>');
        }else if (i == "username" && $('#update_username_error').length == 0) {
            $('#username').after('<span id="update_username_error" class="err" style="color:red">'+message+'</span>');
        } else if (i == "userplan" && $('#update_userplan_error').length == 0) {
            $('#userplan').after('<span id="update_userplan_error" class="err" style="color:red">The user type field is required. </span>');
        } 
    });
                     
                      }
                    });
                  });
                 });

                 
         
    
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: "{{ route('user-list') }}",
        columns: [
            {
                data: 'id',
                orderable: false,
                className: 'text-left'
               
            },
            {
                data: 'username',
                orderable: true,
                className: 'text-left'
            },
            {
                data: 'user_name',
                orderable: true,
                className: 'text-left'
            },
            {
    data: 'university',
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
    data: 'college',
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
                data: 'email',
                orderable: false,
                className: 'text-left'
            },
            {
                data: 'phone',
                orderable: false,
                className: 'text-left'
            },
            {
                data: 'usertype',
                orderable: false,
                className: 'text-left'
                
            },
            {
                data: 'status',
                orderable: false,
                className: 'text-left'
            },
            {
                data: 'action',
                orderable: false,
                className: 'text-left'
            }
        ],
        lengthMenu: [10, 25, 50, 100],
        pageLength: 25,
        scrollCollapse: false, 
    });


    $('body').on('click' , '.viewall' , function(){
      var id = $(this).attr('data-id');

      $('#code').val('');
				$.ajax({
					url: "{{ route('view-all') }}",
					dataType : "json",
					type: "get",
					data : {'id':id},
          success: function(response) {
                            if (response) {    
                            
                  $.each(response, function(index, item){
                        var countryId=item.country;
                        var stateId = item.state;
                        var cityId = item.city;
                        var university_code = item.university_code;
                        var college_code = item.college_code;
                        // console.log(university_code);

                        $.ajax({
                            url: "{{ route('get-byuniversity-id') }}",
                            dataType: "json",
                            type: "get",
                            data: { 'id': university_code },
                            success: function (response) {
                              console.log(response);
                                if (response.status == 'success' && response.data.length > 0) {
                                    $.each(response.data, function (index, university) {
                                      // console.log(state.id);
                                        $('#view_university').append($('<option>', {
                                            value: university.id,
                                            text: university.name
                                        }));
                                        
                                    });
                                    $('#view_university option[value="' + university_code + '"]').prop('selected', true);
                                }
                            },
                        });


                        $.ajax({
                            url: "{{ route('get-bycollege-id') }}",
                            dataType: "json",
                            type: "get",
                            data: { 'id': college_code },
                            success: function (response) {
                              console.log(response);
                                if (response.status == 'success' && response.data.length > 0) {
                                    $.each(response.data, function (index, college) {
                                      // console.log(state.id);
                                        $('#view_college').append($('<option>', {
                                            value: college.id,
                                            text: college.name
                                        }));
                                        
                                    });
                                    $('#view_college option[value="' + college_code + '"]').prop('selected', true);
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
                                        $('#view_state').append($('<option>', {
                                            value: state.id,
                                            text: state.state_name
                                        }));
                                        
                                    });
                                    $('#view_state option[value="' + stateId + '"]').prop('selected', true);
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
                                    $('#view_city').append($('<option>', {
                                        value: city.id,
                                        text: city.city_name
                                    }));
                                    
                                });
                                $('#view_city option[value="' + cityId + '"]').prop('selected', true);

                            } 
                            },
                        });

                        console.log(item.country);
                              
                                 $('#view_name_data').val(item.name);
                                 $('#view_username').val(item.username);
                                 $('#view_email').val(item.email);
                                 $('#view_country').val(item.country);
                                 $('#view_university').val(item.university_code);
                                 $('#view_phone').val(item.phone);
                                 $('#view_address').val(item.address);
                                 $('#view_zipcode').val(item.pincode);
                                //  $('html, body').scrollTop($('#viewuser').offset().top);
                                $('html, body').scrollTop($(document).height());
                                 $('#viewuser').show();
                                 $('#adduserdata').hide();
                                 $('#upadateuniverrsity').hide();
                                  });
                              
                            } else if (response.status == 'error') {

                                alert(response.message);
                            } 
                        },
				});

    }); 

    

    
    $('body').on('click' , '.viewuniversity' , function(){
      var id = $(this).attr('data-id');

      $('#code').val('');
				$.ajax({
					url: "{{ route('view-data') }}",
					dataType : "json",
					type: "get",
					data : {'id':id},
					success : function(response) {
						// console
						if(response.status == 'success') {
						
							$('#id').val(response.data.id);
							$('#viewtemplate_name').val(response.data.name);
                     var htmlContent = response.data.name;
                     $('#contentDisplay').html(htmlContent);
                     $('#viewdata').show();
						} else if(response.status == 'error') {
							alert(response.message);						
						}
						
					},
				});

    }); 

    $('body').on('click' , '.viewcollege' , function(){
      var id = $(this).attr('data-id');
      $('#code').val('');
				$.ajax({
					url: "{{ route('view-college') }}",
					dataType : "json",
					type: "get",
					data : {'id':id},
					success : function(response) {
						// console
						if(response.status == 'success') {
						
							$('#id').val(response.data.id);
							$('#viewtemplate_name').val(response.data.name);
                     var htmlContent = response.data.name;
                     $('#contentDisplay').html(htmlContent);
                     $('#viewdata').show();
						} else if(response.status == 'error') {
							alert(response.message);						
						}
						
					},
				});

    });

    $('body').on('click' , '.viewaddress' , function(){
      var id = $(this).attr('data-id');

      $('#code').val('');
				$.ajax({
					url: "{{ route('view-address') }}",
					dataType : "json",
					type: "get",
					data : {'id':id},
					success : function(response) {
						// console
						if(response.status == 'success') {
						
							$('#id').val(response.data.id);
							$('#viewtemplate_name').val(response.data.address);
                     var htmlContent = response.data.address;
                     $('#contentDisplay').html(htmlContent);
                     $('#viewdata').show();
						} else if(response.status == 'error') {
							alert(response.message);						
						}
						
					},
				});

    });

    $('body').on('click' , '.tglbtn' , function(){
      var confirmation = confirm("Are you sure you want to Change this Status?");
      if (confirmation) {
      var id = $(this).attr('data-id');
				$.ajax({
					url: "{{ route('change-status') }}",
					dataType : "json",
					type: "get",
					data : {'id':id},
					success : function(response) {
					  table.ajax.reload();
						if(response.status == 'success') {
						
						} else if(response.status == 'error') {
							alert(response.message);						
						}
					},
				});
        }
        table.ajax.reload();
    });


        $('body').on('click', '.delete', function() {
          var confirmation = confirm("Are you sure you want to Delete this Record?");
          if (confirmation) {
                var id = $(this).attr('data-id');
                    $.ajax({
                        url: "{{ route('user-delete') }}",
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
              $('#adduserdata').hide();
                var id = $(this).attr('data-id');
                    $.ajax({
                        url: "{{ route('user-edit') }}",
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
                        var university_code = item.university_code;
                        var college_code = item.college_code;
                        // console.log(university_code);

                        $.ajax({
                            url: "{{ route('get-byuniversity-id') }}",
                            dataType: "json",
                            type: "get",
                            data: { 'id': university_code },
                            success: function (response) {
                              console.log(response);
                                if (response.status == 'success' && response.data.length > 0) {
                                    $.each(response.data, function (index, university) {
                                      // console.log(state.id);
                                        $('#update_university').append($('<option>', {
                                            value: university.id,
                                            text: university.name
                                        }));
                                        
                                    });
                                    $('#update_university option[value="' + university_code + '"]').prop('selected', true);
                                }
                            },
                        });


                        $.ajax({
                            url: "{{ route('get-bycollege-id') }}",
                            dataType: "json",
                            type: "get",
                            data: { 'id': college_code },
                            success: function (response) {
                              console.log(response);
                                if (response.status == 'success' && response.data.length > 0) {
                                    $.each(response.data, function (index, college) {
                                      // console.log(state.id);
                                        $('#update_college').append($('<option>', {
                                            value: college.id,
                                            text: college.name
                                        }));
                                        
                                    });
                                    $('#update_college option[value="' + college_code + '"]').prop('selected', true);
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

    if(item.user_type == "1"){
      
      $('#userplanupdate').append($('<option>', {
        value: item.id,
        text: "Admin"
    }));

    }else{
      
      $('#userplanupdate').append($('<option>', {
        value: item.id,
        text: "General User"
    }));

    }

    $('#userplanupdate').prop('disabled', true);
                              
                                 $('#update_update_id').val(item.id);
                                 $('#update_name').val(item.name);
                                 $('#update_username').val(item.username);
                                 $('#update_email').val(item.email);
                                //  $('#update_state').val(item.state);
                                // $('#updatestate option[value="' + item.state + '"]').prop('selected', true);
                                 $('#update_Country').val(item.country);
                                 $('#update_phone').val(item.phone);
                                 $('#update_address').val(item.address);
                                 $('#update_address').val(item.address);
                                 $('#update_zipCode').val(item.pincode);
                                //  $('html, body').scrollTop($('#upadateuniverrsity').offset().top);
                                $('html, body').scrollTop($(document).height());
                                 $('#upadateuniverrsity').show();
                                 $('#adduserdata').hide();
                                 $('#viewuser').hide();
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
               var formData = $('.userupdate').serialize();
               $('.err').remove();
                 $.ajax({
                    url: "{{ route('user-update') }}",
                        dataType: "json",
                        type: "POST",
                        data: formData,
                        success : function (response){
                            if(response.status === "success"){
                alert(response.message);
                window.location.reload();
            }else if (response.status == 'error') {
                            $.each(response.message, function(i, message) {
                               if(i == "name"){
                                $('#update_name').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                               } else if(i == "university"){
                                $('#update_university').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                               }else if(i == "zipCode"){
                                $('#update_zipCode').after(
                                        '<span id="Description_error" class="err" style="color:red">must be a 6-digit number required</span>');
                               }else if(i == "phone"){
                                $('#update_phone').after(
                                        '<span id="Description_error" class="err" style="color:red">'+message+'</span>');
                               }else if(i == "update_email"){
                                $('#update_email').after(
                                        '<span id="Description_error" class="err" style="color:red">'+message+'</span>');
                               }else if (i == "userplanupdate" && $('#update_userplan_error').length == 0) {
            $('#userplanupdate').after('<span id="update_userplan_error" class="err" style="color:red">The user type field is required. </span>');
        }
                            });
                        }
                        }
                 });
            });

</script>

          
          @endsection

        


@extends('admin.layouts.master')

@section('contant')
        <!-- Layout container -->
      
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home  /</span> College</h4>

              <div class="row">
                <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('admin_index')}}"
                        ><i class="fa fa-university me-1"></i> University</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0);"
                        ><i class="fa fa-graduation-cap me-1"></i> College</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('user')}}"
                        ><i class="bx bx-user me-1"></i> User</a
                      >
                    </li>
                  </ul>
                  <div class="card mb-4">
                    <!-- <h5 class="card-header">University Details</h5> -->
                    <!-- Account -->
                    
                    <hr class="my-0" />
                    <div class="card-body">


                      <form id="universityadd" method="POST">
                      @csrf
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">University Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="university"
                              name="university"
                              placeholder = "University Name"
                            />
                          </div>
                        
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">State</label>
                            <select id="state" name="state" class="select2 form-select">
                              <option value="">Select</option>
                            
                            </select>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="zipCode" class="form-label">Zip Code</label>
                            <input
                              type="text"
                              class="form-control"
                              id="zipCode"
                              name="zipCode"
                              placeholder="231465"
                              maxlength="6"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="Established" class="form-label">Established</label>
                            <input
                              type="text"
                              class="form-control"
                              id="Established"
                              name="Established"
                              placeholder="01/01/0001"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="Department" class="form-label">Department</label>
                            <input
                              type="text"
                              class="form-control"
                              id="Department"
                              name="Department"
                              placeholder="Department"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="country">Country</label>
                            <select id="Country" name="Country" class="select2 form-select">
                              <option value="">Select</option>
                             
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="zipCode" class="form-label">University Type</label>
                            <select id="university_type" name="university_type" class="select2 form-select">
                              <option value="">Select</option>
                              <option value="1">Goverment</option>
                              <option value="2">Private</option>
                            </select>
                          </div>

                          <div class="mb-3 col-md-12">
                            <label for="zipCode" class="form-label">Description</label>
                            <textarea name="description" id="description" class="select2 form-select" cols="10" rows="5">
                              
                            </textarea>
                          </div>
                         
                        <div class="mt-2">
                          <button type="submit" id="save" class="btn btn-primary me-2">Save</button>
                          <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                  
                </div>
              </div>
            </div>

            <script>

                 $(document).ready(function(){
                  $(document).on('click' , '#save' , function(event){
                    event.preventDefault();
                    var formdata = $('#universityadd').serialize();
                    $.ajax({
                      url : "{{route('university-add')}}",
                      type : "POST",
                      data : formdata,
                      success : function(response){
                        if (response.status == "success") {
                           alert(response.message);
                           window.location.reload();
                        } else if (response.status == 'error') {
                            $.each(response.message, function(i, message) {
                               if(i == "university"){
                                $('#university').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                               }else if(i == "Country"){
                                $('#Country').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                               }else if(i == "city"){
                                $('#Country').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                               }
                               else if(i == "Department"){
                                $('#Department').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                               }else if(i == "Established"){
                                $('#Established').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                              }else if(i == "address"){
                                $('#address').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                              }else if(i == "description"){
                                $('#description').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                              }else if(i == "state"){
                                $('#state').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                              }else if(i == "university_type"){
                                $('#university_type').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                              }else if(i == "zipCode"){
                                $('#zipCode').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                              }
                            });
                        }
                      }
                    });
                  });
                 });

            </script>
          
          @endsection

         

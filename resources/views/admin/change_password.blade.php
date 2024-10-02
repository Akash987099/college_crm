@extends('admin.layouts.master')

@section('contant')

<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home/</span> Change Password</h4>

              <!-- Basic Layout & Basic with Icons -->
              <div class="row">

<div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                     
                    </div>
                    <div class="card-body">
                      <form method="POST" id="changepassword">
                        @csrf
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Old Password</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="oldpassword" id="oldpassword" placeholder="Old Password" />
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-company">New Password</label>
                          <div class="col-sm-10">
                            <input
                              type="text"
                              class="form-control"
                              id="newpassword"
                              name="newpassword"
                              placeholder="New Password"
                            />
                          </div>
                        </div>
                       
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-phone">Confirm Paasword</label>
                          <div class="col-sm-10">
                            <input
                              type="text"
                              id="confirmpassword"
                              class="form-control phone-mask"
                              placeholder="658 799 8941"
                              aria-label="658 799 8941"
                              aria-describedby="basic-default-phone"
                              name="confirmpassword"
                            />
                          </div>
                        </div>

                      
                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" id="save" class="btn btn-primary">Change</button>
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
                         $('#save').click(function(e){
                          e.preventDefault();
                          var formdata = $('#changepassword').serialize();
                          $.ajax({
                            url : "{{route('update-password')}}",
                            type : "POST",
                            dataType : "json",
                            data : formdata,
                            success : function(response){
                              console.log(response);
                              if (response.status == "success") {
                           alert(response.message);
                           window.location.reload();
                        } else if (response.status == 'error') {
                            $.each(response.message, function(i, message) {
                               if(i == "oldpassword"){
                                $('#oldpassword').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                               }else if (i == "newpassword"){
                                $('#newpassword').after(
                                        '<span id="Description_error" class="err" style="color:red">' +
                                        message + '</span>');
                               }else if(i = "confirmpassword"){
                                $('#confirmpassword').after(
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
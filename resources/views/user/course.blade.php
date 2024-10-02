@extends('user.layouts.master')

@section('user_contant')
        <!-- Layout container -->
      
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">

            
           
              <div class="row">
                <div class="col-md-12">
                @include('user.common_tab')
                  
                  <div class="card">

                  <h5 class="card-header"> 
                  @if(AddPermission(6))
                  <button for="firstName" class="form-label nav-link btn btn-primary" id="adddata"
                          >Add</button>
                          @endif
                
                </h5>
                  <div class="card-body">
                    
                  <div class="table-responsive text-nowrap">
                  
                    <table class="table" id="datatable">
                    <thead class="">
                      <tr >
                      <th >Sr No</th>
                      <th >Course</th>
                      <th >Course type</th>
                      <th >Level</th>
                      <th >Fees</th>
                      <th >Seat</th>
                      <th >Action</th>
                     
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 table-bordered">
                    
                        
                    </tbody>
                  </table>
                  </div>
                </div>
                </div>
              
                  <div class="card mb-4">
                    <hr class="my-0" />

                    <div class="card-body" id="adddatafree">

                    <form id="addborddata" method="POST" enctype="multipart/form-data">
                      @csrf
                     
                        <div class="row" id="description-container">
                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Select Program <span class="required">*</span></label>
                            <!-- <input type="file" name="docs[]" class="form-control" multiple> -->
                            <select class="form-control" name="rank" id="rank">
                              <option value="">Select</option>
                             @foreach($program as $key => $val)
                             <option value="{{$val->id}}">{{$val->name}}</option>
                             @endforeach
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">fees<span class="required">*</span></label>
                            <input type="text" name="fees" id="fees" class="form-control" placeholder="Enter Course Fess">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Seats<span class="required">*</span></label>
                            <input type="text" name="seat" id="seat" class="form-control" placeholder="Enter Course Seats">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Duration<span class="required">*</span></label>
                            <input type="text" name="duration" id="duration" class="form-control" placeholder="Enter Course Duration">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Eligibility<span class="required">*</span></label>
                            <input type="text" name="eligibility" id="eligibility" class="form-control" placeholder="Enter Eligibility">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Course Type<span class="required">*</span></label>
                            <select class="form-control" name="coursetype" id="coursetype">  
                                <option value="">select</option>
                                <option value="full time">Full time</option>
                                <option value="part time">Part time</option>
                                <option value="distance">Distance</option>
                                <option value="online">Online</option>
                                         </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Course Level<span class="required">*</span></label>
                            <select class="form-control" name="courselevel" id="courselevel">  
                                <option value="">select</option>
                                <option value="post Graduate">Post Graduate </option>
                                <option value="under Graduate">Under Graduate</option>
                                         </select>
                          </div>

                          <div class="mb-3 col-md-12">
                            <label for="firstName" class="form-label ">Content<span class="required">*</span></label>
                            <textarea class="form-control" name="about"  id="programeditor">
                        
                        </textarea>

                          </div>
                          
                        <div class="mt-2">
                          <button type="submit" id="save" class="btn btn-primary me-2">Save</button>
                        </div>
                         
                      </form>
                      
                    </div>

                    <!-- /Account -->
                  </div>

                  <div class="card-body" id="updatefgallery">

<form id="updatedata" method="POST" enctype="multipart/form-data">
                      @csrf
                      <input type="text" id="user_id_view" name="updateid" hidden>
                     
                        <div class="row" id="description-container">
                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Select Program <span class="required">*</span></label>
                            <!-- <input type="file" name="docs[]" class="form-control" multiple> -->
                            <select class="form-control" name="rank" id="updaterank">
                              <option value="">Select</option>
                             @foreach($program as $key => $val)
                             <option value="{{$val->id}}">{{$val->name}}</option>
                             @endforeach
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">fees<span class="required">*</span></label>
                            <input type="text" name="fees" id="updatefees" class="form-control" placeholder="Enter Course Fess">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Seats<span class="required">*</span></label>
                            <input type="text" name="seat" id="updateseat" class="form-control" placeholder="Enter Course Seats">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Duration<span class="required">*</span></label>
                            <input type="text" name="duration" id="updateduration" class="form-control" placeholder="Enter Course Duration">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Eligibility<span class="required">*</span></label>
                            <input type="text" name="updateeligibility" id="updateeligibility" class="form-control" placeholder="Enter Eligibility">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Course Type<span class="required">*</span></label>
                            <select class="form-control" name="coursetype" id="updatecourse">  
                                <option value="">select</option>
                                <option value="full time">Full time</option>
                                <option value="part time">Part time</option>
                                <option value="distance">Distance</option>
                                <option value="online">Online</option>
                                         </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Course Level<span class="required">*</span></label>
                            <select class="form-control" name="courselevel" id="updatelevel">  
                                <option value="">select</option>
                                <option value="post Graduate">Post Graduate </option>
                                <option value="under Graduate">Under Graduate</option>
                                         </select>
                          </div>

                          <div class="mb-3 col-md-12">
                            <label for="firstName" class="form-label ">Content<span class="required">*</span></label>
                            <textarea class="form-control" name="about"  id="programeditor1">
                        
                        </textarea>

                          </div>

                        <div class="mt-2">
                          <button type="submit" id="update" class="btn btn-primary me-2">Save</button>
                        </div>
                         
                      </form>
  
</div>


                    </div>
                    </div>
                    </div>


<script>

// adddata

$('#adddatafree').hide();
$('#updatefgallery').hide();

$('#adddata').click(function(){
  $('#adddatafree').show();
  $('#updatefgallery').hide();
  $('html, body').scrollTop($(document).height());
});

      $(document).ready(function () {
        $('#save').on('click', function (e) {
            e.preventDefault();

         var formData = new FormData($('#addborddata')[0]);
         var editorContent = CKEDITOR.instances.programeditor.getData();
             formData.append('editorContent', editorContent);


            $('.err').remove();
            //   console.log(formData);
            $.ajax({
                type: 'POST',
                url: "{{route('course-add')}}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status == "sussess") {
                          //  alert(response.message);
                          alert('Saved successfully. it will publish after approval')
                           window.location.reload();
                        } else if (response.status == 'error') {
                $.each(response.message, function (i, message) {
                    if (i == "admissionpdf") {
                        $('#admissionpdf').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "courselevel") {
                        $('#courselevel').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "coursetype") {
                        $('#coursetype').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "duration") {
                        $('#duration').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "eligibility") {
                        $('#eligibility').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "eligibilitypdf") {
                        $('#eligibilitypdf').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "fees") {
                        $('#fees').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "feespdf") {
                        $('#feespdf').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "rank") {
                        $('#rank').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "seat") {
                        $('#seat').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    }  else if (i == "editorContent") {
                        $('#programeditor').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    }
                });
            }
                },
                error: function (error) {
                    console.log(error);
                    // Handle error response
                }
            });
        });
    });

    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: "{{ route('course-list') }}",
        columns: [
            {
                data: 'id',
                orderable: false,
                className: 'text-center'
               
            },
            {
                data: 'name',
                orderable: true,
                className: 'text-center',
            },
            {
                data: 'type',
                orderable: true,
                className: 'text-center',
            },
            {
                data: 'level',
                orderable: true,
                className: 'text-center',
            },
            {
                data: 'fees',
                orderable: true,
                className: 'text-center',
            },
            {
                data: 'seat',
                orderable: true,
                className: 'text-center',
            },
            {
                data: 'action',
                orderable: false,
                className: 'text-center'
            }
        ],
        lengthMenu: [10, 25, 50, 100],
        pageLength: 25,
        scrollCollapse: false, 
    });

    $('body').on('click', '.update', function() {
    var id = $(this).attr('data-id');
    $('#adddatafree').hide();
    $.ajax({
        url: "{{ route('course-edit') }}",
        dataType: "json",
        type: "GET",
        data: {
            'id': id
        },
        success: function(response) {
            if (response) {
                $.each(response, function(index, item){
                    $('#user_id_view').val(item.id);
                  
                                        $('#updaterank').append($('<option>', {
                                            value: item.program_d,
                                            text: item.name
                                        }));

                                        CKEDITOR.instances.programeditor1.setData(item.description);
                                    
                                    $('#updaterank option[value="' + item.program_id + '"]').prop('selected', true);
                                 
                    $('#updatefees').val(item.fees);
                    $('#updateseat').val(item.seat);
                    $('#updateduration').val(item.duration);
                    $('#updateeligibility').val(item.eligibility);
                    $('#updatecourse').val(item.course_type);
                    $('#updatelevel').val(item.level);

                    if (item.fees_pdf) {
        var pdfUrl = "{{ asset('pdf/') }}/" + item.fees_pdf;

        $('#updatefeesdata').attr('src', pdfUrl);
    }

    if (item.eligibility_pdf) {
        var pdfUrl = "{{ asset('pdf/') }}/" + item.eligibility_pdf;

        $('#updateeligibilitydata').attr('src', pdfUrl);
    }

    if (item.admission_pdf) {
        var pdfUrl = "{{ asset('pdf/') }}/" + item.admission_pdf;

        $('#updateadmissiondata').attr('src', pdfUrl);
    }
                   $('#updatefgallery').show();
                   $('html, body').scrollTop($(document).height());
                });
            } else if (response.status == 'error') {
                alert(response.message);
            } else if (response.status == 'exceptionError') {
                CommonManager.forcelogout();
            }
        },
    });

    return false;
});


$(document).on('click', '#update', function (e) {
  e.preventDefault();
    // var formdata = new FormData($('#updatedata')[0]);

    var formData = new FormData($('#updatedata')[0]);
         var editorContent = CKEDITOR.instances.programeditor1.getData();
             formData.append('editorContent', editorContent);

    $('.err').remove();
    $.ajax({
        url: "{{ route('course-update') }}",
        dataType: "json",
        type: "POST",
        data: formData,
        processData: false,  
        contentType: false, 
        success: function (response) {
          if (response.status == "sussess") { // Fix the typo here
                // alert('Update Successfully');
                alert('Updated successfully. it will publish after approval')
                table.ajax.reload();
                window.location.reload();
            } else if (response.status == 'error') {
                $.each(response.message, function (i, message) {
                    if (i == "rank") {
                        $('#updaterank').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "courselevel") {
                        $('#updatelevel').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "coursetype") {
                        $('#updatecourse').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "duration") {
                        $('#updateduration').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "fees") {
                        $('#updatefees').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "eligibilitypdf") {
                        $('#updateeligibility').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "rank") {
                        $('#fees').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "seat") {
                        $('#updateseat').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "updateeligibility") {
                        $('#rank').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else {
                        alert(message);
                    }
                });
            }
        }
    });
});

    $('body').on('click', '.delete', function() {
                var id = $(this).attr('data-id');
                var confirmation = confirm("Are you sure you want to Delete this Record?");
          if (confirmation) {
                    $.ajax({
                        url: "{{ route('course-delete') }}",
                        dataType: "json",
                        type: "GET",
                        data: {
                            'id': id
                        },
                        success: function(response) {
                            if (response.status === 'sussess') {
                              table.ajax.reload();
                            } else if (response.status == 'error') {
                                alert(response.message);
                            } else if (response.status == 'exceptionError') {
                                CommonManager.forcelogout();
                            }
                        },
                    });
                  }
                return false;
            });

</script>

<script type="text/javascript">
        $(document).ready(function() {
      var editor2=CKEDITOR.replace('programeditor',{
        extraPlugins : ['colorbutton','floatpanel','font','panel','autogrow','table'],
        height:250,
        allowedContent :true,
        uiColor : '#ffffff' , 
      });
        });

</script>

<script type="text/javascript">
        $(document).ready(function() {
      var editor2=CKEDITOR.replace('programeditor1',{
        extraPlugins : ['colorbutton','floatpanel','font','panel','autogrow','table'],
        height:250,
        allowedContent :true,
        uiColor : '#ffffff' , 
      });
        });

</script>
        
          @endsection
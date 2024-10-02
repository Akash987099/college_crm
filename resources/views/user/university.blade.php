@extends('user.layouts.master')

@section('user_contant')
        <!-- Layout container -->
      
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">

          <!-- {{ Auth::user();}} -->
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">

            
           
              <div class="row">
                <div class="col-md-12">
                @include('user.common_tab')
                  <div class="card mb-4">

                  <div class="card">
               
                    <div class="card-body" id="aboutupdate">
                    @if (ViewPermission(1))
                      <form id="updateaboout" method="POST">
                      @csrf
                     
                        <div class="row" id="description-container">
                        @if($about)
                        <input type="text"  value="{{$about->id}}" name="aboutid" hidden>
                        @endif
                 
                          <div class="row mb-3">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Title Name <span class="required">*</span></label>
                            @if($about == NULL)
    <input
        class="form-control specialchar"
        type="text"
        name="title"
        id="title"
        placeholder="Title Name"
    />
@else
    @php
        $updateTitleValue = ($about->title_tmp) ? $about->title_tmp : $about->title;
    @endphp
    <input
        class="form-control specialchar"
        type="text"
        name="update_title"
        id="update_title"
        value="{{ $updateTitleValue }}"
        placeholder="Title Name"
    />
@endif

                          </div>
                        </div>
                        </div>

                        <div class="form-group">
                        <label for="" class=" font-layout">Content <span class="inputlabelmedetory text-err required">*</span></label>
                        @if($about == NULL)
                        <textarea class="form-control" name="about"  id="programeditor1">
                        
                        </textarea>
                        @else
                      
                          @if($about->description == NULL)
                          <textarea class="form-control" name="update_about"  id="programeditor1">
                          {{ $about->description_tmp }}
                          </textarea>
                          @else
                          <textarea class="form-control" name="update_about"  id="programeditor1">
                          {{ $about->description }}
                          </textarea>
                           @endif
                        
                        @endif
                    </div>

              <div class="mt-2">
                 @if($about == NULL)
                 @if(AddPermission(1))
              <button type="save" id="add" class="btn btn-primary me-2">Submit</button>
              @endif
                 @else

                 @if(EditPermission(1))
              <button type="submit" id="updata" class="btn btn-primary me-2">Submit</button>
              @endif

              @endif
            </div>
                      </form>
                      @endif
                    </div>

                    <!-- /Account -->
                  </div>
                  
                </div>
             
            </div>

            <!-- FOOTER -->
            </div>
            </div>

            <script>

      
              $('#addopen').click(function(){
                $('#addabout').show();
              });

              $('#deleteabout').click(function(){
                var id = $(this).attr('data-id');
                var confirmation = confirm("Are you sure you want to Delete this Record?");
          if (confirmation) {
                 $.ajax({
                  url : "{{route('delete-about')}}",
                  type : "GET",
                  data : {id : id},
                  success : function(response){
                    if (response.status == "success") {
                           alert(response.message);
                          // alert('Saved successfully. it will publish after approval')/
                           window.location.reload();
                        }else{
                          alert('Failed! delete Record')
                        }
                  }
                 });
          }
              });


              $('#updata').click(function(e){
                e.preventDefault();
                var editorContent = CKEDITOR.instances.programeditor1.getData();
                var formData = $('#updateaboout').serializeArray();
                formData.push({ name: 'editorContent', value: editorContent });
                $('.err').remove();
                $.ajax({
                  url : "{{route('update-about')}}",
                  type : "POST",
                  data : formData,
                  success : function(response){
                    if (response.status == "success") {
                          //  alert(response.message);
                          alert('Updated successfully. it will publish after approval')
                          // alert('Updated successfully. This content is forwarded for approval')
                           window.location.reload();
                        }else if (response.status == 'error') {
                            $.each(response.message, function(i, message) {
                               if(i == "editorContent"){
                                        $('#programeditor1').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                               }else if (i == "update_title"){
                                        $('#update_title').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                               }
                            });
                        }
                  }
                });
              });

              


  $(document).ready(function () {
        $('#add').on('click', function (e) {
          e.preventDefault();
          var editorContent = CKEDITOR.instances.programeditor1.getData();
                var formData = $('#updateaboout').serializeArray();
                formData.push({ name: 'editorContent', value: editorContent });
            $('.err').remove();
            // AJAX request
            $.ajax({
                url: '{{route('add-about')}}',
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Handle the response from the server
                    if (response.status == "success") {
                          //  alert(response.message);
                          // alert('Saved successfully. This content is forwarded for approval')
                          alert('Saved successfully. it will publish after approval')
                           window.location.reload();
                        }else if (response.status == 'error') {
                            $.each(response.message, function(i, message) {
                               if(i == "editorContent"){
                                        $('#programeditor1').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                               }else if (i == "title"){
                                        $('#title').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                               }
                            });
                        }
                },
                error: function (error) {
                    // Handle errors
                    console.error(error);
                }
            });
        });
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
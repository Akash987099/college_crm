@extends('admin.layouts.master')

@section('contant')

<div class="content-wrapper">

<div class="container-xxl flex-grow-1 container-p-y">
<button type="button" class="btn btn-primary" id="addcountry">Add</button>

                        <div class="card">
                <h5 class="card-header">Articles</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="datatable">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Name</th>
                          <!-- <th>Country Code</th> -->
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

</div>


<div class="container-xxl flex-grow-1 container-p-y">
             
              <div class="row" id="add_articles">
                <div class="col-md-12">
                  
                  <div class="card mb-4">
                    
                    <div class="card-body">

                      <form id="articlesadd" method="POST" enctype="multipart/form-data">
                      @csrf
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Title <span class="required">*</span></label>
                            <input
                              class="form-control specialchar"
                              type="text"
                              id="title"
                              name="title"
                              placeholder = "Title"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Image<span class="required">*</span></label>
                            <input type="file" class="form-control addressallow" id="image" name="image" placeholder="Address" />
                          </div>

                          <div class="mb-3 col-md-12">
                            <label for="zipCode" class="form-label">Description<span class="required">*</span></label>
                            <textarea class="form-control" name="description" id="programeditor" rows="5">

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

              <div class="row" id="update_articles">
                <div class="col-md-12">
                  
                  <div class="card mb-4">
                    
                    <div class="card-body">

                      <form id="articlesupdate" method="POST" enctype="multipart/form-data">
                      @csrf
                      <input type="text" id="user_id_view" name="updateid" hidden>
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Title <span class="required">*</span></label>
                            <input
                              class="form-control specialchar"
                              type="text"
                              id="name_view"
                              name="title"
                              placeholder = "Title"
                            />  
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Image<span class="required">*</span></label>
                            <input type="file" class="form-control addressallow" id="image" name="image" placeholder="Address" />
                            <img id="image_view" style="width: 200px;" class="img-fluid" src="" alt="Image Preview">
                          </div>

                          <div class="mb-3 col-md-12">
                            <label for="zipCode" class="form-label">Description<span class="required">*</span></label>
                            <textarea class="form-control" name="description" id="programeditor1" rows="5">

                            </textarea>
                              
                          </div>
                         
                        <div class="mt-2">
                          <button type="submit" id="update" class="btn btn-primary me-2">Save</button>
                          <button type="reset" id="close" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                      </form>
                    <!-- /Account -->
                  </div>
                  
                </div>
              </div>
              </div>

  </div>


    <script>
    
    $('#add_articles').hide();
    $('#update_articles').hide();
    $(document).on('click' , '#update_articles' , function(){
        $('#add_articles').hide();
    });

            var _ = $('body');
            var updateRecord = 'Are you sure you want to modify this record?';
            var deleteRecord = 'Are you sure you want to delete this record?';

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                paging: true,  
                searching: true,
                ajax: "{{ route('news-view') }}",
                columns: [
                    {
                        data: 'id' , orderable:false,
                        className: 'text-center'
                    },
                    {
                        data: 'title' , orderable:false,
                        className: 'text-center'
                    },
                    // {
                    //     data: 'code' , orderable:false
                    // },
                    {
                        data: 'action' , orderable:false,
                        className: 'text-center'
                    }
                ],
                lengthMenu: [10, 25, 50, 100, 500, 1000, 2000, 3000, 4000,
                5000], // Define available options
                pageLength: 25,
                // scrollY: '500px', 
                scrollCollapse: false, 
            });
 

        $('body').on('click', '.deletedata', function() {
                var id = $(this).attr('data-id');
                    $.ajax({
                        url: "{{ route('delete-news') }}",
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
                            } else if (response.status == 'exceptionError') {
                                CommonManager.forcelogout();
                            }
                        },
                    });
                return false;
            });

            $('body').on('click', '.updatedata', function() {
              $('#add_articles').hide();
                var id = $(this).attr('data-id');
                    $.ajax({
                        url: "{{ route('edit-news') }}",
                        dataType: "json",
                        type: "GET",
                        data: {
                            'id': id
                        },
                        success: function(response) {
                            if (response) {

                                $.each(response, function(index, item){
                                 $('#user_id_view').val(item.id);
                                 $('#name_view').val(item.title);
                                 CKEDITOR.instances.programeditor1.setData(item.description);
                                 if (item.image) {
                        var imgElement = $('<img>').attr('src', "{{ asset('public/news/') }}/" + item.image);
                            $('#image_view').attr('src', imgElement.attr('src'));
                          }

                                 $('#update_articles').show();
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
            
            $(document).on('click' , '#update' , function(e){
               e.preventDefault();
        var formData = new FormData($('#articlesupdate')[0]);
        var editorContent = CKEDITOR.instances.programeditor1.getData();
        formData.append('editorContent', editorContent);
        $('.err').remove();

                 $.ajax({
                    url: "{{ route('update-news') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success : function (response){
                            console.log(response);
                            if(response.status === "success"){
                alert(response.message);
                window.reload();
            }
                        }
                 });
            });

            $(document).ready(function () {
    $('#addcountry').on('click', function () {
        $('#add_articles').show();
    });

    $('#save').on('click', function (e) {
        e.preventDefault();
        var formData = new FormData($('#articlesadd')[0]);
        var editorContent = CKEDITOR.instances.programeditor.getData();
        formData.append('editorContent', editorContent);
        $('.err').remove();

        $.ajax({
            url: "{{ route('add-news') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                if (response.status === "success") {
                    alert(response.message);
                    table.ajax.reload();
                } else if (response.status === "error") {
                    $.each(response.message, function (i, message) {
                    if (i == "title") {
                        $('#title').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "image") {
                        $('#image').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "editorContent") {
                        $('#programeditor').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    }
                });
                }
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
      var editor2 = CKEDITOR.replace('programeditor1',{
        extraPlugins : ['colorbutton','floatpanel','font','panel','autogrow','table'],
        height:250,
        allowedContent :true,
        uiColor : '#ffffff' , 
      });
        });

</script>
@endsection

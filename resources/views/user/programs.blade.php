@extends('user.layouts.master')

@section('user_contant')

<style>
 .select2-search__field {
    width: 11.75em !important;
}
</style>
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
                @if(AddPermission(4))
                  <button for="firstName" class="form-label nav-link btn btn-primary" data-bs-toggle="modal"
                          data-bs-target="#basicModal" >Add</button>
                          @endif
                
                </h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                  
                    <table class="table" id="datatable">
                    <thead class="">
                      <tr >
                      <th >Sr No</th>
                      <th >Program</th>
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
                    
            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <form action="{{ route('add-program-ajax') }}" id="addprogram" method="POST">
                                @csrf
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Program</h5>
                                <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col mb-4">
                                    <label for="nameBasic" class="form-label">Search Program</label>
                                   
                                    <br>
                                 <select id="autoCompletewithSelect2" class="form-control" name="autoCompletewithSelect2" multiple="multiple">
                                       
                                 </select>  <i class="fa fa-plus" aria-hidden="true" id="adddrop" style="color:blue;"></i>
                                 <br>
                                 <div id="dynamicInput">
                                 <label for="nameBasic" class="form-label" >Program Name</label>
                                 <input style=" width: 11.75em !important;" type="text"  id="programdata" name="program" class="form-control" placeholder="Enter Program Name"/>
                                 <!-- <button id="programsave" type="save"  class="btn btn-primary" data-action="add">Add Program</button> -->
                                    <!-- <button type="button" class="btn btn-primary" id="programsave">Add </button> -->
                                   <span id="selecteddata"></span>
                                   </div>
                                  </div>
                               
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Close
                                </button>
                                <button type="button" data-action="save" class="btn btn-primary" id="userprogramsave">Save </button>
                              </div>
                            </div>
                           </form>
                          </div>
                        </div>


                        <div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
    
                           <form action="" id="programupdate" method="POST">
                                @csrf
                                <input type="text"  name="dataid" id="dataid" hidden>
                              <div class="modal-header">

                                <h5 class="modal-title" id="exampleModalLabel1">Program</h5>
                                <button
                                  type="button"
                                  class="btn-close"
                                  id="close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameBasic" class="form-label">Program Name</label>
                                    <input type="text" id="update_program" name="update_program" class="form-control form-range" placeholder="Program Name" />
                                  </div>
                                </div>
                               
                              </div>
                              <div class="modal-footer">
                                <!-- <button type="button" class="btn btn-outline-secondary" id="close" data-bs-dismiss="modal">
                                  Close
                                </button> -->
                                <button type="button" class="btn btn-primary" id="">Save </button>
                              </div>
                            </div>
                           </form>
     
     
    </div>
  </div>
</div>

<script>

  $('#dynamicInput').hide();

  $('#adddrop').click(function(){
    $('#dynamicInput').show();
  });

  $(document).ready(function () {
    // Initiate the search on page load
    initiateSearch();

    function initiateSearch() {
        $.ajax({
            url: '{{ route("search-program") }}',
            method: 'GET',
            data: {}, 
            success: function (response) {
                displayResults(response);
            }
        });
    }

    function displayResults(results) {
        var $searchResults = $('#autoCompletewithSelect2');
        $searchResults.empty();

        if (results.length > 0) {
            results.forEach(function (item) {
                $searchResults.append('<option value="' + item.id + '">' + item.name + '</option>');
            });
        } else {
            $searchResults.append('<option value="">No results found</option>');
        }

        $searchResults.trigger('change');
    }

    $(document).on('click', '#userprogramsave', function (e) {
    e.preventDefault();
    $('.err').remove();

    var selectedValues = $('#autoCompletewithSelect2').val();
    var formData = $('#addprogram').serialize();

    var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };

    $.ajax({
        url: "{{ route('save-program') }}",
        type: "POST",
        data: formData,
        headers: headers,
        success: function (response) {
            if (response.status == "success") {
              alert('Saved successfully. it will publish after approval')
                window.location.reload();
            } else if (response.status == 'error') {
                $.each(response.message, function (i, message) {
                    if (i == "program") {
                        $('#programdata').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "autoCompletewithSelect2") {autoCompletewithSelect2
                        $('#autoCompletewithSelect2').after('<span id="university_error" class="err" style="color:red">select data already exists</span>');
                    } 
                    else if (i == "image") {autoCompletewithSelect2
                        $('#imagedata').after('<span id="university_error" class="err" style="color:red">'+message+'</span>');
                    }
                });
            }
        }
    });
});

$('#autoCompletewithSelect2').select2({
    multiple: true
});

;
});  

  // Example JavaScript for Frontend
  // $(document).ready(function () {
  //   initiateSearch();

  //   function initiateSearch() {
  //       $.ajax({
  //           url: '{{ route("search-program") }}',
  //           method: 'GET',
  //           data: {},
  //           success: function (response) {
  //               displayResults(response);
  //           }
  //       });
  //   }

  //   function displayResults(results) {
  //       var $searchResults = $('#autoCompletewithSelect2');
  //       $searchResults.empty();

  //       if (results.length > 0) {
  //           results.forEach(function (item) {
  //               $searchResults.append('<option value="' + item.id + '">' + item.name + '</option>');
  //           });
  //       } else {
  //           $searchResults.append('<option value="">No results found</option>');
  //       }

  //       $searchResults.trigger('change');
  //   }

  //   $(document).on('click', '#userprogramsave', function (e) {
  //       e.preventDefault();
  //       $('.err').remove();

        // var headers = {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // };

  //       var selectedValues = $('#autoCompletewithSelect2').val();
  //       var formData = $('#programdata').val();
  //       alert(formData);
  //       formData.append('autoCompletewithSelect2', selectedValues);
  //           $.ajax({
  //               url: "{{ route('save-program') }}",
  //               type: "POST",
  //               headers: headers,
  //               data: formData,
  //               success: function (response) {
  //                   console.log(response);
  //               }
  //           });
       
  //   });

  //   function handleEmptySelection() {
  //   }

  //   function handleResponse(response) {
  //       if (response.status == "success") {
  //           alert('Saved Successfully');
  //           window.location.reload();
  //       } else if (response.status == 'error') {
  //           $.each(response.message, function (i, message) {
  //               handleErrorMessage(i, message);
  //           });
  //       }
  //   }

  //   function handleErrorMessage(fieldName, message) {
  //       $('.err').remove();
  //       if (fieldName == "selectedIds") {
  //           $('#autoCompletewithSelect2').after('<span class="err" style="color:red">' + message + '</span>');
  //       } else if (fieldName == "formData") {
  //           $('#programdata').after('<span class="err" style="color:red">' + message + '</span>');
  //       }
  //   }

  //   $('#autoCompletewithSelect2').select2({
  //       multiple: true
  //   });
// });
 

  $('#close').click(function(){
    $('#programupdate').hide();
  });

var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: "{{ route('program-list') }}",
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
                data: 'action',
                orderable: false,
                className: 'text-center'
            }
        ],
        lengthMenu: [10, 25, 50, 100],
        pageLength: 25,
        scrollCollapse: false, 
    });

// updatemodal

    $('body').on('click' , '.updateprogram' , function(){
      var id = $(this).attr('data-id');
           $.ajax({
            url : "{{route('get-programby-id')}}",
            type : "GET",
            data : {id : id},
            success : function(response){
              // console.log(response);
              $.each(response , function(index , item){
                // console.log(item.name);
                $('#update_program').val(item.name);
                $('#dataid').val(item.id);
                    $('.modal').show();
              });
                  }  
           });
    });


    $('#programupdate').click(function(){
        var formData = $('#programupdate').serialize();
        // alert(formData);
        $('.err').remove();
        $.ajax({
          url : "{{route('single-program-update')}}",
          type : "POST",
          data : formData,
          success : function(response){
            // console.log(response);
            if (response.status == "sussess") {
                           alert(response.message);
                           window.location.reload();
                        }else if (response.status == 'error') {
                            $.each(response.message, function(i, message) {
                               if(i == "update_program"){
                                        $('#update_program').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                               }
                            });
                        }
          }
        });
    });


    
    $('body').on('click' , '.deleteprogram' , function(){
      var id = $(this).attr('data-id');
      var confirmation = confirm("Are you sure you want to Delete this Record?");
          if (confirmation) {
             $.ajax({
              url : "{{route('delete-program-data')}}",
              type : "GET",
              data : {id : id},
              success : function(response){
                if (response.status == "sussess") {
            alert(response.message);
            table.ajax.reload();
          }else if(response.status == "error"){
            alert("Course with this  record already exists, Record can't be deleted! ")
          }
              }
             });
          }
    });
    
</script>
 
          @endsection
@extends('admin.layouts.master')

@section('contant')


<div class="content-wrapper">
<div class="container-xxl flex-grow-1 container-p-y">
<!-- <button
                          type="button"
                          class="btn btn-primary"
                          data-bs-toggle="modal"
                          data-bs-target="#basicModal"
                        >
                          Add 
                        </button> -->
     
    <!-- <button  type="button" class="btn btn-primary mb-3 " id="university_search">Search</button> -->
    <form action="" method="POST" id="userprivilege">
    <div class="row">
                          <div class="mb-2 col-md-4">
                            <select class="form-control"  name="user_id" id="user_id">
                               <option value="">Select user</option>
                               @foreach($data as $key => $val)
                             <option value="{{$val->id}}">{{$val->name}}</option>
                             @endforeach
                            </select>
                          </div>
</div>
   
   
                        <div class="card">
                <!-- <h5 class="card-header">College</h5> -->
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                  
                    <table class="table " id="datatable">
                    <thead class="">
                      <tr >
                      <th class="fs-6 text-capitalize">S.No.</th>
									<th class="fs-6 text-capitalize"> Program Description</th>
									<th class="fs-6 text-capitalize"><input type="checkbox" id="selectViewAll" class="ViewCheckbox">View</th>
									<th class="fs-6 text-capitalize"><input type="checkbox" id="selectAddAll" class="AddCheckbox">Add</th>
									<th class="fs-6 text-capitalize"><input type="checkbox" id="selectEditAll" class="EditCheckbox">Edit</th>
									<th class="fs-6 text-capitalize"><input type="checkbox" id="selectDeleteAll" class="DeleteCheckbox">Delete</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 table-bordered">
                     
                    </tbody>
                  </table>
                  </div>
              
						<button type="button" class="btn btn-primary addbutton">Submit</button><br><br>
				
                </div>
              <!-- </div> -->
              </form>
      <!-- <div class="content-wrapper"> -->

    </div>
  </div>

  <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <form action="" id="addcountry" method="POST">
                                @csrf
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Country</h5>
                                <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameBasic" class="form-label">Add New Role <span style="color:red;font-size:20px;">*</span></label>
                                    <input type="text"  min="0" max="26" name="cityname" class="form-control form-range" placeholder="" />
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Close
                                </button>
                                <button type="button" class="btn btn-primary" id="countyrsave">Save </button>
                              </div>
                            </div>
                           </form>
                          </div>
                        </div>

            <script>
                
   var table = $('#datatable').DataTable({
    
    processing: true,
    serverSide: true,
    searching: true,
    bFilter: false,
    ajax: {
        url: "{{ route('privilege-view') }}",
        type: 'GET',
        data: function (d) {
            // Add the university search value to the data sent to the server
            d.university_search = $('#university_search_input').val();
            d.user_id = $('#user_id').val();
        }
    },
    columns: [
        {
            data: 'id',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'description',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'view',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'add',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'edit',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'delete',
            orderable: false,
            className: 'text-center'
        }
    ],
    lengthMenu: [10, 25, 50, 100],
    pageLength: 25,
    scrollY: '800px',
    scrollCollapse: true,
    
});


$('body').on('change', '#user_id', function() {
				
        table.ajax.reload();
      
    });

    $('body').on('click', '.addbutton', function() {
				var data = $('#userprivilege').serialize();
                $('.addbutton').show();
				var params = table.$('input,select,textarea').serializeArray();
			// alert(params);
      //   return false;
      // alert(data);
			if(confirm("Are you sure you want to save changes ?")){

				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				
				$.ajax({
					url: "{{ route('handleprivilege') }}",
					dataType : "json",
					type: "post",
					data : data,
					success : function(response) {
						if(response.status == 'success')
						{
							alert(response.message);
							table.ajax.reload();
							// $('.addbutton').removeAttr('disabled');
							
						} 
						else if(response.status == 'exceptionError')
						{
							// CommonManager.forcelogout();
						}
					},
				});
			};
				
			});

    $(document).ready(function() {
        $('#selectAll').change(function() {
            var isChecked = $(this).prop('checked');
            $('.View_Option, .Add_Option, .Modify_Option, .Delete_Option').prop('checked', isChecked);
        });

		$('#selectViewAll').change(function() {
            var isChecked = $(this).prop('checked');
            $('.View_Option').prop('checked', isChecked);
        });
		$('#selectAddAll').change(function() {
            var isChecked = $(this).prop('checked');
            $('.Add_Option').prop('checked', isChecked);
        });
		$('#selectEditAll').change(function() {
            var isChecked = $(this).prop('checked');
            $('.Modify_Option').prop('checked', isChecked);
        });
		$('#selectDeleteAll').change(function() {
            var isChecked = $(this).prop('checked');
            $('.Delete_Option').prop('checked', isChecked);
        });





        $('.View_Option, .Add_Option, .Modify_Option, .Delete_Option').change(function() {
            if (!$(this).prop('checked')) {
                $('#selectAll').prop('checked', false);
            } else {
                var totalCheckboxes = $('.View_Option, .Add_Option, .Modify_Option, .Delete_Option').length;
                var totalChecked = $('.View_Option:checked, .Add_Option:checked, .Modify_Option:checked, .Delete_Option:checked').length;
                if (totalCheckboxes === totalChecked) {
                    $('#selectAll').prop('checked', true);
                }
            }
        });
		$('.View_Option').change(function() {
            if (!$(this).prop('checked')) {
                $('#selectViewAll').prop('checked', false);
            } else {
                var totalCheckboxes = $('.View_Option').length;
                var totalChecked = $('.View_Option:checked').length;
                if (totalCheckboxes === totalChecked) {
                    $('#selectViewAll').prop('checked', true);
                }
            }
        });
		$('.Add_Option').change(function() {
            if (!$(this).prop('checked')) {
                $('#selectAddAll').prop('checked', false);
            } else {
                var totalCheckboxes = $('.Add_Option').length;
                var totalChecked = $('.Add_Option:checked').length;
                if (totalCheckboxes === totalChecked) {
                    $('#selectAddAll').prop('checked', true);
                }
            }
        });
		$('.Modify_Option').change(function() {
            if (!$(this).prop('checked')) {
                $('#selectEditAll').prop('checked', false);
            } else {
                var totalCheckboxes = $('.Modify_Option').length;
                var totalChecked = $('.Modify_Option:checked,').length;
                if (totalCheckboxes === totalChecked) {
                    $('#selectEditAll').prop('checked', true);
                }
            }
        });
		$('.Delete_Option').change(function() {
            if (!$(this).prop('checked')) {
                $('#selectDeleteAll').prop('checked', false);
            } else {
                var totalCheckboxes = $('.Delete_Option').length;
                var totalChecked = $('.Delete_Option:checked').length;
                if (totalCheckboxes === totalChecked) {
                    $('#selectDeleteAll').prop('checked', true);
                }
            }
        });
    });

</script>

@endsection

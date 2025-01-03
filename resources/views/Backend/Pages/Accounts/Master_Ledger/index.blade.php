@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-body">


                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                              <th class="">No.</th>
                              <th class="">Master Ledger Name</th>
                              <th class="">Status</th>
                              <th class="">Create Date</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Add Modal -->
<div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Add New Master Ledger
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!----- Start Add Form ------->
            <form id="addSectionForm" action="{{ route('admin.master_ledger.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!----- Start Add Form input ------->
                    <div class="row">
                      <div class="col-md-4">
                         <div class="form-group mb-2">
                            <label for="">Master Ledger Name:</label>
                            <input type="text" name="master_ledger_name" class="form-control select2" placeholder="Enter Master Ledger Name"  required>
                        </div>
                      </div>
                      <div class="col-md-4">
                          <label for="status">Status</label>
                            <select name="status" id="" class="form-control select2">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success tx-size-xs">Save changes</button>
                    <button type="button" class="btn btn-danger tx-size-xs" data-dismiss="modal">Close</button>
                </div>
            </form>
            <!----- End Add Form ------->
        </div>
    </div>
</div>
<!-- Edit  Modal -->
<div class="modal fade bs-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">
                    <span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Update Master Ledger
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!----- Start Update Form ------->
            <form id="addSectionForm" action="{{ route('admin.master_ledger.update') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!----- Start Update Form input ------->
                    <div class="row">
                        <div class="form-group mb-2">
                            <label for="">Master Ledger Name:</label>
                            <input type="text" name="id" class="d-none">
                            <input type="text" name="master_ledger_name" class="form-control" placeholder="Enter Master Ledger Name"  required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="status">Status</label>
                            <select name="status"  class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success tx-size-xs">Save changes</button>
                    <button type="button" class="btn btn-danger tx-size-xs" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
            <!----- End Update Form ------->
        </div>
    </div>
</div>
<div id="deleteModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <form action="{{route('admin.master_ledger.delete')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
            <div class="modal-header flex-column">
                <div class="icon-box">
                    <i class="fas fa-trash"></i>
                </div>
                <h4 class="modal-title w-100">Are you sure?</h4>
                <input type="hidden" name="id" value="">
                <a class="close" data-bs-dismiss="modal" aria-hidden="true"><i class="mdi mdi-close"></i></a>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function(){

     var table=$("#datatable1").DataTable({
       "processing":true,
       "responsive": true,
       "serverSide":true,
       beforeSend: function () {
         //$('#preloader').addClass('active');
       },
       complete: function(){
         //$('.product_loading').css({"display":"none"});
       },
       ajax: "{{ route('admin.master_ledger.all_data') }}",
       language: {
         searchPlaceholder: 'Search...',
         sSearch: '',
         lengthMenu: '_MENU_ items/page',
       },
       "columns":[
         {
           "data":"id"
         },
         {
           "data":"name"
         },
         {
           "data":"status",
           render:function(data,type,row){
               if (row.status==1) {
                   return '<span class="badge bg-success">Active</span>';
               }else{
                   return '<span class="badge bg-danger">Inactive</span>';
               }
           }
         },
         {
           "data":"created_at",
           render: function (data, type, row) {
               var formattedDate = moment(row.created_at).format('DD MMM YYYY');
               return formattedDate;
           }
         },
       ],
       order:[
         [0, "desc"]
       ],

     });
     //$('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
   });



   /** Handle edit button click**/
   $('#datatable1 tbody').on('click', '.edit-btn', function () {
     var id = $(this).data('id');
      var editUrl = '{{ route("admin.master_ledger.edit", ":id") }}';
      var url = editUrl.replace(':id', id);
     $.ajax({
         type: 'GET',
         url: url,
         success: function (response) {
             if (response.success) {
               $('#editModal').modal('show');
               $('#editModal input[name="id"]').val(response.data.id);
               $('#editModal input[name="master_ledger_name"]').val(response.data.name);
               $('#editModal select[name="status"]').val(response.data.status);
             } else {
               toastr.error("Error fetching data for edit!");
             }
         },
         error: function (xhr, status, error) {
           console.error(xhr.responseText);
           toastr.error("Error fetching data for edit!");
         }
     });
   });




 /** Handle Delete button click**/
 $('#datatable1 tbody').on('click', '.delete-btn', function () {
   var id = $(this).data('id');
   $('#deleteModal').modal('show');
   console.log("Delete ID: " + id);
   var value_input = $("input[name*='id']").val(id);
 });



 /** Handle form submission for delete **/
 $('#deleteModal form').submit(function(e){
   e.preventDefault();
   /*Get the submit button*/
   var submitBtn =  $('#deleteModal form').find('button[type="submit"]');

   /* Save the original button text*/
   var originalBtnText = submitBtn.html();

   /*Change button text to loading state*/
   submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`);

   var form = $(this);
   var url = form.attr('action');
   var formData = form.serialize();
   /** Use Ajax to send the delete request **/
   $.ajax({
     type:'POST',
     'url':url,
     data: formData,
     success: function (response) {
       $('#deleteModal').modal('hide');
       if (response.success) {
         toastr.success(response.message);
         $('#datatable1').DataTable().ajax.reload( null , false);
       }
     },

     error: function (xhr, status, error) {
        /** Handle  errors **/
        toastr.error(xhr.responseText);
     },
     complete: function () {
       submitBtn.html(originalBtnText);
       }
   });
 });




 /** Store The data from the database table **/
 $('#addModal form').submit(function(e){
   e.preventDefault();

   var form = $(this);
   var url = form.attr('action');
   var formData = form.serialize();
   /** Use Ajax to send the delete request **/
   $.ajax({
     type:'POST',
     'url':url,
     data: formData,
     success: function (response) {
       $('#addModal').modal('hide');
       $('#addModal form')[0].reset();
       if (response.success) {
         toastr.success(response.message);
         $('#datatable1').DataTable().ajax.reload( null , false);
       } else {
          /** Handle validation errors **/
         if (response.errors) {
           var errorMessages = response.errors.join('<br>');
           toastr.error(errorMessages);
         }
       }
     },

     error: function (xhr, status, error) {
        /** Handle  errors **/
       console.error(xhr.responseText);
     }
   });
 });




 /** Update The data from the database table **/
 $('#editModal form').submit(function(e){
   e.preventDefault();

   var form = $(this);
   var url = form.attr('action');
   var formData = form.serialize();

   // Get the submit button
   var submitBtn = form.find('button[type="submit"]');

   // Save the original button text
   var originalBtnText = submitBtn.html();

   // Change button text to loading state
   submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`);

   var form = $(this);
   var url = form.attr('action');
   var formData = form.serialize();
   /** Use Ajax to send the delete request **/
   $.ajax({
     type:'POST',
     'url':url,
     data: formData,
     beforeSend: function () {
       form.find(':input').prop('disabled', true);
     },
     success: function (response) {

       $('#editModal').modal('hide');
       $('#editModal form')[0].reset();
       if (response.success) {
           submitBtn.html(originalBtnText);
           toastr.success(response.success);
           $('#datatable1').DataTable().ajax.reload( null , false);
       } else {
          /** Handle validation errors **/
         if (response.errors) {
             var errorMessages = response.errors.join('<br>');
             toastr.error(errorMessages);
         }else {
           toastr.error("Error!!!");
         }
       }
     },

     error: function (xhr, status, error) {
       console.error(xhr.responseText);
     },
     complete: function () {
       submitBtn.html(originalBtnText);
         form.find(':input').prop('disabled', false);
       }
   });
 });
  </script>


  @if(session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
    @elseif(session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
    @endif

@endsection

@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                  <a href="{{route('admin.supplier.invoice.create_invoice')}}" class="btn btn-success"><i class="mdi mdi-account-plus"></i>
                    Add New Invoice</a>
            </div>
            <div class="card-body">


                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                            <th class="">Invoice No.</th>
                            <th class="">Supplier Name</th>
                            <th class="">Phone Number</th>
                            <th class="">Total Amount</th>
                            <th class="">Paid Amount</th>
                            <th class="">Due Amount</th>
                            <th class="">Status</th>
                            <th class="">Create Date</th>
                            <th class="">Create By</th>
                            <th class="">Action</th>
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

<div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="mdi mdi-account-check"></i> &nbsp; Add Payment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!----- Start Add Form ------->
            <form action="{{ route('admin.supplier.invoice.pay_due_amount') }}" method="post">
                @csrf
                <div class="modal-body bg-light">
                    <!----- Start Add Form input ------->
                    <input type="number" name="id" class="d-none" required>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount:</label>
                        <input type="number" name="amount" class="form-control border-primary shadow-sm" placeholder="Enter Your Amount" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="mdi mdi-content-save"></i> Save Changes
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="mdi mdi-close"></i> Close
                    </button>
                </div>
            </form>
            <!----- End Add Form ------->
        </div>
    </div>
</div>


<div id="deleteModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <form action="{{route('admin.supplier.invoice.delete_invoice')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
            <div class="modal-header flex-column">
                <div class="icon-box">
                    <i class="fas fa-trash"></i>
                </div>
                <h4 class="modal-title w-100">Are you sure?</h4>
                <input type="hidden" name="id" value="">
                <a class="close" data-dismiss="modal" aria-hidden="true"><i class="fas fa-close"></i></a>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
        var user_type = @php
            echo auth('admin')->user()->user_type;
        @endphp;
      var table=$("#datatable1").DataTable({
         "processing":true,
        "responsive": true,
        "serverSide":true,
        // beforeSend: function (xhr) {
        //     var searchValue = $('#datatable1_filter input').val();
        //     xhr.setRequestHeader('X-Search-Value', searchValue);
        // },
        ajax: {
            url: "{{ route('admin.supplier.invoice.show_invoice_data') }}",
            data: function (d) {
                d.search = $('#datatable1_filter input').val();
            }
        },
        language: {
          searchPlaceholder: 'Search...',
          sSearch: '',
          lengthMenu: '_MENU_ items/page',
        },
        "columns":[
          {
            "data":"id",
            "render":function(data,type,row){
                return '#srtc'+row.id;
            }
          },
          {
            "data":"supplier.fullname"
          },
          {
            "data":"supplier.phone_number"
          },
          {
            "data":"total_amount"
          },
          {
            "data":"paid_amount"
          },
          {
            "data":"due_amount"
          },
          {
            "data":null,
            render:function(data,type,row){
              if (row.due_amount==0) {
                return '<span class="badge bg-success">Paid</span>';
              }else{
                 return '<span class="badge bg-danger">Not Paid</span>';
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
          {
            "data":"user.name",
          },
          {
            "data":null,
            render:function(data,type,row){
                var editUrl = "{{ route('admin.supplier.invoice.edit_invoice', ':id') }}";
                var viewUrl = "{{ route('admin.supplier.invoice.view_invoice', ':id') }}";
                editUrl = editUrl.replace(':id', row.id);
                viewUrl = viewUrl.replace(':id', row.id);

                if(user_type==1){
                    if (row.due_amount==0) {
                    return `
                    <a href="${viewUrl}" class="btn btn-success btn-sm mr-3" ><i class="fa fa-eye"></i></a>

                    <button class="btn btn-danger btn-sm mr-3 delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="${row.id}"><i class="fa fa-trash"></i></button>
                    `;
                    }else{
                    return `
                    <button class="btn btn-primary btn-sm mr-3 pay-button"  data-id="${row.id}">Pay Now</button>

                    <a href="${viewUrl}" class="btn btn-success btn-sm mr-3" ><i class="fa fa-eye"></i></a>

                    <button class="btn btn-danger btn-sm mr-3 delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="${row.id}"><i class="fa fa-trash"></i></button>
                    `;
                    }
                }else{
                    if (row.due_amount==0) {
                    return `
                    <a href="${viewUrl}" class="btn btn-success btn-sm mr-3" ><i class="fa fa-eye"></i></a>
                    `;
                    }else{
                    return `
                    <button class="btn btn-primary btn-sm mr-3 pay-button"  data-id="${row.id}">Pay Now</button>

                    <a href="${viewUrl}" class="btn btn-success btn-sm mr-3" ><i class="fa fa-eye"></i></a>
                    `;
                    }
                }
            }
          },
        ],
        order:[
          [0, "desc"]
        ],

      });
    });

  /** Handle Delete button click**/
  $('#datatable1 tbody').on('click', '.delete-btn', function () {
    var id = $(this).data('id');
    $('#deleteModal').modal('show');
    var value_input = $("input[name*='id']").val(id);
  });

  /** Handle form submission for delete **/
  $('#deleteModal form').submit(function(e){
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
        if (response.success==true) {
          $('#deleteModal').modal('hide');
          toastr.success(response.message);
          $('#datatable1').DataTable().ajax.reload( null , false);
        } else {
           /** Handle  errors **/
          toastr.error("Error!!!");
        }
      },

      error: function (xhr, status, error) {
         /** Handle  errors **/
        console.error(xhr.responseText);
      }
    });
  });
  /** Handle Pay button click**/
  $('#datatable1 tbody').on('click', '.pay-button', function () {
    var id = $(this).data('id');
    $('#payModal').modal('show');
    var value_input = $("input[name*='id']").val(id);
  });
  /** Handle form submission for Pay **/
  $('#payModal form').submit(function(e){
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
        if (response.success==true) {
          $('#payModal').modal('hide');
          toastr.success(response.message);
          $('#datatable1').DataTable().ajax.reload( null , false);
        }
      },

      error: function(xhr, status, error) {
        /** Handle errors **/
        var err = eval("(" + xhr.responseText + ")");
        toastr.error(err.message);
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

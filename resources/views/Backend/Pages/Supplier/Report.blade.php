@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('content')
<div class="row">
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Purchase Report</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.supplier.invoice.generate_invoice_report') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="from_date">From Date:</label>
                                    <input type="date" name="from_date" id="from_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="to_date">To Date:</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="supplier_id">Supplier Name:</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control">
                                        <option value="">Select Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->fullname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Generate Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function(){
        $("#supplier_id").select2();
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

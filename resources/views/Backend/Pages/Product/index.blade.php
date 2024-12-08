@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
<style>
/* Barcode cell customization */
.barcode-cell {
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Barcode wrapper */
.barcode-wrapper {
    display: inline-block;
    max-width: 180px;
    vertical-align: middle;
}

/* Tooltip customization for extra barcodes */
.barcode-tooltip {
    color: #007bff;
    cursor: pointer;
    text-decoration: underline;
}

.barcode-tooltip:hover {
    color: #0056b3;
}
/* Tooltip container customization */
.tooltip {
    background-color: #ced2d6 !important;
    color: #ffffff !important;
    border-radius: 8px !important;
    padding: 10px 15px !important;
    font-size: 14px !important;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1) !important;
    max-width: 300px !important;
    text-align: left;
    word-wrap: break-word !important;
}

/* Tooltip arrow */
.tooltip .arrow::before {
    border-top-color: #343a40 !important;
}

</style>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                  <a href="{{route('admin.products.create')}}" class="btn-sm btn btn-success mb-2"><i class="mdi mdi-account-plus"></i>
                    Add New Product</a>
            </div>
            <div class="card-body">


                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                              <th class="">No.</th>
                              <th class="">Product Barcode</th>
                              <th class="">Product Name</th>
                              <th class="">Brand</th>
                              <th class="">Category</th>
                              <th class="">Warenty</th>
                              <th class="">Purchase Price</th>
                              <th class="">Sale's Price</th>
                              <th class="">Quantity</th>
                              <th class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                          @if ($product->isNotEmpty())

                          @foreach ($product as $data)
                              <tr>
                                <td>{{$i++}}</td>
                                <td class="barcode-cell">
                                    @if ($data->barcodes)
                                        <div class="barcode-wrapper">
                                            @php
                                                $barcodes = $data->barcodes->pluck('barcode');
                                                $visibleBarcodes = $barcodes->take(2);
                                                $hiddenBarcodes = $barcodes->slice(2);
                                            @endphp
                                            {{ $visibleBarcodes->implode(', ') }}
                                            @if ($hiddenBarcodes->isNotEmpty())
                                                <a href="javascript:void(0)" class="barcode-tooltip"
                                                   title="{{ $hiddenBarcodes->implode(', ') }}"> ...more</a>
                                            @endif
                                        </div>
                                    @else
                                        No Data
                                    @endif
                                </td>


                                <td>
                                  @if (strlen($data->title) > 40)
                                  {{ substr($data->title,0,40) }}...
                                  @else
                                  {{ $data->title }}
                                  @endif

                                </td>
                                <td>
                                  {{ $data->brand->brand_name?? 'No Data' }}

                                </td>
                                <td>
                                    {{ $data->category->category_name?? 'No Data' }}

                                </td>
                                <td>{{$data->warenty?? 'No Data'}}</td>
                                <td>{{$data->p_price}}</td>
                                <td>{{$data->s_price}}</td>
                                <td>
                                  @if ($data->qty==0)
                                  <span class="badge badge-danger">Out of Stock</span>
                                  @else

                                    <span class="badge badge-success">  {{ $data->qty }}</span>
                                  @endif
                                </td>

                                <td>
                                    @if(auth('admin')->user()->user_type==1)
                                        <a class="btn btn-primary btn-sm mr-3" href="{{route('admin.products.edit', $data->id)}}"><i class="fa fa-edit"></i></a>
                                        <button data-toggle="modal" data-target="#deleteModal{{$data->id}}" class="btn btn-danger btn-sm mr-3"><i class="fa fa-trash"></i></button>
                                        {{-- <a class="btn btn-success btn-sm mr-3" href="{{route('admin.products.view', $data->id)}}"><i class="fa fa-eye"></i></a> --}}
                                    @else

                                    @endif


                                </td>
                              </tr>
                            <!--Start Delete MODAL ---->
                            <div id="deleteModal{{$data->id}}" class="modal fade">
                              <div class="modal-dialog modal-confirm">
                                  <form action="{{route('admin.products.delete')}}" method="post" enctype="multipart/form-data">
                                      @csrf
                                      <div class="modal-content">
                                      <div class="modal-header flex-column">
                                          <div class="icon-box">
                                              <i class="fas fa-trash"></i>
                                          </div>
                                          <h4 class="modal-title w-100">Are you sure?</h4>
                                          <input type="hidden" name="id" value="{{$data->id}}">
                                          <a class="close" data-bs-dismiss="modal" aria-hidden="true"><i class="mdi mdi-close"></i></a>
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
                            <!--End Delete MODAL ---->
                          @endforeach

                          @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection

@section('script')
  <script type="text/javascript">
    $(document).ready(function(){
      $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });
        //$('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    });
    $(document).ready(function () {
        $('.barcode-tooltip').tooltip({
            placement: 'top',
            html: true
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

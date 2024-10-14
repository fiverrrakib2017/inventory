@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                  <h4>Product Stock</h4>
            </div>
            <div class="card-body">


                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="">No.</th>
                                <th class="">Image</th>
                                <th class="">Product Name</th>
                                <th class="">Stock</th>
                                <th class="">Purchase Price</th>
                                <th class="">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach($products as $index => $product)
                            @php
                                $title = strlen($product->title) > 50 ? substr($product->title, 0, 50) . '...' : $product->title;
                                $productTotal = $product->qty * $product->p_price;
                                $total += $productTotal; 
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if(isset($product->product_image[0]))
                                    <img src="{{ asset('uploads/product/'.$product->product_image[0]->image ) }}" alt="" srcset="" width="40px" height="40px" class="image-fluid">
                                    @else
                                    <span>No Image</span>
                                    @endif
                                </td>
                                <td>{{ $title }}</td>
                                <td>{{ $product->qty }}</td>
                                <td>{{ $product->p_price }}</td>
                                <td>{{ $productTotal }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" style="text-align: right;">Total</th>
                                <th>{{ $total }}</th>
                            </tr>
                        </tfoot>
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
    $("#datatable1").DataTable();
  });
</script>

@endsection

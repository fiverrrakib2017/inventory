@extends('Backend.Layout.App')
@section('title','Create Product Page')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card shadow-sm border-0 rounded">
      <form action="{{ route('admin.products.store') }}"  id="productForm" enctype="multipart/form-data" method="POST">
         @csrf
         <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Create New Product</h4>
         </div>
         <div class="card-body">
            <div class="row">
               <!-- Product Title -->
               <div class="col-md-6">
                  <div class="form-group mb-3">
                     <label for="title" class="form-label">Product Title <span class="text-danger">*</span></label>
                     <input type="text" name="title" id="title" class="form-control" placeholder="Enter product title" required>
                  </div>
               </div>
               <!-- Brand Select -->
               <div class="col-md-6">
                  <div class="form-group mb-3">
                     <label for="brand_id" class="form-label">Brand <span class="text-danger">*</span></label>
                     <select name="brand_id" id="brand_id" class="form-control" required>
                        <option value="" disabled selected>Select Brand</option>
                        @foreach($brand as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
            <div class="row">
               <!-- Category Select -->
               <div class="col-md-4">
                  <div class="form-group mb-3">
                     <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                     <select name="category_id" id="category_id" class="form-control" required>
                        <option value="" disabled selected>Select Category</option>
                        @foreach($category as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <!-- Warenty input -->
               <div class="col-md-4">
                  <div class="form-group mb-3">
                     <label for="" class="form-label">Warenty <span class="text-danger">*</span></label>
                     <input name="warenty" id="warenty" class="form-control" placeholder="Enter Your Product Warenty" required />
                  </div>
               </div>
               <!-- Purchase Price -->
               <div class="col-md-4">
                  <div class="form-group mb-3">
                     <label for="p_price" class="form-label">Purchase Price</label>
                     <input type="number" name="p_price" id="p_price" class="form-control" step="0.01" placeholder="Enter purchase price">
                  </div>
               </div>
            </div>
            <div class="row">
               <!-- Sale Price -->
               <div class="col-md-6">
                  <div class="form-group mb-3">
                     <label for="s_price" class="form-label">Sale Price</label>
                     <input type="number" name="s_price" id="s_price" class="form-control" placeholder="Enter sale price">
                  </div>
               </div>
               <!-- Product Type -->
               <div class="col-md-6">
                  <div class="form-group mb-3">
                     <label for="product_type" class="form-label">Product Type <span class="text-danger">*</span></label>
                     <select name="product_type" id="product_type" class="form-control" required>
                        <option value="" disabled selected>---Select---</option>
                        <option value="Features">Features</option>
                        <option value="Popular">Popular</option>
                        <option value="New">New</option>
                     </select>
                  </div>
               </div>
            </div>
            <div class="row">
               <!-- Product Unit -->
               <div class="col-md-6">
                  <div class="form-group mb-3">
                     <label for="Product Unit" class="form-label">Product Unit <span class="text-danger">*</span></label>
                     <select name="unit_id" id="unit_id" class="form-control"  required>
                        <option value="">---Select---</option>
                        @foreach ($units as $item)
                            <option value="{{ $item->id }}">{{ $item->unit_name }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <!-- Quantity -->
               <div class="col-md-6">
                  <div class="form-group mb-3">
                     <label for="qty" class="form-label">Quantity</label>
                     <input type="number" name="qty" id="qty" class="form-control" placeholder="Enter quantity" value="0">
                  </div>
               </div>
            </div>
            <div class="row">
               <!-- Product color -->
               <div class="col-md-6">
                  <div class="form-group mb-3">
                     <label for="">Color</label>
                     <select class="form-control" id="color" name="color[]" multiple="multiple" >
                        <option value="">---Select---</option>
                        @foreach ($color as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <!-- Product Size -->
               <div class="col-md-6">
                  <div class="form-group mb-3">
                     <label for="">Size</label>
                     <select type="text" class="form-control" id="size" name="size[]" multiple="multiple" >
                        <option value="">---Select---</option>
                        @foreach ($size as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
            <div class="card-footer ">
               <button type="button" onclick="window.history.back()" class="btn btn-danger">Back</button>
               <button type="submit" class="btn btn-primary">Create Product</button>
            </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('script')
<script  src="{{ asset('Backend/dist/js/__handle_submit.js') }}"></script>
<script type="text/javascript">
   $(document).ready(function() {
      /*Product barcode textarea change event*/
      $('#product_barcode').on('input', function() {
        let barcodeInput = $(this).val().trim();
        let barcodes = barcodeInput.split(/\s+/);
         if (barcodes.length > 0) {
            $('#qty').val(barcodes.length);
         } else {
            $('#qty').val(0);
        }
      });
   });

   $("#brand_id").select2();
   $("#category_id").select2();
   $("#status").select2();
   $("#product_type").select2();
   $("#unit_id").select2();
   $("#color, #size").select2({
     allowClear: true,
     placeholder: "Select "
   });

   /** Product Store  **/
   handleSubmit('#productForm');



</script>
@endsection

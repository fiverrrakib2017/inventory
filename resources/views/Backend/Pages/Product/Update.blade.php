@extends('Backend.Layout.App')
@section('title','Update Product Page')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card shadow-sm border-0 rounded">
      <form action="{{ route('admin.product.update') }}"  id="productForm" enctype="multipart/form-data" method="POST">
         @csrf
         <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Update Product</h4>
         </div>
         <div class="card-body">
            <div class="row">
               <!-- Product Title -->
               <div class="col-md-6">
                  <div class="form-group mb-3">
                     <label for="title" class="form-label">Product Title <span class="text-danger">*</span></label>
                     <input type="text" name="id" id="id" class="d-none" required>
                     <input type="text" name="title" id="title" class="form-control" placeholder="Enter product title" value="{{ $data->title }}" required>
                  </div>
               </div>
               <!-- Brand Select -->
               <div class="col-md-6">
                  <div class="form-group mb-3">
                     <label for="brand_id" class="form-label">Brand <span class="text-danger">*</span></label>
                     <select name="brand_id" id="brand_id" class="form-control" required>
                        <option value="" disabled selected>Select Brand</option>
                        @foreach($brand as $item)
                        <option value="{{ $item->id }}" {{ $data->brand_id == $item->id ? 'selected' : '' }}>{{ $item->brand_name }}</option>
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
                        <option value="{{ $category->id }}" {{ $data->category_id==$category->id ? 'selected':'' }}>{{ $category->category_name }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <!-- Warenty input -->
               <div class="col-md-4">
                  <div class="form-group mb-3">
                     <label for="" class="form-label">Warenty <span class="text-danger">*</span></label>
                     <input name="warenty" id="warenty" class="form-control" placeholder="Enter Your Product Warenty" value="{{ $data->warenty }}" required />
                  </div>
               </div>
               <!-- Purchase Price -->
               <div class="col-md-4">
                  <div class="form-group mb-3">
                     <label for="p_price" class="form-label">Purchase Price</label>
                     <input type="number" name="p_price" id="p_price" class="form-control" step="0.01" placeholder="Enter purchase price" value="{{ $data->p_price }}">
                  </div>
               </div>
            </div>
            <div class="row">
               <!-- Sale Price -->
               <div class="col-md-6">
                  <div class="form-group mb-3">
                     <label for="s_price" class="form-label">Sale Price</label>
                     <input type="number" name="s_price" id="s_price" class="form-control" placeholder="Enter sale price" value="{{ $data->s_price }}">
                  </div>
               </div>
               <!-- Product Type -->
               <div class="col-md-6">
                  <div class="form-group mb-3">
                     <label for="product_type" class="form-label">Product Type <span class="text-danger">*</span></label>
                     <select name="product_type" id="product_type" class="form-control" required>
                        <option value="" disabled selected>---Select---</option>
                        <option value="Features" {{ $data->product_type == 'Features' ? 'selected' : '' }}>Features</option>
                        <option value="Popular" {{ $data->product_type == 'Popular' ? 'selected' : '' }}>Popular</option>
                        <option value="New" {{ $data->product_type == 'New' ? 'selected' : '' }}>New</option>
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
                            <option value="{{ $item->id }}" {{ $data->unit_id== $item->id ? 'selected':'' }}>{{ $item->unit_name }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <!-- Quantity -->
               <div class="col-md-6">
                  <div class="form-group mb-3">
                     <label for="qty" class="form-label">Quantity</label>
                     <input type="number" name="qty" id="qty" class="form-control" placeholder="Enter quantity"value="{{ $data->qty }}">
                  </div>
               </div>
            </div>
            <div class="row">
               <!-- Product color -->
               <div class="col-md-6">
                  <div class="form-group mb-3">
                     <label for="">Color</label>
                     <select class="form-control" id="color" name="color[]" multiple="multiple">
                        <option value="" disabled>---Select---</option>
                        @php
                            $selectedColors = explode(',', $data->color ?? '');
                        @endphp
                        @foreach ($colors as $item)
                            <option value="{{ $item->name }}" {{ in_array($item->name, $selectedColors) ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
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
                        @php
                            $selectedSizes= explode(',',$data->size ?? '');
                        @endphp
                        @foreach ($sizes as $item)
                        <option value="{{ $item->name }}" {{ in_array($item->name, $selectedSizes) ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
            <div class="card-footer ">
               <button type="button" onclick="window.history.back()" class="btn btn-danger">Back</button>
               <button type="submit" class="btn btn-success">Update Product</button>
            </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('script')
<script  src="{{ asset('Backend/dist/js/__handle_submit.js') }}"></script>
<script type="text/javascript">

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

@extends('Backend.Layout.App')

@section('title','Create Product Page')

@section('style')
<link rel="stylesheet" href="{{ asset('Backend/dist/css/dropzone.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('Backend/plugins/summernote/summernote-bs4.min.css') }}" type="text/css" />

@section('content')
<div class="row">
    <div class="col-md-9 m-auto">
        <div class="card">
            <div class="card-header bg-info text-white">
              <h4>Add New Product</h4>
            </div>
            <form action="{{ route('admin.products.store') }}" id="productForm" enctype="multipart/form-data" method="post">@csrf
          <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-2">
                <label for="">Product Name</label>
                <input type="text"  class="form-control" name="product_name" id="product_name" placeholder="Enter Product Name" required>
                
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-2">
                <label for="">Product Image</label>
                <input type="file"  class="form-control" name="image" id="product_image">
                <img id="image_preview" src="{{asset('Backend/dist/img/default.png')}}" alt=""  class="img-thumbnail" height="200px" width="200px">
            </div>
            </div>
          </div>


          <div class="row">

            <div class="col">
              <div class="form-group mb-2">
                <label for="">Brand</label>
                <select type="text" class="form-control" name="brand_id" id="brand_id" required>
                  <option value="">---Select---</option>
                  @if (count($brand) > 0)

                    @foreach($brand as $item)
                    <option value="{{$item->id}}">{{ $item->brand_name }}</option>
                    @endforeach
                  @endif
                </select>
                <p class="ierr"></p>
              </div>
            </div>
            <div class="col">
              <div class="form-group mb-2">
                <label for="">Category</label>
                <select type="text" class="form-control " name="category_id" id="category_id" required>
                  <option value="">Select</option>
                  @if (count($category) > 0)

                    @foreach($category as $item)
                    <option value="{{$item->id}}">{{ $item->category_name }}</option>
                    @endforeach

                  @else
                    <option value="">No Product</option>
                  @endif

                </select>
              </div>
            </div>
          </div>


       

          <div class="row">
            <div class="col-md-12">
              <div class="form-group mb-2">
                <label for="">Description</label>
                <textarea type="text" class="form-control"  name="description" id="description" placeholder="Enter Your Description" style="height: 600px;"></textarea>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-group mb-2">
                <label for="">Purchase Price</label>
                <input type="number" class="form-control" id="p_price"  name="p_price" placeholder="Enter Your Price" required/>
              </div>
            </div>
            <div class="col">
              <div class="form-group mb-2">
                <label for="">Sale's Price</label>
                <input type="number" class="form-control" id="s_price"  name="s_price" placeholder="Enter Your Sale's Price" required/>
              </div>
            </div>
          </div>



          <div class="row">
            <div class="col-md-4">
              <div class="form-group mb-2">
                <label for="">Size</label>
                <select type="text" class="form-control" id="size" name="size[]" multiple="multiple" >
                <option value="">---Select---</option>
                  @foreach ($size as $item)
                     <option value="{{ $item->name }}">{{ $item->name }}</option>
                  @endforeach

                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-2">
                <label for="">Color</label>
                <select class="form-control" id="color" name="color[]" multiple="multiple" >
                  <option value="">---Select---</option>
                    @foreach ($color as $item)
                     <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-2">
                <label for="">Product Type</label>
                <select type="text" class="form-control" name="product_type" id="product_type" required>
                  <option >---Select---</option>
                  <option value="Features">Features</option>
                  <option value="Popular">Popular</option>
                  <option value="New">New</option>
                </select>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-md-4">
              <div class="form-group mb-2" >
                <label for="">Barcode</label>
                <input type="text" class="form-control"  name="barcode[]" id="barcodes"/>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-2">
              <label for="qty" class="label">Quantity</label>
              <input type="number" name="qty" class="form-control" id="qty" placeholder="Enter Quantity" required>
            
            </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-2">
              <label for="">Status</label>
                <select type="text" class="form-control" name="status" id="status" required>
                  <option value="">Select</option>
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
            </div>
            </div>
          </div>
          </div>
          <div class="card-footer">
            <button type="button" onclick="history.back();" class="btn btn-danger">Back</button>
            <button type="submit" class=" btn btn-success">Add Now</button>
          </div>
        </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('Backend/dist/js/dropzone.min.js') }}"></script>
<script src="{{ asset('Backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script type="text/javascript">
  document.getElementById('product_image').addEventListener('change', function(event) {
      if (event.target.files && event.target.files[0]) {
          var reader = new FileReader();

          reader.onload = function(e) {
              document.getElementById('image_preview').src = e.target.result;
          }
          reader.readAsDataURL(event.target.files[0]);
      }
  });
    $("#brand_id").select2();
    $("#category_id").select2();
    $("#status").select2();
    $("#product_type").select2();

    $("#color, #size").select2({
      allowClear: true,
      placeholder: "Select "
    });
    
   

       /** Editor **/
      $('#description').summernote(); 


    /** Product Store  **/
    //handleSubmit('#productForm');
  </script>
@endsection
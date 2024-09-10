@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')

@section('content')
<div class="row">
    <div class="col-md-6 m-auto">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New Customer</h3>
            </div>
            <form action="{{ route('admin.customer.store') }}" method="post" id="addCustomerForm">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" class="form-control" name="fullname" placeholder="Enter full name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number" placeholder="Enter phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address"  placeholder="Enter phone number" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')

<script  src="{{ asset('Backend/dist/js/__handle_submit.js') }}"></script>
<script  type="text/javascript">
    $(document).ready(function(){
        handleSubmit('#addCustomerForm');
    });
</script> 
@endsection

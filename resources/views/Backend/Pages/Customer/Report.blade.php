@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('content')
<div class="row">
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Sale's Report</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.customer.invoice.generate_invoice_report') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="from_date">From Date:</label>
                                    <input type="date" name="from_date" id="from_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="to_date">To Date:</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="customer_id">Customer Name:</label>
                                    <select name="customer_id" id="customer_id" class="form-control">
                                        <option value="">---Select---</option>
                                        @foreach ($customers as $item)
                                            <option value="{{ $item->id }}">{{ $item->fullname }}</option>
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
<script>
    $(document).ready(function(){
        $("#customer_id").select2();
    });
</script>


@endsection

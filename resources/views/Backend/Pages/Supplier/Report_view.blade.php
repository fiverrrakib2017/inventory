@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                <button type="button" onclick ="history.back();" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</button>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="">No.</th>
                                <th class="">Supplier Name</th>
                                <th class="">Phone Number</th>
                                <th class="">Total Amount</th>
                                <th class="">Paid Amount</th>
                                <th class="">Due Amount</th>
                                <th class="">Status</th>
                                <th class="">Create Date</th>
                                <th class="">Create By</th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalAmount = 0;
                                $totalPaid = 0;
                                $totalDue = 0;
                            @endphp

                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->supplier->fullname }}</td>
                                <td>{{ $item->supplier->phone_number }}</td>
                                <td>{{ $item->total_amount }}</td>
                                <td>{{ $item->paid_amount }}</td>
                                <td>{{ $item->due_amount }}</td>
                                <td>
                                    @if ($item->due_amount == 0)
                                        <span class="badge badge-success">Paid</span>
                                    @else
                                        <span class="badge badge-danger">Due</span>
                                    @endif
                                </td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>


                                <td>{{ $item->user->name }}</td>
                                <td>
                                    <a href="{{ route('admin.supplier.invoice.view_invoice', $item->id) }}" class="btn btn-success btn-sm mr-3">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>

                            @php
                                $totalAmount += $item->total_amount;
                                $totalPaid += $item->paid_amount;
                                $totalDue += $item->due_amount;
                            @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Totals:</th>
                                <th>{{ $totalAmount }}</th>
                                <th>{{ $totalPaid }}</th>
                                <th>{{ $totalDue }}</th>
                                <th colspan="4"></th>
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

<script>
    $(document).ready(function() {
        $('#datatable1').DataTable();
    });
</script>

@endsection

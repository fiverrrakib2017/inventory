@extends('Backend.Layout.App')
@section('title', 'Dashboard | Admin Panel')
@section('style')
    <style>
        /* Product Title column larger */
        th:nth-child(1),
        td:nth-child(1) {
            width: 30%;
            /* Adjust as necessary */
        }

        /* Qty column smaller */
        th:nth-child(2),
        td:nth-child(2) {
            width: 20%;
            /* Adjust as necessary */
        }

        /* Price column smaller */
        th:nth-child(3),
        td:nth-child(3) {
            width: 20%;
            /* Adjust as necessary */
        }

        /* Total Price column smaller */
        th:nth-child(4),
        td:nth-child(4) {
            width: 20%;
            /* Adjust as necessary */
        }

        /* Adjust remove button column */
        th:nth-child(5),
        td:nth-child(5) {
            width: 10%;
            /* Adjust as necessary */
        }
    </style>
@endsection
@section('content')
    <!-- br-pageheader -->
    <div class="row">
        <div class="col-md-12">
            <div class="row d-flex">
                <div class="col-md-12  m-auto">
                    <div class="card-header">
                        <div class="row">
                            <form action="{{ route('admin.customer.store') }}" method="post" id="customerForm"
                                class="w-100 d-flex"> @csrf
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" class="form-control" name="fullname"
                                            placeholder="Enter full name" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number"
                                            placeholder="Enter phone number" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" name="address"
                                            placeholder="Enter Address" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn-success mt-3">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card card-body">
                        <form id="form-data" action="{{ route('admin.customer.invoice.store_invoice') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <select type="text" id="product_name" class="form-select" style="width:100%">
                                            <option>---Select---</option>
                                            @foreach ($product as $item)
                                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Bar Code</label>
                                        <textarea type="text" id="product_barcode" class="form-control" style="height: 38px;" placeholder="Enter barcode"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="">QTY</label>
                                        <input type="number" id="product_qty" class="form-control"
                                            placeholder="Enter quantity" />
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="supplier_name">Product Price</label>
                                        <input type="text" id="product_price" class="form-control"
                                            placeholder="Enter price" />
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="supplier_name">Customer Name</label>
                                        <select class="form-select" name="customer_id" id="customer_id" style="width:100%">
                                            <option>---Select---</option>
                                            @foreach ($customer as $item)
                                                <option value="{{ $item->id }}">{{ $item->fullname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary " type="button" id="submitBtn"
                                            style="margin-top: 28px !important;">Add Now</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead class="bg bg-info text-white">
                                            <th>Product List</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                            <th></th>
                                        </thead>
                                        <tbody id="tableRow"></tbody>
                                        <tfoot class="">
                                            <tr>
                                                <th class="text-center" colspan="3"></th>
                                                <th class="text-left" colspan="2">
                                                    Total Amount <input readonly class="form-control total_amount"
                                                        name="total_amount" type="text">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="text-center" colspan="3"></th>
                                                <th class="text-left" colspan="2">
                                                    Paid Amount <input type="text" class="form-control paid_amount"
                                                        name="paid_amount" placeholder="Enter paid amount">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="text-center" colspan="3"></th>
                                                <th class="text-left" colspan="2">
                                                    Due Amount <input type="text" readonly
                                                        class="form-control due_amount" name="due_amount"
                                                        placeholder="Enter due amount">
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="form-group text-right" id="footerBtn">
                                        <button type="submit" class="btn btn-success" style="margin-right: 100px;"><i
                                                class="fas fe-dollar"></i> Create Now</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
<script  src="{{ asset('Backend/dist/js/__handle_submit.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            handleSubmit('#customerForm');
            $("#customer_id").select2();
            $("#product_name").select2();


            /*Barcode check*/
            $('#product_barcode').on('input', function() {
                let barcodeInput = $(this).val().trim();
                let product_id = $("#product_name").val();
                let barcodes = barcodeInput.split(/\s+/);
                $('#product_qty').val(barcodes.length);
                // if (barcodes.length > 0) {
                //     $('#product_qty').val(barcodes.length);
                //     $.ajax({
                //         url: '{{ route('admin.customer.invoice.check_barcodes') }}',
                //         method: 'POST',
                //         data: {
                //             barcodes: barcodes,
                //             product_id: product_id,
                //             _token: '{{ csrf_token() }}'
                //         },
                //         success: function(response) {
                //             if (response.success) {
                //                 toastr.success('Barcode Found');
                //             } else {
                //                 toastr.error('Invalid barcode(s): ' + response.invalid_barcodes.join(', '));
                //                 $('#product_qty').val(0);

                //                 $('#product_barcode').val('');
                //                 $('#product_barcode').focus();
                //             }
                //         },
                //         error: function() {
                //             toastr.error('An error occurred while checking the barcodes.');
                //             $('#product_qty').val(0);
                //             $('#product_barcode').val('');
                //             $('#product_barcode').focus();
                //         }
                //     });
                // } else {
                //     $('#product_qty').val(0);
                // }
            });

            /* Add button click event*/
            $('#submitBtn').on('click', function() {
                var productID = $('#product_name').val();
                var productName = $('#product_name option:selected').text();
                var barcode = $('#product_barcode').val();
                var qty = $('#product_qty').val();
                var price = $('#product_price').val();
                var totalPrice = qty * price;

                /* Validate if all fields are filled*/
                if (productID !== ''  && qty !== '' && price !== '') {
                    /* Create a new table row*/
                    var newRow = `
               <tr>
                  <td>
                     <input type="hidden" name="product_id[]" value="${productID}">
                     <input type="hidden" name="product_barcode[]" value="${barcode}">
                     ${productName} <br> || ${barcode}
                  </td>
                  <td>
                     <input readonly type="number" min="1" name="qty[]" value="${qty}" class="form-control qty">
                  </td>
                  <td>
                     <input readonly type="number" name="price[]" class="form-control" value="${price}">
                  </td>
                  <td>
                     <input readonly type="number" name="total_price[]" class="form-control" value="${totalPrice}">
                  </td>
                  <td>
                     <a class="btn-sm btn-danger" type="button" id="itemRow"><i class="fas fa-trash"></i></a>
                  </td>
               </tr>
            `;

                    /* Append the new row to the table*/
                    $('#tableRow').append(newRow);

                    /* Clear form fields after adding the product*/
                    $('#product_name').val('');
                    $('#product_barcode').val('');
                    $('#product_qty').val('');
                    $('#product_price').val('');

                    /*Update the total amount*/
                    updateTotalAmount();
                } else {
                    toastr.error('Please fill all fields before adding.');
                }
            });

            // Function to update total amount in the table footer
            function updateTotalAmount() {
                var totalAmount = 0;
                $('input[name="total_price[]"]').each(function() {
                    totalAmount += parseFloat($(this).val());
                });
                $('.total_amount').val(totalAmount);
                updateDueAmount();
            }

            // Calculate due amount based on paid amount
            $('.paid_amount').on('input', function() {
                updateDueAmount();
            });

            function updateDueAmount() {
                var totalAmount = parseFloat($('.total_amount').val());
                var paidAmount = parseFloat($('.paid_amount').val()) || 0;
                var dueAmount = totalAmount - paidAmount;
                $('.due_amount').val(dueAmount);
            }

            // Remove row when delete button is clicked
            $(document).on('click', '#itemRow', function() {
                $(this).closest('tr').remove();
                updateTotalAmount();
            });
            $("#form-data").submit(function(e) {
                e.preventDefault();

                var form = $(this);
                form.find('button[type="submit"]').prop('disabled', true).html(`Loading...`);
                var url = form.attr('action');
                var formData = form.serialize();
                /** Use Ajax to send the  request **/
                $.ajax({
                    type: 'POST',
                    'url': url,
                    data: formData,
                    success: function(response) {
                        if (response.success == true) {
                            console.log(response.data.id);
                            toastr.success(response.message);
                            $("#form-data")[0].reset();

                            // Correcting this line
                            var viewUrl = "{{ route('admin.customer.invoice.view_invoice', ':id') }}";
                            viewUrl = viewUrl.replace(':id', response.data.id);

                            // Fixing the viewUrl usage
                            $("#footerBtn").html(
                                `<a href='${viewUrl}' class="btn btn-success"><i class="fas fe-file"></i> Print</a>`
                            );
                        }
                        if (response.success == false) {
                            toastr.success(response.message);
                        }
                    },

                    error: function(xhr, status, error) {
                        /** Handle  errors **/
                        if (xhr.status === 400) {
                            toastr.error(xhr.responseJSON.message);
                            return false;
                        }
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            Object.values(errors).forEach(function(errorMessage) {
                                toastr.error(errorMessage);
                            });
                            return false;
                        } else {
                            console.error(xhr.responseText);
                            toastr.error('Invoice Not Created');
                        }
                    },
                    complete: function() {
                        form.find('button[type="submit"]').prop('disabled', false).html(
                            'Create Now');
                    }
                });
            });

        });
    </script>


@endsection

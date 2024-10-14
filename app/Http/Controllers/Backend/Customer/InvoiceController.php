<?php

namespace App\Http\Controllers\Backend\Customer;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Customer_Invoice;
use App\Models\Customer_Invoice_Details;
use App\Models\Customer_Transaction_History;
use App\Models\Add_Contract;
use App\Models\Product;
use App\Models\Product_barcode;
use App\Models\User;
use App\Services\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    protected $invoiceService;
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService=$invoiceService;
    }
    public function create_invoice(){
        return $this->invoiceService->createInvoice('Customer');
    }

    public function show_invoice(){
        return view('Backend.Pages.Customer.invoice');
    }
    public function view_invoice($id){
       $data=  Customer_Invoice::with('customer','items.product')->find($id);
       return view('Backend.Pages.Customer.invoice_view',compact('data'));
    }
    public function edit_invoice($id){
        $customer=Customer::latest()->get();
        $product=Product::latest()->get();
        $products=Product::with('product_image')->paginate(10);
       $data=  Customer_Invoice::with('customer','items')->where('id',$id)->get();
       return view('Backend.Pages.Customer.invoice_edit',compact('data','customer','product','products'));
    }

    public function show_invoice_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'customer_name', 'phone_number','total_amount', 'paid_amount', 'due_amount','status','created_at'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];

        $query = Customer_Invoice::with('customer')->when($search, function ($query) use ($search) {
            $query->where('total_amount', 'like', "%$search%")
                  ->orWhere('paid_amount', 'like', "%$search%")
                  ->orWhere('due_amount', 'like', "%$search%")
                  ->orWhere('created_at', 'like', "%$search%")
                  ->orWhereHas('customer', function ($query) use ($search) {
                      $query->where('fullname', 'like', "%$search%")
                            ->orWhere('phone_number', 'like', "%$search%");
                  });
        }) ->orderBy($columnsForOrderBy[$orderByColumn], $orderDirection)
        ->paginate($request->length);


        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $query->total(),
            'recordsFiltered' => $query->total(),
            'data' => $query->items(),
        ]);
    }
    public function store_invoice(Request $request){
        /* Validate incoming request data*/
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer',
            'product_id' => 'required|array',
            'product_id.*' => 'required|numeric',
            'product_barcode' => 'required|array',
            'product_barcode.*' => 'string',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric',
            'price' => 'required|array',
            'price.*' => 'required|numeric',
            'total_price' => 'required|array',
            'total_price.*' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'due_amount' => 'required|numeric',
        ]);

        /* If validation fails, return the error response*/
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        /*Begin a database transaction*/
        DB::beginTransaction();

    try {
        /* Check product stock before creating invoice */
        foreach ($request->product_id as $index => $productId) {
            $product = Product::find($productId);
            $requestedQty = $request->qty[$index];

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message'=>'Product not found for ID: ' . $productId,
                ], 404);
            }

            /* Check if stock is sufficient */
            if ($product->qty < $requestedQty) {
                return response()->json([
                    'success' => false,
                    'message'=>'Insufficient stock for product. Available stock: ' . $product->qty . ', Requested quantity: ' . $requestedQty
                ], 400);
            }
        }
        /* Create the invoice*/
        $invoice = new Customer_Invoice();
        $invoice->customer_id = $request->customer_id;
        $invoice->total_amount = $request->total_amount;
        $invoice->paid_amount = $request->paid_amount ?? 0;
        $invoice->due_amount = $request->due_amount ?? $request->total_amount;
        $invoice->save();

        /*Loop through each product to create invoice details and update stock*/
        foreach ($request->product_id as $index => $productId) {
            $invoiceItem = new Customer_Invoice_Details();
            $invoiceItem->invoice_id = $invoice->id;
            $invoiceItem->product_id = $productId;
            $invoiceItem->barcode = $request->product_barcode[$index];
            $invoiceItem->qty = $request->qty[$index];
            $invoiceItem->price = $request->price[$index];
            $invoiceItem->total_price = $request->total_price[$index];
            $invoiceItem->save();

            /* Update product stock*/
            $product = Product::find($productId);
            if ($product) {
                $product->qty -= $request->qty[$index];
                $product->save();
            }
        }

        /*Commit the transaction if everything is fine*/
        DB::commit();
            return response()->json(['success' => true, 'message' => 'Invoice stored successfully', 'data' => $invoice], 201);
        } catch (\Exception $e) {
            /*Rollback all changes if something goes wrong*/
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }
    public function delete_invoice(Request $request){
        $invoice = Customer_Invoice::find($request->id);
        $invoice->delete();
        return response()->json(['success'=>true,'message' => 'Invoice deleted successfully']);
    }
    public function pay_due_amount(Request $request){
        $request->validate([
            'id' => 'required|integer',
            'amount' => 'required|numeric',
        ]);

        $invoice =Customer_Invoice::find($request->id);
        $dueAmount = $invoice->due_amount;

        if ($request->amount > $dueAmount) {
            return response()->json(['success' => false, 'message' => 'Over Amount Not Allowed'], 400);
        }

        $paid_amount = $invoice->paid_amount + $request->amount;
        $due_amount = max($invoice->due_amount - $request->amount, 0);

        $invoice->update([
            'paid_amount' => $paid_amount,
            'due_amount' => $due_amount,
        ]);
        /*Log transaction history*/
        $object = new Customer_Transaction_History();
        $object->invoice_id = $request->id;
        $object->customer_id = $invoice->customer_id;
        $object->amount = $request->amount;
        $object->status = 1;
        $object->save();

        return response()->json(['success'=>true,'message' => 'Payment successful'], 200);
    }
    protected function __validate_method($request){
        $ruls=[
            'customer_id' => 'required|integer',
            'product_id' => 'required|array',
            'product_id.*' => 'required|numeric',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric',
            'price' => 'required|array',
            'price.*' => 'required|numeric',
            'total_price' => 'required|array',
            'total_price.*' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'due_amount' => 'required|numeric',
        ];
        return Validator::make($request->all(), $ruls);
    }
    private function __create_invoice($request,$invoice,$existing_qty){
        foreach ($request->product_id as $index => $productId) {
            $item = new Customer_Invoice_Details();
            $item->invoice_id = $invoice->id;
            $item->product_id = $productId;
            $item->qty = $request->qty[$index];
            $item->price = $request->price[$index];
            $item->total_price = $request->qty[$index] * $request->price[$index];
            $item->save();
            /*Update product stock*/
            $product = Product::find($productId);
            if ($product) {
                $old_qty = $existing_qty[$productId] ?? 0;
                $difference= $request->qty[$index]-$old_qty;
                $product->qty-=$difference;
                $product->save();
            }
        }
    }
    public function  __get_product_qty($product_id){
        $product = Product::find($product_id);

        /*Check if the product exists*/
        if (!$product) {
            return 0;
        }

        /*Return the quantity */
        return $product->qty;
    }
    public function check_barcodes(Request $request){
        $barcodes = $request->input('barcodes');
        $invalidBarcodes = [];

        foreach ($barcodes as $barcode) {
            $product = Product_barcode::where('barcode', $barcode)->first();
            if (!$product) {
                $invalidBarcodes[] = $barcode;
            }
        }

        if (count($invalidBarcodes) > 0) {
            return response()->json([
                'success' => false,
                'invalid_barcodes' => $invalidBarcodes
            ]);
        } else {
            return response()->json(['success' => true]);
        }
    }
}

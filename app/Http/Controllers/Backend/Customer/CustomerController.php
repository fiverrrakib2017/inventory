<?php

namespace App\Http\Controllers\Backend\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Customer_Invoice;
use App\Models\Customer_Transaction_History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        return view('Backend.Pages.Customer.index');
    }
    public function create()
    {
        return view('Backend.Pages.Customer.Create');
    }

    public function get_all_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy =  ['id', 'fullname', 'phone_number', 'address', 'created_at'];
        $orderByColumn = $columnsForOrderBy[$request->order[0]['column']];
        $orderDirection = $request->order[0]['dir'];

        $query = Customer::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->orWhere('fullname', 'like', "%$search%")
                  ->orWhere('phone_number', 'like', "%$search%")
                  ->orWhere('address', 'like', "%$search%")
                  ->orWhere('created_at', 'like', "%$search%");
            });
        }

        $total = $query->count();
        $items = $query->orderBy($orderByColumn, $orderDirection)
                       ->skip($request->start)
                       ->take($request->length)
                       ->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => Customer::count(),
            'recordsFiltered' => $total,
            'data' => $items,
        ]);
    }

    public function store(Request $request)
    {
        $rules=[
            'fullname' => 'required|string',
            'phone_number' => 'required|string|unique:customers,phone_number',
            'address' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        // Create a new Customer
        $object = new Customer();
        $object->fullname = $request->fullname;
        $object->phone_number = $request->phone_number;
        $object->address = $request->address;
        /*Save to the database table*/
        $object->save();


        return response()->json([
            'success' => true,
            'message' => 'Customer added successfully!'
        ]);
    }


    public function delete(Request $request)
    {
        $object = Customer::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Customer not found.'], 404);
        }
        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' =>true, 'message'=> 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Customer::find($id);
        return view('Backend.Pages.Customer.Update', compact('data'));
    }
    public function view($id) {
        $total_invoice=Customer_Invoice::where('customer_id',$id)->count();
        $total_paid_amount=Customer_Invoice::where('customer_id',$id)->sum('paid_amount');
        $total_due_amount=Customer_Invoice::where('customer_id',$id)->sum('due_amount');
        $invoices = Customer_Invoice::where('customer_id', $id)->get();
        $data = Customer::find($id);
        $customer_transaction_history=Customer_Transaction_History::where('customer_id',$id)->get();
        return view('Backend.Pages.Customer.Profile',compact('data','total_invoice','total_paid_amount','total_due_amount','invoices','customer_transaction_history'));
    }

    public function update(Request $request, $id)
    {
        /*Validate the form data*/
        $rules=[
            'fullname' => 'required|string',
            'phone_number' => 'required|string|unique:customers,phone_number,' . $id,
            'address' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        /* Find the Customer*/

        $object = Customer::findOrFail($id);
        $object->fullname = $request->fullname;
        $object->phone_number = $request->phone_number;
        $object->address = $request->address;
        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'Customer Update successfully!'
        ]);
    }
}

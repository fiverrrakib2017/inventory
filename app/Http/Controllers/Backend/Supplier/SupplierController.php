<?php

namespace App\Http\Controllers\Backend\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Supplier_Invoice;
use App\Models\Supplier_Transaction_History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        return view('Backend.Pages.Supplier.index');
    }
    public function create()
    {
        return view('Backend.Pages.Supplier.Create');
    }
    public function get_all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy =  ['id', 'fullname', 'phone_number', 'address', 'created_at'];
        $orderByColumn = $columnsForOrderBy[$request->order[0]['column']] ?? 'id';
        $orderDirection = $request->order[0]['dir']?? 'asc';
        $user = auth('admin')->user();
        if($user->user_type != 1){
            $query = Supplier::with('user')->where('user_id', $user->id);
        }else{
            $query = Supplier::query()->with('user');
        }

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
            'recordsTotal' => Supplier::count(),
            'recordsFiltered' => $total,
            'data' => $items,
        ]);
    }
    public function store(Request $request)
    {
        /* Validate the form data*/
        $rules=[
            'fullname' => 'required|string',
            'phone_number' => 'required|string|unique:suppliers,phone_number',
            'address' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        /* Create a new Supplier*/
        $object = new Supplier();
        $object->user_id=auth('admin')->user()->id;
        $object->fullname = $request->fullname;
        $object->phone_number = $request->phone_number;
        $object->address = $request->address;
        /*Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Supplier added successfully'
        ]);
    }


    public function delete(Request $request)
    {
        $object = Supplier::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Supplier not found.'], 404);
        }

        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' =>true, 'message'=> 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Supplier::find($id);
        return view('Backend.Pages.Supplier.Update', compact('data'));
    }
    public function view($id) {
        $total_invoice=Supplier_Invoice::where('supplier_id',$id)->count();
        $total_paid_amount=Supplier_Invoice::where('supplier_id',$id)->sum('paid_amount');
        $total_due_amount=Supplier_Invoice::where('supplier_id',$id)->sum('due_amount');
        $invoices = Supplier_Invoice::where('supplier_id', $id)->get();
        $data = Supplier::find($id);
        $supplier_transaction_history=Supplier_Transaction_History::where('supplier_id',$id)->get();
        return view('Backend.Pages.Supplier.Profile',compact('data','total_invoice','total_paid_amount','total_due_amount','invoices','supplier_transaction_history'));
    }

    public function update(Request $request, $id)
    {
        /* Validate the form data*/
        $rules=[
            'fullname' => 'required|string',
            'phone_number' => 'required|string|unique:suppliers,phone_number,' . $id,
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
        $object = Supplier::findOrFail($id);
        $object->fullname = $request->fullname;
        $object->phone_number = $request->phone_number;
        $object->address = $request->address;
        /*Save to the database table*/
        $object->update();
        return response()->json([
            'success' => true,
            'message' => 'Supplier Update successfully'
        ]);
    }
}

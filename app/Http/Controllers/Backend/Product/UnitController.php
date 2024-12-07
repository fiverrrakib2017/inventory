<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function index()
    {
        return view('Backend.Pages.Product.Unit.index');
    }
    public function get_all_data(Request $request)
    {
        $user = auth('admin')->user();
        $search = $request->search['value'] ?? '';
        $columnsForOrderBy = ['id', 'unit_name', 'status', 'created_at'];
        $orderByColumnIndex = $request->order[0]['column'] ?? 0;
        $orderByColumn = $columnsForOrderBy[$orderByColumnIndex] ?? 'id';
        $orderDirection = $request->order[0]['dir'] ?? 'asc';

        $query = Unit::query();

        if ($user->user_type != 1) {
            $query->where('user_id', $user->id);
        }

        if (!empty($search)) {
            $query->where('unit_name', 'like', "%$search%");
        }
        $totalRecords = $query->count();
        $units = $query->orderBy($orderByColumn, $orderDirection)
                        ->skip($request->start)
                        ->take($request->length)
                        ->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => Unit::count(),
            'recordsFiltered' => $totalRecords,
            'data' => $units,
        ]);
    }
    public function store(Request $request)
    {
        /*Validate the form data*/
        $this->validateForm($request);

        $object = new Unit();
        $object->user_id=auth('admin')->user()->id;
        $object->unit_name = $request->name;

        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!'
        ]);
    }


    public function delete(Request $request)
    {
        $object = Unit::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Unit not found.'], 404);
        }
        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' =>true, 'message'=> 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Unit::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Unit not found.']);
        }
    }


    public function update(Request $request, $id)
    {

        $this->validateForm($request);

        $object = Unit::findOrFail($id);
        $object->unit_name = $request->name;
        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'Update successfully!'
        ]);
    }
    private function validateForm($request)
    {

        /*Validate the form data*/
        $rules=[
            'unit_name' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    }
}

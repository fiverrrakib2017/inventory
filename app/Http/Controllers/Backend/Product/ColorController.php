<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index(){
        return view('Backend.Pages.Product.Color.index');
     }
     public function get_all_data(Request $request){
        $user = auth('admin')->user();
        $search = $request->search['value'] ?? '';
        $columnsForOrderBy = ['id', 'name', 'status', 'created_at'];
        $orderByColumnIndex = $request->order[0]['column'] ?? 0;
        $orderByColumn = $columnsForOrderBy[$orderByColumnIndex] ?? 'id';
        $orderDirection = $request->order[0]['dir'] ?? 'asc';

        $query = Color::query();

        if ($user->user_type != 1) {
            $query->where('user_id', $user->id);
        }

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }
        $totalRecords = $query->count();
        $colors = $query->orderBy($orderByColumn, $orderDirection)
                        ->skip($request->start)
                        ->take($request->length)
                        ->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => Color::count(),
            'recordsFiltered' => $totalRecords,
            'data' => $colors,
        ]);
     }
     public function store(Request $request){
         $request->validate([
             'name' => 'required|string|max:255',
             'status' => 'required|in:0,1',
         ]);

         // Create a new Color instance
         $category = new Color();
         $category->user_id=auth('admin')->user()->id;
         $category->name = $request->name;
         $category->status = $request->status;
         $category->save();

         return response()->json(['success' =>true, 'message'=> 'Added Successfully']);
     }
     public function edit($id){
         $data = Color::find($id);

         return response()->json(['success'=>true,'data' => $data]);
     }
     public function delete(Request $request){
         $data = Color::find($request->id);

         if (!$data) {
             return response()->json(['error' => 'not found']);
         }
         // Delete the data
         $data->delete();

         return response()->json(['success' =>true, 'message'=> 'Deleted successfully']);
     }
     public function update(Request $request){
         $request->validate([
             'name' => 'required|string|max:255',
             'status' => 'required|in:0,1',
         ]);

         // Create a new  instance
         $category =Color::find($request->id);
         $category->name = $request->name;
         $category->status = $request->status;
         $category->update();

         return response()->json(['success' =>true, 'message'=> 'Update successfully']);
     }
}

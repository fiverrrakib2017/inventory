<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\Product_barcode;
use App\Models\Product_Brand;
use App\Models\Product_Category;
use App\Models\Product_child_category;
use App\Models\Product_image;
use App\Models\Product_sub_category;
use App\Models\Seller;
use App\Models\Size;
use App\Models\Temp_Image;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
class ProductController extends Controller
{
    public function index(){
        $user= auth('admin')->user();
        $query = Product::query();
        if ($user->user_type != 1) {
            $query->where('user_id', $user->id);
        }

        $product = $query->latest()->get();
        return view('Backend.Pages.Product.index',compact('product'));
    }
    public function get_product($id){
        return Product::with('product_image')->where(['id'=>$id])->latest()->get();
    }
    public function create(){
        $category=Product_Category::where('status',1)->latest()->get();
        $brand=Product_Brand::where('status',1)->latest()->get();
        $color=Color::where('status',1)->latest()->get();
        $size=Size::where('status',1)->latest()->get();
        $units=Unit::latest()->get();
        return view('Backend.Pages.Product.Create',compact('category','brand','color','size','units'));
    }
    public function view($id){
        $product=Product::with('product_image','brand','category')->find($id);
        return view('Backend.Pages.Product.View',compact('product'));
    }
    public function store(Request $request){
        //return $request->all();
        // Validate request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'brand_id' => 'required|exists:product__brands,id',
            'category_id' => 'required|exists:product__categories,id',
            'unit_id' => 'required|exists:units,id',
            'p_price' => 'required|numeric|min:0',
            's_price' => 'required|numeric|min:0',
            'product_type' => 'required|string',
            'qty' => 'nullable|integer|min:0',
            'color' => 'nullable|array',
            'size' => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


            $product = new Product();
            $product->user_id = auth('admin')->user()->id;
            $product->title = $request->title;
            $product->brand_id = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->unit_id = $request->unit_id;
            $product->warenty = $request->warenty;
            $product->p_price = $request->p_price;
            $product->s_price = $request->s_price;
            $product->product_type = $request->input('product_type');
            $product->track_qty = $request->input('track_qty', 'Yes');
            $product->qty = $request->qty;
            $product->status = 1;
            $product->color =$request->color ? implode(',', $request->color) : null;
            $product->size =$request->size ? implode(',', $request->size) : null;
            $product->save();
            return response()->json([
                'success' => true,
                'message' => 'Product added succesfully'
            ]);
    }
    public function product_update(Request $request){

        $product= Product::find($request->id);
        if (empty($product)) {
            return response()->json(['success'=>false,'message'=>'Product Not Found']);
        }
        $validator = Validator::make($request->all(), $this->validate_ruls());
        if($validator->passes()){
            $product->title = $request->title;
            $product->brand_id = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->unit_id = $request->unit_id;
            $product->warenty = $request->warenty;
            $product->p_price = $request->p_price;
            $product->s_price = $request->s_price;
            $product->product_type = $request->input('product_type');
            $product->track_qty = $request->input('track_qty', 'Yes');
            $product->qty = $request->qty;
            $product->status = 1;
            $product->color =$request->color ? implode(',', $request->color) : null;
            $product->size =$request->size ? implode(',', $request->size) : null;

             $product->update();


             return response()->json([
                'success' => true,
                'message' => 'Update Succesfully'
             ]);
         }else{
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
         }
    }
    public function delete(Request $request){
        $product=Product::find($request->id);
        if (empty($product)) {
            return redirect()->route('admin.products.index')->with('error','Product not found');
        }
        /* Product Image Find And Delete it From Database table */
        $product_image=Product_image::where(['product_id'=>$request->id])->get();
        if (!empty($product_image)) {
            foreach ($product_image as $productImage) {
                File::delete(public_path('uploads/product/'.$productImage->image));
            }
        }
        /* Now Delete Product Image Name Delete it From Database table */
        Product_image::where(['product_id'=>$request->id])->delete();
        $product->delete();
        return redirect()->route('admin.products.index')->with('success','Delete Success');
    }
    public function edit($id){
        $category=Product_Category::latest()->get();
        $brand=Product_Brand::latest()->get();
        $child_category=Product_child_category::latest()->get();
        $sub_category=Product_sub_category::latest()->get();
        $colors=Color::where('status', 1)->get();
        $sizes=Size::where('status',1)->get();
        $data=Product::find($id);
        $units=Unit::latest()->get();
        return view('Backend.Pages.Product.Update',compact('units','data','category','brand','sub_category','child_category','colors','sizes'));
    }
    public function photo_update(Request $request){
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $tempImageLocation = $image->getPathName();


        $productImage = new Product_image();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'Null';
        $productImage->save();

        $imageName = $request->product_id . '-' . $productImage->id.'-'.time().'.'.$ext;
        $productImage->image = $imageName;
        $productImage->save();
        $image->move(public_path('uploads/product'), $imageName);

        return response()->json([
            'status' => true,
            'image_id' => $productImage->id,
            'imagePath' => asset('uploads/product/' . $productImage->image),
            'message' => 'Image saved successfully'
        ]);
    }
    public function delete_photo(Request $request){
        if ($request->type == "temp_file") {
            $product_image = Temp_Image::find($request->id);
            if (!empty($product_image)) {
                $imagePath = public_path() . '/temp/' . $product_image->name;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $product_image->delete();
                return response()->json(['success' => true, 'message' => 'Delete Successful']);
            }
        } else {
            /* Product Image Find And Delete it From Database table */
            $product_image = Product_image::find($request->id);
            if (!empty($product_image)) {
                $imagePath = public_path() . '/uploads/product/' . $product_image->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                /* Now Delete Product Image Name Delete it From Database table */
                $product_image->delete();
                return response()->json(['success' => true, 'message' => 'Delete Successful']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Image not found']);
    }

    private function validate_ruls(){
            return  [
            'title' => 'required',
            'brand_id'=>'required',
            'category_id'=>'required',
            'slug' => 'nullable',
            'p_price' => 'required|numeric',
            's_price' => 'required|numeric',
            'description' => 'nullable|max:10000',
            'product_type' => 'required',
        ];
    }
}

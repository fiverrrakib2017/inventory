<?php
namespace App\Services;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;

class InvoiceService{
    public function createInvoice($type){
        $data=array();
        $user= auth('admin')->user();
        /*Get Product Query*/
        $query = Product::query();
        if ($user->user_type != 1) {
            $query->where('user_id', $user->id);
        }
        $data['product']= $query->latest()->get();
        $data['products']=Product::with('product_image')->paginate(10);
        if ($type === 'Customer') {
            if($user->user_type != 1){
                $data['customer'] = Customer::where('user_id', $user->id)->latest()->get();
            }
            $data['customer'] = Customer::latest()->get();
            return view('Backend.Pages.Customer.invoice_create')->with($data);
        } elseif ($type === 'Supplier') {
            if($user->user_type != 1){
                $data['supplier'] = Supplier::where('user_id', $user->id)->latest()->get();
            }
            $data['supplier']=Supplier::latest()->get();
            return view('Backend.Pages.Supplier.invoice_create')->with($data);
        }

    }
}

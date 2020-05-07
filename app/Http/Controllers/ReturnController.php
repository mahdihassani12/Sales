<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\CustomerGroup;
use App\Store;
use App\Biller;
use App\Product;
use App\Unit;
use App\Tax;
use App\Product_Store;
use DB;
use App\Returns;
use App\ProductReturn;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;

class ReturnController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('returns-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            $ezpos_return_all = Returns::orderBy('id', 'desc')->get();
            return view('return.index', compact('ezpos_return_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('returns-add')){
            $ezpos_customer_list = Customer::where('is_active',true)->get();
            $ezpos_store_list = Store::where('is_active',true)->get();
            $ezpos_biller_list = Biller::where('is_active',true)->get();
            $ezpos_tax_list = Tax::where('is_active',true)->get();
            return view('return.create', compact('ezpos_customer_list', 'ezpos_store_list', 'ezpos_biller_list', 'ezpos_tax_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function getCustomerGroup($id)
    {
         $ezpos_customer_data = Customer::find($id);
         $ezpos_customer_group_data = CustomerGroup::find($ezpos_customer_data->customer_group_id);
         return $ezpos_customer_group_data->percentage;
    }

    public function getProduct($id)
    {
        $ezpos_product_store_data = Product_Store::where('store_id', $id)->get();
        $product_code = [];
        $product_name = [];
        $product_qty = [];
        $product_data = [];
        foreach ($ezpos_product_store_data as $product_store) 
        {
            $product_qty[] = $product_store->qty;
            $ezpos_product_data = Product::find($product_store->product_id);
            $product_code[] =  $ezpos_product_data->code;
            $product_name[] = $ezpos_product_data->name;
            $product_type[] = $ezpos_product_data->type;
        }
        $ezpos_product_data = Product::whereNotIn('type', ['standard'])
                            ->get();
        foreach ($ezpos_product_data as $product) 
        {
            $product_qty[] = $product->qty;
            $ezpos_product_data = $product->id;
            $product_code[] =  $product->code;
            $product_name[] = $product->name;
            $product_type[] = $product->type;
        }
        $product_data[] = $product_code;
        $product_data[] = $product_name;
        $product_data[] = $product_qty;
        $product_data[] = $product_type;
        return $product_data;
    }

    public function ezposProductSearch(Request $request)
    {
        $todayDate = date('Y-m-d');
        $product_code = explode(" ",$request['data']);
        $ezpos_product_data = Product::where('code', $product_code[0])->first();

        $product[] = $ezpos_product_data->name;
        $product[] = $ezpos_product_data->code;
        if($ezpos_product_data->promotion && $todayDate <= $ezpos_product_data->last_date){
            $product[] = $ezpos_product_data->promotion_price;
        }
        else
            $product[] = $ezpos_product_data->price;
        
        if($ezpos_product_data->tax_id) {
            $ezpos_tax_data = Tax::find($ezpos_product_data->tax_id);
            $product[] = $ezpos_tax_data->rate;
            $product[] = $ezpos_tax_data->name;
        }
        else{
            $product[] = 0;
            $product[] = 'No Tax';
        }
        $product[] = $ezpos_product_data->tax_method;
        $product[] = $ezpos_product_data->unit;
        $product[] = $ezpos_product_data->id;
        return $product;
    }

    public function store(Request $request)
    {
        $data = $request->except('document');
        $data['date'] = date('Y-m-d', strtotime($data['date']));
        $data['reference_no'] = 'rr-' . date("Ymd") . '-'. date("his");
        $data['user_id'] = Auth::id();
        $document = $request->document;
        if ($document) {
            $documentName = $document->getClientOriginalName();
            $document->move('public/return/documents', $documentName);
            $data['document'] = $documentName;
        }

        Returns::create($data);
        $ezpos_return_data = Returns::latest()->first();
        $ezpos_customer_data = Customer::find($data['customer_id']);
        //collecting male data
        $mail_data['email'] = $ezpos_customer_data->email;
        $mail_data['reference_no'] = $ezpos_return_data->reference_no;
        $mail_data['total_qty'] = $ezpos_return_data->total_qty;
        $mail_data['total_price'] = $ezpos_return_data->total_price;
        $mail_data['order_tax'] = $ezpos_return_data->order_tax;
        $mail_data['order_tax_rate'] = $ezpos_return_data->order_tax_rate;
        $mail_data['grand_total'] = $ezpos_return_data->grand_total;

        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $sale_unit = $data['sale_unit'];
        $net_unit_price = $data['net_unit_price'];
        $discount = $data['discount'];
        $tax_rate = $data['tax_rate'];
        $tax = $data['tax'];
        $total = $data['subtotal'];

        foreach ($product_id as $key => $pro_id) {
            $ezpos_product_data = Product::find($pro_id);
            if($ezpos_product_data->type == 'standard'){
                $ezpos_product_store_data = Product_Store::where([
                            ['product_id', $pro_id],
                            ['store_id', $data['store_id'] ],
                            ])->first();

                $ezpos_product_data->qty +=  $qty[$key];
                $ezpos_product_store_data->qty += $qty[$key];

                $ezpos_product_data->save();
                $ezpos_product_store_data->save();
            }

            $mail_data['products'][$key] = $ezpos_product_data->name;
            $mail_data['unit'][$key] = $sale_unit[$key];
            $mail_data['qty'][$key] = $qty[$key];
            $mail_data['total'][$key] = $total[$key];
            ProductReturn::insert(
                ['return_id' => $ezpos_return_data->id, 'product_id' => $pro_id, 'qty' => $qty[$key], 'unit' => $sale_unit[$key], 'net_unit_price' => $net_unit_price[$key], 'discount' => $discount[$key], 'tax_rate' => $tax_rate[$key], 'tax' => $tax[$key], 'total' => $total[$key] ]
            );
        }
       /*       
	   if($mail_data['email']){
            Mail::send( 'mail.return_details', $mail_data, function( $message ) use ($mail_data)
            {
                $message->to( $mail_data['email'] )->subject( 'Return Details' );
            });
        }
		*/
        return redirect('return')->with('message', 'Data inserted successfully');
    }

    public function productReturnData($id)
    {
        $ezpos_product_return_data = ProductReturn::where('return_id', $id)->get();
        foreach ($ezpos_product_return_data as $key => $product_return_data) {
            $product = Product::find($product_return_data->product_id);
            $product_return[0][$key] = $product->name . '-' . $product->code;
            $product_return[1][$key] = $product_return_data->qty;
            $product_return[2][$key] = $product_return_data->unit;
            $product_return[3][$key] = $product_return_data->tax;
            $product_return[4][$key] = $product_return_data->tax_rate;
            $product_return[5][$key] = $product_return_data->discount;
            $product_return[6][$key] = $product_return_data->total;
        }
        return $product_return;
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('returns-edit')){
            $ezpos_customer_list = Customer::where('is_active',true)->get();
            $ezpos_store_list = Store::where('is_active',true)->get();
            $ezpos_biller_list = Biller::where('is_active',true)->get();
            $ezpos_tax_list = Tax::where('is_active',true)->get();
            $ezpos_return_data = Returns::find($id);
            $ezpos_product_return_data = ProductReturn::where('return_id', $id)->get();
            return view('return.edit',compact('ezpos_customer_list', 'ezpos_store_list', 'ezpos_biller_list', 'ezpos_tax_list', 'ezpos_return_data','ezpos_product_return_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('document');
        $data['date'] = date('Y-m-d', strtotime($data['date']));
        $document = $request->document;
        if ($document) {
            $documentName = $document->getClientOriginalName();
            $document->move('public/return/documents', $documentName);
            $data['document'] = $documentName;
        }

        $ezpos_return_data = Returns::find($id);
        $ezpos_product_return_data = ProductReturn::where('return_id', $id)->get();

        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $sale_unit = $data['sale_unit'];
        $net_unit_price = $data['net_unit_price'];
        $discount = $data['discount'];
        $tax_rate = $data['tax_rate'];
        $tax = $data['tax'];
        $total = $data['subtotal'];

        foreach ($ezpos_product_return_data as $key => $product_return_data) {
            $old_product_id[] = $product_return_data->product_id;
            $ezpos_product_data = Product::find($product_return_data->product_id);
            if($ezpos_product_data->type == 'standard'){
                $ezpos_product_store_data = Product_Store::where([
                        ['product_id', $product_return_data->product_id],
                        ['store_id', $ezpos_return_data->store_id],
                        ])->first();

                $ezpos_product_data->qty -= $product_return_data->qty;
                $ezpos_product_store_data->qty -= $product_return_data->qty;
                $ezpos_product_data->save();
                $ezpos_product_store_data->save();
            }
            if( !(in_array($old_product_id[$key], $product_id)) )
                $product_return_data->delete();
        }
        foreach ($product_id as $key => $pro_id) {
            $ezpos_product_data = Product::find($pro_id);
            if($ezpos_product_data->type == 'standard'){
                $ezpos_product_store_data = Product_Store::where([
                            ['product_id', $pro_id],
                            ['store_id', $data['store_id'] ],
                            ])->first();

                $ezpos_product_data->qty +=  $qty[$key];
                $ezpos_product_store_data->qty += $qty[$key];

                $ezpos_product_data->save();
                $ezpos_product_store_data->save();
            }

            $mail_data['products'][$key] = $ezpos_product_data->name;
            $mail_data['unit'][$key] = $sale_unit[$key];
            $mail_data['qty'][$key] = $qty[$key];
            $mail_data['total'][$key] = $total[$key];

            $product_return['return_id'] = $id ;
            $product_return['product_id'] = $pro_id;
            $product_return['qty'] = $qty[$key];
            $product_return['unit'] = $sale_unit[$key];
            $product_return['net_unit_price'] = $net_unit_price[$key];
            $product_return['discount'] = $discount[$key];
            $product_return['tax_rate'] = $tax_rate[$key];
            $product_return['tax'] = $tax[$key];
            $product_return['total'] = $total[$key];

            if((in_array($pro_id, $old_product_id))){
                ProductReturn::where([
                    ['return_id', $id],
                    ['product_id', $pro_id]
                    ])->update($product_return);
            }
            else
                ProductReturn::create($product_return);
        }
        $ezpos_return_data->update($data);
        $ezpos_customer_data = Customer::find($data['customer_id']);
        //collecting male data
        $mail_data['email'] = $ezpos_customer_data->email;
        $mail_data['reference_no'] = $ezpos_return_data->reference_no;
        $mail_data['total_qty'] = $ezpos_return_data->total_qty;
        $mail_data['total_price'] = $ezpos_return_data->total_price;
        $mail_data['order_tax'] = $ezpos_return_data->order_tax;
        $mail_data['order_tax_rate'] = $ezpos_return_data->order_tax_rate;
        $mail_data['grand_total'] = $ezpos_return_data->grand_total;
        /*
		if($mail_data['email']){
            Mail::send( 'mail.return_details', $mail_data, function( $message ) use ($mail_data)
            {
                $message->to( $mail_data['email'] )->subject( 'Return Details' );
            });
        }
		*/
        return redirect('return')->with('message', 'Data updated successfully');;
    }

    public function destroy($id)
    {
        $ezpos_return_data = Returns::find($id);
        $ezpos_product_return_data = ProductReturn::where('return_id', $id)->get();

        foreach ($ezpos_product_return_data as $key => $product_return_data) {
            $ezpos_product_data = Product::find($product_return_data->product_id);
            if($ezpos_product_data->type == 'standard'){
                $ezpos_product_store_data = Product_Store::where([
                        ['product_id', $product_return_data->product_id],
                        ['store_id', $ezpos_return_data->store_id],
                        ])->first();

                $ezpos_product_data->qty -= $product_return_data->qty;
                $ezpos_product_store_data->qty -= $product_return_data->qty;
                $ezpos_product_data->save();
                $ezpos_product_store_data->save();
                $product_return_data->delete();
            }
        }
        $ezpos_return_data->delete();
        return redirect('return')->with('not_permitted', 'Data deleted successfully');;
    }
}

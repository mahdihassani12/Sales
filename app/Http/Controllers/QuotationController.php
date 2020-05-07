<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Customer;
use App\CustomerGroup;
use App\Supplier;
use App\Warehouse;
use App\Biller;
use App\Product;
use App\Unit;
use App\Tax;
use App\Quotation;
use App\Delivery;
use App\PosSetting;
use App\ProductQuotation;
use App\Product_Warehouse;
use DB;

use NumberToWords\NumberToWords;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;

class QuotationController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('quotes-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            $ezpos_quotation_all = Quotation::orderBy('id', 'desc')->get();
            return view('quotation.index', compact('ezpos_quotation_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('quotes-add')){
            $ezpos_biller_list = Biller::where('is_active', true)->get();
            $ezpos_warehouse_list = Warehouse::where('is_active', true)->get();
            $ezpos_customer_list = Customer::where('is_active', true)->get();
            $ezpos_supplier_list = Supplier::where('is_active', true)->get();
            $ezpos_tax_list = Tax::where('is_active', true)->get();

            return view('quotation.create', compact('ezpos_biller_list', 'ezpos_warehouse_list', 'ezpos_customer_list', 'ezpos_supplier_list', 'ezpos_tax_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $data = $request->except('document');
        $data['user_id'] = Auth::id();
        $document = $request->document;
        if($document){
            $documentName = $document->getClientOriginalName();
            $document->move('public/quotation/documents', $documentName);
            $data['document'] = $documentName;
        }
        $data['reference_no'] = 'qr-' . date("Ymd") . '-'. date("his");
        Quotation::create($data);
        $ezpos_quotation_data = Quotation::latest()->first();
        if($ezpos_quotation_data->quotation_status == 2){
            //collecting mail data
            $ezpos_customer_data = Customer::find($data['customer_id']);
            $mail_data['email'] = $ezpos_customer_data->email;
            $mail_data['reference_no'] = $ezpos_quotation_data->reference_no;
            $mail_data['total_qty'] = $ezpos_quotation_data->total_qty;
            $mail_data['total_price'] = $ezpos_quotation_data->total_price;
            $mail_data['order_tax'] = $ezpos_quotation_data->order_tax;
            $mail_data['order_tax_rate'] = $ezpos_quotation_data->order_tax_rate;
            $mail_data['order_discount'] = $ezpos_quotation_data->order_discount;
            $mail_data['shipping_cost'] = $ezpos_quotation_data->shipping_cost;
            $mail_data['grand_total'] = $ezpos_quotation_data->grand_total;
        }
        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $sale_unit = $data['sale_unit'];
        $net_unit_price = $data['net_unit_price'];
        $discount = $data['discount'];
        $tax_rate = $data['tax_rate'];
        $tax = $data['tax'];
        $total = $data['subtotal'];
        $product_quotation = [];
        $i=0;

        foreach ($product_id as $id) {
            if($sale_unit[$i] != 'n/a'){
                $ezpos_sale_unit_data = Unit::where('unit_name', $sale_unit[$i])->first();
                $sale_unit_id = $ezpos_sale_unit_data->id;
            }
            else
                $sale_unit_id = 0;
            if($sale_unit_id)
                $mail_data['unit'][$i] = $ezpos_sale_unit_data->unit_code;
            else
                $mail_data['unit'][$i] = '';
            $ezpos_product_data = Product::find($id);
            $mail_data['products'][$i] = $ezpos_product_data->name;
            $product_quotation['quotation_id'] = $ezpos_quotation_data->id ;
            $product_quotation['product_id'] = $id;
            $product_quotation['qty'] = $mail_data['qty'][$i] = $qty[$i];
            $product_quotation['sale_unit_id'] = $sale_unit_id;
            $product_quotation['net_unit_price'] = $net_unit_price[$i];
            $product_quotation['discount'] = $discount[$i];
            $product_quotation['tax_rate'] = $tax_rate[$i];
            $product_quotation['tax'] = $tax[$i];
            $product_quotation['total'] = $mail_data['total'][$i] = $total[$i];
            ProductQuotation::create($product_quotation);
            $i++;
        }
       /* if($ezpos_quotation_data->quotation_status == 2 && $mail_data['email']){
            Mail::send( 'mail.quotation_details', $mail_data, function( $message ) use ($mail_data)
            {
                $message->to( $mail_data['email'] )->subject( 'Quotation Details' );
            });
        }
		*/
        return redirect('quotations')->with('message', 'Quotation created successfully');
    }

    public function getCustomerGroup($id)
    {
         $ezpos_customer_data = Customer::find($id);
         $ezpos_customer_group_data = CustomerGroup::find($ezpos_customer_data->customer_group_id);
         return $ezpos_customer_group_data->percentage;
    }

    public function getProduct($id)
    {
        $ezpos_product_warehouse_data = Product_Warehouse::where('warehouse_id', $id)->get();
        $product_code = [];
        $product_name = [];
        $product_qty = [];
        $product_data = [];
        foreach ($ezpos_product_warehouse_data as $product_warehouse) 
        {
            $product_qty[] = $product_warehouse->qty;
            $ezpos_product_data = Product::find($product_warehouse->product_id);
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
        if($ezpos_product_data->type == 'standard'){
            $units = Unit::where("base_unit", $ezpos_product_data->unit_id)
                        ->orWhere('id', $ezpos_product_data->unit_id)
                        ->get();
            $unit_name = array();
            $unit_operator = array();
            $unit_operation_value = array();
            foreach ($units as $unit) {
                if($ezpos_product_data->sale_unit_id == $unit->id) {
                    array_unshift($unit_name, $unit->unit_name);
                    array_unshift($unit_operator, $unit->operator);
                    array_unshift($unit_operation_value, $unit->operation_value);
                }
                else {
                    $unit_name[]  = $unit->unit_name;
                    $unit_operator[] = $unit->operator;
                    $unit_operation_value[] = $unit->operation_value;
                }
            }
            
            $product[] = implode(",",$unit_name) . ',';
            $product[] = implode(",",$unit_operator) . ',';
            $product[] = implode(",",$unit_operation_value) . ',';
        }
        else{
            $product[] = 'n/a'. ',';
            $product[] = 'n/a'. ',';
            $product[] = 'n/a'. ',';
        }
        $product[] = $ezpos_product_data->id;
        return $product;
    }

    public function productQuotationData($id)
    {
        $ezpos_product_quotation_data = ProductQuotation::where('quotation_id', $id)->get();
        foreach ($ezpos_product_quotation_data as $key => $product_quotation_data) {
            $product = Product::find($product_quotation_data->product_id);
            if($product_quotation_data->sale_unit_id){
                $unit_data = Unit::find($product_quotation_data->sale_unit_id);
                $unit = $unit_data->unit_code;
            }
            else
                $unit = '';

            $product_quotation[0][$key] = $product->name . '-' . $product->code;
            $product_quotation[1][$key] = $product_quotation_data->qty;
            $product_quotation[2][$key] = $unit;
            $product_quotation[3][$key] = $product_quotation_data->tax;
            $product_quotation[4][$key] = $product_quotation_data->tax_rate;
            $product_quotation[5][$key] = $product_quotation_data->discount;
            $product_quotation[6][$key] = $product_quotation_data->total;
        }
        return $product_quotation;
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('quotes-edit')){
            $ezpos_customer_list = Customer::where('is_active', true)->get();
            $ezpos_warehouse_list = Warehouse::where('is_active', true)->get();
            $ezpos_biller_list = Biller::where('is_active', true)->get();
            $ezpos_supplier_list = Supplier::where('is_active', true)->get();
            $ezpos_tax_list = Tax::where('is_active', true)->get();
            $ezpos_quotation_data = Quotation::find($id);
            $ezpos_product_quotation_data = ProductQuotation::where('quotation_id', $id)->get();
            return view('quotation.edit',compact('ezpos_customer_list', 'ezpos_warehouse_list', 'ezpos_biller_list', 'ezpos_product_list', 'ezpos_tax_list', 'ezpos_quotation_data','ezpos_product_quotation_data', 'ezpos_supplier_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('document');
        $document = $request->document;
        if($document){
            $documentName = $document->getClientOriginalName();
            $document->move('public/quotation/documents', $documentName);
            $data['document'] = $documentName;
        }
        $ezpos_quotation_data = Quotation::find($id);
        $ezpos_product_quotation_data = ProductQuotation::where('quotation_id', $id)->get();
        //update quotation table
        $ezpos_quotation_data->update($data);
        if($ezpos_quotation_data->quotation_status == 2){
            //collecting mail data
            $ezpos_customer_data = Customer::find($data['customer_id']);
            $mail_data['email'] = $ezpos_customer_data->email;
            $mail_data['reference_no'] = $ezpos_quotation_data->reference_no;
            $mail_data['total_qty'] = $data['total_qty'];
            $mail_data['total_price'] = $data['total_price'];
            $mail_data['order_tax'] = $data['order_tax'];
            $mail_data['order_tax_rate'] = $data['order_tax_rate'];
            $mail_data['order_discount'] = $data['order_discount'];
            $mail_data['shipping_cost'] = $data['shipping_cost'];
            $mail_data['grand_total'] = $data['grand_total'];
        }
        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $sale_unit = $data['sale_unit'];
        $net_unit_price = $data['net_unit_price'];
        $discount = $data['discount'];
        $tax_rate = $data['tax_rate'];
        $tax = $data['tax'];
        $total = $data['subtotal'];
        $i = 0;

        foreach ($product_id as $pro_id) {
            if($sale_unit[$i] != 'n/a'){
                $ezpos_sale_unit_data = Unit::where('unit_name', $sale_unit[$i])->first();
                $sale_unit_id = $ezpos_sale_unit_data->id;
            }
            else
                $sale_unit_id = 0;
            $ezpos_product_data = Product::find($pro_id);
            $mail_data['products'][$i] = $ezpos_product_data->name;
            if($sale_unit_id)
                $mail_data['unit'][$i] = $ezpos_sale_unit_data->unit_code;
            else
                $mail_data['unit'][$i] = '';
            $input['quotation_id'] = $id;
            $input['product_id'] = $pro_id;
            $input['qty'] = $mail_data['qty'][$i] = $qty[$i];
            $input['sale_unit_id'] = $sale_unit_id;
            $input['net_unit_price'] = $net_unit_price[$i];
            $input['discount'] = $discount[$i];
            $input['tax_rate'] = $tax_rate[$i];
            $input['tax'] = $tax[$i];
            $input['total'] = $mail_data['total'][$i] = $total[$i];
            $flag = 1;
            foreach ($ezpos_product_quotation_data as $product_quotation) {
                if($product_quotation->product_id == $pro_id){
                    $product_quotation->update($input);
                    $flag = 0;
                    break;
                }
            }
            if($flag)
                ProductQuotation::create($input);
            $i++;
        }

        foreach ($ezpos_product_quotation_data as $product_quotation){
            $flag = 1;
            foreach ($product_id as $pro_id) {
                if($product_quotation->product_id == $pro_id)
                    $flag = 0;
            }
            if($flag)
                $product_quotation->delete();
        }
		/*
        if($ezpos_quotation_data->quotation_status == 2 && $mail_data['email']){
            Mail::send( 'mail.quotation_details', $mail_data, function( $message ) use ($mail_data)
            {
                $message->to( $mail_data['email'] )->subject( 'Quotation Details' );
            });
        }
		*/
        return redirect('quotations')->with('message', 'Quotation updated successfully');
    }

    public function createSale($id)
    {
        $ezpos_customer_list = Customer::where('is_active', true)->get();
        $ezpos_warehouse_list = Warehouse::where('is_active', true)->get();
        $ezpos_biller_list = Biller::where('is_active', true)->get();
        $ezpos_tax_list = Tax::where('is_active', true)->get();
        $ezpos_quotation_data = Quotation::find($id);
        $ezpos_product_quotation_data = ProductQuotation::where('quotation_id', $id)->get();
        return view('quotation.create_sale',compact('ezpos_customer_list', 'ezpos_warehouse_list', 'ezpos_biller_list', 'ezpos_tax_list', 'ezpos_quotation_data','ezpos_product_quotation_data'));
    }

    public function createPurchase($id)
    {
        $ezpos_product_list = Product::where([
                                    ['is_active', true],
                                    ['type', 'standard']
                                ])->get();
        $ezpos_supplier_list = Supplier::where('is_active', true)->get();
        $ezpos_warehouse_list = Warehouse::where('is_active', true)->get();
        $ezpos_tax_list = Tax::where('is_active', true)->get();
        $ezpos_quotation_data = Quotation::find($id);
        $ezpos_product_quotation_data = ProductQuotation::where('quotation_id', $id)->get();
        return view('quotation.create_purchase',compact('ezpos_product_list', 'ezpos_supplier_list', 'ezpos_warehouse_list', 'ezpos_tax_list', 'ezpos_quotation_data','ezpos_product_quotation_data'));
    }

    public function destroy($id)
    {
        $ezpos_quotation_data = Quotation::find($id);
        $ezpos_product_quotation_data = ProductQuotation::where('quotation_id', $id)->get();
        foreach ($ezpos_product_quotation_data as $product_quotation_data) {
            $product_quotation_data->delete();
        }
        $ezpos_quotation_data->delete();
        return redirect('quotations')->with('not_permitted', 'Quotation deleted successfully');
    }
}

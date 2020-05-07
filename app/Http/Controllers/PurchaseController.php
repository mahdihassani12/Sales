<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Supplier;
use App\Product;
use App\Tax;
use App\Purchase;
use App\ProductPurchase;
use App\PosSetting;
use App\Product_Store;
use App\Payment;
use App\PaymentWithCheque;
use App\PaymentWithCreditCard;
use DB;
use Stripe\Stripe;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PurchaseController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('purchases-index')){
            $ezpos_purchase_list = Purchase::orderBy('id', 'desc')->get();
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            $ezpos_pos_setting_data = PosSetting::latest()->first();

            return view('purchase.index', compact('ezpos_purchase_list', 'all_permission', 'ezpos_pos_setting_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('purchases-add')){
            $ezpos_supplier_list = Supplier::where('is_active', true)->get();
            $ezpos_store_list = Store::where('is_active', true)->get();
            $ezpos_tax_list = Tax::where('is_active', true)->get();
            $ezpos_product_list = Product::where([
                                    ['is_active', true],
                                    ['type', 'standard']
                                ])->get();
            
            return view('purchase.create', compact('ezpos_supplier_list', 'ezpos_store_list', 'ezpos_tax_list', 'ezpos_product_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function ezposProductSearch(Request $request)
    {
        $product_code = explode(" ", $request['data']);
        $ezpos_product_data = Product::where('code', $product_code[0])->first();

        $product[] = $ezpos_product_data->name;
        $product[] = $ezpos_product_data->code;
        $product[] = $ezpos_product_data->cost;
        
        if ($ezpos_product_data->tax_id) {
            $ezpos_tax_data = Tax::find($ezpos_product_data->tax_id);
            $product[] = $ezpos_tax_data->rate;
            $product[] = $ezpos_tax_data->name;
        } else {
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
        //return $data;
        $data['date'] = date('Y-m-d', strtotime($data['date']));
        $data['user_id'] = Auth::id();
        $data['reference_no'] = 'pr-' . date("Ymd") . '-'. date("his");
        $document = $request->document;
        if ($document) {
            $documentName = $document->getClientOriginalName();
            $document->move('public/documents/purchase', $documentName);
            $data['document'] = $documentName;
        }
        Purchase::create($data);

        $ezpos_purchase_data = Purchase::latest()->first();
        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $recieved = $data['recieved'];
        $purchase_unit = $data['purchase_unit'];
        $net_unit_cost = $data['net_unit_cost'];
        $discount = $data['discount'];
        $tax_rate = $data['tax_rate'];
        $tax = $data['tax'];
        $total = $data['subtotal'];
        $product_purchase = [];
        $i=0;

        foreach ($product_id as $id) {
            //add quantity to product table
            $ezpos_product_data = Product::find($id);
            $ezpos_product_data->qty = $ezpos_product_data->qty + $recieved[$i];
            $ezpos_product_data->save();
            //add quantity to store
            $ezpos_product_store_data = Product_Store::where([
                ['product_id', $id],
                ['store_id', $data['store_id'] ],
                ])->first();
            if ($ezpos_product_store_data) {
                $ezpos_product_store_data->qty = $ezpos_product_store_data->qty + $recieved[$i];
            } else {
                $ezpos_product_store_data = new Product_Store();
                $ezpos_product_store_data->product_id = $id;
                $ezpos_product_store_data->store_id = $data['store_id'];
                $ezpos_product_store_data->qty = $recieved[$i];
            }

            $ezpos_product_store_data->save();

            $product_purchase['purchase_id'] = $ezpos_purchase_data->id ;
            $product_purchase['product_id'] = $id;
            $product_purchase['qty'] = $qty[$i];
            $product_purchase['recieved'] = $recieved[$i];
            $product_purchase['unit'] = $purchase_unit[$i];
            $product_purchase['net_unit_cost'] = $net_unit_cost[$i];
            $product_purchase['discount'] = $discount[$i];
            $product_purchase['tax_rate'] = $tax_rate[$i];
            $product_purchase['tax'] = $tax[$i];
            $product_purchase['total'] = $total[$i];
            ProductPurchase::create($product_purchase);
			
			$total_in=DB::table('item_movement')->where('product_id',$id)->where('store_id',$data['store_id'])->get()->sum('qty_in');
			$total_out=DB::table('item_movement')->where('product_id',$id)->where('store_id',$data['store_id'])->get()->sum('qty_out');
			
			$category=DB::table('products')->where('id',$id)->get()[0]->category_id;
			$new_balance=$total_in-$total_out;
			
			if(!$document){
				$data['document']="";
			}
			$move_item['date']=date('Y-m-d');
			$move_item['time']=date('h:i:s');
			$move_item['user']=Auth::id();
			$move_item['product_id']=$id;
			$move_item['category_id']=$category;
			$move_item['store_id']=$data['store_id'];
			$move_item['qty_in']=$qty[$i];
			$move_item['qty_out']=0;
			$move_item['balance']=$new_balance+$qty[$i];
			$move_item['type_invoice']="purchase";
			$move_item['description']=$data['note'];
			$move_item['reference']=$data['reference_no'];
			$move_item['attach']=$data['document'];
			$move_item['col1']='';
			$move_item['col2']='';
			$move_item['col3']='';
			DB::table('item_movement')->insert($move_item);
			
            $i++;
        }

        return redirect('purchase')->with('message', 'Purchase created successfully');
    }

    public function productPurchaseData($id)
    {
        $ezpos_product_purchase_data = ProductPurchase::where('purchase_id', $id)->get();
        foreach ($ezpos_product_purchase_data as $key => $product_purchase_data) {
            $product = Product::find($product_purchase_data->product_id);
            $product_purchase[0][$key] = $product->name . '-' . $product->code;
            $product_purchase[1][$key] = $product_purchase_data->qty;
            $product_purchase[2][$key] = $product_purchase_data->unit;
            $product_purchase[3][$key] = $product_purchase_data->tax;
            $product_purchase[4][$key] = $product_purchase_data->tax_rate;
            $product_purchase[5][$key] = $product_purchase_data->discount;
            $product_purchase[6][$key] = $product_purchase_data->total;
        }
        return $product_purchase;
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('purchases-edit')){
            $ezpos_supplier_list = Supplier::where('is_active', true)->get();
            $ezpos_store_list = Store::where('is_active', true)->get();
            $ezpos_tax_list = Tax::where('is_active', true)->get();
            $ezpos_product_list = Product::where([
                                    ['is_active', true],
                                    ['type', 'standard']
                                ])->get();
            $ezpos_purchase_data = Purchase::find($id);
            $ezpos_product_purchase_data = ProductPurchase::where('purchase_id', $id)->get();

            return view('purchase.edit', compact('ezpos_store_list', 'ezpos_supplier_list', 'ezpos_product_list', 'ezpos_tax_list', 'ezpos_purchase_data', 'ezpos_product_purchase_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('document');
        //return $data;
        $data['date'] = date('Y-m-d', strtotime($data['date']));
        $document = $request->document;
        if ($document) {
            $documentName = $document->getClientOriginalName();
            $document->move('public/purchase/documents', $documentName);
            $data['document'] = $documentName;
        }
        $balance = $data['grand_total'] - $data['paid_amount'];
        if ($balance < 0 || $balance > 0) {
            $data['payment_status'] = 1;
        } else {
            $data['payment_status'] = 2;
        }
        $ezpos_purchase_data = Purchase::find($id);
        
        $ezpos_product_purchase_data = ProductPurchase::where('purchase_id', $id)->get();

        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $recieved = $data['recieved'];
        $purchase_unit = $data['purchase_unit'];
        $net_unit_cost = $data['net_unit_cost'];
        $discount = $data['discount'];
        $tax_rate = $data['tax_rate'];
        $tax = $data['tax'];
        $total = $data['subtotal'];
        $product_purchase = [];

        foreach ($ezpos_product_purchase_data as $product_purchase_data) {

            $ezpos_product_data = Product::find($product_purchase_data->product_id);
            $ezpos_product_store_data = Product_Store::where([
                    ['product_id', $product_purchase_data->product_id],
                    ['store_id', $ezpos_purchase_data->store_id],
                    ])->first();

            $ezpos_product_data->qty -= $product_purchase_data->recieved;
            if($ezpos_product_store_data){
                $ezpos_product_store_data->qty -= $product_purchase_data->recieved;
                $ezpos_product_store_data->save();
            }
            $ezpos_product_data->save();
            $product_purchase_data->delete();
        }

        foreach ($product_id as $key => $pro_id) {

            $ezpos_product_data = Product::find($pro_id);
            $ezpos_product_store_data = Product_Store::where([
                ['product_id', $pro_id],
                ['store_id', $data['store_id']],
                ])->first();

            $ezpos_product_data->qty += $recieved[$key];
            if($ezpos_product_store_data){
                $ezpos_product_store_data->qty += $recieved[$key];
                $ezpos_product_store_data->save();
            }
            else {
                $ezpos_product_store_data = new Product_Store();
                $ezpos_product_store_data->product_id = $pro_id;
                $ezpos_product_store_data->store_id = $data['store_id'];
                $ezpos_product_store_data->qty = $recieved[$key];
                $ezpos_product_store_data->save();
            }
            $ezpos_product_data->save();

            $product_purchase['purchase_id'] = $id ;
            $product_purchase['product_id'] = $pro_id;
            $product_purchase['qty'] = $qty[$key];
            $product_purchase['recieved'] = $recieved[$key];
            $product_purchase['unit'] = $purchase_unit[$key];
            $product_purchase['net_unit_cost'] = $net_unit_cost[$key];
            $product_purchase['discount'] = $discount[$key];
            $product_purchase['tax_rate'] = $tax_rate[$key];
            $product_purchase['tax'] = $tax[$key];
            $product_purchase['total'] = $total[$key];
            ProductPurchase::create($product_purchase);
        }

        $ezpos_purchase_data->update($data);
        return redirect('purchase')->with('message', 'Purchase updated successfully');
    }

    public function addPayment(Request $request)
    {
        $data = $request->all();
        $ezpos_purchase_data = Purchase::find($data['purchase_id']);
        $ezpos_purchase_data->paid_amount += $data['amount'];
        $balance = $ezpos_purchase_data->grand_total - $ezpos_purchase_data->paid_amount;
        if($balance > 0 || $balance < 0)
            $ezpos_purchase_data->payment_status = 1;
        elseif ($balance == 0)
            $ezpos_purchase_data->payment_status = 2;
        $ezpos_purchase_data->save();

        if($data['paid_by_id'] == 1)
            $paying_method = 'Cash';
        elseif ($data['paid_by_id'] == 2)
            $paying_method = 'Gift Card';
        elseif ($data['paid_by_id'] == 3)
            $paying_method = 'Credit Card';
        else
            $paying_method = 'Cheque';

        $ezpos_payment_data = new Payment();
        $ezpos_payment_data->date = date('Y-m-d', strtotime($data['date']));
        $ezpos_payment_data->user_id = Auth::id();
        $ezpos_payment_data->purchase_id = $ezpos_purchase_data->id;
        $ezpos_payment_data->payment_reference = 'ppr-' . date("Ymd") . '-'. date("his");
        $ezpos_payment_data->amount = $data['amount'];
        $ezpos_payment_data->paying_method = $paying_method;
        $ezpos_payment_data->payment_note = $data['payment_note'];
        $ezpos_payment_data->save();

        $ezpos_payment_data = Payment::latest()->first();
        $data['payment_id'] = $ezpos_payment_data->id;

        if($paying_method == 'Credit Card'){
            $ezpos_pos_setting_data = PosSetting::latest()->first();
            Stripe::setApiKey($ezpos_pos_setting_data->stripe_secret_key);
            $token = $data['stripeToken'];
            $amount = $data['amount'];

            // Charge the Customer
            $charge = \Stripe\Charge::create([
                'amount' => $amount * 100,
                'currency' => 'usd',
                'source' => $token,
            ]);

            $data['charge_id'] = $charge->id;
            PaymentWithCreditCard::create($data);
        }
        elseif ($paying_method == 'Cheque') {
            PaymentWithCheque::create($data);
        }
        return redirect('purchase')->with('message', 'Payment created successfully');
    }

    public function getPayment($id)
    {
        $ezpos_payment_list = Payment::where('purchase_id', $id)->get();
        $date = [];
        $payment_reference = [];
        $paid_amount = [];
        $paying_method = [];
        $payment_id = [];
        $payment_note = [];
        $cheque_no = [];

        foreach ($ezpos_payment_list as $payment) {
            $date[] = date('d-m-Y', strtotime($payment->date));
            $payment_reference[] = $payment->payment_reference;
            $paid_amount[] = $payment->amount;
            $paying_method[] = $payment->paying_method;
            if($payment->paying_method == 'Cheque'){
                $ezpos_payment_cheque_data = PaymentWithCheque::where('payment_id',$payment->id)->first();
                $cheque_no[] = $ezpos_payment_cheque_data->cheque_no;
            }
            else{
                $cheque_no[] = null;
            }
            $payment_id[] = $payment->id;
            $payment_note[] = $payment->payment_note;
        }
        $payments[] = $date;
        $payments[] = $payment_reference;
        $payments[] = $paid_amount;
        $payments[] = $paying_method;
        $payments[] = $payment_id;
        $payments[] = $payment_note;
        $payments[] = $cheque_no;

        return $payments;
    }

    public function updatePayment(Request $request)
    {
        $data = $request->all();
        $ezpos_payment_data = Payment::find($data['payment_id']);
        $ezpos_purchase_data = Purchase::find($ezpos_payment_data->purchase_id);
        //updating purchase table
        $amount_dif = $ezpos_payment_data->amount - $data['edit_amount'];
        $ezpos_purchase_data->paid_amount = $ezpos_purchase_data->paid_amount - $amount_dif;
        $balance = $ezpos_purchase_data->grand_total - $ezpos_purchase_data->paid_amount;
        if($balance > 0 || $balance < 0)
            $ezpos_purchase_data->payment_status = 1;
        elseif ($balance == 0)
            $ezpos_purchase_data->payment_status = 2;
        $ezpos_purchase_data->save();

        //updating payment data
        $ezpos_payment_data->date = date('Y-m-d', strtotime($data['date']));
        $ezpos_payment_data->amount = $data['edit_amount'];
        $ezpos_payment_data->payment_note = $data['edit_payment_note'];
        if($data['edit_paid_by_id'] == 1)
            $ezpos_payment_data->paying_method = 'Cash';
        elseif ($data['edit_paid_by_id'] == 2)
            $ezpos_payment_data->paying_method = 'Gift Card';
        elseif ($data['edit_paid_by_id'] == 3){
            $ezpos_pos_setting_data = PosSetting::latest()->first();
            \Stripe\Stripe::setApiKey($ezpos_pos_setting_data->stripe_secret_key);
            $token = $data['stripeToken'];
            $amount = $data['edit_amount'];
            if($ezpos_payment_data->paying_method == 'Credit Card'){
                $ezpos_payment_with_credit_card_data = PaymentWithCreditCard::where('payment_id', $ezpos_payment_data->id)->first();

                /*\Stripe\Refund::create(array(
                  "charge" => $ezpos_payment_with_credit_card_data->charge_id,
                ));*/

                $charge = \Stripe\Charge::create([
                    'amount' => $amount * 100,
                    'currency' => 'usd',
                    'source' => $token,
                ]);

                $ezpos_payment_with_credit_card_data->charge_id = $charge->id;
                $ezpos_payment_with_credit_card_data->save();
            }
            else{
                // Charge the Customer
                $charge = \Stripe\Charge::create([
                    'amount' => $amount * 100,
                    'currency' => 'usd',
                    'source' => $token,
                ]);

                $data['charge_id'] = $charge->id;
                PaymentWithCreditCard::create($data);
            }
            $ezpos_payment_data->paying_method = 'Credit Card';
        }         
        else{
            if($ezpos_payment_data->paying_method == 'Cheque'){
                $ezpos_payment_data->paying_method = 'Cheque';
                $ezpos_payment_cheque_data = PaymentWithCheque::where('payment_id', $data['payment_id'])->first();
                $ezpos_payment_cheque_data->cheque_no = $data['edit_cheque_no'];
                $ezpos_payment_cheque_data->save(); 
            }
            else{
                $ezpos_payment_data->paying_method = 'Cheque';
                $data['cheque_no'] = $data['edit_cheque_no'];
                PaymentWithCheque::create($data);
            }
        }
        $ezpos_payment_data->save();
        return redirect('purchase')->with('message', 'Payment updated successfully');
    }

    public function deletePayment(Request $request)
    {
        $ezpos_payment_data = Payment::find($request['id']);
        $ezpos_purchase_data = Purchase::where('id', $ezpos_payment_data->purchase_id)->first();
        $ezpos_purchase_data->paid_amount -= $ezpos_payment_data->amount;
        $balance = $ezpos_purchase_data->grand_total - $ezpos_purchase_data->paid_amount;
        if($balance > 0 || $balance < 0)
            $ezpos_purchase_data->payment_status = 1;
        elseif ($balance == 0)
            $ezpos_purchase_data->payment_status = 2;
        $ezpos_purchase_data->save();

        if($ezpos_payment_data->paying_method == 'Credit Card'){
            $ezpos_payment_with_credit_card_data = PaymentWithCreditCard::where('payment_id', $request['id'])->first();
            $ezpos_pos_setting_data = PosSetting::latest()->first();
            \Stripe\Stripe::setApiKey($ezpos_pos_setting_data->stripe_secret_key);
            \Stripe\Refund::create(array(
              "charge" => $ezpos_payment_with_credit_card_data->charge_id,
            ));

            $ezpos_payment_with_credit_card_data->delete();
        }

        elseif ($ezpos_payment_data->paying_method == 'Cheque') {
            $ezpos_payment_cheque_data = PaymentWithCheque::where('payment_id', $request['id'])->first();
            $ezpos_payment_cheque_data->delete();
        }
        $ezpos_payment_data->delete();
        return redirect('purchase')->with('not_permitted', 'Payment deleted successfully');
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('purchases-delete')){
            $ezpos_purchase_data = Purchase::find($id);
            $ezpos_product_purchase_data = ProductPurchase::where('purchase_id', $id)->get();
            $ezpos_payment_data = Payment::where('purchase_id', $id)->get();
            foreach ($ezpos_product_purchase_data as $product_purchase_data) {
                $ezpos_product_data = Product::find($product_purchase_data->product_id);
                $ezpos_product_store_data = Product_Store::where([
                        ['product_id', $product_purchase_data->product_id],
                        ['store_id', $ezpos_purchase_data->store_id]
                        ])->first();

                $ezpos_product_data->qty -= $product_purchase_data->recieved;
                if($ezpos_product_store_data){
                    $ezpos_product_store_data->qty -= $product_purchase_data->recieved;
                    $ezpos_product_store_data->save();
                }
                $ezpos_product_data->save();
                $product_purchase_data->delete();
            }
            foreach ($ezpos_payment_data as $payment_data) {
                if($payment_data->paying_method == "Cheque"){
                    $payment_with_cheque_data = PaymentWithCheque::where('payment_id', $payment_data->id)->first();
                    $payment_with_cheque_data->delete();
                }
                elseif($payment_data->paying_method == "Credit Card"){
                    $payment_with_credit_card_data = PaymentWithCreditCard::where('payment_id', $payment_data->id)->first();

                    \Stripe\Stripe::setApiKey($ezpos_pos_setting_data->stripe_secret_key);
                    \Stripe\Refund::create(array(
                      "charge" => $payment_with_credit_card_data->charge_id,
                    ));

                    $payment_with_credit_card_data->delete();
                }
                $payment_data->delete();
            }

            $ezpos_purchase_data->delete();
            return redirect('purchase')->with('not_permitted', 'Purchase deleted successfully');;
        }
        
    }
}

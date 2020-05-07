<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Product;
use App\Product_Store;
use App\Tax;
use App\Transfer;
use App\ProductTransfer;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class TransferController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('transfers-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            $ezpos_transfer_all = Transfer::orderBy('id', 'desc')->get();
            return view('transfer.index', compact('ezpos_transfer_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('transfers-add')){
            $ezpos_store_list = Store::where('is_active', true)->get();
            return view('transfer.create', compact('ezpos_store_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function getProduct($id)
    {   
	    $zb=DB::table('general_settings')->limit(1)->get()[0]->zero_balance;
        if($zb==1){
		  $ezpos_product_store_data = Product_Store::where([
                                        ['store_id', $id],
		                           ])->get();	
		}
		else{
		$ezpos_product_store_data = Product_Store::where([
                                        ['store_id', $id],
                                        ['qty', '>', 0]
		                           ])->get();
		}						   
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
        }

        $product_data[] = $product_code;
        $product_data[] = $product_name;
        $product_data[] = $product_qty;
        return $product_data;
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
        $data['reference_no'] = 'tr-' . date("Ymd") . '-'. date("his");
        $document = $request->document;
        if ($document) {
            $documentName = $document->getClientOriginalName();
            $document->move('public/documents/transfer', $documentName);
            $data['document'] = $documentName;
        }
        Transfer::create($data);

        $ezpos_transfer_data = Transfer::latest()->first();
        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $purchase_unit = $data['purchase_unit'];
        $net_unit_cost = $data['net_unit_cost'];
        $tax_rate = $data['tax_rate'];
        $tax = $data['tax'];
        $total = $data['subtotal'];
        $product_transfer = [];
        $i=0;

        foreach ($product_id as $id) {
            //deduct quantity from sending store
            $ezpos_product_store_data = Product_Store::where([
                ['product_id', $id],
                ['store_id', $data['from_store_id'] ],
                ])->first();
            $ezpos_product_store_data->qty = $ezpos_product_store_data->qty - $qty[$i];
            $ezpos_product_store_data->save();
            //add quantity to destination store
            if($data['status'] == 1){
                $ezpos_product_store_data = Product_Store::where([
                ['product_id', $id],
                ['store_id', $data['to_store_id'] ],
                ])->first();

                if ($ezpos_product_store_data)
                    $ezpos_product_store_data->qty = $ezpos_product_store_data->qty + $qty[$i];
                else {
                    $ezpos_product_store_data = new Product_Store();
                    $ezpos_product_store_data->product_id = $id;
                    $ezpos_product_store_data->store_id = $data['to_store_id'];
                    $ezpos_product_store_data->qty = $qty[$i];
                }

                $ezpos_product_store_data->save();
            }

            $product_transfer['transfer_id'] = $ezpos_transfer_data->id ;
            $product_transfer['product_id'] = $id;
            $product_transfer['qty'] = $qty[$i];
            $product_transfer['unit'] = $purchase_unit[$i];
            $product_transfer['net_unit_cost'] = $net_unit_cost[$i];
            $product_transfer['tax_rate'] = $tax_rate[$i];
            $product_transfer['tax'] = $tax[$i];
            $product_transfer['total'] = $total[$i];
            ProductTransfer::create($product_transfer);
			
			$total_in=DB::table('item_movement')->where('product_id',$id)->where('store_id',$data['from_store_id'])->get()->sum('qty_in');
			$total_out=DB::table('item_movement')->where('product_id',$id)->where('store_id',$data['from_store_id'])->get()->sum('qty_out');
			
			
			$total_in=DB::table('item_movement')->where('product_id',$id)->where('store_id',$data['to_store_id'])->get()->sum('qty_in');
			$total_out=DB::table('item_movement')->where('product_id',$id)->where('store_id',$data['to_store_id'])->get()->sum('qty_out');
			$tobalance=$total_in-$total_out;
			$category=DB::table('products')->where('id',$id)->get()[0]->category_id;
			$frombalance=$total_in-$total_out;
			
			if(!$document){
				$data['document']="";
			}
			$move_item_from['date']=date('Y-m-d');
			$move_item_from['time']=date('h:i:s');
			$move_item_from['user']=Auth::id();
			$move_item_from['product_id']=$id;
			$move_item_from['category_id']=$category;
			$move_item_from['store_id']=$data['from_store_id'];
			$move_item_from['qty_in']=0;
			$move_item_from['qty_out']=$qty[$i];
			$move_item_from['balance']=$frombalance-$qty[$i];
			$move_item_from['type_invoice']="Tansfer";
			$move_item_from['description']=$data['note'];
			$move_item_from['reference']=$data['reference_no'];
			$move_item_from['attach']=$data['document'];
			$move_item_from['col1']='';
			$move_item_from['col2']='';
			$move_item_from['col3']='';
			
			
			
			$move_item_to['date']=date('Y-m-d');
			$move_item_to['time']=date('h:i:s');
			$move_item_to['user']=Auth::id();
			$move_item_to['product_id']=$id;
			$move_item_to['category_id']=$category;
			$move_item_to['store_id']=$data['to_store_id'];
			$move_item_to['qty_in']=$qty[$i];
			$move_item_to['qty_out']=0;
			$move_item_to['balance']=$tobalance+$qty[$i];
			$move_item_to['type_invoice']="transfer";
			$move_item_to['description']=$data['note'];
			$move_item_to['reference']=$data['reference_no'];
			$move_item_to['attach']=$data['document'];
			$move_item_to['col1']='';
			$move_item_to['col2']='';
			$move_item_to['col3']='';
			
			DB::table('item_movement')->insert($move_item_from);
			DB::table('item_movement')->insert($move_item_to);
			
            $i++;
        }

        return redirect('transfers')->with('message', 'Transfer created successfully');
    }

    public function productTransferData($id)
    {
        $ezpos_product_transfer_data = ProductTransfer::where('transfer_id', $id)->get();
        foreach ($ezpos_product_transfer_data as $key => $product_transfer_data) {
            $product = Product::find($product_transfer_data->product_id);
            $product_transfer[0][$key] = $product->name . '-' . $product->code;
            $product_transfer[1][$key] = $product_transfer_data->qty;
            $product_transfer[2][$key] = $product_transfer_data->unit;
            $product_transfer[3][$key] = $product_transfer_data->tax;
            $product_transfer[4][$key] = $product_transfer_data->tax_rate;
            $product_transfer[5][$key] = $product_transfer_data->total;
        }
        return $product_transfer;
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('transfers-edit')){
            $ezpos_store_list = Store::where('is_active',true)->get();
            $ezpos_transfer_data = Transfer::find($id);
            $ezpos_product_transfer_data = ProductTransfer::where('transfer_id', $id)->get();
            return view('transfer.edit', compact('ezpos_store_list', 'ezpos_transfer_data', 'ezpos_product_transfer_data'));
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
            $document->move('public/documents/transfer', $documentName);
            $data['document'] = $documentName;
        }

        $ezpos_transfer_data = Transfer::find($id);
        $ezpos_product_transfer_data = ProductTransfer::where('transfer_id', $id)->get();
        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $purchase_unit = $data['purchase_unit'];
        $net_unit_cost = $data['net_unit_cost'];
        $tax_rate = $data['tax_rate'];
        $tax = $data['tax'];
        $total = $data['subtotal'];
        $product_transfer = [];
        foreach ($ezpos_product_transfer_data as $key => $product_transfer_data) {
            $old_product_id[] = $product_transfer_data->product_id;
            
            if($ezpos_transfer_data->status == 1){
                $ezpos_product_store_data = Product_Store::where([
                    ['product_id', $product_transfer_data->product_id],
                    ['store_id', $ezpos_transfer_data->from_store_id]
                ])->first();
                $ezpos_product_store_data->qty += $product_transfer_data->qty;
                $ezpos_product_store_data->save();

                $ezpos_product_store_data = Product_Store::where([
                    ['product_id', $product_transfer_data->product_id],
                    ['store_id', $ezpos_transfer_data->to_store_id]
                ])->first();
                $ezpos_product_store_data->qty -= $product_transfer_data->qty;
                $ezpos_product_store_data->save();
            }
            elseif($ezpos_transfer_data->status == 3){
                $ezpos_product_store_data = Product_Store::where([
                    ['product_id', $product_transfer_data->product_id],
                    ['store_id', $ezpos_transfer_data->from_store_id]
                ])->first();
                $ezpos_product_store_data->qty += $product_transfer_data->qty;
                $ezpos_product_store_data->save();
            }
            if( !(in_array($old_product_id[$key], $product_id)) )
                $product_transfer_data->delete();
        }

        foreach ($product_id as $key => $pro_id) {
            if($data['status'] == 1){
                $ezpos_product_store_data = Product_Store::where([
                ['product_id', $pro_id],
                ['store_id', $data['from_store_id']]
                ])->first();

                $ezpos_product_store_data->qty -= $qty[$key];
                $ezpos_product_store_data->save();

                $ezpos_product_store_data = Product_Store::where([
                ['product_id', $pro_id],
                ['store_id', $data['to_store_id']]
                ])->first();
                if($ezpos_product_store_data){
                    $ezpos_product_store_data->qty += $qty[$key];
                }
                else{
                    $ezpos_product_store_data = new Product_store();
                    $ezpos_product_store_data->product_id = $pro_id;
                    $ezpos_product_store_data->store_id = $data['to_store_id'];
                    $ezpos_product_store_data->qty = $qty[$key];
                }
                $ezpos_product_store_data->save();
            }
            elseif($data['status'] == 3){
                $ezpos_product_store_data = Product_Store::where([
                ['product_id', $pro_id],
                ['store_id', $data['from_store_id']]
                ])->first();

                $ezpos_product_store_data->qty -= $qty[$key];
                $ezpos_product_store_data->save();
            }

            $product_transfer['product_id'] = $pro_id;
            $product_transfer['transfer_id'] = $id;
            $product_transfer['qty'] = $qty[$key];
            $product_transfer['unit'] = $purchase_unit[$key];
            $product_transfer['net_unit_cost'] = $net_unit_cost[$key];
            $product_transfer['tax_rate'] = $tax_rate[$key];
            $product_transfer['tax'] = $tax[$key];
            $product_transfer['total'] = $total[$key];
            
            if(in_array($pro_id, $old_product_id)){
                ProductTransfer::where([
                ['transfer_id', $id],
                ['product_id', $pro_id]
                ])->update($product_transfer);
            }
            else
                ProductTransfer::create($product_transfer);
        }

        $ezpos_transfer_data->update($data);
        return redirect('transfers')->with('message', 'Transfer updated successfully');
    }

    public function destroy($id)
    {
        $ezpos_transfer_data =Transfer::find($id);
        $ezpos_product_transfer_data = ProductTransfer::where('transfer_id', $id)->get();
        foreach ($ezpos_product_transfer_data as $product_transfer_data) {
            if($ezpos_transfer_data->status == 1){
                $ezpos_product_store_data = Product_Store::where([
                    ['product_id', $product_transfer_data->product_id],
                    ['store_id', $ezpos_transfer_data->from_store_id]
                ])->first();
                $ezpos_product_store_data->qty += $product_transfer_data->qty;
                $ezpos_product_store_data->save();

                $ezpos_product_store_data = Product_Store::where([
                    ['product_id', $product_transfer_data->product_id],
                    ['store_id', $ezpos_transfer_data->to_store_id]
                ])->first();
                $ezpos_product_store_data->qty -= $product_transfer_data->qty;
                $ezpos_product_store_data->save();
            }
            elseif($ezpos_transfer_data->status == 3){
                $ezpos_product_store_data = Product_Store::where([
                    ['product_id', $product_transfer_data->product_id],
                    ['store_id', $ezpos_transfer_data->from_store_id]
                ])->first();
                $ezpos_product_store_data->qty += $product_transfer_data->qty;
                $ezpos_product_store_data->save();
            }
            $product_transfer_data->delete();
        }
        $ezpos_transfer_data->delete();
        return redirect('transfers')->with('not_permitted', 'Transfer deleted successfully');
    }
}

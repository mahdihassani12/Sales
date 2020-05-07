<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Product_Store;
use App\Product;
use App\Adjustment;
use App\ProductAdjustment;
use Auth;
use DB;
use Excel; 
use Spatie\Permission\Models\Role;

class AdjustmentController extends Controller
{
    public function index()
    {
	  $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('adjustment-index')){	 
        $ezpos_adjustment_all = Adjustment::orderBy('id', 'desc')->get();
		$permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
        return view('adjustment.index', compact('ezpos_adjustment_all','all_permission'));
		}
		else
		return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');	
    }

    public function getProduct($id)
    {
		 
        $ezpos_product_store_data = DB::table('products')
            ->join('product_store', 'products.id', '=', 'product_store.product_id')->where([ ['products.is_active', 1], ['product_store.store_id', $id] ])->select('product_store.qty', 'products.code', 'products.name' ,'products.arabic_name')->get();
        $product_code = [];
        $product_name = [];
        $product_qty = [];
        $product_data = [];
        $product_arabicname = [];
        foreach ($ezpos_product_store_data as $product_store) 
        {
            $product_qty[] = $product_store->qty;
            $product_code[] =  $product_store->code;
            $product_name[] = $product_store->name;
            $product_arabicname[] = $product_store->arabic_name;
        }

        $product_data[] = $product_code;
        $product_data[] = $product_name;
        $product_data[] = $product_qty;
        $product_data[]= $product_arabicname;
        return $product_data;
    }

    public function ezposProductSearch(Request $request)
    {
        $product_code = explode(" ", $request['data']);
        $ezpos_product_data = Product::where('code', $product_code[0])->first();

        $product[] = $ezpos_product_data->name;
        $product[] = $ezpos_product_data->code;
        $product[] = $ezpos_product_data->id;
        $product[] = $ezpos_product_data->arabic_name; 
        return $product;
    }

    public function create(Request $request)
    {
       
        $store_id=$request->store_id;
	    $product_id=$request->product_id;
	    $branch=Auth::user()->branch_id;
  
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('adjustment-in')){			
            //$ezpos_store_list = Store::where('is_active', true)->get();
            $ezpos_store_list = Store::where('is_active', true);if($branch !="Admin"){$ezpos_store_list=$ezpos_store_list->where('branch_id',$branch);} $ezpos_store_list=$ezpos_store_list->get();

		   $default_store=Auth::user()->store_id;
           $user_role=Auth::user()->role_id; 

            return view('adjustment.create', compact('ezpos_store_list','default_store','user_role','store_id','product_id'));
		}
		else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
   

   public function out_store()
    {
		$branch=Auth::user()->branch_id; 
		$role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('adjustment-out')){ 
           //$ezpos_store_list = Store::where('is_active', true)->get();
           $ezpos_store_list = Store::where('is_active', true);if($branch !="Admin"){$ezpos_store_list=$ezpos_store_list->where('branch_id',$branch);} $ezpos_store_list=$ezpos_store_list->get();

		   $default_store=Auth::user()->store_id;
           $user_role=Auth::user()->role_id; 
           return view('adjustment.outStore', compact('ezpos_store_list','default_store','user_role'));
		}
		else
		  return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
	
    }
	
    public function store(Request $request)
    {
	  	
      $branch=Auth::user()->branch_id;		
      if($request->has('document')){
           $store_id=$request->store_id;
           $data['store_id']=$store_id;
           $data['date'] = date('Y-m-d');
           $data['reference_no'] = 'adr-' . date("Ymd") . '-'. date("his");
           $data['total_qty']=0;
           $data['item']=0;
           $data['created_at']=date("Y-m-d h:i:s");
           $data['updated_at']=date("Y-m-d h:i:s");
           $data['type']='in_store';
           $data['user_id']=Auth::user()->id;
           $data['branch_id']=$branch;
           Adjustment::create($data);

            $reference =$data['reference_no']; 
           $adjustment_id = Adjustment::latest()->first()->id;
                       
           Excel::load($request->file('document')->getRealPath(), function ($reader) use($adjustment_id, $store_id,$reference) {
                $totalqtys=0;
                $totalitems=0;
                foreach ($reader->toArray() as $key => $row) {
                $product = Product::where([
                  ['code', $row['code']],
                ['is_active', '1']
                ])->first();
                  if(isset($product->id)){
                    $totalitems++;
                    $totalqtys+=$row['qty'];
                    $cdata['adjustment_id']=$adjustment_id;
                    $product_id=$product->id;
                    $cdata['product_id']=$product_id;
                    $cdata['qty']=$row['qty'];
                    $cdata['action']="+";
                    $cdata['created_at']=date("Y-m-d h:i:s");
                    $cdata['updated_at']=date("Y-m-d h:i:s");
                    
                    if(!empty($cdata)) {
                        DB::table('product_adjustments')->insert($cdata);
                    }

             $updateData['is_inserted']='1';
             DB::table('product_store')->where('store_id',$store_id)->where('product_id',$product_id)->update($updateData);        
             DB::table('product_store')->where('store_id',$store_id)->where('product_id',$product_id)->increment('qty',$row['qty']);


            $total_in=DB::table('item_movement')->where('product_id',$product_id)->where('store_id',$store_id)->get()->sum('qty_in');

            $total_out=DB::table('item_movement')->where('product_id',$product_id)->where('store_id',$store_id)->get()->sum('qty_out');
            
            $category=DB::table('products')->where('id',$product_id)->get()[0]->category_id;

            $new_balance=$total_in-$total_out;
            
            
            $branch=Auth::user()->branch_id;
            $move_item['qty_in']=$row['qty'];
            $move_item['qty_out']=0;
            $move_item['balance']=$new_balance+$row['qty'];
            $move_item['date']=date('Y-m-d');
            $move_item['time']=date('h:i:s');
            $move_item['user']=Auth::id();
            $move_item['product_id']=$product_id;
            $move_item['category_id']=$category;
            $move_item['store_id']=$store_id;
            $move_item['type_invoice']="adjustment";
            // $move_item['description']=$data['note'];
            $move_item['reference']=$reference;
            $move_item['branch_id']=$branch;
            $move_item['col1']='';
            $move_item['col2']='';
            $move_item['col3']='';
            DB::table('item_movement')->insert($move_item);

                }
                }

                DB::table('adjustments')->where('id',$adjustment_id)->update(['total_qty'=>$totalqtys,'item'=>$totalitems]);
            });
        } 
        

    else{ 
        $data = $request->except('document');
        $data['date'] = date('Y-m-d', strtotime($data['date']));
        $data['reference_no'] = 'adr-' . date("Ymd") . '-'. date("his");
		 $data['type']=$data['adjustment_type'];
		
        $document = $request->document;
        if ($document) {
            $documentName = $document->getClientOriginalName();
            $document->move('public/documents/adjustment', $documentName);
            $data['document'] = $documentName;
        }
        $data['user_id']=Auth::user()->id;
        $data['branch_id']=$branch;
        Adjustment::create($data);

        $ezpos_adjustment_data = Adjustment::latest()->first();
        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $action = $data['action'];

        foreach ($product_id as $key => $pro_id) {
            $ezpos_product_data = Product::find($pro_id);
            $ezpos_product_store_data = Product_Store::where([
                ['product_id', $pro_id],
                ['store_id', $data['store_id'] ],
                ])->first();
            if($action[$key] == '-'){
                $ezpos_product_data->qty -= $qty[$key];
                $ezpos_product_store_data->qty -= $qty[$key];
            }
            elseif($action[$key] == '+'){
                $ezpos_product_data->qty += $qty[$key];
                $ezpos_product_store_data->qty += $qty[$key];
                $ezpos_product_store_data->is_inserted ='1';
				
            }
            $ezpos_product_data->save();
            $ezpos_product_store_data->save();

            $product_adjustment['product_id'] = $pro_id;
            $product_adjustment['adjustment_id'] = $ezpos_adjustment_data->id;
            $product_adjustment['qty'] = $qty[$key];
            $product_adjustment['action'] = $action[$key];
            ProductAdjustment::create($product_adjustment);
			
			
			$total_in=DB::table('item_movement')->where('product_id',$pro_id)->where('store_id',$data['store_id'])->get()->sum('qty_in');
			$total_out=DB::table('item_movement')->where('product_id',$pro_id)->where('store_id',$data['store_id'])->get()->sum('qty_out');
			
			$category=DB::table('products')->where('id',$pro_id)->get()[0]->category_id;
			$new_balance=$total_in-$total_out;
			
			if(!$document){
				$data['document']="";
			}
			
			//check the action for item_movement table
			if($action[$key] == '+'){
				$move_item['qty_in']=$qty[$key];
			   $move_item['qty_out']=0;
			   $move_item['balance']=$new_balance+$qty[$key];
			}
			else{
				$move_item['qty_in']=0;
			   $move_item['qty_out']=$qty[$key];
			   $move_item['balance']=$new_balance-$qty[$key];
			}
			$move_item['date']=date('Y-m-d');
			$move_item['time']=date('h:i:s');
			$move_item['user']=Auth::id();
			$move_item['product_id']=$pro_id;
			$move_item['category_id']=$category;
			$move_item['store_id']=$data['store_id'];
			$move_item['type_invoice']="adjustment";
			$move_item['description']=$data['note'];
			$move_item['reference']=$data['reference_no'];
			$move_item['attach']=$data['document'];
			$move_item['branch_id']=$branch;
			$move_item['col1']='';
			$move_item['col2']='';
			$move_item['col3']='';
			DB::table('item_movement')->insert($move_item);
			
        }
      }
        return redirect('order/order_archive')->with('message', 'Data inserted successfully');
    }

    public function edit($id)
    {
 	 $branch=Auth::user()->branch_id;
     $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('adjusment-edit')){	 
        $ezpos_adjustment_data = Adjustment::find($id);
        $ezpos_product_adjustment_data = ProductAdjustment::where('adjustment_id', $id)->get();
        //$ezpos_store_list = Store::where('is_active', true)->get();
        $ezpos_store_list = Store::where('is_active', true);if($branch !="Admin"){$ezpos_store_list=$ezpos_store_list->where('branch_id',$branch);} $ezpos_store_list=$ezpos_store_list->get();

		return view('adjustment.edit', compact('ezpos_adjustment_data', 'ezpos_store_list', 'ezpos_product_adjustment_data'));
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
            $document->move('public/documents/adjustment', $documentName);
            $data['document'] = $documentName;
        }

        $ezpos_adjustment_data = Adjustment::find($id);
        $ezpos_product_adjustment_data = ProductAdjustment::where('adjustment_id', $id)->get();
        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $action = $data['action'];

        foreach ($ezpos_product_adjustment_data as $key => $product_adjustment_data) {
            $old_product_id[] = $product_adjustment_data->product_id;
            $ezpos_product_data = Product::find($product_adjustment_data->product_id);
            $ezpos_product_store_data = Product_Store::where([
                    ['product_id', $product_adjustment_data->product_id],
                    ['store_id', $ezpos_adjustment_data->store_id]
                ])->first();
            if($product_adjustment_data->action == '-'){
                $ezpos_product_data->qty += $product_adjustment_data->qty;
                $ezpos_product_store_data->qty += $product_adjustment_data->qty;
            }
            elseif($product_adjustment_data->action == '+'){
                $ezpos_product_data->qty -= $product_adjustment_data->qty;
                $ezpos_product_store_data->qty -= $product_adjustment_data->qty;
            }
            $ezpos_product_data->save();
            $ezpos_product_store_data->save();

            if( !(in_array($old_product_id[$key], $product_id)) )
                $product_adjustment_data->delete();
        }

        foreach ($product_id as $key => $pro_id) {
            $ezpos_product_data = Product::find($pro_id);
            $ezpos_product_store_data = Product_Store::where([
                ['product_id', $pro_id],
                ['store_id', $data['store_id'] ],
                ])->first();
            if($action[$key] == '-'){
                $ezpos_product_data->qty -= $qty[$key];
                $ezpos_product_store_data->qty -= $qty[$key];
            }
            elseif($action[$key] == '+'){
                $ezpos_product_data->qty += $qty[$key];
                $ezpos_product_store_data->qty += $qty[$key];
            }
            $ezpos_product_data->save();
            $ezpos_product_store_data->save();

            $product_adjustment['product_id'] = $pro_id;
            $product_adjustment['adjustment_id'] = $id;
            $product_adjustment['qty'] = $qty[$key];
            $product_adjustment['action'] = $action[$key];

            if(in_array($pro_id, $old_product_id)){
                ProductAdjustment::where([
                ['adjustment_id', $id],
                ['product_id', $pro_id]
                ])->update($product_adjustment);
            }
            else
                ProductAdjustment::create($product_adjustment);
        }
        $ezpos_adjustment_data->update($data);
        return redirect('order/order_archive')->with('message', 'Data updated successfully');
    }

    public function re_insert($id){
	  $branch=Auth::user()->branch_id;
 	 
     $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('adjusment-edit')){	 
        $ezpos_adjustment_data = Adjustment::find($id);
        $ezpos_product_adjustment_data = ProductAdjustment::where('adjustment_id', $id)->get();
        //$ezpos_store_list = Store::where('is_active', true)->get();
        $ezpos_store_list = Store::where('is_active', true);if($branch !="Admin"){$ezpos_store_list=$ezpos_store_list->where('branch_id',$branch);} $ezpos_store_list=$ezpos_store_list->get();

		return view('adjustment.re-insert', compact('ezpos_adjustment_data', 'ezpos_store_list', 'ezpos_product_adjustment_data'));
	  }
	 else 
		return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');  
		
	}
    
	public function insertNew(Request $request) {
	  	
      $branch=Auth::user()->branch_id;		
      if($request->has('document')){
           $store_id=$request->store_id;
           $data['store_id']=$store_id;
           $data['date'] = date('Y-m-d');
           $data['reference_no'] = 'adr-' . date("Ymd") . '-'. date("his");
           $data['total_qty']=0;
           $data['item']=0;
           $data['created_at']=date("Y-m-d h:i:s");
           $data['updated_at']=date("Y-m-d h:i:s");
           $data['type']='in_store';
           $data['user_id']=Auth::user()->id;
           $data['branch_id']=$branch;
           Adjustment::create($data);

            $reference =$data['reference_no']; 
           $adjustment_id = Adjustment::latest()->first()->id;
                       
           Excel::load($request->file('document')->getRealPath(), function ($reader) use($adjustment_id, $store_id,$reference) {
                $totalqtys=0;
                $totalitems=0;
                foreach ($reader->toArray() as $key => $row) {
                $product = Product::where([
                  ['code', $row['code']],
                ['is_active', '1']
                ])->first();
                  if(isset($product->id)){
                    $totalitems++;
                    $totalqtys+=$row['qty'];
                    $cdata['adjustment_id']=$adjustment_id;
                    $product_id=$product->id;
                    $cdata['product_id']=$product_id;
                    $cdata['qty']=$row['qty'];
                    $cdata['action']="+";
                    $cdata['created_at']=date("Y-m-d h:i:s");
                    $cdata['updated_at']=date("Y-m-d h:i:s");
                    
                    if(!empty($cdata)) {
                        DB::table('product_adjustments')->insert($cdata);
                    }

             $updateData['is_inserted']='1';
             DB::table('product_store')->where('store_id',$store_id)->where('product_id',$product_id)->update($updateData);        
             DB::table('product_store')->where('store_id',$store_id)->where('product_id',$product_id)->increment('qty',$row['qty']);


            $total_in=DB::table('item_movement')->where('product_id',$product_id)->where('store_id',$store_id)->get()->sum('qty_in');

            $total_out=DB::table('item_movement')->where('product_id',$product_id)->where('store_id',$store_id)->get()->sum('qty_out');
            
            $category=DB::table('products')->where('id',$product_id)->get()[0]->category_id;

            $new_balance=$total_in-$total_out;
            
            
            
            $move_item['qty_in']=$row['qty'];
            $move_item['qty_out']=0;
            $move_item['balance']=$new_balance+$row['qty'];
            $move_item['date']=date('Y-m-d');
            $move_item['time']=date('h:i:s');
            $move_item['user']=Auth::id();
            $move_item['product_id']=$product_id;
            $move_item['category_id']=$category;
            $move_item['store_id']=$store_id;
            $move_item['type_invoice']="adjustment";
            // $move_item['description']=$data['note'];
            $move_item['reference']=$reference;
            $move_item['branch_id']=$branch;
            $move_item['col1']='';
            $move_item['col2']='';
            $move_item['col3']='';
            DB::table('item_movement')->insert($move_item);

                }
                }

                DB::table('adjustments')->where('id',$adjustment_id)->update(['total_qty'=>$totalqtys,'item'=>$totalitems]);
            });
        } 
        

    else{ 
        $data = $request->except('document');
        $data['date'] = date('Y-m-d', strtotime($data['date']));
        $data['reference_no'] = 'adr-' . date("Ymd") . '-'. date("his");
		 $data['type']='in_store';
		
        $document = $request->document;
        if ($document) {
            $documentName = $document->getClientOriginalName();
            $document->move('public/documents/adjustment', $documentName);
            $data['document'] = $documentName;
        }
        $data['user_id']=Auth::user()->id;
        $data['branch_id']=$branch;
        Adjustment::create($data);

        $ezpos_adjustment_data = Adjustment::latest()->first();
        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $action = $data['action'];

        foreach ($product_id as $key => $pro_id) {
            $ezpos_product_data = Product::find($pro_id);
            $ezpos_product_store_data = Product_Store::where([
                ['product_id', $pro_id],
                ['store_id', $data['store_id'] ],
                ])->first();
            if($action[$key] == '-'){
                $ezpos_product_data->qty -= $qty[$key];
                $ezpos_product_store_data->qty -= $qty[$key];
            }
            elseif($action[$key] == '+'){
                $ezpos_product_data->qty += $qty[$key];
                $ezpos_product_store_data->qty += $qty[$key];
                $ezpos_product_store_data->is_inserted ='1';
				
            }
            $ezpos_product_data->save();
            $ezpos_product_store_data->save();

            $product_adjustment['product_id'] = $pro_id;
            $product_adjustment['adjustment_id'] = $ezpos_adjustment_data->id;
            $product_adjustment['qty'] = $qty[$key];
            $product_adjustment['action'] = $action[$key];
            ProductAdjustment::create($product_adjustment);
			
			
			$total_in=DB::table('item_movement')->where('product_id',$pro_id)->where('store_id',$data['store_id'])->get()->sum('qty_in');
			$total_out=DB::table('item_movement')->where('product_id',$pro_id)->where('store_id',$data['store_id'])->get()->sum('qty_out');
			
			$category=DB::table('products')->where('id',$pro_id)->get()[0]->category_id;
			$new_balance=$total_in-$total_out;
			
			if(!$document){
				$data['document']="";
			}
			
			//check the action for item_movement table
			if($action[$key] == '+'){
				$move_item['qty_in']=$qty[$key];
			   $move_item['qty_out']=0;
			   $move_item['balance']=$new_balance+$qty[$key];
			}
			else{
				$move_item['qty_in']=0;
			   $move_item['qty_out']=$qty[$key];
			   $move_item['balance']=$new_balance-$qty[$key];
			}
			$move_item['date']=date('Y-m-d');
			$move_item['time']=date('h:i:s');
			$move_item['user']=Auth::id();
			$move_item['product_id']=$pro_id;
			$move_item['category_id']=$category;
			$move_item['store_id']=$data['store_id'];
			$move_item['type_invoice']="adjustment";
			$move_item['description']=$data['note'];
			$move_item['reference']=$data['reference_no'];
			$move_item['attach']=$data['document'];
			$move_item['branch_id']=$branch;
			$move_item['col1']='';
			$move_item['col2']='';
			$move_item['col3']='';
			DB::table('item_movement')->insert($move_item);
			
        }
      }
        return redirect('order/order_archive')->with('message', 'Data inserted successfully');
    }

   
	
	public function destroy($id)
    {
        
        $ref_no= DB::table('adjustments')->where('id',$id)->first()->reference_no;
        DB::table('item_movement')->where('type_invoice','adjustment')->where('reference',$ref_no)->delete();
		
        $ezpos_adjustment_data = Adjustment::find($id);
        $ezpos_product_adjustment_data = ProductAdjustment::where('adjustment_id', $id)->get();
        foreach ($ezpos_product_adjustment_data as $key => $product_adjustment_data) {
            $ezpos_product_data = Product::find($product_adjustment_data->product_id);
            $ezpos_product_store_data = Product_Store::where([
                    ['product_id', $product_adjustment_data->product_id],
                    ['store_id', $ezpos_adjustment_data->store_id]
                ])->first();
            if($product_adjustment_data->action == '-'){
                $ezpos_product_data->qty += $product_adjustment_data->qty;
                $ezpos_product_store_data->qty += $product_adjustment_data->qty;
            }
            elseif($product_adjustment_data->action == '+'){
                $ezpos_product_data->qty -= $product_adjustment_data->qty;
                $ezpos_product_store_data->qty -= $product_adjustment_data->qty;
            }
            $ezpos_product_data->save();
            $ezpos_product_store_data->save();
            $product_adjustment_data->delete();
        }
        $ezpos_adjustment_data->delete();

        
        return redirect('order/order_archive')->with('not_permitted', 'Data deleted successfully');
    }
	
	
   public function adjustmentInvoice($reference_no,$type,$status){
		 $role = Role::find(Auth::user()->role_id);
		 //purchase  adjustment  sell
       //if($role->hasPermissionTo('adjustment-index')){
	     if($type=="adjustment"){	 
			 $adjusInvoice=DB::table('adjustments')
			->join('stores','stores.id','adjustments.store_id')
			->select('adjustments.*','stores.name')
			->where('adjustments.reference_no',$reference_no)
			->get();
		
		     $products=DB::table('product_adjustments')
		          ->join('adjustments','adjustments.id','product_adjustments.adjustment_id')
				  ->join('products','products.id','product_adjustments.product_id')
				  ->select('products.name','product_adjustments.qty','products.price')
				  ->where('adjustments.reference_no',$reference_no)
				  ->get();
		 }
		 else if($type=="sell"){ 
			 $adjusInvoice=DB::table('sales')
			->join('stores','stores.id','sales.store_id')
			->select('sales.*','stores.name')
			->where('sales.reference_no',$reference_no)
			->get();
		
		     $products=DB::table('product_sales')
		          ->join('sales','sales.id','product_sales.sale_id')
				  ->join('products','products.id','product_sales.product_id')
				  ->select('products.name','product_sales.qty','products.price')
				  ->where('sales.reference_no',$reference_no)
				  ->get(); 
		       }
		 else {
			 $store="to_store_id";
			  if($status=="out"){
				$store="from_store_id"; 
			 }
			 $adjusInvoice=DB::table('transfers')
			->join('stores','stores.id','transfers.'.$store)
			->select('transfers.*','stores.name')
			->where('transfers.reference_no',$reference_no)
			->get();
		
		     $products=DB::table('product_transfer')
		          ->join('transfers','transfers.id','product_transfer.transfer_id')
				  ->join('products','products.id','product_transfer.product_id')
				  ->select('products.name','product_transfer.qty','products.price')
				  ->where('transfers.reference_no',$reference_no)
				  ->get();  
		 }
		 
				  
		$permissions = Role::findByName($role->name)->permissions;
		  
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
			
          return view('adjustment.invoice')->with('adjusInvoice',$adjusInvoice)->with('products',$products)->with('all_permission',$all_permission);
		//}
		//else
		//return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');	
      }

}
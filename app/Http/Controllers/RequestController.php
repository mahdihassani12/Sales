<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Keygen;
use DB;
use App\Brand;
use App\Category;
use App\Tax;
use App\Store;
use App\Supplier;
use App\Product;
use App\Company;
use App\Product_Store;
use App\Product_Supplier;
use Auth;
use DNS1D;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class RequestController extends Controller
{
	public function index(){
		$total_Request= DB::table('sales')->where('order_status','0')->get();
        $branch=Auth::user()->branch_id;

		$request=DB::table('request')
		->leftjoin('stores','stores.id','request.customer_store')
         ->leftjoin('sales','sales.request_id','request.id')
		->join('product_request','product_request.request_id','request.id')
		->where('request.is_active',1)
		->where('sales.order_status','0')
		->where('request.is_marketer_order','0')
         ->where('request.status','=','waiting');
         if($branch!="Admin"){
			     $request=$request->where('request.branch_id',$branch);	  
			   }

		$request=$request->select('sales.date as request_date','sales.is_printed as sales_isprint','sales.id as SalesID','request.*','stores.name as storeName',DB::raw('sum(product_request.product_qty) as totalQty'))
		->groupBy('request.id')
         ->orderBy('request.id','DESC')
		->get();
        $users=DB::table('users')->where('is_active','1')->get();
		return view('request.index')->with('request',$request)->with('users',$users);;
	}
    
              public function selec_request($user_id){
		$request=DB::table('request')
		->leftjoin('stores','stores.id','request.customer_store')
		->leftjoin('sales','sales.request_id','request.id')
		->join('product_request','product_request.request_id','request.id')
		->where('request.is_active','1')
		->where('request.is_marketer_order','0');
       // ->where('request.status','=','waiting');
		if($user_id!="all"){
			$request=$request->where('sales.user_id',$user_id);
		}
		$request=$request->select('sales.date as request_date','sales.id as SalesID','sales.is_printed as sales_isprint','request.*','stores.name as storeName',DB::raw('sum(product_request.product_qty) as totalQty'))
		->groupBy('request.id')
        ->orderBy('request.id','DESC')
		->get();
		
		
		
		return view('request.partials.tbodyOrders')->with('request',$request)->with('waiting_status','waiting');
	
	}
	
	
    public function showOrders($status,$userId=""){
		if($userId=="" or $userId=="all"){
			$request=DB::table('request')
		->leftjoin('country','country.country_id','request.customer_city')
		->where('request.is_active',1)
		->where('request.status','=',$status)
		->select('request.*','country.country as ccity')
		->orderBy('request.id','DESC')
		->get();
		}
		else{
			$request=DB::table('request')
		->leftjoin('country','country.country_id','request.customer_city')
		->where('request.is_active',1)
		->where('request.status','=',$status)
		->where('request.reference_id','=',$userId)
		->select('request.*','country.country as ccity')
		->orderBy('request.id','DESC')
		->get();
		}
		
		return view('request.partials.tbodyOrders')->with('request',$request)->with('waiting_status',$status);
	}
	
		
 
      public function rejectedRequests(){
	   $request=DB::table('request')
		->leftjoin('country','country.country_id','request.customer_city')
		->where('request.is_active',1)
		->where('request.status','rejected')
		->select('request.*','country.country as ccity')
		->orderBy('request.id','DESC')
		->get();
		
		return view('request.rejected')->with('request',$request);	
	}
	
	
	public function change_rejected_status($id, $fromStatus,$toStatus){
		if($toStatus=='delete'){
			$data['is_active']='0';
			DB::table('request')->where('id',$id)->update($data);
		}
		else if($toStatus=='waiting'){
			$data['status']='waiting';
			DB::table('request')->where('id',$id)->update($data);
		}
		return redirect('requests/rejected')->with('request_message','Operation Done Successfully');
	}

   public function chageRejectedOrders(Request $request){
	   $toStatus=$request->tostatus;
	   if($toStatus=='delete'){
			$data['is_active']='0';
		}
		else if($toStatus=='waiting'){
			$data['status']='waiting';
		}
		
	   
	   $orders=explode(',',$request->ids);
	   for($i=0; $i<count($orders)-1; $i++){
		   DB::table('request')->where('id',$orders[$i])->update($data);
	   }
	   
	  return redirect('requests/rejected')->with('request_message','Operation Done Successfully');
   }
	public function request_details($id){
		$requested=DB::table('request')->leftjoin('stores','stores.id','request.customer_store')->where('request.id',$id)->select('request.*','stores.name as storeName')->get()[0];
		$requestDetail=DB::table('product_request')
		    ->join('request','request.id','product_request.request_id')
			->join('products','products.id','product_request.product_id')
			->leftjoin('categories','categories.id','products.category_id')
			->where('request.id',$id)
			->select('request.*','products.image as itemphoto','products.external_link', 'product_request.*','categories.name as cateName','categories.parent_id as parentCategory')
			->get();
			
			return view('request.partials.details')->with('requestDetail',$requestDetail)->with('requested',$requested);
	
	}


   	 	public function change_status($id, $fromStatus, $toStatus){
		$data['status']=$toStatus;	
		DB::table('request')->where('id',$id)->update($data); 
		
		/*
		if($fromStatus=='waiting' and $toStatus=="rejected"){
			$data['status']=$toStatus;	
		    DB::table('request')->where('id',$id)->update($data); 
		}
		
		else if($fromStatus !='waiting' and $toStatus =='rejected'){
			$storeId=DB::table('request')->where('id',$id)->get()[0]->from_store; 
		    $orders=DB::table('product_request')->where('request_id',$id)->get();
		   
		     foreach($orders as $orderReject){
				$items=DB::table('product_store')->where('store_id',$storeId)->where('product_id',$orderReject->product_id);
                
				if(count($items->get())>0){
					$items->increment('qty',$orderReject->product_qty ); 
				 }	
                else{
				$insData['store_id']=$storeId;	
				$insData['product_id']=$orderReject->product_id;	
				$insData['qty']=$orderReject->product_qty ;	
				$insData['created_at']=date('Y-m-d h:i:s');	
				$insData['updated_at']=date('Y-m-d h:i:s');	
				  DB::table('product_store')->insert($insData);	
				}				 
		       
			 }
			 
			$rejectItem=DB::table('sales')->where('request_id',$id);			
			if($rejectItem->count()>0){
				$saleID=$rejectItem->get()[0]->id;
				$ref=$rejectItem->get()[0]->reference_no;
				DB::table('product_sales')->where('sale_id',$saleID)->delete();
				DB::table('sales')->where('id',$saleID)->delete();
				DB::table('item_movement')->where('type_invoice','sell')->where('reference',$ref)->delete();
				
			}
			
			$data['status']=$toStatus;
            $data['is_counted'] ='0'; 			
		   DB::table('request')->where('id',$id)->update($data); 
           //DB::table('sales')->where('request_id',$id)->delete();
		}
		   return redirect('requests')->with('request_message','The Request have been Rejected');
		*/
		
		}
	
	
 public function process_status($id){
		 $company=DB::table('company')->get();
		 $stores=DB::table('stores')->where('is_active','1')->get();
		return view('request.partials.processInfo')->with('company',$company)->with('requestId',$id)->with('stores',$stores);
	 }
	 

    
         public function change_status_to_process(Request $request){
		$requestId= $request->request_id; 
		/*
		 
		$store_id=$request->from_store; 
		
            $orders= DB::table('product_request')
		   ->join('products','products.id','product_request.product_id')
		   ->where('product_request.request_id',$requestId)
		   ->select('products.unit as punit','product_request.*');		
		$currentRequest=DB::table('request')->where('id',$requestId)->get()[0];
		
      
      // add online request to sale table  	  
	    $totalItem=$orders->sum('product_qty');
		$sitme=$orders->get()[0]->product_id; 
		$reference_number='sr-' . date("Ymd") . '-'. date("his");
	    $idata['user_id'] = Auth::id();
        $idata['date'] = date('Y-m-d');
		$idata['reference_no'] = $reference_number;
		$idata['payment_status'] = 2;
		$idata['customer_id'] = 1;
		$idata['store_id'] = $store_id;
		$idata['item'] = $sitme;
		$idata['total_qty'] = $totalItem;
		$idata['total_discount'] = '0';
		$idata['total_tax'] = '0';
		$idata['total_price'] = str_replace(",","",$currentRequest->subtotal);
		$idata['grand_total'] = str_replace(",","",$currentRequest->total);
		$idata['order_tax_rate'] = '0';
		$idata['order_tax'] = '0';
		$idata['order_discount'] = '0';
		$idata['shipping_cost'] = str_replace(",","",$currentRequest->shipping_cost);
		$idata['sale_status'] = 1;
		
		$idata['document'] = '';
		$idata['paid_amount'] = '0';
		$idata['sale_note'] = $currentRequest->order_note;
		$idata['staff_note'] = '';
		$idata['request_id'] = $requestId;
		$idata['created_at'] = date('Y-m-d h:i:s');
		$idata['updated_at'] = date('Y-m-d h:i:s');
		
	   DB::table('sales')->insert($idata);
	   $saleid = DB::getPdo()->lastInsertId();
	   
	   $orders=$orders->get();
	   foreach($orders as  $orderProcess){
           $rdata['sale_id']=$saleid;		   
           $rdata['product_id']=$orderProcess->product_id; 		   
           $rdata['qty']=$orderProcess->product_qty; 		   
           $rdata['unit']=$orderProcess->punit;		   
           $rdata['net_unit_price']=$orderProcess->product_price; 		   
           $rdata['discount']='0';		   
           $rdata['tax_rate']='0';		   
           $rdata['tax']='0';		   
           $rdata['total']=$orderProcess->product_qty*$orderProcess->product_price;	   
           $rdata['created_at']= date('Y-m-d h:i:s'); 		   
           $rdata['updated_at']= date('Y-m-d h:i:s');		   
		   
		   
		    $get_balance=DB::table('item_movement')->where('product_id',$orderProcess->product_id)->where('store_id',$store_id)->get();
			$total_in=$get_balance->sum('qty_in');
			$total_out=$get_balance->sum('qty_out');
			$balance=$total_in-$total_out;
			
		   $mdata['date']=date('Y-m-d');
		   $mdata['time']=date('h:i:s');
		   $mdata['user']=Auth::id();
		   $mdata['product_id']=$orderProcess->product_id;
		   $mdata['category_id']=DB::table('products')->where('id',$orderProcess->product_id)->get()[0]->category_id;
		   $mdata['store_id']=$store_id;
		   $mdata['qty_in']='0';
		   $mdata['qty_out']=$orderProcess->product_qty; 
		   $mdata['balance']=$balance-$orderProcess->product_qty;
		   $mdata['type_invoice']='sell';
		   $mdata['description']=$currentRequest->order_note;
		   $mdata['reference']=$reference_number;
		   
		   DB::table('product_sales')->insert($rdata);
		   DB::table('item_movement')->insert($mdata);
		   $items=DB::table('product_store')->where('store_id',$store_id)->where('product_id',$orderProcess->product_id);
	   
	       if(count($items->get())>0){
					$items->decrement('qty',$orderProcess->product_qty ); 
				 }	
                else{
				$insData['store_id']=$store_id;	
				$insData['product_id']=$orderProcess->product_id;	
				$insData['qty']=$orderProcess->product_qty ;	
				$insData['created_at']=date('Y-m-d h:i:s');	
				$insData['updated_at']=date('Y-m-d h:i:s');	
				  DB::table('product_store')->insert($insData);	
				}		
	          }
	   */
	   //$data['shipping_company']= $request->company; 		
       //$data['company_phone'] =$request->com_phone; 		
       //$data['company_note'] =$request->note;
	   
	   /* 
	   $orders=$orders->get();
	   foreach($orders as  $orderProcess){
		   $items=DB::table('product_store')->where('store_id',$store_id)->where('product_id',$orderProcess->product_id);
	   
	           if(count($items->get())>0){
					$items->decrement('qty',$orderProcess->product_qty ); 
				 }	
                else{
				$insData['store_id']=$store_id;	
				$insData['product_id']=$orderProcess->product_id;	
				$insData['qty']=-$orderProcess->product_qty ;	
				$insData['created_at']=date('Y-m-d h:i:s');	
				$insData['updated_at']=date('Y-m-d h:i:s');	
				  DB::table('product_store')->insert($insData);	
				}			
	   }
	   */
       $data['status'] ='process'; 
       //$data['from_store'] =$store_id; 
       $data['is_counted'] ='1'; 
       $data['paid_amount'] ='0'; 
	   
	   DB::table('request')->where('id',$requestId)->update($data); 
       return redirect('requests')->with('request_message','Change Status to Process Successfully');		
	}

	


	
	//change status of many orders
  public function changeOredersStatus(Request $request){
	 /*  
	    $fromStatus= $request->from_status;
	    $toStatus=$request->to_status;
		$ids= $request->ids;
		$paid_amount=$request->paid_amount;
		$store_id=DB::table('pos_setting')->where('id','1')->get()[0]->store_id;
		
		if($fromStatus==$toStatus){
		   return redirect()->back()->with('request_message','Select Deffirent Status');
		}
		
		
	   if( ($fromStatus=="waiting" or $fromStatus=="offer") and ($toStatus !='rejected'  and $toStatus !='offer' and $toStatus !='waiting') ){
		   $allids = explode(',' , $ids);
     for($i=0; $i<count($allids)-1; $i++){		
	   $orders= DB::table('product_request')
		   ->join('products','products.id','product_request.product_id')
		   ->where('product_request.request_id',$allids[$i])
		   ->select('products.unit as punit','product_request.*');		
		
      // add online request to sale table  	
        $pstatus=2;
		if($toStatus=="paid"){
			$pstatus=4;
		}
		$currentRequest=DB::table('request')->where('id',$allids[$i])->get()[0];	  
	    $totalItem=$orders->sum('product_qty');
		$sitme=$orders->get()[0]->product_id; 
		$reference_number='sr-' . date("Ymd") . '-'. date("his").rand(0,100);
	    $idata['user_id'] = Auth::id();
        $idata['date'] = date('Y-m-d');
		$idata['reference_no'] = $reference_number;
		$idata['payment_status'] = $pstatus;
		$idata['customer_id'] = 1;
		$idata['store_id'] = $store_id;
		$idata['item'] = $sitme;
		$idata['total_qty'] = $totalItem;
		$idata['total_discount'] = '0';
		$idata['total_tax'] = '0';
		$idata['total_price'] = str_replace(",","",$currentRequest->subtotal);
		$idata['grand_total'] = str_replace(",","",$currentRequest->total);
		$idata['order_tax_rate'] = '0';
		$idata['order_tax'] = '0';
		$idata['order_discount'] = '0';
		$idata['shipping_cost'] = str_replace(",","",$currentRequest->shipping_cost);
		$idata['sale_status'] = 1;
		
		$idata['document'] = '';
		$idata['paid_amount'] = $paid_amount;
		$idata['sale_note'] = $currentRequest->order_note;
		$idata['staff_note'] = '';
		$idata['request_id'] = $allids[$i];
		$idata['created_at'] = date('Y-m-d h:i:s');
		$idata['updated_at'] = date('Y-m-d h:i:s');
		
	   DB::table('sales')->insert($idata);
	   $saleid = DB::getPdo()->lastInsertId();
	   
	   $orders=$orders->get();
	   foreach($orders as  $orderProcess){
		   
           $rdata['sale_id']=$saleid;		   
           $rdata['product_id']=$orderProcess->product_id; 		   
           $rdata['qty']=$orderProcess->product_qty; 		   
           $rdata['unit']=$orderProcess->punit;;		   
           $rdata['net_unit_price']=$orderProcess->product_price; 		   
           $rdata['discount']='0';		   
           $rdata['tax_rate']='0';		   
           $rdata['tax']='0';		   
           $rdata['total']=$orderProcess->product_qty*$orderProcess->product_price;	   
           $rdata['created_at']= date('Y-m-d h:i:s'); 		   
           $rdata['updated_at']= date('Y-m-d h:i:s');		   
		   
		   
		    $get_balance=DB::table('item_movement')->where('product_id',$orderProcess->product_id)->where('store_id',$store_id);
			$total_in=$get_balance->sum('qty_in');
			$total_out=$get_balance->sum('qty_out');
			$balance=$total_in-$total_out;
			
		   $mdata['date']=date('Y-m-d');
		   $mdata['time']=date('h:i:s');
		   $mdata['user']=Auth::id();
		   $mdata['product_id']=$orderProcess->product_id;
		   $mdata['category_id']=DB::table('products')->where('id',$orderProcess->product_id)->get()[0]->category_id;
		   $mdata['store_id']=$store_id;
		   $mdata['qty_in']='0';
		   $mdata['qty_out']=$orderProcess->product_qty; 
		   $mdata['balance']=$balance-$orderProcess->product_qty;
		   $mdata['type_invoice']='sell';
		   $mdata['description']=$currentRequest->order_note;
		   $mdata['reference']=$reference_number;
		   
		   DB::table('product_sales')->insert($rdata);
		   DB::table('item_movement')->insert($mdata);
		   $items=DB::table('product_store')->where('store_id',$store_id)->where('product_id',$orderProcess->product_id);
	   
	       if(count($items->get())>0){
					$items->decrement('qty',$orderProcess->product_qty ); 
				 }	
                else{
				$insData['store_id']=$store_id;	
				$insData['product_id']=$orderProcess->product_id;	
				$insData['qty']=-$orderProcess->product_qty ;	
				$insData['created_at']=date('Y-m-d h:i:s');	
				$insData['updated_at']=date('Y-m-d h:i:s');	
				  DB::table('product_store')->insert($insData);	
				}		
	          }
		
		
       $data['status'] =$toStatus; 
       $data['from_store'] =$store_id; 
       $data['is_counted'] ='1'; 
       $data['paid_amount'] =$paid_amount; 
	   DB::table('request')->where('id',$allids[$i])->update($data);
			
		  }
	   }
       
	   
    else  if( ($fromStatus !="waiting" and $fromStatus !="offer") and ($toStatus=="waiting" or $toStatus=='rejected' or $toStatus=="offer") ){
		   $allids = explode(',' , $ids);
		   for($i=0; $i<count($allids)-1; $i++){
			//$storeId=DB::table('request')->where('id',$id)->get()[0]->from_store; 
		    $orders=DB::table('product_request')->where('request_id',$allids[$i])->get();
		     
		     foreach($orders as $orderReject){
				$items=DB::table('product_store')->where('store_id',$store_id)->where('product_id',$orderReject->product_id);
                
				if(count($items->get())>0){
					$items->increment('qty',$orderReject->product_qty ); 
				 }	
                else{
				$insData['store_id']=$store_id;	
				$insData['product_id']=$orderReject->product_id;	
				$insData['qty']=$orderReject->product_qty ;	
				$insData['created_at']=date('Y-m-d h:i:s');	
				$insData['updated_at']=date('Y-m-d h:i:s');	
				DB::table('product_store')->insert($insData);	
				}				 
		       
			 }
			
            $rejectItem=DB::table('sales')->where('request_id',$allids[$i]);			
			if($rejectItem->count()>0){
				$saleID=$rejectItem->get()[0]->id;
				$ref=$rejectItem->get()[0]->reference_no;
				DB::table('product_sales')->where('sale_id',$saleID)->delete();
				DB::table('sales')->where('id',$saleID)->delete();
				DB::table('item_movement')->where('type_invoice','sell')->where('reference',$ref)->delete();
				
			}
			$data['status']=$toStatus;
                        $data['is_counted'] ='0'; 
                       $data['paid_amount'] =$paid_amount; 			
		    DB::table('request')->where('id',$allids[$i])->update($data); 
			
			
		   }  
	     }	
       else{
		   $allids = explode(',' , $ids);
		   for($i=0; $i<count($allids)-1; $i++){
			  $updata['payment_status']=2; 
              if($toStatus=="paid"){
			    $updata['payment_status']=4;
			   }	
                    $updata['paid_amount'] = $paid_amount; 				
		    DB::table('sales')->where('request_id',$allids[$i])->update($updata);  
			  
              			  
		       $data['status']=$toStatus;
                       $data['paid_amount'] =$paid_amount; 
		      DB::table('request')->where('id',$allids[$i])->update($data);    
		   }
	   }
       	*/
		   $ids= $request->ids; 
           $allids = explode(',' , $ids);
		   $fromStatus= $request->from_status;
	       $toStatus=$request->to_status;
		   $paid_amount=$request->paid_amount;
		   
		   for($i=0; $i<count($allids)-1; $i++){
			  $updata['payment_status']=2; 
              if($toStatus=="paid"){
			    $updata['payment_status']=4;
			   }	
            //$updata['paid_amount'] = $paid_amount; 				
		    //DB::table('sales')->where('request_id',$allids[$i])->update($updata);    
              			  
		      $data['status']=$toStatus;
              $data['paid_amount'] =$paid_amount; 
			  
		      DB::table('request')->where('id',$allids[$i])->update($data);    
		   		
	   return redirect('requests')->with('request_message','Operation is done Successfully!');	 
	}
   }
 

  public function changePaidAmount(Request $request){
		$paid=$request->amount;
		$id=$request->req_id;
		
		DB::table('request')->where('id',$id)->update(['paid_amount'=>$paid]);
		$resutl=DB::table('sales')->where('request_id',$id)->update(['paid_amount'=>$paid]);
	   if($resutl){
		   return 1; 
	   }
	  
	}

    public function deleteOnlineRequest($id){
	  $sales=DB::table('sales')->where('request_id',$id);
	  
	  if($sales->count()>0){
		  $sale_id=$sales->get()[0]->id;
		  $sale_ref=$sales->get()[0]->reference_no;
		  $store_id=$sales->get()[0]->store_id;
		  
		  $orders=DB::table('product_request')->where('request_id',$id)->get();
		  
		  foreach($orders as $orderReject){
		   $items=DB::table('product_store')->where('store_id',$store_id)->where('product_id',$orderReject->product_id);
			 if(count($items->get())>0){
				 $items->increment('qty',$orderReject->product_qty ); 
			  }	
            else{
				$insData['store_id']=$store_id;	
				$insData['product_id']=$orderReject->product_id;	
				$insData['qty']=$orderReject->product_qty ;	
				$insData['created_at']=date('Y-m-d h:i:s');	
				$insData['updated_at']=date('Y-m-d h:i:s');	
				DB::table('product_store')->insert($insData);	
			}				   
			 }
			 
			 
		  DB::table('product_sales')->where('sale_id',$sale_id)->delete();
		  DB::table('sales')->where('request_id',$id)->delete();
		  DB::table('item_movement')->where('type_invoice','sell')->where('reference',$sale_ref)->delete();
	  }
	  
	  
	   DB::table('product_request')->where('request_id',$id)->delete();	     
	   DB::table('request')->where('id',$id)->delete();	     
		    
			 
	return redirect()->back()->with('request_message','the order is deleted successfully!');;  
	  
  }	

 public function PrintOnlineOrder($req_id){
   
      $data['order']=DB::table('request')->leftjoin('stores','stores.id','request.customer_store')->where('request.id',$req_id)->select('request.*','stores.name  as storeName')->get();

   $data['orderItems']=DB::table('product_request')->join('products','products.id','product_request.product_id')->leftjoin('categories','categories.id','products.category_id')->where('product_request.request_id',$req_id)->select('products.name','products.arabic_name','products.code as barcode','product_request.product_qty','product_request.product_price','categories.name as cateName','categories.parent_id as parentCategory')->get();
   
   return view('request.request_print')->withData($data);   
  
 }
 

 public function MarketerOrders(){
	 $branch=Auth::user()->branch_id;
	 $data['order']=DB::table('request')->where('is_marketer_order','1')->where('is_active','1')->get();
     $request=DB::table('request')
		->leftjoin('country','country.country_id','request.customer_city')
		->where('request.is_active',1)
		->where('is_marketer_order','1');
        if($branch!="Admin"){
	      $request=$request->where('request.branch_id',$branch);		
		}
		$request=$request->select('request.*','country.country as ccity')
        ->orderBy('request.id','DESC')->get();   
   return view('request.marketer_order')->with('request',$request);
 }

 
 
 
 
 
 
  public function getProduct()
    {
        $ezpos_product_store_data = DB::table('products')
            ->join('product_store', 'products.id', '=', 'product_store.product_id')->where('products.is_active', 1)->select('product_store.qty', 'products.code', 'products.name' ,'products.arabic_name')->groupBy('products.id')->get();
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
	
public function editMarketerRequest($id){
	    $ezpos_marketer_data =DB::table('request')->where('id',$id)->first();
        $ezpos_product_marketer_data = DB::table('product_request')->where('request_id',$id)->get();
        $ezpos_store_list = Store::where('is_active', true)->get();
       return view('request.edit_marketer_order', compact('ezpos_marketer_data', 'ezpos_store_list', 'ezpos_product_marketer_data'));
}

public function updateMarketerRequest(Request $request,$id){
	//echo $id; exit();
       $data = $request->except('document');       
        $ezpos_marketer_data = DB::table('request')->where('id',$id)->first();
       $ezpos_product_marketer_data = DB::table('product_request')->where('request_id',$id)->delete();
        $product_id = $data['product_id'];
        $qty = $data['qty'];
       // $cdate = date('Y-m-d',$request->date);
		
		//echo $cdate;exit();
		foreach($product_id as $key=>$pr){
			$pro= Product::find($pr);
           	$pdata['product_id'] =$pr;
           	$pdata['request_id']=$id;
           	$pdata['product_qty']=$qty[$key];
           	$pdata['product_name']=$pro->name;
           	$pdata['product_price']=0;
    		$d=DB::table('product_request')->insert($pdata);
            
		}
		$rdata['marketer_note']=$request->note;
		//$rdata['created_at']=$cdate;
		//$rdata['updated_at']=$cdate;
		DB::table('request')->where('id',$id)->update($rdata);
       return redirect('sale/marketer_orders')->with('message', 'Data updated successfully');
}
public function deleteMarketerRequest($id){
	DB::table('request')->where('id',$id)->delete();
    DB::table('product_request')->where('request_id',$id)->delete();
         
	return redirect('sale/marketer_orders')->with('message', 'Data deleted successfully');
}

 public function OrderArchive(){
 	$user_role=Auth::user()->role_id;
 	$branch=Auth::user()->branch_id;
 	//echo $user_role;
	 $orders=DB::table('adjustments')
	          ->join('stores','stores.id','adjustments.store_id')
	          ->leftjoin('users','users.id','adjustments.user_id');
			  //->groupBy('adjustments.reference')
			if($user_role==9 ){
               $orders=$orders->where('adjustments.is_checked','0');
			} 
			if($branch!="Admin"){
				$orders=$orders->where('adjustments.branch_id',$branch);
			}
			$data['orders']=$orders->select('adjustments.*','stores.name as storeName','users.name as userName')
			  ->get();
     return view('order.all_orders')->withData($data);			  
 }

public function OrderChangeStatsu($id){
		
	DB::table('adjustments')->where('id',$id)->update(['is_checked'=>'1']);
	return back();
}


 public function OrderArchiveDetails(Request $request){
	 $id=$request->id; 
	 $data['order']=DB::table('adjustments')
	 ->join('stores','stores.id','adjustments.store_id')
	 ->where('adjustments.id',$id)
	 ->select('adjustments.*','stores.name as storeName')
	 ->get();
	 
	 
	 $data['products']=DB::table('product_adjustments')
	 ->join('products','products.id','product_adjustments.product_id')
	 ->leftjoin('categories','categories.id','products.category_id')
	 ->where('product_adjustments.adjustment_id',$id)
	 ->select('product_adjustments.*','products.name as prName','categories.name as cateName','categories.parent_id as parentCategory')
	 ->get();
	 
	 return view('order.all_order_detail')->withData($data);
 }
 
public function notSalesStore(){
	$branch=Auth::user()->branch_id;
	$data['stores']=DB::table('stores')->where('is_active',1);
	if($branch!="Admin"){
      $data['stores']=$data['stores']->where('branch_id',$branch);
    }
    $data['stores']=$data['stores']->get();
	return view('store.not_sale_stores')->withData($data);
}
}

?>
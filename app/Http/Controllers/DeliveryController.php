<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Sale;
use App\Delivery;
use DB;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;

class DeliveryController extends Controller
{
	public function index()
	{
		$ezpos_delivery_all = Delivery::all();
		return view('delivery.index', compact('ezpos_delivery_all'));
	}
    public function create($id){
    	$ezpos_delivery_data = Delivery::where('sale_id', $id)->first();
        $requestedID=DB::table('sales')->where('id',$id)->get()[0]->request_id; 

    	if($ezpos_delivery_data){
    		$customer_sale = DB::table('sales')->join('customers', 'sales.customer_id', '=', 'customers.id')->where('sales.id', $id)->select('sales.reference_no','customers.name')->get();

    		$delivery_data[] = $ezpos_delivery_data->reference_no;
    		$delivery_data[] = $customer_sale[0]->reference_no;
    		$delivery_data[] = $ezpos_delivery_data->status;
    		$delivery_data[] = $ezpos_delivery_data->delivered_by;
    		$delivery_data[] = $ezpos_delivery_data->recieved_by;
    		if($requestedID != ""){
                     $delivery_data[] =trans('file.online')." ".trans('file.request')." ".DB::table('request')->where('id',$requestedID)->get()[0]->customer_name; 	
		     $delivery_data[]='';
		   }
	        else{
		$delivery_data[] = $customer_sale[0]->name;
                $delivery_data[] = $ezpos_delivery_data->address;			  
		}
    		$delivery_data[] = $ezpos_delivery_data->note;
            $delivery_data[] = date('d-m-Y', strtotime($ezpos_delivery_data->date));
    	}
    	else{
    		$customer_sale = DB::table('sales')->join('customers', 'sales.customer_id', '=', 'customers.id')->where('sales.id', $id)->select('sales.reference_no','customers.name', 'customers.address', 'customers.city', 'customers.country')->get();

    		$delivery_data[] = 'dr-' . date("Ymd") . '-'. date("his");
    		$delivery_data[] = $customer_sale[0]->reference_no;
    		$delivery_data[] = '';
    		$delivery_data[] = '';
    		$delivery_data[] = '';
    		if($requestedID != ""){
	        $delivery_data[] = trans('file.online')." ".trans('file.request')." ".DB::table('request')->where('id',$requestedID)->get()[0]->customer_name; 	
	      $delivery_data[]='';
	        }
	       else{
    		  $delivery_data[] = $customer_sale[0]->name;
    		  $delivery_data[] = $customer_sale[0]->address.' '.$customer_sale[0]->city.' '.$customer_sale[0]->country;			
		}
    		$delivery_data[] = '';
            $delivery_data[] = date('d-m-Y');
    	}        
    	return $delivery_data;
    }

    public function store(Request $request)
    {
    	$data = $request->except('file');
        //return $data;
    	$delivery = Delivery::firstOrNew(['reference_no' => $data['reference_no'] ]);
         
           $requestStatus=$request->sale_id;
	   $result= DB::table('sales')->where('id',$requestStatus)->get()[0]->request_id;
	  
          if($result !=""){
	       if($request->status=="packing"){
	            $sdata['status']='pickup';
		   } 	
           else if($request->status=="delivering"){
	             $sdata['status']='pickup';
		   }	
         else if($request->status=="delivered"){
	           $sdata['status']='delivered';
		 }		   
		   DB::table('request')->where('id',$result)->update($sdata);	
		}	 
        
    	$document = $request->file;
        if ($document) {
            $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = $data['reference_no'] . '.' . $ext;
            $document->move('public/documents/delivery', $documentName);
            $delivery->file = $documentName;
        }
        $delivery->date = date('Y-m-d', strtotime($data['date']));
        $delivery->sale_id = $data['sale_id'];
        $delivery->address = $data['address'];
        $delivery->delivered_by = $data['delivered_by'];
        $delivery->recieved_by = $data['recieved_by'];
        $delivery->status = $data['status'];
        $delivery->note = $data['note'];
        $delivery->save();
        $ezpos_sale_data = Sale::find($data['sale_id']);
        $ezpos_customer_data = Customer::find($ezpos_sale_data->customer_id);
        if($ezpos_customer_data->email && $data['status'] != 'packing'){
            $mail_data['email'] = $ezpos_customer_data->email;
            $mail_data['customer'] = $ezpos_customer_data->name;
            $mail_data['sale_reference'] = $ezpos_sale_data->reference_no;
            $mail_data['delivery_reference'] = $delivery->reference_no;
            $mail_data['status'] = $data['status'];
            $mail_data['address'] = $data['address'];
            $mail_data['delivered_by'] = $data['delivered_by'];
           /*
            Mail::send( 'mail.delivery_details', $mail_data, function( $message ) use ($mail_data)
            {
                $message->to( $mail_data['email'] )->subject( 'Delivery Details' );
            });
          */
        }
        return redirect('delivery')->with('message', 'Delivery created successfully');
    }

    public function edit($id)
    {
    	$ezpos_delivery_data = Delivery::find($id);
    	$customer_sale = DB::table('sales')->join('customers', 'sales.customer_id', '=', 'customers.id')->where('sales.id', $ezpos_delivery_data->sale_id)->select('sales.reference_no','customers.name')->get();

    	$delivery_data[] = $ezpos_delivery_data->reference_no;
		$delivery_data[] = $customer_sale[0]->reference_no;
		$delivery_data[] = $ezpos_delivery_data->status;
		$delivery_data[] = $ezpos_delivery_data->delivered_by;
		$delivery_data[] = $ezpos_delivery_data->recieved_by;
		$delivery_data[] = $customer_sale[0]->name;
		$delivery_data[] = $ezpos_delivery_data->address;
		$delivery_data[] = $ezpos_delivery_data->note;
        $delivery_data[] = date('d-m-Y', strtotime($ezpos_delivery_data->date));
    	return $delivery_data;
    }

    public function update(Request $request)
    {
    	$input = $request->except('file');
        $input['date'] = date('Y-m-d', strtotime($input['date']));
    	$ezpos_delivery_data = Delivery::find($input['delivery_id']);
    	$document = $request->file;
        
         
	$saledID=$ezpos_delivery_data->sale_id; 
	$requestedID=DB::table('sales')->where('id',$saledID)->get()[0]->request_id;
		
		 

        if ($document) {
            $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = $input['reference_no'] . '.' . $ext;
            $document->move('public/documents/delivery', $documentName);
            $input['file'] = $documentName;
        }
    	$ezpos_delivery_data->update($input);
    
          if( $requestedID !=""){
	     if($request->status=="packing"){
	         $sdata['status']='pickup';
	     } 	
           else if($request->status=="delivering"){
		   $sdata['status']='pickup';
	        }	
           else if($request->status=="delivered"){
		 $sdata['status']='delivered';
     	      }		   
			$requestID=DB::table('request')->where('id',$requestedID)->update($sdata); 
	}   
 
        $ezpos_sale_data = Sale::find($ezpos_delivery_data->sale_id);
        $ezpos_customer_data = Customer::find($ezpos_sale_data->customer_id);
        if($ezpos_customer_data->email && $input['status'] != 'packing'){
            $mail_data['email'] = $ezpos_customer_data->email;
            $mail_data['customer'] = $ezpos_customer_data->name;
            $mail_data['sale_reference'] = $ezpos_sale_data->reference_no;
            $mail_data['delivery_reference'] = $ezpos_delivery_data->reference_no;
            $mail_data['status'] = $input['status'];
            $mail_data['address'] = $input['address'];
            $mail_data['delivered_by'] = $input['delivered_by'];
       /*   
         Mail::send( 'mail.delivery_details', $mail_data, function( $message ) use ($mail_data)
            {
                $message->to( $mail_data['email'] )->subject( 'Delivery Details' );
            });
       */

        }
    	return redirect('delivery')->with('message', 'Delivery updated successfully');
    }

    public function delete($id)
    {
    	$ezpos_delivery_data = Delivery::find($id);
    	$ezpos_delivery_data->delete();
    	return redirect('delivery')->with('not_permitted', 'Delivery deleted successfully');
    }
}

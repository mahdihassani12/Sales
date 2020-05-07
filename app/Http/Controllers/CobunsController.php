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
use \Cart as Cart;
use App\Product;
use App\Company;
use App\Product_Store;
use App\Product_Supplier;
use Auth;
use DNS1D;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class CobunsController extends Controller
{
	function index(){
	   $data['cobun']=DB::table('cobuns')->where('status','1')->get();
	   $data['category']=DB::table('categories')->where('is_active','1')->get();
	   return view('cobun.index')->withData($data);
	   
	}
	function create(Request $request){
		
	  $array = array(  
            'cobun_no'  => 'required',  
            'number_of_use'  => 'required',    
        ); 
		
		;
		
        $this->validate($request, $array);
		
	    
	    //if(!empty($request->selected_category)){
		//	$ins_data['categories']= implode("-",$request->selected_category);
		// }   
		//else {
			
		//}
		
		$ins_data['categories']='';
	    $ins_data['cobun_number']=$request->cobun_no;
	    $ins_data['number_of_use']=$request->number_of_use;
	    //$ins_data['value']=$request->discount_value;
	    $ins_data['status']='1';
	    $ins_data['expire_date']=$request->expire_date;
	    
		
		$category=DB::table('categories')->where('is_active','1')->get();
		foreach($category as $ct ){
			$cat='coupon_categories_'.$ct->id;
			
			$ins_data1['copupon']=$request->cobun_no;
			$ins_data1['category']=$ct->id;
			$ins_data1['value']=$request->$cat;
			if($request->$cat==null){
			  $ins_data1['value']=0;	
			}
		   DB::table('coupon_category')->insert($ins_data1);	
		}
		
		
	
		DB::table('cobuns')->insert($ins_data);
	   return redirect()->back()->with('create_message', 'Cobun created successfully');
	}
	
	function delete($id){
		    $data['status']='0';
			DB::table('cobuns')->where('id',$id)->update($data);
			$cno=DB::table('cobuns')->where('id',$id)->get()[0]->cobun_number;
		    DB::table('coupon_category')->where('copupon',$cno)->delete();
			
	       return redirect()->back()->with('message', 'Cobun deleted successfully');
	}
	
	function edit($id){
		$data['coupon']=DB::table('cobuns')->where('id',$id)->get()[0];
        $data['category']=DB::table('categories')->where('is_active','1')->get();
       return view('cobun.partial.edit')->withData($data);		
	}
	
	function update(Request $request){
			$array = array(  
            'cobun_no'  => 'required',  
            'number_of_use'  => 'required',    
               
        ); 
        $this->validate($request, $array);
		
	     // if(!empty($request->selected_category)){
		//	$ins_data['categories']= implode("-",$request->selected_category);
		 //}   
		//else {
		//}
		
	    $ins_data['cobun_number']=$request->cobun_no;
	    $ins_data['number_of_use']=$request->number_of_use;
	    //$ins_data['value']=$request->discount_value;
	    $ins_data['expire_date']=$request->expire_date;
	    
		$cid=$request->coupon_id;
		$cno=DB::table('cobuns')->where('id',$cid)->get()[0]->cobun_number;
		
		DB::table('coupon_category')->where('copupon',$cno)->delete();
		
		$category=DB::table('categories')->where('is_active','1')->get();
		foreach($category as $ct ){
			$cat='coupon_categories_'.$ct->id;
			
			$ins_data1['copupon']=$request->cobun_no;
			$ins_data1['category']=$ct->id;
			$ins_data1['value']=$request->$cat;
			if($request->$cat==null){
			  $ins_data1['value']=0;	
			}
		   DB::table('coupon_category')->insert($ins_data1);	
		}
		
		
	
		DB::table('cobuns')->where('id',$cid)->update($ins_data);
	   return redirect()->back()->with('edit_message', 'Cobun Updated successfully');
	}
	
	public function checkCobun($id){
		$result=DB::table('cobuns')->where('cobun_number',$id);
		if($result->count()>0){
			if($result->get()[0]->number_of_use<=0){
				return "zero";	
			}
			else{
				$discountCat=explode('-',$result->get()[0]->categories);
				
				$discountValue=0;
				foreach( Cart::content() as $item){
					$presult=DB::table('products')->where('id',$item->id)->get();
					for($i=0; $i<count($discountCat); $i++){	
					    if($presult[0]->category_id==$discountCat[$i]){
						  $discountValue=$discountValue+$presult[0]->price*$item->qty*$result->get()[0]->value/100;
						  break;
					    }
					}
				}
				
				 
				//echo Cart::subtotal().'-'.$discountValue;
				return number_format(str_replace( ',', '', Cart::subtotal() ), 2, '.', '')-$discountValue;
               				
			}
		}
		else{
			return 'not_exist';
		}
	}


public function checkGeneratedCoupon($num){
		$result=DB::table('cobuns')->where('cobun_number',$num);
		if($result->count()>0){
		  	$newCopoun=rand(10000000,90000000);
			return $newCopoun;
		}
		else{
			return $num;
		}
	}

	
}

?>
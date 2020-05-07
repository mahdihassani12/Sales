<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Keygen;
use DB;

use Auth;
use DNS1D;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class PincodeController extends Controller
{
		public function PincodeList(){
			
		  $data['pincode']=DB::table('pincode')->join('users','users.id','pincode.user_inserted')->select('pincode.*','users.name as user_added')->get();
		return view('pincode.pincodes')->withData($data);
	}
	
	
	
	public function createPincode(Request $request){
		$array = array(  
            'pincode_no'  => 'required',  
            'amount'  => 'required'
        ); 
        $this->validate($request, $array);
		
		     $cdata['date'] = date('Y-m-d');
		     $cdata['time'] = date('h:i:s');
		     $cdata['number'] = $request->pincode_no;
            $cdata['amount'] = $request->amount;
            $cdata['user_owner'] = $request->user_owner;
            $cdata['software_name'] = $request->software_name;
            $cdata['status_done'] = $request->status_done;
            $cdata['status_used'] = $request->status_used;
            $cdata['notes'] = $request->note;
            $cdata['user_inserted'] = Auth::user()->id;
			
		 DB::table('pincode')->insert($cdata);
        return redirect('pincode/list')->with('create_message', 'Pincode created successfully');     
	}

        public function deletePincode($id){
		DB::table('pincode')->where('id',$id)->delete();
	    return redirect('pincode/list')->with('message', 'Pincode deleted successfully');     
	}
	
	public function edit($id){
		$data['pincode']=DB::table('pincode')->where('id',$id)->get()[0];
		return view('pincode.partials.edit')->withData($data);
	}
	
	public function updatePincode(Request $request){
		$array = array(  
            'pincode_no'  => 'required',  
            'amount'  => 'required'
        ); 
        $this->validate($request, $array);
		
		     $cdata['number'] = $request->pincode_no;
            $cdata['amount'] = $request->amount;
            $cdata['user_owner'] = $request->user_owner;
            $cdata['software_name'] = $request->software_name;
            $cdata['status_done'] = $request->status_done;
            $cdata['status_used'] = $request->status_used;
            $cdata['notes'] = $request->note;
            $id=$request->pinid;
			
		 DB::table('pincode')->where('id',$id)->update($cdata);
        return redirect('pincode/list')->with('create_message', 'Pincode updated successfully');   
	}
	
	public function changePinStatus(Request $request){
		$type=$request->type;
	    $value=$request->value;
		$pinid=$request->pinid;
		if($type=="done"){
		   $data['status_done']=$value;	
		}
		if($type=="used"){
		  $data['status_used']=$value;
		}
		DB::table('pincode')->where('id',$pinid)->update($data);
		
		return redirect('pincode/list')->with('create_message', 'Pincode statuc is changed!');
	}
}

?>
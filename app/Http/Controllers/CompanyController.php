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

class CompanyController extends Controller
{
	public function createCompany(){
		return view('company.create');
	}
	
	public function add_company(Request $request){
		     
			$array = array(  
            'name'  => 'required',  
            'username'  => 'required',  
            'password'  => 'required',  
            'mail'  => 'required',   
        ); 
        $this->validate($request, $array);
		
		     $cdata['name'] = $request->name;
            $cdata['address'] = $request->address;
            $cdata['username'] = $request->username;
            $cdata['password'] = $request->password;
            $cdata['email'] = $request->mail;
            $cdata['phone'] = $request->phone;
            $cdata['extra1'] = $request->extra1;
            $cdata['extra2'] = $request->extra2;
            $cdata['extra3'] = $request->extra3;
			
			DB::table('company')->insert($cdata);
          
        return redirect('company/create')->with('create_message', 'Company created successfully');;     
	}
	
	public function all_company(){
		$company=DB::table('company')->get();
		return view('company.index')->with('company',$company);
	}
	
	public function delete_company($id){
		DB::table('company')->where('company_id',$id)->delete();
	    return redirect('company/all')->with('message', 'Company deleted successfully');     
	}
	
	public function edit_company($id){
		$company=DB::table('company')->where('company_id',$id)->get();
		return view('company.edit')->with('company',$company);
	}
	
	public function update_company(Request $request){
		$id=$request->com_id;
		$bdata['name']=$request->name;
		$bdata['address']=$request->address;
		$bdata['username']=$request->username;
		$bdata['email']=$request->mail;
		$bdata['phone']=$request->phone;
		$bdata['extra1']=$request->extra1;
		$bdata['extra2']=$request->extra2;
		$bdata['extra3']=$request->extra3;
		
		DB::table('company')->where('company_id',$id)->update($bdata);
	 return redirect('company/all')->with('edit_message', 'Company updated successfully');     
	}
}

?>
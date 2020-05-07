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

class CountryController extends Controller
{
	public function createCountry(){
		$company=DB::table('company')->get();
		return view('country.create')->with('company',$company);
	}
	public function add_country(Request $request){
		     
			$array = array(  
            'name'  => 'required',  
            'shipping_cost'  => 'required',  
            'shipping_sale'  => 'required',  
            'company'  => 'required',   
        ); 
        $this->validate($request, $array);
		
		     $cdata['country'] = $request->name;
            $cdata['cost_shiping'] = $request->shipping_cost;
            $cdata['sale_shipping'] = $request->shipping_sale;
            $cdata['company_id'] = $request->company;
			
			DB::table('country')->insert($cdata);
          
        return redirect('country/create')->with('create_message', 'Country created successfully');     
	}
	
	public function all_country(){
		$country=DB::table('country')->get();
		return view('country.index')->with('country',$country);
	}
	
	public function delete_country($id){
		DB::table('country')->where('country_id',$id)->delete();
	    return redirect('country/all')->with('message', 'Country deleted successfully');     
	}
	
	public function edit_country($id){
		$country=DB::table('country')->where('country_id',$id)->get();
		$company=DB::table('company')->get();
		return view('country.edit')->with('country',$country)->with('company',$company);
	}
	public function update_country(Request $request){
	    $id=$request->coun_id;
		$bdata['country']=$request->name;
		$bdata['cost_shiping']=$request->shipping_cost;
		$bdata['sale_shipping']=$request->shipping_sale;
		$bdata['company_id']=$request->company;
		
		
		DB::table('country')->where('country_id',$id)->update($bdata);
	 return redirect('country/all')->with('edit_message', 'Company updated successfully');	
	}
}

?>
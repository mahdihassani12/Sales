<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\StoreCategory;
use Illuminate\Validation\Rule;
use Keygen;
use Auth;
use Spatie\Permission\Models\Role;
use DB;


class StoreController extends Controller
{

    public function index()
    {
	  $branch = Auth::user()->branch_id; 	
	  $role = Role::find(Auth::user()->role_id);
	  
	     $branches=DB::table('branches')->where('is_active',true)->get();
        if($role->hasPermissionTo('store_setting')){	 
        $ezpos_store_all = Store::where('is_active', true);
		if($branch!="Admin"){
		 $ezpos_store_all=$ezpos_store_all->where('branch_id',$branch);	
		}
		$ezpos_store_all=$ezpos_store_all->get();
        $ezpos_store_category_all = StoreCategory::where('is_active', true);
		if($branch!="Admin"){
		$ezpos_store_category_all =$ezpos_store_category_all->where('branch_id',$branch);	
		}
		$ezpos_store_category_all =$ezpos_store_category_all->get();
        return view('store.create', compact('ezpos_store_all','ezpos_store_category_all','branches','branch'));
		}
    else
    return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');	
    }

    public function store(Request $request)
    {
       if($request->branch and $request->branch !=""){
		  $branch=$request->branch; 
	   }
	   else{
	      $branch = Auth::user()->branch_id; 
	   }
		$this->validate($request, [
            'name' => [
                'max:255',
                    Rule::unique('stores')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $category=$request->store_category_id;
       // $selectedCat="";
       // for($i=0; $i<count($request->store_category_id); $i++):
        //   $selectedCat.=$category[$i]."-";
        //endfor;

        // $selectedCat=substr($selectedCat, 0, -1);

        $input = $request->all();
        $input['is_active'] = true;
        $input['branch_id'] = $branch;
       // $input['store_category_id'] = $selectedCat;
        store::create($input);
		$storeId=DB::table('stores')->orderBy('id','DESC')->limit(1)->get()[0]->id; 
        $products=DB::table('products')->where('is_active','1');
		//if($branch!="Admin"){
		$products=$products->where('branch_id',$branch);	
		//}
		$products=$products->get();
		foreach( $products as $pro){
			$jdata['product_id']=$pro->id;
			$jdata['store_id']=$storeId;
			$jdata['qty']=0;
            $jdata['created_at']=date('Y-m-d h:i:s');
			$jdata['updated_at']=date('Y-m-d h:i:s');
			DB::table('product_store')->insert($jdata);
		}
		return redirect('store')->with('message', 'Data inserted successfully');
    }

	
    public function edit($id)
    {
        $ezpos_store_data = store::findOrFail($id);
        return $ezpos_store_data;
    }
   
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                    Rule::unique('stores')->ignore($request->store_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);


      //  $category=$request->store_category_id;
      //  $selectedCat="";
      //  for($i=0; $i<count($request->store_category_id); $i++):
       //    $selectedCat.=$category[$i]."-";
       // endfor;

         //$selectedCat=substr($selectedCat, 0, -1);

        $input = $request->all();
        //$input['store_category_id'] = $selectedCat;
        $ezpos_store_data = store::find($input['store_id']);
        $ezpos_store_data->update($input);
        return redirect('store')->with('message', 'Data updated successfully');
    }

    public function importstore(Request $request)
    {
        //get file
        $upload=$request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if($ext != 'csv')
            return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
        $filename =  $upload->getClientOriginalName();
        $upload=$request->file('file');
        $filePath=$upload->getRealPath();
        //open and read
        $file=fopen($filePath, 'r');
        $header= fgetcsv($file);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        //looping through othe columns
        while($columns=fgetcsv($file))
        {
            if($columns[0]=="")
                continue;
            foreach ($columns as $key => $value) {
                $value=preg_replace('/\D/','',$value);
            }
           $data= array_combine($escapedHeader, $columns);

           $store = store::firstOrNew([ 'name'=>$data['name'], 'is_active'=>true ]);
           $store->name = $data['name'];
           $store->phone = $data['phone'];
           $store->email = $data['email'];
           $store->address = $data['address'];
           $store->is_active = true;
           $store->save();
        }
        return redirect('store')->with('message', 'store imported successfully');
        
    }

    public function destroy($id)
    {
        $ezpos_store_data = store::find($id);
        $ezpos_store_data->is_active = false;
        $ezpos_store_data->save();
        return redirect('store')->with('not_permitted', 'Data deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StoreCategory;
use Illuminate\Validation\Rule;
use Keygen;
use Auth;
use Spatie\Permission\Models\Role;
use DB;


class StoreCategoryController extends Controller
{

    public function index()
    {

	  $role = Role::find(Auth::user()->role_id);
	  $branch = Auth::user()->branch_id;
        if($role->hasPermissionTo('store_setting')){	 
        $ezpos_store_category_all = StoreCategory::where('is_active', true);
		if($branch!="Admin"){
		 $ezpos_store_category_all=$ezpos_store_category_all->where('branch_id',$branch);	
		}
		$ezpos_store_category_all=$ezpos_store_category_all->get();
        return view('stsore_category.index', compact('ezpos_store_category_all'));
		}
    else
    return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');	
    }

    public function store(Request $request)
    {
        $branch = Auth::user()->branch_id;
        $this->validate($request, [
            'name' => [
                'max:255',
                    Rule::unique('store_category')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);
        $input = $request->all();

        $input['is_active'] = true;
        $input['branch_id'] = $branch;
        StoreCategory::create($input);

	
		return redirect('store_category')->with('message', 'Data inserted successfully');
    }

	
    public function edit($id)
    {
        $ezpos_store_data = StoreCategory::findOrFail($id);
        return $ezpos_store_data;
    }
   
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                    Rule::unique('store_category')->ignore($request->store_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);
        $input = $request->all();
        $ezpos_store_data = StoreCategory::find($input['store_category_id']);
        $ezpos_store_data->update($input);
        return redirect('store_category')->with('message', 'Data updated successfully');
    }

   

    public function destroy($id)
    {
        $ezpos_store_data = StoreCategory::find($id);
        $ezpos_store_data->is_active = false;
        $ezpos_store_data->save();
        return redirect('store_category')->with('not_permitted', 'Data deleted successfully');
    }
}

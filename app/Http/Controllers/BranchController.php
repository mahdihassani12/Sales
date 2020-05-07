<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product_Store;
use App\Product;
use App\Adjustment;
use App\Branch;
use Illuminate\Validation\Rule;
use Auth;
use DB;
use Excel; 
use Spatie\Permission\Models\Role;

class BranchController extends Controller
{
	
	public function index(){
		$role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('branch-index')){	 
        $ezpos_branch_all = Branch::where('is_active',true)->orderBy('id', 'desc')->get();
		$permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
        return view('branch.index', compact('ezpos_branch_all','all_permission'));
		}
		else
		return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');	
	}
	
	public function store(Request $request){
		
		$this->validate($request, [
            'name' => [
                'max:255',
                    Rule::unique('branches')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
				'required'
            ],	
        ]);
        $input['name'] = $request->name;
        $input['phone'] = $request->phone;
        $input['email'] = $request->email;
        $input['address'] = $request->address;
        $input['is_active'] = true;
		//print_r($input); exit();
        
        DB::table('branches')->insert($input);
	
		return redirect('branch')->with('message', 'Data inserted successfully');
	}

	public function update(Request $request){
		
		$id=$request->id;
		$data['name']=$request->name;
		$data['phone']=$request->phone;
		$data['email']=$request->email;
		$data['address']=$request->address;
	   
	    DB::table('branches')->where('id',$id)->update($data);
        return redirect('branch')->with('message', 'Data updated successfully');
    
	}
	public function destroy($id){
        DB::table('branches')->where('id',$id)->update(['is_active'=>false]);
        return redirect('branch')->with('message', 'Data deleted successfully');
    
	}
	}	

?>
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Roles;
use App\Store;
use App\Branch;
use Auth;
use Hash;
use Keygen;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        $branch = Auth::user()->branch_id;
		
        if($role->hasPermissionTo('users-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
				
		 		
            $ezpos_user_list = User::where('is_deleted', false);
			if($branch!="Admin"){
			 $ezpos_user_list=$ezpos_user_list->where('branch_id',$branch);	
			}
			$ezpos_user_list=$ezpos_user_list->get();
            return view('user.index', compact('ezpos_user_list', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        $branch = Auth::user()->branch_id;
		
        if($role->hasPermissionTo('users-add')){
            $ezpos_role_list = Roles::where('is_active', true);if($branch!="Admin"){$ezpos_role_list=$ezpos_role_list->where('id','!=',2)->where('id','!=',11);} $ezpos_role_list=$ezpos_role_list->get();
            $ezpos_store_list = Store::where('is_active', true);if($branch!="Admin"){$ezpos_store_list=$ezpos_store_list->where('branch_id',$branch);} $ezpos_store_list=$ezpos_store_list->get();
            $ezpos_branch_list = Branch::where('is_active', true)->get();
            return view('user.create', compact('ezpos_branch_list','ezpos_role_list', 'ezpos_store_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function generatePassword()
    {
        $id = Keygen::numeric(6)->generate();
        return $id;
    }

    public function store(Request $request)
    {
		$branch_id=Auth::user()->branch_id;
        $this->validate($request, [
            'name' => [
                'max:255',
                    Rule::unique('users')->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ],
            'email' => [
                'email',
                'max:255',
                    Rule::unique('users')->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ],
        ]);

        $data = $request->all();
        /*
        Mail::send( 'mail.user_details', $data, function( $message ) use ($data)
        {
            $message->to( $data['email'] )->subject( 'User Account Details' );
        });
      */

        if(!isset($data['is_active']))
            $data['is_active'] = false;
        $data['is_deleted'] = false;
        $data['password'] = bcrypt($data['password']);

        $stores= $request->store_id;
	    $data['branch_id']=$branch_id;
         if($stores!=null and $stores!=""){	
		  $data['store_id']= implode("-" , $stores);
	    }
		if(isset($request->branch_id) and $request->branch_id!=null and $request->branch_id!=""){
		 $data['branch_id']=$request->branch_id;	
		}
         User::create($data);
        return redirect('user')->with('message1', 'Data inserted successfullly'); 
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        $branch = Auth::user()->branch_id;
        if($role->hasPermissionTo('users-edit')){
            $ezpos_user_data = User::find($id);
            $ezpos_role_list = Roles::where('is_active', true);if($branch!="Admin"){$ezpos_role_list=$ezpos_role_list->where('id','!=',2)->where('id','!=',11);} $ezpos_role_list=$ezpos_role_list->get();
            $ezpos_store_list = Store::where('is_active', true);if($branch !="Admin"){$ezpos_store_list=$ezpos_store_list->where('branch_id',$branch);} $ezpos_store_list=$ezpos_store_list->get();
            $ezpos_branch_list = Branch::where('is_active', true)->get();
			return view('user.edit', compact('ezpos_branch_list','ezpos_user_data', 'ezpos_role_list', 'ezpos_store_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        //return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('users')->ignore($id)->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ],
            'email' => [
                'email',
                'max:255',
                    Rule::unique('users')->ignore($id)->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ],
        ]);

        $input = $request->except('password');
        //return dd($input);
        if(!isset($input['is_active']))
            $input['is_active'] = false;
        if(!empty($request['password']))
            $input['password'] = bcrypt($request['password']);
         
          
		 
		 $stores= $request->store_id;
         if($stores!=null and $stores!=""){	
		    $data['store_id']= implode("-" , $stores);
	      }

        $ezpos_user_data = User::find($id);
        $ezpos_user_data->update($input);
        return redirect('user')->with('message2', 'Data updated successfullly');
    }

    public function profile($id)
    {
        $ezpos_user_data = User::find($id);
        return view('user.profile', compact('ezpos_user_data'));
    }

    public function profileUpdate(Request $request, $id)
    {
        //return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        $input = $request->all();
        $ezpos_user_data = User::find($id);
        $ezpos_user_data->update($input);
        return redirect('/');
    }

    public function changePassword(Request $request, $id)
    {
        //return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        $input = $request->all();
        $ezpos_user_data = User::find($id);
        if($input['new_pass'] != $input['confirm_pass'])
            return redirect("user/" .  "profile/" . $id )->with('message2', "Please Confirm your new password");

        if (Hash::check($input['current_pass'], $ezpos_user_data->password)) {
            $ezpos_user_data->password = bcrypt($input['new_pass']);
            $ezpos_user_data->save();
        }
        else {
            return redirect("user/" .  "profile/" . $id )->with('message1', "Current Password doesn't match");
        }
        auth()->logout();
        return redirect('/');
    }

    public function destroy($id)
    {
        //return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        $ezpos_user_data = User::find($id);
        $ezpos_user_data->is_deleted = true;
        $ezpos_user_data->is_active = false;
        $ezpos_user_data->save();
        if(Auth::id() == $id){
            auth()->logout();
            return redirect('/login');
        }
        else
            return redirect('user')->with('message3', 'Data deleted successfullly');
    }
}

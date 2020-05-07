<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerGroup;
use App\Customer;
use App\Deposit;
use App\User;
use Illuminate\Validation\Rule;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('customers-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            $ezpos_customer_all = Customer::where('is_active', true)->get();
            return view('customer.index', compact('ezpos_customer_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('customers-add')){
            $ezpos_customer_group_all = CustomerGroup::where('is_active',true)->get();
            return view('customer.create', compact('ezpos_customer_group_all'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'phone_number' => [
                'max:255',
                    Rule::unique('customers')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);
        $ezpos_customer_data = $request->all();
        $ezpos_customer_data['is_active'] = true;
		/*
        if($ezpos_customer_data['email']){
            Mail::send( 'mail.customer_create', $ezpos_customer_data, function( $message ) use ($ezpos_customer_data)
            {
                $message->to( $ezpos_customer_data['email'] )->subject( 'New Customer' );
            });
        }
		*/
        Customer::create($ezpos_customer_data);
        if($ezpos_customer_data['pos'])
            return redirect('offers1')->with('message', 'Customer created successfully');
        else
            return redirect('customer')->with('create_message', 'Data inserted Successfully');
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('customers-edit')){
            $ezpos_customer_data = Customer::find($id);
            $ezpos_customer_group_all = CustomerGroup::where('is_active',true)->get();
            return view('customer.edit', compact('ezpos_customer_data','ezpos_customer_group_all'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'phone_number' => [
                'max:255',
                    Rule::unique('customers')->ignore($id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $input = $request->all();
        $ezpos_customer_data = Customer::find($id);
        $ezpos_customer_data->update($input);
        return redirect('customer')->with('edit_message', 'Data updated Successfully');
    }

    public function getDeposit($id)
    {
        $ezpos_deposit_list = Deposit::where('customer_id', $id)->get();
        $deposit_id = [];
        $deposits = [];
        foreach ($ezpos_deposit_list as $deposit) {
            $deposit_id[] = $deposit->id;
            $date[] = $deposit->created_at->toDateString() . ' '. $deposit->created_at->toTimeString();
            $amount[] = $deposit->amount;
            $note[] = $deposit->note;
            $ezpos_user_data = User::find($deposit->user_id);
            $name[] = $ezpos_user_data->name;
            $email[] = $ezpos_user_data->email;
        }
        if(!empty($deposit_id)){
            $deposits[] = $deposit_id;
            $deposits[] = $date;
            $deposits[] = $amount;
            $deposits[] = $note;
            $deposits[] = $name;
            $deposits[] = $email;
        }
        return $deposits;
    }

    public function addDeposit(Request $request)
    {
        $data = $request->all();
        //return $data;
        $data['user_id'] = Auth::id();
        $ezpos_customer_data = Customer::find($data['customer_id']);
        $ezpos_customer_data->deposit += $data['amount'];
        $ezpos_customer_data->save();
        Deposit::create($data);
		/*
        if($ezpos_customer_data->email){
            $data['name'] = $ezpos_customer_data->name;
            $data['email'] = $ezpos_customer_data->email;
            $data['balance'] = $ezpos_customer_data->deposit - $ezpos_customer_data->expense;
            Mail::send( 'mail.customer_deposit', $data, function( $message ) use ($data)
            {
                $message->to( $data['email'] )->subject( 'Recharge Info' );
            });
        }
		*/
        return redirect('customer')->with('create_message', 'Data inserted successfully');
    }

    public function updateDeposit(Request $request)
    {
        $data = $request->all();
        $ezpos_deposit_data = Deposit::find($data['deposit_id']);
        $ezpos_customer_data = Customer::find($ezpos_deposit_data->customer_id);
        $amount_dif = $data['amount'] - $ezpos_deposit_data->amount;
        $ezpos_customer_data->deposit += $amount_dif;
        $ezpos_customer_data->save();
        $ezpos_deposit_data->update($data);
        return redirect('customer')->with('create_message', 'Data updated successfully');
    }

    public function deleteDeposit(Request $request)
    {
        $data = $request->all();
        $ezpos_deposit_data = Deposit::find($data['id']);
        $ezpos_customer_data = Customer::find($ezpos_deposit_data->customer_id);
        $ezpos_customer_data->deposit -= $ezpos_deposit_data->amount;
        $ezpos_customer_data->save();
        $ezpos_deposit_data->delete();
        return redirect('customer')->with('not_permitted', 'Data deleted successfully');
    }

    public function destroy($id)
    {
        $ezpos_customer_data = Customer::find($id);
        $ezpos_customer_data->is_active = false;
        $ezpos_customer_data->save();
        return redirect('customer')->with('not_permitted','Data deleted Successfully');
    }
	
	    public function add_customer(Request $request)
        {
        $this->validate($request, [
            'phone_number' => [
                'max:255',
                    Rule::unique('customers')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);
        $ezpos_customer_data = $request->all();
        $ezpos_customer_data['is_active'] = true;
		/*
        if($ezpos_customer_data['email']){
            Mail::send( 'mail.customer_create', $ezpos_customer_data, function( $message ) use ($ezpos_customer_data)
            {
                $message->to( $ezpos_customer_data['email'] )->subject( 'New Customer' );
            });
        }
		*/
        Customer::create($ezpos_customer_data);
        if($ezpos_customer_data['pos'])
            return redirect('offers1')->with('message', 'Customer created successfully');
        else
            return redirect('customer')->with('create_message', 'Data inserted Successfully');
    }

	}

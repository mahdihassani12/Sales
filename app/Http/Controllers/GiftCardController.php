<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\User;
use App\GiftCard;
use App\GiftCardRecharge;
use Keygen;
use Auth;
use Illuminate\Validation\Rule;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;

class GiftCardController extends Controller
{
    public function index()
    {
        $ezpos_customer_list = Customer::where('is_active', true)->get();
        $ezpos_user_list = User::where('is_active', true)->get();
        $ezpos_gift_card_all = GiftCard::where('is_active', true)->orderBy('id', 'desc')->get();

        return view('gift_card.index', compact('ezpos_customer_list', 'ezpos_user_list', 'ezpos_gift_card_all'));
    }

    public function create()
    {
        //
    }

    public function generateCode()
    {
        $id = Keygen::numeric(16)->generate();
        return $id;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'card_no' => [
                'max:255',
                    Rule::unique('gift_cards')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ]
        ]);

        $data = $request->all();
        if($request->input('user'))
            $data['customer_id'] = null;
        else
            $data['user_id'] = null;
        
        $data['expired_date'] = date('Y-m-d', strtotime($data['expired_date']));
        $data['is_active'] = true;
        $data['created_by'] = Auth::id();
        $data['expense'] = 0;
        GiftCard::create($data);
        if($request->input('user')) {
          //  $ezpos_user_data = User::find($data['user_id']);
          //  $data['email'] = $ezpos_user_data->email;
          //  $data['name'] = $ezpos_user_data->name;

          //  Mail::send( 'mail.gift_card_create', $data, function( $message ) use ($data)
           // {
           //     $message->to( $data['email'] )->subject( 'GiftCard' );
          //  });
        }
        else{
           // $ezpos_customer_data = Customer::find($data['customer_id']);
           /* if($ezpos_customer_data->email){
                $data['email'] = $ezpos_customer_data->email;
                $data['name'] = $ezpos_customer_data->name;
                if($data['name']){
                    Mail::send( 'mail.gift_card_create', $data, function( $message ) use ($data)
                    {
                        $message->to( $data['email'] )->subject( 'GiftCard' );
                    });
                }
            }
			*/
        }
        return redirect('gift_cards')->with('message', 'GiftCard created successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $ezpos_gift_card_data = GiftCard::find($id);
        $ezpos_gift_card_data->expired_date = date('d-m-Y', strtotime($ezpos_gift_card_data->expired_date));
        return $ezpos_gift_card_data;
    }

    public function update(Request $request, $id)
    {
        $request['card_no'] = $request['card_no_edit'];
        $this->validate($request, [
            'card_no' => [
                'max:255',
                Rule::unique('gift_cards')->ignore($request['gift_card_id'])->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ]
        ]);

        $data = $request->all();
        $ezpos_gift_card_data = GiftCard::find($data['gift_card_id']);
        $ezpos_gift_card_data->card_no = $data['card_no_edit'];
        $ezpos_gift_card_data->amount = $data['amount_edit'];
        if($request->input('user_edit')){
            $ezpos_gift_card_data->user_id = $data['user_id_edit'];
            $ezpos_gift_card_data->customer_id = null;
        }
        else{
            $ezpos_gift_card_data->user_id = null;
            $ezpos_gift_card_data->customer_id = $data['customer_id_edit'];
        }
        $ezpos_gift_card_data->expired_date = date('Y-m-d', strtotime($data['expired_date_edit']));
        $ezpos_gift_card_data->save();
        return redirect('gift_cards')->with('message', 'GiftCard updated successfully');
    }

    public function recharge(Request $request, $id)
    {
        $data = $request->all();
        //return $data;
        $data['user_id'] = Auth::id();
        $ezpos_gift_card_data = GiftCard::find($data['gift_card_id']);
        if($ezpos_gift_card_data->customer_id)
            $ezpos_customer_data = Customer::find($ezpos_gift_card_data->customer_id);
        else
            $ezpos_customer_data = User::find($ezpos_gift_card_data->user_id);
        $ezpos_gift_card_data->amount += $data['amount'];
        $ezpos_gift_card_data->save();
        GiftCardRecharge::create($data);

        $data['email'] = $ezpos_customer_data->email;
        $data['name'] = $ezpos_customer_data->name;
        $data['card_no'] = $ezpos_gift_card_data->card_no;
        $data['balance'] = $ezpos_gift_card_data->amount - $ezpos_gift_card_data->expense;
       /* if($data['email']){
            Mail::send( 'mail.gift_card_recharge', $data, function( $message ) use ($data)
            {
                $message->to( $data['email'] )->subject( 'GiftCard Recharge Info' );
            });
        }
		*/
        return redirect('gift_cards')->with('message', 'GiftCard recharged successfully');
    }

    public function destroy($id)
    {
        $ezpos_gift_card_data = GiftCard::find($id);
        $ezpos_gift_card_data->is_active = false;
        $ezpos_gift_card_data->save();
        return redirect('gift_cards')->with('not_permitted', 'Data deleted successfully');
    }
}

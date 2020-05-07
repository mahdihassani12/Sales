<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Customer;
use App\CustomerGroup;
use App\Store;
use App\Biller;
use App\PosSetting;
use App\GeneralSetting;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
class SettingController extends Controller
{
    public function generalSetting()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('general_setting')) {
            $ezpos_general_setting_data = GeneralSetting::latest()->first();
            return view('setting.general_setting', compact('ezpos_general_setting_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function generalSettingStore(Request $request)
    {
        //return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        $this->validate($request, [
            'site_logo' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);

        $data = $request->except('site_logo');
        $general_setting = GeneralSetting::latest()->first();
        $general_setting->id = 1;
        $general_setting->site_title = $data['site_title'];
        $general_setting->currency = $data['currency'];
        $logo = $request->site_logo;
        if ($logo) {
            $logoName = $logo->getClientOriginalName();
            $logo->move('public/logo', $logoName);
            $general_setting->site_logo = $logoName;
        }
        $general_setting->save();
        return redirect()->back()->with('message', 'Data updated successfully');
    }

    public function mailSetting()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('mail_setting'))
            return view('setting.mail_setting');
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function mailSettingStore(Request $request)
    {
        //return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        $data = $request->all();
        //writting mail info in .env file
        $path = '.env';
        $searchArray = array('MAIL_HOST='.env('MAIL_HOST'), 'MAIL_PORT='.env('MAIL_PORT'), 'MAIL_FROM_ADDRESS='.env('MAIL_FROM_ADDRESS'), 'MAIL_FROM_NAME='.env('MAIL_FROM_NAME'), 'MAIL_USERNAME='.env('MAIL_USERNAME'), 'MAIL_PASSWORD='.env('MAIL_PASSWORD'), 'MAIL_ENCRYPTION='.env('MAIL_ENCRYPTION'));

        $replaceArray = array('MAIL_HOST='.$data['mail_host'], 'MAIL_PORT='.$data['port'], 'MAIL_FROM_ADDRESS='.$data['mail_address'], 'MAIL_FROM_NAME='.$data['mail_name'], 'MAIL_USERNAME='.$data['mail_address'], 'MAIL_PASSWORD='.$data['password'], 'MAIL_ENCRYPTION='.$data['encryption']);
        
        file_put_contents($path, str_replace($searchArray, $replaceArray, file_get_contents($path)));

        return redirect()->back()->with('message', 'Data updated successfully');
    }
    
    public function posSetting()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('pos_setting')) {
        	$ezpos_customer_list = Customer::where('is_active', true)->get();
            $ezpos_store_list = Store::where('is_active', true)->get();
            $ezpos_pos_setting_data = PosSetting::latest()->first();
            
        	return view('setting.pos_setting', compact('ezpos_customer_list', 'ezpos_store_list', 'ezpos_pos_setting_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function posSettingStore(Request $request)
    {
        //return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
    	$data = $request->all();
        //writting mail info in .env file
        $path = '.env';
        $searchArray = array('PAYPAL_LIVE_API_USERNAME='.env('PAYPAL_LIVE_API_USERNAME'), 'PAYPAL_LIVE_API_PASSWORD='.env('PAYPAL_LIVE_API_PASSWORD'), 'PAYPAL_LIVE_API_SECRET='.env('PAYPAL_LIVE_API_SECRET'));

        $replaceArray = array('PAYPAL_LIVE_API_USERNAME='.$data['paypal_username'], 'PAYPAL_LIVE_API_PASSWORD='.$data['paypal_password'], 'PAYPAL_LIVE_API_SECRET='.$data['paypal_signature']);

        file_put_contents($path, str_replace($searchArray, $replaceArray, file_get_contents($path)));

    	$pos_setting = PosSetting::firstOrNew(['id' => 1]);
    	$pos_setting->id = 1;
    	$pos_setting->customer_id = $data['customer_id'];
    	$pos_setting->store_id = $data['store_id'];
    	$pos_setting->product_number = $data['product_number'];
    	$pos_setting->stripe_public_key = $data['stripe_public_key'];
    	$pos_setting->stripe_secret_key = $data['stripe_secret_key'];
        if(!isset($data['keybord_active']))
            $pos_setting->keybord_active = false;
        else
            $pos_setting->keybord_active = true;
    	$pos_setting->save();
    	return redirect()->back()->with('message', 'POS setting updated successfully');
    }
	
	
	public function changeDefaultColor(Request $request){
		$bdata['color']=$request->color;
		DB::table('general_settings')->where('id',1)->update($bdata);
		return redirect('setting/general_setting');
	}
	
	public function zero_balance($id){
		$bdata['zero_balance']=$id;
		DB::table('general_settings')->where('id',1)->update($bdata);
	}
	public function offersPageSetting(Request $request){
		$data['paginate_scrole'] =$request->paginate_scroll;
		$data['offers_item_number'] =$request->item_num;
		DB::table('general_settings')->where('id',1)->update($data);
		return redirect('setting/general_setting');
	}
	
  public function siteSetting(){
		$site_setting=DB::table('site_setting')->where('id',1)->get()[0];
		return view('setting/site_setting')->with('site_setting',$site_setting);
	}
	public function updateSiteSetting(Request $request){
		
		$attachment = NULL;
		if ($request->hasFile('site_logo')){ 
                $files =$request->site_logo;
                $ext = $files->getClientOriginalExtension();
                $attachment = 'site_logo'.".".$ext;
				
                $file = $files;
                $destinationPath = public_path("logo");
                $file->move($destinationPath, $attachment);
				
              $data['logo']=$attachment;
            }
			 
       		
             $data['title']=$request->site_title;
             $data['phone_no1']=$request->phone_no1;		
             $data['phone_no2']=$request->phone_no2; 
             $data['email']=$request->email; 
             $data['facebook']=$request->facebook;
             $data['allow_negative']=$request->allow_negative;
		
            DB::table("site_setting")->where('id','1')->update($data);
			return redirect('setting/siteSetting');
	}
	
}

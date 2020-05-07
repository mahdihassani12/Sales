<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Biller;
use Illuminate\Validation\Rule;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;

class BillerController extends Controller
{
    public function index()
    {
        $ezpos_biller_all = biller::where('is_active', true)->get();
        return view('biller.index',compact('ezpos_biller_all'));
    }

    public function create()
    {
        return view('biller.create');
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
            'company_name' => [
                'max:255',
                    Rule::unique('billers')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'email' => [
                'email',
                'max:255',
                    Rule::unique('billers')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);

        $ezpos_biller_data = $request->except('image');
        $ezpos_biller_data['is_active'] = true;
        $image = $request->image;
        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $request['company_name']);
            $imageName = $imageName . '.' . $ext;
            $image->move('public/images/biller', $imageName);
            $ezpos_biller_data['image'] = $imageName;
        }
       // Mail::send( 'mail.biller_create', $ezpos_biller_data, function( $message ) use ($ezpos_biller_data)
       // {
       //     $message->to( $ezpos_biller_data['email'] )->subject( 'New Biller' );
       // });
        Biller::create($ezpos_biller_data);
        return redirect('biller')->with('message','Data inserted successfully');
    }

    public function edit($id)
    {
        $ezpos_biller_data = Biller::where('id',$id)->first();
        return view('biller.edit',compact('ezpos_biller_data'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'company_name' => [
                'max:255',
                    Rule::unique('billers')->ignore($id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'email' => [
                'email',
                'max:255',
                    Rule::unique('billers')->ignore($id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],

            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);

        $input = $request->except('image');
        $image = $request->image;
        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $request['company_name']);
            $imageName = $imageName . '.' . $ext;
            $image->move('public/images/biller', $imageName);
            $input['image'] = $imageName;
        }

        $ezpos_biller_data = Biller::findOrFail($id);
        $ezpos_biller_data->update($input);
        return redirect('biller')->with('message','Data updated successfully');
    }

    public function importBiller(Request $request)
    {
        $upload=$request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if($ext != 'csv')
            return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
        $filename =  $upload->getClientOriginalName();
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

           $biller = Biller::firstOrNew(['company_name'=>$data['companyname']]);
           $biller->name = $data['name'];
           $biller->image = $data['image'];
           $biller->vat_number = $data['vatnumber'];
           $biller->email = $data['email'];
           $biller->phone_number = $data['phonenumber'];
           $biller->address = $data['address'];
           $biller->city = $data['city'];
           $biller->state = $data['state'];
           $biller->postal_code = $data['postalcode'];
           $biller->country = $data['country'];
           $biller->is_active = true;
           $biller->save();
          /* if($data['email']){
                Mail::send( 'mail.biller_create', $data, function( $message ) use ($data)
                {
                    $message->to( $data['email'] )->subject( 'New Biller' );
                });
            }
		 */	
        }
        return redirect('biller')->with('message','Biller Imported Successfully');
        
    }

    public function destroy($id)
    {
        $ezpos_biller_data = Biller::find($id);
        $ezpos_biller_data->is_active = false;
        $ezpos_biller_data->save();
        return redirect('biller')->with('not_permitted','Data deleted successfully');
    }
}

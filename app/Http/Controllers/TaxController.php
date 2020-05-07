<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tax;
use Illuminate\Validation\Rule;

class TaxController extends Controller
{
    public function index()
    {
        $ezpos_tax_all = Tax::where('is_active', true)->get();
        return view('tax.create', compact('ezpos_tax_all'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                    Rule::unique('taxes')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],

            'rate' => 'numeric|min:0|max:100',

        ]);
        $input = $request->all();
        $input['is_active'] = true;
        Tax::create($input);
        return redirect('tax')->with('message', 'Data inserted successfully');
    }

    public function ezposTaxSearch()
    {
        $ezpos_tax_name = $_GET['ezpos_taxNameSearch'];
        $ezpos_tax_all = tax::where('name', $ezpos_tax_name)->paginate(5);
        $ezpos_tax_list = tax::all();
        return view('tax.create', compact('ezpos_tax_all','ezpos_tax_list'));
    }

    public function edit($id)
    {
        $ezpos_tax_data = Tax::findOrFail($id);
        return $ezpos_tax_data;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('taxes')->ignore($request->tax_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],

            'rate' => 'numeric|min:0|max:100'
        ]);

        $input = $request->all();
        $ezpos_tax_data = Tax::where('id', $input['tax_id'])->first();
        $ezpos_tax_data->update($input);
        return redirect('tax')->with('message', 'Data updated successfully');
    }

    public function importTax(Request $request)
    {  
        //get file
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

           $tax = Tax::firstOrNew(['name' => $data['name'], 'is_active' => true ]);
           $tax->name = $data['name'];
           $tax->rate = $data['rate'];
           $tax->is_active = true;
           $tax->save();
        }
        return redirect('tax')->with('message', 'Tax imported successfully');
    }

    public function destroy($id)
    {
        $ezpos_tax_data = Tax::findOrFail($id);
        $ezpos_tax_data->is_active = false;
        $ezpos_tax_data->save();
        return redirect('tax')->with('not_permitted', 'Data deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{

    public function index()
    {
        $ezpos_brand_all = Brand::where('is_active',true)->get();
        return view('brand.create', compact('ezpos_brand_all'));
    }

    public function store(Request $request)
    {
        $request->title = preg_replace('/\s+/', ' ', $request->title);
        $this->validate($request, [
            'title' => [
                'max:255',
                    Rule::unique('brands')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],

            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);

        $input = $request->except('image');
        $input['is_active'] = true;
        $image = $request->image;
        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $input['title']);
            $imageName = $imageName . '.' . $ext;
            $image->move('public/images/brand', $imageName);
            $input['image'] = $imageName;
        }
        Brand::create($input);
        return redirect('brand');
    }

    public function edit($id)
    {
        $ezpos_brand_data = Brand::findOrFail($id);
        return $ezpos_brand_data;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => [
                'max:255',
                    Rule::unique('brands')->ignore($request->brand_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],

            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);
        $ezpos_brand_data = Brand::findOrFail($request->brand_id);
        $ezpos_brand_data->title = $request->title;
        $image = $request->image;
        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $request->title);
            $imageName = $imageName . '.' . $ext;
            $image->move('public/images/brand', $imageName);
            $ezpos_brand_data->image = $imageName;
        }
        $ezpos_brand_data->save();
        return redirect('brand');
    }

    public function importBrand(Request $request)
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

           $brand = Brand::firstOrNew([ 'title'=>$data['title'], 'is_active'=>true ]);
           $brand->title = $data['title'];
           $brand->image = $data['image'];
           $brand->is_active = true;
           $brand->save();
        }
        return redirect('brand')->with('message', 'Brand imported successfully');
    }

    public function destroy($id)
    {
        $ezpos_brand_data = Brand::findOrFail($id);
        $ezpos_brand_data->is_active = false;
        $ezpos_brand_data->save();
        return redirect('brand');
    }

    public function exportBrand(Request $request)
    {
        $ezpos_brand_data = $request['brandArray'];
        $csvData=array('Brand Title, Image');
        foreach ($ezpos_brand_data as $brand) {
            if($brand > 0) {
                $data = Brand::where('id', $brand)->first();
                $csvData[]=$data->title.','.$data->image;
            }   
        }        
        $filename=date('Y-m-d').".csv";
        $file_path=public_path().'/downloads/'.$filename;
        $file_url=url('/').'/downloads/'.$filename;   
        $file = fopen($file_path,"w+");
        foreach ($csvData as $exp_data){
          fputcsv($file,explode(',',$exp_data));
        }   
        fclose($file);
        return $file_url;
    }
}

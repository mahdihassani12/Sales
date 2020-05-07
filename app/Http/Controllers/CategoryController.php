<?php

namespace App\Http\Controllers;
use Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    { 
	  $branch=Auth::user()->branch_id;
	   $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('category-index')){
           $ezpos_categories = Category::where('is_active', true)->where('parent_id',null);
		   if($branch!="Admin"){
			   $ezpos_categories=$ezpos_categories->where('branch_id',$branch);
		   }
		   $ezpos_categories=$ezpos_categories->pluck('name', 'id');
           $ezpos_category_all = Category::where('is_active', true)->where('parent_id',null);
		   if($branch!="Admin"){
			   $ezpos_category_all=$ezpos_category_all->where('branch_id',$branch);
		   }
		   $ezpos_category_all=$ezpos_category_all->get();
		   
		   $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
        return view('category.create',compact('ezpos_categories', 'ezpos_category_all','all_permission'));
	 }
	else
     return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
  		
	}

    public function subCategory(){
        
        $branch=Auth::user()->branch_id;
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('category-index')){
           $ezpos_categories = Category::where('is_active', true)->where('parent_id',null);
           if($branch!="Admin"){
               $ezpos_categories=$ezpos_categories->where('branch_id',$branch);
           }
           $ezpos_categories=$ezpos_categories->pluck('name', 'id');

           $ezpos_category_all = Category::where('is_active', true)->where('parent_id','!=',null);
           if($branch!="Admin"){
               $ezpos_category_all=$ezpos_category_all->where('branch_id',$branch);
           }
           $ezpos_category_all=$ezpos_category_all->get();
           
            $parent_ezpos_categories = Category::where('is_active', true)->where('parent_id',null);
           if($branch!="Admin"){
               $parent_ezpos_categories=$parent_ezpos_categories->where('branch_id',$branch);
           }
           $parent_ezpos_categories=$parent_ezpos_categories->get();


           $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
        return view('sub_category.create',compact('ezpos_categories', 'ezpos_category_all','all_permission','parent_ezpos_categories'));
     }
    else
     return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $branch=Auth::user()->branch_id;
        $request->name = preg_replace('/\s+/', ' ', $request->name);
        $this->validate($request, [
            'name' => [
                'max:255',
                    Rule::unique('categories')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);
		
        $ezpos_category_data['name'] = $request->name;
        $ezpos_category_data['parent_id'] = $request->parent_id;
        $ezpos_category_data['branch_id'] = $branch;
        $ezpos_category_data['is_active'] = true;
        Category::create($ezpos_category_data);
        return back()->with('message', 'Data inserted successfully');
    }

    public function edit($id)
    {
        $ezpos_category_data = Category::findOrFail($id);
        $ezpos_parent_data = Category::where('id',
            $ezpos_category_data['parent_id'])->first();
        $ezpos_category_data['parent'] = $ezpos_parent_data['name'];
        return $ezpos_category_data;
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'name' => [
                'max:255',
                Rule::unique('categories')->ignore($request->category_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $input = $request->all();
        $ezpos_category_data = Category::findOrFail($request->category_id);
        $ezpos_category_data->update($input);
        return back()->with('message', 'Data updated successfully');
    }

    public function import(Request $request)
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
            $category = Category::firstOrNew(['name' => $data['name'], 'is_active' => true ]);
            if($data['parentcategory']){
                $parent_category = Category::firstOrNew(['name' => $data['parentcategory'], 'is_active' => true ]);
                $parent_id = $parent_category->id;
            }
            else
                $parent_id = null;

            $category->parent_id = $parent_id;
            $category->is_active = true;
            $category->save();
        }
        return back()->with('message', 'Category imported successfully');
    }

    public function destroy($id)
    {
        $ezpos_category_data = Category::findOrFail($id);
        $ezpos_category_data->is_active = false;
        $ezpos_product_data = Product::where('category_id', $id)->get();
        foreach ($ezpos_product_data as $product_data) {
            $product_data->is_active = false;
            $product_data->save();
        }
        $ezpos_category_data->save();
        return back()->with('not_permitted', 'Data deleted successfully');
    }
}

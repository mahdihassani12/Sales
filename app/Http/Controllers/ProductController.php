<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Keygen;
use App\Brand;
use App\Category;
use App\Tax;
use App\Store;
use App\Supplier;
use App\Product;
use App\Product_Store;
use App\Product_Supplier;
use Auth;
use DNS1D;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;
use Excel;
class ProductController extends Controller
{
    public function index()
    {
		$branch=Auth::user()->branch_id;
		
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('products-index')){
            $ezpos_product_all = Product::where('is_active', true)->where('is_variation','0');
			if($branch!="Admin"){
			 $ezpos_product_all=$ezpos_product_all->where('branch_id',$branch);	
			}
			$ezpos_product_all=$ezpos_product_all->get();
			
			
            $all_category=DB::table('categories')->where('is_active',true);
			if($branch!="Admin"){
			 $all_category=$all_category->where('branch_id',$branch);	
			}
			$all_category=$all_category->get();
			
			$permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            return view('product.index', compact('all_category','ezpos_product_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

	public function changeProductCategory($category,$product){
		$res=DB::table('products')->where('id',$product)->update(['category_id'=>$category]);
		if($res){
		   return 1;
		}
		else{
			return 0;
		}
	}
    public function create()
    {
		 $branch=Auth::user()->branch_id;
		 
        $role = Role::firstOrCreate(['id' => Auth::user()->role_id]);
        if ($role->hasPermissionTo('products-add')){
            $ezpos_brand_list = Brand::where('is_active', true)->get();
            $ezpos_category_list = Category::where('is_active', true);
			if($branch!="Admin"){
			$ezpos_category_list=$ezpos_category_list->where('branch_id',$branch);	
			}
			$ezpos_category_list=$ezpos_category_list->get();
            $ezpos_tax_list = Tax::where('is_active', true)->get();
            return view('product.create',compact('ezpos_brand_list', 'ezpos_category_list', 'ezpos_unit_list', 'ezpos_tax_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

	public function product_view($id){
		//jumah code
		//echo DB::table('products')->where('id',$id)->get()[0]->name;
       return view('product.product_view');

	}
    public function store(Request $request)
    {
		$branch=Auth::user()->branch_id; 
        $external=$request->external_link; 
		

        $this->validate($request, [
            'code' => [
                'max:255',
                    Rule::unique('products')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'name' => [
                'max:255',
                    Rule::unique('products')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);

        $data = $request->except('image', 'file');
        if($data['type'] == 'digital')
            $data['cost'] = 0;
        if($data['starting_date'])
            $data['starting_date'] = date('Y-m-d', strtotime($data['starting_date']));
        if($data['last_date'])
            $data['last_date'] = date('Y-m-d', strtotime($data['last_date']));
        $data['is_active'] = true;
        $image = $request->image;
        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $request['name']);
            $imageName = $imageName . '.' . $ext;
            $image->move('public/images/product', $imageName);
            $data['image'] = $imageName;
        }
        else {
          $data['image'] = 'zummXD2dvAtI.png';
        }

         $data['external_link']='0';
         $data['branch_id']=$branch;
       if($external){
	   $data['image']=$external;
	   $data['external_link']='1';
	}

 
        $file = $request->file;
        if ($file) {
            $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $fileName = strtotime(date('Y-m-d H:i:s'));
            $fileName = $fileName . '.' . $ext;
            $file->move('public/product/files', $fileName);
            $data['file'] = $fileName;
        }

         $data['product_link']=$data['product_link']; 
         if($data['product_link']){     
            $data['product_link']= str_replace("watch?v=","embed/",$data['product_link']); 
          }
        Product::create($data);
		
		
		//my codes
		$pid=DB::table('products')->orderBy('created_at','DESC')->limit(1)->get()[0]->id;
		$store=DB::table('stores')->where('is_active','1');
		//if($branch!="Admin"){
		    $store=$store->where('branch_id',$branch);	
		//}
		$store=$store->get();
		foreach ($store as $str){
			$jdata['store_id']=$str->id;
			$jdata['product_id']=$pid;
			$jdata['qty']=0;
			$jdata['created_at']=date('Y-m-d h:i:s');
			$jdata['updated_at']=date('Y-m-d h:i:s');
			DB::table('product_store')->insert($jdata);
		}
		//end of mycode
        return redirect('products')->with('create_message', 'Product created successfully'); 
    }

    public function edit($id)
    {
		$branch=Auth::user()->branch_id;
        $role = Role::firstOrCreate(['id' => Auth::user()->role_id]);
        if ($role->hasPermissionTo('products-edit')) {
            $ezpos_brand_list = Brand::where('is_active', true)->get();
            $ezpos_category_list = Category::where('is_active', true);
			if($branch!="Admin"){
			$ezpos_category_list=$ezpos_category_list->where('branch_id',$branch);	
			}
			$ezpos_category_list=$ezpos_category_list->get();
            $ezpos_tax_list = Tax::where('is_active', true)->get();
            $ezpos_product_data = Product::where('id', $id)->first();

            return view('product.edit',compact('ezpos_brand_list', 'ezpos_category_list', 'ezpos_tax_list', 'ezpos_product_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('products')->ignore($id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],

            'code' => [
                'max:255',
                Rule::unique('products')->ignore($id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],

            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);

        $ezpos_product_data = Product::findOrFail($id);
        $data = $request->except('image', 'file');
        if($data['type'] == 'digital'){
            $data['cost'] = $data['unit_id'] = $data['purchase_unit_id'] = $data['sale_unit_id'] = 0;
        }
        if($data['starting_date'])
            $data['starting_date'] = date('Y-m-d', strtotime($data['starting_date']));
        if($data['last_date'])
            $data['last_date'] = date('Y-m-d', strtotime($data['last_date']));
        $image = $request->image;
        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $request['name']);
            $imageName = $imageName . '.' . $ext;
            $image->move('public/images/product', $imageName);
            $data['image'] = $imageName;
        }
         
              $external=$request->external_link; 
		
		$data['external_link']='0';
	    if($external){
			$data['image']=$external;
			$data['external_link']='1';
		}

        $file = $request->file;
        if ($file) {
            $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $fileName = strtotime(date('Y-m-d H:i:s'));
            $fileName = $fileName . '.' . $ext;
            $file->move('public/product/files', $fileName);
            $data['file'] = $fileName;
        }

         if($data['product_link']){     
            $data['product_link']= str_replace("watch?v=","embed/",$data['product_link']); 
	}
          

        $ezpos_product_data->update($data);
        return redirect('products')->with('edit_message', 'Product updated successfully');
    }

    public function generateCode()
    {
        $id = Keygen::numeric(8)->generate();
        return $id;
    }

    public function saleUnit($id)
    {
        $unit = Unit::where("base_unit", $id)->orWhere('id', $id)->pluck('unit_name','id');
        return json_encode($unit);
    }

    public function productStoreData($id)
    {
        $store = [];
        $qty = [];
        $product_store = [];

        $ezpos_product_store_data = Product_Store::where('product_id', $id)->get();
        foreach ($ezpos_product_store_data as $key => $product_store_data) {
            $ezpos_store_data = Store::find($product_store_data->store_id);
            $store[] = $ezpos_store_data->name;
            $qty[] = $product_store_data->qty;
        }

        $product_store[] = $store;
        $product_store[] = $qty;
        return $product_store;
    }

    public function printBarcode()
    {
        $ezpos_product_list = Product::where('is_active', true)->get();
        return view('product.print_barcode', compact('ezpos_product_list'));
    }

    public function ezposProductSearch(Request $request)
    {
        $product_code = explode(" ", $request['data']);
        $ezpos_product_data = Product::where('code', $product_code[0])->first();
        $product[] = $ezpos_product_data->name;
        $product[] = $ezpos_product_data->code;
        $product[] = $ezpos_product_data->price;
        $product[] = DNS1D::getBarcodePNG($ezpos_product_data->code, $ezpos_product_data->barcode_symbology);
        $product[] = $ezpos_product_data->promotion_price;
        return $product;
    }

  public function importProduct(Request $request)
    {   
        //get file
        

        $upload=$request->file('file');
        if(!$request->hasFile('file')){
          return redirect()->back()->with('message', 'Please Select a file first!');   
          }
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);

        if($ext != 'xls'){
            return redirect()->back()->with('message', 'Please upload a xls  file');
        }

          Excel::load($request->file('file')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $row) {

                $product = Product::firstOrNew([ 'code'=>$row['code'], 'is_active'=>true ]);

                $product->name = $row['name'];
                $product->code = $row['code'];
                if(!is_numeric($row['code'])){
                  $product->code=rand(100,434444);  
                }
            $branch=Auth::user()->branch_id;
           $product->arabic_name = $row['arname'];
           $category = $row['category'];
           $subCategory = $row['sub_category'];

            $isCategory=DB::table('categories')->where('name',$category)->get();
            
            if(count($isCategory)){
                $categoryId=$isCategory[0]->id;
            }
            else{
                DB::table('categories')->insert(['name'=>$category,'branch_id'=>$branch,'is_active'=>1]);
                 $categoryId=DB::table('categories')->orderBy('id','DESC')->first()->id;
            }


            
             $issubCategory=DB::table('categories')->where('name',$subCategory)->where('parent_id',$categoryId)->get();

             if(count($issubCategory)){
                $subcategoryId=$issubCategory[0]->id;
            }
            else{
                DB::table('categories')->insert(['name'=>$subCategory,'branch_id'=>$branch,'is_active'=>1,'parent_id'=>$categoryId]);
                 $subcategoryId=DB::table('categories')->where('parent_id',$categoryId)->orderBy('id','DESC')->first()->id;
            }
            

      
           $product->type =  'standard';
           $product->category_id =$subcategoryId; 
           $product->last_date=date('Y-m-d');
           $product->image='zummXD2dvAtI.png';
           $product->created_at=date('Y-m-d h:i:s');
           $product->updated_at=date('Y-m-d h:i:s');
      
           $product->barcode_symbology = 'EAN13';
           
           $product->cost = 0;
           $product->price = 0;
           $product->qty = 0;
           $product->is_active = true;
           $product->alert_quantity = 0;
           $product->starting_date = date('Y-m-d');
           $product->last_date = date('Y-m-d');
           $product->image = 'zummXD2dvAtI.png';
           $product->created_at = date('Y-m-d');
           $product->updated_at = date('Y-m-d');
           $product->branch_id =$branch;
		   
		   $exist_pro=DB::table('products')->where('code',$row['code'])->where('is_active',1)->get();
		  if($row['name']!=""  and $row['code'] !="" and count($exist_pro)<1){ 
             $product->save();
		    } 

			
			$pid=DB::table('products')->orderBy('id','DESC')->limit(1)->get()[0]->id;
	       $store=DB::table('stores')->get();	
		   
		   foreach ($store as $str){
			 $jdata['store_id']=$str->id;
			 $jdata['product_id']=$pid;
			 $jdata['qty']=0;
			 $jdata['created_at']=date('Y-m-d h:i:s');
			 $jdata['updated_at']=date('Y-m-d h:i:s');
			 DB::table('product_store')->insert($jdata);
		  }
		  
                }
            });    

         
           
		 
           
         

         return redirect('products')->with('import_message', 'Product imported successfully');
    }



    public function exportProduct(Request $request)
    {
        $ezpos_product_data = $request['productArray'];
        $csvData=array('name, code, brand, category, quantity, unit, price');
        foreach ($ezpos_product_data as $product) {
            if($product > 0) {
                $data = product::where('id', $product)->first();
                if($data->brand_id){
                    $ezpos_brand_data = Brand::find($data->brand_id);
                    $brand = $ezpos_brand_data->title;
                }
                else
                    $brand = 'N/A';
                $ezpos_category_data = Category::find($data->category_id);
                $ezpos_unit_data = Unit::find($data->unit_id);
                
                $csvData[]=$data->name. ',' . $data->code . ',' . $brand . ',' . $ezpos_category_data->name . ',' . $data->qty . ',' . $ezpos_unit_data->unit_code . ',' . $data->price;
            }   
        }        
        $filename="product- " .date('d-m-Y').".csv";
        $file_path=public_path().'/downloads/'.$filename;
        $file_url=url('/').'/downloads/'.$filename;   
        $file = fopen($file_path,"w+");
        foreach ($csvData as $exp_data){
          fputcsv($file,explode(',',$exp_data));
        }   
        fclose($file);
        return $file_url;
    }

    public function destroy($id)
    {
        $ezpos_product_data = Product::findOrFail($id);
        $ezpos_product_data->is_active = false;
        $ezpos_product_data->save();
        return redirect('products')->with('message', 'Product deleted successfully');
    }
	
	public function offers(){
		$customer=DB::table('customers')->get();
		$products=DB::table('products')->limit(3)->get();
		return view('product.offers')->with('customer',$customer)->with('products',$products);
	}
	
	
	public function add_to_cart($id ,$qty){
		$product=DB::table('products')->where('id',$id)->get()[0];
		if($product->promotion==1){
		  return $qty.','.$product->promotion_price;	
		}
		else{
		 return $qty.','.$product->price;
		}
	}
	
	
	
	 public function sale(Request $request)
    {
        $data = $request->all();
        //return dd($data);
        //$data['user_id'] = Auth::id();
		
        return redirect('offers')->with('message', "Sale created successfully");
    }

	
	 public function get_all_invoice($id){
		return view('product.invoices')->with('id',$id);
	 }
	
	public function prices(){
		$role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('product-price')){
		$products=DB::table('products')
		    ->join('categories','categories.id','products.category_id')
		    ->select('products.name as pname','categories.name as cname','products.price')
			->get();
		return view('product.prices')->with('products',$products);
		}
		else
	     return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
	}
	
	public function createQuick(){
		$data['ezpos_category_list']=DB::table('categories')->where('is_active',1)->get();
		$data['products']=DB::table('products')
		->join('categories','categories.id','products.category_id')
		->where('categories.is_active',1)
		->where('products.is_active',1)
                ->where('products.is_variation','0')
		->limit(10)
		->select('products.*','categories.name as category')
		->orderBy('products.id','DESC')
		->get();
		return view('product.create_quick',$data);
	}
	
	public function storeQuick(Request $request){
		//echo $request->product_name;
		
		$image=$request->file;
		if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $request->product_name);
            $imageName = $imageName . '.' . $ext;
            $image->move('public/images/product', $imageName);
            $data['image'] = $imageName;
        }
        else {
            $data['image'] = 'zummXD2dvAtI.png';
        }
                 $data['external_link']='0';
                 if($request->external_link){
			$data['image']=$request->external_link;
			$data['external_link']='1';
		}
		
		$data['name']=$request->product_name;
                $data['arabic_name']=$request->arabic_name; 
                $data['product_details']=$request->product_details;   
                $data['product_link']=$request->youtube_link;
                if($data['product_link']){     
                 $data['product_link']= str_replace("watch?v=","embed/",$data['product_link']); 
		 }
             
		$data['code']=$request->barcode;
		$data['category_id']=$request->category_id;
		$data['cost']=$request->cost;
		$data['price']=$request->price;
		$data['unit']=$request->unit;
		$data['qty']=$request->quantity;
		$data['alert_quantity']=$request->alert_quantity;
		$data['type']='standard';
		$data['barcode_symbology']='C128';
		$data['brand_id']='3';
		$data['is_active']='1';
                 $data['tax_method']='1';
		$data['created_at']=date('Y-m-d h:i:s');
		$data['updated_at']=date('Y-m-d h:i:s');
		
		$res=DB::table('products')->insert($data);
		
		$pid=DB::table('products')->orderBy('id','DESC')->limit(1)->get()[0]->id;
                $defaultStore=DB::table('pos_setting')->where('id',1)->get()[0]->store_id;
                 		
                $ddata['product_id']=$pid; 
		$ddata['store_id']=$defaultStore; 
		$ddata['qty']=$request->quantity; 
		$ddata['created_at']=date('Y-m-d h:i:s');
		$ddata['updated_at']=date('Y-m-d h:i:s');
		$store=DB::table('product_store')->insert($ddata);


		$store=DB::table('stores')->where('is_active','1')->where('id','!=',$defaultStore)->get();
		foreach ($store as $str){
			$jdata['store_id']=$str->id;
			$jdata['product_id']=$pid;
			$jdata['qty']=0;
			$jdata['created_at']=date('Y-m-d h:i:s');
			$jdata['updated_at']=date('Y-m-d h:i:s');
			DB::table('product_store')->insert($jdata);
		}
		//end of mycode

                $gupdata['temp']=null;
		$gupdata['product_id']=$pid;
		DB::table('product_gallery_images')->where('temp','1')->update($gupdata);

		
	    if($res){
			return view('product.partial.lastetproducts');
		}
		else{
		   echo "not_inserted";	
		}
	}
	
public function quickAddImages(Request $request){
		DB::table('product_gallery_images')->where('temp','1')->delete();
		$name1=$request->image1;
		$name2=$request->image2;
		$name3=$request->image3;
		$name4=$request->image4;
		$name5=$request->image5;
		$name6=$request->image6;
		
		$dataIns['imag_gallery']=$name1;
		$dataIns['external_link']='1';
		$dataIns['is_active']='1';
		$dataIns['temp']='1';
		
		DB::table('product_gallery_images')->insert($dataIns);
		
		if($name2){
			$dataIns['imag_gallery']=$name2;
			DB::table('product_gallery_images')->insert($dataIns);
		}
		if($name3){
			$dataIns['imag_gallery']=$name3;
			DB::table('product_gallery_images')->insert($dataIns);
		}
		if($name4){
			$dataIns['imag_gallery']=$name4;
			DB::table('product_gallery_images')->insert($dataIns);
		}
		if($name5){
			$dataIns['imag_gallery']=$name5;
			DB::table('product_gallery_images')->insert($dataIns);
		}
		if($name6){
			$dataIns['imag_gallery']=$name6;
			DB::table('product_gallery_images')->insert($dataIns);
		}
		
		return 1;
	}


	
	public function updateProductImages(Request $request){
		$product_id=$request->product_id;
		DB::table('product_gallery_images')->where('product_id',$product_id)->delete();
		
		$name1=$request->image1;
		$name2=$request->image2;
		$name3=$request->image3;
		$name4=$request->image4;
		$name5=$request->image5;
		$name6=$request->image6;
		
		$dataIns['imag_gallery']=$name1;
		$dataIns['external_link']='1';
		$dataIns['is_active']='1';
		$dataIns['temp']=null;
		$dataIns['product_id']=$product_id;
		
		DB::table('product_gallery_images')->insert($dataIns);
		
		if($name2){
			$dataIns['imag_gallery']=$name2;
			DB::table('product_gallery_images')->insert($dataIns);
		}
		if($name3){
			$dataIns['imag_gallery']=$name3;
			DB::table('product_gallery_images')->insert($dataIns);
		}
		if($name4){
			$dataIns['imag_gallery']=$name4;
			DB::table('product_gallery_images')->insert($dataIns);
		}
		if($name5){
			$dataIns['imag_gallery']=$name5;
			DB::table('product_gallery_images')->insert($dataIns);
		}
		if($name6){
			$dataIns['imag_gallery']=$name6;
			DB::table('product_gallery_images')->insert($dataIns);
		}
		
		return 1;
	}
	


	public function selectProducts($id){
		$product=DB::table('products')
		    ->join('categories','categories.id','products.category_id')
			->where('products.is_active',1)
			->where('products.id',$id)
			->select('products.*','categories.name as cname')
			->get()[0];
			echo $product->name.','.$product->category_id.','.$product->qty.','.$product->price.','.$product->cost.','.$product->unit.','.$product->alert_quantity.','.$product->code;
	}
	
	public function updateQuick(Request $request){
		//echo $request->product_name;
		$pid=$request->product_id; 
		
		$image=$request->file;
		if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $request->product_name);
            $imageName = $imageName . '.' . $ext;
            $image->move('public/images/product', $imageName);
            $data['image'] = $imageName;
			
        }
        
		$data['name']=$request->product_name;
		$data['code']=$request->barcode;
		$data['category_id']=$request->category_id;
		$data['cost']=$request->cost;
		$data['price']=$request->price;
		$data['unit']=$request->unit;
		$data['qty']=$request->quantity;
		$data['alert_quantity']=$request->alert_quantity;
		
		
		$res=DB::table('products')->where('id',$pid)->update($data);
	    if($res){
			return view('product.partial.lastetproducts');
		}
		else{
		   echo "not_updated";	
		}
	}
	
	public function searchSpecificProducts($word){
		$data['product']=DB::table('products')->where('is_active',1)->where('name','LIKE','%'.$word.'%')->get();
	    
	   return view('product.partial.searchedproduct',$data);
	}

   public function add_image_gallery(Request $request){
		
		$attachment = NULL;
		if ($request->hasFile('passenger_attachment')){ 
                $files =$request->passenger_attachment;
                $ext = $files->getClientOriginalExtension();
                $attachment = time().".".$ext;
				
                $file = $files;
                $destinationPath = public_path("images/product_variation");
                $file->move($destinationPath, $attachment);

             $ins_data['imag_gallery'] = $attachment;
             $ins_data['product_id'] = $request->product_id;
             $ins_data['is_active'] = '1';
			
			
			 $ins_data['external_link']='0';
			 if($request->external_link){
			    $ins_data['imag_gallery']=$request->external_link; 
			    $ins_data['external_link']='1'; 
			 }
			 
            DB::table("product_gallery_images")->insert($ins_data); 
			}
        $getPro=DB::table('product_gallery_images')->where('product_id',$request->product_id)->get();
		return view('product.partial.image_gallary')->with('getPro',$getPro);
		//return $attachment;    			   			
	}
	
	
    	public function get_product_images($pid){
		$getPro=DB::table('product_gallery_images')->where('product_id',$pid)->get();
		return view('product.partial.image_gallary')->with('getPro',$getPro);	
	}
	
	public function delete_image($id){
		$gid=DB::table('product_gallery_images')->where('id',$id)->get()[0];
		$src=$gid->imag_gallery;
		$extl=$gid->external_link;
	   if(file_exists(public_path('images/product_variation/'.$src))  and $extl==0){
               unlink(public_path('images/product_variation/'.$src));
       }		
            
            DB::table("product_gallery_images")->where("id",$id)->delete();
	}

  	
	public function variationsList(){
	  $role = Role::find(Auth::user()->role_id);
          if($role->hasPermissionTo('products-index')){
            $ezpos_product_variation=DB::table('products')
				->where('is_variation','1')
                                ->where('is_active','1')
				->orderBy('created_at','DESC')->get();
									 
            $products=DB::table('products')->where('is_active', true)->where('is_variation','0')->get();
			$permissions = Role::findByName($role->name)->permissions;
            
			foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
			
		  return view('product.variation_list',compact('ezpos_product_variation', 'all_permission','products'));
           }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
	}
	
	
		public function createVariation(Request $request){
		 $array = array(  
            'variation_name'  => 'required',  
            'variation_product'  => 'required',    
            'variation_alert'  => 'required',    
        ); 
		
        $this->validate($request, $array);
		
		$attachment = 'zummXD2dvAtI.png';
		if ($request->hasFile('variation_photo')){ 
                $files =$request->variation_photo;
                $ext = $files->getClientOriginalExtension();
                $attachment = time().rand(5000,50000).".".$ext;
				
                $file = $files;
                $destinationPath = public_path("images/product");
                $file->move($destinationPath, $attachment);
            }
			
		$resutl=DB::table('products')->where('id',$request->variation_product)->get()[0];
	    
		$ins_data['name']=$resutl->name.'-'.$request->variation_name;
		$ins_data['code']=rand(9999999,99999999);
		$ins_data['type']=$resutl->type;
		$ins_data['barcode_symbology']=$resutl->barcode_symbology;
		$ins_data['brand_id']=$resutl->brand_id;
		$ins_data['category_id']=$resutl->category_id;
		$ins_data['unit']=$resutl->unit;
		$ins_data['cost']=$resutl->cost;
		$ins_data['price']=$request->variation_price;
		$ins_data['qty']=$resutl->qty;
		$ins_data['alert_quantity']=$request->variation_alert;
		$ins_data['tax_method']=$resutl->tax_method;
		$ins_data['image']=$attachment;
		$ins_data['is_active']=$resutl->is_active;
		$ins_data['is_variation']='1';
		$ins_data['product_id']=$request->variation_product;
		
	   
		
		DB::table('products')->insert($ins_data);
		$stores=DB::table('stores')->where('is_active','1')->get();
		
		$pdi=DB::table('products')->orderBy('id','DESC')->get()[0]->id; 
		foreach($stores as $st){
			$store_insert['product_id']=$pdi;
			$store_insert['store_id']=$st->id;
			$store_insert['qty']='0';
			$store_insert['created_at']=date('Y-m-d h:i:s');
			$store_insert['updated_at']=date('Y-m-d h:i:s');
			
			DB::table('product_store')->insert($store_insert);
		}
	    return redirect()->back()->with('create_message', 'Variation created successfully');
	}
	

	
	public function deleteVariation($id){
		$photo=DB::table('products')->where('id',$id)->get()[0]->image;
		if(file_exists(public_path('images/product/'.$photo))){
                unlink(public_path('images/product/'.$photo));
		}
		$data['is_active']=false;
		DB::table('products')->where('id',$id)->update($data);
	    return redirect()->back()->with('message', 'Variation deleted successfully');
	}
	
	public function editVariation($id){
		  $ezpos_product_variation=DB::table('products')->where('id',$id)->get()[0];			 
        $products=DB::table('products')->where('is_active', true)->where('is_variation','0')->get();	
		
		return view('product.partial.edit_variation',compact('ezpos_product_variation','products'));
	}
	
	public function updateVariation(Request $request){
		$array = array(  
            'variation_name'  => 'required',  
            'variation_product'  => 'required',    
            'variation_alert'  => 'required',    
        ); 
		
        $this->validate($request, $array);
		$name=DB::table('products')->where('id',$request->variation_product)->get()[0]->name; 
		
		$attachment = $request->variation_image;
		if ($request->hasFile('variation_photo')){ 
		        if(file_exists(public_path('images/product/'.$attachment))){
                  unlink(public_path('images/product/'.$attachment));
		        }
                $files =$request->variation_photo;
                $ext = $files->getClientOriginalExtension();
                $attachment = time().rand(5000,50000).".".$ext;
				
                $file = $files;
                $destinationPath = public_path("images/product");
                $file->move($destinationPath, $attachment);
					
            }
		$id=$request->selected_variation_id; 
		
	    $ins_data['name']=$name.'-'.$request->variation_name;
	    $ins_data['product_id']=$request->variation_product;
	    $ins_data['alert_quantity']=$request->variation_alert;
	    $ins_data['price']=$request->variation_price;
	    $ins_data['image']=$attachment;
		
		DB::table('products')->where('id',$id)->update($ins_data);
	    return redirect()->back()->with('create_message', 'Variation Updated successfully');
	}
	
	public function showProductVariation($id){
 		$data['variations']=DB::table('products')->where('product_id',$id)->where('is_active',true)->get();
	    return view('product.partial.product_variation')->withData($data);
	}


   public function quickAddProduct(){
      return view('product.quick_add_product');
   }


   public function saveExcelData(Request $request){
	   $branch=Auth::user()->branch_id;
	   
     for($i=0; $i<count($request->txt_product_code); $i++ ){
       $data['name']=$request->txt_product_name[$i];
       $data['arabic_name']=$request->txt_product_arabicName[$i];
       $data['code']=$request->txt_product_code[$i];
      if(!is_numeric($data['code'])){
	$data['code']=0;  
	}
       $data['type']='standard';
       $data['barcode_symbology']='EAN13';
       $data['brand_id']=3;
       $data['cost']=0;
       $data['price']=0;
       $data['qty']=0;
       $data['alert_quantity']=0;
       $data['branch_id']=$branch;
       $data['starting_date']=date('Y-m-d');
       $data['last_date']=date('Y-m-d');
       $data['image']='zummXD2dvAtI.png';
       $data['created_at']=date('Y-m-d h:i:s');
       $data['updated_at']=date('Y-m-d h:i:s');
       $data['is_active']=1;
       
     
       DB::table('products')->insert($data);
	   
	   $pid=DB::table('products')->orderBy('id','DESC')->limit(1)->get()[0]->id;
	   $store=DB::table('stores')->where('is_active','1')->get();
		foreach ($store as $str){
			$jdata['store_id']=$str->id;
			$jdata['product_id']=$pid;
			$jdata['qty']=0;
			$jdata['created_at']=date('Y-m-d h:i:s');
			$jdata['updated_at']=date('Y-m-d h:i:s');
			DB::table('product_store')->insert($jdata);
		}
     } 

     return redirect('products')->with('create_message', 'Product created successfully');
   }

   public function  productQty(Request $request){
    $branch=Auth::user()->branch_id;
       
        $role = Role::find(Auth::user()->role_id);
     if($role->hasPermissionTo('products-index')){
 
    $products=DB::table('products')->where('is_active',true);
    if($branch!="Admin"){
     $products=$products->where('branch_id',$branch);
    }
    $products=$products->get();
    $data['products']=$products;

   $data['categories']=DB::table('categories')->where('is_active',true);
   if($branch!="Admin"){
     $data['categories']=$data['categories']->where('branch_id',$branch);   
    }
    $data['categories']=$data['categories']->where('parent_id',null)->get();

     $data['subcategories']=DB::table('categories')->where('is_active',true);
   if($branch!="Admin"){
     $data['subcategories']=$data['subcategories']->where('branch_id',$branch);   
    }
    $data['subcategories']=$data['subcategories']->where('parent_id','!=',null)->get();


    if(isset($request->export)){
        $result= DB::table('products')
            ->join('product_store','product_store.product_id','products.id')
            ->join('stores','stores.id','product_store.store_id')
            ->leftjoin('branches','branches.id','products.branch_id')
            ->leftjoin('categories','categories.id','products.category_id');
            if($branch!="Admin"){
                $result=$result->where('products.branch_id',$branch);
            }
            if($request->name){
                $result=$result->where('products.name','like','%'.$request->name.'%');
            }
            if($request->arname){
                $result=$result->where('products.arabic_name','like','%'.$request->arname.'%');
            }
            if($request->code){
                $result=$result->where('products.code','like','%'.$request->code.'%');
            }
		   $category=$request->category;
           $subcategory=$request->subcategory;
		    if($category and $category !="all"){
               $result=$result->where(function($query) use($category) {$query=$query->where('categories.id',$category)->orwhere('categories.parent_id',$category);});
           } 
		   if($subcategory and $subcategory !="all"){
             $result=$result->where('products.category_id',$subcategory);
           }
          $data['result']=$result=$result->select('products.name','products.arabic_name','products.code','branches.name as branchName','stores.name as storeName','product_store.qty as total_qty')->get();

        

        $export_name= "products-".date("Y-m-d h-i-s");
       $reports= json_decode(json_encode($data['result']), true);
        if(count($reports)>0):
            return Excel::create(''.$export_name.'', function($excel) use ($reports) { 
                $excel->sheet('reports', function($sheet) use ($reports){
                    $sheet->fromArray($reports);
                    });
            })->download('xlsx');
        else:
            return back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        endif;
        return back();

    };



    if(isset($request->search)){
      $result= DB::table('products')
            ->join('product_store','product_store.product_id','products.id')
            ->join('stores','stores.id','product_store.store_id')
            ->leftjoin('branches','branches.id','products.branch_id')
            ->leftjoin('categories','categories.id','products.category_id');
            if($branch!="Admin"){
                $result=$result->where('products.branch_id',$branch);
            }
            
            if($request->name){
                $result=$result->where('products.name','like','%'.$request->name.'%');
            }
            if($request->arname){
                $result=$result->where('products.arabic_name','like','%'.$request->arname.'%');
            }
            if($request->code){
                $result=$result->where('products.code','like','%'.$request->code.'%');
            }
        
		    $category=$request->category;
           $subcategory=$request->subcategory;
		   
		    if($category and $category !="all"){
               $result=$result->where(function($query) use($category) {$query=$query->where('categories.id',$category)->orwhere('categories.parent_id',$category);});
           } 
		   if($subcategory and $subcategory !="all"){
             $result=$result->where('products.category_id',$subcategory);
           }
		 
          $data['result']=$result=$result->select('products.*','branches.name as branchName','stores.name as storeName','categories.parent_id as parentCategory','categories.name as cateName','product_store.qty as total_qty')->get();
          }
            
             $data['name']=$request->name;  
             $data['arname']=$request->arname;  
             $data['code']=$request->code;  
             $data['category']=$request->category;; 
             $data['subcategory']=$request->subCategory;
            
			$permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

            return view('product.product_qty', compact('all_permission'))->withData($data);
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
   
   }

}

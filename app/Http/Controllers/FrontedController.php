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
use \Cart as Cart;
use Auth;
use Mail;
use DNS1D;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class FrontedController extends Controller
{

     public function select_store(){
		 $user_stores=Auth::user()->store_id;
		 $data['user_id']=Auth::user()->id;
		 $role=Auth::user()->role_id;
		 if($role !=6){
			 return redirect('web');
		 }
		 $user_stores=explode("-",$user_stores);
		 $data['stores']=DB::table('stores')->where('is_active','1')->whereIn('id',$user_stores)->get();
		 return view("fronted.select_store")->withData($data);
	 }
      
	public function changeDefaultStore($store,$user){
		DB::table('users')->where('id',$user)->update(['selected_store'=>$store]);
		return redirect('web');
	}   
	 

      public function index(Request $request)
    {
        $reference_id=$request->ref_id; 
        $user_store=Auth::user()->selected_store;
        //$user_store=explode('-',$user_store); 
        $role_id=Auth::user()->role_id;
		$branch=Auth::user()->branch_id;
		
        if($reference_id!=""){ 
	    $result =DB::table('users')->where('phone',$reference_id)->get()->count();
	    if($result==0){
			echo "link is not valid";
            header( "refresh:3;url=".asset('/')."" );
			exit();
		}
	  } 
           
	  $totalCartQty= Cart::count();	
	  $category=DB::table('categories')->where('is_active','1')->where('parent_id',null);
	  if($branch!="Admin"){
		$category=$category->where('branch_id',$branch);  
	  }
	  $category=$category->get();
      $products=DB::table('products')
	       ->join('product_store','product_store.product_id','products.id')
		   ->where('products.is_active','1')
		   ->where('products.is_variation','0');
                  if($role_id != 8){		   
		      $products=$products->where('product_store.store_id',$user_store)
		      ->where('product_store.is_inserted','1');
		  } 
          if($branch!="Admin"){
			  $products=$products->where('products.branch_id',$branch);
		  }		  
		  $products=$products->groupBy('products.id')
		    ->orderBy('products.id','DESC')
		  ->select('products.*',DB::raw('sum(product_store.qty) as storeqty'));		
		   
	  $productQTY=$products->get()->count();
	  $products=$products->limit(15)->get();
          $startFrom=15;
	  return view('fronted.index')->with('user_store',$user_store)->with('category',$category)->with('products',$products)->with('productQTY',$productQTY)->with('totalCartQty',$totalCartQty)->with('reference_id',$reference_id)->with('startFrom',$startFrom);;
	
	}



    	public function load_more(Request $request){
			$branch=Auth::user()->branch_id;
			$user_store=Auth::user()->selected_store;
			//$user_store=explode('-',$user_store);
			$role_id=Auth::user()->role_id;
			
			$id=$request->product_id;
			$sortby=$request->sort_by;
			$sorttype=$request->sort_type;
	  
	    $order="";
        $type="";	
        $pro=DB::table('products')->where('id',$id);
		if($branch!="Admin"){
			$pro=$pro->where('branch_id',$branch);
		}
		$pro=$pro->get()[0];   
	 
	 if($sortby=="date" and $sorttype=="asc"){
		$order="products.id";
        $type="ASC"; 
		
		$operand=">";
		$value=$id;
	 }
	 else if($sortby=="date" and $sorttype=="des"){
	    $order="products.id";
       $type="DESC";

       $operand="<";
		$value=$id;	   
	 }
	 else if($sortby=="price" and $sorttype=="asc"){
		$order="products.price";
       $type="ASC"; 

        $operand=">=";
		$value=$pro->price;	   
	 }
	  else if($sortby=="price" and $sorttype=="des"){
		$order="products.price";
        $type="DESC";
	    
		$operand="<=";
		$value=$pro->price;	
	 }
	$startFrom=$request->start_from;
	// echo $order.' - '.$operand.' - '.$value;  
     
      	 
      $products=DB::table('products')
	      ->join('product_store','product_store.product_id','products.id')
		  ->where('products.is_active','1')->where('products.is_variation','0');
        if($role_id != 8){		  
		  $products=$products->where('product_store.store_id',$user_store)
                  ->where('product_store.is_inserted','1') ;
		}
        if($branch!="Admin"){
			$products=$products->where('products.branch_id',$branch);
		}     
                   $products=$products->groupBy('products.id')
                  ->select('products.*',DB::raw('sum(product_store.qty) as storeqty'))
		  ->orderBy($order,$type)->offset($startFrom)->limit(15)->get();
	
       $end_num=$startFrom+15;		  
      if($products->count()>0){	 
	    return view('fronted.load_more')->with('products',$products)->with('startFrom',$end_num);
	  }
	   return 'no_date';
	}
	
	
	
	public function load_more_cat_item(Request $request){
	  $user_store=Auth::user()->selected_store;
          //$user_store=explode('-',$user_store);
	  $role_id=Auth::user()->role_id;
	  $branch=Auth::user()->branch_id;
	  
	  $id=$request->product_id;
	  $sortby=$request->sort_by;
	  $sorttype=$request->sort_type;
	  $category=$request->category;
	  
	    $order="";
       $type="";	
      $pro=DB::table('products')->where('id',$id);
	  if($branch!="Admin"){
		$pro=$pro->where('branch_id',$admin);  
	  }
	  $pro=$pro->get()[0];   
	 
	 if($sortby=="date" and $sorttype=="asc"){
		$order="products.id";
        $type="ASC"; 
		
		$operand=">";
		$value=$id;
	 }
	 else if($sortby=="date" and $sorttype=="des"){
	    $order="products.id";
       $type="DESC";

       $operand="<";
		$value=$id;	   
	 }
	 else if($sortby=="price" and $sorttype=="asc"){
		$order="products.price";
       $type="ASC"; 

        $operand=">=";
		$value=$pro->price;	   
	 }
	  else if($sortby=="price" and $sorttype=="des"){
		$order="products.price";
        $type="DESC";
	    
		$operand="<=";
		$value=$pro->price;	
	 }
	$startFrom=$request->start_from;
	$end_num=$startFrom+15;	
	
		if($category=="all"){		
		   $products=DB::table('products')
		   ->join('product_store','product_store.product_id','products.id')
		  ->where('products.is_active','1')->where('products.is_variation','0');
		  if($role_id !=8){
		   $products=$products->where('product_store.store_id',$user_store)
                  ->where('product_store.is_inserted','1');
		  }
          if($branch!="Admin"){
			$products=$products->where('products.branch_id',$branch);  
		  }     
                 $products=$products->groupBy('products.id')
                  ->select('products.*',DB::raw('sum(product_store.qty) as storeqty'))
		  ->orderBy($order,$type)->offset($startFrom)->limit(15)->get();
		}
		else{
          $products=DB::table('products')
		  ->join('product_store','product_store.product_id','products.id')
		  ->leftjoin('categories','categories.id','products.category_id')
		  ->where('products.is_active','1')->where('products.is_variation','0')->where(function($query) use($category){
		  	  $query=$query->where('products.category_id',$category)->orWhere('categories.parent_id',$category);
		  });
		 if($role_id !=8){  
		  $products=$products->where('product_store.store_id',$user_store)
                  ->where('product_store.is_inserted','1');
		 }
           if($branch!="Admin"){
			$products=$products->where('products.branch_id',$branch);  
		  }        
                    $products=$products->groupBy('products.id')
		    ->select('products.*',DB::raw('sum(product_store.qty) as storeqty'))
		    ->orderBy($order,$type)->offset($startFrom)->limit(15)->get();
		}
		
		
	  if($products->count()>0){	 
	    return view('fronted.load_more_cate_itmes')->with('products',$products)->with('cid',$category)->with('startFrom',$end_num);
	  }
	   return 'no_date';
	}

	


  
  public function selectProduct($id){
	    $user_store=Auth::user()->selected_store;
	  //  $user_store=explode('-',$user_store);
	    $role_id=Auth::user()->role_id;
		
      $productImages=DB::table('product_gallery_images')->where('product_id',$id)->get();   
      $productVariation=DB::table('products')->where('product_id',$id)->where('is_variation','1')->get();   
      $products=DB::table('products')
	  ->leftjoin('categories','categories.id','products.category_id')
	  ->join('product_store','product_store.product_id','products.id')
	  ->where('products.id',$id);
     if($role_id !=8){	  
	  $products=$products->where('product_store.store_id',$user_store)
         ->where('product_store.is_inserted','1');
	 }
        
          $products=$products->groupBy('products.id')
	  ->select('products.*','categories.name as cateName',DB::raw('sum(product_store.qty) as storeqty'))
	  ->get();

      return view('fronted.partials.product_details')->with('products',$products)->with('productImages',$productImages)->with('productVariation',$productVariation);	 
   }


   
  public function productDetail($id,$reference_id=""){
	   $user_store=Auth::user()->selected_store;
           //$user_store=explode('-',$user_store);
	   $role_id=Auth::user()->role_id;
	   
	  $totalCartQty= Cart::count();	
	  $productImages=DB::table('product_gallery_images')->where('product_id',$id)->get();   
	  $productVariation=DB::table('products')->where('product_id',$id)->where('is_variation','1')->get();   
	  $products=DB::table('products')
	  ->leftjoin('categories','categories.id','products.category_id')
	  ->join('product_store','product_store.product_id','products.id')
	  ->where('products.id',$id);
	   if($role_id !=8){
	       $products=$products->where('product_store.store_id',$user_store)
               ->where('product_store.is_inserted','1');
	   }
          
          $products=$products->groupBy('products.id')
	  ->select('products.*','categories.name as cateName',DB::raw('sum(product_store.qty) as storeqty'))
	  ->get();

	  
	  $moreProducts=DB::table('products')
	  ->join('product_store','product_store.product_id','products.id');
      if($role_id !=8){	  
	   $moreProducts=$moreProducts->where('product_store.store_id',$user_store)
            ->where('product_store.is_inserted','1');
            //->where('product_store.qty','>',0);      
}
        
          $moreProducts=$moreProducts->groupBy('products.id')
	  ->where('products.is_active','1')->where('products.is_variation','0')
	  ->select('products.*','categories.name as cateName',DB::raw('sum(product_store.qty) as $product'))
	  ->orderBy('products.id','DESC');	  
	  $productQTY=$moreProducts->get()->count();
	  $moreProducts=$moreProducts->limit(15)->get();
	  
	  
      return view('fronted.single_product')->with('products',$products)->with('productImages',$productImages)->with('totalCartQty',$totalCartQty)->with('productVariation',$productVariation)->with('reference_id',$reference_id)->with('moreProducts',$moreProducts)->with('productQTY',$productQTY);	 
   
   }
 
public function selectCategory($id){
     $user_store=Auth::user()->selected_store;
    // $user_store=explode('-',$user_store);
     $branch=Auth::user()->branch_id;
      $role_id=Auth::user()->role_id;
    if($id=="all"){
		  $catename="كل المنتجات"; 
		 $products=DB::table('products')
	    //->join('products','products.category_id','categories.id')
	   ->join('product_store','product_store.product_id','products.id');
     if($role_id!=8){	  
	   $products=$products->where('product_store.store_id',$user_store)
          ->where('product_store.is_inserted','1');
	 }
     if($branch!="Admin"){
		$products=$products->where('products.branch_id',$branch); 
	 }     
          $products=$products->groupBy('products.id')
	   ->where('products.is_active',1)
	    ->where('products.is_variation','0')
	   ->select('products.*', DB::raw('sum(product_store.qty) as storeqty'))
	   ->orderBy('products.id','DESC');  
	   }
	  else{ 
	  $catename=DB::table('categories')->where('id',$id)->get()[0]->name;
	   $products=DB::table('categories')
	   ->join('products','products.category_id','categories.id')
	   ->join('product_store','product_store.product_id','products.id');
	   if($role_id!=8){
	   $products=$products->where('product_store.store_id',$user_store)
            ->where('product_store.is_inserted','1');
	   }
        if($branch!="Admin"){
		$products=$products->where('products.branch_id',$branch); 
	   }   
          $products=$products->groupBy('products.id')   
	   ->where('products.is_active',1)
	   ->where('products.is_variation','0')
	   ->where(function($query) use($id){
	   	$query=$query->where('categories.id',$id)
	   ->orWhere('categories.parent_id',$id);
	   })
	   ->select('products.*', DB::raw('sum(product_store.qty) as storeqty'))
	   ->orderBy('products.id','DESC');
	  } 
	  $productQTY=$products->get()->count();
	  $products=$products->limit(15)->get();
          $startFrom=15;

         $parentid=$id;
         $checkCategory=DB::table('categories')->where('id',$id)->first();   
         if($checkCategory->parent_id!=null){
          $parentid=$checkCategory->parent_id;
         }
         $childCategory=DB::table('categories')->where('is_active',1)->where('parent_id',$parentid)->get(); 

      return view('fronted.partials.products')->with('products',$products)->with('productQTY',$productQTY)->with('catename',$catename)->with('id',$id)->with('catename',$catename)->with('id',$id)->with('startFrom',$startFrom)->with('childCategory',$childCategory);  }


public function searchProduct($word){
	   $user_store=Auth::user()->selected_store;
           //$user_store=explode('-',$user_store);
	   $branch=Auth::user()->branch_id;
	   $role_id=Auth::user()->role_id;
	   
	   if($word!="null"):
	   	  $products=DB::table('products')
		  ->join('product_store','product_store.product_id','products.id')
		  ->where('products.is_active',1)
                  ->where( function ($query) use ($word){               
                  $query
				->where('products.arabic_name','LIKE','%'.$word.'%')
				->orWhere('products.code','LIKE','%'.$word.'%')
				->orWhere('products.name','LIKE','%'.$word.'%');
                 }); 
		  if($role_id !=8){
		  $products=$products->where('product_store.store_id',$user_store)
                  ->where('product_store.is_inserted','1');
                
	      }
         if($branch!="Admin"){
			$products=$products->where('products.branch_id',$branch); 
		 }     
          $products=$products->groupBy('products.id')		
		  ->select('products.*',DB::raw('sum(product_store.qty) as storeqty'))
		  ->get();
		  return view('fronted.partials.search_result')->with('products',$products);	 
		else:
		  return "type any thing...";
		endif;
   }
   
   public function cart($reference_id=""){
	    $branch=Auth::user()->branch_id;
		
             if($reference_id!=""){ 
	    $result =DB::table('users')->where('phone',$reference_id)->get()->count();
	    if($result==0){
			echo "link is not valid";
                       header( "refresh:3;url=".asset('cart')."" );
 
			exit();
		}
	  }

	   $totalCartQty= Cart::count();
	   return view('fronted.cart')->with('totalCartQty',$totalCartQty)->with('reference_id',$reference_id);
   }
   
  public function add_to_cart($id,$coupon,$currency){
    $products=DB::table('products')->where('id',$id)->get()[0];  
	
       $extl=$products->external_link;
	if($extl==1){
	  $image=$products->image; 
	}
	else{
	  $image=asset('public/images/product').'/'.$products->image;
	}

	$name=$products->name;   
	$id=$products->id;   
	$price=$products->price;   
	if($currency=="ar"){
	    $price=(double)$price*1200;
	 }
 
  if($coupon !="null"):	
    $cat=$products->category_id; 
    $dvalue=DB::table('coupon_category')->where('copupon',$coupon)->where('category',$cat)->get()[0]->value;
	
    
	$price=$price-$price*$dvalue/100;
	
   endif;
  Cart::add($id, $name , 1, floor((double)$price*100)/100, ['image' => $image,'description'=>'','currency'=>$currency]);
     return Cart::count();
   }
   
  
   
    public function add_to_cart_search($id,$coupon,$currency){
    $products=DB::table('products')->where('id',$id)->get()[0];   
	
	$extl=$products->external_link;
	if($extl==1){
	  $image=$products->image; 
	}
	else{
		$image=asset('public/images/product').'/'.$products->image;
	}

	$name=$products->name;   
	$id=$products->id;   
	$price=$products->price;  

       if($currency=="ar"){
		 $price=(double)$price*1200;
	 }
 
	 
   if($coupon !="null"):	
      $cat=$products->category_id; 
      $dvalue=DB::table('coupon_category')->where('copupon',$coupon)->where('category',$cat)->get()[0]->value;
	
      $price=$price-$price*$dvalue/100;
   endif;
   Cart::add($id, $name , 1, floor((double)$price*100)/100, ['image' => $image,'description'=>'','currency'=>$currency]);
     return redirect()->back();
   }


   public function cart_items($reference_id=""){  
           $country=DB::table('country')->get();  
	   return view('fronted.partials.cart-items')->with('country',$country)->with('reference_id',$reference_id);
   }
   
   public function remove_item($id){
	   Cart::remove($id);
	   return Cart::count().'-'.Cart::subtotal();
   }
   
   public function increaseItem($id){
	 $item=Cart::get($id);
     $totalQty=$item->qty;
	 $totalQty=$totalQty+1;
	 Cart::update($id, $totalQty);
	 return Cart::count().'-'.Cart::subtotal();	 
   }
   
   public function decreaseItem($id){
	   $item=Cart::get($id);
     $totalQty=$item->qty;
	 $totalQty=$totalQty-1;
	 Cart::update($id, $totalQty);
	 return Cart::count().'-'.Cart::subtotal();
   }

 public function sendRequest(Request $request){
	   $user_store=Auth::user()->selected_store;
	   $userName=Auth::user()->name;
	   $userPhone=Auth::user()->phone;
	   $user_id=Auth::user()->id;
	   $role_id=Auth::user()->role_id;
	   $branch=Auth::user()->branch_id;
	   
	   $array = array(  
            'firstname'  => 'required',  
            'phone'  => 'required',  
        ); 
         //$this->validate($request, $array);
	    //$data['customer_name']= $request->firstname;
	    //$data['customer_phone']=$request->phone;
		$data['customer_name']= $userName;
	    $data['customer_phone']=$userPhone;
	    $data['customer_store']=$user_store;
		
	    $data['customer_city']=$request->city;
        $data['order_note']=$request->order_note;
		$data['subtotal']= (double)str_replace(',', '', Cart::subtotal());
		$data['shipping_cost']=$request->shipping_cost;
		$data['total']=$request->total_cost;
		$data['reference_id']=$request->reference_id;
		$data['delivery_type']=$request->deliver_type;
        $data['status']='waiting';
        $data['branch_id']=$branch;
		
		 if($request->print_save =="sandp"){
		     $data['status']='offer';
	       }

		if($request->is_valid_coupon=="1"){
			$cn=$request->cobun_number;
			$result=DB::table('cobuns')->where('cobun_number',$cn)->get()[0];
			        DB::table('cobuns')->where('cobun_number',$cn)->decrement('number_of_use',1);
			
			//$subtotal = str_replace( ',', '', Cart::subtotal());
			//$subtotal=number_format($subtotal, 0, '.', '');
			//$discountPrecen=$result->value;
			//$data['discount']=$subtotal*$discountPrecen/100; 
			
			//$data['subtotal']=$subtotal-$data['discount'];
			
			$data['coupon_nu']=$request->cobun_number;
			//$data['total']=$subtotal-$data['discount']+$data['shipping_cost'];	
		}
		if($role_id ==8){
			$data['is_marketer_order']='1';
            $data['marketer_note']=$request->marketer_order_note;
		}
		DB::table('request')->insert($data);
		$id = DB::getPdo()->lastInsertId();
		
		$saleData['date']=date('Y-m-d');
		$saleData['reference_no']='sr-' . date("Ymd") . '-'. date("his");
		$saleData['user_id']=$user_id;
		$saleData['customer_id']='6';
		$saleData['store_id']=$user_store;
		$saleData['item']='0';
		$saleData['total_qty']=Cart::count();
		$saleData['total_discount']='0';
		$saleData['total_tax']='0';
		$saleData['total_price']=(double)str_replace(',', '', Cart::subtotal());
		$saleData['grand_total']=$request->total_cost;
		$saleData['order_tax_rate']='0';
		$saleData['order_tax']='0';
		$saleData['order_discount']='0';
		$saleData['shipping_cost']=$request->shipping_cost;
		$saleData['sale_status']='1';
		$saleData['payment_status']='2';
		$saleData['document']='';
		$saleData['paid_amount']='0';
		$saleData['sale_note']=$request->order_note;
		$saleData['staff_note']='';
		$saleData['branch_id']=$branch;
		$saleData['request_id']=$id;
		$saleData['created_at']=date('Y-m-d h:i:s');
		$saleData['updated_at']=date('Y-m-d h:i:s');
		
		if($role_id !=8){
			DB::table('sales')->insert($saleData);
		}
		
		$saleid = DB::getPdo()->lastInsertId();
		
		foreach(Cart::content() as $product):
          $real=DB::table('products')->where('id',$product->id)->get()[0];
		
		  $cdata['product_id']=$product->id;
		  $cdata['product_name']=$real->name;
		  $cdata['product_price']=$real->price;
		  $cdata['ch_product_name']=$product->name;
		  $cdata['ch_product_price']=$product->price;
          $cdata['changed_description']=$product->options->description;
		  $cdata['currency']=$product->options->currency;

		  $cdata['request_id']=$id; 
		  $cdata['product_qty']=$product->qty;	  
		  DB::table('product_request')->insert($cdata);
		  
		   $rdata['sale_id']=$saleid;		   
           $rdata['product_id']=$product->id; 		   
           $rdata['qty']=$product->qty; 		   
           $rdata['unit']='';		   
           $rdata['net_unit_price']=$real->price; 		   
           $rdata['discount']='0';		   
           $rdata['tax_rate']='0';		   
           $rdata['tax']='0';		   
           $rdata['total']=$product->qty*$real->price;	   
           $rdata['created_at']= date('Y-m-d h:i:s'); 		   
           $rdata['updated_at']= date('Y-m-d h:i:s');		   
		   
		   
		    $get_balance=DB::table('item_movement')->where('product_id',$product->id)->where('store_id',$user_store)->get();
			$total_in=$get_balance->sum('qty_in');
			$total_out=$get_balance->sum('qty_out');
			$balance=$total_in-$total_out-$product->qty;
			
		   $mdata['date']=date('Y-m-d');
		   $mdata['time']=date('h:i:s');
		   $mdata['user']=Auth::id();
		   $mdata['product_id']=$product->id;
		   $mdata['category_id']=DB::table('products')->where('id',$product->id)->get()[0]->category_id;
		   $mdata['store_id']=$user_store;
		   $mdata['qty_in']='0';
		   $mdata['qty_out']=$product->qty; 
		   $mdata['balance']=$balance;
		   $mdata['branch_id']=$branch;
		   $mdata['type_invoice']='sell';
		   $mdata['description']='';
		   $mdata['reference']=$saleData['reference_no'];
		   
		  if($role_id !=8){
			DB::table('product_sales')->insert($rdata);
		   DB::table('item_movement')->insert($mdata);
		
		 
		   $items=DB::table('product_store')->where('store_id',$user_store)->where('product_id',$product->id);
	   
	       if(count($items->get())>0){
					$items->decrement('qty',$product->qty); 
				 }	
            else{
				$insData['store_id']=$user_store;	
				$insData['product_id']=$product->id;	
				$insData['qty']=$product->qty;	
				$insData['created_at']=date('Y-m-d h:i:s');	
				$insData['updated_at']=date('Y-m-d h:i:s');	
				DB::table('product_store')->insert($insData);	
		   }	
		
         }		
		endforeach;
           
		   session()->flash('message','Request Sent Successfully');

            $reference_id=$request->reference_id;
            $totalCartQty= Cart::count();
            
     
            $countryName="";
            if($request->deliver_type=="deliver"){
	          $countryName=DB::table('country')->where('country_id',$request->city)->get()[0]->country;
	     }
	      /*  $sendEmail=0; 
			if($sendEmail==1){
			  $emailData['name']=$request->firstname;
	                  $emailData['phone']=$request->phone;
	                  $emailData['city']= $countryName;
	                  $emailData['bill_no']=$id;
	                  $emailData['Delivery_Type']=$request->deliver_type;
	                  $emailData['total']=$request->total_cost;
	                  $emailData['total_qty']=$totalCartQty;
	                  $emailData['status']=$data['status'];
	                  $emailData['link']=asset("/orders/print/$id/$reference_id");
				 
		     Mail::send('mail', $emailData, function($message) use($emailData)
		     {
		      $message->to('kokapp2015@gmail.com', 'online sales')->subject($emailData['bill_no'].' - '.' - '.$emailData['Delivery_Type'].' - '.$emailData['status']);
		    });
		 }
         */
             Cart::destroy();
            if($request->print_save =="sandp"){
		 return redirect("orders/print/$id/$reference_id");
            }
	    else{
               return redirect('orders/requestSent?ref='.$reference_id.'&req_id='.$id);
	     }
		  ///note here
        }

   

    public function requestSent(){
	    $totalCartQty= Cart::count();
        return view('fronted.request_sent')->with('totalCartQty',$totalCartQty);
   }

  
  public function changeQty($itemID, $qty){
	  Cart::update($itemID, $qty);
	  return Cart::count().'-'.Cart::subtotal();
  }

 
 public function checkCouponNumber(Request $request){
	 $cp=$request->cpn;
	 $coupons=DB::table('cobuns')->where('cobun_number',$cp)->get();
     if(count($coupons)>0){
		 if($coupons[0]->number_of_use==0){
			 return 'ended_nubmer_of_use';  
		 }
		 else if($coupons[0]->expire_date<date('Y-m-d')){
			 return 'expire_date';
		 }
		 else{
			 
			 $coupons=DB::table('coupon_category')->where('copupon',$cp)->get();
			 $couponCat="";
			 $couponValue="";
			 foreach($coupons as $cop){
			    $couponCat.=$cop->category.'-';	
                $couponValue.=$cop->value.'-';				
			 }
			 
			 $couponCat=rtrim($couponCat,'-');
			 $couponValue=rtrim($couponValue,'-');
			 
			 return $cp.'&&'.$couponValue.'&&'.$couponCat;
		 }
	 }
	 else{
		 return "not_valid";
	 }
 }

 
 public function calculateCoupon($id){
	 $result=DB::table('cobuns')->where('cobun_number',$id);
		if($result->count()>0){
			
			$discountCat=explode('-',$result->get()[0]->categories);			
			$discountValue=0;
			foreach( Cart::content() as $item){
				$presult=DB::table('products')->where('id',$item->id)->get();
				for($i=0; $i<count($discountCat); $i++){	
					if($presult[0]->category_id==$discountCat[$i]){
					  $discountValue=$discountValue+$presult[0]->price*$item->qty*$result->get()[0]->value/100;
					  break;
					}
				}
			}
		//echo Cart::subtotal().'-'.$discountValue;
		return $discountValue;	
		}
		else{
		  return 0;	
		}
     }
 
 
public function requestPrint(Request $request){
   $data['reference_id']=$request->ref;
   $req_id=$request->id;
   
   $data['order']=DB::table('request')->leftjoin('country','country.country_id','request.customer_city')->where('request.id',$req_id)->select('request.*','country.country as cityName')->get();
   $data['orderItems']=DB::table('product_request')->join('products','products.id','product_request.product_id')->leftjoin('categories','categories.id','products.category_id')->where('product_request.request_id',$req_id)->select('products.name as productName','products.arabic_name as productArName','products.image','products.external_link','products.code as barcode','product_request.product_qty','product_request.ch_product_price','products.product_details','product_request.ch_product_name','product_request.currency','categories.name as cate_name')->get();
   $totalCartQty= Cart::count();
    return view('fronted.request_print')->withData($data)->with('totalCartQty',$totalCartQty)->with('reference_id',$request->ref);   
  }
 
 
public function changeCartItem(Request $request){
	$id=$request->selectedrowId;
	$pname= $request->product_name;
	$pprice= $request->product_price;
	$description=$request->description;
	
	if(!$pname and !$pprice ){
		return redirect('cart');
	}
	 if($pname){
		Cart::update($id, ['name' => $pname]); 
	}
	 if($pprice){
		Cart::update($id, ['price' => $pprice]); 
	}
	if($description){
		$image=Cart::get($id)->options->image;
		$currency=Cart::get($id)->options->currency;
		Cart::update($id, ['options' =>['description'=>$description,'image'=>$image,'currency'=>$currency]]); 
	 
	}
	return redirect('cart');
}  


 
  public function getSortedProdcut(Request $request){
	 $user_store=Auth::user()->selected_store;
        // $user_store=explode('-',$user_store);
	 $role_id=Auth::user()->role_id;
	 $branch=Auth::user()->branch_id;
	 
	 $category=$request->category;
	 $sortby=$request->sort_by;
	 $sorttype=$request->sort_type;
     $startFrom=15;
       $order="";
       $type="";	  
	 if($sortby=="date" and $sorttype=="asc"){
		$order="products.id";
       $type="ASC"; 
	 }
	 else if($sortby=="date" and $sorttype=="des"){
		$order="products.id";
       $type="DESC";  
	 }
	 else if($sortby=="price" and $sorttype=="asc"){
		$order="products.price";
       $type="ASC";  
	 }
	  else if($sortby=="price" and $sorttype=="des"){
		$order="products.price";
       $type="DESC";  
	 }
	
	
		  
	  $products=DB::table('products')
	        ->join('product_store','product_store.product_id','products.id')
	        ->leftjoin('categories','categories.id','products.category_id');
	         if($role_id!=8){
		    $products=$products->where('product_store.store_id',$user_store)
                     ->where('product_store.is_inserted','1');
	         }
			 if($branch!="Admin"){
			$products=$products->where('products.branch_id',$branch);    	 
			 }
		    $products=$products->groupBy('products.id')
			 ->where('products.is_active','1')->where('products.is_variation','0');
			 if($category!='undefined' and $category!='all'){
		      $products=$products->where(function($query) use($category){
		      	$query=$query->where('products.category_id',$category)->orWhere('categories.parent_id',$category);
		      });		
			} 
			$products=$products->select('products.*', DB::raw('sum(product_store.qty) as storeqty'))->orderBy($order,$type)->limit(15)->get();	  
       
	   if($category!='undefined' and $category!='all'){
	      return view('fronted.load_more_cate_itmes')->with('products',$products)->with('cid',$category)->with('startFrom',$startFrom);
	   }
	   else{
		  return view('fronted.load_more')->with('products',$products)->with('startFrom',$startFrom); 
	   }
	  
 }





  public function changeCurrncy($cu){	 
	 foreach (Cart::content() as $product):
	  $currency = $cu;
	  $image = $product->options->image;
	  $description = $product->options->description;
	  
	  $cprice= (double)$product->price;
	  if($cu !=$product->options->currency){
		if($cu=="ar"){
			$cprice=$cprice*1200;
		}
		else{
			$cprice=$cprice/1200;
		}
		
		Cart::update($product->rowId, ['price'=>$cprice,'options' =>['description'=>$description,'image'=>$image,'currency'=>$currency]]); 
	  }
	 endforeach;
	
    return redirect()->back();	
 }
 

  public function changeUserStore(Request $request){
     $id=	 $request->user_id;
  $store= $request->selected_store;
   Cart::destroy();
   DB::table('users')->where('id',$id)->update(['selected_store'=>$store]);
   return redirect('web');
	
	}

 }	

?>
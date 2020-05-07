<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Returns;
use App\Purchase;
use App\Payment;
use App\Product_Sale;
use DB;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     public function importProduct(){
		 $product=DB::table('products')->where('is_active','1')->get();
	     foreach ($product as $pr){
			 $data['product_id']=$pr->id;
			 $data['store_id']='11';
			 $data['qty']='0';
			 DB::table('product_store')->insert($data);
		 }
	 }



    public function index(Request $request)
    {         
       $user_role=Auth::user()->role_id;
       $storeid=Auth::user()->store_id;
       $branch=Auth::user()->branch_id;
       
	   $data['store_cat']=DB::table('store_category')
	   ->where('is_active','1');
	   if($branch!="Admin"){
		$data['store_cat']=$data['store_cat']->where('branch_id',$branch);   
	   }
	   $data['store_cat']=$data['store_cat']->get();
	   
       return view('index')->withData($data);
	   }


      public function showAllStore(Request $request)
    {         
	  
       $user_role=Auth::user()->role_id;
       $storeid=Auth::user()->store_id;
       //$id=$request->id;
       $branch=Auth::user()->branch_id;

       $stores=DB::table('stores')
       ->where('is_active','1');
       if($branch !="Admin"){
           $stores=$stores->where('branch_id',$branch);
       }
       $data['stores']=$stores->get();
       //$data['store_category']=$id;
       return view('all_store')->withData($data);
       }

    public function dashboardFilter($start_date, $end_date)
    {
        $revenue = Sale::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('grand_total');
        $return = Returns::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('grand_total');
        $revenue -= $return;
        $purchase = Purchase::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('grand_total');
        $profit = $revenue - $purchase;
        $sold_qty = Sale::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('total_qty');

        $data[0] = $revenue;
        $data[1] = $return;
        $data[2] = $profit;
        $data[3] = $sold_qty;
        return $data;

    }
	
	public function index1(Request $request)
    {                      
         $language= DB::table('languages')->get()[0];
		 $request->session()->put('language',$language->code);
		 
		 
        $start_date = date("Y").'-'.date("m").'-'.'01';
        $end_date = date("Y").'-'.date("m").'-'.'31';
        $yearly_sale_amount = []; 

        $revenue = Sale::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('grand_total');
        $return = Returns::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('grand_total');
        $revenue -= $return;
        $purchase = Purchase::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('grand_total');
        $profit = $revenue - $purchase;
        $sold_qty = Sale::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('total_qty');
        $recent_sale = Sale::orderBy('id', 'desc')->take(5)->get();
        $recent_purchase = Purchase::orderBy('id', 'desc')->take(5)->get();
        $recent_return = Returns::orderBy('id', 'desc')->take(5)->get();
        $recent_payment = Payment::orderBy('id', 'desc')->take(5)->get();

        $best_selling_qty = DB::table('sales')
                        ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->select(DB::raw('product_sales.product_id, sum(product_sales.qty) as sold_qty'))->whereDate('sales.date', '>=' , $start_date)->whereDate('sales.date', '<=' , $end_date)->groupBy('product_sales.product_id')->orderBy('sold_qty', 'desc')->take(5)->get();

        $yearly_best_selling_qty = DB::table('sales')
                        ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->select(DB::raw('product_sales.product_id, sum(product_sales.qty) as sold_qty'))->whereDate('sales.date', '>=' , date("Y").'-01-01')->whereDate('sales.date', '<=' , date("Y").'-12-31')->groupBy('product_sales.product_id')->orderBy('sold_qty', 'desc')->take(5)->get();

        $yearly_best_selling_price = DB::table('sales')
                        ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->select(DB::raw('product_sales.product_id, sum(product_sales.total) as total_price'))->whereDate('sales.date', '>=' , date("Y").'-01-01')->whereDate('sales.date', '<=' , date("Y").'-12-31')->groupBy('product_sales.product_id')->orderBy('total_price', 'desc')->take(5)->get();

        $start = strtotime(date("Y") .'-01-01');
        $end = strtotime(date("Y") .'-12-31');
        while($start < $end)
        {
            $start_date = date("Y").'-'.date('m', $start).'-'.'01';
            $end_date = date("Y").'-'.date('m', $start).'-'.'31';
            $sale_amount = Sale::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('grand_total');
            $purchase_amount = Purchase::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('grand_total');

             $yearly_sale_amount[] = number_format((float)$sale_amount, 2, '.', '');
             $yearly_purchase_amount[] = number_format((float)$purchase_amount, 2, '.', '');
             $start = strtotime("+1 month", $start);
        }
        return view('nindex', compact('revenue', 'return', 'profit', 'sold_qty', 'yearly_sale_amount', 'yearly_purchase_amount', 'recent_sale', 'recent_purchase', 'recent_return', 'recent_payment', 'best_selling_qty', 'yearly_best_selling_qty', 'yearly_best_selling_price'));
    }
	public function search_product($word){
		$result=DB::table('products')->where('name','LIKE','%'.$word.'%')->where('is_active','1')->get();
		return view('home.search_products')->with('result',$result);
	}
	
	public function selectProduct($id){
       return view('home.selectProduct')->with('id',$id);
	}
	
	function OrderList(Request $request){
		//$data['title']='مخزن الصناعة الجديد';
		$branch=Auth::user()->branch_id;
		$store_id=$request->id; 
		$data['store_id']=$store_id;

        $storeName=DB::table('stores')->where('id',$store_id)->get()[0]->name; 
		$data['title']=$storeName;

		$data['sale']=DB::table('sales')
		              ->join('users','users.id','sales.user_id')
		              ->where('sales.store_id',$store_id);
					  if($branch!="Admin"){
						$data['sale']=$data['sale']->where('sales.branch_id',$branch);  
					  }
					  $data['sale']=$data['sale']->select('sales.*','users.name as userName','users.full_name as fullName')
                                         ->orderBy('sales.date','DESC')
					  ->get();
		//DB::table('request')->where
		return view('order.view')->withData($data);
	}


    public function OrderDetails(Request $request){
     $data['products']=DB::table('product_sales')->join('products','products.id','product_sales.product_id')->leftjoin('categories','categories.id','products.category_id')->where('product_sales.sale_id',$request->id)->select('products.name as pro_name','products.arabic_name','products.code','product_sales.*','categories.name as cateName','categories.parent_id as parentCategory')->get();
     $data['order']=DB::table('sales')
	                ->join('stores','stores.id','sales.store_id')
	                ->join('customers','customers.id','sales.customer_id')
					->select('sales.*','customers.name as customerName','stores.name  as storeName')
					->where('sales.id',$request->id)->get();
	 return view('order.details')->withData($data);
   }


	function ProductMovementList(Request $request){
		$branch=Auth::user()->branch_id;
		//echo $branch;exit;
		$storeId=$request->id;
                $data['sales_count']=DB::table('sales')
		              ->where('order_status','0')->where('store_id',$storeId);
					   if($branch !="Admin"){
							$data['sales_count']=$data['sales_count']->where('sales.branch_id',$branch);  
						  }
					 $data['sales_count']=$data['sales_count']->count();		

		$streName=DB::table('stores')->where('id',$storeId)->get()[0]->name;
		$data['title']=$streName;
		$data['store_id']=$storeId;
		$data['breadcrumb'] = array('جرد مخزني', 'حركة المنتجات');
		$data['products']=DB::table('item_movement')
		                  ->join('products','products.id','item_movement.product_id')
						  ->leftjoin('categories','categories.id','products.category_id')
						  ->where('item_movement.store_id',$storeId);
						  if($branch !="Admin"){
							$data['products']=$data['products']->where('item_movement.branch_id',$branch);  
						  }
						  //->groupBy('item_movement.product_id')
						 $data['products']=$data['products']->select('item_movement.*','products.name as productname','products.arabic_name as productArabicName','products.code as productCode','categories.name as catename','categories.parent_id as parentCategory')->orderBy('item_movement.id','DESC')
						  ->get();
						  
		return view('store.product_movement')->withData($data);
	}

function changerOrderStatus(Request $request){
		$checked=$request->is_checked;
		$saleid= $request->sale_id;
		
		DB::table('sales')->where('id',$saleid)->update(['order_status'=>$checked]);
	}
}

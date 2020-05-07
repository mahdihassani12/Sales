<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductPurchase;
use App\Product_Sale;
use App\ProductQuotation;
use App\Sale;
use App\Purchase;
use App\Returns;
use App\Payment;
use App\Store;
use App\Product_Store;
use App\Expense;
use App\Customer;
use App\Supplier;
use DB;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Excel;
class ReportController extends Controller
{
    public function productQuantityAlert()
    {
        $branch=Auth::user()->branch_id;
		$role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('product-qty-alert')){
           
		   //$ezpos_product_data = Product::where('is_active', true)->whereColumn('alert_quantity', '>', 'qty')->get();
           // return view('report.qty_alert_report', compact('ezpos_product_data'));
        
		  $ezpos_product_data=DB::table('product_store')
		      ->join('products','products.id','product_store.product_id')
			  ->join('stores','stores.id','product_store.store_id')
              ->leftjoin('categories','categories.id','products.category_id')
			  ->where('products.is_active',true)
			  ->where('stores.is_active',true)
			  ->where('product_store.is_inserted','1')
			  ->where('products.alert_quantity','>','product_store.qty');
			  if($branch!="Admin"){
			     $ezpos_product_data=$ezpos_product_data->where('products.branch_id',$branch);	  
			   }
			  $ezpos_product_data=$ezpos_product_data->select('products.*','stores.name as storeName','product_store.qty as sqty','categories.name as cateName','categories.parent_id as parentCategory')
			  ->get();
			  
		 return view('report.qty_alert_report', compact('ezpos_product_data'));
		}
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
   
    }

    public function storeStock()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('store-stock-report')){
            $total_item = DB::table('product_store')
                        ->join('products', 'product_store.product_id', '=', 'products.id')
                        ->where([
                            ['products.is_active', true],
                            ['product_store.qty', '>' , 0]
                        ])->count();

            $total_qty = Product::where('is_active', true)->sum('qty');
            $total_price = DB::table('products')->where('is_active', true)->sum(DB::raw('price * qty'));
            $total_cost = DB::table('products')->where('is_active', true)->sum(DB::raw('cost * qty'));
            $ezpos_store_list = Store::where('is_active', true)->get();
            $store_id = 0;
            return view('report.store_stock', compact('total_item', 'total_qty', 'total_price', 'total_cost', 'ezpos_store_list', 'store_id'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function storeStockById(Request $request)
    {
        $data = $request->all();
        if($data['store_id'] == 0)
            return redirect()->back();

        $total_item = DB::table('product_store')
                        ->join('products', 'product_store.product_id', '=', 'products.id')
                        ->where([
                            ['products.is_active', true],
                            ['product_store.qty', '>' , 0],
                            ['product_store.store_id', $data['store_id']]
                        ])->count();
        $total_qty = DB::table('product_store')
                        ->join('products', 'product_store.product_id', '=', 'products.id')
                        ->where([
                            ['products.is_active', true],
                            ['product_store.store_id', $data['store_id']]
                        ])->sum('product_store.qty');
        $total_price = DB::table('product_store')
                        ->join('products', 'product_store.product_id', '=', 'products.id')
                        ->where([
                            ['products.is_active', true],
                            ['product_store.store_id', $data['store_id']]
                        ])->sum(DB::raw('products.price * product_store.qty'));
        $total_cost = DB::table('product_store')
                        ->join('products', 'product_store.product_id', '=', 'products.id')
                        ->where([
                            ['products.is_active', true],
                            ['product_store.store_id', $data['store_id']]
                        ])->sum(DB::raw('products.cost * product_store.qty'));
        $ezpos_store_list = Store::where('is_active', true)->get();
        $store_id = $data['store_id'];
        return view('report.store_stock', compact('total_item', 'total_qty', 'total_price', 'total_cost', 'ezpos_store_list', 'store_id'));
    }

    public function dailySale($year, $month)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('daily-sale')){
            $start = 1;
            $number_of_day = cal_days_in_month(CAL_GREGORIAN,$month,$year);
            while($start <= $number_of_day)
            {
                if($start < 10)
                    $date = $year.'-'.$month.'-0'.$start;
                else
                    $date = $year.'-'.$month.'-'.$start;
                $query1 = array(
                    'SUM(total_discount) AS total_discount',
                    'SUM(order_discount) AS order_discount',
                    'SUM(total_tax) AS total_tax',
                    'SUM(order_tax) AS order_tax',
                    'SUM(shipping_cost) AS shipping_cost',
                    'SUM(grand_total) AS grand_total'
                );
                $sale_data = Sale::whereDate('date', $date)->selectRaw(implode(',', $query1))->get();
                $total_discount[$start] = $sale_data[0]->total_discount;
                $order_discount[$start] = $sale_data[0]->order_discount;
                $total_tax[$start] = $sale_data[0]->total_tax;
                $order_tax[$start] = $sale_data[0]->order_tax;
                $shipping_cost[$start] = $sale_data[0]->shipping_cost;
                $grand_total[$start] = $sale_data[0]->grand_total;
                $start++;
            }
            $start_day = date('w', strtotime($year.'-'.$month.'-01')) + 1;
            $prev_year = date('Y', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
            $prev_month = date('m', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
            $next_year = date('Y', strtotime('+1 month', strtotime($year.'-'.$month.'-01')));
            $next_month = date('m', strtotime('+1 month', strtotime($year.'-'.$month.'-01')));
            $ezpos_store_list = Store::where('is_active', true)->get();
            $store_id = 0;
            return view('report.daily_sale', compact('total_discount','order_discount', 'total_tax', 'order_tax', 'shipping_cost', 'grand_total', 'start_day', 'year', 'month', 'number_of_day', 'prev_year', 'prev_month', 'next_year', 'next_month', 'ezpos_store_list', 'store_id'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function dailySaleByStore(Request $request,$year,$month)
    {
        $data = $request->all();
        if($data['store_id'] == 0)
            return redirect()->back();
        $start = 1;
        $number_of_day = cal_days_in_month(CAL_GREGORIAN,$month,$year);
        while($start <= $number_of_day)
        {
            if($start < 10)
                $date = $year.'-'.$month.'-0'.$start;
            else
                $date = $year.'-'.$month.'-'.$start;
            $query1 = array(
                'SUM(total_discount) AS total_discount',
                'SUM(order_discount) AS order_discount',
                'SUM(total_tax) AS total_tax',
                'SUM(order_tax) AS order_tax',
                'SUM(shipping_cost) AS shipping_cost',
                'SUM(grand_total) AS grand_total'
            );
            $sale_data = Sale::where('store_id', $data['store_id'])->whereDate('date', $date)->selectRaw(implode(',', $query1))->get();
            $total_discount[$start] = $sale_data[0]->total_discount;
            $order_discount[$start] = $sale_data[0]->order_discount;
            $total_tax[$start] = $sale_data[0]->total_tax;
            $order_tax[$start] = $sale_data[0]->order_tax;
            $shipping_cost[$start] = $sale_data[0]->shipping_cost;
            $grand_total[$start] = $sale_data[0]->grand_total;
            $start++;
        }
        $start_day = date('w', strtotime($year.'-'.$month.'-01')) + 1;
        $prev_year = date('Y', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
        $prev_month = date('m', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
        $next_year = date('Y', strtotime('+1 month', strtotime($year.'-'.$month.'-01')));
        $next_month = date('m', strtotime('+1 month', strtotime($year.'-'.$month.'-01')));
        $ezpos_store_list = Store::where('is_active', true)->get();
        $store_id = $data['store_id'];
        return view('report.daily_sale', compact('total_discount','order_discount', 'total_tax', 'order_tax', 'shipping_cost', 'grand_total', 'start_day', 'year', 'month', 'number_of_day', 'prev_year', 'prev_month', 'next_year', 'next_month', 'ezpos_store_list', 'store_id'));

    }

    public function dailyPurchase($year, $month)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('daily-purchase')){
            $start = 1;
            $number_of_day = cal_days_in_month(CAL_GREGORIAN,$month,$year);
            while($start <= $number_of_day)
            {
                if($start < 10)
                    $date = $year.'-'.$month.'-0'.$start;
                else
                    $date = $year.'-'.$month.'-'.$start;
                $query1 = array(
                    'SUM(total_discount) AS total_discount',
                    'SUM(order_discount) AS order_discount',
                    'SUM(total_tax) AS total_tax',
                    'SUM(order_tax) AS order_tax',
                    'SUM(shipping_cost) AS shipping_cost',
                    'SUM(grand_total) AS grand_total'
                );
                $purchase_data = Purchase::whereDate('date', $date)->selectRaw(implode(',', $query1))->get();
                $total_discount[$start] = $purchase_data[0]->total_discount;
                $order_discount[$start] = $purchase_data[0]->order_discount;
                $total_tax[$start] = $purchase_data[0]->total_tax;
                $order_tax[$start] = $purchase_data[0]->order_tax;
                $shipping_cost[$start] = $purchase_data[0]->shipping_cost;
                $grand_total[$start] = $purchase_data[0]->grand_total;
                $start++;
            }
            $start_day = date('w', strtotime($year.'-'.$month.'-01')) + 1;
            $prev_year = date('Y', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
            $prev_month = date('m', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
            $next_year = date('Y', strtotime('+1 month', strtotime($year.'-'.$month.'-01')));
            $next_month = date('m', strtotime('+1 month', strtotime($year.'-'.$month.'-01')));
            $ezpos_store_list = Store::where('is_active', true)->get();
            $store_id = 0;
            return view('report.daily_purchase', compact('total_discount','order_discount', 'total_tax', 'order_tax', 'shipping_cost', 'grand_total', 'start_day', 'year', 'month', 'number_of_day', 'prev_year', 'prev_month', 'next_year', 'next_month', 'ezpos_store_list', 'store_id'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function dailyPurchaseByStore(Request $request, $year, $month)
    {        
        $data = $request->all();
        if($data['store_id'] == 0)
            return redirect()->back();
        $start = 1;
        $number_of_day = cal_days_in_month(CAL_GREGORIAN,$month,$year);
        while($start <= $number_of_day)
        {
            if($start < 10)
                $date = $year.'-'.$month.'-0'.$start;
            else
                $date = $year.'-'.$month.'-'.$start;
            $query1 = array(
                'SUM(total_discount) AS total_discount',
                'SUM(order_discount) AS order_discount',
                'SUM(total_tax) AS total_tax',
                'SUM(order_tax) AS order_tax',
                'SUM(shipping_cost) AS shipping_cost',
                'SUM(grand_total) AS grand_total'
            );
            $purchase_data = Purchase::where('store_id', $data['store_id'])->whereDate('date', $date)->selectRaw(implode(',', $query1))->get();
            $total_discount[$start] = $purchase_data[0]->total_discount;
            $order_discount[$start] = $purchase_data[0]->order_discount;
            $total_tax[$start] = $purchase_data[0]->total_tax;
            $order_tax[$start] = $purchase_data[0]->order_tax;
            $shipping_cost[$start] = $purchase_data[0]->shipping_cost;
            $grand_total[$start] = $purchase_data[0]->grand_total;
            $start++;
        }
        $start_day = date('w', strtotime($year.'-'.$month.'-01')) + 1;
        $prev_year = date('Y', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
        $prev_month = date('m', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
        $next_year = date('Y', strtotime('+1 month', strtotime($year.'-'.$month.'-01')));
        $next_month = date('m', strtotime('+1 month', strtotime($year.'-'.$month.'-01')));
        $ezpos_store_list = Store::where('is_active', true)->get();
        $store_id = $data['store_id'];

        return view('report.daily_purchase', compact('total_discount','order_discount', 'total_tax', 'order_tax', 'shipping_cost', 'grand_total', 'start_day', 'year', 'month', 'number_of_day', 'prev_year', 'prev_month', 'next_year', 'next_month', 'ezpos_store_list', 'store_id'));
    }

    public function monthlySale($year)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('monthly-sale')){
            $start = strtotime($year .'-01-01');
            $end = strtotime($year .'-12-31');
            while($start <= $end)
            {
                $start_date = $year . '-'. date('m', $start).'-'.'01';
                $end_date = $year . '-'. date('m', $start).'-'.'31';

                $temp_total_discount = Sale::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('total_discount');
                $total_discount[] = number_format((float)$temp_total_discount, 2, '.', '');

                $temp_order_discount = Sale::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('order_discount');
                $order_discount[] = number_format((float)$temp_order_discount, 2, '.', '');

                $temp_total_tax = Sale::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('total_tax');
                $total_tax[] = number_format((float)$temp_total_tax, 2, '.', '');

                $temp_order_tax = Sale::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('order_tax');
                $order_tax[] = number_format((float)$temp_order_tax, 2, '.', '');

                $temp_shipping_cost = Sale::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('shipping_cost');
                $shipping_cost[] = number_format((float)$temp_shipping_cost, 2, '.', '');

                $temp_total = Sale::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('grand_total');
                $total[] = number_format((float)$temp_total, 2, '.', '');
                $start = strtotime("+1 month", $start);
            }
            $ezpos_store_list = Store::where('is_active',true)->get();
            $store_id = 0;
            return view('report.monthly_sale', compact('year', 'total_discount', 'order_discount', 'total_tax', 'order_tax', 'shipping_cost', 'total', 'ezpos_store_list', 'store_id'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function monthlySaleByStore(Request $request, $year)
    {
        $data = $request->all();
        if($data['store_id'] == 0)
            return redirect()->back();

        $start = strtotime($year .'-01-01');
        $end = strtotime($year .'-12-31');
        while($start <= $end)
        {
            $start_date = $year . '-'. date('m', $start).'-'.'01';
            $end_date = $year . '-'. date('m', $start).'-'.'31';

            $temp_total_discount = Sale::where('store_id', $data['store_id'])->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('total_discount');
            $total_discount[] = number_format((float)$temp_total_discount, 2, '.', '');

            $temp_order_discount = Sale::where('store_id', $data['store_id'])->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('order_discount');
            $order_discount[] = number_format((float)$temp_order_discount, 2, '.', '');

            $temp_total_tax = Sale::where('store_id', $data['store_id'])->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('total_tax');
            $total_tax[] = number_format((float)$temp_total_tax, 2, '.', '');

            $temp_order_tax = Sale::where('store_id', $data['store_id'])->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('order_tax');
            $order_tax[] = number_format((float)$temp_order_tax, 2, '.', '');

            $temp_shipping_cost = Sale::where('store_id', $data['store_id'])->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('shipping_cost');
            $shipping_cost[] = number_format((float)$temp_shipping_cost, 2, '.', '');

            $temp_total = Sale::where('store_id', $data['store_id'])->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('grand_total');
            $total[] = number_format((float)$temp_total, 2, '.', '');
            $start = strtotime("+1 month", $start);
        }
        $ezpos_store_list = Store::where('is_active',true)->get();
        $store_id = $data['store_id'];
        return view('report.monthly_sale', compact('year', 'total_discount', 'order_discount', 'total_tax', 'order_tax', 'shipping_cost', 'total', 'ezpos_store_list', 'store_id'));
    }

    public function monthlyPurchase($year)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('monthly-purchase')){
            $start = strtotime($year .'-01-01');
            $end = strtotime($year .'-12-31');
            while($start <= $end)
            {
                $start_date = $year . '-'. date('m', $start).'-'.'01';
                $end_date = $year . '-'. date('m', $start).'-'.'31';

                $query1 = array(
                    'SUM(total_discount) AS total_discount',
                    'SUM(order_discount) AS order_discount',
                    'SUM(total_tax) AS total_tax',
                    'SUM(order_tax) AS order_tax',
                    'SUM(shipping_cost) AS shipping_cost',
                    'SUM(grand_total) AS grand_total'
                );
                $purchase_data = Purchase::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->selectRaw(implode(',', $query1))->get();
                
                $total_discount[] = number_format((float)$purchase_data[0]->total_discount, 2, '.', '');
                $order_discount[] = number_format((float)$purchase_data[0]->order_discount, 2, '.', '');
                $total_tax[] = number_format((float)$purchase_data[0]->total_tax, 2, '.', '');
                $order_tax[] = number_format((float)$purchase_data[0]->order_tax, 2, '.', '');
                $shipping_cost[] = number_format((float)$purchase_data[0]->shipping_cost, 2, '.', '');
                $grand_total[] = number_format((float)$purchase_data[0]->grand_total, 2, '.', '');
                $start = strtotime("+1 month", $start);
            }
            $ezpos_store_list = Store::where('is_active', true)->get();
            $store_id = 0;
            return view('report.monthly_purchase', compact('year', 'total_discount', 'order_discount', 'total_tax', 'order_tax', 'shipping_cost', 'grand_total', 'ezpos_store_list', 'store_id'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function monthlyPurchaseByStore(Request $request, $year)
    {
        $data = $request->all();
        if($data['store_id'] == 0)
            return redirect()->back();

        $start = strtotime($year .'-01-01');
        $end = strtotime($year .'-12-31');
        while($start <= $end)
        {
            $start_date = $year . '-'. date('m', $start).'-'.'01';
            $end_date = $year . '-'. date('m', $start).'-'.'31';

            $query1 = array(
                'SUM(total_discount) AS total_discount',
                'SUM(order_discount) AS order_discount',
                'SUM(total_tax) AS total_tax',
                'SUM(order_tax) AS order_tax',
                'SUM(shipping_cost) AS shipping_cost',
                'SUM(grand_total) AS grand_total'
            );
            $purchase_data = Purchase::where('store_id', $data['store_id'])->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->selectRaw(implode(',', $query1))->get();
            
            $total_discount[] = number_format((float)$purchase_data[0]->total_discount, 2, '.', '');
            $order_discount[] = number_format((float)$purchase_data[0]->order_discount, 2, '.', '');
            $total_tax[] = number_format((float)$purchase_data[0]->total_tax, 2, '.', '');
            $order_tax[] = number_format((float)$purchase_data[0]->order_tax, 2, '.', '');
            $shipping_cost[] = number_format((float)$purchase_data[0]->shipping_cost, 2, '.', '');
            $grand_total[] = number_format((float)$purchase_data[0]->grand_total, 2, '.', '');
            $start = strtotime("+1 month", $start);
        }
        $ezpos_store_list = Store::where('is_active', true)->get();
        $store_id = $data['store_id'];
        return view('report.monthly_purchase', compact('year', 'total_discount', 'order_discount', 'total_tax', 'order_tax', 'shipping_cost', 'grand_total', 'ezpos_store_list', 'store_id'));
    }

    public function bestSeller()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('best-seller')){
            $start = strtotime(date("Y").'-'.date("m", strtotime("-2 months")).'-01');
            $end = strtotime(date("Y").'-'.date("m").'-31');
            while($start <= $end)
            {
                $start_date = date("Y").'-'.date('m', $start).'-'.'01';
                $end_date = date("Y").'-'.date('m', $start).'-'.'31';

                $best_selling_qty = DB::table('sales')
                                ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->select(DB::raw('product_sales.product_id, sum(product_sales.qty) as sold_qty'))->whereDate('sales.date', '>=' , $start_date)->whereDate('sales.date', '<=' , $end_date)->groupBy('product_id')->orderBy('sold_qty', 'desc')->take(1)->get();
                //return $best_selling_qty;
                if(!count($best_selling_qty)){
                    $product[] = '';
                    $sold_qty[] = 0;
                }
                foreach ($best_selling_qty as $best_seller) {
                    $product_data = Product::find($best_seller->product_id);
                    $product[] = $product_data->name.': '.$product_data->code;
                    $sold_qty[] = $best_seller->sold_qty;
                }
                $start = strtotime("+1 month", $start);
            }
            $start_month = date("F Y", strtotime('-2 month'));
            $ezpos_store_list = Store::where('is_active', true)->get();
            $store_id = 0;
            return view('report.best_seller', compact('product', 'sold_qty', 'start_month', 'ezpos_store_list', 'store_id'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function bestSellerByStore(Request $request)
    {
        $data = $request->all();
        if($data['store_id'] == 0)
            return redirect()->back();

        $start = strtotime(date("Y").'-'.date("m", strtotime("-2 months")).'-01');
        $end = strtotime(date("Y").'-'.date("m").'-31');
        while($start <= $end)
        {
            $start_date = date("Y").'-'.date('m', $start).'-'.'01';
            $end_date = date("Y").'-'.date('m', $start).'-'.'31';
            $best_selling_qty = DB::table('sales')
                                ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->select(DB::raw('product_sales.product_id, sum(product_sales.qty) as sold_qty'))->where('sales.store_id', $data['store_id'])->whereDate('sales.date', '>=' , $start_date)->whereDate('sales.date', '<=' , $end_date)->groupBy('product_id')->orderBy('sold_qty', 'desc')->take(1)->get();
            if(!count($best_selling_qty)){
                $product[] = '';
                $sold_qty[] = 0;
            }
            foreach ($best_selling_qty as $best_seller) {
                $product_data = Product::find($best_seller->product_id);
                $product[] = $product_data->name.': '.$product_data->code;
                $sold_qty[] = $best_seller->sold_qty;
            }
            $start = strtotime("+1 month", $start);
        }
        $start_month = date("F Y", strtotime('-2 month'));
        $ezpos_store_list = Store::where('is_active', true)->get();
        $store_id = $data['store_id'];
        return view('report.best_seller', compact('product', 'sold_qty', 'start_month', 'ezpos_store_list', 'store_id'));
    }

    public function profitLoss(Request $request)
    {
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        $query1 = array(
            'SUM(grand_total) AS grand_total',
            'SUM(paid_amount) AS paid_amount',
            'SUM(total_tax + order_tax) AS tax'
        );
        $query2 = array(
            'SUM(grand_total) AS grand_total',
            'SUM(total_tax + order_tax) AS tax'
        );
        $purchase = Purchase::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->selectRaw(implode(',', $query1))->get();
        $total_purchase = Purchase::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->count();
        $sale = Sale::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->selectRaw(implode(',', $query1))->get();
        $total_sale = Sale::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->count();
        $return = Returns::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->selectRaw(implode(',', $query2))->get();
        $total_return = Returns::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->count();
        $expense = Expense::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('amount');
        $total_expense = Expense::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->count();
        $total_item = DB::table('product_store')
                    ->join('products', 'product_store.product_id', '=', 'products.id')
                    ->where([
                        ['products.is_active', true],
                        ['product_store.qty', '>' , 0]
                    ])->count();
        $payment_recieved_number = DB::table('payments')->whereNotNull('sale_id')->whereDate('date', '>=' , $start_date)
            ->whereDate('date', '<=' , $end_date)->count();
        $payment_recieved = DB::table('payments')->whereNotNull('sale_id')->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('payments.amount');
        $credit_card_payment_sale = DB::table('payments')
                            ->join('payment_with_credit_card', 'payments.id', '=',
                            'payment_with_credit_card.payment_id')
                            ->whereNotNull('payments.sale_id')
                            ->whereDate('payments.date', '>=' , $start_date)
                            ->whereDate('payments.date', '<=' , $end_date)->sum('payments.amount');
        $cheque_payment_sale = DB::table('payments')
                            ->join('payment_with_cheque', 'payments.id', '=',
                            'payment_with_cheque.payment_id')
                            ->whereNotNull('payments.sale_id')
                            ->whereDate('payments.date', '>=' , $start_date)
                            ->whereDate('payments.date', '<=' , $end_date)->sum('payments.amount');
        $cash_payment_sale =  $payment_recieved - $credit_card_payment_sale - $cheque_payment_sale;
        $payment_sent_number = DB::table('payments')->whereNotNull('purchase_id')->whereDate('date', '>=' , $start_date)
            ->whereDate('date', '<=' , $end_date)->count();
        $payment_sent = DB::table('payments')->whereNotNull('purchase_id')->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('payments.amount');
        $credit_card_payment_purchase = DB::table('payments')
                            ->join('payment_with_credit_card', 'payments.id', '=',
                            'payment_with_credit_card.payment_id')
                            ->whereNotNull('payments.purchase_id')
                            ->whereDate('payments.date', '>=' , $start_date)
                            ->whereDate('payments.date', '<=' , $end_date)->sum('payments.amount');
        $cheque_payment_purchase = DB::table('payments')
                            ->join('payment_with_cheque', 'payments.id', '=',
                            'payment_with_cheque.payment_id')
                            ->whereNotNull('payments.purchase_id')
                            ->whereDate('payments.date', '>=' , $start_date)
                            ->whereDate('payments.date', '<=' , $end_date)->sum('payments.amount');
        $cash_payment_purchase =  $payment_sent - $credit_card_payment_purchase - $cheque_payment_purchase;
        $ezpos_store_all = Store::where('is_active',true)->get();
        foreach ($ezpos_store_all as $store) {
            $store_name[] = $store->name;
            $store_sale[] = Sale::where('store_id', $store->id)->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->selectRaw(implode(',', $query2))->get();
            $store_purchase[] = Purchase::where('store_id', $store->id)->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->selectRaw(implode(',', $query2))->get();
            $store_return[] = Returns::where('store_id', $store->id)->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->selectRaw(implode(',', $query2))->get();
            $store_expense[] = Expense::where('store_id', $store->id)->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->sum('amount');
        }

        return view('report.profit_loss', compact('purchase', 'total_purchase', 'sale', 'total_sale', 'return', 'total_return', 'expense', 'total_expense', 'payment_recieved_number', 'payment_recieved', 'cash_payment_sale', 'cheque_payment_sale', 'credit_card_payment_sale', 'payment_sent_number', 'payment_sent', 'cash_payment_purchase', 'cheque_payment_purchase', 'credit_card_payment_purchase', 'store_name', 'store_sale', 'store_purchase', 'store_return', 'store_expense', 'start_date', 'end_date'));
    }

    public function productReport(Request $request)
    {
        $data = $request->all();
        $start_date = date('Y-m-d', strtotime($data['start_date']));
        $end_date = date('Y-m-d', strtotime($data['end_date']));
        $store_id = $data['store_id'];
        $ezpos_product_all = Product::where('is_active', true)->get();
        foreach ($ezpos_product_all as $product) {
            if($store_id == 0)
                $ezpos_product_purchase_data = DB::table('purchases')
                            ->join('product_purchases', 'purchases.id', '=', 'product_purchases.purchase_id')->where('product_purchases.product_id', $product->id)->whereDate('purchases.date', '>=' , $start_date)->whereDate('purchases.date', '<=' , $end_date)->first();
            else
                $ezpos_product_purchase_data = DB::table('purchases')
                            ->join('product_purchases', 'purchases.id', '=', 'product_purchases.purchase_id')->where([
                                    ['product_purchases.product_id', $product->id],
                                    ['purchases.store_id', $store_id]
                            ])->whereDate('purchases.date','>=', $start_date)->whereDate('purchases.date','<=', $end_date)->first();

            if($ezpos_product_purchase_data){
                $product_name[] = $product->name;
                $product_id[] = $product->id;
                if($store_id == 0)
                    $product_qty[] = $product->qty;
                else
                    $product_qty[] = Product_Store::where([
                                    ['product_id', $product->id],
                                    ['store_id', $store_id]
                                ])->sum('qty');
            }
            else{
                if($store_id == 0)
                    $ezpos_product_sale_data = DB::table('sales')
                            ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->where('product_sales.product_id', $product->id)->whereDate('sales.date', '>=' , $start_date)->whereDate('sales.date', '<=' , $end_date)->first();
                else
                    $ezpos_product_sale_data = DB::table('sales')
                                ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->where([
                                        ['product_sales.product_id', $product->id],
                                        ['sales.store_id', $store_id]
                                ])->whereDate('sales.date','>=', $start_date)->whereDate('sales.date','<=', $end_date)->first();
                                
                if($ezpos_product_sale_data){
                    $product_name[] = $product->name;
                    $product_id[] = $product->id;
                    if($store_id == 0)
                        $product_qty[] = $product->qty;
                    else
                        $product_qty[] = Product_Store::where([
                                        ['product_id', $product->id],
                                        ['store_id', $store_id]
                                    ])->sum('qty');
                }
            }
        }
        $ezpos_store_list = Store::where('is_active', true)->get();
        return view('report.product_report',compact('product_id', 'product_name', 'product_qty', 'start_date', 'end_date', 'ezpos_store_list', 'store_id'));
    }

    public function purchaseReport(Request $request)
    {
    	$data = $request->all();
        $start_date = date('Y-m-d', strtotime($data['start_date']));
        $end_date = date('Y-m-d', strtotime($data['end_date']));
        $store_id = $data['store_id'];
        $ezpos_product_all = Product::where('is_active', true)->get();
        foreach ($ezpos_product_all as $product) {
            
            if($store_id == 0)
                $ezpos_product_purchase_data = DB::table('purchases')
                            ->join('product_purchases', 'purchases.id', '=', 'product_purchases.purchase_id')->where('product_purchases.product_id', $product->id)->whereDate('purchases.date', '>=' , $start_date)->whereDate('purchases.date', '<=' , $end_date)->first();
            else
                $ezpos_product_purchase_data = DB::table('purchases')
                            ->join('product_purchases', 'purchases.id', '=', 'product_purchases.purchase_id')->where([
                                    ['product_purchases.product_id', $product->id],
                                    ['purchases.store_id', $store_id]
                            ])->whereDate('purchases.date','>=', $start_date)->whereDate('purchases.date','<=', $end_date)->first();
            if($ezpos_product_purchase_data){
                $product_name[] = $product->name;
                $product_id[] = $product->id;
                if($store_id == 0)
                    $product_qty[] = $product->qty;
                else
                    $product_qty[] = Product_Store::where([
                                    ['product_id', $product->id],
                                    ['store_id', $store_id]
                                ])->sum('qty');
            }
        }
        $ezpos_store_list = Store::where('is_active', true)->get();
        return view('report.purchase_report',compact('product_id', 'product_name', 'product_qty', 'start_date', 'end_date', 'ezpos_store_list', 'store_id'));
    }

    public function saleReport(Request $request)
    {
    	$data = $request->all();
        $start_date = date('Y-m-d', strtotime($data['start_date']));
        $end_date = date('Y-m-d', strtotime($data['end_date']));
        $store_id = $data['store_id'];
        $ezpos_product_all = Product::where('is_active', true)->get();
        foreach ($ezpos_product_all as $product) {
            if($store_id == 0)
                $ezpos_product_sale_data = DB::table('sales')
                        ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->where('product_sales.product_id', $product->id)->whereDate('sales.date', '>=' , $start_date)->whereDate('sales.date', '<=' , $end_date)->first();
            else
                $ezpos_product_sale_data = DB::table('sales')
                            ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->where([
                                    ['product_sales.product_id', $product->id],
                                    ['sales.store_id', $store_id]
                            ])->whereDate('sales.date','>=', $start_date)->whereDate('sales.date','<=', $end_date)->first();
                            
            if($ezpos_product_sale_data){
                $product_name[] = $product->name;
                $product_id[] = $product->id;
                if($store_id == 0)
                    $product_qty[] = $product->qty;
                else
                    $product_qty[] = Product_Store::where([
                                    ['product_id', $product->id],
                                    ['store_id', $store_id]
                                ])->sum('qty');
            }

        }
        $ezpos_store_list = Store::where('is_active', true)->get();
        return view('report.sale_report',compact('product_id', 'product_name', 'product_qty', 'start_date', 'end_date', 'ezpos_store_list','store_id'));
    }

    public function paymentReportByDate(Request $request)
    {
        $data = $request->all();
        $start_date = date('Y-m-d', strtotime($data['start_date']));
        $end_date = date('Y-m-d', strtotime($data['end_date']));
        
        $ezpos_payment_data = Payment::whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->get();
        return view('report.payment_report',compact('ezpos_payment_data', 'start_date', 'end_date'));
    }

    public function customerReport(Request $request)
    {
    	$data = $request->all();
        $customer_id = $data['customer_id'];
        $start_date = date('Y-m-d', strtotime($data['start_date']));
        $end_date = date('Y-m-d', strtotime($data['end_date']));
        $ezpos_sale_data = Sale::where('customer_id', $customer_id)->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->get();
        foreach ($ezpos_sale_data as $key => $sale) {
            $ezpos_product_sale_data[$key] = Product_Sale::where('sale_id', $sale->id)->get();
            $ezpos_payment_data[$key] = Payment::where('sale_id', $sale->id)->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->get();
        }
        $ezpos_customer_list = Customer::where('is_active', true)->get();
        return view('report.customer_report', compact('ezpos_sale_data','customer_id', 'start_date', 'end_date', 'ezpos_product_sale_data', 'ezpos_payment_data', 'ezpos_customer_list'));
    }

    public function supplierReport(Request $request)
    {
        $data = $request->all();
        $supplier_id = $data['supplier_id'];
        $start_date = date('Y-m-d', strtotime($data['start_date']));
        $end_date = date('Y-m-d', strtotime($data['end_date']));
        $ezpos_purchase_data = Purchase::where('supplier_id', $supplier_id)->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->get();

        foreach ($ezpos_purchase_data as $key => $purchase) {
            $ezpos_product_purchase_data[$key] = ProductPurchase::where('purchase_id', $purchase->id)->get();
            $ezpos_payment_data[$key] = Payment::where('purchase_id', $purchase->id)->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->get();
        }
        $ezpos_supplier_list = Supplier::where('is_active', true)->get();
        return view('report.supplier_report', compact('ezpos_purchase_data', 'ezpos_product_purchase_data', 'ezpos_payment_data', 'supplier_id', 'start_date', 'end_date', 'ezpos_supplier_list'));
    }

    public function dueReportByDate(Request $request)
    {
    	$data = $request->all();
        $start_date = date('Y-m-d', strtotime($data['start_date']));
        $end_date = date('Y-m-d', strtotime($data['end_date']));
        $ezpos_sale_data = Sale::where('payment_status', '!=', 4)->whereDate('date', '>=' , $start_date)->whereDate('date', '<=' , $end_date)->get();

        return view('report.due_report', compact('ezpos_sale_data', 'start_date', 'end_date'));
    }
	
	public function movementReport(){
	   $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('item_movement')){
		$reports=DB::table('item_movement')
		   ->select('item_movement.*','users.name as user_name','products.name as product_name','products.image','products.code', 'stores.name as store_name', 'categories.name as category_name')
		   ->join('users','users.id','item_movement.user')
		   ->join('categories','categories.id','item_movement.category_id')
		   ->join('stores','stores.id','item_movement.store_id')
		   ->join('products','products.id','item_movement.product_id')
		   ->orderby('id','DESC')
		   ->get();
		   
		   return view('report.movement_report')->with('reports',$reports);
		}
	  else	
		return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
  
	}
	
	public function store_qty(){
		$role = Role::find(Auth::user()->role_id);
		$branch = Auth::user()->branch_id;
		
        if($role->hasPermissionTo('item_count_store')){
		  $stores=DB::table('stores')->where('is_active','1');
		  if($branch!="Admin"){
			$stores=$stores->where('branch_id',$branch);  
		  }
		  $stores=$stores->get();
	     return view('report.store_qty_report')->with('stores',$stores);
		}
      else
	    return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
	  
	}
	
	public function store_item($id){
		$branch=Auth::user()->branch_id;
		
		$storeName="";
		if($id=="all"){
		   $products_qty=DB::table('product_store')
			   ->join('products' ,'products.id','product_store.product_id')
			   ->leftjoin('categories' ,'categories.id','products.category_id')
			   ->join('stores','stores.id','product_store.store_id')
                 ->where('product_store.is_inserted','1');
				 if($branch !="Admin"){
					$products_qty=$products_qty->where('products.branch_id',$branch); 
				 }
			   $products_qty=$products_qty->select('products.name','products.arabic_name','products.code','product_store.qty','stores.name as storename','categories.name as cateName','categories.parent_id as parentCategory')
			   ->orderBy('stores.created_at','DESC')
			   ->get();	
			 $storeName="all_store";  
		 }
		else{
		$products_qty=DB::table('product_store')
		   ->join('products' ,'products.id','product_store.product_id')
		   ->leftjoin('categories' ,'categories.id','products.category_id')
		   ->where('product_store.store_id',$id)
		    ->where('product_store.is_inserted','1');
			 if($branch !="Admin"){
					$products_qty=$products_qty->where('products.branch_id',$branch); 
				 }
                 $products_qty=$products_qty->select('products.name','products.arabic_name','products.code','product_store.qty','categories.name as cateName','categories.parent_id as parentCategory')
		   ->get();
		   $storeName="single_store";
		}
		return view('report.partials/store_products')->with('products_qty',$products_qty)->with('storeName',$storeName)->with('store_id',$id);;   
	}

	public function ExportItemsQTY($id){
		
		if($id=="all"){
		   $reports=DB::table('product_store')
			   ->join('products' ,'products.id','product_store.product_id')
			   ->join('stores','stores.id','product_store.store_id')
			   ->where('product_store.is_inserted','1')
			   ->select('products.name','products.arabic_name','products.code','product_store.qty','stores.name as storename')
			   ->orderBy('stores.created_at','DESC')
			   ->get();	
			 $storeName="all_store";  
		 }
		else{
		$reports=DB::table('product_store')
		   ->join('products' ,'products.id','product_store.product_id')
		   ->where('product_store.store_id',$id)
		   ->where('product_store.is_inserted','1')
		   ->select('products.name','products.arabic_name','products.code','product_store.qty')
		   ->get();
		   $storeName="single_store";
		}
	   $export_name= "stor-qty-".date("Y-m-d h-i-s");
	   $reports= json_decode(json_encode($reports), true);
        if(count($reports)>0):
            return Excel::create(''.$export_name.'', function($excel) use ($reports) { 
                $excel->sheet('reports', function($sheet) use ($reports){                
                                $sheet->fromArray($reports);
                            });
            })->download('xlsx');
        else:
            $this->CreateMessages("nothing_found");
        endif;
		return redirect("report/store_qty");
	}



}

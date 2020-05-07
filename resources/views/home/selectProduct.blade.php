  
  <?php $product= DB::table('products')->where('id',$id)->get()[0];
    
	   $store= DB::table('product_store')
		   ->join('stores','stores.id','product_store.store_id')
		   ->select('stores.name','product_store.qty')
		   ->where('stores.is_active','1')
		   ->where('product_id',$product->id)->get();
   $total=0;
  ?>        
 <div class="selected_item" style="position:relative">
					 <h5>{{$product->name}}</h5>
					 <h6>{{trans('file.total_qty')}} <span class="total_item">  </span></h6>
				   
				   <table class="table table-hover">
				     <thead>
					    <tr><th>{{trans('file.name')}} {{trans('file.Store')}}</td><th>{{trans('file.count')}}</th></tr>
					 </thead>
					 <tbody>
					   @foreach($store as $str)
					    <tr><td>{{$str->name}}</td><td style="color:green">{{$str->qty}}</td></tr>
					   <?php $total+=$str->qty;?>
					   @endforeach
					 </tbody>
				   </table>
				   <span id="search_total_item_result">{{$total}}</span>
				  </div> 
				   
<style>
  #search_total_item_result{
	 position: absolute;
    top: 29px;
    right: 12px;
    font-weight: bold;
    color: cornflowerblue;
  }
</style>		
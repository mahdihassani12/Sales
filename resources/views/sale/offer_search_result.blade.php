<style >
.btns{
	 width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 1px solid gray;
    background: transparent;
    box-shadow: 1px 1px #c1c1c1;
	position:relative;
}

.btns span{
	font-size: 33px;
    position: absolute;
  
    
}
.btns span.left{
     left: 6px;
    top: -14px;
}
.btns span.right{
	top: -11px;
    left: 4px;
}
</style>
<ul style="list-style-type:none;margin:0px;padding:0px;">
  @if($products)
  @foreach($products as $product)
   <div class="row" style="margin-top:10px;margin-bottom:10px;;padding-top:5px;padding-bottom:5px; background:#fff; background:2px 2px 12px #b1adad;">
		 <div class="col-md-2" style="border-right:1px solid #c5c4c4;">
		   <img src="{{url('public/images/product',$product->image)}}" style="width:140px">
		 </div>
		 <div class="col-md-8" >
		   <h2 style="font-size:1.3rem">{{$product->name}}</h2>
		   <h3 style="font-size:1rem; color:gray;"> {{$product->product_details}} </h3>
		   <p style="font-size:33px;font-size: 28px;width:95%;margin: 0px;position: absolute;bottom: 0px;"><?php if($product->promotion==1):?><del style="font-size:22px;color:#777272;">{{$product->price}}$</del> {{$product->promotion_price}}$  <span style="font-size:19px; float:right;">{{trans('file.expire_date')}} : {{$product->last_date}}</span><?php else:?> {{$product->price}}$ <?php endif;?></p>
		 </div>
		 <div class="col-md-2 add_to_cart" style="border-left:1px solid #c5c4c4;">
		   <p style="text-align:center" >{{trans('file.count')}}</p>
		   <p style="margin-top:-17px" ><button class="btns minus" product_id="{{$product->id}}" ><span class="left"  >-</span></button > <input type="text" id="{{$product->id}}" name="product_count"  style="width:57px;text-align:center; font-size:20px; margin-left:4px" value="0" ><button class="btns sum" style="margin-left:4px;"  product_id="{{$product->id}}"><span class="right" >+</span></button></p>
		   <p><button class="btn btn-block add_cart product-img" style="color:#fff; font-size:17px; background:linear-gradient(to right,#EE8636,#E03C8E)" product_id="{{$product->id}}"  data-product ="{{$product->code . ' (' . $product->name . ')'}}">{{trans('file.add')}}</button></p>

		 </div>
	   </div>
	   
  @endforeach
  @else
	  <p style="text-align:center;font-size:19px">{{trans('not_found')}}</p>
  @endif
</ul>

<script>
  $(".add_cart").click(function(){
		 var id=$(this).attr('product_id');
		 var qty=$("input#"+id).attr('value');
		 
			jQuery.ajax({
				method : 'GET',
				url : ''+APP_URL+'/offers/add_to_cart/'+id+'/'+qty,
				success: function(response){
					var pqty=$("#span-right").text();
					var ptotal=$("#span-left").text();
					pqty=parseInt(pqty);
					ptotal=parseInt(ptotal);
					
                    var nqty=response.split(",")[0];
                    var cost=response.split(",")[1];
                      					
					$("#span-right").text(pqty+parseInt(nqty));
					$("#span-left").text(ptotal+nqty*cost);
					$("#net").val((ptotal+nqty*cost)-parseInt($("#discount").val()));
				}
          });
	 })
	 $("#discount").change(function (){
		var total=parseInt($("#net").val()); 
		var newval=total-parseInt($(this).val());
		$("#net").val(newval);
	 });
	 
      

	  $(".minus").click(function(){
	 var id=$(this).attr('product_id');
     var newvalue=Number($("#"+id).val())-1;
     if(newvalue>0){
		 $('#'+id).attr("value",newvalue);
	 }
     else{
		$('#'+id).attr("value",0); 
	 }	 
  });
  
   $(".sum").click(function(){
	 var id=$(this).attr('product_id');
        var newvalue=Number($("#"+id).val())+1;
       
	 $('#'+id).attr("value",newvalue); 	 
  });
	 
  
</script>

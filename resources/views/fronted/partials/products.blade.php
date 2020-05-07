<div class="row">
<h3 style="margin-bottom:10px;" class="col-md-9">{{$catename}} <span style="float:left; font-size:20px; color:#d0d0d0;"> عدد المنتجات  &nbsp;&nbsp;&nbsp;{{$productQTY}}<span></h3>

  <div class="sort_product_part col-md-3">	
	<label class="sort_by" >ترتيب بواسطة</label>
	<select name="sortBy" class="sortBy">
	    <option value="date" type="des"> الافتراضي </option>
	    <option value="date" type="asc"> التاريخ - تصاعدي </option>
	    <option value="date" type="des">التاريخ - تنازلي</option>
	    <option value="price" type="asc"  style="display:none">السعر - تصاعدي</option>
	    <option value="price" type="des" style="display:none">السعر - تنازلي</option>
	</select>
  </div>
  <div class="col-12">
  	@if($catename!="كل المنتجات")
  	<select class="form-control select_subCategory" style="border-radius: 6px;    box-shadow: 3px 5px 10px #ddd;font-size:19px ">
  		<option value="" style="padding-top: 44px">Sub Categories</option>
  		@foreach($childCategory as $chcat)
          <option value="{{$chcat->id}}" @if($chcat->id==$id) selected @endif>{{$chcat->name}}</option>
  		@endforeach
  	</select>
  	@endif
  </div>	
</div>
	<div class="category-result">
	  <div class="row" id="load_more_item_section">
           <?php $getProduct_id=0;?>
	   @foreach($products as $product)
	     <div class="column5" product_id="{{$product->id}}" data-toggle="" data-target="#productModal">
	      <div class="single_product">
		    <div class="product-image">
			  @if($product->product_link!=null) <span class="fa fa-youtube product_link" product_link="{{$product->product_link}}" data-toggle="modal" data-target="#product_video" ></span>@endif
			   <img src="@if($product->external_link==1) {{$product->image}} @else {{asset('public/images/product')}}/{{$product->image}} @endif" class="img-responsive">
			      <p class="main_price" style="color:#858585;margin:0px;font-weight:bold;font-size:22px;position:absolute;bottom:-9px;left:10px;z-index:3;display:none;"><del>@if(strpos($product->price,'.')===false) {{number_format($product->price,0,'.',',')}} @else{{rtrim(number_format($product->price,2,'.',','),".0")}} @endif </del></p> 
				 <h3 style="display:none" class="product-price" category="{{$product->category_id}}" real_price="{{$product->price}}"> @if(strpos($product->price,'.')===false) {{number_format($product->price,0,'.',',')}} @else{{rtrim(number_format($product->price,2,'.',','),".0")}} @endif $</h3>
                 <h4 style="display:none">@if(strpos($product->price,'.')===false) {{number_format($product->price,0,'.',',')}} @else{{rtrim(number_format($product->price,2,'.',','),".0")}} @endif</h4>
				 <p class="discount_amount" style="color:#107b10;margin:0px;font-weight:bold;font-size:19px;position:absolute;bottom:-9px;right:10px;z-index:3;display:none;">0</p> 
            </div> 		
            <div class="product-request">
			    <?php 
                               $getProduct_id=$product->id; 
				  
			       // $allqty=DB::table('product_store')->where('product_id',$product->id)->get();
				//	 $allQuantity=0;
				//	 foreach($allqty as $totalCount){
				//		 $allQuantity=$allQuantity+$totalCount->qty; 
				//	 }
			   ?>
			   <button class="btn add_to_cart" product_id="{{$product->id}}"  product_qty="{{$product->storeqty}}">اطلب الان</button> 			
			     <p style="display:none" class="english_name">{{$product->name}}</p>
			     <p style="" class="arabic_name">{{$product->arabic_name}}</p>
			</div>
		  </div> 
		 </div> 
	   @endforeach
           <div id="remove_div" class="col-12" style="margin-top:20px; text-align:center;">
		     <button name="btn_more_cate" id="btn_more_cate" data-pro="{{$getProduct_id}}" data-cate='{{$id}}' class="load_more_item_btn" start_number="{{$startFrom}}">مشاهدة المزيد</button>
	       </div>
             
	   </div>
	  </div>
	  
<?php $zero_qty=DB::table('general_settings')->where('id','1')->get()[0]->zero_balance; ?>

<style>
 .single_product .product_link {
	  position: absolute;
	  left: 9px;
    color: white;
    font-size: 24px;
    padding-top: 10px;
    top: 0px;
    background-color: #ff1616;
    width: 30px;
    height: 40px;
    text-align: center;
    border-radius: 0px 0px 5px 5px;
  }
</style>

<script>
   $(document).ready(function () {
	var $button = $('.load_more_item_btn');

	$button.on('click', function () {
		var $this = $(this);
		if ($this.hasClass('active') || $this.hasClass('success')) {
			return false;
		}
		$this.addClass('active');
		setTimeout(function () {
			$this.addClass('loader');
		}, 125);
		setTimeout(function () {
			$this.removeClass('loader active');
			$this.text('تم');
			$this.addClass('success animated pulse');
		}, 1600);
		setTimeout(function () {
			$this.text('مشاهدة المزيد');
			$this.removeClass('success animated pulse');
			$this.blur();
		}, 2900);
	});
});	  
		 

  var zero_qty=<?php echo $zero_qty;?>;
  var APP_URL = {!! json_encode(url('/')) !!}
	
 
 $(document).ready(function(){
          var pr_name=localStorage.getItem("product_name");
	   if(pr_name=="ar"){
		  $('.arabic_name').css('display','block'); 
	   }
	   else{
		 // $('.english_name').css('display','block'); 
	   }
	   
    
         var st=localStorage.getItem("userCouponValue");
           var productlength=$(".product-price").length;
	 var currency=localStorage.getItem("currency");
	 
	 if(currency=="ar" && (st!=null || st!=0 || st!='null' || st!='')){
		   $( '.product-price' ).each(function(){
           var actual = $(this).attr('real_price');
		   //actual=actual.replace(/\,/g,'');
           actual=parseFloat(actual); 
		   
		  for (var i=0; i<productlength; i++){
			 
            $(this).text( addCommas(parseFloat( actual*1200 )) +' د . ع');
            $(this).next().text( addCommas(parseFloat( actual*1200 )));
            //$(this).next().next().text(seperated_value[i]+'%');
			
		   }	
          }); 
	   }

	 if(st==null || st==0 || st=='null' || st==''){
            st=0;	 
            $(".discount_amount").css('display','none');		
            $(".main_price").css('display','none');	
         }
         
        else{
          $(".discount_amount").css('display','block');		
          $(".main_price").css('display','block');     
    
	 var categories=localStorage.getItem('CouponNumberCategories');
	 
	 var seperated_cat=categories.split('-');
	 var lg=seperated_cat.length;
	 var seperated_value=st.split('-');
 
	   $( '.product-price' ).each(function(){
		    var actual = $(this).attr('real_price'); 
		   //actual=actual.replace(/\,/g,'');
           actual=parseFloat(actual); 
		  for (var i=0; i<lg; i++){
		  if( parseInt($(this).attr('category')) ==parseInt(seperated_cat[i])){ 
                     if(currency=='ar'){
				 $(this).text( addCommas(parseInt( (actual - actual*seperated_value[i]/100)*1200 )) +' د . ع');
                 $(this).next().text( addCommas(parseInt( (actual - actual*seperated_value[i]/100)*1200 )));
                 $(this).prev().text(addCommas(actual*1200)).css('text-decoration','line-through');
				 $(this).next().next().text(seperated_value[i]+'%');   
			   }
			   else{
                 $(this).text( addCommas(parseFloat(actual - actual*seperated_value[i]/100)) +' $');
                 $(this).next().text( addCommas(parseFloat(actual - actual*seperated_value[i]/100)));
                 $(this).next().next().text(seperated_value[i]+'%');
			   }	 
                  }
		}	
    }); 
 }
 });
</script>	   
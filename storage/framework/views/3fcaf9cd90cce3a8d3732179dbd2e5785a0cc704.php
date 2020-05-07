<?php $getProduct_id=0;?>
	   <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	     <div class="column5" product_id="<?php echo e($product->id); ?>" data-toggle="" data-target="#productModal">
	      <div class="single_product">
		    <div class="product-image">
			 			  <?php if($product->product_link!=null): ?>  <span class="fa fa-youtube product_link" product_link="<?php echo e($product->product_link); ?>" data-toggle="modal" data-target="#product_video" ></span><?php endif; ?>

			   <img src="<?php if($product->external_link==1): ?> <?php echo e($product->image); ?> <?php else: ?>  <?php echo e(asset('public/images/product')); ?>/<?php echo e($product->image); ?> <?php endif; ?>" class="img-responsive">
                 <p class="main_price" style="color:#858585;margin:0px;font-weight:bold;font-size:22px;position:absolute;bottom:-9px;left:10px;z-index:3;display:none;"><del><?php if(strpos($product->price,'.')===false): ?> <?php echo e(number_format($product->price,0,'.',',')); ?> <?php else: ?><?php echo e(rtrim(number_format($product->price,2,'.',','),".0")); ?> <?php endif; ?> </del></p> 			     
				 <h3 class="product-price" category="<?php echo e($product->category_id); ?>" real_price="<?php echo e($product->price); ?>"><?php if(strpos($product->price,'.')===false): ?> <?php echo e(number_format($product->price,0,'.',',')); ?> <?php else: ?><?php echo e(rtrim(number_format($product->price,2,'.',','),".0")); ?> <?php endif; ?> $</h3>
                 <h4><?php if(strpos($product->price,'.')===false): ?> <?php echo e(number_format($product->price,0,'.',',')); ?> <?php else: ?><?php echo e(rtrim(number_format($product->price,2,'.',','),".0")); ?> <?php endif; ?></h4>
				 <p class="discount_amount" style="color:#107b10;margin:0px;font-weight:bold;font-size:19px;position:absolute;bottom:-9px;right:10px;z-index:3;display:none;">0</p> 

            </div> 		
            <div class="product-request"> 
			   <?php 
			        $getProduct_id=$product->id; 
					
			        $allqty=DB::table('product_store')->where('product_id',$product->id)->get();
					 $allQuantity=0;
					 foreach($allqty as $totalCount){
						 $allQuantity=$allQuantity+$totalCount->qty; 
					 }
			   ?>
			   <button class="btn add_to_cart" product_id="<?php echo e($product->id); ?>"  product_qty="<?php echo e($allQuantity); ?>">اطلب الان</button> 			
			     <p style="display:none" class="english_name"><?php echo e($product->name); ?></p>
			     <p style="display:none" class="arabic_name"><?php echo e($product->arabic_name); ?></p>
			</div>
		  </div> 
		 </div> 
	   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	      <div id="remove_div" class="col-12" style="margin-top:20px;text-align:center; ">
		    <button name="btn_more" id="btn_more" data-pro="<?php echo e($getProduct_id); ?>" class="load_more_item_btn" start_number="<?php echo e($startFrom); ?>">مشاهدة المزيد</button>
		  </div>
		  
 
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
 var APP_URL = <?php echo json_encode(url('/')); ?>


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
		 

 $(document).ready(function(){
     var pr_name=localStorage.getItem("product_name");
	   if(pr_name=="ar"){
		  $('.arabic_name').css('display','block'); 
	   }
	   else{
		  $('.english_name').css('display','block'); 
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
	 var seperated_value=st.split('-');
	 var lg=seperated_cat.length;
 
	   $( '.product-price' ).each(function(){
        var actual = $(this).attr('real_price');		 
		 //actual=actual.replace(/\,/g,'');
           actual=parseFloat(actual);
         	   
	    for (var i=0; i<lg; i++){
		if( parseInt($(this).attr('category')) ==parseInt(seperated_cat[i])){  
              if(currency=='ar'){
				 $(this).text( addCommas(parseFloat( (actual - actual*seperated_value[i]/100)*1200 )) +' د . ع');
                 $(this).next().text( addCommas(parseFloat((actual - actual*seperated_value[i]/100)*1200 )));
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
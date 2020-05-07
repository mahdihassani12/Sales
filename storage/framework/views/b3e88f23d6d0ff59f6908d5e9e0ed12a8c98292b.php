<h3 style="margin-bottom:10px;"><?php echo e($catename); ?> <span style="float:left; font-size:20px; color:#d0d0d0;"> عدد المنتجات  &nbsp;&nbsp;&nbsp;<?php echo e($productQTY); ?><span></h3>
	 <div class="category-result">
	  <div class="row" id="load_more_item_section">
           <?php $getProduct_id=0;?>
	   <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	     <div class="column5" product_id="<?php echo e($product->id); ?>" data-toggle="" data-target="#productModal">
	      <div class="single_product">
		    <div class="product-image">
			  <span class="fa fa-youtube product_link" product_link="<?php echo e($product->product_link); ?>" data-toggle="modal" data-target="#product_video" ></span>
			   <img src="<?php echo e(asset('public/images/product')); ?>/<?php echo e($product->image); ?>" class="img-responsive">
			      <p class="main_price" style="color:#858585;margin:0px;font-weight:bold;font-size:22px;position:absolute;bottom:-9px;left:10px;z-index:3;"><del><?php echo e(number_format($product->price)); ?></del></p> 
				 <h3 class="product-price" category="<?php echo e($product->category_id); ?>" real_price="<?php echo e($product->price); ?>"><?php echo e(number_format($product->price)); ?></h3>
                 <h4><?php echo e(number_format($product->price)); ?></h4>
				 <p class="discount_amount" style="color:#107b10;margin:0px;font-weight:bold;font-size:19px;position:absolute;bottom:-9px;right:10px;z-index:3;">0</p> 
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
			   <p><?php echo e($product->name); ?></p>
			</div>
		  </div> 
		 </div> 
	   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           <div id="remove_div" class="col-12" style="margin-top:20px; text-align:center;">
		     <button name="btn_more_cate" id="btn_more_cate" data-pro="<?php echo e($getProduct_id); ?>" data-cate='<?php echo e($id); ?>' class="load_more_item_btn">مشاهدة المزيد</button>
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
  var APP_URL = <?php echo json_encode(url('/')); ?>

	
 
 $(document).ready(function(){
         var st=localStorage.getItem("userCouponValue");
	 if(st==null || st==0){
            st=0;	 
            $(".discount_amount").css('display','none');		
            $(".main_price").css('display','none');	
         }

	 var categories=localStorage.getItem('CouponNumberCategories');
	 
	 var seperated_cat=categories.split('-');
	 var lg=seperated_cat.length;
 
	   $( '.product-price' ).each(function(){
		    var actual = $(this).attr('real_price'); 
		   //actual=actual.replace(/\,/g,'');
           actual=parseInt(actual,10); 
		  for (var i=0; i<lg; i++){
			if( parseInt($(this).attr('category')) ==parseInt(seperated_cat[i])){  
               $(this).text( addCommas(parseInt(actual - actual*st/100)));
               $(this).next().text( addCommas(parseInt(actual - actual*st/100)));
               $(this).next().next().text(st+'%');			}
		}	
    }); 
 });
</script>	   
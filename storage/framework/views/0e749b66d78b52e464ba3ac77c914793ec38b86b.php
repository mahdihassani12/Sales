<div class="row">
   <div class="col-md-4"> <h4> Request ID: &nbsp;&nbsp; <?php echo e($requested->id); ?></h4>  </div>
   <div class="col-md-4"> <h4>Date: &nbsp;&nbsp; <?php echo explode(" ",$requested->created_at)[0]; ?>  </h4></div>
   <div class="col-md-4"> <h4> Time: &nbsp;&nbsp; <?php echo explode(" ",$requested->created_at)[1];  ?> </h4></div>
</div>

<div class="request_details">
<table class="table table-striped rwd-table">
   <tbody>
      <?php $totalQty=0;?>
       <?php $totalPrice=0;?>
      
      <?php $__currentLoopData = $requestDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	  <div class="details-row row">
	     <div class="col-md-2" style="padding:6px;display:none">
		     <img src="<?php if($details->external_link !=1): ?> <?php echo e(asset('public/images/product')); ?>/ <?php endif; ?> <?php echo e($details->itemphoto); ?>" style="width: 70%;height:100%;object-fit:cover;" >
		 </div>
		 <div class="col-md-2" style="padding:11px 6px;font-weight:600;font-size:17px">
		    <div style="height:40px;"><?php echo e($details->product_name); ?></div>
		    <div style="display:none"><span class="labels">السعر &nbsp;&nbsp;&nbsp;<?php echo e($details->product_price); ?> </span></div>
		 </div>
		 <div class="col-md-3" style="padding-top: 10px;">
              <h4> <?php echo e(trans('file.sub_category')); ?></h4>
		       <?php if($details->parentCategory!=null): ?>
				<?php echo e($details->cateName); ?>

				<?php else: ?> 
				<?php echo e('N\A'); ?>

				<?php endif; ?>	
		 </div>
		 <div class="col-md-3" style="padding-top: 10px;">
              <h4> <?php echo e(trans('file.category')); ?></h4>
		       <?php if($details->parentCategory==null): ?>
				  <?php echo e($details->cateName); ?>

				<?php else: ?> 
				  <?php $category=DB::table('categories')->where('id',$details->parentCategory)->get(); if(count($category)>0): echo $category[0]->name; endif;?> 
				<?php endif; ?>
		 </div>
		 <div class="col-md-3" style="padding:11px 6px;font-weight:600;font-size:19px">
		     <div style="height:40px;"> <span class="labels">الکمیة </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo e($details->product_qty); ?> </div>
		 </div>
	  </div>	   
	    
	 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	  
   </tbody>
</table>
</div>
<div class="footer-totals row" style="padding:20px 10px; text-align:center;">
  <div class="col-md-6" style="border-left:1px solid lightgray;"><h5 style="height:25px;"><?php echo e(trans('file.sales_man')); ?></h5><h5> <?php echo e($requested->customer_name); ?></h5></div>
  <div class="col-md-6" style=""><h5 style="height:25px;"><?php echo e(trans('file.phone')); ?></h5><h5> <?php echo e($requested->customer_phone); ?></h5></div>
  <div class="col-md-4" style="border-left:1px solid lightgray;display:none"><h5 style="height:25px;"><?php echo e(trans('file.Total')); ?></h5><h5><img  style="width:23px" src="<?php echo e(asset('public/images/icons/chash.png')); ?>">&nbsp;&nbsp;&nbsp;&nbsp; <?php echo e($requested->subtotal); ?></h5></div>
  <div class="col-md-4" style="border-left:1px solid lightgray;display:none"><h5 style="height:25px;"><?php echo e(trans('file.Shipping Cost')); ?></h5><h5><img style="width:23px" src="<?php echo e(asset('public/images/icons/chash.png')); ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo e($requested->shipping_cost); ?></h5></div>
  <div class="col-md-4" style="display:none"><h5 style="height:25px;"><?php echo e(trans('file.grand total')); ?></h5><h5><img src="<?php echo e(asset('public/images/icons/chash.png')); ?>" style="width:23px">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo e($requested->total); ?></h5></div>
</div>

<div>
   <h2 style="text-align:center;">المخزن   <?php echo e($requested->storeName); ?><h2>
</div>
	
<div>
   <h3 style="display:none">ملاحظات الطلب: <?php echo e($requested->marketer_note); ?></h3>
   <a class="btn btn-success btn-lg" style="padding:0px 20px;" href="<?php echo e(asset('online_order/print')); ?>/<?php echo e($requested->id); ?>" target="_blank">Print</a>
</div>	

<style>
.request_details{
	background:#504f4e;
    padding:10px;  	
}

.request_details .details-row{
	background-color:#fff !important;
	margin:0px; 
	margin-top:6px;
    height:94px;
}
.request_details .details-row .labels{
	color:#b3b2b2;
}
</style>
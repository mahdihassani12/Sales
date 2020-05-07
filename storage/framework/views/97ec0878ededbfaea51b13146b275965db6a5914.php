
<div class="row">
<?php if(count($data['variations'])>0): ?>
 <?php $__currentLoopData = $data['variations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <div class="col-md-4 ">
   <div class="variations_area">
    <img src="<?php echo e(asset('public/images/product_variation')); ?>/<?php echo e($pv->image); ?>">
	<h3><?php echo e($pv->name); ?></h3>
	<h2><?php echo e($pv->price); ?></h2>
  </div>
 </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
<h3 class="col-sm-12" style="text-align:center" ><?php echo e(trans('file.no_variation')); ?></h3>
<?php endif; ?>	
</div>

<style>
.variations_area{
	border: 1px solid #d2cfcf;
    box-shadow: 1px 3px 2px #dededec4;
    text-align: center;
    padding: 17px;	
}
.variations_area img{
	width:100%;
}
.variations_area h3{
	margin-top:15px; 
}
</style>
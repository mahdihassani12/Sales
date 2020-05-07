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
	top: -14px;
    left: 4px;
}
</style>
<ul style="list-style-type:none;margin:0px;padding:0px;">
  <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <div class="row" style="margin-top:10px;margin-bottom:10px;;padding-top:5px;padding-bottom:5px; background:#fff; background:2px 2px 12px #b1adad;">
     <div class="col-md-2" style="border-right:1px solid #c5c4c4;">
	   <img src="<?php echo e(url('public/images/product',$product->image)); ?>" style="width:120px">
	 </div>
	 <div class="col-md-8" >
	   <h2><?php echo e($product->name); ?></h2>
	   <h3> <?php echo e($product->product_details); ?> </h3>
	   <p style="font-size:33px;font-size: 28px;margin: 0px;position: absolute;bottom: 0px;"><?php echo e($product->price); ?>$</p>
	 </div>
	 <div class="col-md-2" style="border-left:1px solid #c5c4c4;">
	   <p style="text-align:center" ><?php echo e(trans('file.count')); ?></p>
	   <p style="margin-top:-17px" ><button class="btns minus" product_id="<?php echo e($product->id); ?>" ><span class="left"  >-</span></button > <input type="text" id="<?php echo e($product->id); ?>" name="product_count"  style="width:57px;text-align:center; font-size:20px; margin-left:4px;" value="0" ><button class="btns sum" style="margin-left:4px;"  product_id="<?php echo e($product->id); ?>"><span class="right" >+</span></button></p>
	   <p><button class="btn btn-block" style="color:#fff; font-size:17px; background:linear-gradient(to right,#EE8636,#E03C8E)">add</button></p>

	 </div>
   </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>

<script>
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

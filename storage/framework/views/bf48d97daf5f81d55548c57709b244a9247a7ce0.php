<?php 
$products=DB::table('products')
		->join('categories','categories.id','products.category_id')
		->where('categories.is_active',1)
		->where('products.is_active',1)
		->limit(10)
		->select('products.*','categories.name as category')
		->orderBy('products.id','DESC')
		->get();
		?>

 <?php $counter=1; ?>
	 <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	   <tr class="edit_product" product_id="<?php echo e($product->id); ?>" ><td><?php echo e($counter); ?></td><td><?php echo e($product->name); ?></td><td><?php echo e($product->code); ?></td><td><?php echo e($product->category); ?></td><td><?php echo e($product->alert_quantity); ?></td><td><?php echo e($product->unit); ?></td><td><?php echo e($product->price); ?></td></tr>							 
	 <?php $counter++;?>
	 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	 
<script>

   $(".edit_product").click(function(){
	   var product_id=$(this).attr('product_id');
	   $.ajax({
		   url:APP_URL+'/products/searchPro/'+product_id,
		   type:'get',
		   success:function(response){
			   $("#product_name").val(response.split(',')[0]);
			   $('#category_id option:contains("'+response.split(',')[1]+'")').attr('selected', 'selected');
			   $("#category_id").val(response.split(',')[1]);
			   $("#category_id").val(response.split(',')[1]);
			   $("#quantity").val(response.split(',')[2]);
			   $("#price").val(response.split(',')[3]);
			   $("#cost").val(response.split(',')[4]);
			   $("#unit").val(response.split(',')[5]);
			   $("#alert_quantity").val(response.split(',')[6]);
			   $("#barcode").val(response.split(',')[7]);
			   $("#product_id").val(product_id);
		   },
		   error:function(data){
			  alert(data); 
		   }
	   })
   });

</script>	 
 <?php $__env->startSection('content'); ?>
<section>
	<?php echo e(Form::open(['route' => ['report.monthlySaleByStore', $year], 'method' => 'post', 'id' => 'report-form'])); ?>

	<input type="hidden" name="store_id_hidden" value="<?php echo e($store_id); ?>">
	<h4 class="text-center"><?php echo e(trans('file.Monthly Sale')); ?>s <?php echo e(trans('file.Report')); ?> &nbsp;&nbsp;
	<select class="selectpicker" id="store_id" name="store_id">
		<option value="0"><?php echo e(trans('file.All')); ?> <?php echo e(trans('file.Store')); ?></option>
		<?php $__currentLoopData = $ezpos_store_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<option value="<?php echo e($store->id); ?>"><?php echo e($store->name); ?></option>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</select>
	</h4>
	<?php echo e(Form::close()); ?>

	<div class="table-responsive mt-4">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th><a href="<?php echo e(url('report/monthly_sale/'.($year-1))); ?>"><i class="fa fa-arrow-left"></i> <?php echo e(trans('file.Previous')); ?></a></th>
			    	<th colspan="10" class="text-center"><?php echo e($year); ?></th>
			    	<th><a href="<?php echo e(url('report/monthly_sale/'.($year+1))); ?>"><?php echo e(trans('file.Next')); ?> <i class="fa fa-arrow-right"></i></a></th>
			    </tr>
			</thead>
		    <tbody>
			    <tr>
			      <td><strong>January</strong></td>
			      <td><strong>February</strong></td>
			      <td><strong>March</strong></td>
			      <td><strong>April</strong></td>
			      <td><strong>May</strong></td>
			      <td><strong>June</strong></td>
			      <td><strong>July</strong></td>
			      <td><strong>August</strong></td>
			      <td><strong>September</strong></td>
			      <td><strong>October</strong></td>
			      <td><strong>November</strong></td>
			      <td><strong>December</strong></td>
			    </tr>
			    <tr>
			    	<?php $__currentLoopData = $total_discount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $discount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			        <td>
			        	<?php if($discount > 0): ?>
				      	<strong><?php echo e(trans("file.product").' '.trans("file.Discount")); ?></strong><br>
				      	<span><?php echo e($discount); ?></span><br><br>
				      	<?php endif; ?>
				      	<?php if($order_discount[$key] > 0): ?>
				      	<strong><?php echo e(trans("file.Order").' ' .trans("file.Discount")); ?></strong><br>
				      	<span><?php echo e($order_discount[$key]); ?></span><br><br>
				      	<?php endif; ?>
				      	<?php if($total_tax[$key] > 0): ?>
				      	<strong><?php echo e(trans("file.product").' ' .trans("file.Tax")); ?></strong><br>
				      	<span><?php echo e($total_tax[$key]); ?></span><br><br>
				      	<?php endif; ?>
				      	<?php if($order_tax[$key] > 0): ?>
				      	<strong><?php echo e(trans("file.Order").' '.trans("file.Tax")); ?></strong><br>
				      	<span><?php echo e($order_tax[$key]); ?></span><br><br>
				      	<?php endif; ?>
				      	<?php if($shipping_cost[$key] > 0): ?>
				      	<strong><?php echo e(trans("file.Shipping Cost")); ?></strong><br>
				      	<span><?php echo e($shipping_cost[$key]); ?></span><br><br>
				      	<?php endif; ?>
				      	<?php if($total[$key] > 0): ?>
				      	<strong><?php echo e(trans("file.grand total")); ?></strong><br>
				      	<span><?php echo e($total[$key]); ?></span><br>
				      	<?php endif; ?>
			        </td>
			        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			    </tr>
		    </tbody>
		</table>
	</div>	
</section>

<script type="text/javascript">

	$("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(4).addClass("active");

	$('#store_id').val($('input[name="store_id_hidden"]').val());
	$('.selectpicker').selectpicker('refresh');

	$('#store_id').on("change", function(){
		$('#report-form').submit();
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
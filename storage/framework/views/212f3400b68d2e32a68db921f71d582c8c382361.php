<?php $__env->startSection('content'); ?>
<section>
	<?php echo e(Form::open(['route' => ['report.dailySaleByStore', $year, $month], 'method' => 'post', 'id' => 'report-form'])); ?>

	<input type="hidden" name="store_id_hidden" value="<?php echo e($store_id); ?>">
	<h4 class="text-center"><?php echo e(trans('file.Daily Sale')); ?> <?php echo e(trans('file.Report')); ?> &nbsp;&nbsp;
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
					<th><a href="<?php echo e(url('report/daily_sale/'.$prev_year.'/'.$prev_month)); ?>"><i class="fa fa-arrow-left"></i> <?php echo e(trans('file.Previous')); ?></a></th>
			    	<th colspan="5" class="text-center"><?php echo e(date("F", strtotime($year.'-'.$month.'-01')).' ' .$year); ?></th>
			    	<th><a href="<?php echo e(url('report/daily_sale/'.$next_year.'/'.$next_month)); ?>"><?php echo e(trans('file.Next')); ?> <i class="fa fa-arrow-right"></i></a></th>
			    </tr>
			</thead>
		    <tbody>
			    <tr>
				    <td><strong>Sunday</strong></td>
				    <td><strong>Monday</strong></td>
				    <td><strong>Tuesday</strong></td>
				    <td><strong>Wednesday</strong></td>
				    <td><strong>Thrusday</strong></td>
				    <td><strong>Friday</strong></td>
				    <td><strong>Saturday</strong></td>
			    </tr>
			    <?php 
			    	$i = 1;
			    	$flag = 0;
			    	while ($i <= $number_of_day) {
			    		echo '<tr>';
			    		for($j=1 ; $j<=7 ; $j++){
			    			if($i > $number_of_day)
			    				break;

			    			if($flag){
			    				if($year.'-'.$month.'-'.$i == date('Y').'-'.date('m').'-'.(int)date('d'))
			    					echo '<td><p style="color:red"><strong>'.$i.'</strong></p>';
			    				else
			    					echo '<td><p><strong>'.$i.'</strong></p>';

			    				if($total_discount[$i]){
			    					echo '<strong>'.trans("file.product").' '.trans("file.Discount").'</strong><br><span>'.$total_discount[$i].'</span><br><br>';
			    				}
			    				if($order_discount[$i]){
			    					echo '<strong>'.trans("file.Order").' ' .trans("file.Discount").'</strong><br><span>'.$order_discount[$i].'</span><br><br>';
			    				}
			    				if($total_tax[$i]){
			    					echo '<strong>'.trans("file.product").' ' .trans("file.Tax").'</strong><br><span>'.$total_tax[$i].'</span><br><br>';
			    				}
			    				if($order_tax[$i]){
			    					echo '<strong>'.trans("file.Order").' '.trans("file.Tax").'</strong><br><span>'.$order_tax[$i].'</span><br><br>';
			    				}
			    				if($shipping_cost[$i]){
			    					echo '<strong>'.trans("file.Shipping Cost").'</strong><br><span>'.$shipping_cost[$i].'</span><br><br>';
			    				}
			    				if($grand_total[$i]){
			    					echo '<strong>'.trans("file.grand total").'</strong><br><span>'.$grand_total[$i].'</span><br><br>';
			    				}
			    				echo '</td>';
			    				$i++;
			    			}
			    			elseif($j == $start_day){
			    				if($year.'-'.$month.'-'.$i == date('Y').'-'.date('m').'-'.(int)date('d'))
			    					echo '<td><p style="color:red"><strong>'.$i.'</strong></p>';
			    				else
			    					echo '<td><p><strong>'.$i.'</strong></p>';

			    				if($total_discount[$i]){
			    					echo '<strong>'.trans("file.product").' '.trans("file.Discount").'</strong><br><span>'.$total_discount[$i].'</span><br><br>';
			    				}
			    				if($order_discount[$i]){
			    					echo '<strong>'.trans("file.Order").' ' .trans("file.Discount").'</strong><br><span>'.$order_discount[$i].'</span><br><br>';
			    				}
			    				if($total_tax[$i]){
			    					echo '<strong>'.trans("file.product").' ' .trans("file.Tax").'</strong><br><span>'.$total_tax[$i].'</span><br><br>';
			    				}
			    				if($order_tax[$i]){
			    					echo '<strong>'.trans("file.Order").' '.trans("file.Tax").'</strong><br><span>'.$order_tax[$i].'</span><br><br>';
			    				}
			    				if($shipping_cost[$i]){
			    					echo '<strong>'.trans("file.Shipping Cost").'</strong><br><span>'.$shipping_cost[$i].'</span><br><br>';
			    				}
			    				if($grand_total[$i]){
			    					echo '<strong>'.trans("file.grand total").'</strong><br><span>'.$grand_total[$i].'</span><br><br>';
			    				}
			    				echo '</td>';
			    				$flag = 1;
			    				$i++;
			    				continue;
			    			}
			    			else {
			    				echo '<td></td>';
			    			}
			    		}
			    	    echo '</tr>';
			    	}
			    ?>
		    </tbody>
		</table>
	</div>	
</section>

<script type="text/javascript">

	$("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(3).addClass("active");

	$('#store_id').val($('input[name="store_id_hidden"]').val());
	$('.selectpicker').selectpicker('refresh');

	$('#store_id').on("change", function(){
		$('#report-form').submit();
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
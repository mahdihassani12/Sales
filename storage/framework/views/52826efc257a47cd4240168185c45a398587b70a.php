<h1>Delivery Details</h1>
<h3>Hey <?php echo e($customer); ?>!</h3>
<p>Your Product is <?php echo e($status); ?>.</p>
<p><strong>Sale Reference: </strong><?php echo e($sale_reference); ?></p>
<p><strong>Delivery Reference: </strong><?php echo e($delivery_reference); ?></p>
<p><strong>Destination: </strong><?php echo e($address); ?></p>
<?php if($delivered_by): ?>
<p><strong>Delivered By: </strong><?php echo e($delivered_by); ?></p>
<?php endif; ?>
<p>Thank You</p>
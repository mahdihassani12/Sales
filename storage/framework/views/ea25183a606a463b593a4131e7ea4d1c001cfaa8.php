<div class="breadcrum">
            <?php if(isset($data['breadcrumb'])): ?>
            <p>
                 <a href="<?php echo e(asset('/home')); ?>"><span><?php echo e($data['breadcrumb'][0]); ?></span></a>
                <strong> - </strong>
                <span><?php echo e($data['breadcrumb'][1]); ?></span>
            </p>
            <?php endif; ?>
        </div>
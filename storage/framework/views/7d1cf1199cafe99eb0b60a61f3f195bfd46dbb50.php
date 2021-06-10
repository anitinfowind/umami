<li class="header"><?php echo e(sprintf(trans_choice('strings.backend.general.you_have.notifications', $unreadNotificationCount), $unreadNotificationCount)); ?></li>
<li> 
    <!--Inner Menu: contains the notifications -->
    <ul class="menu"> 
        <?php $__currentLoopData = $notifications->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nK => $nV): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="<?php echo e($nV['is_read']?'read':'unread'); ?>"> 
                <!--start notification -->
                <a href="<?php echo route('admin.notification.index'); ?>">                    
                    <i class="fa fa-exclamation-triangle text-<?php echo e($nV['type']); ?>"></i> <?php echo e($nV['message']); ?>

                </a>
            </li> 
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
        <!--end notification -->
    </ul>
</li>
<li class="footer"><a href="<?php echo route('admin.notification.index'); ?>">
<?php echo e(trans('strings.backend.general.see_all.notifications')); ?></a></li>
 
<?php /**PATH F:\xampp\htdocs\umami\resources\views/backend/includes/notification.blade.php ENDPATH**/ ?>
<?php
    $message = '';
    $type = '';
    $dontHide = false;

    if(session()->has('dontHide')) {
        $dontHide = session()->get('dontHide');
    }
?>
<?php if($errors->any()): ?>
    <?php
        $type = 'danger';
    ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $message .= $error . '<br/>';
        ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php elseif(session()->get('flash_success')): ?>
    <?php
        $type = 'success';
    ?>
    <?php if(is_array(json_decode(session()->get('flash_success'), true))): ?>
        <?php
            $message = implode('', session()->get('flash_success')->all(':message<br/>'));
        ?>
    <?php else: ?>
        <?php
            $message = session()->get('flash_success');
        ?>
    <?php endif; ?>
<?php elseif(session()->get('flash_warning')): ?>
    <?php
        $type = 'warning';
    ?>
    <?php if(is_array(json_decode(session()->get('flash_warning'), true))): ?>
        <?php
            $message = implode('', session()->get('flash_warning')->all(':message<br/>'));
        ?>
    <?php else: ?>
        <?php
            $message = session()->get('flash_warning');
        ?>
    <?php endif; ?>
<?php elseif(session()->get('flash_info')): ?>
    <?php
        $type = 'info';
    ?>
    <?php if(is_array(json_decode(session()->get('flash_info'), true))): ?>
        <?php
            $message = implode('', session()->get('flash_info')->all(':message<br/>'));
        ?>
    <?php else: ?>
        <?php
            $message = session()->get('flash_info');
        ?>
    <?php endif; ?>
<?php elseif(session()->get('flash_danger')): ?>
    <?php
        $type = 'danger';
    ?>
    <?php if(is_array(json_decode(session()->get('flash_danger'), true))): ?>
        <?php
            $message = implode('', session()->get('flash_danger')->all(':message<br/>'));
        ?>
    <?php else: ?>
        <?php
            $message = session()->get('flash_danger');
        ?>
    <?php endif; ?>
<?php elseif(session()->get('flash_message')): ?>
    <?php
        $type = 'info';
    ?>
    <?php if(is_array(json_decode(session()->get('flash_message'), true))): ?>
        <?php
            $message = implode('', session()->get('flash_message')->all(':message<br/>'));
        ?>
    <?php else: ?>
        <?php
            $message = session()->get('flash_message');
        ?>
    <?php endif; ?>
<?php endif; ?>

<!-- Flash Message Vue component -->
<flash message="<?php echo $message; ?>" type="<?php echo e($type); ?>" dont-hide="<?php echo e($dontHide); ?>"></flash><?php /**PATH F:\xampp\htdocs\umami\resources\views/includes/partials/messages.blade.php ENDPATH**/ ?>
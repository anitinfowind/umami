<?php if(auth()->check() && session()->has("admin_user_id") && session()->has("temp_user_id")): ?>
    <div class="alert alert-warning logged-in-as">
        You are currently logged in as <?php echo e(auth()->user()->first_name); ?>. <a href="<?php echo e(route("frontend.auth.logout-as")); ?>">Re-Login as <?php echo e(session()
        ->get("admin_user_name")); ?></a>.
    </div>
<?php endif; ?><?php /**PATH F:\xampp\htdocs\umami\resources\views/includes/partials/logged-in-as.blade.php ENDPATH**/ ?>
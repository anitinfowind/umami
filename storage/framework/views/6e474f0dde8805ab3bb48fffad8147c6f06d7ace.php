<ul class="dropdown-menu lang-menu" role="menu">
        <?php $__currentLoopData = array_keys(config('locale.languages')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($lang != App::getLocale()): ?>
                        <li><?php echo e(link_to('lang/'.$lang, trans('menus.language-picker.langs.'.$lang))); ?></li>
                <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul><?php /**PATH F:\xampp\htdocs\umami\resources\views/includes/partials/lang.blade.php ENDPATH**/ ?>
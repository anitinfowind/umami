<!--Action Button-->
<?php if(Active::checkUriPattern('admin/pages')): ?>
    <export-component></export-component>    
<?php endif; ?>
<!--Action Button-->
<div class="btn-group">
  <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">Action
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo e(route('admin.pages.index')); ?>"><i class="fa fa-list-ul"></i> <?php echo e(trans('menus.backend.pages.all')); ?></a></li>
    <?php if (access()->allow('create-page')): ?>
    <li><a href="<?php echo e(route('admin.pages.create')); ?>"><i class="fa fa-plus"></i> <?php echo e(trans('menus.backend.pages.create')); ?></a></li>
    <?php endif; ?>
  </ul>
</div>
<div class="clearfix"></div>
<?php /**PATH F:\xampp\htdocs\umami\resources\views/backend/pages/partials/pages-header-buttons.blade.php ENDPATH**/ ?>
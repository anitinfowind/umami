<?php $__env->startSection('title', trans('labels.backend.products.management') . ' | ' . trans('labels.backend.products.create')); ?>

<?php $__env->startSection('page-header'); ?>
    <h1>
        <?php echo e(trans('labels.backend.products.management')); ?>

        <small><?php echo e(trans('labels.backend.products.create')); ?></small>
    </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo e(Form::open(['route' => 'admin.products.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-product','files' => true,])); ?>


        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo e(trans('labels.backend.products.create')); ?></h3>

                <div class="box-tools pull-right">
                    <?php echo $__env->make('backend.products.partials.products-header-buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div><!--box-tools pull-right-->
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    
                    <?php echo $__env->make("backend.products.form", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="edit-form-btn">
                        <?php echo e(link_to_route('admin.products.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md'])); ?>

                        <?php echo e(Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md'])); ?>

                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!-- form-group -->
            </div><!--box-body-->
        </div><!--box box-success-->
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\umami\resources\views/backend/products/create.blade.php ENDPATH**/ ?>
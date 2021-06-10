<?php $__env->startSection('page-header'); ?>
    <h1>
        <?php echo e(app_name()); ?>

        <small><?php echo e(trans('strings.backend.dashboard.title')); ?></small>
    </h1>
<?php $__env->stopSection(); ?>
   <style type="text/css">
      .dashboard_show {
    background: #49a3db;
    text-align: center;
    padding: 20px;
    margin-bottom: 20px;
    font-size: 22px;
    color: #fff;
}
.dashboard_show span {
    font-size: 18px;
    color: #984e9d;
    background: #fff;
    padding: 5px 10px;
    margin-top: 10px;
    display: inline-block;
    border-radius: 4px;
    width: auto;
}      
    </style>
<?php $__env->startSection('content'); ?>
    <div class="box box-info">
        <div class="box-header with-border">
            <!-- <h3 class="box-title"><?php echo e(trans('history.backend.recent_history')); ?></h3> -->
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
           <div class="col-md-12">
            <div class="col-md-4">
             <a href="<?php echo e(URL::to('admin/access/user')); ?>"> <div class="dashboard_show">Registered users<br><span><?php echo e($usercount); ?></span>
              </div></a>
            </div>

            <div class="col-md-4">
               <a href="<?php echo e(URL::to('admin/vendors')); ?>">  <div class="dashboard_show">
                Vendor<br><span><?php echo e($vendorcount); ?></span>
                </div>
               </a>
            </div>

            <div class="col-md-4">
              <div class="dashboard_show">Complate Order<br><span>00</span>
              </div>
            </div>
           

          </div> 

         
        </div><!-- /.box-body -->
    </div><!--box box-info-->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\umami\resources\views/backend/dashboard.blade.php ENDPATH**/ ?>
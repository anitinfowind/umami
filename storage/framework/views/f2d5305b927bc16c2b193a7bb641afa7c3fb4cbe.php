<?php $__env->startSection('title', trans('Products Management')); ?>

<?php $__env->startSection('page-header'); ?>
    <h1><?php echo e(trans('Products Management')); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo e(trans('Products Management')); ?></h3>

            <div class="box-tools pull-right">
                <?php echo $__env->make('backend.products.partials.products-header-buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="example"class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                          <th style="display: none;"></th>
                            <th><?php echo e(trans('Restaurant Name')); ?></th>
                            <th><?php echo e(trans('Product Name')); ?></th>
                            <th><?php echo e(trans('Category Name')); ?></th>
                            <th><?php echo e(trans('Brand')); ?></th>
                            <th><?php echo e(trans('Diet')); ?></th>
                           <!--  <th><?php echo e(trans('Region')); ?></th> -->
                            <th><?php echo e(trans('Image')); ?></th>
                            <th><?php echo e(trans('Price')); ?></th>
                            <th><?php echo e(trans('Quantity')); ?></th> 
                            <th><?php echo e(trans('Status')); ?></th>
                            <th><?php echo e(trans('labels.general.actions')); ?></th>
                           <!--  <th>
                              <form method="post">
                                <input type="hidden" class="adminstatus" name="status">
                                <button>Submit</button>
                              </form>
                            </th> -->
                        </tr>
                    </thead>
                    <tbody>
                      <?php if($products->isNotEmpty()): ?>
                       <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php 
                            $ext = '';
                            if(isset($product->singleProductImage->image)) {
                              $info = pathinfo(PRODUCT_ROOT_PATH.$product->singleProductImage->image);
                               $ext = $info['extension'];
                             }
                               ?>
                            <tr>
                              <td style="display: none;"><?php echo e($key+1); ?></td>
                                <td><?php echo e(restaurantName($product->restaurant_id)); ?> </td>
                                <td><?php echo e(isset($product->title)?$product->title:''); ?></td>
                                <td>
                                  <?php if($product->pCategory->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $product->pCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <?php echo e(isset($pcat->p_category->name)?$pcat->p_category->name:''); ?> <br/>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  <?php endif; ?>
                                </td>
                                <td>
                                 <?php if($product->pBrand->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $product->pBrand; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pbrands): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <?php echo e(isset($pbrands->p_brand->name)?$pbrands->p_brand->name:''); ?><br/>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php endif; ?>
                                </td>
                                <td>
                                   <?php if($product->pdiet->isNotEmpty()): ?>
                                     <?php $__currentLoopData = $product->pdiet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pdits): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php echo e(isset($pdits->p_diet->name)?$pdits->p_diet->name:''); ?><br/>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                   <?php endif; ?>
                                </td>
                                <td>
                                 <?php if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp'): ?> 
                                  <?php if(!empty($product->singleProductImage->image) &&
                                          File::exists(PRODUCT_ROOT_PATH.$product->singleProductImage->image)): ?>
                                      <?php $image = PRODUCT_URL.$product->singleProductImage->image; ?>
                                  <?php else: ?>
                                      <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                                  <?php endif; ?>
                                  <img class="resto product_list" src="<?php echo e($image); ?>" alt="<?php echo e($product->title()); ?>">
                                  <?php elseif($ext != ''): ?>
                                  <video width="100px" height="80px" muted loop  controls poster="<?php echo e(url('thimbnailimage.png')); ?>"> 
                                  <source src="<?php echo e(PRODUCT_URL.$product->singleProductImage->image); ?>" type="video/mp4">
                                  </video>

                                  <?php endif; ?>
                                </td>
                                <td><?php echo e($product->price); ?></td>
                                <td><?php echo e($product->quantity); ?></td>
                                <td>
                                  <?php if($product->product_admin_status == 1): ?>
                                      <label class="label label-success">Publish</label>
                                  <?php else: ?>
                                      <label class="label label-danger">Pending</label>
                                  <?php endif; ?>
                                </td>
                                <td>
                                  <div class="btn-group action-btn">
                                   <a class="btn btn-default btn-flat" href="<?php echo e(route('admin.products.view',$product)); ?>">
                                      <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-eye" data-original-title="View"></i>
                                   </a>
                                     <a class="btn btn-default btn-flat edit_product" href111="<?php echo e(route('admin.products.edit',$product)); ?>" href="javascript:;" onclick1111="window.location.href='<?php echo e(url('admin/products/' . $product->id . '/edit?dt_page=')); ?>'" product_id="<?php echo e($product->id); ?>">
                                          <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-pencil" data-original-title="Edit"></i>
                                     </a>
                                       <a href="<?php echo e(route('admin.products.delete',$product)); ?>" class="btn btn-flat btn-default" data-method="delete" data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();">
                                          <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-trash" data-original-title="Delete" aria-describedby="tooltip373985"></i>
                                          <div class="tooltip fade top" role="tooltip" id="tooltip373985" style="top: -27px; left: -12.3906px; display: block;">
                                            <div class="tooltip-arrow" style="left: 50%;"></div>
                                            <div class="tooltip-inner">Delete</div>
                                            </div>
                                       </a>
                                      <?php if(!empty($product->price)): ?>
                                        <?php if($product->product_admin_status == 1): ?>
                                         <a class="btn btn-default btn-flat" href="<?php echo e(url('admin/products/status/'.$product->id.'/0')); ?>"><i class="fa fa-square" data-toggle="tooltip" data-placement="top" title="" data-original-title="Deactivate"></i></a>
                                         <?php else: ?>
                                         <a class="btn btn-default btn-flat" href="<?php echo e(url('admin/products/status/'.$product->id.'/1')); ?>"><i class="fa fa-check-square" data-toggle="tooltip" data-placement="top" title="" data-original-title="Activate" aria-describedby="tooltip302972"></i><div class="tooltip fade top" role="tooltip"><div class="tooltip-inner">Activate</div></div></a>
                                         <?php endif; ?>
                                      <?php else: ?>
                                      <a class="btn btn-default btn-flat" id="btnSave" href="javascript:void(0)"><i class="fa fa-square" data-toggle="tooltip" data-placement="top" title="" data-original-title="Product Publish"></i></a>
                                      <?php endif; ?>  
                                 </div>
                                </td>
                                <!-- <td><input type="checkbox" name="ceck" class="publishdata" value="<?php echo e($product->id); ?>" <?php if($product->product_admin_status == 1): ?> checked <?php endif; ?>></td> -->
                            </tr> 
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <td style="text-align: center;"> Product Not found</td>
                       <?php endif; ?> 
                    </tbody>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after-scripts'); ?>
    
    <?php echo e(Html::script(mix('js/dataTable.js'))); ?>


    <script>
     $(document).ready(function() {
        //$('#example').DataTable();

        var table = $('#example').DataTable();
        <?php if(isset($_GET['dt_page'])) { echo 'table.page(' . $_GET['dt_page'] . ').draw("page");'; } ?>

        $(document).on('click', '.edit_product', function(){
          var product_id = $(this).attr('product_id');
          var info = table.page.info();
          window.location.href = '<?php echo e(url('admin/products/')); ?>/' + product_id + '/edit?dt_page=' + info.page;
        });
        

    } );
$("#btnSave").click(function (e) {
    e.preventDefault();
       swal({
          title: 'Please enter product price first.',
          type: 'warning',
          confirmButtonColor: '#3085d6'
      }).then((value) => {
          if (value === "yes") {
            // Add Your Custom Code for CRUD
          }
          return false;
      });
  });

$('.publishdata').click(function(){
  var id= $(this).val();
 var diet = [];
  $("input").each(function() {
    if ($(this).is(':checked')) {
      var checked = ($(this).val());
      diet.push(checked);
    }
  });
  $('.adminstatus').val(diet);

});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\umami\resources\views/backend/products/index.blade.php ENDPATH**/ ?>
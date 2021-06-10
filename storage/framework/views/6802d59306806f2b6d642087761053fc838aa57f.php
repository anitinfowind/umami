<?php $__env->startSection('title', trans('Product Management')); ?>
<?php $__env->startSection('page-header'); ?>
    <h1><?php echo e(trans('Product Order')); ?></h1>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <style>
.widget {
    margin-bottom: 0px;
}
.sortable-list-card {
    margin: 0 auto 3px;
    line-height: 29px;
    height: 30px;
}
li.widget-body-content {
    height: 33px;
    background: bisque;
    padding-left: 5%;
    padding-top: 6px;
}
</style>
    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                <?php echo $__env->make('backend.products.partials.products-header-buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>

        <div class="box-body">
          <?php if(!empty($productdata)): ?>
            <div class='widget-container' id='tileSort'>     
            <?php $__currentLoopData = $categorydata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class='widget' id='<?=$category->id ?>'>
               <input type="hidden" class="cat_id" data-id='<?=$category->id ?>' id="category_id" name="category_id[]" value="<?=$category->id ?>">
              <!-- id='<?=$category->id ?>' -->
              <ul class='widget-body-table' style='list-style:none;padding:0px;margin-bottom:5px'>
                <li class='widget-body-content' style="height: 33px;background: #ccc;padding-left: 5%;padding-top: 6px;">
                  <div class='sortable-list-card'>
                    <div class='sortable-list-handle'>
                      <div class='sortable-list-handle-line'></div>
                    </div>
                    <label>
                      <?php echo e($category->name); ?>

                    </label>
                  </div>
                </li>
              </ul>
            </div>
           
             <?php $__currentLoopData = $productdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <?php if($category->id == $product->category_id): ?>
            
            <div class='widget' id='<?=$product->id ?>' style="margin-left: 20px;">
              <input type="hidden" class="product_id" data-category-id='<?=$category->id ?>' id="product_id" name="product_id[]" value="<?=$product->id ?>">
              <ul class='widget-body-table' style='list-style:none;padding:0px;margin-bottom:5px'>
                <li class='widget-body-content' style="height: 33px;background: #ccc;padding-left: 5%;padding-top: 6px;">
                  <div class='sortable-list-card'>
                    <div class='sortable-list-handle'>
                      <div class='sortable-list-handle-line'></div>
                    </div>
                    <label>
                      <?php echo e($product->title); ?>

                    </label>
                  </div>
                </li>
              </ul>
            </div>
           
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <br>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
          <?php else: ?> 
           <?php echo e('No record found!'); ?>


           <?php endif; ?>
        </div>
         <input type="button" class="btn btn-success" name="submit" value="Update" id="saveColumnOrder">
            <input type="hidden" id="orders">
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('after-scripts'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

    <script type="text/javascript">
      var url   = '<?php echo e(url("admin/products/sortproductajax")); ?>'; 
       $('#tileSort').sortable({
        //items: "li:not(.ui-state-disabled)",
        cursor: 'move',   
        update: function(event, ui) {
          var tileOrder = $(this).sortable('toArray').toString();
          //alert(tileOrder);
          $("#orders").val(tileOrder);  
         }
  });
 
      
  $('#saveColumnOrder').click(function(e){
    e.preventDefault();
    var orderVal = $('#orders').val().trim();
    var category_id = [];
    var product_id = [];
    $('input[name="category_id[]"]').each(function(index, item){
    var val = $(item).val();
    var id = $(item).attr('data-id');
     category_id.push({id:val});
      $('input[name="product_id[]"]').each(function(i, it){
          var pro_val = $(it).val();
          var pro_id = $(it).attr('data-category-id');
          if(pro_id == val){
            product_id.push({
              category_id : val,
              product_id:pro_val,
            });
          }
      });
   });
    //console.log(category_id);
    //var orderVal2 = ',,'+orderVal; 
    $.ajax({
      //url:'<?php echo e(url("admin/products/sortproductajax")); ?>?order='+orderVal+'&&catorder='+category_id,
      //url:url,
      url:'<?php echo e(url("admin/sortproductajax")); ?>',
      data:{catorder:category_id,prodorder:product_id},
      method:'get',
      dataType:'html',
     // beforeSend:showLoader,
      success:function(resp){
        console.log(resp);
         
         alert('Sequence successfully updated');
         
        if(resp.status == 'success'){
        //  hideLoader();
        //  window.location.reload()
        
        //alert(resp.message);
         // toastr.success(resp.message,{'closeButton':true});
        }
        else{
         // hideLoader();
         //alert(resp.message);
          //toastr.error(resp.message,{'closeButton':true});
        }
      },
      error:function(jqXHR,exception){
       // hideLoader();
         console.log(jqXHR);
         console.log(exception);
        alert('Something went wrong');
        //toastr.error('<?=__('Something went wrong')?>',{'closeButton':true});
      }
    });   
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\umami\resources\views/backend/products/ordersort.blade.php ENDPATH**/ ?>
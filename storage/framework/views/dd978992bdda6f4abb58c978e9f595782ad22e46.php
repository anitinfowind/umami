<?php $__env->startSection('page-header'); ?>
    <h1>
        Testimonials
        <small></small>
    </h1>
<?php $__env->stopSection(); ?>
   
<?php $__env->startSection('content'); ?>
  <div class="box box-info">
      <div class="box-header with-border">
              <h3 class="box-title">Testimonials</h3>

              <div class="box-tools pull-right">
                <div class="btn-group">
                  <button type="button" data-toggle="dropdown" class="btn btn-primary btn-flat dropdown-toggle" aria-expanded="false">Action
                    <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span></button> 
                    <ul role="menu" class="dropdown-menu">
                      <li><a href="javascript:;" class="add_testimonial"><i class="fa fa-plus"></i> Add New</a></li>
                    </ul>
              </div> 
                <div class="clearfix"></div>
              </div>
                <!--box-tools pull-right-->
          </div><!--box-header with-border-->
          <div class="box-body">
          <div class="table-responsive data-table-wrapper">
              <table id="example" class="table table-condensed table-hover table-bordered" data-order111="[[ 3, &quot;desc&quot; ]]">
                  <thead>
                      <tr>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Title</th>
                          <th>Comment</th>
                          <th>Status</th>
                          <th><?php echo e(trans('labels.general.actions')); ?></th>
                      </tr>
                  </thead>
                  <tbody>
                        <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                            <td><?php echo $tst->image != '' ? '<img src="' . url('public/uploads/testimonial/' . $tst->image) . '" style="height: 80px;" />' : ''; ?></td>
                            <td><?php echo e($tst->first_name . ' ' . $tst->last_name); ?></td>
                            <td><?php echo e($tst->title); ?></td>
                            <td><?php echo nl2br($tst->comment); ?></td>
                            <td><?php echo $tst->status == '1' ? '<i class="fa fa-check"></i>' : ''; ?></td>
                              <td>
                                <div class="btn-group dropup">
                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                  <span class="glyphicon glyphicon-option-vertical"></span>
                              </button>
                                <ul class="dropdown-menu dropdown-menu-right"> 
                                
                                <li><a class="edit_testimonial" href="javascript:;" testimonial_id="<?php echo e($tst->id); ?>"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top"></i>Edit</a></li>
                                <li><a class="delete_testimonial text-danger" href="javascript:;" testimonial_id="<?php echo e($tst->id); ?>"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top"></i>Delete</a></li>
                                </ul>
                               </div>
                              </td>
                          </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
              </table>
          </div>
      </div>
  </div>


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Testimonial Form</h4>
      </div>
       <!-- <form enctype="multipart/form-data"> -->
      <div class="modal-body">
        <div class="form-group">
          <label>First Name:</label>
          <input type="text" class="form-control" name="first_name" />
        </div>
        <div class="form-group">
          <label>Last Name:</label>
          <input type="text" class="form-control" name="last_name" />
        </div>
        <div class="form-group">
          <label>Title:</label>
          <input type="text" class="form-control" name="title">
        </div>
        <div class="form-group">
          <label>Image: (70 x 70)</label>
          <input type="file" class="form-control" name="testimonial_image">
        </div>
        <div class="imgBlock">
          <img src="" style="max-height: 100px;" /><br>
          <label><input type="checkbox" name="remove_image" value="1" /> Remove</label>
        </div>
        
        <div class="form-group">
          <label>Post Image:</label>
          <input type="file" class="form-control" name="testimonial_post_image" accept="video/*,image/*"/>
          <!-- accept="image/*,video/*" -->
        </div>
        <div class="imgBlockPost">
          
          <label><input type="checkbox" name="remove_post_image" value="1" /> Remove</label>
        </div>
        
        <div class="form-group">
          <label>Comment:</label>
          <textarea class="form-control" name="comment" rows="6"></textarea>
        </div>
        <div class="form-group">
          <label>Status:</label>
          <select class="form-control" name="status">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
          </select>
        </div>
        <div class="form-group">
          <input type="hidden" name="testimonial_id" value="">
          <a href="javascript:;" class="btn btn-primary submit_testimonial">Submit</a>
        </div>
      </div>
   <!--  </form> -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('after-scripts'); ?>
    <?php echo e(Html::script(mix('js/dataTable.js'))); ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
    <script type="text/javascript">
      $(document).ready(function() {

        $(document).on('click', '.add_testimonial', function(){
          $('#myModal .imgBlock').hide();
          $('#myModal .imgBlockPost').hide();
          $('#myModal input[name="first_name"], #myModal input[name="last_name"], #myModal input[name="title"], #myModal input[name="image"], #myModal input[name="testimonial_post_image"], #myModal textarea[name="comment"], #myModal input[name="testimonial_id"]').val('');
          $('#myModal select[name="status"]').val('1');
          $("#myModal").modal();
        });

        $(document).on('click', '.submit_testimonial', function(){
          var first_name = $.trim($('#myModal input[name="first_name"]').val());
          var last_name = $.trim($('#myModal input[name="last_name"]').val());
          var title = $.trim($('#myModal input[name="title"]').val());
          var comment = $.trim($('#myModal textarea[name="comment"]').val());
          var status = $('#myModal select[name="status"]').val();
          var remove_image = $('#myModal input[name="remove_image"]:checked').length;
          var remove_post_image = $('#myModal input[name="remove_post_image"]:checked').length;
          var testimonial_id = $.trim($('#myModal input[name="testimonial_id"]').val());
          var image = document.getElementsByName("testimonial_image")[0];
          var post_image = document.getElementsByName("testimonial_post_image")[0];

          var data = new FormData();
          data.append('first_name', first_name);
          data.append('last_name', last_name);
          data.append('title', title);
          data.append('comment', comment);
          data.append('status', status);
          data.append('remove_image', remove_image);
          data.append('remove_post_image', remove_post_image);
          data.append('testimonial_id', testimonial_id);
          if(image.value != '') {
              data.append('image', image.files[0]);
          }
          if(post_image.value != '') {
              data.append('post_image', post_image.files[0]);
          }
          data.append('_token', $('meta[name="csrf-token"]').attr('content'));
          $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '<?php echo e(url('admin/set_testimonial')); ?>',
            data: data,
            processData: false,
            contentType: false,
            success: function (data) {
              location.reload();
            }
          });
        });

        $(document).on('click', '.edit_testimonial', function(){
          var testimonial_id = $(this).attr('testimonial_id');
          var data = new FormData();
          data.append('testimonial_id', testimonial_id);
          data.append('_token', $('meta[name="csrf-token"]').attr('content'));
          $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '<?php echo e(url('admin/get_testimonial')); ?>',
            data: data,
            processData: false,
            contentType: false,
            success: function (data) {
              var testimonial = data.data.testimonial;
              $('#myModal input[name="first_name"]').val(testimonial.first_name);
              $('#myModal input[name="last_name"]').val(testimonial.last_name);
              $('#myModal input[name="title"]').val(testimonial.title);
              $('#myModal textarea[name="comment"]').val(testimonial.comment);
              $('#myModal select[name="status"]').val(testimonial.status);
              $('#myModal input[name="testimonial_id"]').val(testimonial.id);
              $('#myModal .imgBlock').hide();
              $('#myModal .imgBlockPost').hide();

              $('#myModal .imgBlock input[name="remove_image"]').prop('checked', false);
              $('#myModal .imgBlockPost input[name="remove_post_image"]').prop('checked', false);

              if(testimonial.image != '' && testimonial.image != null) {
                $('#myModal .imgBlock img').attr('src', '<?php echo e(url('public/uploads/testimonial')); ?>/' + testimonial.image);
                $('#myModal .imgBlock').show();
              }

              var postimage = testimonial.post_image;
              var myarr = postimage.split(".");
              var myvar = myarr[1];
               
              if(testimonial.post_image != '' && testimonial.post_image != null) {
                if(myvar !='' && myvar !=null || myvar == 'mp4' || myvar == 'ogx' || myvar == 'oga' || myvar == 'ogv' || myvar == 'ogg' || myvar == 'webm' ){
                  var url = '<?php echo e(url('public/uploads/testimonial/post_image')); ?>'+testimonial.post_image;
                 var video_show = "<video style='max-height: 100px;' controls><source src="+url+" type='video/mp4'></video>";
                 $('#myModal .imgBlockPost').append(video_show);
                  $('#myModal .imgBlockPost').show();
                }
                else{
                  var url = '<?php echo e(url('public/uploads/testimonial/post_image')); ?>'+testimonial.post_image;
                  var image_show = "<img src="+url+" style='max-height: 100px;' /><br>";
                  $('#myModal .imgBlockPost').append(image_show);
                   $('#myModal .imgBlockPost').show();
                }
                
                //$('#myModal .imgBlockPost img').attr('src', '<?php echo e(url('public/uploads/testimonial/post_image')); ?>/' + testimonial.post_image);
               
              }

              $("#myModal").modal();
            }
          });
        });

        $(document).on('click', '.delete_testimonial', function(){
          var testimonial_id = $(this).attr('testimonial_id');
          if(confirm('Are you sure to delete this testimonial?')) {
            var url = '<?php echo e(url('admin/delete_testimonial')); ?>';
            var data = new FormData();
            data.append('testimonial_id', testimonial_id);
            data.append('_token', $('meta[name="csrf-token"]').attr('content'));
            $.ajax({type: 'POST', dataType: 'json', url: url, data: data, processData: false, contentType: false, success: function (data) {
                location.reload();
              }
            });
          }
        })

      });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\umami\resources\views/backend/testimonials.blade.php ENDPATH**/ ?>
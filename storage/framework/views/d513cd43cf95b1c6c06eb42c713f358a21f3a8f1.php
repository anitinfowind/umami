
<div class="box-body">
    <div class="form-group">
        <?php echo e(Form::label('Restaurant', trans('Restaurant'), ['class' => 'col-lg-2 control-label required'])); ?>


        <div class="col-lg-10">
        <select name="restaurant_id" class="form-control tags box-size"  required="">
          <option value="">Select Restaurant</option>
          <?php $__currentLoopData = $restaurants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $restaurant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <option value="<?php echo e($restaurant->id); ?>" <?php if(isset($products) && !empty($products->restaurant_id) && $products->restaurant_id==$restaurant->id): ?> selected <?php endif; ?>><?php echo e($restaurant->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        <?php echo e(Form::label('Product name', trans('Title'), ['class' => 'col-lg-2 control-label required'])); ?>


        <div class="col-lg-10">
            <?php echo e(Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('Product Title'), 'required' => 'required'])); ?>

        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        <?php echo e(Form::label('Serving For', 'Serving For', ['class' => 'col-lg-2 control-label required'])); ?>


        <div class="col-lg-10">
            <select name="serving_for" class="form-control tags box-size"  required="">
                <option value="">Select</option>
                <option value="people" <?php if(isset($products) && !empty($products->serving_for) && $products->serving_for=='people'): ?> selected <?php endif; ?>>/people</option>
                <option value="meals" <?php if(isset($products) && !empty($products->serving_for) && $products->serving_for=='meals'): ?> selected <?php endif; ?>>/meals</option>
                <option value="pcs" <?php if(isset($products) && !empty($products->serving_for) && $products->serving_for=='pcs'): ?> selected <?php endif; ?>>/pcs</option>
                <option value="servings" <?php if(isset($products) && !empty($products->serving_for) && $products->serving_for=='servings'): ?> selected <?php endif; ?>>/servings</option>
            </select>
        </div><!--col-lg-10-->
    </div><!--form control-->

     <div class="form-group">
        <?php echo e(Form::label('categories', trans('Category'), ['class' => 'col-lg-2 control-label'])); ?>

		<input type="hidden" name="is_rating_show" id="is_rating_show" value="<?php if(isset($products->is_rating_show)){ echo $products->is_rating_show;}?>">
        <div class="col-lg-10">
        <select name="category_id[]" class="form-control tags box-size categories" multiple="multiple">
          <option value="null">Select Category</option>
          <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if(isset($products->category_id) && !empty($products->category_id)): ?>
        <?php 
        $cate=explode(',',$products->category_id);
        $selected='';
        if (in_array($cat->id, $cate)) {
          $selected='selected';
        }
         ?>
         <?php endif; ?>
           <option value="<?php echo e($cat->id); ?>" <?php if(isset($products->category_id) && !empty($products->category_id)): ?><?php echo e($selected); ?>  <?php endif; ?>><?php echo e($cat->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        </div><!--col-lg-10-->
    </div><!--form control-->

      <div class="form-group showsubcat" style="display: none;">
        <?php echo e(Form::label('categories', trans('Product Sub category'), ['class' => 'col-lg-2 control-label required'])); ?>


        <div class="col-lg-10">
          <div class="productsubcategory"></div>
         
        </div><!--col-lg-10-->
    </div><!--form control-->

      <div class="form-group">
        <?php echo e(Form::label('Brand', trans('Brand'), ['class' => 'col-lg-2 control-label'])); ?>


        <div class="col-lg-10">
        <select name="brand_id[]" class="form-control tags box-size" multiple="multiple">
          <option value="null">Select Brand</option>
          <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if(isset($products->brand_id) && !empty($products->brand_id)): ?>
          <?php 
        $brandings=explode(',',$products->brand_id);
        $selecte='';
        if (in_array($brand->id, $brandings)) {
          $selecte='selected';
        }
         ?>
         <?php endif; ?>
           <option value="<?php echo e($brand->id); ?>" <?php if(isset($products) && !empty($products->brand_id)): ?> <?php echo e($selecte); ?> <?php endif; ?>><?php echo e($brand->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        <?php echo e(Form::label('diet', trans('Diet'), ['class' => 'col-lg-2 control-label'])); ?>


        <div class="col-lg-10 mce-box">
            <select name="diet_id[]" class="form-control tags box-size"  multiple="multiple">
              <option value="null">Select Deit</option>

              <?php $__currentLoopData = $diets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if(isset($products->diet_id) && !empty($products->diet_id)): ?>
              <?php 
                $dietsfor=explode(',',$products->diet_id);
                $selecte='';
                if (in_array($diet->id, $dietsfor)) {
                  $selecte='selected';
                }
                 ?>
             <?php endif; ?>
               <option value="<?php echo e($diet->id); ?>" <?php if(isset($products) && !empty($products->diet_id)): ?> <?php echo e($selecte); ?> <?php endif; ?>><?php echo e($diet->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div><!--col-lg-10-->
    </div><!--form control-->

   <!--  <div class="form-group">
        <?php echo e(Form::label('Region', trans('Region'), ['class' => 'col-lg-2 control-label required'])); ?>


        <div class="col-lg-10 mce-box">
            <select name="region_id" class="form-control tags box-size" required="">
              <option value="">Select Region</option>
              <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <option value="<?php echo e($region->id); ?>" <?php if(isset($products) && !empty($products->region_id) && $products->region_id==$region->id): ?> selected <?php endif; ?>><?php echo e($region->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div> --><!--form control-->

    <div class="form-group">
        <?php echo e(Form::label('Price', trans('Price'), ['class' => 'col-lg-2 control-label required'])); ?>


        <div class="col-lg-10">
            <?php echo e(Form::text('price', null, ['class' => 'form-control box-size', 'placeholder' => trans('Price'), 'required' => 'required'])); ?>

        </div>
    </div><!--form control-->
    <div class="form-group">
        <?php echo e(Form::label('Daily Limit', trans('Daily Limit'), ['class' => 'col-lg-2 control-label required'])); ?>

        <div class="col-lg-10">
            <?php echo e(Form::text('daily_limit', ($products->daily_limit ?? ''), ['class' => 'form-control box-size', 'placeholder' => trans('Daily Limit'), 'required' => 'required'])); ?>

        </div>
    </div><!--form control-->
    <div class="form-group">
        <?php echo e(Form::label('Sold Out', trans('Sold Out'), ['class' => 'col-lg-2 control-label'])); ?>

        <div class="col-lg-10 mce-box">
         <?php echo e(Form::select(
                'sold_out',
                [
                    '0' => 'No',
                    '1' => 'Yes'
                ],
                null,
                [
                    'class' => 'form-control shippingtype tags box-size'
                ]
            )); ?>

        </div><!--col-lg-10-->
    </div><!--form control-->
    <!--  <div class="form-group">
        <?php echo e(Form::label('Discount', trans('Discount'), ['class' => 'col-lg-2 control-label'])); ?>


        <div class="col-lg-10">
            <?php echo e(Form::text('discount', null, ['class' => 'form-control box-size', 'placeholder' => trans('Discount')])); ?>

        </div>
    </div> --><!--form control-->

    <div class="form-group">
        <?php echo e(Form::label('Quantity', trans('Quantity'), ['class' => 'col-lg-2 control-label'])); ?>


        <div class="col-lg-10">
            <?php echo e(Form::text('quantity', null, ['class' => 'form-control box-size', 'placeholder' => trans('Quantity'),'required' => 'required'])); ?>

        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
        <?php echo e(Form::label('Shipping', trans('Shipping Lable'), ['class' => 'col-lg-2 control-label required'])); ?>


        <div class="col-lg-10">
               <div class="col-md-2">
                <label for="Weight" class="col-lg-2 control-label">Weight</label>
                <?php echo e(Form::text('weight', null, ['class' => 'form-control box-size', 'placeholder' => trans('Weight'),'required' => 'required'])); ?>

              </div>
              <div class="col-md-2">
                 <label for="Height" class="col-lg-2 control-label">Height</label>
                <?php echo e(Form::text('height', null, ['class' => 'form-control box-size', 'placeholder' => trans('Height'),'required' => 'required'])); ?>

              </div>
              <div class="col-md-2">
                <label for="Length" class="col-lg-2 control-label">Length</label>
                <?php echo e(Form::text('length', null, ['class' => 'form-control box-size', 'placeholder' => trans('Length'),'required' => 'required'])); ?>

              </div>
              <div class="col-md-2">
                 <label for="Width" class="col-lg-2 control-label">Width</label>
                <?php echo e(Form::text('width', null, ['class' => 'form-control box-size', 'placeholder' => trans('Width'),'required' => 'required'])); ?>

              </div>
        </div><!--col-lg-10-->
    </div><!--form control-->
   <div class="form-group">
        <?php echo e(Form::label('Shipping Type', trans('Shipping Type'), ['class' => 'col-lg-2 control-label'])); ?>


        <div class="col-lg-10 mce-box">
         <?php echo e(Form::select(
                'shipping_type',
                [
                    '' => 'Select Shipping',
                    'FREE' => 'FREE',
                    'PAID' => 'PAID'
                ],
                null,
                [
                    'class' => 'form-control shippingtype tags box-size'
                ]
            )); ?>

        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        <?php echo e(Form::label('Shipping Price', trans('Shipping Price'), ['class' => 'col-lg-2 control-label required'])); ?>


        <div class="col-lg-10">
            <?php echo e(Form::text('shipping_price', null, ['class' => 'form-control box-size', 'placeholder' => trans('Price'), 'required' => 'required'])); ?>

        </div>
    </div><!--form control-->

    <div class="form-group">
        <?php echo e(Form::label('description', trans('Description'), ['class' => 'col-lg-2 control-label'])); ?>


        <div class="col-lg-10 mce-box">
            <?php echo e(Form::textarea('description', null, ['class' => 'form-control box-size','rows'=>3])); ?>

        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        <?php echo e(Form::label('Ingredients', trans('Ingredients'), ['class' => 'col-lg-2 control-label' ])); ?>


        <div class="col-lg-10 mce-box">
            <?php echo e(Form::textarea('ingredients', null, ['class' => 'form-control box-size required','rows'=>3])); ?>

        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
        <?php echo e(Form::label('Instruction', trans('Instruction'), ['class' => 'col-lg-2 control-label'])); ?>


        <div class="col-lg-10 mce-box">
            <?php echo e(Form::textarea('nutrition', null, ['class' => 'form-control box-size','rows'=>3])); ?>

        </div><!--col-lg-10-->
    </div><!--form control-->
     <!--  <div class="form-group">
        <?php echo e(Form::label('Instruction', trans('Instruction Image'), ['class' => 'col-lg-2 control-label'])); ?>


        <div class="col-lg-10 mce-box">
              <input type="file" name="instruction_img" class="form-control box-size">
        </div>
    </div> -->
    <div class="form-group">
        <?php echo e(Form::label('How to store food', trans('How to store food'), ['class' => 'col-lg-2 control-label'])); ?>


        <div class="col-lg-10 mce-box">
            <?php echo e(Form::textarea('details', null, ['class' => 'form-control box-size', 'rows'=>3])); ?>

        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
        <?php echo e(Form::label('Home Recommended ', trans('Home Recommended'), ['class' => 'col-lg-2 control-label'])); ?>


        <div class="col-lg-10 mce-box">
         <?php echo e(Form::select(
                'is_home_recommended',
                [
                    '' => 'Select',
                    'active' => 'Show',
                    'inactive' => 'Hide'
                ],
                null,
                [
                    'class' => 'form-control is_home_recommended tags box-size'
                ]
            )); ?>

        </div><!--col-lg-10-->
    </div>
    <div class="form-group">
        <?php echo e(Form::label('Home category products', trans('Home category products'), ['class' => 'col-lg-2 control-label'])); ?>


        <div class="col-lg-10 mce-box">
         <?php echo e(Form::select(
                'is_home_cat_product',
                [
                    '' => 'Select',
                    'active' => 'Show',
                    'inactive' => 'Hide'
                ],
                null,
                [
                    'class' => 'form-control is_home_cat_product tags box-size'
                ]
            )); ?>

        </div><!--col-lg-10-->
    </div>
    <?php if(isset($products->is_rating_show)): ?>
    <?php if($products->is_rating_show=='Y'): ?>
    <?php if($total_user>0): ?>
    <div class="row1111" id="rating_del_btn_section">
      <div class="col-md-12">
        <div class="table-responsive111111">
          <table class="table table-striped">
            <tbody>
              <tr>
                <th>Total User</th>
                <th>Rating</th>
                <th>Action</th>
              </tr>
              <tr>
                <td align="left"><?php echo e($total_user); ?></td>
                <td align="left"><?php echo e($total_user_rating); ?></td>
                <td align="left"><a href="javascript:;" class="btn btn-success btn-sm" id="rating_del_btn"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    <?php endif; ?>
    <div class="form-group">
      <?php echo e(Form::label('Video', trans('Video'), ['class' => 'col-lg-2 control-label'])); ?>

      <div class="col-lg-10">
        <input type="file" name="video" class="form-control box-size" accept="video/*">
        <br>
        <?php if(isset($products) && !empty($products)): ?>
          <?php if(!empty($products->video) && file_exists(public_path().'/uploads/product/'.$products->video)): ?>
             <video width="100%" height="240" controls>
              <source src="<?php echo e(URL::to('uploads/product/'.$products->video)); ?>" type="video/mp4">
            </video>
           <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
    <div class="form-group">
        <?php echo e(Form::label('Product Image', trans('Product Image'), ['class' => 'col-lg-2 control-label'])); ?>

        <div class="form-group col-lg-9">
          <div class="demo"> 
    <ul id="sortable1" class="connectedSortable" style="list-style: none">
      <input type="file" name="image[]" multiple class="form-control box-size">
          <?php if(isset($products) && !empty($products)): ?>
            <?php $__currentLoopData = $products->productImage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $producimg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
           // print_r($products->productImage);die;
            $info = pathinfo(PRODUCT_ROOT_PATH.$producimg->image);
               $ext = $info['extension'];
              ?>
              
              <?php if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp'): ?>
                  <?php if(file_exists(public_path().'/uploads/product/'.$producimg->image)): ?>
                  <li id="item<?php echo e($key+1); ?>" data-id="<?php echo e($producimg->id); ?>" class=" image_<?php echo e($producimg->id); ?>">
                      <span class="pip" id="image_<?php echo e($producimg->id); ?>">
                      <img  width="100%" style="padding: 5px" height="125px" class="imageThumb" src="<?php echo e(URL::to('public/uploads/product/'.$producimg->image)); ?>">
                    <span class="remove" onclick="productRemoveImageAdmin(<?php echo e($producimg->id); ?>)">Remove
                    </span></span>
                     <input type="hidden" name="product_image_id[]" value="<?php echo e($producimg->id); ?>">
                   <input type="hidden" name="product_all_id[]" value="<?php echo e($producimg->product_id); ?>">
                  <input type="hidden" name="product_image_url[]" value="<?php echo e($producimg->image); ?>">
                  </li>
                 
                     <?php else: ?>
                     <li id="<?php echo e($key+1); ?>" class="">
                      <span class="pip" id="image_<?php echo e($producimg->id); ?>">
                      <img  width="100%" style="padding: 5px" height="125px" class="imageThumb" src="<?php echo e(URL::to('noimage.png')); ?>">
                    <span class="remove" onclick="productRemoveImageAdmin(<?php echo e($producimg->id); ?>)">Remove
                    </span></span></li>
                   
                   <?php endif; ?>
              <?php else: ?>
               <li id="item<?php echo e($key+1); ?>" data-id="<?php echo e($producimg->id); ?>" class=" image_<?php echo e($producimg->id); ?>">
                 <span class="pip" id="image_<?php echo e($producimg->id); ?>">
                  <video width="150px" height="100px" controls>
                      <source src="<?php echo e(PRODUCT_URL.$producimg->image); ?>" type="video/mp4">
                  </video>
                 <span class="remove" onclick="productRemoveImageAdmin(<?php echo e($producimg->id); ?>)">Remove
                    </span></span>
                    <input type="hidden" name="product_image_id[]" value="<?php echo e($producimg->id); ?>">
                   <input type="hidden" name="product_all_id[]" value="<?php echo e($producimg->product_id); ?>">
                  <input type="hidden" name="product_image_url[]" value="<?php echo e($producimg->image); ?>">
                </li>
                  
              <?php endif; ?>
           
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           </ul>
       </div>
            
          <?php endif; ?>
        </div>
    </div>
    
</div>

    <!-- <div class="option_add_copy" style="display:none">
        <div class="option_wrap_copy">
            <div class="form-group">
                <div class="col-md-8">
                    <label for="Height" class="col-lg-2 control-label">Option</label>
                    <?php echo e(Form::text('addon_option[]', null, ['class' => 'form-control option_class box-size'])); ?>

                </div>
                <div class="col-md-2">
                    <label for="Length" class="col-lg-2 control-label">Price</label>
                    <?php echo e(Form::text('price[]', 0, ['class' => 'form-control price_class box-size'])); ?>

                </div>
                <div class="option_remove_wrap">
                    <button type="button" class="btn btn-danger option_remove">-</button>
                </div>
            </div>
        </div>
    </div>

    <div class="addon_for_copy" style="display:none">
        <div class="addon_wrapper">
            <div class="form-group">
                <div class="col-lg-8">
                    <div class="">
                        <label for="Weight" class="col-lg-2 control-label">Label</label>
                        <?php echo e(Form::text('label[]', null, ['class' => 'form-control label_class box-size'])); ?>

                    </div>
                </div>
            </div>
            
            <div class="option_wrap">
                <div class="form-group">
                    <div class="col-md-8">
                        <label for="Height" class="col-lg-2 control-label">Option</label>
                        <?php echo e(Form::text('addon_option[]', null, ['class' => 'form-control box-size'])); ?>

                    </div>
                    <div class="col-md-2">
                        <label for="Length" class="col-lg-2 control-label">Price</label>
                        <?php echo e(Form::text('price[]', 0, ['class' => 'form-control box-size'])); ?>

                    </div>
                    <div class="option_add">
                        <button type="button" class="btn btn-info option_add_more">+</button>
                    </div>
                </div>
            </div>
            <div class="remove col-md-2">
                <button type="button" class="btn btn-danger remove">Remove</button>
            </div>
        </div>
    </div>-->
    <?php $product_addons = [];
    if(!empty($products->id)) {
        $product_addons = get_addon_price($products->id);
    }
    $inc = 0;
    ?>

    <?php if(!empty($product_addons)): ?>
        <?php $__currentLoopData = $product_addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="addon_<?php echo e($key); ?> addon_wrapper">
            <div class="form-group">
                <?php echo e(Form::label('Addons', 'Addons', ['class' => 'col-lg-2 control-label required'])); ?>


                <div class="col-lg-8">
                    <div class="">
                        <label for="Weight" class="col-lg-2 control-label">Label</label>
                        <?php echo e(Form::text('label[]', $key, ['class' => 'form-control box-size'])); ?>

                    </div>
                </div><!--col-lg-10-->
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove">Remove</button>
                </div>
            </div><!--form control-->
            
            <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="option_wrap_<?php echo e($row['id']); ?> option_wrap option_wrap_copy">
                <div class="col-md-2"></div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label for="Height" class="col-lg-2 control-label">Option</label>
                        <?php echo e(Form::text('label_option['.$inc.'][addon_option][]', $row['option_name'], ['class' => 'form-control box-size','required' => 'required'])); ?>

                    </div>
                    <div class="col-md-2">
                        <label for="Length" class="col-lg-2 control-label">Price</label>
                        <?php echo e(Form::text('label_option['.$inc.'][price][]', $row['price'], ['class' => 'form-control box-size'])); ?>

                    </div>

                    <div class="col-md-1">
                        <label for="Length" class="col-lg-1 control-label">Shipping Price</label>
                        <?php echo e(Form::text('label_option['.$inc.'][shipping_price][]', $row['shipping_price'], ['class' => 'form-control box-size'])); ?>

                    </div>

                    <?php if($index == 0): ?>
                        <div class="option_add">
                            <button type="button" class="btn btn-info option_add_more" id="<?php echo e($inc); ?>">+</button>
                        </div>
                    <?php else: ?>
                        <div class="option_remove_wrap">
                            <button type="button" class="btn btn-danger option_remove">-</button>
                        </div>
                    <?php endif; ?>
                </div><!--form control-->
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div><hr>
        <?php $inc++; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <div class="addon">
        <div class="form-group">
            <?php echo e(Form::label('Addons', 'Addons', ['class' => 'col-lg-2 control-label'])); ?>


            <div class="col-lg-8">
                <label for="Weight" class="col-lg-2 control-label">Label</label>
                <?php echo e(Form::text('label[]', null, ['class' => 'form-control box-size'])); ?>

            </div><!--col-lg-10-->
            <div class="col-lg-2">
                <button type="button" class="btn btn-primary add_more">Add More</button>
            </div>

        </div><!--form control-->
        
        <div class="option_wrap">
            <div class="form-group">
            <div class="col-md-2"></div>
                <div class="col-md-6">
                    <label for="Height" class="col-lg-2 control-label">Option</label>
                    <?php echo e(Form::text('label_option['.$inc.'][addon_option][]', null, ['class' => 'form-control box-size'])); ?>

                </div>
                <div class="col-md-2">
                    <label for="Length" class="col-lg-2 control-label">Price</label>
                    <?php echo e(Form::text('label_option['.$inc.'][price][]', 0, ['class' => 'form-control box-size'])); ?>

                </div>

                <div class="col-md-1">
                    <label for="Length" class="col-lg-2 control-label">Shipping Price</label>
                    <?php echo e(Form::text('label_option['.$inc.'][shipping_price][]', 0, ['class' => 'form-control box-size'])); ?>

                </div>

                <div class="col-md-1 option_add">
                    <button type="button" class="btn btn-info option_add_more" id="0">+</button>
                </div>
            </div><!--form control-->
        </div>
        <hr>
    </div>
    <?php $inc++; ?>
<?php $__env->startSection('after-scripts'); ?>
   <!--  <script type="text/javascript">
        Backend.Faq.init('<?php echo e(config('locale.languages.' . app()->getLocale())[1]); ?>');
    </script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript">
var count = <?php echo $inc; ?>;
var x;

$(document).on('click','#rating_del_btn',function(){
	var r = confirm("Are you sure to delete this restaurant rating?");
	if (r == true) {
		$('#is_rating_show').val('N');
		$('#rating_del_btn_section').hide();
	}
});


// $(document).on('click','.add_more',function(){
//     $('label_class').attr('name', 'newName');
//     var addon = $('.addon_for_copy').html();
//     $('.addon').append(addon);
//     count++;
// });


$(document).on('click','.add_more',function(){
    //count++;
    var addon = '<div class="addon_wrapper" id="'+ count +'"><div class="form-group"><div class="col-md-2"></div><div class="col-lg-8"><label for="Weight" class="col-lg-2 control-label">Label</label>\
            <input id="'+ count +'" type="text" name="label[]" class="form-control label_class box-size"></div>\
            <div class="col-md-2">\
                <button type="button" class="btn btn-danger remove">Remove</button>\
            </div>\
                </div><div class="option_wrap"><div class="form-group"><div class="col-md-2"></div>\
                <div class="col-md-6"><label for="Height" class="col-lg-2 control-label">Option</label><input type="text" name="label_option['+ count +'][addon_option][]" class="form-control box-size"></div>\
                <div class="col-md-2">\
                        <label for="Length" class="col-lg-2 control-label">Price</label>\
                        <input type="text" name="label_option['+ count +'][price][]" value="0" class="form-control box-size">\
                    </div>\
                    <div class="col-md-1">\
                        <label for="Length" class="col-lg-1 control-label">Shipping Price</label>\
                        <input type="text" name="label_option['+ count +'][shipping_price][]" value="0" class="form-control box-size">\
                    </div>\
                    <div class="option_add">\
                        <button type="button" class="btn btn-info option_add_more" id="'+count+'">+</button>\
                    </div>\
                </div>\
            </div>\
        </div><hr>';
    $('.addon').append(addon);
    count++;
});

$(document).on('click','.remove',function(){
    $(this).closest('.addon_wrapper').remove();
    count--;
});

// $(document).on('click','.option_add_more',function(){
//     var addon = $('.option_add_copy').html();
//     $(this).closest('.option_wrap').append(addon);
//     count++;
// });


$(document).on('click','.option_add_more',function(){
    var label_id = $(this).attr('id');
    var addon = '<div class="option_wrap_copy">\
            <div class="form-group"><div class="col-md-2"></div>\
                <div class="col-md-6">\
                    <label for="Height" class="col-lg-2 control-label">Option</label>\
                    <input type="text" name="label_option['+ label_id +'][addon_option][]" class="form-control box-size">\
                </div>\
                <div class="col-md-2">\
                    <label for="Length" class="col-lg-2 control-label">Price</label>\
                    <input type="text" name="label_option['+ label_id +'][price][]" value="0" class="form-control box-size">\
                </div>\
                 <div class="col-md-1">\
                    <label for="Length" class="col-lg-1 control-label">Shipping Price</label>\
                    <input type="text" name="label_option['+ label_id +'][shipping_price][]" value="0" class="form-control box-size">\
                </div>\
                <div class="option_remove_wrap">\
                    <button type="button" class="btn btn-danger option_remove">-</button>\
                </div>\
            </div>\
        </div>';
    $(this).closest('.option_wrap').append(addon);
});

$(document).on('click','.option_remove',function(){
    $(this).closest('.option_wrap_copy').remove();
});
</script>
    
    

    <script type="text/javascript">
      $( "#sortable1").sortable({
        //items: 'li:not(:first)',
    connectWith: ".connectedSortable",
    stop: function(event, ui) {
        $('.connectedSortable').each(function() {
            result = "";
           // alert($(this).sortable("toArray"));
            $(this).find("li").each(function(){
                result += $(this).text() + ",";
            });
          //  $("."+$(this).attr("id")+".list").html(result);
        });
    }
});

      $('.categories2222').on('change', function()
      {
        var id= $(this).val();
         $.ajax({
           url:"<?php echo e(url('admin/subcategory')); ?>",
           type:'get',
           data:{id:id},
           success:function(result)
           {
             if(result!='')
             {
              $('.showsubcat223').show();
              $('.productsubcategory').html('');
              $('.productsubcategory').append(result);
             }
             else
             {
              $('.showsubcat').hide();
             }
           }
         })
      });

    $('.shippingtype').on('change', function() {
        var id= $(this).val();
        if(id=='PAID') {
          $('.shippingprice').removeClass('novalidate');
          $('.shippingpaid').show();
        } else {
           $('.shippingprice').addClass('novalidate');
          $('.shippingpaid').hide();
        }
    });

     function productRemoveImageAdmin(imageId)
     {
      $.ajax({
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        url: "<?php echo e(url('admin/products/remove-image')); ?>",
        type: 'post',
        data: { 'image_id' : imageId },
        beforeSend: function() {
          $("#overlay").show();
        },
        success:function(data) {
          $('.image_'+imageId).hide();
          location.reload();
          $("#overlay").hide();
        }
      });
    }
    </script>
<style type="text/css">
  .remove {
    display: block;
    background: #444;
    border: 1px solid black;
    color: white;
    text-align: center;
    cursor: pointer;
}
span.pip {
    display: inline-block;
}
img.imageThumb {
    width: 120px;
    height: 100px;
}
li #item1 {
    display: inline-block;
}
.connectedSortable li {
    display: inline-block;
}
.col-md-2.option_add {
    margin-top: 27px;
}
.col-md-2.option_remove_wrap {
    margin-top: 27px;
}
button.btn.btn-primary.add_more {
    margin-top: 27px;
}
button.btn.btn-danger.remove {
    margin-top: 27px;
}
button.btn.btn-danger.option_remove, .addon_wrapper .option_add_more {
    margin-left: 15px;
    margin-top: 27px;
}
</style>
<?php $__env->stopSection(); ?><?php /**PATH F:\xampp\htdocs\umami\resources\views/backend/products/form.blade.php ENDPATH**/ ?>
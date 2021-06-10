@extends('frontend.layouts.app')
@section ('title', trans('product create'))
@section('content')
<div class="dashboard-wrap">
  <div class="container">
    <div class="row">
      @include('frontend.user.sidebar')
        <div class="col-md-9">
          <div class="dashboard-container">
            <div class="panel panel-default">
            <div class="panel-heading">
                    <div class="add-product-div">
                      <span>
                        <a href="{{ url('product-manager') }}">
                          <button type="button" class="btn add-product">
                            <i class="fa fa-arrow-left" aria-hidden="true">
                            </i> Back
                      </button>
                        </a>
                      </span>
                    </div>
                </div>
                <div class="panel-body">
                  {{ Form::model(
                          $productDetail,
                          [
                              'route' => ['frontend.update-product'],
                              'class' => 'form-horizontal',
                              'role' => 'form',
                              'method' => 'POST',
                              'id' => 'product',
                              'files' => 'true'
                          ])
                  }}
                    <div class="product_error_div"></div>
                    <div class="row">
                          {{ Form::hidden(
                                  'id',
                                  null
                              )
                          }}
                        <div class="form-group col-md-6">
                          <label class = 'control-label'>Title<span class="required">*</span></label>
                            <div class="">
                              {{ Form::text(
                                      'title',
                                      null,
                                      [
                                          'class' => 'form-control',
                                          'id' => 'title',
                                          'placeholder' => trans('Product Title')
                                      ]
                                  )
                              }}
                            </div>
                        </div>
                        <!-- <div class="form-group col-md-6">
                              <label class = 'control-label'>Category<span class="required">*</span></label>
                                <div class="">
                                  {{ Form::select(
                                          'category_id',
                                          [
                                              '' => 'Select Category'
                                          ]+$category_data,
                                          $productDetail->categoryId(),
                                          [
                                              'class' => 'form-control'
                                          ]
                                      )
                                  }}
                                </div>
                        </div> -->
                        <?php 
                          $categorymult= explode(',', $productDetail->categoryId());
                        ?>
                        <div class="form-group col-md-6">
                              <label class = 'control-label'>Category<span class="required"></span></label>
                                <div class="">
                                  {{ Form::select(
                                          'category_id[]',
                                          [
                                          ]+$category_data,
                                          $categorymult,
                                          [
                                              'class' => 'form-control',
                                              'id'=>'categorys',
                                              'multiple'=>'multiple'
                                          ]
                                      )
                                  }}
                                </div>
                        </div>
                         <?php /* <div class="form-group col-md-6">
                            <label class = 'control-label'> Brand<span class="required">*</span></label>
                              <div class="">
                                {{ Form::select(
                                        'brand_id',
                                        [
                                            '' => 'Select Brand'
                                        ]+$brands,
                                        $productDetail->brandId(),
                                        [
                                            'class'=>'form-control'
                                        ]
                                    )
                                }}
                              </div>
                          </div> */ ?>
                           <?php 
                             $brandmult= explode(',', $productDetail->brandId());
                            ?>
                          <div class="form-group col-md-6">
                            <label class = 'control-label'>Brand<span class="required"></span></label>
                              <div class="">
                                {{ Form::select(
                                        'brand_id[]',
                                        [
                                        ]+$brands,
                                        $brandmult,
                                        [
                                            'class'=>'form-control',
                                            'id' =>'lstFruits',
                                            'multiple'=>'multiple'
                                        ]
                                    )
                                }}
                               
                              </div>
                          </div>
                          <?php 
                             $dietmult= explode(',', $productDetail->dietId());
                            ?>
                          <div class="form-group col-md-6">
                              <label class = 'control-label'>Diet<span class="required"></span></label>
                                <div class="">
                                  {{ Form::select(
                                          'diet_id[]',
                                          [
                                          ]+$diet,
                                          $dietmult,
                                          [
                                              'class'=>'form-control',
                                              'id'=>'diet',
                                              'multiple'=>'multiple'
                                          ]
                                      )
                                  }}
                                </div>
                          </div>
                          <!-- <div class="form-group col-md-6">
                            <label class = 'control-label'>Price<span class="required">*</span></label>
                              <div class="input-group">
                                {{ Form::text(
                                        'price',
                                        null,
                                        [
                                            'class' => 'form-control number-field',
                                            'autocomplete' => 'off'
                                        ]
                                    )
                                }}
                                <div class="input-group-prepend">
                                  <span class="input-group-text">{{ CURRENCY }}</span>
                                </div>
                              </div>
                          </div>
 -->                         <!--  <div class="form-group col-md-6">
                              <label class = 'control-label'>Discount<span class="required"></span></label>
                                <div class="input-group">
                                  {{ Form::text(
                                          'discount',
                                          null,
                                          [
                                              'class' => 'form-control number-field',
                                              'maxlength' => 2,
                                              'autocomplete' => 'off'
                                          ]
                                      )
                                  }}
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">{{ PERCENTAGE }}</span>
                                    </div>
                                </div>
                          </div> -->
                          <div class="form-group col-md-6">
                            <label class = 'control-label'>Quantity<span class="required"></span></label>
                              <div class="input-group">
                                {{ Form::text(
                                        'quantity',
                                        null,
                                        [
                                            'class' => 'form-control number-field novalidate',
                                            'maxlength' => 5,
                                            'autocomplete' => 'off','readonly'=>true
                                        ]
                                    )
                                 }}
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">{{ QTY }}</span>
                                  </div>
                                </div>
                          </div>
                          <div class="form-group col-md-6">
                            <label class = 'control-label'>Shipping Type<span class="required"></span></label>
                              <div class="">
                                {{ Form::select(
                                        'shipping_type',
                                        [
                                            '' => 'Select Shipping',
                                            'FREE' => 'FREE (Included the price)',
                                            'PAID' => 'PAID (Not included the price)'
                                        ],
                                        $productDetail->shippingType(),
                                        [
                                            'class' => 'form-control novalidate shippingtype'
                                        ]
                                    )
                                }}
                              </div>
                          </div>
                          <div class="form-group col-md-6" style="display: none">
                            <label class = 'control-label'>Shipping Price<span class="required">*</span></label>
                              <div class="input-group">
                                @php $class = '' @endphp
                                @if($productDetail->shippingType() == 'FREE')
                                  @php $class = 'novalidate' @endphp
                                @endif        
                                  {{ Form::text(
                                          'shipping_price',
                                          null,
                                          [
                                              'class' => 'form-control number-field shippingprice '.$class,
                                              'placeholder' => trans('Shipping Price'),
                                              'maxlength' => 5,
                                              'autocomplete' => 'off'
                                          ]
                                      )
                                  }}
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ CURRENCY }}</span>
                                    </div>
                              </div>
                          </div>
                         <!--  <div class="form-group col-md-6">
                                <label class = 'control-label'>Reward<span class="required"></span></label>
                                    <div class="input-group">
                                        {{ Form::text(
                                                'reward',
                                                null,
                                                [
                                                    'class' => 'form-control number-field novalidate',
                                                    'placeholder' => trans('Reward Point'),
                                                    'maxlength'=> 100
                                                ]
                                            )
                                        }}
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Reward</span>
                                        </div>
                                    </div>
                          </div> -->
                         <!--  <div class="form-group col-md-12">
                            <label class = 'control-label'>Attributes</label>
                              <?php $check =[];
                                  if (isset($productDetail) & !empty($productDetail)){ 
                                           $check= explode(',', $productDetail->attribute_id);
                                         }
                                         ?>
                                    <div class="check-list">
                                        @foreach($attributes as $attribute)
                                        <div class="form-group  custom-checkbox-div check-data">
                                          {{ Form::checkbox('attribute_id[]', $attribute->id,  in_array($attribute->id,$check), ['id'=> $attribute->id]) }} 
                                            <label for="{{ $attribute->id }}">{{ $attribute->name }}</label>
                                          </div>
                                        @endforeach
                                    </div>
                          </div> -->
                          <div class="form-group col-md-12">
                              <label class = 'control-label'>Description<span class="required"></span></label>
                                <div class="">
                                  {{ Form::textarea(
                                          'description',strip_tags($productDetail->description()),
                                          [
                                              'class' => 'form-control novalidate textarea',
                                              'id' => 'description',
                                              'autocomplete' => 'off',
                                              'placeholder' => trans('About Product')
                                          ]
                                      )
                                  }}
                              </div>
                          </div>
                          <div class="form-group col-md-12">
                              <label class = 'control-label'>Ingredients<span class="required"></span></label>
                              <div class="">
                                  {{ Form::textarea(
                                          'ingredients',
                                          strip_tags($productDetail->ingredients()),
                                          [
                                              'class' => 'form-control novalidate textarea',
                                              'id' => 'ingredients',
                                              'autocomplete' => 'off',
                                              'placeholder' => trans('Ingredients')
                                          ]
                                      )
                                  }}
                              </div>
                          </div>
                          <div class="form-group col-md-12">
                              <label class = 'control-label'>Instruction<span class="required"></span></label>
                              <div class="">
                                  {{ Form::textarea(
                                          'nutrition',strip_tags($productDetail->nutrition()),
                                          [
                                              'class' => 'form-control novalidate textarea',
                                              'id' => 'nutrition',
                                              'autocomplete' => 'off',
                                              'placeholder' => trans('Nutrition')
                                          ]
                                      )
                                  }}
                              </div>
                          </div>
                          <div class="form-group col-md-12">
                              <label class = 'control-label'>How to store food<span class="required"></span></label>
                              <div class="">
                                  {{ Form::textarea(
                                          'details',
                                          strip_tags($productDetail->details()),
                                          [
                                              'class' => 'form-control novalidate textarea',
                                              'id' => 'product_details',
                                              'autocomplete' => 'off',
                                              'placeholder' => trans('Product Details')
                                          ]
                                      )
                                  }}
                              </div>
                          </div>
                          
                          <div class="form-group col-md-12">
                              <label class = 'control-label'>Video<span class=""></span></label>
                              <div class="">
                                  <input type="file" name="video" accept="video/*">
                                   @if($productDetail->video !=='' && File::exists(PRODUCT_ROOT_PATH.$productDetail->video))
                                  <?php $video = PRODUCT_URL.$productDetail->video; ?>
                                 <video width="320" height="240" controls>
                                  <source src="{{$video}}" type="video/mp4">
                                </video>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group col-md-12">
                            <label class = 'control-label'>Images<span class="required"></span><span style="color: red">  ( Image must be greater than (1024X680) )</span></label>
                              <div class="">
                                <input type="file" id="files" />
                                 <ul id="sortable1" class="connectedSortable" style="list-style: none">
                                  @if(($productDetail) && $productDetail->productImage->isNotEmpty())
                                    @foreach($productDetail->productImage as $productImage)
                                    <?php 
                                     $info = pathinfo(PRODUCT_ROOT_PATH.$productImage->image);
                                     $ext = $info['extension'];
                                     ?>
                                      @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
                                          @if($productImage->image() !=='' && File::exists(PRODUCT_ROOT_PATH.$productImage->image()))
                                            <?php $image = PRODUCT_URL.$productImage->image(); ?>
                                            @else
                                              <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                                            @endif

                                                <span class="pip" id="image_{{ $productImage->id }}">
                                                  <input type="hidden" name="product_image_id[]" value="{{$productImage->id}}">
                                                   <input type="hidden" name="product_all_id[]" value="{{$productImage->product_id}}">
                                                  <input type="hidden" name="product_image_url[]" value="{{$productImage->image}}">
                                                  <img class="imageThumb" src="{{ $image }}">
                                                <span class="remove" onclick="productRemoveImage({{ $productImage->id }})">Remove
                                                </span></span>
                                            @else
                                            <span class="pip" id="image_{{ $productImage->id }}">
                                              <input type="hidden" name="product_image_id[]" value="{{$productImage->id}}">
                                              <input type="hidden" name="product_all_id[]" value="{{$productImage->product_id}}">
                                              <input type="hidden" name="product_image_url[]" value="{{$productImage->image}}">
                                             <?php $video = PRODUCT_URL.$productImage->image(); ?>
                                                <video width="120" height="100" controls>
                                                  <source src="{{ $video}}" type="video/mp4">
                                                </video>
                                                <span class="remove" onclick="productRemoveImage({{ $productImage->id }})">Remove</span>
                                            </span>
                                            @endif    
                                    @endforeach
                                  @endif
                                </ul>
                                </div>
                          </div>
                          <div class="form-group">
                              <div class="col-md-6 col-md-offset-4">
                                 <button
                                    onclick='formData("product", false, false, "{{ url('product-manager') }}")'
                                    type="button"
                                    class="btn order-btn"
                            >
                                Submit
                            </button>
                              </div>
                          </div>
                    </div>
                      {{ Form::close() }}
                </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

@endsection
@section('after-script')
<script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"
    type="text/javascript"></script>
    <link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"
    rel="stylesheet" type="text/css" />


    <script type="text/javascript">
    $(function () {
        $('#lstFruits').multiselect({
            includeSelectAllOption: true,
            nonSelectedText:'Select Brand',
            buttonWidth: '390px',
            buttonHeight: '48px',
        });
         $('#diet').multiselect({
            includeSelectAllOption: true,
            nonSelectedText:'Select Diet',
            buttonWidth: '390px',
            buttonHeight: '48px',
        });
          $('#categorys').multiselect({
            includeSelectAllOption: true,
            nonSelectedText:'Select Category',
            buttonWidth: '390px',
            buttonHeight: '48px',
        });
    });

          $( "#sortable1").sortable({
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
</script>
@endsection
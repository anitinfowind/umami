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
			<i class="fa fa-arrow-left" aria-hidden="true"></i> Back
		</button>
                    </a>
                </span>
            </div>
        </div>
        <div class="panel-body">
            {{ Form::open([
                    'url' => 'add-product',
                    'class' => 'form-horizontal',
                    'id'=>'product',
                    'method' => 'POST',
                    'files'=>'true'
                ])
            }}
                <div class="product_error_div"></div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class = 'control-label'>Title<span class="required">*</span></label>
                        <div class="">
                            {{ Form::text(
                                    'title',
                                    '',
                                    [
                                        'class' => 'form-control',
                                        'id' => 'title',
                                        'autocomplete' => 'off',
                                        'placeholder' => trans('Title')
                                    ]
                                )
                            }}
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class = 'control-label'>Category<span class="required"></span></label>
                        <div class="">
                            {{ Form::select(
                                    'category_id[]',
                                    [
                                    ]+$category_data,
                                    '',
                                    [
                                        'class' => 'form-control',
                                        'id'=>'categorys',
                                        'multiple'=>'multiple'
                                    ]
                                )
                            }}
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class = 'control-label'>Brand<span class="required"></span></label>
                        <div class="multiselect-input">
                            {{ Form::select(
                                    'brand_id[]',
                                    [
                                    ]+$brands,
                                    '',
                                    [
                                        'class' => 'form-control',
                                        'id'=>'brand',
                                        'multiple'=>'multiple'
                                    ]
                                )
                            }}
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class = 'control-label'>Diet<span class="required"></span></label>
                        <div class="">
                            {{ Form::select(
                                    'diet_id[]',
                                    [
                                    ]+$diet,
                                    '',
                                    [
                                        'class' => 'form-control',
                                        'id'=>'diet',
                                        'multiple'=>'multiple'
                                    ]
                                )
                            }}
                        </div>
                    </div>
                       
                   <!--  <div class="form-group col-md-6">
                        <label class = 'control-label'>Price<span class="required">*</span></label>
                        <div class="input-group">
                            {{ Form::radio(
                                    'price',
                                    '',
                                    [
                                        'class' => ' number-field',
                                        'placeholder' => trans('Price'),
                                        'autocomplete'=>'off'
                                    ]
                                )
                            }}
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ CURRENCY }}</span>
                            </div>
                        </div>
                    </div> -->
                   <!--  <div class="form-group col-md-6">
                        <label class = 'control-label'>Discount<span class="required"></span></label>
                        <div class="input-group">
                            {{ Form::text(
                                    'discount',
                                    '',
                                    [
                                        'class' => 'form-control number-field novalidate',
                                        'placeholder' => trans('Discount'),
                                        'maxlength'=>2,
                                        'autocomplete'=>'off'
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
                                    '',
                                    [
                                        'class' => 'form-control number-field novalidate',
                                        'placeholder' => trans('Quantity'),
                                        'maxlength'=>5,
                                        'autocomplete'=>'off'
                                    ]
                                )
                            }}
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ QTY }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6" style="display: none;">
                        <label class = 'control-label'>Shipping Type<span class="required"></span></label>
                        <div class="">
                            {{ Form::select(
                                    'shipping_type',
                                    [
                                        '' => 'Select Shipping',
                                        'FREE' => 'FREE (Included the price)',
                                        'PAID' => 'PAID (Not included the price)'
                                    ],
                                    '',
                                    [
                                        'class' => 'form-control shippingtype novalidate'
                                    ]
                                )
                            }}
                        </div>
                    </div>
                    <!-- <div class="form-group col-md-6 shippingpaid" style="display: none">
                        <label class = 'control-label'>Shipping Price<span class="required">*</span></label>
                        <div class="input-group">
                            {{ Form::text(
                                    'shipping_price',
                                    '',
                                    [
                                        'class' => 'form-control number-field novalidate shippingprice',
                                        'placeholder' => trans('Shipping Price'),
                                        'maxlength'=> 5
                                    ]
                                )
                            }}
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ CURRENCY }}</span>
                            </div>
                        </div>
                    </div> -->
                 <!--    <div class="form-group col-md-6">
                        <label class = 'control-label'>Reward<span class="required"></span></label>
                        <div class="input-group">
                            {{ Form::text(
                                    'reward',
                                    '',
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
                    <!-- <div class="form-group col-md-12">
                      <label class = 'control-label'>Attributes</label>
                        <div class="check-list">
                          @foreach($attributes as $attribute)
                            <div class="form-group  custom-checkbox-div check-data">
                              <input name="attribute_id[]" value="{{ $attribute->id }}" type="checkbox" id="{{ $attribute->id }}">
                              <label for="{{ $attribute->id }}">{{ $attribute->name }}</label>
                            </div>
                          @endforeach
                        </div>
                    </div> -->
                   
                    <div class="form-group col-md-12">
                        <label class = 'control-label'>Description<span class="required"></span></label>
                        <div class="">
                            {{ Form::textarea(
                                    'description',
                                    '',
                                    [
                                        'class' => 'form-control textarea novalidate',
                                        'id' => 'description',
                                        'autocomplete' => 'off',
                                        'placeholder' => trans('Description')
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
                                    '',
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
                                    'nutrition',
                                    '',
                                    [
                                        'class' => 'form-control textarea novalidate',
                                        'id' => 'nutrition',
                                        'autocomplete' => 'off',
                                        'placeholder' => trans('Nutrition')
                                    ]
                                )
                            }}
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class = 'control-label'>Instruction Image<span class=""></span></label>
                        <div class="">
                            <input type="file" name="instruction_img" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class = 'control-label'>How to store food<span class="required"></span></label>
                        <div class="">
                            {{ Form::textarea(
                                    'details',
                                    '',
                                    [
                                        'class' => 'form-control textarea novalidate',
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
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class = 'control-label'>Image <span class="required">*</span> <span style="color: red">Image must be greater than (1024X680)</span></label>
                        <div class="">
                               <ul id="sortable1" class="connectedSortable" style="list-style: none">
                            <input type="file" id="files"  multiple="">
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
<!-- <script src="{{url('js/jquery.multiselect.js')}}"></script> -->
<!-- <script>
    $('#langOpt').multiselect({
      placeholder: 'Select Languages',
      search: true,
      selectAll: true
  });
</script> -->

    <script type="text/javascript">
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
    $(function () {
        $('#brand').multiselect({
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
</script>
@endsection
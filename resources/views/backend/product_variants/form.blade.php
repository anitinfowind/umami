<?php //echo "<pre>"; print_r($productVariants); die("Ok");?>
<div class="box-body">
    
      <div class="form-group">
        {{ Form::label('Product', trans('Product'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
        <select name="product_id" class="form-control tags box-size"  required="">
          <option value="">Select Product</option>
          @foreach($products as $product)
        <option value="{{$product->id}}" @if(isset($products) && !empty($productVariants->product_id) && $product->id==$productVariants->product_id) selected @endif>{{$product->title}}</option>
          @endforeach
        </select>
        </div><!--col-lg-10-->
    </div>


    <div class="form-group">
        {{ Form::label(
                'variant_name',
                trans('Variant Name'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
            {{ Form::text(
                    'variant_name',
                    null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Name')
                    ]
                )
            }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label(
                'price',
                trans('Price'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
            {{ Form::text(
                    'price',
                    null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Price')
                    ]
                )
            }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label(
                'status',
                trans('validation.attributes.backend.brand.status'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
            <div class="control-group">
                <label class="control control--checkbox">
                    @if(isset($productAttributes->is_active))
                        {{ Form::checkbox('status', 1, $productAttributes->isActive() == ACTIVE ? true :false) }}
                    @else
                        {{ Form::checkbox('is_active', 1, true) }}
                    @endif
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
    </div>
</div>
@section("after-scripts")
    <script type="text/javascript">
        Backend.Blog.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');

    </script>
@endsection
@extends ('backend.layouts.app')

@section ('title', trans('Product view') . ' | ' . trans('Product view'))
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('Product view') }}</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table table-striped table-hover">
            <tr>
                <th>{{ trans('User name') }}</th>
                <td>{{ isset($detail->user->name)?$detail->user->name:'--' }}</td>
            </tr>

            <tr>
                <th>{{ trans('Restarurant name') }}</th>
                <td>{{ $detail->restaurant->name }}</td>
            </tr>

            <tr>
                <th>{{ trans('Category') }}</th>
                <td>{{ $detail->category->name }}</td>
            </tr>

            <tr>
                <th>{{ trans('Brand') }}</th>
                <td>{{ $detail->brand->name }}</td>
            </tr>

            <tr>
                <th>{{ trans('Diet') }}</th>
                <td>{{ $detail->diet->name }}</td>
            </tr>

            <tr>
                <th>{{ trans('Region') }}</th>
                <td>{{ $detail->region->name }}</td>
            </tr>
            <tr>
                <th>{{ trans('Title') }}</th>
                <td>{{ $detail->title }}</td>
            </tr>
             <tr>
                <th>{{ trans('Price') }}</th>
                <td>{{ $detail->price }}</td>
            </tr>
            <tr>
                <th>{{ trans('Discount') }}</th>
                <td>{{isset($detail->discount)?$detail->discount:'--' }}</td>
            </tr>
            <tr>
                <th>{{ trans('Quantity') }}</th>
                <td>{{ isset($detail->quantity)?$detail->quantity:'--' }}</td>
            </tr>
             <tr>
                <th>{{ trans('Shipping Type') }}</th>
                <td>{{ $detail->shipping_type }}</td>
            </tr>
            <tr>
                <th>{{ trans('Shipping Price') }}</th>
                <td>{{ isset($detail->shipping_price)?$detail->shipping_price:'--' }}</td>
            </tr>
            <tr>
                <th>{{ trans('Editor Pick') }}</th>
                <td>
                   @if($detail->editor_pick==1)
                   {{'Yes'}}
                   @else
                   {{'No'}}
                   @endif
               </td>
            </tr>
             <tr>
                <th>{{ trans('Attributes') }}</th>
                <td>
                  <?php
                    $checkattr=[];
                    if (!empty($detail->attribute_id))
                    {
                      $checkattr= explode(',', $detail->attribute_id);
                    } ?>
                  @foreach($productAttrs as $productAtt)
                     @if(in_array($productAtt->id, $checkattr))
                       {{$productAtt->name.','}}
                     @endif
                  @endforeach 
               </td>
            </tr>
             <tr>
                <th width="40%">{{ trans('Description') }}</th>
                <td width="60%">{{$detail->description}}</td>
            </tr>
            <tr>
                <th width="40%">{{ trans('Ingredients') }}</th>
                <td width="60%">{{$detail->ingredients}}</td>
            </tr>
            <tr>
                <th width="40%">{{ trans('Nutrition') }}</th>
                <td width="60%">{{$detail->nutrition}}</td>
            </tr>
            <tr>
                <th width="40%">{{ trans('Details') }}</th>
                <td width="60%">{{$detail->details}}</td>
            </tr>
            
         </table>
          <p>&nbsp;</p>
           <div class="form-group">
              {{ Form::label('Images', trans('Images'), ['class' => 'col-lg-2 control-label']) }}

              <div class="col-lg-10">
                @foreach($detail->productImage as $images)
                  @if(!empty($images->image) &&
                          File::exists(PRODUCT_ROOT_PATH.$images->image))
                      <?php $image = PRODUCT_URL.$images->image; ?>
                  @else
                      <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                  @endif
                  <img class="resto" src="{{ $image }}" alt="{{}}">
                @endforeach
            
              </div><!--col-lg-10-->
          </div><!--form control-->
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection
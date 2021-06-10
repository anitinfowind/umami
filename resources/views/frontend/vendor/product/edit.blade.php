@extends('frontend.layouts.app')

@section('content')
@include('frontend.vendor.sidebar')
<div class="col-md-9">
    <div class="dashboard-container">
        <div class="panel panel-default">
          <div class="panel-heading">{{ trans('Create Product') }}</div>
          <div class="panel-body">

            {{ Form::model($editproduct,['route' => ['frontend.vendor.product.update',$editproduct], 'class' => 'form-horizontal', 'method' => 'PATCH','files'=>'true']) }}
              <div class="form-group">
                {{ Form::label('Product Name', trans('Product Name'), ['class' => 'col-md-4 control-label required']) }}
                <div class="col-md-12">
                    {{ Form::input('text', 'name', null, ['class' => 'form-control', 'placeholder' => trans('Product Name'),'required'=>'required']) }}
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('Product category', trans('Product category'), ['class' => 'col-md-4 control-label required']) }}
                <div class="col-md-12">
                    <select class="form-control" required="" name="category_id[]">
                      <option value="">Select Category</option>
                      @if(count($categorys)>0)
                      @foreach($categorys as $category)
                        <option value="{{$category->id}}" @if(!empty($editproduct->category_id) && $editproduct->category_id==$category->id) selected @endif>{{$category->category_name}}</option>
                      @endforeach
                      @endif
                    </select>
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('Product Brand', trans('Product Brand'), ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-12">
                    <select class="form-control" name="brand_id">
                      <option value="">Select Brand</option>
                      @if(count($brands)>0)
                      @foreach($brands as $brand)
                        <option value="{{$brand->id}}" @if(!empty($editproduct->category_id) && $editproduct->brand_id==$brand->id) selected @endif>{{$brand->brand_name}}</option>
                      @endforeach
                      @endif
                    </select>
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('Description', trans('Description'), ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-12">
                    <textarea name="description" id="content" class="form-control ckeditor">{{isset($editproduct->description)?$editproduct->description:''}}</textarea>
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('Price', trans('Price'), ['class' => 'col-md-4 control-label required']) }}
                <div class="col-md-12">
                    {{ Form::input('text', 'price', null, ['class' => 'form-control', 'placeholder' => trans('Price'),'required'=>'required']) }}
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('sale price', trans('Sale price'), ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-12">
                    {{ Form::input('text', 'sale_price', null, ['class' => 'form-control', 'placeholder' => trans('Sale price')]) }}
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('Quantity', trans('Quantity'), ['class' => 'col-md-4 control-label required']) }}
                <div class="col-md-12">
                    {{ Form::input('text', 'quantity', null, ['class' => 'form-control', 'placeholder' => trans('Quantity'),'required'=>'required']) }}
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('Product Image', trans('Product Image'), ['class' => 'col-md-4 control-label required']) }}
                <div class="col-md-12">
                    {{ Form::input('file', 'image[]', null, ['class' => 'form-control','multiple'=>'multiple']) }}
                      <br>
                  @if(isset($getimage) && !empty($getimage))
                    @foreach($getimage as $producimg)
                    @if(file_exists(public_path().'/product/'.$producimg->image))
                       <img width="60px" src="{{URL::to('product/'.$producimg->image)}}">
                       @else
                     <img width="60px" src="{{URL::to('noimage.png')}}">
                     @endif

                    @endforeach

                  @endif
                </div>
              </div>
               <div class="form-group">
                {{ Form::label('Status', trans('Status'), ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-12">
                     <div class="control-group">
                      <label class="control control--checkbox">
                          @if(isset($editproduct->status))
                              {{ Form::checkbox('status', 1, $editproduct->status == 1 ? true :false) }}
                          @else
                              {{ Form::checkbox('status', 1, true) }}
                          @endif
                          <div class="control__indicator"></div>
                      </label>
                    </div>
                </div>
              </div>
             <div class="form-group">
               <div class="col-md-6 col-md-offset-4">
                 {{ Form::submit(trans('Submit'), ['class' => 'btn order-btn', 'id' => 'update-profile']) }}
              </div>
            </div>
              {{ Form::close() }}
          </div><!--panel body-->
        </div><!-- panel -->
      </div>
    </div>
   </div>
  </div>
 </div>
    <script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
    <script>
 CKEDITOR.replace( 'content', {
  height: 200,
  filebrowserUploadUrl: "upload.php"
 });
</script>
    
@endsection
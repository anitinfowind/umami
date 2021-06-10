@extends('frontend.layouts.app')
@section ('title', trans('Vendor product create'))
@section('content')
 <div class="dashboard-wrap">
    <div class="container">
      <div class="row">
        @include('frontend.user.sidebar')
        <div class="col-md-9">
          <div class="dashboard-container">
                  <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('Create Product') }}</div>
                    <div class="panel-body">
                      {{ Form::open(['url' => 'add-product', 'class' => 'form-horizontal', 'method' => 'POST','files'=>'true']) }}
                        <div class="form-group">
                          {{ Form::label('Product Name', trans('Product Name'), ['class' => 'col-md-4 control-label']) }}
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
                                  <option value="{{$category->id}}">{{$category->name}}</option>
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
                                  <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                                @endif
                              </select>
                          </div>
                        </div>
                        <div class="form-group">
                          {{ Form::label('Description', trans('Description'), ['class' => 'col-md-4 control-label']) }}
                          <div class="col-md-12">
                              <textarea name="description" id="content" class="form-control ckeditor"></textarea>
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
                              {{ Form::input('file', 'image[]', null, ['class' => 'form-control','required'=>'required','multiple'=>'multiple']) }}
                          </div>
                        </div>
                         <div class="form-group">
                          {{ Form::label('Status', trans('Status'), ['class' => 'col-md-4 control-label']) }}
                          <div class="col-md-12">
                              <label class="control control--checkbox"><input checked="checked" name="status" type="checkbox" value="1" id="status"> <div class="control__indicator"></div></label>
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
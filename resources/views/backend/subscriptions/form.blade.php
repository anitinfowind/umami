<div class="box-body">
    <div class="form-group">
         {{ Form::label('name', trans('labels.backend.subscriptions.title'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10"> 
            {{ Form::text('name', isset($subscriptions->title)?$subscriptions->title:'', ['class' => 'form-control box-size', 'placeholder' => trans('labels.backend.subscriptions.title'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form-group-->

    <div class="form-group">
        {{ Form::label('content', trans('validation.attributes.backend.slider.content'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10 mce-box">
            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) }}
        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
         {{ Form::label('price', trans('Price'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10"> 
            {{ Form::text('price', null, ['class' => 'form-control box-size', 'placeholder' => trans('Price'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form-group-->
    <div class="form-group">
         {{ Form::label('discount', trans('Discount'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10"> 
            {{ Form::text('discount', null, ['class' => 'form-control box-size', 'placeholder' => trans('Discount')]) }}
        </div><!--col-lg-10-->
    </div><!--form-group-->
    <div class="form-group">
         {{ Form::label('more detail', trans('More Detail'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10"> 
             {{ Form::textarea('more_detail', null, ['class' => 'form-control','rows'=>3]) }}
        </div><!--col-lg-10-->
    </div><!--form-group-->
     <div class="form-group">
         {{ Form::label('shipping detail', trans('Shipping Detail'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10"> 
             {{ Form::textarea('shipping_detail', null, ['class' => 'form-control','rows'=>3]) }}
        </div><!--col-lg-10-->
    </div><!--form-group-->

     <div class="form-group">
         {{ Form::label('Payment Type', trans('Payment Type'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10"> 
             {{ Form::select('payment_type', [''=>'Select Payment','MONTHLY'=>'Monthly','ANNUALY'=>'Annualy'],'', ['class' => 'form-control','required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form-group-->

      <div class="form-group monthplan" style="display: none;">
         {{ Form::label('Select Months', trans('Select Months'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10"> 
          @foreach(months() as $key=>$month)
             {{ Form::checkbox('month[]',$key, false) }} {{$month}} 
           @endforeach  
        </div><!--col-lg-10-->
    </div><!--form-group-->
     <div class="form-group">
         {{ Form::label('Images', trans('Images'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10"> 
             {{ Form::file('image[]', ['class' => 'form-control','multiple'=>'multiple']) }}
        </div><!--col-lg-10-->
    </div><!--form-group-->
</div><!--box-body-->


@section('after-scripts')
 <script>
   $('select[name=payment_type]').on('change', function() { 
     var name=$(this).val();
     if (name=='MONTHLY') {
         $('.monthplan').show();
       } else {
         $('.monthplan').hide();
       }
  });
 </script>
@endsection
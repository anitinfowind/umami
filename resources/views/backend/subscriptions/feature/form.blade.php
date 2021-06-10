<div class="box-body">
    <div class="form-group">
         {{ Form::label('name', trans('labels.backend.subscriptions.title'), ['class' => 'col-lg-2 control-label required']) }}
        <div class="col-lg-10"> 
            {{ Form::text('title',null, ['class' => 'form-control box-size', 'placeholder' => trans('labels.backend.subscriptions.title'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form-group-->
     <div class="form-group">
         {{ Form::label('Plan name', trans('labels.backend.subscriptions.select_plan'), ['class' => 'col-lg-2 control-label required']) }}
        <div class="col-lg-10"> 
          <select name="subscription_id" class="form-control" required="">
            <option value="">Select Plan</option>
            @foreach($getplan as $plan)
             <option value="{{$plan->id}}" @if(isset($getfeature) && !empty($getfeature) &&$getfeature->subscription_plan_id==$plan->id) selected @endif>{{$plan->title}}</option>
            @endforeach
          </select>
        </div><!--col-lg-10-->
    </div><!--form-group-->

     <div class="form-group">
         {{ Form::label('Price', trans('labels.backend.subscriptions.price'), ['class' => 'col-lg-2 control-label required']) }}
        <div class="col-lg-10"> 
           {{ Form::text('price', null, ['class' => 'form-control box-size', 'placeholder' => trans('labels.backend.subscriptions.price'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form-group-->

     <div class="form-group">
         {{ Form::label('features', trans('labels.backend.subscriptions.features'), ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10"> 
           {{ Form::text('features', null, ['class' => 'form-control box-size', 'placeholder' => trans('labels.backend.subscriptions.features')]) }}
        </div><!--col-lg-10-->
    </div><!--form-group-->
    <div class="form-group">
        {{ Form::label('status', trans('validation.attributes.backend.slider.status'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10">
            <div class="control-group">
                <label class="control control--checkbox">
                    @if(isset($getfeature->status))
                        {{ Form::checkbox('status', 1, $getfeature->status == 1 ? true :false) }}
                    @else
                        {{ Form::checkbox('status', 1, true) }}
                    @endif
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div><!--col-lg-3-->
    </div><!--form control-->
</div><!--box-body-->

@section("after-scripts")
<script type="text/javascript">
        Backend.Blog.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');
        
    </script>
@endsection

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
  <div class="panel-body">
      {{ Form::model($couponedit,[
              'route' => ['frontend.update.coupon',$couponedit->id],
              'class' => 'form-horizontal',
              'id'=>'product',
              'method' => 'get',
              'files'=>'true'
          ])
      }}
          <div class="product_error_div"></div>
          <div class="row">
              <div class="form-group col-md-6">
                  <label class = 'control-label'>Coupon Code<span class="required">*</span></label>
                  <div class="">
                      {{ Form::text(
                              'coupon_code',
                              null,
                              [
                                'class' => 'form-control',
                                'id' => 'coupon_code',
                                'autocomplete' => 'off',
                                'placeholder' => trans('Coupon Code'),
                                'readonly'=>''
                              ]
                          )
                      }}
                  </div>
              </div>
              <div class="form-group col-md-6">
                  <label class = 'control-label'>Discount Type<span class="required">*</span></label>
                  <div class="input-group">
                      {{ Form::select(
                              'discount_type',
                              [''=> 'Select discount type','FIXED'=>'Fixed','PERCENTAGE'=>'Percentage'],null,
                              [
                                'class' => 'form-control discounttype'
                              ]
                          )
                      }}
                  </div>
              </div>
              <div class="form-group col-md-6 discountshow"@if(empty($couponedit->discount)) style="display: none" @endif>
                  <label class = 'control-label'>Discount<span class="required"></span></label>
                  <div class="input-group">
                      {{ Form::text(
                              'discount',
                               null,
                              [
                                  'class' => 'form-control number-field novalidate discountperc',
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
              </div>
              <div class="form-group col-md-6">
                  <label class = 'control-label'>Start Date<span class="required">*</span></label>
                  <div class="input-group">
                      {{ Form::text(
                              'start_date',
                               null,
                              [
                                'class' => 'form-control start_date','placeholder' => trans('Start Date'),
                                'readonly'=>true
                              ]
                          )
                      }}
                  </div>
              </div>
               <div class="form-group col-md-6">
                  <label class = 'control-label'>End Date<span class="required">*</span></label>
                  <div class="input-group">
                      {{ Form::text(
                              'end_date',
                               null,
                              [
                                'class' => 'form-control end_date','placeholder' => trans('End Date'),
                                'readonly'=>true
                              ]
                          )
                      }}
                  </div>
              </div>
               <div class="form-group col-md-6">
                  <label class = 'control-label'>Min price<span class="required">*</span></label>
                  <div class="input-group">
                      {{ Form::text(
                              'min_price',
                              null,
                              [
                                'class' => 'form-control number-field','placeholder'=>'Min Price'
                              ]
                          )
                      }}
                  </div>
              </div>
                 <div class="form-group col-md-12">
                  <label class = 'control-label'>Description<span class="required">*</span></label>
                  <div class="input-group">
                      {{ Form::textarea(
                              'description',
                              null,
                              [
                                'class' => 'form-control textarea','placeholder'=>'description'
                              ]
                          )
                      }}
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-6 col-md-offset-4">
                      <button
                              onclick='formData("product", false, false,"{{url('coupon  ')}}")'
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
@extends('frontend.layouts.app')
@section ('title', trans('User add address'))
@section('content')
<div class="dashboard-wrap">
<div class="container">
  <div class="row">
      @include('frontend.user.sidebar')
      <div class="col-md-9">
          <div class="dashboard-container">
              <div class="panel panel-default">
                  <div class="panel-body">
                      {{ Form::open([
                              'url' => 'add-address',
                              'id' => 'address',
                              'method' => 'POST',
                              ])
                      }}
                          <div class="user_address_error_div"></div>
                          <div class="row">
                              <div class="form-group col-md-6">
                                  <label class = 'control-label'>Country<span class="required">*</span></label>
                                  <div class="">
                                      {{ Form::select(
                                              'country_id',
                                              [
                                                  '' => 'Select Country'
                                              ]+$countries,
                                              '',
                                              [
                                                  'class' => 'form-control',
                                                  'id' => 'country'
                                              ]
                                          )
                                      }}
                                  </div>
                              </div>
                              <div class="form-group col-md-6">
                                  <label class = 'control-label'>State<span class="required">*</span></label>
                                  <div class="state">
                                      {{ Form::select(
                                              'state_id',
                                              [
                                                  '' => trans("Select State")
                                              ],
                                              '',
                                              [
                                                  'class' => 'form-control',
                                                  'id' => 'state'
                                              ])
                                      }}
                                  </div>
                              </div>
                              <div class="form-group col-md-6">
                                  <label class = 'control-label'>City<span class="required">*</span></label>
                                  <div class="city">
                                      {{ Form::select(
                                               'city_id',
                                               [
                                                   '' => trans("Select City")
                                               ],
                                               '',
                                               [
                                                   'class' => 'form-control'
                                               ])
                                       }}
                                  </div>
                              </div>
                              <div class="form-group col-md-6">
                                  <label class = 'control-label'>Address Type<span class="required">*</span></label>
                                  <div class="">
                                      <?php addressType() ?>
                                          {{ Form::select(
                                                  'address_type',
                                                  [
                                                      '' => 'Select Address'
                                                  ]+addressType(),
                                                  '',
                                                  [
                                                      'class' => 'form-control'
                                                  ]
                                              )
                                          }}
                                  </div>
                              </div>
                              <div class="form-group col-md-12">
                                  <label class = 'control-label'>Street Address<span class="required">*</span></label>
                                  <div class="">
                                      {{ Form::textarea(
                                              'street_address',
                                              null,
                                              [
                                                  'class' => 'form-control textarea',
                                                  'id' => 'street_address',
                                                  'rows' => 4,
                                                  'placeholder' => trans('Street Address')
                                              ]
                                          )
                                      }}
                                  </div>
                              </div>
                              <div class="form-group col-md-12">
                                  <label class = 'control-label'>Alternative Address</label>
                                  <div class="">
                                      {{ Form::textarea(
                                              'alternative_address',
                                              null,
                                              [
                                                  'class' => 'form-control textarea novalidate',
                                                  'rows' => 4,
                                                  'placeholder' => trans('Alternative Address')
                                              ]
                                          )
                                      }}
                                  </div>
                              </div>
                              <div class="form-group col-md-6">
                                  <label class = 'control-label'>Landmark<span class="required">*</span></label>
                                  <div class="">
                                      {{ Form::text(
                                              'landmark',
                                              null,
                                              [
                                                  'class' => 'form-control',
                                                  'placeholder' => trans('Landmark')
                                              ]
                                          )
                                      }}
                                  </div>
                              </div>

                              <div class="form-group col-md-6">
                                  <label class = 'control-label'>Pincode<span class="required">*</span></label>
                                  <div class="">
                                      {{ Form::text(
                                              'pincode',
                                              null,
                                              [
                                                  'class' => 'form-control number-field',
                                                  'maxlength' => '10',
                                                  'placeholder' => trans('Pincode')
                                              ]
                                          )
                                      }}
                                  </div>
                              </div>

                              <div class="form-group">
                                  <div class="col-md-6 col-md-offset-4">
                                      <button id="update-profile"
                                              onclick='formData("address", false, false, "{{ url('address') }}")'
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
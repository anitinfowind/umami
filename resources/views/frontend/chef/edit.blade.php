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
                {{ Form::model($editchef,[
                        'route' => ['frontend.update.chefs'],
                        'class' => 'form-horizontal',
                        'id'=>'restaurant',
                        'method' => 'POST',
                        'files'=>'true'
                    ])
                }}
                {{ Form::hidden('id',null) }}
                  <div class="restaurant_error_div"></div>
                    <div class="row">
                      <div class="form-group col-md-6">
                          <label class = 'control-label'>Name<span class="required">*</span></label>
                          <div class="">
                            {{ Form::text(
                                    'name',
                                    null,
                                    [
                                      'class' => 'form-control',
                                      'id' => 'name',
                                      'autocomplete' => 'off',
                                      'placeholder' => trans('Name')
                                  ]
                                )
                            }}
                          </div>
                      </div>
                      <div class="form-group col-md-6">
                          <label class = 'control-label'>Designation<span class="required">*</span></label>
                          <div class="">
                            {{ Form::text(
                                    'designation',
                                    null,
                                    [
                                      'class' => 'form-control',
                                      'id' => 'designation',
                                      'autocomplete' => 'off',
                                      'placeholder' => trans('Designation')
                                    ]
                                )
                            }}
                          </div>
                      </div>
                      
                      <div class="form-group col-md-12">
                          <label class = 'control-label'>Description<span class="required"></span></label>
                          <div class="">
                            {{ Form::textarea(
                                    'description',
                                    null,
                                    [
                                      'class' => 'form-control textarea novalidate',
                                      'autocomplete' => 'off',
                                      'placeholder' => trans('Description')
                                    ]
                                )
                            }}
                          </div>
                      </div>
                      <div class="form-group col-md-12">
                          <label class = 'control-label'>Image<span class="required"></span></label>
                          <div class="">
                              <input type="file" name="image" />
                             <p></p>
                               @if($editchef->image !=='' &&
                                      File::exists(CHEF_ROOT_PATH.$editchef->image))
                                  <?php $image = CHEF_URL.$editchef->image; ?>
                                @else
                                    <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                                @endif
                                 <img class="imageThumb" src="{{ $image }}">
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                            <button onclick='formData("restaurant", false, false, "{{ url('chefs') }}")' type="button" class="btn order-btn" > Submit
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
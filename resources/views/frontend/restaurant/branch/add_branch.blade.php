@extends('frontend.layouts.app')
@section ('title', trans('Restaurant'))
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
                                        <a href="{{ url('branch') }}">
                                            <button type="button" class="btn add-product">
                                                <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                                            </button>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <div class="panel-body">
                                {{ Form::open([
                                        'url' => 'branch/save-branch',
                                        'id' => 'restaurant',
                                        'method' => 'POST',
                                        ])
                                }}
                                    <div class="restaurant_error_div"></div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class = 'control-label cate-label'>Manager Info</label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class = 'control-label'>First Name<span class="required">*</span></label>
                                            <div class="">
                                                {{ Form::text(
                                                        'first_name',
                                                        '',
                                                        [
                                                            'class' => 'form-control',
                                                            'id' => 'first_name',
                                                            'autocomplete' => 'off',
                                                            'placeholder' => trans('First Name')
                                                        ]
                                                    )
                                                }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class = 'control-label'>Last Name<span class="required">*</span></label>
                                            <div class="">
                                                {{ Form::text(
                                                        'last_name',
                                                        '',
                                                        [
                                                            'class' => 'form-control',
                                                            'id' => 'last_name',
                                                            'autocomplete' => 'off',
                                                            'placeholder' => trans('Last Name')
                                                        ]
                                                    )
                                                }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class = 'control-label'>Email<span class="required">*</span></label>
                                            <div class="">
                                                {{ Form::email(
                                                        'email',
                                                        '',
                                                        [
                                                            'class' => 'form-control',
                                                            'id' => 'email',
                                                            'autocomplete' => 'off',
                                                            'placeholder' => trans('Email')
                                                        ]
                                                    )
                                                }}
                                                <span class="email error-msg" style="color:red"></span>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class = 'control-label cate-label'>Branch Info</label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class = 'control-label'>Location<span class="required">*</span></label>
                                            <div class="">
                                                {{ Form::text(
                                                        'location',
                                                        '',
                                                        [
                                                            'class' => 'form-control',
                                                            'id' => 'location',
                                                            'autocomplete' => 'off',
                                                            'placeholder' => trans('Location')
                                                        ]
                                                    )
                                                }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class = 'control-label'>Country<span class="required">*</span></label>
                                            <div class="">
                                                {{ Form::text(
                                                        'country',
                                                        '',
                                                        [
                                                            'class' => 'form-control',
                                                            'id' => 'country',
                                                            'autocomplete' => 'off',
                                                            'readonly' => 'true',
                                                            'placeholder' => trans('Country')
                                                        ]
                                                    )
                                                }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class = 'control-label'>State<span class="required">*</span></label>
                                            <div class="">
                                                {{ Form::text(
                                                        'state',
                                                        '',
                                                        [
                                                            'class' => 'form-control',
                                                            'id' => 'state',
                                                            'autocomplete' => 'off',
                                                            'readonly' => 'true',
                                                            'placeholder' => trans('State')
                                                        ]
                                                    )
                                                }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class = 'control-label'>City<span class="required">*</span></label>
                                            <div class="">
                                                {{ Form::text(
                                                        'city',
                                                        '',
                                                        [
                                                            'class' => 'form-control',
                                                            'id' => 'city',
                                                            'autocomplete' => 'off',
                                                            'readonly' => 'true',
                                                            'placeholder' => trans('City')
                                                        ]
                                                    )
                                                }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class = 'control-label'>Zip Code<span class="required">*</span></label>
                                            <div class="">
                                                {{ Form::text(
                                                        'zip_code',
                                                        '',
                                                        [
                                                            'class' => 'form-control number-field',
                                                            'id' => 'zip_code',
                                                            'maxlength' => 8,
                                                            'autocomplete' => 'off',
                                                            'placeholder' => trans('Zip Code')
                                                        ]
                                                    )
                                                }}
                                            </div>
                                        </div>
                                        {{ Form::hidden('latitude','',['id' => 'latitude']) }}
                                        {{ Form::hidden('longitude','',['id' => 'longitude']) }}

                                        <div class="form-group col-md-6">
                                            <label class = 'control-label'>Phone<span class="required">*</span></label>
                                            <div class="">
                                                {{ Form::text(
                                                        'phone',
                                                        '',
                                                        [
                                                            'class' => 'form-control number-field',
                                                            'id' => 'phone',
                                                            'maxlength' => 10,
                                                            'autocomplete' => 'off',
                                                            'placeholder' => trans('Phone')
                                                        ]
                                                    )
                                                }}
                                                <span class="phone error-msg" style="color:red"></span>
                                            </div>
                                        </div>
                                        {{ Form::hidden('password',substr(uniqid(rand(10,1000),false),rand(0,10),8)) }}
                                        <div class="form-group col-md-12">
                                            <label class = 'control-label'>About Restaurant<span class="required">*</span></label>
                                            <div class="">
                                                {{ Form::textarea(
                                                        'description',
                                                        '',
                                                        [
                                                            'class' => 'form-control textarea',
                                                            'id' => 'description',
                                                            'autocomplete' => 'off',
                                                            'placeholder' => trans('About Restaurant')
                                                        ]
                                                    )
                                                }}
                                            </div>
                                        </div>

                                        @if($categories->isNotEmpty())
                                            <div class="form-group col-md-12">
                                                <label class = 'control-label cate-label'>Category</label>
                                                <div class="check-list">
                                                    @foreach($categories as $category)
                                                        <div class="form-group custom-checkbox-div check-data">
                                                            <input
                                                                    name="category_id[]"
                                                                    value="{{ $category->id }}"
                                                                    type="checkbox"
                                                                    id="{{$category->slug }}"
                                                            >
                                                            <label for="{{ $category->slug }}">{{ $category->name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group col-md-12">
                                            <label class = 'control-label cate-label'>Service type</label>
                                            <div class="check-list">
                                                @foreach(serviceType() as $key => $serviceType)
                                                    <div class="form-group custom-checkbox-div check-data">
                                                        <input
                                                                name="service_type_id[]"
                                                                value="{{ $key }}"
                                                                type="checkbox"
                                                                id="{{$serviceType }}"
                                                        >
                                                        <label for="{{ $serviceType }}">{{ $serviceType }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class = 'control-label cate-label'>Opening</label>
                                            <div class="form-group col-lg-12">
                                                <div class="row">
                                                    <div class="col-md-2 col-sm-3">
                                                        <b>Day</b>
                                                    </div>
                                                    <div class="col-md-1 col-sm-4">
                                                        <b> Open </b>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach(weekDay() as $key => $week)
                                                <div class="col-lg-12">
                                                    <div class="row week-div">
                                                        <div class="col-md-2 col-sm-3">
                                                            <div class="form-group">
                                                                <span>{{ $week }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1 col-sm-2">
                                                            <div class="form-group">
                                                                <div class="form-group custom-checkbox-div check-data">
                                                                    <input
                                                                            name="time[{{$key}}]['day']"
                                                                            type="checkbox"
                                                                            class="open_{{$key}}"
                                                                            id="{{ $week }}"
                                                                            value="{{ $key }}"
                                                                            onclick='showTime("{{ $key }}")'
                                                                    >
                                                                    <label for="{{ $week }}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 time_{{$key}}" style="display: none">
                                                            <div class="form-group">
                                                                <input
                                                                        class="form-control novalidate"
                                                                        id="open_{{$key}}"
                                                                        type="time"
                                                                        name="time[{{$key}}]['open']"
                                                                        placeholder="Open Time"
                                                                        autocomplete="off"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 time_{{$key}}" style="display: none">
                                                            <div class="form-group">
                                                                <input
                                                                        class="form-control novalidate"
                                                                        type="time"
                                                                        id="close_{{$key}}"
                                                                        name="time[{{$key}}]['close']"
                                                                        placeholder="Close Time"
                                                                        autocomplete="off"
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class = 'control-label cate-label'>Images</label>
                                            <input type="file" id="files" />
                                        </div>


                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button id="update-profile"
                                                        onclick='formData("restaurant", false, false, "{{ url('branch') }}")'
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
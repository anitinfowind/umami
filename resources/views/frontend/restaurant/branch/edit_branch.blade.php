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
                                        'url' => 'branch/update-branch',
                                        'id' => 'restaurant',
                                        'method' => 'POST',
                                        ])
                                }}
                                    <div class="restaurant_error_div"></div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class = 'control-label cate-label'>Manager Info</label>
                                            {{ Form::hidden('user_id',$branchDetails->userId()) }}
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class = 'control-label'>First Name<span class="required">*</span></label>
                                            <div class="">
                                                {{ Form::text(
                                                        'first_name',
                                                        $branchDetails->user->firstName(),
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
                                                        $branchDetails->user->lastName(),
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
                                                        $branchDetails->user->email(),
                                                        [
                                                            'class' => 'form-control',
                                                            'id' => 'email',
                                                            'autocomplete' => 'off',
                                                            'readonly' => true,
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
                                                        $branchDetails->restaurantLocation->location(),
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
                                                        $branchDetails->restaurantLocation->country(),
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
                                                        $branchDetails->restaurantLocation->state(),
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
                                                        $branchDetails->restaurantLocation->city(),
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
                                                        $branchDetails->restaurantLocation->zipCode(),
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
                                        {{ Form::hidden('latitude',$branchDetails->restaurantLocation->latitude(),['id' => 'latitude']) }}
                                        {{ Form::hidden('longitude',$branchDetails->restaurantLocation->longitude(),['id' => 'longitude']) }}

                                        <div class="form-group col-md-6">
                                            <label class = 'control-label'>Phone<span class="required">*</span></label>
                                            <div class="">
                                                {{ Form::text(
                                                        'phone',
                                                        $branchDetails->phone(),
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
                                        <div class="form-group col-md-12">
                                            <label class = 'control-label'>About Restaurant<span class="required">*</span></label>
                                            <div class="">
                                                {{ Form::textarea(
                                                        'description',
                                                        $branchDetails->description(),
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
                                                            @if(!empty($restaurantCategory) && in_array($category->id, $restaurantCategory))
                                                                <input
                                                                        name="category_id[]"
                                                                        value="{{ $category->id }}"
                                                                        type="checkbox"
                                                                        id="{{ $category->slug }}"
                                                                        checked
                                                                >
                                                                <label for="{{ $category->slug }}">{{ $category->name }}</label>
                                                            @else
                                                                <input
                                                                        name="category_id[]"
                                                                        value="{{ $category->id }}"
                                                                        type="checkbox"
                                                                        id="{{$category->slug }}"
                                                                >
                                                                <label for="{{ $category->slug }}">{{ $category->name }}</label>
                                                            @endif
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
                                                        @if(!empty($restaurantServiceType) && in_array($key, $restaurantServiceType))
                                                            <input
                                                                    name="service_type_id[]"
                                                                    value="{{ $key }}"
                                                                    type="checkbox"
                                                                    id="{{ $serviceType }}"
                                                                    checked
                                                            >
                                                            <label for="{{ $serviceType }}">{{ $serviceType }}</label>
                                                        @else
                                                            <input
                                                                    name="service_type_id[]"
                                                                    value="{{ $key }}"
                                                                    type="checkbox"
                                                                    id="{{$serviceType }}"
                                                            >
                                                            <label for="{{ $serviceType }}">{{ $serviceType }}</label>
                                                        @endif
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
                                                    <?php
                                                    if ($branchDetails) {
                                                        $restaurantsId = $branchDetails->restaurantId();
                                                    } else {
                                                        $restaurantsId = '';
                                                    }
                                                    $restaurantOpen = restaurantOpen($branchDetails->userId(), $restaurantsId, $key);
                                                    ?>

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
                                                                            @if(isset($restaurantOpen->day) && $restaurantOpen->day == $key)
                                                                            checked
                                                                            @endif
                                                                            onclick='showTime("{{ $key }}")'
                                                                    >
                                                                    <label for="{{ $week }}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(isset($restaurantOpen->day) && $restaurantOpen->day == $key)
                                                            <?php $display = 'block'; ?>
                                                        @else
                                                            <?php $display = 'none'; ?>
                                                        @endif
                                                        <div class="col-md-3 col-sm-3 time_{{$key}}" style="display: {{ $display }}">
                                                            <div class="form-group">
                                                                <input
                                                                        class="form-control novalidate"
                                                                        id="open_{{$key}}"
                                                                        type="time"
                                                                        name="time[{{$key}}]['open']"
                                                                        placeholder="Open Time"
                                                                        value="{{ isset($restaurantOpen->open) ? $restaurantOpen->open : '' }}"
                                                                        autocomplete="off"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 time_{{$key}}" style="display: {{ $display }}">
                                                            <div class="form-group">
                                                                <input
                                                                        class="form-control novalidate"
                                                                        type="time"
                                                                        id="close_{{$key}}"
                                                                        name="time[{{$key}}]['close']"
                                                                        placeholder="Close Time"
                                                                        value="{{ isset($restaurantOpen->close) ? $restaurantOpen->close : '' }}"
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
                                            @if(($branchDetails) && $branchDetails->restaurantImage->isNotEmpty())
                                                @foreach($branchDetails->restaurantImage as $restaurantImage)
                                                <?php
                                                 $info = pathinfo((RESTAURANT_ROOT_PATH.$restaurantImage->image()));
                                                   $ext = $info['extension'];
                                                  ?>
                                                  @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
                                                    @if($restaurantImage->image() !=='' && File::exists(RESTAURANT_ROOT_PATH.$restaurantImage->image()))
                                                        <?php $image = RESTAURANT_URL.$restaurantImage->image(); ?>
                                                    @else
                                                        <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                                                    @endif
                                                    <span class="pip" id="image_{{ $restaurantImage->id }}">
                                                        <img class="imageThumb" src="{{ $image }}">
                                                        <span class="remove" onclick="removeImage({{ $restaurantImage->id }})">Remove</span>
                                                    </span>
                                                    @else
                                                    <span class="pip" id="image_{{ $restaurantImage->id }}">
                                                     <?php $video = RESTAURANT_URL.$restaurantImage->image(); ?>
                                                        <video width="120" height="100" controls>
                                                          <source src="{{ $video}}" type="video/mp4">
                                                        </video>
                                                        <span class="remove" onclick="removeImage({{ $restaurantImage->id }})">Remove</span>
                                                    </span>
                                                    @endif

                                                @endforeach
                                            @endif
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
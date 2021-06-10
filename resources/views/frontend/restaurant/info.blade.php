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
<div class="panel-body">
{{ Form::open([
    'url' => 'restaurant/save-restaurant',
    'id' => 'restaurant',
    'method' => 'POST',
    'files'=>'true'
    ])
}}
<div class="restaurant_error_div"></div>
<div class="row">
    <div class="form-group col-md-6">
        <label class = 'control-label'>Restaurant Name<span class="required">*</span></label>
        <div class="">
            {{ Form::text(
                    'name',
                    ($restaurants) ? $restaurants->name() : '',
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
        <label class = 'control-label'>Location<span class="required">*</span></label>
        <div class="">
            {{ Form::text(
                    'location',
                    isset($restaurants->restaurantLocation->location) ? $restaurants->restaurantLocation->location: '',
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
          <select name="country" class="form-control" id="rescountry">
            <option value=""> Select Country</option>
            @foreach($countriedata as $cdata)
            <option value="{{$cdata->name}}" @if(isset($restaurants->restaurantLocation->country) && !empty($restaurants->restaurantLocation->country) && $restaurants->restaurantLocation->country==$cdata->name) selected="selected" @endif>{{$cdata->name}}</option>
            @endforeach
          </select>
        </div>
    </div>
    <div class="form-group col-md-6">
        <label class = 'control-label'>State<span class="required">*</span></label>
        <div class="state">
           <select name="state" class="form-control" id="resstate">
            <option value=""> Select State</option>
            @foreach($states as $sdata)
            <option value="{{$sdata->name}}" @if(isset($restaurants->restaurantLocation->state) && !empty($restaurants->restaurantLocation->state) && $restaurants->restaurantLocation->state==$sdata->name) selected="selected" @endif>{{$sdata->name}}</option>
            @endforeach
          </select>
        </div>
    </div>
    <div class="form-group col-md-6">
        <label class = 'control-label'>City<span class="required">*</span></label>
        <div class="city">
          <select name="city" class="form-control" id="resstate">
            <option value=""> Select City</option>
            @foreach($cities as $citydata)
            <option value="{{$citydata->name}}" @if(isset($restaurants->restaurantLocation->city) && !empty($restaurants->restaurantLocation->city) && $restaurants->restaurantLocation->city==$citydata->name) selected @endif>{{$citydata->name}}</option>
            @endforeach
          </select>
        </div>
    </div>
    <div class="form-group col-md-6">
        <label class = 'control-label'>Zip Code<span class="required">*</span></label>
        <div class="">
            {{ Form::text(
                    'zip_code',
                    isset($restaurants->restaurantLocation->zip_code) ? $restaurants->restaurantLocation->zip_code: '',
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
    {{ Form::hidden('id',($restaurants) ? $restaurants->id() : '') }}
    {{ Form::hidden('slug',isset($restaurants->slug) ? $restaurants->slug: '') }}
    {{ Form::hidden(
            'latitude',
            isset($restaurants->restaurantLocation->latitude) ? $restaurants->restaurantLocation->latitude: '',
            [
                'id' => 'latitude'
            ]
        )
    }}
    {{ Form::hidden(
            'longitude',
            isset($restaurants->restaurantLocation->longitude) ? $restaurants->restaurantLocation->longitude: '',
            [
                'id' => 'longitude'
            ]
        )
    }}

    <div class="form-group col-md-6">
        <label class = 'control-label'>Phone<span class="required">*</span></label>
        <div class="">
            {{ Form::text(
                    'phone',
                    isset($restaurants->restaurantBranch->phone) ? $restaurants->restaurantBranch->phone: '',
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

    <div class="form-group col-md-6">
        <label class = 'control-label'>UPS Account Number</label>
        <div class="">
            {{ Form::text(
                    'ups_account_no',
                    isset($restaurants->ups_account_no) ? $restaurants->ups_account_no: '',
                    [
                        'class' => 'form-control novalidate',
                        'id' => 'ups_account_no',
                        'maxlength' => 10,
                        'autocomplete' => 'off',
                        'placeholder' => trans('UPS Account Number')
                    ]
                )
            }}
            <!-- <span class="phone error-msg" style="color:red"></span> -->
        </div>
    </div>

    <div class="form-group col-md-12">
        <label class = 'control-label'>About Restaurant<span class="required">*</span></label>
        <div class="">
            {{ Form::textarea(
                    'description',
                    isset($restaurants->restaurantBranch->description) ? strip_tags($restaurants->restaurantBranch->description) : '',
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
        <label class = 'control-label cate-label'>Background Images</label>
        <input type="file" name="backimage"/>
        @if(isset($restaurants->restaurantBranch->background_image) &&!empty($restaurants->restaurantBranch->background_image))
            <?php
            $info = pathinfo(RESTAURANT_ROOT_PATH.$restaurants->restaurantBranch->background_image);
               $ext = $info['extension'];
              ?>
              @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
                @if($restaurants->restaurantBranch->background_image !=='' && File::exists(RESTAURANT_ROOT_PATH.$restaurants->restaurantBranch->background_image))
                    <?php $image = RESTAURANT_URL.$restaurants->restaurantBranch->background_image; ?>
                     <input type="hidden" name="oldimage" value="{{isset($restaurants->restaurantBranch->background_image)?$restaurants->restaurantBranch->background_image:''}}">
                @else
                    <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                @endif
                <span class="pip" id="image_{{ $restaurants->restaurantBranch->id }}">
                    <img class="imageThumb" src="{{ $image }}">
                    <span class="remove" onclick="backgroundImage({{$restaurants->restaurantBranch->id }})">Remove</span>
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
        @endif
    </div>
    <div class="form-group col-md-12">
        <label class = 'control-label cate-label'>Images</label>
        <ul id="sortable1" class="connectedSortable" style="list-style: none">
        <input type="file" id="files" multiple />
        @if(($restaurants) && $restaurants->restaurantImage->isNotEmpty())
            @foreach($restaurants->restaurantImage as $key => $restaurantImage)
            <?php
            $info = pathinfo(RESTAURANT_ROOT_PATH.$restaurantImage->image());
               $ext = $info['extension'];
              ?>
              @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
                @if($restaurantImage->image() !=='' && File::exists(RESTAURANT_ROOT_PATH.$restaurantImage->image()))
                    <?php $image = RESTAURANT_URL.$restaurantImage->image(); ?>
                @else
                    <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                @endif
                <?php if($key==0){$newclass='static';}else{$newclass='';} ?>
                
                <span class="pip <?=$newclass?>" id="image_{{ $restaurantImage->id }}">
                    <input type="hidden" name="restaurant_image_id[]" value="{{$restaurantImage->id}}">
                     <input type="hidden" name="restaurant_image_url[]" value="{{$restaurantImage->image}}">

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
    </ul>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button id="update-profile"
                    onclick='formData("restaurant", false, false, "{{ url('restaurant/info') }}")'
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
@section('after-script')
<script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"
    type="text/javascript"></script>
    <link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"
    rel="stylesheet" type="text/css" />
<script type="text/javascript">
        $( "#sortable1").sortable({
           // items: '.pip:not(:first)',
            connectWith: ".connectedSortable",
           
            stop: function(event, ui) {
               /* alert("New position: " + ui.item.index());*/
                $('.connectedSortable').each(function() {
                    result = "";
                   // alert($(this).sortable("toArray"));
                    $(this).find("li").each(function(){
                        result += $(this).text() + ",";
                    });
                });
            }
        });
</script>
@endsection
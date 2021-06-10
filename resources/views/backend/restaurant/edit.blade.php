@extends ('backend.layouts.app')

@section ('title', trans('Restaurant view') . ' | ' . trans('Restaurant view'))
@section('content')
   <div class="panel-body">

 {{ Form::model($restaurants, ['route' => ['admin.restaurant.update', $restaurants->user_id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'update-product','files' => true,]) }}
<div class="restaurant_error_div"></div>
<div class="row">
    <div class="form-group col-md-6">
        <label class = 'control-label'>Restaurant Name<span class="required"></span></label>
        <input type="hidden" name="restaurant_id" value="{{$restaurants->id}}">
        <input type="hidden" name="is_rating_show" id="is_rating_show" value="{{$restaurants->is_rating_show}}">
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
        <label class = 'control-label'>Location<span class="required"></span></label>
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
        <label class = 'control-label'>Country<span class="required"></span></label>
        <div class="">
          <select name="country" class="form-control" id="country">
            <option value="">{{trans('Country')}}</option>
            @foreach($countriedata as $cdata)
            <option value="{{$cdata->name}}" @if(isset($restaurants->restaurantLocation->country) && !empty($restaurants->restaurantLocation->country) && $restaurants->restaurantLocation->country==$cdata->name) selected="selected" @endif>{{$cdata->name}}</option>
            @endforeach
          </select>
        </div>
    </div>
    <div class="form-group col-md-6">
        <label class = 'control-label'>State<span class="required"></span></label>
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
        <label class = 'control-label'>City<span class="required"></span></label>
        <div class="city">
          <select name="city" class="form-control">
            <option value=""> Select City</option>
            @foreach($cities as $citydata)
            <option value="{{$citydata->name}}" @if(isset($restaurants->restaurantLocation->city) && !empty($restaurants->restaurantLocation->city) && $restaurants->restaurantLocation->city==$citydata->name) selected @endif>{{$citydata->name}}</option>
            @endforeach
          </select>
     
        </div>
    </div>
    <div class="form-group col-md-6">
        <label class = 'control-label'>Zip Code<span class="required"></span></label>
        <div class="">
            {{ Form::text(
                    'zip_code',
                    isset($restaurants->restaurantLocation->zip_code) ? $restaurants->restaurantLocation->zip_code : '',
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
    {{ Form::hidden('slug',($restaurants) ? $restaurants->slug() : '') }}
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
            isset($restaurants->restaurantLocation->longitude) ? $restaurants->restaurantLocation->longitude:'',
            [
                'id' => 'longitude'
            ]
        )
    }}

    <div class="form-group col-md-6">
        <label class = 'control-label'>Phone<span class="required"></span></label>
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
    <div class="form-group col-md-6" style="display: none;">
        <label class = 'control-label'>Preparation Days<span class="required"></span></label>
        <div class="">
            {{ Form::select(
                    'preparation_day',
                    [
                        '' => 'Select Preparation Days',
                        '1' => '1 Day',
                        '2' => '2 Day',
                        '3' => '3 Day',
                        'above' => 'Above 3 Day'
                    ],
                     isset($restaurants->restaurantBranch->preparation_day) ? $restaurants->restaurantBranch->preparation_day : '',
                    [
                        'class' => 'form-control',
                        'id' => 'preparation_days'
                    ]
                )
            }}
            <span class="preparation_days error-msg" style="color:red"></span>
        </div>
    </div> 
    <div class="form-group col-md-6" style="display: none;">
            <label class = 'control-label'>Delivery Days<span class="required"></span></label>
            <div class="">
                {{ Form::select(
                        'delivery_day',
                        [
                            '' => 'Select Delivery Days',
                            '1' => '1 Day',
                            '2' => '2 Day',
                            '3' => '3 Day'
                        ],
                       isset($restaurants->restaurantBranch->delivery_day) ? $restaurants->restaurantBranch->delivery_day : '',
                        [
                            'class' => 'form-control',
                            'id' => 'delivery_days'
                        ]
                    )
                }}
                <span class="delivery_days error-msg" style="color:red"></span>
            </div>
        </div>

     <div class="form-group col-md-6">
        <label class = 'control-label'>Order Time<span class="required"></span></label>
        <div class="">
            {{ Form::select(
                    'order_time',
                    [
                        '' => 'Select Order Time',
                        '1' => '1 AM',
                        '2' => '2 AM',
                        '3' => '3 AM',
                        '4' => '4 AM',
                        '5' => '5 AM',
                        '6' => '6 AM',
                        '7' => '7 AM',
                        '8' => '8 AM',
                        '9' => '9 AM',
                        '10' => '10 AM',
                        '11' => '11 AM',
                        '12' => '12 AM',
                        '13' => '1 PM',
                        '14' => '2 PM',
                        '15' => '3 PM',
                        '16' => '4 PM',
                        '17' => '5 PM',
                        '17' => '6 PM',
                        '19' => '7 PM',
                        '20' => '8 PM',
                        '21' => '9 PM',
                        '22' => '10 PM',
                        '23' => '11 PM',
                        '24' => '12 PM',
                       
                    ],
                    isset($restaurants->restaurantBranch->order_time) ? $restaurants->restaurantBranch->order_time : '',
                    [
                        'class' => 'form-control',
                        'id' => 'order_time'
                    ]
                )
            }}
            <span class="order_time error-msg" style="color:red"></span>
        </div>
    </div>
    <div class="form-group col-md-12">
        <label class = 'control-label'>About Restaurant<span class="required"></span></label>
        <div class="">
            {{ Form::textarea(
                    'description',
                    isset($restaurants->restaurantBranch->description)?$restaurants->restaurantBranch->description : '',
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
    <div class="form-group">
        {{ Form::label('Show/Hide Home Page ', trans('how/Hide Home Page'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10 mce-box">
         {{ Form::select(
                'is_home_show',
                [
                    '' => 'Select',
                    'active' => 'Show',
                    'inactive' => 'Hide'
                ],
                null,
                [
                    'class' => 'form-control is_home_show tags box-size'
                ]
            )
        }}
        </div><!--col-lg-10-->
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

    <div class="form-group col-md-6">
        <label class="control-label">UPS Account No</label>
        <div class="">
            <input class="form-control" autocomplete="off" placeholder="UPS Account No" name="ups_account_no" type="text" value="{{ $restaurants->ups_account_no }}" />
        </div>
    </div>

    <div class="clearfix"></div>

    <?php
    $shipping_info = $restaurants->shipping_info;
    if($shipping_info == '') $shipping_info = '{}';
    $shipping_info = json_decode($shipping_info, true);
    ?>
    <div class="row1111">
        <div class="form-group col-md-6">
            <label class="control-label">Preparation Days</label>
            <div class="">
                <input class="form-control" autocomplete="off" placeholder="Preparation Days" name="preparation_time" type="text" value="{{ $shipping_info['preparation_time'] ?? '' }}" />
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class="control-label">Delivery Days</label>
            <div class="">
                <input class="form-control" autocomplete="off" placeholder="Delivery Days" name="delivery_days" type="text" value="{{ $shipping_info['delivery_days'] ?? '' }}" />
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row1111">
      <div class="col-md-12----">
        <div class="table-responsive111111">
          <table class="table table-striped">
            <tbody>
              <tr>
                <th style="width: 40px"></th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
              </tr>
            <?php
            $weekdays = [['title' => 'Monday'], ['title' => 'Tuesday'], ['title' => 'Wednesday'], ['title' => 'Thursday'], ['title' => 'Friday'], ['title' => 'Saturday'], ['title' => 'Sunday']];
            foreach ($weekdays as $key => $value) {
              $f = ($shipping_info['pickuptime'][$key] ?? []);
              $chk = '';
              if(isset($f['enabled']) && $f['enabled'] == 1)
                $chk = 'checked="checked"';
              echo '<tr class="pickuptime_row">
              <td><input type="checkbox" class="minimal" name="pickuptime[' . $key . '][enabled]" value="1" ' . $chk . '></td>
              <td>' . $weekdays[$key]['title'] . '</td>
              <td><div class="bootstrap-timepicker"><input type="text" class="form-control timepicker" placeholder="Start Time" name="pickuptime[' . $key . '][start_time]" value="' . ($f['start_time'] ?? '00:00') . '" readonly /></div></td>
              <td><div class="bootstrap-timepicker"><input type="text" class="form-control timepicker" placeholder="End Time" name="pickuptime[' . $key . '][end_time]" value="' . ($f['end_time'] ?? '00:00') . '" readonly /></div></td>
              </tr>';
            }
            ?>
          </tbody>
        </table>
        </div>
      </div>
    </div>
    @if($restaurants->is_rating_show=='Y')
    @if($total_user>0)
    <div class="row1111" id="rating_del_btn_section">
      <div class="col-md-12">
        <div class="table-responsive111111">
          <table class="table table-striped">
            <tbody>
              <tr>
                <th>Total User</th>
                <th>Rating</th>
                <th>Action</th>
              </tr>
              <tr>
                <td align="left">{{$total_user}}</td>
                <td align="left">{{$total_user_rating}}</td>
                <td align="left"><a href="javascript:;" class="btn btn-success btn-sm" id="rating_del_btn"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    @endif
    @endif

      <div class="form-group col-md-12" style="display: none;">
        <label class = 'control-label cate-label'>Picking Hours</label>
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
                    if ($restaurants) {
                        $restaurantsId = $restaurants->id();
                    } else {
                        $restaurantsId = '';
                    }
                    $restaurantOpen = restaurantOpen($restaurants->user_id, $restaurantsId, $key);
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
    

      <div class="form-group">
          {{ Form::label('Video', trans('Background Image'), ['class' => 'col-lg-2 control-label']) }}
       
        <div class="form-group col-lg-10">
              <input type="file" name="backimage">
               @if(isset($restaurants->restaurantBranch->background_image) && !empty($restaurants->restaurantBranch->background_image))
               <?php
               $info = pathinfo(RESTAURANT_ROOT_PATH.$restaurants->restaurantBranch->background_image);
               $ext = $info['extension'];              ?>
              <div class="col-md-3">
               @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
                @if($restaurants->restaurantBranch->background_image !=='' && File::exists(RESTAURANT_ROOT_PATH.$restaurants->restaurantBranch->background_image))
                    <?php $image = RESTAURANT_URL.$restaurants->restaurantBranch->background_image; ?>
                     <input type="hidden" name="oldimage" value="{{isset($restaurants->restaurantBranch->background_image)?$restaurants->restaurantBranch->background_image:''}}">
                @else
                    <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                @endif
                 
                <li class="image_{{ $restaurants->restaurantBranch->id }}">
                <span class="pip">
                    <img style="padding: 5px" class="imageThumb" width="100%" height="125px" src="{{ $image }}">
                    <span class="remove" onclick="RestaurantRemoveBackImageAdmin({{ $restaurants->restaurantBranch->id }})">Remove
                    </span>
                  </span>
                </li>
                @endif
              </div>
              @endif
        </div>
      </div>

         <div class="form-group">
        {{ Form::label('Video', trans('Images'), ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
          <input type="file" name="restaurantmage[]" multiple="" class="form-control box-size">
          <br>
          @if(isset($products) && !empty($products))
            @if(!empty($products->video) && file_exists(public_path().'/uploads/product/'.$products->video))
               <video width="100%" height="240" controls>
                <source src="{{URL::to('uploads/product/'.$products->video)}}" type="video/mp4">
              </video>
             @endif
          @endif
        </div>
    </div>
        <br/>
        <div class="form-group">
        <div class="demo">
      <ul id="sortable1" class="connectedSortable" style="list-style: none">
        @if(($restaurants) && $restaurants->restaurantImage->isNotEmpty())
            @foreach($restaurants->restaurantImage as $key => $restaurantImage)
            <?php
            $info = pathinfo(RESTAURANT_ROOT_PATH.$restaurantImage->image());
               $ext = $info['extension'];
              ?>
              <!-- <div class="col-md-3"> -->
              @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
                @if($restaurantImage->image() !=='' && File::exists(RESTAURANT_ROOT_PATH.$restaurantImage->image()))
                    <?php $image = RESTAURANT_URL.$restaurantImage->image(); ?>
                @else
                    <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                @endif
                 
                <!-- <li class="image_{{ $restaurantImage->id }}">
                <span class="pip">
                    <img style="padding: 5px" class="imageThumb" width="100%" height="125px" src="{{ $image }}">
                    <span class="remove" onclick="RestaurantRemoveImageAdmin({{ $restaurantImage->id }})">Remove
                    </span>
                </span>
              </li> -->
              <li id="item{{$key+1}}" data-id="{{$restaurantImage->id}}" class=" image_{{ $restaurantImage->id }}">
                  <span class="pip" id="image_{{ $restaurantImage->id }}">
                  <img  width="100%" style="padding: 5px" height="125px" class="imageThumb" src="{{$image}}">
                <span class="remove" onclick="RestaurantRemoveImageAdmin({{ $restaurantImage->id }})">Remove
                </span></span>
              <input type="hidden" name="restaurant_image_url[]" value="{{$restaurantImage->image()}}">
              </li>

              @else

              <?php $video = RESTAURANT_URL.$restaurantImage->image(); ?>
              <li id="item{{$key+1}}" data-id="{{$restaurantImage->id}}" class=" image_{{ $restaurantImage->id }}">
                 <span class="pip" id="image_{{ $restaurantImage->id }}">
                  <video width="150px" height="100px" controls>
                      <source src="{{ $video }}" type="video/mp4">
                  </video>
                 <span class="remove" onclick="RestaurantRemoveImageAdmin({{ $restaurantImage->id }})">Remove
                    </span></span>
                  <input type="hidden" name="restaurant_image_url[]" value="{{$restaurantImage->image()}}">
                </li>
              @endif  
               <!-- </div> -->
            @endforeach
        @endif
  </ul>
</div></div>
  <p>&nbsp;</p>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button id="update-profile"
                    type="submit"
                    class="btn order-btn btn-primary" 
            >
                Update
            </button>
        </div>
    </div>
</div>
{{ Form::close() }}
</div>

@endsection

<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->



@section('after-scripts')


<script>
$(document).on('click','#rating_del_btn',function(){
    var r = confirm("Are you sure to delete this restaurant rating?");
    if (r == true) {
        $('#is_rating_show').val('N');
        $('#rating_del_btn_section').hide();
    }
});
  
  $(document).on('change','#country',function(){
    var countryId = $('#country').val();
    if (countryId !== '') {
      city();
      $.ajax({
        method: "GET",
        url: "{{ url('restaurant/restaurant-state') }}",
        data: {'country_id': countryId},
        success: function (data) {
          $('.state').html(data);
        },
        complete: function () {
          $('#resstate').change(function () {
            var stateId = $('#resstate').val();
            $.ajax({
              method: "GET",
              url: "{{ url('restaurant/restaurant-city') }}",
              data: {'state_id': stateId},
              success: function (data) {
                $('.city').html(data);
              },
            });
          });
        },
      });
    } else {
      state();
      city();
    }
  });
 $(document).on('change','#resstate',function(){
    var stateId = $('#resstate').val();
    if (stateId !== '') {
      $.ajax({
        method: "GET",
        url: "{{ url('restaurant/restaurant-city') }}",
        data: {'state_id': stateId},
        success: function (data) {
          $('.city').html(data);
        },
      });
    } else {
      city();
    }
  });

  function city()
  {
    $('.city').html('<select class="form-control" name="city"><option value="">Select City</option></select>');
  }

  function state()
  {
    $('.state').html('<select class="form-control" name="state"><option value="">Select State</option></select>');
  }

  function showTime(key)
{
    if ($('.open_'+key).is(":checked")) {
        $('.time_'+key).css({'display' : 'block'});
        $('#open_'+key).removeClass('novalidate');
        $('#close_'+key).removeClass('novalidate');
    } else {
        $('.time_'+key).css({'display' : 'none'});
        $('#open_'+key).addClass('novalidate');
        $('#close_'+key).addClass('novalidate');
        $('#open_'+key).val('');
        $('#close_'+key).val('');
    }
}

     function RestaurantRemoveImageAdmin(imageId)
     {
      $.ajax({
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('admin/restaurant/remove-image') }}",
        type: 'post',
        data: { 'image_id' : imageId },
        beforeSend: function() {
          $("#overlay").show();
        },
        success:function(data) {
          $('.image_'+imageId).hide();
          $("#overlay").hide();
        }
      });
    }

    function RestaurantRemoveBackImageAdmin(imageId)
     {
      $.ajax({
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('admin/restaurant/remove-backgroundimage') }}",
        type: 'post',
        data: { 'image_id' : imageId },
        beforeSend: function() {
          $("#overlay").show();
        },
        success:function(data) {
          $('.image_'+imageId).hide();
          $("#overlay").hide();
        }
      });
    }
    
    </script>
<style type="text/css">
  /*.remove {
    display: block;
    background: #444;
    border: 1px solid black;
    color: white;
    text-align: center;
    cursor: pointer;
}*/
</style>


<link rel="stylesheet" href="{{ URL::asset('/public/latest/plugins/timepicker/bootstrap-timepicker.min.css') }}">
<script src="{{ URL::asset('/public/latest/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script type="text/javascript">
    $( "#sortable1").sortable({
        //items: 'li:not(:first)',
    connectWith: ".connectedSortable",
    stop: function(event, ui) {
        $('.connectedSortable').each(function() {
            result = "";
           // alert($(this).sortable("toArray"));
            $(this).find("li").each(function(){
                result += $(this).text() + ",";
            });
          //  $("."+$(this).attr("id")+".list").html(result);
        });
    }
});
</script>

<script type="text/javascript">
  $(document).ready(function(){

    $('.timepicker').each(function(){
      $(this).timepicker({
        showInputs: false,
        showMeridian: false,
        defaultTime: false
      });
    });

  });
</script>

<style type="text/css">
  .remove {
    display: block;
    background: #444;
    border: 1px solid black;
    color: white;
    text-align: center;
    cursor: pointer;
}
span.pip {
    display: inline-block;
}
img.imageThumb {
    width: 120px;
    height: 100px;
}
li #item1 {
    display: inline-block;
}
.connectedSortable li {
    display: inline-block;
}
</style>

@endsection
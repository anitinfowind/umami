<div class="box-body">
    <div class="form-group">
        {{ Form::label('Restaurant', trans('User Name'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
        <select name="user_id" class="form-control tags box-size"  required="">
          <option value="">Select User Name</option>
          @foreach($vendorname as $vendor)
           <option value="{{$vendor->id}}">{{$vendor->first_name}}</option>
          @endforeach
        </select>
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('Product name', trans('Restaurant Name'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('Restaurant Name'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('Price', trans('Location'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('location', null, ['class' => 'form-control box-size', 'placeholder' => trans('Location'), 'required' => 'required']) }}
        </div>
    </div><!--form control--> 
      <div class="form-group">
        {{ Form::label('Country', trans('Country'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
           <select name="country" class="form-control box-size" id="country">
            <option value="">{{trans('Country')}}</option>
            @foreach($countriedata as $cdata)
            <option value="{{$cdata->name}}" @if(isset($restaurants->restaurantLocation->country) && !empty($restaurants->restaurantLocation->country) && $restaurants->restaurantLocation->country==$cdata->name) selected="selected" @endif>{{$cdata->name}}</option>
            @endforeach
          </select>
        </div>
    </div>
     <div class="form-group">
        {{ Form::label('State', trans('State'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            <div class="state">
               <select name="state" class="form-control box-size" id="resstate">
                <option value="">{{trans('Select State')}}</option>
              </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('city', trans('City'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10">
            <div class="city">
             <select name="city" class="form-control box-size">
              <option value="">{{trans('Select City')}}</option>
           
            </select>
          </div>
        </div>
    </div>


    <div class="form-group">
        {{ Form::label('Zip Code', trans('Zip Code'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('zip_code', null, ['class' => 'form-control box-size', 'placeholder' => trans('Zip Code'),'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

   <div class="form-group">
        {{ Form::label('Phone', trans('Phone'), ['class' => 'col-lg-2 control-label required']) }}
        <div class="col-lg-10 mce-box">
          {{ Form::text('phone', null, ['class' => 'form-control box-size', 'placeholder' => trans('Phone'),'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('Preparation Days', trans('Preparation Days'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10 mce-box">
          {{ Form::select(
                    'preparation_day',
                    [
                        '' => 'Select Preparation Days',
                        '1' => '1 Day',
                        '2' => '2 Day',
                        '3' => '3 Day',
                        'above' => 'Above 3 Day'
                    ],
                     '',
                    [
                        'class' => 'form-control box-size',
                        'id' => 'preparation_days',
                        'required'=>""
                    ]
                )
            }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('Delivery Days', trans('Delivery Days'), ['class' => 'col-lg-2 control-label required' ]) }}

        <div class="col-lg-10 mce-box">
           {{ Form::select(
                        'delivery_day',
                        [
                            '' => 'Select Delivery Days',
                            '1' => '1 Day',
                            '2' => '2 Day',
                            '3' => '3 Day'
                        ],
                         '',
                        [
                            'class' => 'form-control box-size',
                            'id' => 'delivery_days',
                            'required'=>""
                        ]
                    )
                }}
        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
        {{ Form::label('Order Time', trans('Order Time'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10 mce-box">
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
                     '',
                    [
                        'class' => 'form-control box-size',
                        'id' => 'order_time',
                        'required'=>""
                    ]
                )
            }}
        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
        {{ Form::label('about Restaurant', trans('About Restaurant'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10 mce-box">
            {{ Form::textarea('description', null, ['class' => 'form-control box-size', 'rows'=>3,'required'=>'']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

      <div class="form-group col-md-12">
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
      {{ Form::label('Background Image', trans('Background Image'), ['class' => 'col-lg-2 control-label']) }}
      <div class="col-lg-10">
        <input type="file" name="background_image" class="form-control box-size">
      </div>
    </div>
    <div class="form-group">
        {{ Form::label('Restaurant Image', trans('Restaurant Image'), ['class' => 'col-lg-2 control-label']) }}
        <div class="form-group col-lg-9">
          <div class="demo"> 
           <input type="file" name="image[]" multiple="" class="form-control box-size">
          </div>
        </div>
    </div>
</div>
@section('after-scripts')
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
  
  $(document).on('change','#country',function(){
    var countryId = $('#country').val();
    if (countryId !== '') {
      city();
      $.ajax({
        method: "GET",
        url: "{{ url('admin/restaurant/restaurant-state') }}",
        data: {'country_id': countryId},
        success: function (data) {
          $('.state').html(data);
        },
        complete: function () {
          $('#resstate').change(function () {
            var stateId = $('#resstate').val();
            $.ajax({
              method: "GET",
              url: "{{ url('admin/restaurant/restaurant-city') }}",
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
        url: "{{ url('admin/restaurant/restaurant-city') }}",
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
    $('.city').html('<select class="form-control box-size" name="city"><option value="">Select City</option></select>');
  }

  function state()
  {
    $('.state').html('<select class="form-control box-size" name="state"><option value="">Select State</option></select>');
  }
</script>

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



     function productRemoveImageAdmin(imageId)
     {
      $.ajax({
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('admin/products/remove-image') }}",
        type: 'post',
        data: { 'image_id' : imageId },
        beforeSend: function() {
          $("#overlay").show();
        },
        success:function(data) {
          $('.image_'+imageId).hide();
          location.reload();
          $("#overlay").hide();
        }
      });
    }
    </script>

@endsection
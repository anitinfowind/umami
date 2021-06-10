@extends ('backend.layouts.app')
@section ('title', trans('Shipping Charge Calculation'))
@section('page-header')
    <h1>{{ trans('Shipping Charge Calculation') }}</h1>
@endsection
@section('content')
 {{ Form::model($shippingcharge,[
                'route' => ['admin.shippings.charge-shippings'],
                'class' => 'form-horizontal',
                'role' => 'form',
                'files'=>'true',
                ])
    }}
    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                @include('backend.shippings.partials.shippings-header-buttons')
            </div>
        </div>
    <div class="box-body">
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Service Days'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">

  <select name="day" class="form-control selectday" required="true">
  <option value="">Select Day</option>
  <option value="01">One Day</option>
  <option value="02">Two Day</option>
  <option value="03">Three Day</option>
  
</select>
        </div>
    </div>
     <div class="form-group ">
        {{ Form::label(
                'title',
                trans('From Country'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          <select name="f_country" class="form-control box-size" id="country" required="">
            <option value="">{{trans('From Country')}}</option>
            @foreach($countriedata as $cdata)
            <option value="{{$cdata->name}}">{{$cdata->name}}</option>
            @endforeach
          </select>
        </div>
    </div>
      <div class="form-group ">
        {{ Form::label(
                'title',
                trans('From State'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
            <div class="state">
              <select name="f_state" class="form-control box-size" id="fromstate">
                <option value="">{{trans('From state')}}</option>
              </select>
        </div>
      </div>
    </div>

      <div class="form-group ">
        {{ Form::label(
                'title',
                trans('From City'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          <div class="city">
             <select name="f_city" class="form-control box-size">
              <option value="">{{trans('From city')}}</option>
           
            </select>
          </div>
        </div>
    </div>
    
    <div class="form-group  discountshow">
        {{ Form::label(
                'title',
                trans('From Zipcode'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
              {{ Form::text(
                    'from_zipcode',null,
                    [
                        'class' => 'form-control from_zipcode box-size',
                        'placeholder' => trans('From Zipcode'),
                        'required'=>'required'
                    ]
                )
            }}

        </div>
    </div>
    <div class="form-group ">
        {{ Form::label(
                'title',
                trans('To Country'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          <select name="t_country" class="form-control box-size" id="tocountry" required="">
            <option value="">{{trans('To country')}}</option>
            @foreach($countriedata as $cdata)
            <option value="{{$cdata->name}}">{{$cdata->name}}</option>
            @endforeach
          </select>
           

        </div>
    </div>
      <div class="form-group ">
        {{ Form::label(
                'title',
                trans('To State'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          <div class="to_state">
              <select name="t_state" class="form-control box-size" id="tostate">
                <option value="">{{trans('To state')}}</option>
              </select>
          </div>
        </div>
    </div>

      <div class="form-group ">
        {{ Form::label(
                'title',
                trans('TO City'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          <div class="to_city">
             <select name="t_city" class="form-control box-size">
              <option value="">{{trans('To city')}}</option>
           
            </select>
          </div>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('To Zipcode'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'to_zipcode',null,
                    [
                        'class' => 'form-control to_zipcode box-size','required'=>'required',
                        'placeholder' => trans('To Zip code')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Product Weight'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'weight',null,
                    [
                        'class' => 'form-control  box-size','required'=>'required',
                        'placeholder' => trans('Product Weight')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Width'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'width',null,
                    [
                        'class' => 'form-control  box-size','required'=>'required',
                        'placeholder' => trans('Product width')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Product Height'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'height',null,
                    [
                        'class' => 'form-control box-size','required'=>'required',
                        'placeholder' => trans('Product Height')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Product Length'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'length',null,
                    [
                        'class' => 'form-control  box-size','required'=>'required',
                        'placeholder' => trans('Product Length')
                    ]
                )
            }}
        </div>
    </div>
    <?php if(isset($shippingcalculate)){ ?>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Sipping Charge'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
         <input type="text" class="form-control" placeholder="Shipping Charge" value="{{$shippingcalculate}}" readonly>
        </div>
    </div>
<?php } ?>
   <div class="edit-form-btn">
                        {{ link_to_route(
                                'admin.shippings.index',
                                trans('buttons.general.cancel'),
                                [],
                                [
                                    'class' => 'btn btn-danger btn-md'
                                ]
                            )
                        }}
                        {{ Form::submit(
                                trans('buttons.general.crud.update'),
                                [
                                    'class' => 'btn btn-primary btn-md'
                                ]
                            )
                        }}
                        <div class="clearfix"></div>
                    </div>

</div>
  
    </div>

{{ Form::close() }}
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  var day="<?php if(isset($day)){echo $day;} ?>";
  var from_zipcode="<?php if(isset($from_zipcode)){echo $from_zipcode;} ?>";
  var to_zipcode="<?php if(isset($to_zipcode)){echo $to_zipcode;} ?>";
    $(".selectday").val(day);
    $(".from_zipcode").val(from_zipcode);
    $(".to_zipcode").val(to_zipcode);

});
</script>
<script>
  
  $(document).on('change','#country',function(){
    var countryId = $('#country').val();
    if (countryId !== '') {
      city();
      $.ajax({
        method: "GET",
        url: "{{ url('admin/shippings/shippings-state-from') }}",
        data: {'country_id': countryId},
        success: function (data) {
          $('.state').html(data);
        },
        complete: function () {
          $('#fromstate').change(function () {
            var stateId = $('#fromstate').val();
            $.ajax({
              method: "GET",
              url: "{{ url('admin/shippings/shippings-city-from') }}",
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
 $(document).on('change','#fromstate',function(){
    var stateId = $('#fromstate').val();
    if (stateId !== '') {
      $.ajax({
        method: "GET",
        url: "{{ url('admin/shippings/shippings-city-from') }}",
        data: {'state_id': stateId},
        success: function (data) {
          $('.city').html(data);
        },
      });
    } else {
      city();
    }
  });


  $(document).on('change','#tocountry',function(){
    var countryId = $('#tocountry').val();
    if (countryId !== '') {
      tocity();
      $.ajax({
        method: "GET",
        url: "{{ url('admin/shippings/shippings-state') }}",
        data: {'country_id': countryId},
        success: function (data) {
          $('.to_state').html(data);
        },
        complete: function () {
          $('#tostate').change(function () {
            var stateId = $('#tostate').val();
            $.ajax({
              method: "GET",
              url: "{{ url('admin/shippings/shippings-city') }}",
              data: {'state_id': stateId},
              success: function (data) {
                $('.to_city').html(data);
              },
            });
          });
        },
      });
    } else {
      tostate();
      tocity();
    }
  });
 $(document).on('change','#tostate',function(){
    var stateId = $('#tostate').val();
    if (stateId !== '') {
      $.ajax({
        method: "GET",
        url: "{{ url('admin/shippings/shippings-city') }}",
        data: {'state_id': stateId},
        success: function (data) {
          $('.to_city').html(data);
        },
      });
    } else {
      tocity();
    }
  });


  function city()
  {
    $('.city').html('<select class="form-control box-size" name="f_city"><option value="">From City</option></select>');
  }

  function state()
  {
    $('.state').html('<select class="form-control box-size" name="f_state"><option value="">From State</option></select>');
  }

    function tocity()
  {
    $('.to_city').html('<select class="form-control box-size" name="t_city"><option value="">To City</option></select>');
  }

  function tostate()
  {
    $('.to_state').html('<select class="form-control box-size" name="t_state"><option value="">To State</option></select>');
  }
</script>
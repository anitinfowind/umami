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
    
    'id' => 'restaurant_shipping_info',
    'method' => 'POST',
    'files'=>'true'
    ])
}}


<?php
$shipping_info = $restaurant->shipping_info;
if($shipping_info == '') $shipping_info = '{}';
$shipping_info = json_decode($shipping_info, true);
?>

<div class="restaurant_error_div"></div>

    <div class="row">
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

    <div class="row">
      <div class="col-md-12">
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


    <div class="form-group">
      <div class="col-md-6 col-md-offset-4">
          <button 
                  type="submit"
                  class="btn order-btn"
          >
              Save
          </button>
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

<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{ URL::asset('/public/latest/plugins/timepicker/bootstrap-timepicker.min.css') }}">
<script src="{{ URL::asset('/public/latest/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

<script type="text/javascript">
  function onlyNumbers(elem) {
    $(document).on("keypress keyup blur", elem, function (event) { 
    //$(elem).on("keypress keyup blur",function (event) {    
         $(this).val($(this).val().replace(/[^\d].+/, ""));
          if ((event.which < 48 || event.which > 57)) {
              event.preventDefault();
          }
      });
  }
</script>

<script type="text/javascript">
  $(document).ready(function(){

    onlyNumbers('input[name="preparation_time"]');
    onlyNumbers('input[name="delivery_days"]');

    $('.timepicker').each(function(){
      $(this).timepicker({
        showInputs: false,
        showMeridian: false,
        defaultTime: false
      });
    });

  });
</script>

@endsection
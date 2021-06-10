@extends('frontend.layouts.app')
@section('content')

<div class="dashboard-wrap">
    <div class="container">
        <div class="row">
            @include('frontend.user.sidebar')
            <div class="col-md-9">
                <div class="dashboard-container">
                    <div class="panel panel-default">
                        <div class="panel-heading"></div>
                          <div class="row">
                            <table class="table">
                              <tr>
                                <td>Email Notification</td>
                                <td>
                                  <label class="switch">
                                    <input type="checkbox" value="{{isset($email->notification)?$email->notification:0}}" class="email-notifi" @if(isset($email->notification) && !empty($email->notification) && $email->notification=='1') checked @endif>
                                    <span class="slider round emailcheck"></span>
                                  </label></td>
                              </tr>
                            </table>
                            
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

@endsection
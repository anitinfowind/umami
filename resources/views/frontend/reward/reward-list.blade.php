@extends('frontend.layouts.app')
@section('content')
    <div class="dashboard-wrap">
      <div class="container">
        <div class="row">
          @include('frontend.user.sidebar')
          <div class="col-md-9">
            <div class="dashboard-container">
              <div class="panel panel-default my-order">
                <?php
                //auth()->user()->reward_point
                ?>
                <div class="rewards-wrap">
                  <h2>rewards</h2>
                  <div class="rewards-ern">
                    <h4>Hey there, you’ve earned</h4>
                    <span>{{ auth()->user()->reward_point }}</span>
                    <p>Rewards Points</p>
                  </div>
                  <!-- <p>Belly Rewards Points are reflective of all purchases that have shipped. Keep your points forever by placing an order at least once a year.</p> -->
                  <a class="earn-point-btn" href="{{ url('products') }}">Shop to earn point</a>
                  <br><br><a href="{{ url('pages/learn-about-rewards') }}">Learn more about reward system</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <link rel="stylesheet" type="text/css" href="{{url('css/dataTables.bootstrap4.min.css')}}">
<script type="text/javascript" src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable();
} );
</script>
@endsection
@extends('frontend.layouts.app')
@section('content')
<div class="dashboard-wrap">
  <div class="container">
    <div class="row">
      @include('frontend.user.sidebar')
      <div class="col-md-9">
        <h2>STATEMENT</h2>
        <div class="dashboard-container">
          <div class="panel panel-default">

            <div class="panel-heading">
              <div class="add-product-div">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <ul class="row list-unstyled border-bottom mx-2 py-2 no-gutters">
                  <li class="col-md-6">MERCHANT</li>
                  <li class="col-md-6 text-right">{{$statementorders->vendor_name}}</li>
                </ul>
                <ul class="row list-unstyled border-bottom mx-2 py-2 no-gutters">
                  <li class="col-md-6">STATEMENT START</li>
                  <li class="col-md-6 text-right">{{date('M d Y', strtotime($startdate))}}</li>
                </ul>
                <ul class="row list-unstyled border-bottom mx-2 py-2 no-gutters">
                  <li class="col-md-6">STATEMENT END</li>
                  <li class="col-md-6 text-right">{{date('M d Y',strtotime($enddate))}}</li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="row list-unstyled border-bottom mx-2 py-2 no-gutters">
                  <li class="col-md-6">SALES TOTAL</li>
                  <li class="col-md-6 text-right">
                    <span>${{number_format($statementorders->sums,2)}}</span>
                   <!--  <span><button class="btn btn-default">See More</button></span> -->
                  </li>
                </ul>
                <ul class="row list-unstyled border-bottom mx-2 py-2 no-gutters">
                  <li class="col-md-6">MISSED SHIPMENTS</li>
                  <li class="col-md-6 text-right">
                    <span>$0.00</span>
                    <!-- <span><button class="btn btn-default">See More</button></span> -->
                  </li>
                </ul>
                <ul class="row list-unstyled border-bottom mx-2 py-2 no-gutters">
                  <li class="col-md-6">RESHIPMENT</li>
                  <li class="col-md-6 text-right">
                    <span>$0.00</span>
                   <!--  <span><button class="btn btn-default">See More</button></span> -->
                  </li>
                </ul>
                <ul class="row list-unstyled border-bottom mx-2 py-2 no-gutters">
                  <li class="col-md-6">REFUNDS</li>
                  <li class="col-md-6 text-right">
                    <span>$0.00</span>
                  </li>
                </ul>
                <ul class="row list-unstyled border-bottom mx-2 py-2 no-gutters">
                  <li class="col-md-6">CANCELLATIONS</li>
                  <li class="col-md-6 text-right">
                    <span>$0.00</span>
                  </li>
                </ul>
                 <ul class="row list-unstyled border-bottom mx-2 py-2 no-gutters">
                  <li class="col-md-6">PROMOTIONS</li>
                  <li class="col-md-6 text-right">
                    <span>$0.00</span>
                  </li>
                </ul>
                <ul class="row list-unstyled border-bottom mx-2 py-2 no-gutters">
                  <li class="col-md-6">ADJUSTMENT</li>
                  <li class="col-md-6 text-right">
                    <span>$0.00</span>
                  </li>
                </ul>
                <ul class="row list-unstyled border-bottom mx-2 py-2 no-gutters">
                  <li class="col-md-6">INVOICEABLE TOTAL</li>
                  <li class="col-md-6 text-right">
                    <span style="font-weight: 600">${{number_format($statementorders->sums,2)}}</span>
                  </li>
                </ul>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <link rel="stylesheet" type="text/css" href="{{url('css/dataTables.bootstrap4.min.css')}}">
  <script type="text/javascript" src="{{url('js/
  jquery.dataTables.min.js')}}"></script>
  <script type="text/javascript" src="{{url('js/dataTables.bootstrap4.min.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable();
    } );
  </script>
  @endsection
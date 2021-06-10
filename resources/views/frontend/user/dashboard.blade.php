@extends('frontend.layouts.app')
@section('content')

<div class="dashboard-wrap">
    <div class="container">
        <div class="row">
            @include('frontend.user.sidebar')
            <div class="col-md-9">
                <div class="dashboard-container">
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ trans('navs.frontend.dashboard') }}</div>
                        @if(!auth()->user()->isUser())
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 col-md-push-8">
                                    <div class="row dash-bx dash1">
                                      <a href="{{url('order')}}">
                                        <div class="dash-box">
                                           {{$latestorder}}
                                            <h6>TODAY ORDER</h6>
                                        </div>
                                      </a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-push-8">
                                    <div class="row dash-bx dash2">
                                       <a href="{{url('order?status=pending')}}">
                                        <div class="dash-box">
                                            {{$pendingorder}}
                                             <h6>PENDING ORDER</h6>
                                        </div>
                                      </a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-push-8">
                                    <div class="row dash-bx dash3">
                                       <a href="{{url('order?status=cancel')}}">
                                        <div class="dash-box">
                                            {{$cancelorder}}
                                             <h6>CANCEL ORDER</h6>
                                        </div>
                                      </a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-push-8">
                                    <div class="row dash-bx dash4">
                                       <a href="{{url('order?status=packed,shipped,delivered')}}">
                                        <div class="dash-box">
                                            {{$shippedorder}}
                                             <h6>SHIPPED ORDER</h6>
                                        </div>
                                      </a>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6 col-md-push-8">
                                    <div class="row dash-bx dash4">
                                     <a href="report">   <div class="dash-box">
                                            {{isset($totalamount)?$totalamount:'0'}}
                                             <h6>Over All SALES </h6>
                                        </div>
                                      </a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection
@extends('frontend.layouts.app')
@section ('title', trans('product create'))
@section('content')
    <div class="dashboard-wrap">
        <div class="container">
            <div class="row">
                @include('frontend.user.sidebar')
                <div class="col-md-9">
                    <div class="dashboard-container">
                        <div class="panel panel-default">
                        	<div class="panel-body">
                            <div role="tabpanel">
                                <ul class="nav nav-tabs dash-tabs" role="tablist">
                                    
                                    <li role="presentation"  class="active" id="li-edit">
                                        <a href="#site2" class="nav-item nav-link active" aria-controls="edit" role="tab" data-toggle="tab"> Emails setting</a>
                                    </li>
                                   <!--  <li role="presentation" id="li-password">
                                        <a href="#site4" class="nav-item nav-link" aria-controls="password" role="tab" data-toggle="tab"> Payment Method</a>
                                    </li> -->
                                </ul>
                                 <div class="tab-content">
                                 
                  									<div role="tabpanel" class="tab-pane mt-30 active" id="site2">
                  										@include('frontend.setting.tabs.email-setting')      
                  									</div>
                                  <!--   <div role="tabpanel" class="tab-pane mt-30" id="site4">
                                      @include('frontend.setting.tabs.payment-method')
                                    </div> -->
                                    
                                 </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
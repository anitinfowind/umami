@extends('frontend.layouts.app')
@section('content')
    <div class="dashboard-wrap">
        <div class="container">
            <div class="row">
                @include('frontend.user.sidebar')
                <div class="col-md-9">
                    <div class="panel panel-default dash-right-side">
                        <div class="panel-body">
                            @if(auth()->user()->isUser())
                            <div class="alert alert-secondary text-info" role="alert">
                              <i class="fa fa-question-circle"></i> Your current reward point balance <b>{{ auth()->user()->reward_point }}</b>
                            </div>
                            @endif
                            <div role="tabpanel">
                                <ul class="nav nav-tabs dash-tabs" role="tablist">
                                    <li role="presentation" class="active" id="li-profile">
                                        <a href="#profile" class="nav-item nav-link active" aria-controls="profile" role="tab" data-toggle="tab" class="tabs">{{ trans('Profile Details') }}</a>
                                    </li>
                                    <li role="presentation" id="li-edit">
                                        <a href="#edit" class="nav-item nav-link"  aria-controls="edit" role="tab" data-toggle="tab" class="tabs">{{ trans('labels.frontend.user.profile.update_information') }}</a>
                                    </li>
                                    <!-- <li role="presentation" id="li-password">
                                        <a href="#password" class="nav-item nav-link" aria-controls="password" role="tab" data-toggle="tab" class="tabs">{{ trans('navs.frontend.user.change_password') }}</a>
                                    </li> -->
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane mt-30 active" id="profile">
                                        @include('frontend.user.account.tabs.profile')
                                    </div>
                                    <div role="tabpanel" class="tab-pane mt-30" id="edit">
                                        @include('frontend.user.account.tabs.edit')
                                    </div>
                                    <!-- <div role="tabpanel" class="tab-pane mt-30" id="password">
                                        @include('frontend.user.account.tabs.change-password')
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

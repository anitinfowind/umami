@extends('frontend.layouts.app')
@section('content')
    <div class="dashboard-wrap">
        <div class="container">
            <div class="row">
                @include('frontend.user.sidebar')
                <div class="col-md-9">
                    <div class="dashboard-container">
                        <div class="panel panel-default my-order">
                            @include('frontend.rating.rating-element')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
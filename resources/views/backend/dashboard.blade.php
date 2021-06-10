@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>{{ trans('strings.backend.dashboard.title') }}</small>
    </h1>
@endsection
   <style type="text/css">
      .dashboard_show {
    background: #49a3db;
    text-align: center;
    padding: 20px;
    margin-bottom: 20px;
    font-size: 22px;
    color: #fff;
}
.dashboard_show span {
    font-size: 18px;
    color: #984e9d;
    background: #fff;
    padding: 5px 10px;
    margin-top: 10px;
    display: inline-block;
    border-radius: 4px;
    width: auto;
}      
    </style>
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <!-- <h3 class="box-title">{{ trans('history.backend.recent_history') }}</h3> -->
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
           <div class="col-md-12">
            <div class="col-md-4">
             <a href="{{URL::to('admin/access/user')}}"> <div class="dashboard_show">Registered users<br><span>{{$usercount}}</span>
              </div></a>
            </div>

            <div class="col-md-4">
               <a href="{{URL::to('admin/vendors')}}">  <div class="dashboard_show">
                Vendor<br><span>{{$vendorcount}}</span>
                </div>
               </a>
            </div>

            <div class="col-md-4">
              <div class="dashboard_show">Complate Order<br><span>00</span>
              </div>
            </div>
           

          </div> 

         {{--   {!! history()->render() !!}--}}
        </div><!-- /.box-body -->
    </div><!--box box-info-->
@endsection
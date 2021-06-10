@extends('frontend.layouts.app')
@section ('title', trans('Notification'))
@section('content')
    <div class="dashboard-wrap">
        <div class="container">
            <div class="row">
                @include('frontend.user.sidebar')
                <div class="col-md-9">
                    <div class="dashboard-container">
                        <div class="panel panel-default">
                          <div class="panel-body">
                          <table class="table notification-table">
                            
                             <tbody>
                              @if(count($lists)>0)
                                @foreach($lists as $list)
                                 @if(isset($list->getProductNotifi->singleProductImage->image) && !empty($list->getProductNotifi->singleProductImage->image))
                                <tr>
                                  <td>
                                    <img src="{{url('uploads/product/'.$list->getProductNotifi->singleProductImage->image)}}">

                                  </td>
                                  <td  class="desc-noti" style="text-align: left;"><h4 class="noti-title">{{$list->notification_text}}</h4>
                                    <p>Your {{$list->getProductNotifi->title}} product order success.</p>
                                  </td>
                                  <td style="text-align: center;">
                                    {{ Carbon\Carbon::parse($list->created_at)->diffForHumans()}}
                                  </td>
                                 
                                </tr>
                                @endif
                                @endforeach
                              @else
                              <h4>Not founds notifications.</h4>

                              @endif
                             </tbody>
                           </table>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
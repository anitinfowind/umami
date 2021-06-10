@extends ('backend.layouts.app')

@section ('title', trans('Restaurant view') . ' | ' . trans('Restaurant view'))
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('Restaurant view') }}</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table table-striped table-hover">
            <tr>
                <th>{{ trans('User name') }}</th>
                <td>{{checkUserName($restaurant->user_id)}}</td>
            </tr>

            <tr>
                <th>{{ trans('Restarurant name') }}</th>
                <td>{{ $restaurant->name }}</td>
            </tr>

            <tr>
                <th>{{ trans('Phone No') }}</th>
                <td>{{ isset($restaurant->restaurantBranch->phone)?$restaurant->restaurantBranch->phone:'' }}</td>
            </tr>

            <tr>
                <th>{{ trans('Location') }}</th>
                <td>{{isset($restaurant->restaurantLocation->location)?$restaurant->restaurantLocation->location:'' }}</td>
            </tr>

            <tr>
                <th>{{ trans('Country') }}</th>
                <td>{{ isset($restaurant->restaurantLocation->country)?$restaurant->restaurantLocation->country:'' }}</td>
            </tr>

            <tr>
                <th>{{ trans('State') }}</th>
                <td>{{ isset($restaurant->restaurantLocation->state)?$restaurant->restaurantLocation->state:'' }}</td>
            </tr>
            <tr>
                <th>{{ trans('City') }}</th>
                <td>{{ $restaurant->restaurantLocation->city }}</td>
            </tr>
            <tr>
                <th>{{ trans('Description') }}</th>
                <td>{{ $restaurant->restaurantBranch->description }}</td>
            </tr>
            <tr>
                <th>{{ trans('Status') }}</th>
                <td>{{ $restaurant->is_active }}</td>
            </tr>
            <tr>
                <th>{{ trans('Category') }}</th>
                <td>
                  @if($restaurant->restaurantCategory->isNotEmpty())
                    @foreach($restaurant->restaurantCategory as $c=>$category)
                    {{ checkCategoryName($category['category_id']) }}
                    @endforeach
                  @endif
              </td>
            </tr>
            <tr>
                <th>{{ trans('Service Type') }}</th>
                <td>
                  @foreach(serviceType() as $key=>$service)
                    @if(in_array($key, $servicetype))
                        {{$service.' ,'}}
                    @endif
                  @endforeach
                </td>
            </tr>
             <tr>
                <th>{{ trans('Service Time') }}</th>
                <td>
                  <table class="table table-striped table-hover">
                    <th>Day</th>
                    <th>Open</th>
                    <th>Close</th>
                   
                    @if($restaurant->restaurantTime->isNotEmpty())
                        <?php $week = [];?>
                        @foreach($restaurant->restaurantTime as $restaurantTime)
                                <?php $week[] =  $restaurantTime->day; ?>
                        @endforeach
                    @endif
                    @foreach(weekDay() as $key => $day)
                        @if(isset($week) && in_array($key,  $week))
                            @foreach($restaurant->restaurantTime as $restaurantTime)
                                @if($key == $restaurantTime->day)
                                 <tr>
                                    <td>
                                        <span>{{ $day }}</span>
                                    </td>
                                    <td>  {{ date('h:i A', strtotime($restaurantTime->open)) }} 
                                    </td>
                                    <td>
                                        {{ date('h:i A', strtotime($restaurantTime->close)) }}
                                    </td>
                                 </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                  </table>
                </td>
            </tr>
            <tr>
              <th>{{ trans('Images') }}</th>
              <td>
                @if($restaurant->restaurantImage->isNotEmpty())
                  @foreach($restaurant->restaurantImage as $images)
                  <img style="width: 150px" height="100px" src="{{url('uploads/restaurant/'.$images->image)}}">
                  @endforeach
                @endif
              </td>
            </tr>
         </table>
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection
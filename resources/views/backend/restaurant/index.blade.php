@extends ('backend.layouts.app')
@section ('title', trans('Restaurant'))
@section('page-header')
    <h1>{{ trans('Restaurant') }}</h1>
@endsection
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Restaurants') }}</h3>

                <div class="box-tools pull-right">
                 @include('backend.restaurant.partials.restaurant-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!--box-header with-border-->
            <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="example" class="table table-condensed table-hover table-bordered" data-order="[[ 3, &quot;desc&quot; ]]">
                    <thead>
                        <tr>
                            <th>{{ trans('User name') }}</th>
                            <th>{{ trans('Restaurant Name') }}</th>
                            <th>{{ trans('Location') }}</th>
                            <th>{{ trans('Created At') }}</th>
                            <th>{{ trans('Status') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($getresdata->isNotEmpty())
                          @foreach($getresdata as $restoval)
                            <tr>
                              <td>{{checkUserName($restoval->user_id)}}</td>
                                <td>{{ isset($restoval->name)?$restoval->name:'' }}</td>
                                <td>{{ isset($restoval->restaurantLocation->location)?$restoval->restaurantLocation->location:'' }}</td>
                                <td>{{ date('m-d-Y H:i:s',strtotime($restoval->created_at)) }}</td>
                                <td>
                                <?php if($restoval->is_active=='PENDING'){ ?>
                                  <label class="label label-danger">Pending</label>
                                  <?php }else{?>
                                    <label class="label label-success">Active</label>
                              <?php   }?>
                                </td>
                                <td>
                                  <div class="btn-group dropup">
                                  <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-option-vertical"></span>
                                </button>
                                  <ul class="dropdown-menu dropdown-menu-right"> 
                                  <li><a class="" href="{{route('admin.restaurant.edit',$restoval->id)}}"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top"></i>Edit</a></li>
                                  <li><a class="" href="{{route('admin.restaurant.view',$restoval->id)}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top"></i>View</a></li>
                                  <li><a class="" href="{{ url('admin/sales_report?restaurant_id=' . $restoval->id) }}"><i class="fa fa-usd" data-toggle="tooltip" data-placement="top"></i>Sales</a></li>
                                   @if($restoval->is_active=='PENDING')
                                    @if(isset($restoval->restaurantSingleImage->image) && !empty($restoval->restaurantSingleImage->image))
                                     <li><a class="" href="{{route('admin.restaurant.approved',$restoval->id)}}"><i class="fa fa-check-square" aria-hidden="true"></i>Approved</a></li>
                                     @else
                                     <li><a class="checkIm" href="{{route('admin.restaurant.approved',$restoval->id)}}" onclick="return confirm('Please let us choose if it will be visible on top page or not')"><i class="fa fa-check-square" aria-hidden="true"></i>Approved</a></li>

                                     @endif
                                  @else
                                  <li><a class="" href="{{route('admin.restaurant.approved',$restoval->id)}}"><i class="fa fa-check-square" aria-hidden="true"></i>UnApproved</a></li>
                                  @endif
                                  <li><a class="" href="{{ url('admin/restaurant/delete/' . $restoval->id) }}" onclick="return confirm('Are you sure to delete this restaurant?');"><i class="fa fa-trash" aria-hidden="true"></i>Delete</a></li>
                                  </ul>
                                 </div>
                                </td>
                            </tr>
                          @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('after-scripts')
    {{ Html::script(mix('js/dataTable.js')) }}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@endsection
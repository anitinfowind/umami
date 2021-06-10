@extends ('backend.layouts.app')

@section ('title', trans('Vendor view') . ' | ' . trans('Vendor view'))
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('Vendor view') }}</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table table-striped table-hover">
              <tr>
                  <th>{{ trans('labels.backend.access.users.tabs.content.overview.name') }}</th>
                  <td>{{ $vendorDetail->first_name .' '. $vendorDetail->last_name }}</td>
              </tr>

              <tr>
                  <th>{{ trans('labels.backend.access.users.tabs.content.overview.email') }}</th>
                  <td>{{ $vendorDetail->email }}</td>
              </tr>
              <tr>
                  <th>{{ trans('Phone No.') }}</th>
                  <td>{{ isset($vendorDetail->phone)?$vendorDetail->phone:'' }}</td>
              </tr>
              <tr>
                  <th>{{ trans('Location') }}</th>
                  <td>{{ isset($vendorDetail->isRestaurantLocation->location)?$vendorDetail->isRestaurantLocation->location:'' }}</td>
              </tr>
              <tr>
                  <th>{{ trans('Category') }}</th>
                  <td>
                      @if($vendorDetail->isRestaurantCategory->isNotEmpty())
                        @foreach($vendorDetail->isRestaurantCategory as $restaurantCategory)
                          {{ $restaurantCategory->category->name }}
                        @endforeach
                      @endif
                 </td>
              </tr>
              <tr>
                  <th>{{ trans('Image') }}</th>
                  <td>
                    @if($vendorDetail->image() !=='' && File::exists(USER_PROFILE_IMAGE_ROOT_PATH.$vendorDetail->slug.DS.$vendorDetail
                        ->image()))
                      <img class="media-object" style="width: 150px" src="{{ USER_PROFILE_IMAGE_URL.$vendorDetail->slug.DS.$vendorDetail->image() }}">
                    @else
                      <img class="media-object" src="{{ WEBSITE_IMG_URL }}profile-user-img.png">
                    @endif
                  </td>
              </tr>

              <tr>
                  <th>{{ trans('labels.backend.access.users.tabs.content.overview.status') }}</th>
                  <td>{!! $vendorDetail->status_label !!}</td>
              </tr>

              <tr>
                  <th>{{ trans('labels.backend.access.users.tabs.content.overview.confirmed') }}</th>
                  <td>{!! $vendorDetail->confirmed_label !!}</td>
              </tr>

              <tr>
                  <th>{{ trans('labels.backend.access.users.tabs.content.overview.created_at') }}</th>
                  <td>{{ date('d-M-Y', strtotime($vendorDetail->created_at)) }} ({{ $vendorDetail->created_at->diffForHumans() }})</td>
              </tr>

              <tr>
                  <th>{{ trans('labels.backend.access.users.tabs.content.overview.last_updated') }}</th>
                  <td>{{ date('d-M-Y', strtotime($vendorDetail->updated_at)) }} ({{ $vendorDetail->updated_at->diffForHumans() }})</td>
              </tr>

              @if ($vendorDetail->trashed())
                  <tr>
                      <th>{{ trans('labels.backend.access.users.tabs.content.overview.deleted_at') }}</th>
                      <td>{{ $vendorDetail->deleted_at }} ({{ $vendorDetail->deleted_at->diffForHumans() }})</td>
                  </tr>
              @endif
          </table>
       </div><!-- /.box-body -->
    </div><!--box-->
  @endsection
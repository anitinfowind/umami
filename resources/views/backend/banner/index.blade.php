@extends ('backend.layouts.app')
@section ('title', trans('Banner'))
@section('page-header')
    <h1>{{ trans('Banner') }}</h1>
@endsection
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
             @include('backend.banner.partials.banner-header-buttons')
            </div>
        </div>
            <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="example" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('Banner Image') }}</th>
                            <th>{{ trans('Title') }}</th>
                            <th>{{ trans('Status') }}</th>
                            <th>{{ trans('Created At') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($banners->isNotEmpty())
                            @foreach($banners as $banner)
                            <?php
                             $info = pathinfo(public_path('/uploads/banner/').$banner->image);
                                $ext = $info['extension'];
                                ?>
                                <tr>
                                    <td>
                                     @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
                                        @if(!empty($banner->image) && File::exists(public_path('/uploads/banner/').$banner->image))
                                        <img style="width: 70px" src="{{URL::to('uploads/banner/'.$banner->image)}}">
                                        @else
                                        <img style="width: 70px" src="{{URL::to('images/no-image.png')}}">
                                        @endif
                                      @else
                                       <video width="200px" height="150px" muted loop  controls> 
                                        <source src="{{URL::to('uploads/banner/'.$banner->image)}}" type="video/mp4">
                                        </video>
                                      @endif
                                    </td>
                                    <td>{{ $banner->title() }}</td>
                                    <td>
                                        @if($banner->is_active == ACTIVE)
                                            <label class="label label-success">Active</label>
                                        @else
                                            <label class="label label-danger">Inactive</label>
                                        @endif
                                    </td>
                                    </td>
                                    <td>{{ $banner->createdAt() }}</td>
                                    <td>
                                        <a href="{{ route("admin.banner.edit", $banner->id()) }}" class="btn btn-flat btn-default">
                                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-pencil" data-original-title="Edit"></i>
                                        </a>
                                       <!--  <a href="{{ route("admin.banner.delete", $banner->id()) }}" class="btn btn-flat btn-default" data-method="delete"
                                           data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();">
                                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-trash" data-original-title="Delete" aria-describedby="tooltip373985"></i>
                                            <div class="tooltip fade top" role="tooltip" id="tooltip373985" style="top: -27px; left: -12.3906px; display: block;">
                                                <div class="tooltip-arrow" style="left: 50%;"></div>
                                                <div class="tooltip-inner">Delete</div>
                                            </div>
                                        </a> -->
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
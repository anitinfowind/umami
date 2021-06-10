@extends ('backend.layouts.app')

@section ('title', trans('Chef management'))

@section('page-header')
    <h1>{{ trans('Chef management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('Chef management') }}</h3>

            <div class="box-tools pull-right">
               @include('backend.chef.partials.chef-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="example" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                          <th>{{trans('Image')}}</th>
                            <th>{{ trans('Name') }}</th>
                             <th>{{ trans('Designation') }}</th>
                            <!--  <th>{{ trans('Email') }}</th> -->
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                     <tbody>
                      @if($chefs->isNotEmpty())
                       @foreach($chefs as $chef)
                          <tr>
                            <td>@if($chef->image !=='' &&
                                      File::exists(CHEF_ROOT_PATH.$chef->image))
                                  <?php $image = CHEF_URL.$chef->image; ?>
                                @else
                                    <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                                @endif
                                 <img class="resto product_list" src="{{ $image }}"></td>
                            <td> {{ $chef->name }}</td>
                            <td> {{ $chef->designation}}</td>
                           <!--  <td> {{ $chef->email}}</td> -->
                            <td>
                              <a href="{{url('admin/chefs/view/'.$chef->id)}}" class="btn btn-default btn-flat"><i data-toggle="tooltip" data-placement="top" title="" data-original-title="View" class="fa fa-eye"></i></a>

                               <a class="btn btn-default btn-flat" href="{{route('admin.chefs.edit',$chef)}}">
                                    <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-pencil" data-original-title="Edit"></i>
                               </a>

                               <a href="{{ route('admin.chefs.destroy',$chef) }}" class="btn btn-flat btn-default" data-method="delete" data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();">
                                          <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-trash" data-original-title="Delete" aria-describedby="tooltip373985"></i>
                                          <div class="tooltip fade top" role="tooltip" id="tooltip373985" style="top: -27px; left: -12.3906px; display: block;">
                                            <div class="tooltip-arrow" style="left: 50%;"></div>
                                            <div class="tooltip-inner">Delete</div>
                                            </div>
                                       </a>
                            </td>
                          </tr>
                       @endforeach   
                      @endif
                        </tbody>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}
    <script>
     $(document).ready(function() {
       $('#example').DataTable();
      } );
    </script>
@endsection

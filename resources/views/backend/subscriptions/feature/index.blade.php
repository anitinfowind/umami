@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.subscriptions.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.subscriptions.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.subscriptions.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.subscriptions.feature.partials.subscriptions-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="example" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.subscriptions.table.id') }}</th>
                            <th>{{ trans('labels.backend.subscriptions.table.title') }}</th>
                            <th>{{ trans('labels.backend.subscriptions.price') }}</th>
                            <th>{{ trans('labels.backend.subscriptions.plan') }}</th>
                              <th>{{ trans('labels.backend.subscriptions.table.status') }}</th>
                            
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                  @foreach($getplanlist as $getplan)
                      <tr>
                         <td>{{$getplan->id}}</td>
                          <td>{{$getplan->title}}</td>
                          <td>{{$getplan->price}}</td>
                          <td>{{$getplan['getplan']->title}}</td>
                          <td>
                            @if($getplan->status==1)
                            <label class="label label-success">Active</label>
                           @else
                            <label class="label label-danger">Inactive</label>
                           @endif
                        </td>
                          <td>
                            <a href="{{URL::to('admin/subscriptions/feature/edit/'.$getplan->id)}}" class="btn btn-flat btn-default">
                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-pencil" data-original-title="Edit"></i>
                            </a>
                            <a href="{{URL::to('admin/subscriptions/feature/delete/'.$getplan->id)}}" class="btn btn-flat btn-default" data-method="delete" data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();">
                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-trash" data-original-title="Delete"></i>
                          </a>
                          </td>
                      </tr>
                   @endforeach  
                  </tbody>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}
    <script type="text/javascript">
  
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
@endsection

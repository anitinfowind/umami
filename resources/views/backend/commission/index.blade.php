@extends ('backend.layouts.app')

@section ('title', trans('Commission Module'))

@section('page-header')
    <h1>{{ trans('Commission Module') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('Commission Module') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.commission.partials.commission-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="example" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.products.table.id') }}</th>
                            <th>{{ trans('Site commission') }}</th>
                            <th>{{ trans('Vendor commission') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <thead class="transparent-bg">
                        <tr>
                            <td>{{$getcomm->id}}</td>
                            <td>{{$getcomm->site_commission}}</td>
                            <td>{{$getcomm->vendor_commission}}</td>
                            <td><a href="{{route('admin.commission.edit',$getcomm->id)}}" class="btn btn-flat btn-default">
                              <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-pencil" data-original-title="Edit"></i>
                          </a>        
                            </td>
                        </tr>
                    </thead>
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

@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.videos.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.videos.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.videos.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.videos.partials.videos-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="videos-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('Title') }}</th>
                             <th>{{ trans('Video') }}</th>
                             <th>{{ trans('Location') }}</th>
                             <th>{{ trans('Status') }}</th>
                            <th>{{ trans('labels.backend.videos.table.createdat') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
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

    <script>
        //Below written line is short form of writing $(document).ready(function() { })
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var dataTable = $('#videos-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.videos.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'title', name: '{{config('module.videos.table')}}.title'},
                    {data: 'video', name: '{{config('module.videos.table')}}.vodeo'},
                    {data: 'location', name: '{{config('module.videos.table')}}.location'},
                    {data: 'is_active', name: '{{config('module.videos.table')}}.is_active'},
                    {data: 'created_at', name: '{{config('module.videos.table')}}.created_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[0, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1 ]  }}
                    ]
                }
            });

            Backend.DataTableSearch.init(dataTable);
        });
    </script>
@endsection

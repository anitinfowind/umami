@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.sliders.management'))

@section('page-header')
    <h1>{{ trans('Sliders') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                @include('backend.sliders.partials.sliders-header-buttons')
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="sliders-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('Image') }}</th>
                            <th>{{ trans('Status') }}</th>
                            <th>{{ trans('labels.backend.sliders.table.createdat') }}</th>
                            <th>{{ trans('Updated At') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('after-scripts')
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var dataTable = $('#sliders-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.sliders.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'slider_image', name: '{{config('module.sliders.table')}}.slider_image'},
                    {data: 'status', name: '{{config('module.sliders.table')}}.status'},
                    {data: 'created_at', name: '{{config('module.sliders.table')}}.created_at'},
                    {data: 'updated_at', name: '{{config('module.sliders.table')}}.updated_at'},
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

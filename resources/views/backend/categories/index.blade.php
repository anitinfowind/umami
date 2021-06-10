@extends ('backend.layouts.app')
@section ('title', trans('labels.backend.categories.management'))
@section('page-header')
    <h1>{{ trans('Category') }}</h1>
@endsection
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                @include('backend.categories.partials.categories-header-buttons')
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="categories-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>{{ trans('Name') }}</th>
                        <th>{{ trans('Status') }}</th>
                        <th>{{ trans('labels.backend.categories.table.createdat') }}</th>
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody class="transparent-bg">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tbody>
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

            var dataTable = $('#categories-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.categories.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'name', name: '{{config('module.categories.table')}}.name'},
                    {data: 'is_active', name: '{{config('module.categories.table')}}.is_active'},
                    {data: 'created_at', name: '{{config('module.categories.table')}}.created_at'},
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
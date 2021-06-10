@extends ('backend.layouts.app')
@section ('title', trans('Diet'))
@section('page-header')
    <h1>{{ trans('Diets') }}</h1>
@endsection
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                @include('backend.diet.partials.diet-header-buttons')
            </div>
        </div>
            <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="example" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('Name') }}</th>
                            <th>{{ trans('Status') }}</th>
                            <th>{{ trans('Created At') }}</th>
                            <th>{{ trans('Updated At') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($diets->isNotEmpty())
                            @foreach($diets as $diet)
                                <tr>
                                    <td>{{ $diet->name() }}</td>
                                    <td>
                                        @if($diet->isActive() == ACTIVE)
                                            <label class="label label-success">Active</label>
                                        @else
                                            <label class="label label-danger">Inactive</label>
                                        @endif
                                    </td>
                                    <td>{{ $diet->createdAt() }}</td>
                                    <td>{{ $diet->updatedAt() }}</td>
                                    <td>
                                        <a href="{{ route("admin.diet.edit", $diet->id()) }}" class="btn btn-flat btn-default">
                                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-pencil" data-original-title="Edit"></i>
                                        </a>
                                        <a href="{{ route("admin.diet.delete", $diet->id()) }}" class="btn btn-flat btn-default" data-method="delete"
                                           data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();">
                                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-trash" data-original-title="Delete" aria-describedby="tooltip373985"></i>
                                            <div class="tooltip fade top" role="tooltip" id="tooltip373985" style="top: -27px; left: -12.3906px; display: block;">
                                                <div class="tooltip-arrow" style="left: 50%;"></div>
                                                <div class="tooltip-inner">Delete</div>
                                            </div>
                                        </a>
                                        @if($diet->isActive() == ACTIVE)
                                            <a href='{{ route("admin.diet.update-diet-status", [$diet->id(), INACTIVE]) }}' class="btn btn-flat
                                            btn-default">
                                                <i class="fa fa-square" data-toggle="tooltip" data-placement="top" title="Deactivate"></i>
                                            </a>
                                        @else
                                            <a href='{{ route("admin.diet.update-diet-status", [$diet->id(), ACTIVE]) }}' class="btn btn-flat
                                            btn-default">
                                                <i class="fa fa-check-square" data-toggle="tooltip" data-placement="top" title="activate"></i>
                                            </a>
                                        @endif
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
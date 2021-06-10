@extends ('backend.layouts.app')

@section ('title', trans('Commission Module') . ' | ' . trans('Commission Module'))

@section('page-header')
    <h1>
        {{ trans('Commission Module') }}
        <small>{{ trans('Commission Edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($editcomm, ['route' => ['admin.commission.update', $editcomm->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-product','files' => true,]) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Commission Edit') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.commission.partials.commission-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    {{-- Including Form blade file --}}
                    @include("backend.commission.form")
                    <div class="edit-form-btn">
                        {{ link_to_route('admin.commission.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!--form-group-->
            </div><!--box-body-->
        </div><!--box box-success -->
    {{ Form::close() }}
@endsection

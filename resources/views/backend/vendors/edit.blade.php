@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.vendors.management') . ' | ' . trans('labels.backend.vendors.edit'))

@section('page-header')
    <h1>
        {{ trans('Vendor') }}
    </h1>
@endsection

@section('content')
    {{ Form::model($vendors, ['route' => ['admin.vendors.update', $vendors], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-vendor']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.vendors.edit') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.vendors.partials.vendors-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    {{-- Including Form blade file --}}
                    @include("backend.vendors.form")
                    <div class="edit-form-btn">
                        {{ link_to_route('admin.vendors.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!--form-group-->
            </div><!--box-body-->
        </div><!--box box-success -->
    {{ Form::close() }}
@endsection

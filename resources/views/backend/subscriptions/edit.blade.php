@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.subscriptions.management') . ' | ' . trans('labels.backend.subscriptions.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.subscriptions.management') }}
        <small>{{ trans('labels.backend.subscriptions.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($subscriptions, ['route' => ['admin.subscriptions.update', $subscriptions], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-subscription','files'=>'true']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.subscriptions.edit') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.subscriptions.partials.subscriptions-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    {{-- Including Form blade file --}}
                    @include("backend.subscriptions.form")
                    <div class="edit-form-btn">
                        {{ link_to_route('admin.subscriptions.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!--form-group-->
            </div><!--box-body-->
        </div><!--box box-success -->
    {{ Form::close() }}
@endsection

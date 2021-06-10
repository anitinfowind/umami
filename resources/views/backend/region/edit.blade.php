@extends ('backend.layouts.app')
@section ('title', trans('Region') . ' | ' . trans('Edit Region'))
@section('page-header')
    <h1>
        {{ trans('Region') }}
    </h1>
@endsection
@section('content')
    {{ Form::open([
                'route' => ['admin.region.update',$regions->id()],
                'class' => 'form-horizontal',
                'role' => 'form',
                ])
    }}
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Edit Region') }}</h3>
                <div class="box-tools pull-right">
                    @include('backend.region.partials.region-header-buttons')
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    @include("backend.region.form")
                    <div class="edit-form-btn">
                        {{ link_to_route(
                                'admin.region.index',
                                trans('buttons.general.cancel'),
                                [],
                                [
                                    'class' => 'btn btn-danger btn-md'
                                ]
                            )
                        }}
                        {{ Form::submit(
                                trans('buttons.general.crud.update'),
                                [
                                    'class' => 'btn btn-primary btn-md'
                                ]
                            )
                        }}
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
@endsection
@extends ('backend.layouts.app')
@section ('title', trans('Event') . ' | ' . trans('Edit Event'))
@section('page-header')
    <h1>
        {{ trans('Event') }}
    </h1>
@endsection
@section('content')
    {{ Form::open([
                'route' => ['admin.event.update',$events->id()],
                'class' => 'form-horizontal',
                'role' => 'form',
                'files'=>'true',
                ])
    }}
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Edit Event') }}</h3>
                <div class="box-tools pull-right">
                    @include('backend.event.partials.event-header-buttons')
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    @include("backend.event.form")
                    <div class="edit-form-btn">
                        {{ link_to_route(
                                'admin.event.index',
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
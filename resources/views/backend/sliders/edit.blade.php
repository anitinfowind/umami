@extends ('backend.layouts.app')
@section ('title', trans('labels.backend.sliders.management') . ' | ' . trans('labels.backend.sliders.edit'))
@section('page-header')
    <h1>
        {{ trans('Slider') }}
    </h1>
@endsection
@section('content')
    {{ Form::model(
            $sliders,
            [
                'route' => ['admin.sliders.update', $sliders],
                'class' => 'form-horizontal',
                'role' => 'form',
                'method' => 'PATCH',
                'id' => 'edit-slider',
                'files' => 'true'
            ]
        )
    }}
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Edit Slider') }}</h3>
                <div class="box-tools pull-right">
                    @include('backend.sliders.partials.sliders-header-buttons')
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    @include("backend.sliders.form")
                    <div class="edit-form-btn">
                        {{ link_to_route(
                                'admin.sliders.index',
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
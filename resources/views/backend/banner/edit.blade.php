@extends ('backend.layouts.app')
@section ('title', trans('Banner') . ' | ' . trans('Edit Banner'))
@section('page-header')
    <h1>
        {{ trans('Banner') }}
    </h1>
@endsection
@section('content')
    {{ Form::model($banners,[
                'route' => ['admin.banner.update',$banners->id()],
                'class' => 'form-horizontal',
                'role' => 'form',
                'files'=>'true',
                ])
    }}
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Edit Banner') }}</h3>
                <div class="box-tools pull-right">
                    @include('backend.banner.partials.banner-header-buttons')
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    @include("backend.banner.form")
                    <div class="edit-form-btn">
                        {{ link_to_route(
                                'admin.banner.index',
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
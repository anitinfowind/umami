@extends ('backend.layouts.app')
@section ('title', trans('Video') . ' | ' . trans('Add Video'))
@section('page-header')
    <h1>
        {{ trans('Video') }}
    </h1>
@endsection
@section('content')
    {{ Form::open([
                'route' => 'admin.banner.videosave',
                'class' => 'form-horizontal',
                'role' => 'form',
                'method' => 'post',
                'id' => 'create-slider',
                'files' => 'true'
                ])
    }}
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Add Video ') }}</h3>
                <div class="box-tools pull-right">
                    @include('backend.banner.partials.banner-header-buttons')
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    @include("backend.banner.videoform")
                    <div class="edit-form-btn">
                        {{ link_to_route(
                                'admin.banner.video',
                                trans('buttons.general.cancel'),
                                [],
                                [
                                    'class' => 'btn btn-danger btn-md'
                                ]
                            )
                        }}
                        {{ Form::submit(
                                trans('buttons.general.crud.create'),
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
@extends ('backend.layouts.app')
@section ('title', trans('labels.backend.blogs.management') . ' | ' . trans('labels.backend.blogs.create'))
@section('page-header')
    <h1>
        {{ trans('Blog') }}
    </h1>
@endsection
@section('content')
    {{ Form::open([
            'route' => 'admin.blogs.store',
            'class' => 'form-horizontal',
            'role' => 'form',
            'method' => 'post',
            'id' => 'create-permission',
            'files' => true
            ])
    }}
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Add Blog') }}</h3>
                <div class="box-tools pull-right">
                    @include('backend.blogs.partials.blogs-header-buttons')
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    @include("backend.blogs.form")
                    <div class="edit-form-btn">
                        {{ link_to_route(
                                'admin.blogs.index',
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
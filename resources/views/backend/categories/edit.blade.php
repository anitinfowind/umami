@extends ('backend.layouts.app')
@section ('title', trans('labels.backend.categories.management') . ' | ' . trans('labels.backend.categories.edit'))
@section('page-header')
    <h1>
        {{ trans('Category') }}
    </h1>
@endsection
@section('content')
    {{ Form::open([
            'route' => ['admin.categories.update', $category->id],
            'class' => 'form-horizontal',
            'role' => 'form',
            'method' =>'PATCH',
            'id' => 'edit-category'
            ])
    }}
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Edit Category') }}</h3>
                <div class="box-tools pull-right">
                    @include('backend.categories.partials.categories-header-buttons')
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    @include("backend.categories.form")
                    <div class="edit-form-btn">
                        {{ link_to_route(
                                'admin.categories.index',
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
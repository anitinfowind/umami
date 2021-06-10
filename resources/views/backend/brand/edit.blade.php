@extends ('backend.layouts.app')
@section ('title', trans('labels.backend.brand.management') . ' | ' . trans('labels.backend.brand.edit'))
@section('page-header')
    <h1>
        {{ trans('Brand') }}
    </h1>
@endsection
@section('content')
    {{ Form::open([
                'route' => ['admin.brand.update',$brands->id()],
                'class' => 'form-horizontal',
                'role' => 'form',
                'method' => 'PATCH',
                'id' => 'edit-slider',
                'files' => 'true'
                ])
    }}
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Edit Brand') }}</h3>
                <div class="box-tools pull-right">
                    @include('backend.brand.partials.brand-header-buttons')
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    @include("backend.brand.form")
                    <div class="edit-form-btn">
                        {{ link_to_route(
                                'admin.brands.index',
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
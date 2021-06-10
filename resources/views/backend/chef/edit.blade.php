@extends ('backend.layouts.app')
@section ('title', trans('Chefs') . ' | ' . trans('Edit Chefs'))
@section('page-header')
    <h1>
        {{ trans('Chefs') }}
    </h1>
@endsection
@section('content')
    {{ Form::model($chefs,[
                'route' => ['admin.chefs.update',$chefs->id],
                'class' => 'form-horizontal',
                'role' => 'form',
                'files'=>'true',
                'method' => 'PATCH',
                ])
    }}
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Edit Chefs') }}</h3>
                <div class="box-tools pull-right">
                    @include('backend.chef.partials.chef-header-buttons')
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    @include("backend.chef.form")
                    <div class="edit-form-btn">
                        {{ link_to_route(
                                'admin.chefs.index',
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
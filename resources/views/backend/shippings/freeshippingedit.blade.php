@extends ('backend.layouts.app')
@section ('title', trans('Shippings Fee') . ' | ' . trans('Edit Shippings'))
@section('page-header')
    <h1>
        {{ trans('shippings Fee') }}
    </h1>
@endsection
@section('content')
    {{ Form::model($freeshipping,[
                'route' => ['admin.shippings.update.fees',$freeshipping->id],
                'class' => 'form-horizontal',
                'role' => 'form',
                'files'=>'true',
                ])
    }}
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Edit shippings Fee') }}</h3>
                <div class="box-tools pull-right">
                    @include('backend.shippings.partials.shippings-header-buttons')
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    @include("backend.shippings.form_fees")
                    <div class="edit-form-btn">
                        {{ link_to_route(
                                'admin.shippings.freeshipping',
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
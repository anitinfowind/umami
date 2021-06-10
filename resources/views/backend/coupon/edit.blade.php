@extends ('backend.layouts.app')
@section ('title', trans('Coupon') . ' | ' . trans('Edit Coupon'))
@section('page-header')
    <h1>
        {{ trans('Coupon') }}
    </h1>
@endsection
@section('content')
    {{ Form::model($coupons,[
                'route' => ['admin.coupon.update',$coupons->id],
                'class' => 'form-horizontal',
                'role' => 'form',
                'files'=>'true',
                ])
    }}
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Edit Coupon') }}</h3>
                <div class="box-tools pull-right">
                    @include('backend.coupon.partials.coupon-header-buttons')
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    @include("backend.coupon.form")
                    <div class="edit-form-btn">
                        {{ link_to_route(
                                'admin.coupon.index',
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
@extends ('backend.layouts.app')
@section ('title', trans('Shipping Commission'))
@section('page-header')
<h1>{{ trans('Shipping Commission') }}</h1>
@endsection
    @section('content')
        {{ Form::model($shippingcommisssion,[
            'route' => ['admin.shippings.addcommission'],
            'class' => 'form-horizontal',
            'role' => 'form',
            'files'=>'true',
            ])
        }}
        <input type="hidden" name="id" value="{{isset($shippingcommisssion->id)?$shippingcommisssion->id:''}}">
        <div class="box box-info">
            <div class="box-header with-border">
                <div class="box-tools pull-right">
                    @include('backend.shippings.partials.shippings-header-buttons')
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    {{ Form::label(
                        'title',
                        trans('Shipping Commission'),
                        [
                        'class' => 'col-lg-2 control-label required'
                        ]
                        )
                    }}
                <div class="col-lg-10">
                    {{ Form::text(
                        'shipping_commission',null,
                        [
                            'class' => 'form-control box-size',
                            'placeholder' => trans('Commission'),
                            'required'=>'required'
                        ]
                        )
                    }}
                </div>
            </div>

                <div class="edit-form-btn">
                    {{ link_to_route(
                        'admin.shippings.index',
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
        {{ Form::close() }}
    @endsection


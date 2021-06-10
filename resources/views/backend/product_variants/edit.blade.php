@extends ('backend.layouts.app')
@section ('title', trans('Product Variants') . ' | ' . trans('Edit Product Variants'))
@section('page-header')
    <h1>
        {{ trans('Product Variants') }}
    </h1>
@endsection
@section('content')
    {{ Form::model($productVariants,[
                'route' => ['admin.productVariants.update',$productVariants->id()],
                'class' => 'form-horizontal',
                'role' => 'form',
                'files'=>'true'
                ])
    }}
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Edit Product Variants') }}</h3>
                <div class="box-tools pull-right">
                    @include('backend.product_variants.partials.product-attribute-header-buttons')
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    @include("backend.product_variants.form")
                    <div class="edit-form-btn">
                        {{ link_to_route(
                                'admin.productVariants.index',
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
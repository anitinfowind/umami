@extends ('backend.layouts.app')
@section ('title', trans('Shipping Charge Calculation'))
@section('page-header')
    <h1>{{ trans('Shipping Charge Calculation') }}</h1>
@endsection
@section('content')
 {{ Form::model($shippingcharge,[
                'route' => ['admin.shippings.shippingcharge'],
                'class' => 'form-horizontal',
                'role' => 'form',
                'files'=>'true',
                ])
    }}
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
                trans('Service Days'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
  <select name="day" class="form-control" required="true">
  <option value="01">One Day</option>
  <option value="02">Two Day</option>
  <option value="03">Three Day</option>
  
</select>
        </div>
    </div>
    
    <div class="form-group  discountshow">
        {{ Form::label(
                'title',
                trans('From Zipcode'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
              {{ Form::text(
                    'from_zipcode',null,
                    [
                        'class' => 'form-control  box-size',
                        'placeholder' => trans('From Zipcode'),
                        'required'=>'required'
                    ]
                )
            }}

        </div>
    </div>
    
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('To Zipcode'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'to_zipcode',null,
                    [
                        'class' => 'form-control box-size','required'=>'required',
                        'placeholder' => trans('To Zip code')
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

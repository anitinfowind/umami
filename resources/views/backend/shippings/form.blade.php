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

            {{ Form::text(
                    'day',null,
                    [
                        'class' => 'form-control box-size','required'=>'required',
                        'placeholder' => trans('Service Day')
                    ]
                )
            }}
        </div>
    </div>
    
    <div class="form-group  discountshow">
        {{ Form::label(
                'title',
                trans('Service Name'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
              {{ Form::text(
                    'service_name',null,
                    [
                        'class' => 'form-control  box-size',
                        'placeholder' => trans('service name'),
                        'required'=>'required'
                    ]
                )
            }}

        </div>
    </div>
    
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('price'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'price',null,
                    [
                        'class' => 'form-control box-size','required'=>'required',
                        'placeholder' => trans('Price')
                    ]
                )
            }}
        </div>
    </div>
    <!--form control-->
</div>
@section("after-scripts")
    <script type="text/javascript">
        Backend.Pages.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');
  
    </script>
@endsection
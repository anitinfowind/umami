<div class="box-body">
    <div class="form-group">
        {{ Form::label(
                'Discount Price',
                trans('Discount Price'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">

            {{ Form::text(
                    'discount_price',
                    null,
                    [
                        'class' => 'form-control box-size','required'=>'required',
                        'placeholder' => trans('Discount Price')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'Reward Point',
                trans('Reward Point'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">

            {{ Form::text(
                    'earn_point',
                    null,
                    [
                        'class' => 'form-control box-size','required'=>'required',
                        'placeholder' => trans('Reward Point')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'status',
                trans('validation.attributes.backend.slider.status'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
            <div class="control-group">
                <label class="control control--checkbox">
                    @if(isset($reward->is_active))
                       {{ Form::checkbox('is_active', 1, $reward->is_active == ACTIVE ? true :false) }}
                    @else
                        {{ Form::checkbox('is_active', 1, true) }}
                    @endif
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
    </div>
 
</div>
@section("after-scripts")
    <script type="text/javascript">
        Backend.Pages.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');

    </script>
@endsection
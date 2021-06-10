<div class="box-body">
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Coupon Code'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">

            {{ Form::text(
                    'coupon_code',null,
                    [
                        'class' => 'form-control box-size','required'=>'required',
                        'placeholder' => trans('Coupon Code')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Discount Type'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
             {{ Form::select(
                        'discount_type',
                        [''=> 'Select discount type','FIXED'=>'Fixed','PERCENTAGE'=>'Percentage'],null,
                        [
                          'class' => 'form-control box-size discounttype','required'=>'required'
                        ]
                    )
             }}
        </div>
    </div>
    <div class="form-group  discountshow">
        {{ Form::label(
                'title',
                trans('Discount'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
              {{ Form::text(
                    'discount',null,
                    [
                        'class' => 'form-control number-field discountperc box-size',
                        'placeholder' => trans('Discount'),
                        'maxlength'=>3,
                        'autocomplete'=>'off',
                        'required'=>'required'
                    ]
                )
            }}

        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Start Date'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
             {{ Form::date(
                    'start_date',
                    null,
                    [
                      'class' => 'form-control box-size start_date','placeholder' => trans('Start Date')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('End Date'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
             {{ Form::date(
                    'end_date',null,
                    [
                      'class' => 'form-control end_date box-size','required'=>'required','placeholder' => trans('End Date')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Min price'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'min_price',null,
                    [
                        'class' => 'form-control box-size','required'=>'required',
                        'placeholder' => trans('Min Price')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Max person'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'max_users',null,
                    [
                        'class' => 'form-control box-size','required'=>'required',
                        'placeholder' => trans('Max person')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('description', trans('Description'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10 mce-box">
            {{ Form::textarea('description',  isset($coupons->description) ? $coupons->description : '', ['class' => 'form-control box-size']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->
</div>
@section("after-scripts")
    <script type="text/javascript">
        Backend.Pages.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');
  /*$('.discounttype').on('change', function() {
    var id= $(this).val();
    if (id == 'PERCENTAGE') {
       $('.discountperc').attr('required',true);
       $('.discountshow').show();
   }else if (id == 'FIXED'){
       $('.discountperc').attr('required',false);
       $('.discountshow').show();
   }else{
    $('.discountperc').attr('required',false);
       $('.discountshow').hide();
   } 
 });*/
    </script>
@endsection
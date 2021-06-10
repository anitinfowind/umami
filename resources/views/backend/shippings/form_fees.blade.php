<div class="box-body">
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Title'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">

            {{ Form::text(
                    'title',null,
                    [
                        'class' => 'form-control box-size','required'=>'required',
                        'placeholder' => trans('Title')
                    ]
                )
            }}
        </div>
    </div>
    
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Min Distance'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
              {{ Form::text(
                    'min_distance',null,
                    [
                        'class' => 'form-control  box-size',
                        'placeholder' => trans('Min Distance')
                    ]
                )
            }}

        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Max Distance'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
              {{ Form::text(
                    'max_distance',null,
                    [
                        'class' => 'form-control  box-size',
                        'placeholder' => trans('Max Distance')
                    ]
                )
            }}

        </div>
    </div>
    
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Alaska 1 Day'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'alaska_1day',null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Alaska 1 Day')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Hawai 1 Day'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'hawai_1day',null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Hawai 1 Day')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Service 1 Day'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::select(
                    'service_1',
                    [''=>'Select Service',
                    '01'=>'1 Day Air service',
                    '02'=>'2 Day Air service',
                    '03'=>'3 Day Ground Service',
                    ],
                    null,
                    [
                      'class' => 'form-control  box-size'
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Alaska 2 Day'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'alaska_2day',null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Alaska 2 Day')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Hawai 2 Day'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'hawai_2day',null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Hawai 2 Day')
                    ]
                )
            }}
        </div>
    </div>
     <div class="form-group">
        {{ Form::label(
                'title',
                trans('Service 2 Day'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::select(
                    'service_2',
                    [''=>'Select Service',
                    '01'=>'1 Day Air service',
                    '02'=>'2 Day Air service',
                    '03'=>'3 Day Ground Service',
                    ],
                    null,
                    [
                      'class' => 'form-control  box-size'
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Alaska 3 Day'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'alaska_3day',null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Alaska 3 Day')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Hawai 3 Day'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'hawai_3day',null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Hawai 3 Day')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Service 3 Day'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::select(
                    'service_3',
                    [''=>'Select Service',
                    '01'=>'1 Day Air service',
                    '02'=>'2 Day Air service',
                    '03'=>'3 Day Ground Service',
                    ],
                    null,
                    [
                      'class' => 'form-control  box-size'
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Alaska Above 3 Days'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'alaska_above',null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Alaska Above 3 Days')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Hawai Above 3 Days'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::text(
                    'hawai_above',null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Hawai Above 3 Days')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Service 3 Day Above'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
          {{ Form::select(
                    'service_above',
                    [''=>'Select Service',
                    '01'=>'1 Day Air service',
                    '02'=>'2 Day Air service',
                    '03'=>'3 Day Ground Service',
                    ],
                    null,
                    [
                      'class' => 'form-control  box-size'
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
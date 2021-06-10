<div class="box-body">
    <div class="form-group">
        {{ Form::label(
                'name',
                trans('Name'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
            {{ Form::text(
                    'name',
                    isset($regions->name) ? $regions->name : '',
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Name')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'status',
                trans('validation.attributes.backend.brand.status'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
            <div class="control-group">
                <label class="control control--checkbox">
                    @if(isset($regions->is_active))
                        {{ Form::checkbox('is_active', 1, $regions->isActive() == ACTIVE ? true :false) }}
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
        Backend.Blog.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');

    </script>
@endsection
<div class="box-body">
    <div class="form-group">
        <label class = 'col-lg-2 control-label required'>Name</label>
        <div class="col-lg-10">
            {{ Form::text(
                    'name',
                    isset($category->name) ? $category->name : '',
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Name'),
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        <label class = 'col-lg-2 control-label required'>Description</label>
        <div class="col-lg-10 mce-box">
            {{ Form::textarea(
                    'description',
                    isset($category->description) ? $category->description : '',
                    [
                        'class' => 'form-control box-size'
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        <label class = 'col-lg-2 control-label'>Status</label>
        <div class="col-lg-10">
            <div class="control-group">
                <label class="control control--checkbox">
                    @if(isset($category->is_active))
                        {{ Form::checkbox('is_active', 1, $category->is_active == ACTIVE ? true :false) }}
                    @else
                        {{ Form::checkbox('is_active', 1, true) }}
                    @endif
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
    </div>
</div>
@section('after-scripts')
    <script type="text/javascript">
        Backend.Faq.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');
    </script>
@endsection
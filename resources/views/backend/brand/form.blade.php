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
                    isset($brands->name) ? $brands->name : '',
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
                'content',
                trans('validation.attributes.backend.slider.content'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
           )
        }}
        <div class="col-lg-10 mce-box">
            {{ Form::textarea(
                    'description',
                    isset($brands->description) ? $brands->description : '',
                    [
                        'class' => 'form-control',
                        'placeholder' => trans('validation.attributes.backend.slider.content')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'image',
                trans('image'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        @if(!empty($brands->image))
            @if ($brands->image() !='' && File::exists(BRAND_ROOT_PATH.$brands->image()))
                <?php $brandImage	=	BRAND_URL.$brands->image(); ?>
            @else
                <?php $brandImage	=	WEBSITE_IMG_URL.'no-image.png'; ?>
            @endif
            <div class="col-lg-1">
                <img src="{{ $brandImage  }}" height="80" width="80">
            </div>
            <div class="col-lg-5">
                <div class="custom-file-input">
                    <input
                            type="file"
                            name="file"
                            id="file-1"
                            class="inputfile inputfile-1"
                            data-multiple-caption="{count} files selected"
                            accept="image/*"
                    />
                    <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
                </div>
            </div>
        @else
            <div class="col-lg-5">
                <div class="custom-file-input">
                    <input
                            type="file"
                            name="file"
                            id="file-1"
                            class="inputfile inputfile-1"
                            data-multiple-caption="{count} files selected"
                            accept="image/*"
                    />
                    <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
                </div>
            </div>
        @endif
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
                    @if(isset($brands->is_active))
                        {{ Form::checkbox('is_active', 1, $brands->isActive() == ACTIVE ? true :false) }}
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
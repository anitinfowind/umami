<div class="box-body">
    <div class="form-group">
        {{ Form::label(
                'name',
                trans('validation.attributes.backend.blogs.title'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
            {{ Form::text(
                    'name',
                    null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('validation.attributes.backend.blogs.title'),
                        'required' => 'required'
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'publish_datetime',
                trans('validation.attributes.backend.blogs.publish'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}

        <div class="col-lg-10">
            @if(!empty($blog->publish_datetime))
                {{ Form::text(
                        'publish_datetime',
                        \Carbon\Carbon::parse($blog->publish_datetime)->format('m/d/Y h:i a'),
                        [
                            'class' => 'form-control datetimepicker1 box-size',
                            'placeholder' => trans('validation.attributes.backend.blogs.publish'),
                            'required' => 'required',
                            'id' => 'datetimepicker1'
                        ]
                    )
                }}
            @else
                {{ Form::text(
                        'publish_datetime',
                        null,
                        [
                            'class' => 'form-control datetimepicker1 box-size',
                            'placeholder' => trans('validation.attributes.backend.blogs.publish'),
                            'required' => 'required',
                            'id' => 'datetimepicker1'
                        ]
                    )
                }}
            @endif
        </div>
    </div>

    <div class="form-group">
        {{ Form::label(
                'featured_image',
                trans('validation.attributes.backend.blogs.image'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        @if(isset($blog))
            <div class="col-lg-1">
                @if ($blog->image() !== '' && File::exists(BLOG_ROOT_PATH.$blog->image()))
                    <?php $image = BLOG_URL . $blog->image(); ?>
                @else
                    <?php $image = WEBSITE_IMG_URL . 'no-image.png'; ?>
                @endif
                <img src="{{ $image  }}" height="80" width="80">
            </div>
        @endif
        <div class="col-lg-5">
            <div class="custom-file-input">
                <input
                        type="file"
                        name="featured_image"
                        id="file-1"
                        class="inputfile inputfile-1"
                        data-multiple-caption="{count} files selected"
                />
                <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
            </div>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'content',
                trans('validation.attributes.backend.blogs.content'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10 mce-box">
            {{ Form::textarea(
                    'content',
                    null,
                    [
                        'class' => 'form-control',
                        'placeholder' => trans('validation.attributes.backend.blogs.content')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'meta_title',
                trans('validation.attributes.backend.blogs.meta-title'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
            {{ Form::text(
                    'meta_title',
                    null,
                    [
                        'class' => 'form-control box-size ',
                        'placeholder' => trans('validation.attributes.backend.blogs.meta-title')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'cannonical_link',
                trans('validation.attributes.backend.blogs.cannonical_link'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
            {{ Form::text(
                    'cannonical_link',
                    null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('validation.attributes.backend.blogs.cannonical_link')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'meta_keywords',
                trans('validation.attributes.backend.blogs.meta_keyword'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
            {{ Form::text(
                    'meta_keywords',
                    null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('validation.attributes.backend.blogs.meta_keyword')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'meta_description',
                trans('validation.attributes.backend.blogs.meta_description'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}

        <div class="col-lg-10 mce-box">
            {{ Form::textarea(
                    'meta_description',
                    null,
                    [
                        'class' => 'form-control',
                        'placeholder' => trans('validation.attributes.backend.blogs.meta_description')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'status',
                trans('validation.attributes.backend.blogs.status'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
            {{ Form::select(
                    'status',
                    $status,
                    null,
                    [
                        'class' => 'form-control select2 status box-size',
                        'placeholder' => trans('validation.attributes.backend.blogs.status'),
                        'required' => 'required'
                    ]
                )
            }}
        </div>
    </div>
</div>

@section("after-scripts")
    <script type="text/javascript">
        Backend.Blog.selectors.GenerateSlugUrl = "{{route('admin.generate.slug')}}";
        Backend.Blog.selectors.SlugUrl = "{{url('/')}}";
        Backend.Blog.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');
    </script>
@endsection
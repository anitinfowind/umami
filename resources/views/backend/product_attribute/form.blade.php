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
                    null,
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
                'icon',
                trans('Icon'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
            {{ Form::file(
                    'icon',
                    null,
                    [
                        'class' => 'form-control box-size'
                        
                    ]
                )
            }}
			@if(isset($productAttributes->icon))
				@if(!empty($productAttributes->icon) &&   File::exists(ATTRIBUTE_ROOT_PATH.$productAttributes->icon))
					<?php $image = ATTRIBUTE_URL.$productAttributes->icon; ?>
				@else
					<?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
				@endif
				<img class="resto product_list" src="{{ $image }}" alt="">
			@endif			 
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
                    @if(isset($productAttributes->is_active))
                        {{ Form::checkbox('is_active', 1, $productAttributes->isActive() == ACTIVE ? true :false) }}
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
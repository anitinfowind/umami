<div class="box-body">
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Title'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">

            {{ Form::text(
                    'title',
                     null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Title')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('file', trans('Banner Image'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10 mce-box">
            {!! Form::file('banner_image', ['class'=>'form-control box-size'] )!!}
            <p></p>
            @if(isset($banners->image) && !empty($banners->image))
             <?php
               $info = pathinfo(public_path('/uploads/banner/').$banners->image);
                  $ext = $info['extension'];
                  ?>
               @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
                 @if(isset($banners->image) && File::exists(public_path('/uploads/banner/').$banners->image))
                   <img style="width: 200px" src="{{url('uploads/banner/'.$banners->image)}}">
                 @endif
                @else
                    <video width="200px" height="150px" muted loop  controls> 
                    <source src="{{URL::to('uploads/banner/'.$banners->image)}}" type="video/mp4">
                    </video>
                @endif
              @endif  
        </div><!--col-lg-10-->=
    </div><!--form control-->
    <div class="form-group">
        {{ Form::label(
                'Button',
                trans('Button URL '),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">

            {{ Form::text(
                    'button_url',
                     null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Button Url')
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
                    @if(isset($banners->is_active))
                        {{ Form::checkbox('is_active', 1, $banners->is_active == ACTIVE ? true :false) }}
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
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
        {{ Form::label('file', trans('Video'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10 mce-box">
            {!! Form::file('video', ['class'=>'form-control box-size'] )!!}
            <p></p>
            @if(isset($banners->video) && !empty($banners->video))
             <?php
               $info = pathinfo(public_path('/uploads/banner/').$banners->video);
                  $ext = $info['extension'];
                  ?>
               @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
                 @if(isset($banners->video) && File::exists(public_path('/uploads/banner/').$banners->video))
                   <img style="width: 200px" src="{{url('uploads/banner/'.$banners->video)}}">
                 @endif
                @else
                    <video width="200px" height="150px" muted loop  controls> 
                    <source src="{{URL::to('public/uploads/banner/'.$banners->video)}}" type="video/mp4">
                    </video>
                @endif
              @endif  
        </div><!--col-lg-10-->
    </div><!--form control-->
   
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
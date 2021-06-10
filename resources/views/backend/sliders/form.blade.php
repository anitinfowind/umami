<div class="box-body">
    <div class="form-group">
        {{ Form::label(
                'name',
                trans('validation.attributes.backend.slider.title'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
            {{ Form::text(
                    'name',
                    isset($sliders->title) ? $sliders->title : '',
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('validation.attributes.backend.slider.title')
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
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10 mce-box">
            {{ Form::textarea(
                    'description',
                    null,
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
                'slider_image',
                trans('validation.attributes.backend.slider.image'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        @if(isset($sliders))
            <div class="col-lg-1">
               @php  $info = pathinfo(SLIDER_ROOT_PATH.$sliders->slider_image);
                    $ext = $info['extension'];
               @endphp
                  @if($ext=='mp4')
                    <?php $video = SLIDER_URL . $sliders->slider_image; ?>
                    <video width="100px" height="80px" muted loop controls autoplay>
                      <source src="{{$video}}" type="video/mp4">
                    </video>
                  @else
                    @if ($sliders->slider_image !== '' && File::exists(SLIDER_ROOT_PATH.$sliders->slider_image))
                        <?php $image = SLIDER_URL . $sliders->slider_image; ?>
                    @else
                        <?php $image = WEBSITE_IMG_URL . 'no-image.png'; ?>
                    @endif
                    <img src="{{ $image  }}" height="80" width="80">
                  @endif  
            </div>
        @endif
        <div class="col-lg-5">
            <div class="custom-file-input">
                <input
                        type="file"
                        name="slider_image"
                        id="file-1"
                        class="inputfile inputfile-1"
                        data-multiple-caption="{count} files selected"
                />
                <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
            </div>
        </div>
    </div>
    @if(isset($sliders))
      @php  $type = $sliders->type;            
       @endphp
        @if($type == 'video') 
             <!-- <input type="radio" name="answer"  value="no" style="margin-left: 40px;" />&nbsp;&nbsp;No <br><br>
             <input type="radio" name="answer" che cked="checked" value="video" style="margin-left: 40px;"/>&nbsp;&nbsp;Video File<br><br>-->
        @else
            <!--  <input type="radio" name="answer" checked="checked"  value="no" style="margin-left: 40px;" />&nbsp;&nbsp;No <br><br>
             <input type="radio" name="answer"  value="video" style="margin-left: 40px;"/>&nbsp;&nbsp;Video File<br><br> -->
        @endif
        @else
            <!--  <input type="radio" name="answer" checked="checked"  value="no" style="margin-left: 40px;" />&nbsp;&nbsp;No <br><br>
             <input type="radio" name="answer"  value="video" style="margin-left: 40px;"/>&nbsp;&nbsp;Video File<br><br> -->
    @endif    

     @if(isset($sliders))
            <div class="col-lg-1">
               @php  $info = pathinfo(SLIDER_ROOT_PATH.$sliders->slider_video);
                    $ext = $info['extension'];
               @endphp
                  @if($ext=='mp4')
                    <?php $video = SLIDER_URL . $sliders->slider_video; ?>
                    <!-- <video width="100px" height="80px" muted loop controls autoplay>
                      <source src="{{$video}}" type="video/mp4">
                    </video> -->
                  @else
                    @if ($sliders->slider_video !== '' && File::exists(SLIDER_ROOT_PATH.$sliders->slider_video))
                        <?php //$image = SLIDER_URL . $sliders->slider_video; ?>
                    @else
                        <?php //$image = WEBSITE_IMG_URL . 'no-image.png'; ?>
                    @endif
                    <!-- <img src="{{ $image  }}" height="80" width="80"> -->
                  @endif  
            </div>
        @endif
     
     <!-- <div class="form-group" style="display:none;" id="otherAnswer">
     <div class="col-lg-5">
            <div class="custom-file-input">
                <input
                        type="file"
                        name="slider_video"
                        id="file-2"
                        class="inputfile inputfile-1"
                        accept="video/*"
                />
                <label for="file-2"><i class="fa fa-upload"></i><span>Choose a video</span></label>
            </div>
      </div>
     </div> -->

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
                    @if(isset($sliders->status))
                        {{ Form::checkbox('status', 1, $sliders->status == 1 ? true :false) }}
                    @else
                        {{ Form::checkbox('status', 1, true) }}
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

    <script>
    //  $(document).ready(function(){
    //    $("input[type='radio']").change(function(){
    //      if($(this).val()=="video")
    //       {
    //        $("#otherAnswer").show();
    //       }
    //      else
    //       {
    //       $("#otherAnswer").hide();
    //       }
    //   });
    //    //Get
    //    var value = $("input[type='radio']").val();

    //    if(value =="video")
    //       {
    //        $("#otherAnswer").show();
    //     }
    // });
  </script>

@endsection
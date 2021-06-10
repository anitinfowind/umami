<div class="box-body">
    <div class="form-group">
        {{ Form::label('Title', trans('Title'), ['class' => 'col-lg-2 control-label required']) }}
        <input type="hidden" name="latitude" id="latitude" value="{{isset($videos->latitude)?$videos->latitude:''}}">
        <input type="hidden" name="longitude" id="longitude" value="{{isset($videos->longitude)?$videos->longitude:''}}">
        <input type="hidden" name="city" id="locality" value="{{isset($videos->city)?$videos->city:''}}">
        <input type="hidden" name="country" id="country" value="{{isset($videos->country)?$videos->country:''}}">
        <input type="hidden" name="state" id="administrative_area_level_1" value="{{isset($videos->state)?$videos->state:''}}">
        <div class="col-lg-10">
            {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('Title'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
        {{ Form::label('Video Type', trans('Video Type'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
           <input type="radio" class="videotype" name="video_type" value="VIDEO" required="" @if(isset($videos)&& $videos->video_type=='VIDEO') checked="" @endif> Video 
           <input type="radio"class="videotype"  name="video_type" value="EMBEDDED_URL" required="" @if(isset($videos)&& $videos->video_type=='EMBEDDED_URL') checked="" @endif> Embedded
        </div><!--col-lg-10-->
    </div><!--form control-->
     
     <div class="form-group video_show"  @if(isset($videos)&& $videos->video_type=='VIDEO')  @else style="display: none;" @endif>
          {{ Form::label('video', trans('Videos'), ['class' => 'col-lg-2 control-label'])
          }}

          <div class="col-lg-10">
            <div class="custom-file-input">
              {!! Form::file('video', array('class'=>'form-control inputfile inputfile-1' )) !!}
              <label for="video">
                <i class="fa fa-upload"></i>
                <span>Choose a video</span>
              </label>
            </div>
            <div class="img-remove-favicon">
              @if(isset($videos->video) && $videos->video_type=='VIDEO')
              <video width="320" height="240" controls>
                <source src="{{url('uploads/video/'.$videos->video) }}" type="video/mp4">
              </video>
              @endif
            </div>
          </div>
     </div>
     <div class="form-group embedded_show" @if(isset($videos)&& $videos->video_type=='EMBEDDED_URL')  @else style="display: none;" @endif>
        {{ Form::label('Embedded', trans('Embedded URl'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('embedded_url', null, ['class' => 'form-control box-size', 'placeholder' => trans('Embedded URl')]) }}
          @if(isset($videos->embedded_url))
            <div class="img-remove-favicon">
              <iframe width="320" height="240" src="{{$videos->embedded_url}}">
              </iframe>
            </div>
          @endif  
        </div>
    </div>
     <div class="form-group">
        {{ Form::label('Location', trans('Location'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('location', null, ['class' => 'form-control box-size','id'=>'location', 'placeholder' => trans('Location'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
                    {{ Form::label('description', trans('validation.attributes.backend.pages.description'), ['class' => 'col-lg-2 control-label required']) }}

                    <div class="col-lg-10">
                        {{ Form::textarea('description', null,['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.description')]) }}
                    </div><!--col-lg-3-->
                </div><!--form control-->

    <div class="form-group">
        {{ Form::label('status', trans('validation.attributes.backend.faqs.status'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10">
            <div class="control-group">
                <label class="control control--checkbox">
                    @if(isset($videos->is_active))
                        {{ Form::checkbox('is_active', 1, $videos->is_active == ACTIVE ? true :false) }}
                    @else
                        {{ Form::checkbox('is_active', 1, true) }}
                    @endif
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div><!--col-lg-3-->
    </div><!--form control-->
</div>
@section('after-scripts')
 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI&libraries=places&sensor=false">
 </script> 
<script src='/js/backend/bootstrap-tabcollapse.js'></script>
    <script type="text/javascript">
          Backend.Pages.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');

 $('.videotype').click(function() {
   var type= $(this).val();
    if(type=='VIDEO') {
      $('.video_show').show();
      $('.embedded_show').hide();
    }
    else {
      $('.video_show').hide();
      $('.embedded_show').show();
    }
 });

    </script>


@endsection
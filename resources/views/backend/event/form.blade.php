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
                    'title',
                    isset($events->title) ? $events->title : '',
                    [
                        'class' => 'form-control box-size','required'=>'required',
                        'placeholder' => trans('Title')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('description', trans('Description'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10 mce-box">
            {{ Form::textarea('description',  isset($events->description) ? $events->description : '', ['class' => 'form-control box-size']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
        {{ Form::label('status', trans('Status'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            <?php
            $opt1 = $opt2 = '';
            if(isset($events->status)) {
                if($events->status == '1') $opt1 = 'selected="selected"';
                if($events->status == '0') $opt2 = 'selected="selected"';
            }
            ?>
            <select class="form-control box-size" name="status">
                <option value="1" {{ $opt1 }}>Active</option>
                <option value="0" {{ $opt2 }}>Inactive</option>
            </select>
        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
        {{ Form::label('file', trans('Event Image'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10 mce-box">
            {!! Form::file('event_image', ['class'=>'form-control box-size'] )!!}
            <p></p>
             @if(isset($events->image) && File::exists(EVENT_ROOT_PATH.$events->image))
                 <?php $image = EVENT_URL.$events->image; ?>
              @else
                  <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
             @endif
               <img style="width: 50px" src="{{ $image }}">
             
        </div><!--col-lg-10-->=
    </div><!--form control-->
</div>
@section("after-scripts")
    <script type="text/javascript">
        Backend.Pages.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');

    </script>
@endsection
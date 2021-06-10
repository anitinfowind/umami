<div class="box-body">
  <div class="form-group">
        {{ Form::label(
                'title',
                trans('Restaurant Name'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
          <select name="restaurant_id" class="form-control" required="">
            <option value=""> Select Restaurant</option>
            @foreach($restaurants as $restaurant)
            <option value="{{$restaurant->id}}" @if(isset($chefs) && !empty($chefs) && $chefs->restaurant_id==$restaurant->id) selected @endif>{{$restaurant->name}}</option>
            @endforeach
          </select>
         
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'title',
                trans('Name'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">

            {{ Form::text(
                    'name',null,
                    [
                        'class' => 'form-control box-size','required'=>'required',
                        'placeholder' => trans('Name')
                    ]
                )
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
                'Designation',
                trans('Designation'),
                [
                    'class' => 'col-lg-2 control-label'
                ]
            )
        }}
        <div class="col-lg-10">
             {{ Form::text(
                    'designation',null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Designation')
                    ]
                )
            }}
        </div>
    </div>
<!--     <div class="form-group  discountshow">
        {{ Form::label(
                'email',
                trans('Email'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">
              {{ Form::email(
                    'email',null,
                    [
                        'class' => 'form-control box-size',
                        'placeholder' => trans('Email'),
                        'autocomplete'=>'off',
                        'required'=>'required'
                    ]
                )
            }}
        </div>
    </div> -->
    <div class="form-group">
        {{ Form::label('description', trans('Description'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10 mce-box">
            {{ Form::textarea('description',  isset($chefs->description) ? $chefs->description : '', ['class' => 'form-control box-size']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
        {{ Form::label('Show/Hide Home Page ', trans('how/Hide Home Page'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10 mce-box">
         {{ Form::select(
                'is_home_show',
                [
                    '' => 'Select',
                    'active' => 'Show',
                    'inactive' => 'Hide'
                ],
                null,
                [
                    'class' => 'form-control is_home_show tags box-size'
                ]
            )
        }}
        </div><!--col-lg-10-->
    </div>
    <div class="form-group">
        {{ Form::label('Status ', trans('Status'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10 mce-box">
         {{ Form::select(
                'status',
                [
                    '1' => 'Active',
                    '0' => 'Inactive'
                ],
                null,
                [
                    'class' => 'form-control is_home_show tags box-size'
                ]
            )
        }}
        </div><!--col-lg-10-->
    </div>
    <div class="form-group">
        {{ Form::label(
                'image',
                trans('Image'),
                [
                    'class' => 'col-lg-2 control-label required'
                ]
            )
        }}
        <div class="col-lg-10">

           <input type="file" name="image">
           <br/>
            @if(isset($chefs) && !empty($chefs->image))
            <img src="{{CHEF_URL.$chefs->image}}" style="max-width: 200px; max-height: 200px;">
            @endif
        </div>
    </div>
</div>
@section("after-scripts")
    <script type="text/javascript">
        Backend.Pages.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');

    </script>
@endsection
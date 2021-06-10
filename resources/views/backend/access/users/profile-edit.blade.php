@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.access.users.edit-profile') }}
    </h1>
@endsection

@section('content')
	{{ Form::model(auth::user()->id, ['route' => 'admin.profile.update', 'class' => 'form-horizontal', 'method' => 'PATCH','files'=>'true']) }}

     <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.access.users.edit-profile') }}</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                {{ Form::label('first_name', trans('validation.attributes.frontend.register-user.firstName'), ['class' => 'col-lg-2 control-label']) }}
                <div class="col-lg-10">
                    {{ Form::input('text', 'first_name', access()->user()->first_name, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.frontend.register-user.firstName')]) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('last_name', trans('validation.attributes.frontend.register-user.lastName'), ['class' => 'col-lg-2 control-label']) }}
                <div class="col-lg-10">
                    {{ Form::input('text', 'last_name', access()->user()->last_name, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.frontend.register-user.firstName')]) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('Image', trans('Profile Image'), ['class' => 'col-lg-2 control-label']) }}
                <div class="col-lg-10">
                    {{ Form::file('image',['class' => 'form-control box-size']) }}
                </div>
              </div>
              <div class="form-group">
                 <p class="col-lg-2 control-label"></p>
                <div class="col-lg-10">
                
                 @if(file_exists(public_path('uploads/user/'. access()->user()->image)))
                 <img src="{{ url('uploads/user/'. access()->user()->image) }}" class="img-circle" alt="User Avatar" />
                 @else
                 <img src="{{ url('/images/profile-user-img.png') }}" class="img-circle" alt="User Avatar" />

                 @endif
            </div>
          </div>

            <div class="form-group">
                <div class="col-lg-10 col-md-offset-4">
                    {{ Form::submit(trans('labels.general.buttons.update'), ['class' => 'btn btn-primary', 'id' => 'update-profile']) }}
                </div>
            </div>
        </div>
    </div>
{{ Form::close() }}
@endsection
@section('after-scripts')

<script type="text/javascript">
    $(document).ready(function() {
        Backend.Profile.init();
    });
</script>
@endsection

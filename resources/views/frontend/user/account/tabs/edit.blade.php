{{ Form::open([
            'url' => 'update-profile',
            'class' => 'form-horizontal',
            'files' => 'true',
            'id' => 'update_profile'
        ]
    )
}}
    <div class="update_profile_error_div"></div>
    <div class="row">
        <div class="form-group col-md-6">
            <label class = 'col-md-12 control-label'>First Name<!-- <span class="required">*</span> --></label>
            <div class="col-md-12">
                {{ Form::text(
                        'first_name',
                        auth()->user()->firstName(),
                        [
                            'class' => 'form-control novalidate',
                            'placeholder' => trans('validation.attributes.frontend.register-user.firstName')
                        ]
                    )
                }}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class = 'col-md-12 control-label'>Last Name<!-- <span class="required">*</span> --></label>
            <div class="col-md-12">
                {{ Form::text(
                        'last_name',
                        auth()->user()->lastName(),
                        [
                            'class' => 'form-control novalidate',
                            'placeholder' => trans('validation.attributes.frontend.register-user.lastName')
                        ]
                    )
                }}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class = 'col-md-12 control-label'>Email<span class="required">*</span></label>
            <div class="col-md-12">
                {{ Form::email(
                        'email',
                        auth()->user()->email(),
                        [
                            'class' => 'form-control',
                            'placeholder' => trans('validation.attributes.frontend.register-user.email'),
                            'readonly' => true
                        ]
                    )
                }}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class = 'col-md-12 control-label'>Phone No<!-- <span class="required">*</span> --></label>
            <div class="col-md-12">
                {{ Form::text(
                        'phone',
                        auth()->user()->phoneNo(),
                        [
                            'class' => 'form-control number-field novalidate',
                            'placeholder' => trans('Phone No'),
                            'maxlength'=>'10',
                            'id' => 'phone'
                        ]
                    )
                }}
                <span class="phone error-msg" style="color:red"></span>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class = 'col-md-12 control-label'>Profile Image</label>
            <div class="col-md-12 upload-img-div">
                {{ Form::file(
                        'image',
                        null
                    )
                }}
                @if(auth()->user()->image() !=='' && File::exists(USER_PROFILE_IMAGE_ROOT_PATH.auth()->user()->slug.DS.auth()->user()
                ->image()))
                    <img class="media-object" src="{{ USER_PROFILE_IMAGE_URL.auth()->user()->slug.DS.auth()->user()->image() }}">
                @else
                    <img class="media-object" src="{{ WEBSITE_IMG_URL }}profile-user-img.png">
                @endif
            </div>
            <br/>

        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button
                    class="btn order-btn"
                    id="update-profile"
                    onclick='formData("update_profile",false,false,"{{ url('account') }}")'
                    type="button"
            >
                Update
            </button>
        </div>
    </div>
{{ Form::close() }}
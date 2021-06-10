{{ Form::open([
            'url' => 'vendor-payment',
            'class' => 'form-horizontal',
            'files' => 'true',
            'id' => 'update_profile'
        ]
    )
}}
    <div class="update_profile_error_div"></div>
    <div class="row">
        <div class="form-group col-md-6">
            <label class = 'col-md-12 control-label'>First Name<span class="required">*</span></label>
            <div class="col-md-12">
                {{ Form::text(
                        'first_name',
                        auth()->user()->firstName(),
                        [
                            'class' => 'form-control',
                            'placeholder' => trans('validation.attributes.frontend.register-user.firstName')
                        ]
                    )
                }}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class = 'col-md-12 control-label'>Last Name<span class="required">*</span></label>
            <div class="col-md-12">
                {{ Form::text(
                        'last_name',
                        auth()->user()->lastName(),
                        [
                            'class' => 'form-control',
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
            <label class = 'col-md-12 control-label'>Phone No<span class="required">*</span></label>
            <div class="col-md-12">
                {{ Form::text(
                        'phone',
                        auth()->user()->phoneNo(),
                        [
                            'class' => 'form-control number-field',
                            'placeholder' => trans('Phone No'),
                            'maxlength'=>'10',
                            'id' => 'phone'
                        ]
                    )
                }}
                <span class="phone error-msg" style="color:red"></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button
                    class="btn order-btn"
                    id="update-profile"
                    onclick='formData("update_profile",false,false,false)'
                    type="button"
            >
                Update
            </button>
        </div>
    </div>
{{ Form::close() }}
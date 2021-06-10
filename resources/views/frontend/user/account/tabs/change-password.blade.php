{{ Form::open([
    'url' => 'change-password',
    'class' => 'form-horizontal',
    'id' => 'change_password'
    ])
}}
    <div class="change_password_error_div"></div>
    <div class="form-group">
        <label class = 'col-md-12 control-label'>Old Password<span class="required">*</span></label>
        <div class="col-md-6">
            {{ Form::input(
                    'password',
                    'old_password',
                    null,
                    [
                        'class' => 'form-control',
                        'placeholder' => trans('validation.attributes.frontend.register-user.old_password'),
                        'id' => 'old_password',
                    ]
                )
            }}
            <span class="old_password error-msg" style="color:red"></span>
        </div>
    </div>
    <div class="form-group">
        <label class = 'col-md-12 control-label'>New Password<span class="required">*</span></label>
        <div class="col-md-6">
            {{ Form::input(
                    'password',
                    'new_password',
                    null,
                    [
                        'class' => 'form-control',
                        'id' => 'new_password',
                        'placeholder' => trans('New Password')
                    ]
                )
            }}
            <span class="new_password error-msg" style="color:red"></span>
        </div>
    </div>
    <div class="form-group">
        <label class = 'col-md-12 control-label'>Confirm Password<span class="required">*</span></label>
        <div class="col-md-6">
            {{ Form::input(
                    'password',
                    'confirm_password',
                    null,
                    [
                        'class' => 'form-control',
                        'placeholder' => trans('Confirm Password'),
                        'id' => 'confirm_password',
                    ]
                )
            }}
            <span class="confirm_password error-msg" style="color:red"></span>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            {{ Form::button(
                    trans('labels.general.buttons.update'),
                    [
                        'class' => 'btn order-btn',
                        'id' => 'change-password',
                        'onclick' => 'passwordSubmit("change_password")'
                    ]
                )
            }}
        </div>
    </div>
{{ Form::close() }}

<script>
    function passwordSubmit(formId){
        var formData	=	jsValidation(formId,formId+'_error_div','yes','error_manual');
        if(formData){
            formSubmit(formId, 'Password', 'Your password has been successfully updated', false);
        }
    }
</script>
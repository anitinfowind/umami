{{ Form::open([
            'url' => 'email-setting',
            'class' => 'form-horizontal',
            'files' => 'true',
            'id' => 'update_profile'
        ]
    )
}}
    <div class="update_profile_error_div"></div>
    <div class="row">
        <div class="form-group col-md-6">
            <label class = 'col-md-12 control-label'>Email<span class="required">*</span></label>
            <div class="col-md-12">
                {{ Form::email(
                        'email',
                        auth()->user()->email(),
                        [
                            'class' => 'form-control',
                            'placeholder' => trans('Email'),
                            'id' => 'email'
                        ]
                    )
                }}
                <span class="email error-msg" style="color:red"></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button
                    class="btn order-btn"
                    id="update-profile"
                    onclick='formData("update_profile",false,false,"{{ url('site-setting') }}")'
                    type="button"
            >
                Update
            </button>
        </div>
    </div>
{{ Form::close() }}
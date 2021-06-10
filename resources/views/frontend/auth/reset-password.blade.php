@extends('frontend.layouts.app')
@section('content')

    <div class="login-section">
        <div class="container">
            <div class="col-sm-12 mx-auto">
                <div class="display-section login-section">
                    <div class="display-description">
                        <ul class="nav nav-tabs">
                            <li class="nav-item"></li>
                        </ul>
                        <div class="tab-content">
                            <div id="Login" class="tab-pane active">
                                <h2>Reset Password</h2>
                                {{ Form::open([
                                        'url' => 'reset-password',
                                        'class' => 'form-horizontal',
                                        'id' => 'reset_password_form'
                                    ])
                                }}
                                <div class="reset_password_form_error_div"></div>
                                {{ Form::hidden('forgotPasswordString', $forgotPasswordString) }}
                                <div class="form-group">
                                    <div class="col-md-12">
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
                                    <div class="col-md-12">
                                        {{ Form::input(
                                                'password',
                                                'confirm_password',
                                                null,
                                                [
                                                    'class' => 'form-control',
                                                    'id' => 'conf_password',
                                                    'placeholder' => trans('Confirm Password')
                                                ]
                                            )
                                        }}
                                        <span class="conf_password error-msg" style="color:red"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 text-center">
                                        <button id="login-form"
                                                onclick='formData("reset_password_form", false, false, "{{ url('/') }}")'
                                                type="button"
                                                class="catg-btn" >
                                            {{ trans('Reset') }}
                                        </button>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

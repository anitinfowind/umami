@extends('frontend.layouts.layout')
@section('content')

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Forgot Password</li>
    </ol>
  </div>
</nav>

<h1 style="display: none;">Forgot Password</h1>

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
                                <h2>Forgot Password</h2>
                                {{ Form::open([
                                        'url' => 'forgot-password',
                                        'class' => 'form-horizontal',
                                        'id' => 'login_form'
                                    ])
                                }}
                                <div class="login_form_error_div"></div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        {{ Form::email(
                                                'email',
                                                null,
                                                [
                                                    'class' => 'form-control',
                                                    'id' => 'email',
                                                    'placeholder' => trans('Email')
                                                ]
                                            )
                                        }}
                                        <span class="email error-msg" style="color:red"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 text-center">
                                        <button id="login-form"
                                                onclick='formData("login_form", "Forgot Password", "Success! Password Reset Details have been sent to your email address.", false)'
                                                type="button"
                                                class="catg-btn" >
                                            {{ trans('Forgot Password') }}
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
@extends('frontend.layouts.app')
@section('content')
	<?php $segment = \Request::segment(1); ?>
	<div class="login-section">
		<div class="container">
			<div class="col-sm-12 mx-auto">
				<div class="display-section login-section">
					<div class="display-description">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link @if($segment === 'login') active @endif" data-toggle="tab" href="#Login">Log In</a>
							</li>
							<li class="nav-item">
								<a class="nav-link @if($segment === 'vendor-register') active @endif" data-toggle="tab" href="#Registro">Sign Up</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="Login" class="tab-pane @if($segment === 'login') active @endif">
								<h2>VENDOR LOG IN</h2>
								{{ Form::open([
                                		'route' => 'frontend.auth.login',
                                		'class' => 'form-horizontal',
                                		'id' => 'login_form'
                                	])
                                }}
									<div class="login_form_error_div"></div>
									<div class="form-group">
										<div class="col-md-12">
											{{ Form::text(
													'email',
													null,
													[
														'class' => 'form-control',
														'id' => 'email-login',
														'placeholder' => trans('Email / Phone No')
													]
												)
											}}
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											{{ Form::input(
													'password',
													'password',
													null,
													[
														'class' => 'form-control',
														'id' => 'password_login',
														'placeholder' => trans('validation.attributes.frontend.register-user.password')
													]
												)
											}}
											<span class="password_login error-msg" style="color:red"></span>
										</div>
									</div>
									<div class="form-group col-md-12">
										<div class="row">
										<div class="col-md-6">
											<div class="custom-control custom-checkbox mb-3">
												<input type="checkbox" name="remember" class="custom-control-input" id="customCheck1">
												<label class="custom-control-label" for="customCheck1">Remember password</label>
											</div>
										</div>
										<div class="col-md-6">
											<a class="forgot-pass" href="{{url('forgot-password')}}">Forgot Password</a>
										</div>
									</div>
									</div>
									<div class="form-group">
										<div class="col-md-12 text-center">
											<button id="login-form"
													onclick='formLogin("login_form")'
													type="button"
													class="catg-btn" >
												{{ trans('labels.frontend.auth.login_button') }}
											</button>
										</div>
									</div>
								{{ Form::close() }}
								<div class="col-md-12 text-center">
									<hr class="my-4">
								</div>
								<div class="form-group">
									<div class="col-md-12 text-center">
										<button class="btn btn-lg btn-google btn-block text-uppercase" type="button"><i class="fa fa-google
										mr-2"></i>
											Sign in with Google</button>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12 text-center">
										<button class="btn btn-lg btn-facebook btn-block text-uppercase" type="button"><i class="fa fa-facebook-f
										mr-2"></i> Sign in with Facebook</button>
									</div>
								</div>
							</div>
							<div id="Registro" class="tab-pane @if($segment === 'vendor-register') active @endif">
								<h2>VENDOR Sign Up</h2>
								{{ Form::open([
                                		'route' => 'frontend.auth.register',
                                		'class' => 'form-horizontal',
                                		'id'=>'register_form'
                                	])
                                }}
									<div class="register_form_error_div"></div>
                  {{ Form::hidden(
                          'role',
                          '2',
                          [
                            'class' => 'form-control',
                           
                          ]
                        )
                      }}
									<div class="form-group">
										<div class="col-md-12">
											{{ Form::text(
													'first_name',
													null,
													[
														'class' => 'form-control',
														'placeholder' => trans('validation.attributes.frontend.register-user.firstName')
													]
												)
											}}
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											{{ Form::text(
													'last_name',
													null,
													[
														'class' => 'form-control',
														'placeholder' => trans('validation.attributes.frontend.register-user.lastName')
													]
												)
											}}
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											{{ Form::text(
													'phone',
													null,
													[
														'class' => 'form-control number-field',
														'maxlength' => '10',
														'id' => 'phone',
														'placeholder' => trans('Phone No')
													]
												)
											}}
											<span class="phone error-msg" style="color:red"></span>
										</div>
									</div>
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
										<div class="col-md-12">
											{{ Form::input(
													'password',
													'password',
													null,
													[
														'class' => 'form-control',
														'id' => 'password',
														'placeholder' => trans('validation.attributes.frontend.register-user.password')
													]
												)
											}}
											<span class="password error-msg" style="color:red"></span>
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
														'id' => 'confirm_password',
														'placeholder' => trans('Confirm Password')
													]
												)
											}}
											<span class="confirm_password error-msg" style="color:red"></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12 text-center">
											<button
													id="submit-contact"
													class="catg-btn"
													onclick='formData("register_form", "Registration", "An email has been sent to your inbox with the link to verify your account. Please check your email.", false)'
													type="button">
												{{ trans('Sign up') }}
											</button>
										</div>
									</div>
								{{ Form::close() }}
								<div class="col-md-12 text-center">
									<hr class="my-4">
								</div>
								<div class="form-group">
									<div class="col-md-12 text-center">
										<button class="btn btn-lg btn-google btn-block text-uppercase google" type="button"><i class="fa fa-google
										mr-2"></i> Sign in with Google</button>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12 text-center">
										<button class="btn btn-lg btn-facebook btn-block text-uppercase facebook" type="button"><i class="fa fa-facebook-f
										mr-2"></i> Sign in with Facebook</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function formLogin(formId)
		{
			var formData = jsValidation(formId,formId+'_error_div','yes','error_manual');
			if (formData) {
				login(formId);
			}
		}

		function login(formId)
		{
			var options = {
				beforeSubmit: function() {
					$('input,select,textarea').removeClass('border-red');
					$('.'+formId+'_error_div').hide();
					$("#overlay").show();
				},
				success:function(data) {
					$("#overlay").hide();
					window.location.href = data.redirect;
				},
				error:function(data) {
					$("#overlay").hide();
					$('.'+formId+'_error_div').html(errorMessage(data));
					$('.'+formId+'_error_div').show('slow');
				},
				resetForm:true
			};
			$('#'+formId).ajaxSubmit(options);
		}
	</script>
@endsection
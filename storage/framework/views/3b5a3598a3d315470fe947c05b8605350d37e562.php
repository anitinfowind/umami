<?php $__env->startSection('content'); ?>
<?php $segment = \Request::segment(1); ?>


<h1 style="display: none;"><?php echo e($segment == 'login' ? 'Login' : ''); ?><?php echo e($segment == 'register' ? 'Register' : ''); ?></h1>

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo e(ucfirst($segment)); ?></li>
    </ol>
  </div>
</nav>
	
	<section class="login-page">
		<div class="container">
			<div class="col-sm-12 mx-auto">
				<div class="display-section login-section">
					<div class="display-description">
						<ul class="nav nav-tabs nav-justified" role="tablist">
							<li class="nav-item">
								<a class="nav-link <?php if($segment === 'login'): ?> active <?php endif; ?>" data-toggle="tab" href="#Login">Log In</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?php if($segment === 'register'): ?> active <?php endif; ?>" data-toggle="tab" href="#Registro">Sign Up</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="Login" class="tab-pane <?php if($segment === 'login'): ?> active <?php endif; ?>">
								<h2>LOG IN</h2>
								<?php echo e(Form::open([
                                		'route' => 'frontend.auth.login',
                                		'class' => 'form-horizontal',
                                		'id' => 'login_form'
                                	])); ?>

									<div class="login_form_error_div"></div>
                  <input type="hidden" name="preview" value="<?php echo e(isset($_REQUEST['key'])?$_REQUEST['key']:''); ?>">
									<div class="form-group">
										<div class="col-md-12">
											<?php echo e(Form::text(
													'email',
													null,
													[
														'class' => 'form-control',
														'id' => 'email-login',
														'placeholder' => trans('Email / Phone No')
													]
												)); ?>

										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<?php echo e(Form::input(
													'password',
													'password',
													null,
													[
														'class' => 'form-control',
														'id' => 'password_login',
														'placeholder' => trans('validation.attributes.frontend.register-user.password')
													]
												)); ?>

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
											<a class="forgot-pass" href="<?php echo e(url('forgot-password')); ?>">Forgot Password</a>
										</div>
									</div>
									</div>
									<div class="form-group">
										<div class="col-md-12 text-center">
											<button id="login-form"
													onclick='formLogin("login_form")'
													type="button"
													class="catg-btn" >
												<?php echo e(trans('labels.frontend.auth.login_button')); ?>

											</button>
										</div>
									</div>
								<?php echo e(Form::close()); ?>

								<div class="col-md-12 text-center">
									<hr class="my-4">
								</div>
								<div class="form-group">
									<div class="col-md-12 text-center">
										<button class="btn btn-lg btn-google google111 btn-block text-uppercase" type="button" onclick="window.location.href='<?php echo e(url('login/google')); ?>';"><i class="fa fa-google
										mr-2"></i>
											Sign in with Google</button>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12 text-center">
										<button class="btn btn-lg btn-facebook facebook111 btn-block text-uppercase" type="button" onclick="window.location.href='<?php echo e(url('login/facebook')); ?>';"><i class="fa fa-facebook-f
										mr-2"></i> Sign in with Facebook</button>
									</div>
								</div>
							</div>
							<div id="Registro" class="tab-pane <?php if($segment === 'register'): ?> active <?php endif; ?>">
								<h2>Sign Up</h2>
								<?php echo e(Form::open([
                                		'route' => 'frontend.auth.register',
                                		'class' => 'form-horizontal',
                                		'id'=>'register_form'
                                	])); ?>

									<div class="register_form_error_div"></div>
                   <?php echo e(Form::hidden(
                          'role',
                          '3',
                          [
                            'class' => 'form-control',
                           
                          ]
                        )); ?>

								<!-- 	<div class="form-group">
										<div class="col-md-12">
											<?php echo e(Form::select(
													'role',
													[
														'' => 'Select User Type',
														'2' => 'Vendor',
														'3' => 'User',
													],
													'',
													[
														'class' => 'form-control',
														'id' => 'role'
													]
												)); ?>

										</div>
									</div> -->

									<!-- <div class="form-group">
										<div class="col-md-12">
											<?php echo e(Form::text(
													'first_name',
													null,
													[
														'class' => 'form-control',
														'placeholder' => trans('validation.attributes.frontend.register-user.firstName')
													]
												)); ?>

										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<?php echo e(Form::text(
													'last_name',
													null,
													[
														'class' => 'form-control',
														'placeholder' => trans('validation.attributes.frontend.register-user.lastName')
													]
												)); ?>

										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<?php echo e(Form::text(
													'phone',
													null,
													[
														'class' => 'form-control number-field',
														'maxlength' => '10',
														'id' => 'phone',
														'placeholder' => trans('Phone No')
													]
												)); ?>

											<span class="phone error-msg" style="color:red"></span>
										</div>
									</div> -->


									<div class="form-group">
										<div class="col-md-12">
											<?php echo e(Form::email(
													'email',
													null,
													[
														'class' => 'form-control',
														'id' => 'email',
														'placeholder' => trans('Email')
													]
												)); ?>

											<span class="email error-msg" style="color:red"></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<?php echo e(Form::input(
													'password',
													'password',
													null,
													[
														'class' => 'form-control',
														'id' => 'password',
														'placeholder' => trans('validation.attributes.frontend.register-user.password')
													]
												)); ?>

											<span class="password error-msg" style="color:red"></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<?php echo e(Form::input(
													'password',
													'confirm_password',
													null,
													[
														'class' => 'form-control',
														'id' => 'confirm_password',
														'placeholder' => trans('Confirm Password')
													]
												)); ?>

											<span class="confirm_password error-msg" style="color:red"></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12 text-center">
											<button
													id="submit-contact"
													class="catg-btn"
													onclick='formData("register_form", "Registration", "You have successfully registered", "<?php echo e(url(isset($_REQUEST['key']) ? str_replace('\\', '/', $_REQUEST['key']) : 'login')); ?>")'
													type="button">
												<?php echo e(trans('Sign up')); ?>

											</button>
										</div>
									</div>
								<?php echo e(Form::close()); ?>

								<div class="col-md-12 text-center">
									<hr class="my-4">
								</div>
								<div class="form-group">
									<div class="col-md-12 text-center">
										<button class="btn btn-lg btn-google btn-block text-uppercase google111" type="button" onclick="window.location.href='<?php echo e(url('login/google')); ?>';"><i class="fa fa-google
										mr-2"></i> Sign in with Google</button>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12 text-center">
										<button class="btn btn-lg btn-facebook btn-block text-uppercase facebook111" type="button" onclick="window.location.href='<?php echo e(url('login/facebook')); ?>';"><i class="fa fa-facebook-f
										mr-2"></i> Sign in with Facebook</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
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
					<?php
					if(isset($_GET['redirect']) && $_GET['redirect'] != '') {
						echo ' window.location.href = "' . $_GET['redirect'] . '"; return false; ';
					}
					?>
					
           if(data.preview!='')
           {
					   window.location.href = data.preview;
           }
           else
           {
             window.location.href = data.redirect;
           }
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\umami\resources\views/frontend/auth/sign.blade.php ENDPATH**/ ?>
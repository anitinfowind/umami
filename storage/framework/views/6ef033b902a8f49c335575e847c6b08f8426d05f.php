<header class="main-header">
    <a href="<?php echo e(route('frontend.index')); ?>" class="logo">
        <span class="logo-mini">
		    <?php echo e(substr(app_name(), 0, 1)); ?>

		</span>
        <span class="logo-lg">
		    <?php echo e(app_name()); ?>

        </span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only"><?php echo e(trans('labels.general.toggle_navigation')); ?></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php if(config('locale.status') && count(config('locale.languages')) > 1): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-language"></i> <?php echo e(trans('menus.language-picker.language')); ?> <span class="caret"></span>
                        </a>
                        <?php echo $__env->make('includes.partials.lang', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </li>
                <?php endif; ?>
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-info">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><?php echo e(trans_choice('strings.backend.general.you_have.messages', 0, ['number' => 0])); ?></li>
                        <li class="footer">
                            <?php echo e(link_to('#', trans('strings.backend.general.see_all.messages'))); ?>

                        </li>
                    </ul>
                </li>
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-info notification-counter"></span>
                    </a>
                    <ul class="dropdown-menu notification-menu-container">
                    </ul>
                </li>
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-info">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><?php echo e(trans_choice('strings.backend.general.you_have.tasks', 0, ['number' => 0])); ?></li>
                        <li class="footer">
                            <?php echo e(link_to('#', trans('strings.backend.general.see_all.tasks'))); ?>

                        </li>
                    </ul>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo e(url('public/uploads/user/'. access()->user()->image)); ?>" class="user-image" alt="User Avatar"/>
                        <span class="hidden-xs"><?php echo e(access()->user()->first_name); ?></span>
                        <div class="clearfix"></div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="user-header">
                            <img src="<?php echo e(url('public/uploads/user/'. access()->user()->image)); ?>" class="img-circle" alt="User Avatar" />
                            <p>
                                <small><?php echo e(trans('strings.backend.general.member_since')); ?> <?php echo e(access()->user()->created_at->format("m/d/Y")); ?></small>
                            </p>
                        </li>
                        <li class="user-body">
                            <div class="col-xs-12 text-center">
                                <?php echo e(link_to_route("admin.profile.edit", 'Edit Profile')); ?>

                            </div>
                        </li>
                        <li class="user-body border-left">
                            <div class="col-xs-12 text-center">
                                <?php echo e(link_to_route('admin.access.user.change-password','Change Password', access()->user()->id)); ?>

                            </div>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo route('frontend.index'); ?>" class="btn btn-default btn-flat">
                                    <i class="fa fa-home"></i>
                                    <?php echo e(trans('navs.general.home')); ?>

                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo route('frontend.auth.logout'); ?>" class="btn btn-danger btn-flat">
                                    <i class="fa fa-sign-out"></i>
                                    <?php echo e(trans('navs.general.logout')); ?>

                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header><?php /**PATH F:\xampp\htdocs\umami\resources\views/backend/includes/header.blade.php ENDPATH**/ ?>
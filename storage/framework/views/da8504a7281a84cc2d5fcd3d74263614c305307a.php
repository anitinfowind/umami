<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header"><?php echo e(trans('menus.backend.sidebar.general')); ?></li>
            <li class="<?php echo e(active_class(Active::checkUriPattern('admin/dashboard'))); ?>">
                <a href="<?php echo e(route('admin.dashboard')); ?>">
                    <i class="fa fa-dashboard"></i>
                    <span><?php echo e(trans('menus.backend.sidebar.dashboard')); ?></span>
                </a>
            </li>
            <?php if (access()->allow('view-user-management')): ?>
                <li class="<?php echo e(active_class(Active::checkUriPattern('admin/access/user*'))); ?>">
                    <a href="<?php echo e(route('admin.access.user.index')); ?>">
                        <i class="fa fa-user"></i>
                        <span><?php echo e(trans('labels.backend.access.users.management')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <li class="<?php echo e(active_class(Active::checkUriPattern('admin/vendor*'))); ?> treeview">
                <a href="#">
                    <i class="fa fa-user-secret"></i>
                    <span><?php echo e(trans('menus.backend.vendor.management')); ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu <?php echo e(active_class(Active::checkUriPattern('admin/vendor*'), 'menu-open')); ?>" style="display: none; <?php echo e(active_class(Active::checkUriPattern('admin/vendor*'), 'display: block;')); ?>">
                    <li class="<?php echo e(active_class(Active::checkUriPattern('admin/vendor*'))); ?>">
                        <a href="<?php echo e(route('admin.vendors.index')); ?>">
                            <span><?php echo e(trans('Vendor')); ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php /*
            @permission('view-access-management')
                <li class="{{ active_class(Active::checkUriPattern('admin/access/*')) }} treeview">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span>{{ trans('menus.backend.access.title') }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/access/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/access/*'), 'display: block;') }}">
                        @permission('view-user-management')
                        <li class="{{ active_class(Active::checkUriPattern('admin/access/user*')) }}">
                            <a href="{{ route('admin.access.user.index') }}">
                                <span>{{ trans('labels.backend.access.users.management') }}</span>
                            </a>
                        </li>
                        @endauth
                        @permission('view-role-management')
                        <li class="{{ active_class(Active::checkUriPattern('admin/access/role*')) }}">
                            <a href="{{ route('admin.access.role.index') }}">
                                <span>{{ trans('labels.backend.access.roles.management') }}</span>
                            </a>
                        </li>
                        @endauth
                        @permission('view-permission-management')
                        <li class="{{ active_class(Active::checkUriPattern('admin/access/permission*')) }}">
                            <a href="{{ route('admin.access.permission.index') }}">
                                <span>{{ trans('labels.backend.access.permissions.management') }}</span>
                            </a>
                        </li>
                        @endauth
                    </ul>
                </li>
            @endauth

            <li class="{{ active_class(Active::checkUriPattern('admin/modules*')) }}">
                <a href="{{ route('admin.modules.index') }}">
                    <i class="fa fa-gear"></i>
                    <span>{{ trans('generator::menus.modules.management') }}</span>
                </a>
            </li>
            */ ?>
            <li class="<?php echo e(active_class(Active::checkUriPattern('admin/slider*'))); ?>">
                <a href="<?php echo e(route('admin.sliders.index')); ?>">
                    <i class="fa fa-sliders"></i>
                    <span><?php echo e(trans('Slider')); ?></span>
                </a>
            </li>
             <li class="<?php echo e(active_class(Active::checkUriPattern('admin/newsletter*'))); ?>">
                        <a href="<?php echo e(route('admin.newsletters.index')); ?>">  <i class="fa fa-users"></i>
                            <span><?php echo e(trans('News Letter Email List')); ?></span>
                        </a>
                    </li>
            <li class="<?php echo e(active_class(Active::checkUriPattern('admin/paymenthistory*'))); ?>">
                <a href="<?php echo e(route('admin.paymenthistory.index')); ?>">
                    <i class="fa fa-money"></i>
                    <span><?php echo e(trans('Payment History')); ?></span>
                </a>
            </li>
            <li class="<?php echo e(active_class(Active::checkUriPattern('admin/sales_report_dates*'))); ?>">
                <a href="<?php echo e(url('/admin/sales_report_dates')); ?>">
                    <i class="fa fa-cubes"></i>
                    <span>Sales Reports</span>
                </a>
            </li>
            <li class="<?php echo e(active_class(Active::checkUriPattern('admin/notifications*'))); ?>">
                <a href="<?php echo e(url('/admin/notifications')); ?>">
                    <i class="fa fa-question-circle"></i>
                    <span>Notifications</span>
                </a>
            </li>
             
            <!-- <li class="<?php echo e(active_class(Active::checkUriPattern('admin/vendorpayment*'))); ?>">
                <a href="<?php echo e(route('admin.vendorpayment.index')); ?>">
                    <i class="fa fa-money"></i>
                    <span><?php echo e(trans('Vendor Payment')); ?></span>
                </a>
            </li> -->
          
              <li class="<?php echo e(active_class(Active::checkUriPattern('admin/banner*'))); ?>">
                <a href="<?php echo e(route('admin.banner.index')); ?>">
                   <i class="fa fa-picture-o" aria-hidden="true"></i>
                    <span><?php echo e(trans('Banner')); ?></span>
                </a>
            </li>
            <?php if (access()->allow('view-blog')): ?>
                <li class="<?php echo e(active_class(Active::checkUriPattern('admin/blogs*'))); ?>">
                    <a href="<?php echo e(route('admin.blogs.index')); ?>">
                        <i class="fa fa-commenting"></i>
                        <span><?php echo e(trans('Blog')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
           
           <?php /*  @permission('view-blog')
            <li class="{{ active_class(Active::checkUriPattern('admin/blog*')) }} treeview">
                <a href="#">
                    <i class="fa fa-commenting"></i>
                    <span>{{ trans('menus.backend.blog.management') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/blog*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/blog*'), 'display: block;') }}">
                    @permission('view-blog-category')
                    <li class="{{ active_class(Active::checkUriPattern('admin/blogCategories*')) }}">
                        <a href="{{ route('admin.blogCategories.index') }}">
                            <span>{{ trans('menus.backend.blogcategories.management') }}</span>
                        </a>
                    </li>
                    @endauth
                    @permission('view-blog-tag')
                    <li class="{{ active_class(Active::checkUriPattern('admin/blogTags*')) }}">
                        <a href="{{ route('admin.blogTags.index') }}">
                            <span>{{ trans('menus.backend.blogtags.management') }}</span>
                        </a>
                    </li>
                    @endauth
                    @permission('view-blog')
                    <li class="{{ active_class(Active::checkUriPattern('admin/blogs*')) }}">
                        <a href="{{ route('admin.blogs.index') }}">
                            <span>{{ trans('menus.backend.blog.management') }}</span>
                        </a>
                    </li>
                    @endauth
                </ul>
            </li>
            @endauth
 */ ?>

            <?php if (access()->allow('view-faq')): ?>
                <li class="<?php echo e(active_class(Active::checkUriPattern('admin/faqs*'))); ?>">
                    <a href="<?php echo e(route('admin.faqs.index')); ?>">
                        <i class="fa fa-question-circle"></i>
                        <span><?php echo e(trans('labels.backend.faqs.title')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <li class="<?php echo e(active_class(Active::checkUriPattern('admin/categories*'))); ?>">
                <a href="<?php echo e(route('admin.categories.index')); ?>">
                    <i class="fa fa-chevron-circle-down"></i>
                    <span><?php echo e(trans('Category Manager')); ?></span>
                </a>
            </li>
            <li class="<?php echo e(active_class(Active::checkUriPattern('admin/product*'))); ?> treeview">
                <a href="#">
                    <i class="fa fa-product-hunt"></i>
                    <span><?php echo e(trans('menus.backend.product.management')); ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu <?php echo e(active_class(Active::checkUriPattern('admin/product*'), 'menu-open')); ?>" style="display: none; <?php echo e(active_class(Active::checkUriPattern('admin/product*'), 'display: block;')); ?>">

                    <li class="<?php echo e(active_class(Active::checkUriPattern('admin/brands*'))); ?>">
                        <a href="<?php echo e(route('admin.brands.index')); ?>">
                            <span><?php echo e(trans('Brands')); ?></span>
                        </a>
                    </li>
                    <li class="<?php echo e(active_class(Active::checkUriPattern('admin/diet*'))); ?>">
                        <a href="<?php echo e(route('admin.diet.index')); ?>">
                            <span><?php echo e(trans('Diet')); ?></span>
                        </a>
                    </li>
                    <li class="<?php echo e(active_class(Active::checkUriPattern('admin/region*'))); ?>">
                        <a href="<?php echo e(route('admin.region.index')); ?>">
                            <span><?php echo e(trans('Region')); ?></span>
                        </a>
                    </li>
                    <li class="<?php echo e(active_class(Active::checkUriPattern('admin/product*'))); ?>">
                        <a href="<?php echo e(route('admin.products.index')); ?>">
                            <span><?php echo e(trans('Product')); ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo e(active_class(Active::checkUriPattern('admin/product_reviews*'))); ?>">
                <a href="<?php echo e(url('/admin/product_reviews')); ?>">
                    <i class="fa fa-commenting"></i>
                    <span>Reviews</span>
                </a>
            </li>
            <!--  <li class="<?php echo e(active_class(Active::checkUriPattern('admin/productAttribute*'))); ?>">
                <a href="<?php echo e(route('admin.productAttribute.index')); ?>">
                    <i class="fa fa-chevron-circle-down"></i>
                    <span><?php echo e(trans('product Attribute')); ?></span>
                </a>
            </li> -->
            <li class="<?php echo e(active_class(Active::checkUriPattern('admin/shippings*'))); ?>">
                <a href="<?php echo e(route('admin.shippings.index')); ?>">
                    <i class="fa fa-money"></i>
                    <span><?php echo e(trans('Shippings')); ?></span>
                </a>
            </li>
            <!-- <li class="<?php echo e(active_class(Active::checkUriPattern('admin/videos*'))); ?>">
                <a href="<?php echo e(route('admin.videos.index')); ?>">
                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                    <span><?php echo e(trans('Video Section')); ?></span>
                </a>
            </li> -->
             <li class="<?php echo e(active_class(Active::checkUriPattern('admin/coupon*'))); ?>">
                <a href="<?php echo e(route('admin.coupon.index')); ?>">
                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                    <span><?php echo e(trans('Coupon Managment')); ?></span>
                </a>
            </li>
            <li class="<?php echo e(active_class(Active::checkUriPattern('admin/event*'))); ?>">
                <a href="<?php echo e(route('admin.event.index')); ?>">
                    <i class="fa fa-calendar-o" aria-hidden="true"></i>
                    <span><?php echo e(trans('Event Management')); ?></span>
                </a>
            </li>
             <li class="<?php echo e(active_class(Active::checkUriPattern('admin/restaurant*'))); ?>">
                <a href="<?php echo e(route('admin.restaurant.index')); ?>">
                    <i class="fa fa-cutlery" aria-hidden="true"></i>
                    <span><?php echo e(trans('Restaurant')); ?></span>
                </a>
            </li>
            <li class="<?php echo e(active_class(Active::checkUriPattern('admin/testimonials*'))); ?>">
                <a href="<?php echo e(url('/admin/testimonials')); ?>">
                    <i class="fa fa-commenting"></i>
                    <span>Testimonials</span>
                </a>
            </li>
            <?php /*
            <li class="{{ active_class(Active::checkUriPattern('admin/commission*')) }}">
                <a href="{{ route('admin.commission.index') }}">
                    <i class="fa fa-money" aria-hidden="true"></i>
                    <span>{{ trans('Commission Module') }}</span>
                </a>
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/videos*')) }}">
                <a href="{{ route('admin.videos.index') }}">
                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                    <span>{{ trans('Video Section') }}</span>
                </a>
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer*')) }} treeview">
                <a href="#">
                    <i class="fa fa-list"></i>
                    <span>{{ trans('menus.backend.log-viewer.main') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer')) }}">
                        <a href="{{ route('log-viewer::dashboard') }}">
                            <span>{{ trans('menus.backend.log-viewer.dashboard') }}</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer/logs')) }}">
                        <a href="{{ route('log-viewer::logs.list') }}">
                            <span>{{ trans('menus.backend.log-viewer.logs') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            */?>
             <li class="<?php echo e(active_class(Active::checkUriPattern('admin/subscriptions*'))); ?> treeview">
                <a href="#">
                    <i class="fa fa-commenting"></i>
                    <span><?php echo e(trans('menus.backend.subscription.management')); ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu <?php echo e(active_class(Active::checkUriPattern('admin/subscriptions/plan*'), 'menu-open')); ?>" style="display: none; <?php echo e(active_class(Active::checkUriPattern('admin/subscriptions*'), 'display: block;')); ?>">
                    <li class="<?php echo e(active_class(Active::checkUriPattern('admin/subscriptions*'))); ?>">
                        <a href="<?php echo e(route('admin.subscriptions.index')); ?>">
                            <span><?php echo e(trans('Subscription')); ?></span>
                        </a>
                    </li>
                <!--     <li class="<?php echo e(active_class(Active::checkUriPattern('admin/subscriptions/feature*'))); ?>">
                        <a href="<?php echo e(route('admin.subscriptions.feature')); ?>">
                            <span><?php echo e(trans('menus.backend.subscription.feature')); ?></span>
                        </a>
                    </li>
                    <li class="<?php echo e(active_class(Active::checkUriPattern('admin/subscription/list*'))); ?>">
                        <a href="<?php echo e(route('admin.blogs.index')); ?>">
                            <span><?php echo e(trans('menus.backend.subscription.list')); ?></span>
                        </a>
                    </li> -->
                </ul>
            </li>
            <?php if (access()->allow('edit-settings')): ?>
                <li class="<?php echo e(active_class(Active::checkUriPattern('admin/settings*'))); ?>">
                    <a href="<?php echo e(route('admin.settings.edit', 1 )); ?>">
                        <i class="fa fa-gear"></i>
                        <span><?php echo e(trans('labels.backend.settings.title')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
                <li class="<?php echo e(active_class(Active::checkUriPattern('admin/chef*'))); ?>">
                      <a href="<?php echo e(route('admin.chefs.index')); ?>">
                          <i class="fa fa-file-text"></i>
                          <span><?php echo e(trans('Chef Manager')); ?></span>
                      </a>
                </li>
                 <!-- <li class="<?php echo e(active_class(Active::checkUriPattern('admin/reward*'))); ?>">
                      <a href="<?php echo e(route('admin.reward.index')); ?>">
                          <i class="fa fa-file-text"></i>
                          <span><?php echo e(trans('Reward Manager')); ?></span>
                      </a>
                </li> -->

            <?php if (access()->allow('view-page')): ?>
                <li class="<?php echo e(active_class(Active::checkUriPattern('admin/pages*'))); ?>">
                    <a href="<?php echo e(route('admin.pages.index')); ?>">
                        <i class="fa fa-file-text"></i>
                        <span><?php echo e(trans('labels.backend.pages.title')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </section>
</aside><?php /**PATH F:\xampp\htdocs\umami\resources\views/backend/includes/sidebar.blade.php ENDPATH**/ ?>
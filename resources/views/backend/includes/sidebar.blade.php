<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">{{ trans('menus.backend.sidebar.general') }}</li>
            <li class="{{ active_class(Active::checkUriPattern('admin/dashboard')) }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>{{ trans('menus.backend.sidebar.dashboard') }}</span>
                </a>
            </li>
            @permission('view-user-management')
                <li class="{{ active_class(Active::checkUriPattern('admin/access/user*')) }}">
                    <a href="{{ route('admin.access.user.index') }}">
                        <i class="fa fa-user"></i>
                        <span>{{ trans('labels.backend.access.users.management') }}</span>
                    </a>
                </li>
            @endauth
            <li class="{{ active_class(Active::checkUriPattern('admin/vendor*')) }} treeview">
                <a href="#">
                    <i class="fa fa-user-secret"></i>
                    <span>{{ trans('menus.backend.vendor.management') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/vendor*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/vendor*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/vendor*')) }}">
                        <a href="{{ route('admin.vendors.index') }}">
                            <span>{{ trans('Vendor') }}</span>
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
            <li class="{{ active_class(Active::checkUriPattern('admin/slider*')) }}">
                <a href="{{ route('admin.sliders.index') }}">
                    <i class="fa fa-sliders"></i>
                    <span>{{ trans('Slider') }}</span>
                </a>
            </li>
             <li class="{{ active_class(Active::checkUriPattern('admin/newsletter*')) }}">
                        <a href="{{ route('admin.newsletters.index') }}">  <i class="fa fa-users"></i>
                            <span>{{ trans('News Letter Email List') }}</span>
                        </a>
                    </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/paymenthistory*')) }}">
                <a href="{{ route('admin.paymenthistory.index') }}">
                    <i class="fa fa-money"></i>
                    <span>{{ trans('Payment History') }}</span>
                </a>
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/sales_report_dates*')) }}">
                <a href="{{ url('/admin/sales_report_dates') }}">
                    <i class="fa fa-cubes"></i>
                    <span>Sales Reports</span>
                </a>
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/notifications*')) }}">
                <a href="{{ url('/admin/notifications') }}">
                    <i class="fa fa-question-circle"></i>
                    <span>Notifications</span>
                </a>
            </li>
             
            <!-- <li class="{{ active_class(Active::checkUriPattern('admin/vendorpayment*')) }}">
                <a href="{{ route('admin.vendorpayment.index') }}">
                    <i class="fa fa-money"></i>
                    <span>{{ trans('Vendor Payment') }}</span>
                </a>
            </li> -->
          
              <li class="{{ active_class(Active::checkUriPattern('admin/banner*')) }}">
                <a href="{{ route('admin.banner.index') }}">
                   <i class="fa fa-picture-o" aria-hidden="true"></i>
                    <span>{{ trans('Banner') }}</span>
                </a>
            </li>
            @permission('view-blog')
                <li class="{{ active_class(Active::checkUriPattern('admin/blogs*')) }}">
                    <a href="{{ route('admin.blogs.index') }}">
                        <i class="fa fa-commenting"></i>
                        <span>{{ trans('Blog') }}</span>
                    </a>
                </li>
            @endauth
           
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

            @permission('view-faq')
                <li class="{{ active_class(Active::checkUriPattern('admin/faqs*')) }}">
                    <a href="{{ route('admin.faqs.index')}}">
                        <i class="fa fa-question-circle"></i>
                        <span>{{ trans('labels.backend.faqs.title') }}</span>
                    </a>
                </li>
            @endauth
            <li class="{{ active_class(Active::checkUriPattern('admin/categories*')) }}">
                <a href="{{ route('admin.categories.index') }}">
                    <i class="fa fa-chevron-circle-down"></i>
                    <span>{{ trans('Category Manager') }}</span>
                </a>
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/product*')) }} treeview">
                <a href="#">
                    <i class="fa fa-product-hunt"></i>
                    <span>{{ trans('menus.backend.product.management') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/product*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/product*'), 'display: block;') }}">

                    <li class="{{ active_class(Active::checkUriPattern('admin/brands*')) }}">
                        <a href="{{ route('admin.brands.index') }}">
                            <span>{{ trans('Brands') }}</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/diet*')) }}">
                        <a href="{{ route('admin.diet.index') }}">
                            <span>{{ trans('Diet') }}</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/region*')) }}">
                        <a href="{{ route('admin.region.index') }}">
                            <span>{{ trans('Region') }}</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/product*')) }}">
                        <a href="{{ route('admin.products.index') }}">
                            <span>{{ trans('Product') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/product_reviews*')) }}">
                <a href="{{ url('/admin/product_reviews') }}">
                    <i class="fa fa-commenting"></i>
                    <span>Reviews</span>
                </a>
            </li>
            <!--  <li class="{{ active_class(Active::checkUriPattern('admin/productAttribute*')) }}">
                <a href="{{ route('admin.productAttribute.index') }}">
                    <i class="fa fa-chevron-circle-down"></i>
                    <span>{{ trans('product Attribute') }}</span>
                </a>
            </li> -->
            <li class="{{ active_class(Active::checkUriPattern('admin/shippings*')) }}">
                <a href="{{ route('admin.shippings.index') }}">
                    <i class="fa fa-money"></i>
                    <span>{{ trans('Shippings') }}</span>
                </a>
            </li>
            <!-- <li class="{{ active_class(Active::checkUriPattern('admin/videos*')) }}">
                <a href="{{ route('admin.videos.index') }}">
                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                    <span>{{ trans('Video Section') }}</span>
                </a>
            </li> -->
             <li class="{{ active_class(Active::checkUriPattern('admin/coupon*')) }}">
                <a href="{{ route('admin.coupon.index') }}">
                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                    <span>{{ trans('Coupon Managment') }}</span>
                </a>
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/event*')) }}">
                <a href="{{ route('admin.event.index') }}">
                    <i class="fa fa-calendar-o" aria-hidden="true"></i>
                    <span>{{ trans('Event Management') }}</span>
                </a>
            </li>
             <li class="{{ active_class(Active::checkUriPattern('admin/restaurant*')) }}">
                <a href="{{ route('admin.restaurant.index') }}">
                    <i class="fa fa-cutlery" aria-hidden="true"></i>
                    <span>{{ trans('Restaurant') }}</span>
                </a>
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/testimonials*')) }}">
                <a href="{{ url('/admin/testimonials') }}">
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
             <li class="{{ active_class(Active::checkUriPattern('admin/subscriptions*')) }} treeview">
                <a href="#">
                    <i class="fa fa-commenting"></i>
                    <span>{{ trans('menus.backend.subscription.management') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/subscriptions/plan*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/subscriptions*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/subscriptions*')) }}">
                        <a href="{{ route('admin.subscriptions.index') }}">
                            <span>{{ trans('Subscription') }}</span>
                        </a>
                    </li>
                <!--     <li class="{{ active_class(Active::checkUriPattern('admin/subscriptions/feature*')) }}">
                        <a href="{{ route('admin.subscriptions.feature') }}">
                            <span>{{ trans('menus.backend.subscription.feature') }}</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/subscription/list*')) }}">
                        <a href="{{ route('admin.blogs.index') }}">
                            <span>{{ trans('menus.backend.subscription.list') }}</span>
                        </a>
                    </li> -->
                </ul>
            </li>
            @permission('edit-settings')
                <li class="{{ active_class(Active::checkUriPattern('admin/settings*')) }}">
                    <a href="{{ route('admin.settings.edit', 1 ) }}">
                        <i class="fa fa-gear"></i>
                        <span>{{ trans('labels.backend.settings.title') }}</span>
                    </a>
                </li>
            @endauth
                <li class="{{ active_class(Active::checkUriPattern('admin/chef*')) }}">
                      <a href="{{ route('admin.chefs.index') }}">
                          <i class="fa fa-file-text"></i>
                          <span>{{ trans('Chef Manager') }}</span>
                      </a>
                </li>
                 <!-- <li class="{{ active_class(Active::checkUriPattern('admin/reward*')) }}">
                      <a href="{{ route('admin.reward.index') }}">
                          <i class="fa fa-file-text"></i>
                          <span>{{ trans('Reward Manager') }}</span>
                      </a>
                </li> -->

            @permission('view-page')
                <li class="{{ active_class(Active::checkUriPattern('admin/pages*')) }}">
                    <a href="{{ route('admin.pages.index') }}">
                        <i class="fa fa-file-text"></i>
                        <span>{{ trans('labels.backend.pages.title') }}</span>
                    </a>
                </li>
            @endauth
        </ul>
    </section>
</aside>
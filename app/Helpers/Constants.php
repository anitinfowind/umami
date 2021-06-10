<?php
define('FFMPEG_CONVERT_COMMAND','');
define('WEBSITE_URL',env('APP_URL'));

define('WEBSITE_IMG_URL', WEBSITE_URL . 'public/images/');

define('WEBSITE_UPLOADS_ROOT_PATH','public/uploads/');
define('WEBSITE_UPLOADS_URL', WEBSITE_URL . 'public/uploads/');

define('SLIDER_URL', WEBSITE_UPLOADS_URL . 'slider/');
define('SLIDER_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'slider' . DS);

define('BLOG_URL', WEBSITE_UPLOADS_URL . 'blog/');
define('BLOG_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'blog' . DS);

define('BRAND_URL', WEBSITE_UPLOADS_URL . 'brand/');
define('BRAND_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'brand' . DS);

define('USER_PROFILE_IMAGE_URL', WEBSITE_UPLOADS_URL . 'user/');
define('USER_PROFILE_IMAGE_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'user' . DS);

define('RESTAURANT_URL', WEBSITE_UPLOADS_URL . 'restaurant/');
define('RESTAURANT_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'restaurant' . DS);

define('PRODUCT_URL', WEBSITE_UPLOADS_URL . 'product/');
define('PRODUCT_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'product' . DS);

define('EVENT_URL', WEBSITE_UPLOADS_URL . 'event/');
define('EVENT_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'event' . DS);

define('CHEF_URL', WEBSITE_UPLOADS_URL . 'chef/');
define('CHEF_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'chef' . DS);

define('ATTRIBUTE_URL', WEBSITE_UPLOADS_URL . 'attributeicon/');
define('ATTRIBUTE_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'attributeicon' . DS);

define('BANNER_URL', WEBSITE_UPLOADS_URL . 'banner/');
define('BANNER_ROOT_PATH', WEBSITE_UPLOADS_ROOT_PATH .  'banner' . DS);
define('ZERO', 0);
define('ONE', 1);
define('TWO', 2);
define('THREE', 3);
define('FOUR', 4);
define('FIVE', 5);
define('SIX', 6);
define('EIGHT', 8);
define('TEN', 10);
define('PUBLISHED', 'Published');
define('DESC_LIMIT', 100);
define('SHORT_LIMIT', 70);
define('TITLE_LIMIT', 30);
define('PAGINATION', 12);
define('CURRENCY', '$');
define('PERCENTAGE', '%');
define('QTY', 'Qty');


define('ACTIVE', 'ACTIVE');
define('INACTIVE', 'INACTIVE');

define('PENDING', 'PENDING');
define('PACKED', 'PACKED');
define('SHIPPED', 'SHIPPED');
define('DELIVERED', 'DELIVERED');
define('APPROVED', 'APPROVED');
define('CANCELLED', 'CANCELLED');

define('CASH_ON_DELIVERY', 'CASH_ON_DELIVERY');
define('ONLINE', 'ONLINE');

define('OPEN', 'OPEN');
define('CLOSE', 'CLOSE');

function addressType()
{
    return [
        'HOME' => 'Home',
        'OFFICE' => 'Office',
        'OTHER' =>'Other'
    ];
}

function serviceType()
{
    return [
        '1' => 'Delivery',
        '2' => 'Take Away',
        '3' => 'Table Booking'
    ];
}

function weekDay()
{
    return [
        '1' => 'Monday',
       // '2' => 'Tuesday',
        //'3' => 'Wednesday',
        '4' => 'Thursday',
        //'5' => 'Friday',
       // '6' => 'Saturday',
       // '7' => 'Sunday',
    ];
}
function months()
{
    return [
        '3' => '3 Months ',
        '6' => '6 Months',
        '9' => '9 Months',
        '12' => '12 Months',
    ];
}


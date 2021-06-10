<!doctype html>
<html class="no-js" lang="<?php echo e(config('app.locale')); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="viewport" content="width=device-width, minimal-ui">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo $__env->yieldContent('title', app_name()); ?></title>
        <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'Default Description'); ?>">
        <meta name="author" content="<?php echo $__env->yieldContent('meta_author', 'Viral Solani'); ?>">
        <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
        <?php echo $__env->yieldContent('meta'); ?>
        <?php echo $__env->yieldContent('before-styles'); ?>
        <?php if (\Illuminate\Support\Facades\Blade::check('langrtl')): ?>
            <?php echo e(Html::style(getRtlCss(mix('css/backend.rtl.css')))); ?>

        <?php else: ?>
            <?php echo e(Html::style('css/backend.css')); ?>

        <?php endif; ?>
        <?php echo e(Html::style('css/backend-custom.css')); ?>

        <?php echo $__env->yieldContent('after-styles'); ?>
        <!--[if lt IE 9]>
        <?php echo e(Html::script('https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')); ?>

        <?php echo e(Html::script('https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js')); ?>

        <![endif]-->

        <style type="text/css">
            .table-responsive.data-table-wrapper {
                overflow: visible;
            }
        </style>

        <script>
            window.Laravel = <?php echo json_encode([ 'csrfToken' => csrf_token() ]); ?>;
        </script>
        <?php
            if (!empty($google_analytics)) {
                echo $google_analytics;
            }
        ?>
    </head>
    <body class="skin-<?php echo e(config('backend.theme')); ?> <?php echo e(config('backend.layout')); ?>">
        <div class="loading" style="display:none"></div>
        <?php echo $__env->make('includes.partials.logged-in-as', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="wrapper" id="app">
            <?php echo $__env->make('backend.includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('backend.includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <?php echo $__env->yieldContent('page-header'); ?>
                </section>
                <section class="content">
                    <?php echo $__env->make('includes.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->yieldContent('content'); ?>
                </section>
            </div>
            <?php echo $__env->make('backend.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <?php echo $__env->yieldContent('before-scripts'); ?>
        <?php echo e(Html::script('js/backend.js')); ?>

        <?php echo e(Html::script('js/backend-custom.js')); ?>

        <?php echo $__env->yieldContent('after-scripts'); ?>
        <?php echo e(Html::script('js/backend/custom.js')); ?>

    </body>
</html><?php /**PATH F:\xampp\htdocs\umami\resources\views/backend/layouts/app.blade.php ENDPATH**/ ?>
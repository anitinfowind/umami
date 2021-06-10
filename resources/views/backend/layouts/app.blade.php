<!doctype html>
<html class="no-js" lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="viewport" content="width=device-width, minimal-ui">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'Default Description')">
        <meta name="author" content="@yield('meta_author', 'Viral Solani')">
        <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
        @yield('meta')
        @yield('before-styles')
        @langrtl
            {{ Html::style(getRtlCss(mix('css/backend.rtl.css'))) }}
        @else
            {{ Html::style('css/backend.css') }}
        @endlangrtl
        {{ Html::style('css/backend-custom.css') }}
        @yield('after-styles')
        <!--[if lt IE 9]>
        {{ Html::script('https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}
        {{ Html::script('https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js') }}
        <![endif]-->

        <style type="text/css">
            .table-responsive.data-table-wrapper {
                overflow: visible;
            }
        </style>

        <script>
            window.Laravel = {!! json_encode([ 'csrfToken' => csrf_token() ]) !!};
        </script>
        <?php
            if (!empty($google_analytics)) {
                echo $google_analytics;
            }
        ?>
    </head>
    <body class="skin-{{ config('backend.theme') }} {{ config('backend.layout') }}">
        <div class="loading" style="display:none"></div>
        @include('includes.partials.logged-in-as')
        <div class="wrapper" id="app">
            @include('backend.includes.header')
            @include('backend.includes.sidebar')
            <div class="content-wrapper">
                <section class="content-header">
                    @yield('page-header')
                </section>
                <section class="content">
                    @include('includes.partials.messages')
                    @yield('content')
                </section>
            </div>
            @include('backend.includes.footer')
        </div>
        @yield('before-scripts')
        {{ Html::script('js/backend.js') }}
        {{ Html::script('js/backend-custom.js') }}
        @yield('after-scripts')
        {{ Html::script('js/backend/custom.js') }}
    </body>
</html>
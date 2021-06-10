<?php

Breadcrumbs::register('admin.videos.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.videos.management'), route('admin.videos.index'));
});

Breadcrumbs::register('admin.videos.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.videos.index');
    $breadcrumbs->push(trans('menus.backend.videos.create'), route('admin.videos.create'));
});

Breadcrumbs::register('admin.videos.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.videos.index');
    $breadcrumbs->push(trans('menus.backend.videos.edit'), route('admin.videos.edit', $id));
});

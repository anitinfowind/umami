<?php

Breadcrumbs::register('admin.subscriptions.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.subscriptions.management'), route('admin.subscriptions.index'));
});

Breadcrumbs::register('admin.subscriptions.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.subscriptions.index');
    $breadcrumbs->push(trans('menus.backend.subscriptions.create'), route('admin.subscriptions.create'));
});

Breadcrumbs::register('admin.subscriptions.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.subscriptions.index');
    $breadcrumbs->push(trans('menus.backend.subscriptions.edit'), route('admin.subscriptions.edit', $id));
});

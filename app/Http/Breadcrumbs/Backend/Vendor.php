<?php

Breadcrumbs::register('admin.vendors.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.vendors.management'), route('admin.vendors.index'));
});

Breadcrumbs::register('admin.vendors.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.vendors.index');
    $breadcrumbs->push(trans('menus.backend.vendors.create'), route('admin.vendors.create'));
});

Breadcrumbs::register('admin.vendors.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.vendors.index');
    $breadcrumbs->push(trans('menus.backend.vendors.edit'), route('admin.vendors.edit', $id));
});

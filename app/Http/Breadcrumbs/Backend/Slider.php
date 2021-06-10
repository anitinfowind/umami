<?php

Breadcrumbs::register('admin.sliders.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.sliders.management'), route('admin.sliders.index'));
});

Breadcrumbs::register('admin.sliders.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.sliders.index');
    $breadcrumbs->push(trans('menus.backend.sliders.create'), route('admin.sliders.create'));
});

Breadcrumbs::register('admin.sliders.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.sliders.index');
    $breadcrumbs->push(trans('menus.backend.sliders.edit'), route('admin.sliders.edit', $id));
});

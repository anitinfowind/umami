<?php

namespace App\Http\Responses\Backend\Vendor;

use Illuminate\Contracts\Support\Responsable;
use App\Models\Access\Permission\Permission;
class EditResponse implements Responsable
{
    /**
     * @var App\Models\Vendor\Vendor
     */
    protected $vendors;

    /**
     * @param App\Models\Vendor\Vendor $vendors
     */
    public function __construct($vendors)
    {
        $this->vendors = $vendors;
    }

    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
      $permissions = Permission::getSelectData('display_name');
        return view('backend.vendors.edit', compact('permissions'))->with([
            'vendors' => $this->vendors
        ]);
    }
}
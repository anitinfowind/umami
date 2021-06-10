<?php

namespace App\Http\Controllers\Backend\Vendor;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Vendor\VendorRepository;
use App\Http\Requests\Backend\Vendor\ManageVendorRequest;

class VendorsTableController extends Controller
{
    /**
     * @var VendorRepository
     */
    protected $vendor;

    /**
     * VendorsTableController constructor.
     * @param VendorRepository $vendor
     */
    public function __construct(VendorRepository $vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * @param ManageVendorRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function __invoke(ManageVendorRequest $request)
    {
       return Datatables::of($this->vendor->getForDataTable($request->get('status'), $request->get('trashed')))
            ->escapeColumns(['id'])
            ->escapeColumns(['first_name', 'email'])
            ->editColumn('confirmed', function ($vendor) {
                return $vendor->confirmed_label;
            })
           ->addColumn('status', function ($user) {
               return $user->status_label;
           })
            ->addColumn('created_at', function ($vendor) {
                return Carbon::parse($vendor->created_at)->format('d-M-Y');
            })
           ->addColumn('updated_at', function ($vendor) {
               return Carbon::parse($vendor->updated_at)->format('d-M-Y');
           })
            ->addColumn('actions', function ($vendor) {
                return $vendor->action_buttons;
            })
            //  ->addColumn('approvels', function ($vendor) {
            //     return $vendor->approvels_label;
            // })
            ->make(true);
    }
}

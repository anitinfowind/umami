<?php

namespace App\Http\Controllers\Backend\Vendor;

use App\Models\Vendor\Vendor;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Vendor\CreateResponse;
use App\Http\Responses\Backend\Vendor\EditResponse;
use App\Repositories\Backend\Vendor\VendorRepository;
use App\Http\Requests\Backend\Vendor\ManageVendorRequest;
use App\Http\Requests\Backend\Vendor\CreateVendorRequest;
use App\Http\Requests\Backend\Vendor\StoreVendorRequest;
use App\Http\Requests\Backend\Vendor\EditVendorRequest;
use App\Http\Requests\Backend\Vendor\UpdateVendorRequest;
use App\Http\Requests\Backend\Vendor\DeleteVendorRequest;
use App\Http\Requests\Backend\Access\User\StoreUserRequest;
use App\Repositories\Backend\Access\User\UserRepository;
use App\Http\Requests\Backend\Access\User\UpdateUserRequest;
use App\Models\Access\User\User;

class VendorsController extends Controller
{
    /**
     * @var VendorRepository
     */
    protected $repository;

    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * VendorsController constructor.
     * @param VendorRepository $repository
     * @param UserRepository $users
     */
    public function __construct(VendorRepository $repository,UserRepository $users)
    {
        $this->repository = $repository;
        $this->users = $users;
    }

    /**
     * @param ManageVendorRequest $request
     * @return ViewResponse
     */
    public function index(ManageVendorRequest $request)
    {
        return new ViewResponse('backend.vendors.index');
    }

    /**
     * @param CreateVendorRequest $request
     * @return CreateResponse
     */
    public function create(CreateVendorRequest $request)
    {
        return new CreateResponse('backend.vendors.create');
    }

    /**
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        $this->users->create($request);

        return new RedirectResponse(route('admin.vendors.index'),
            ['flash_success' => trans('alerts.backend.users.created')]
        );
    }

    /**
     * @param Vendor $vendor
     * @param EditVendorRequest $request
     * @return EditResponse
     */
    public function edit(Vendor $vendor, EditVendorRequest $request)
    {
        return new EditResponse($vendor);
    }

    /**
     * @param UpdateVendorRequest $request
     * @param Vendor $vendor
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        $input = $request->except(['_token']);
        $this->repository->update( $vendor, $request );

        return new RedirectResponse(route('admin.vendors.index'),
            ['flash_success' => trans('alerts.backend.vendors.updated')]
        );
    }

    /**
     * @param Vendor $vendor
     * @param DeleteVendorRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(Vendor $vendor, DeleteVendorRequest $request)
    {
        $this->repository->delete($vendor);

        return new RedirectResponse(route('admin.vendors.index'),
            ['flash_success' => trans('alerts.backend.vendors.deleted')]
        );
    }

    /**
     * @return View
     */
    public function sellerProductlist()
    {
        $sellerproduct=Product::get();

        return view('backend.vendors.seller_product',
            compact('sellerproduct')
        );
    }

    /**
     * @param int $modelId
     * @param string $modelStatus
     * @return RedirectResponse
     */
    public function updateStatus(int $modelId, string $modelStatus)
    {
        User::where('id', '=', $modelId)->update(['status' => $modelStatus]);

        return new RedirectResponse(route('admin.vendors.index'),
            ['flash_success' => trans('Status has been changed successfully.')]
        );
    }

    public function vendorView(int $id)
    {
       $vendorDetail = User::with('isRestaurantLocation','isRestaurantCategory')->where('id', '=', $id)->first();

       // echo '<pre>'; print_r($vendorDetail); exit;
       return view('backend.vendors.overview', compact('vendorDetail'));
    }
}

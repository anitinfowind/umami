<?php

namespace App\Http\Controllers\Backend\Brands;

use App\Http\Requests\Backend\Brand\BrandAddRequest;
use App\Http\Requests\Backend\Brand\BrandDeleteRequest;
use App\Http\Requests\Backend\Brand\BrandEditRequest;
use App\Http\Requests\Backend\Brand\BrandSaveRequest;
use App\Http\Requests\Backend\Brand\BrandShowRequest;
use App\Http\Requests\Backend\Brand\BrandUpdateRequest;
use App\Models\Brand\Brand;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use Ramsey\Uuid\Uuid;
use File;

class BrandController extends Controller
{
    /**
     * @var Brand
     */
    private $brand;

    /**
     * @param Brand $brand
     */
    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * @param BrandShowRequest $request
     * @return View
     */
    public function index(BrandShowRequest $request)
    {
        $brands = $this->brand->orderby('id','DESC')->get();

        return view('backend.brand.index',
            compact('brands')
        );
    }

    /**
     * @param BrandAddRequest $request
     * @return View
     */
    public function create(BrandAddRequest $request)
    {
        return view('backend.brand.create');
    }

    /**
     * @param BrandSaveRequest $request
     * @return RedirectResponse
     */
    public function store(BrandSaveRequest $request)
    {
        if ($request->hasFile('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = Uuid::uuid4()->toString() . '.' . $extension;
            if ($request->file('file')->move(BRAND_ROOT_PATH, $fileName)) {
                $fileName = $fileName;
            }
        }

        $this->brand->create([
            'name' => $request->name(),
            'description' => $request->description(),
            'slug' => $this->getSlug($request->get('name'),'','brands'),
            'image' => $fileName,
            'is_active' => ($request->get('is_active')) ? ACTIVE : INACTIVE,
        ]);

        return new RedirectResponse(route('admin.brands.index'),
            ['flash_success' => trans('Brands has been successfully added.')]
        );
    }

    /**
     * @param BrandEditRequest $request
     * @param int $id
     * @return View
     */
    public function edit(BrandEditRequest $request, int $id)
    {
        $brands = $this->brand->find($id);

        return view('backend.brand.edit',
            compact('brands')
        );
    }

    /**
     * @param BrandUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(BrandUpdateRequest $request, int $id)
    {
        $brand = $this->brand->where('id', $id)->first();
        $fileName = $brand->image;
        if ($request->hasFile('file')) {
            $extension =	$request->file('file')->getClientOriginalExtension();
            $fileName = Uuid::uuid4()->toString() . '.' . $extension;

            if (File::exists(BRAND_ROOT_PATH.$brand->image)) {
                @unlink(BRAND_ROOT_PATH.$brand->image);
            }

            if ($request->file('file')->move(BRAND_ROOT_PATH, $fileName)) {
                $fileName   =   $fileName;
            }
        }

        $brand->update([
            'name' => $request->name(),
            'description' => $request->description(),
            'image' => $fileName,
            'is_active' => ($request->get('is_active')) ? ACTIVE : INACTIVE,
        ]);

        return new RedirectResponse(route('admin.brands.index'),
            ['flash_success' => trans('Brands has been successfully updated.')]
        );
    }

    /**
     * @param BrandDeleteRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(BrandDeleteRequest $request, int $id)
    {
        $brand = $this->brand->find($id);

        if (File::exists(BRAND_ROOT_PATH.$brand->image)) {
            @unlink(BRAND_ROOT_PATH.$brand->image);
        }
        $brand->delete();

        return new RedirectResponse(route('admin.brands.index'),
            ['flash_success' => trans('Brands has been successfully deleted.')]
        );
    }

    /**
     * @param BrandShowRequest $request
     * @param int $modelId
     * @param string $modelStatus
     */
    public function updateStatus(BrandShowRequest $request, int $modelId, string $modelStatus)
    {
        $this->brand->where('id', '=', $modelId)->update(['is_active' => $modelStatus]);

        return new RedirectResponse(route('admin.brands.index'),
            ['flash_success' => trans('Status has been changed successfully.')]
        );
    }
}

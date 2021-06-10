<?php

namespace App\Http\Controllers\Backend\Region;

use App\Http\Requests\Backend\Region\RegionAddRequest;
use App\Http\Requests\Backend\Region\RegionDeleteRequest;
use App\Http\Requests\Backend\Region\RegionEditRequest;
use App\Http\Requests\Backend\Region\RegionSaveRequest;
use App\Http\Requests\Backend\Region\RegionShowRequest;
use App\Http\Requests\Backend\Region\RegionUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\Region;

class RegionController extends Controller
{
    /**
     * @var Region
     */
    private $region;

    /**
     * @param Region $region
     */
    public function __construct(Region $region)
    {
        $this->region = $region;
    }

    /**
     * @param RegionShowRequest $request
     * @return View
     */
    public function index(RegionShowRequest $request)
    {
        $regions = $this->region->orderby('id','DESC')->get();

        return view('backend.region.index',
            compact('regions')
        );
    }

    /**
     * @param RegionAddRequest $request
     * @return View
     */
    public function addRegion(RegionAddRequest $request)
    {
        return view('backend.region.create');
    }

    /**
     * @param RegionSaveRequest $request
     */
    public function saveRegion(RegionSaveRequest $request)
    {
        $this->region->create([
            'name' => $request->name(),
            'slug' => $this->getSlug($request->name(),'','regions'),
            'is_active' => ($request->isActive()) ? ACTIVE : INACTIVE,
        ]);

        return redirect()->route('admin.region.index')
            ->with(['flash_success' => trans('Region has been successfully added.')]);
    }

    /**
     * @param RegionEditRequest $request
     * @param int $id
     * @return View
     */
    public function editRegion(RegionEditRequest $request, int $id)
    {
        $regions = $this->region->find($id);

        return view('backend.region.edit',
            compact('regions')
        );
    }

    /**
     * @param RegionUpdateRequest $request
     * @param int $id
     */
    public function updateRegion(RegionUpdateRequest $request, int $id)
    {
        $this->region->where('id', $id)->update([
            'name' => $request->name(),
            'is_active' => ($request->isActive()) ? ACTIVE : INACTIVE,
        ]);

        return redirect()->route('admin.region.index')
            ->with(['flash_success' => trans('Region has been successfully updated.')]);
    }

    /**
     * @param RegionDeleteRequest $request
     * @param int $id
     */
    public function deleteRegion(RegionDeleteRequest $request, int $id)
    {
        $this->region->find($id)->delete();

        return redirect()->route('admin.region.index')
            ->with(['flash_success' => trans('Region has been successfully deleted.')]);
    }

    /**
     * @param RegionShowRequest $request
     * @param int $modelId
     * @param string $modelStatus
     */
    public function updateStatus(RegionShowRequest $request, int $modelId, string $modelStatus)
    {
        $this->region->where('id', '=', $modelId)->update(['is_active' => $modelStatus]);

        return redirect()->route('admin.region.index')
            ->with(['flash_success' => trans('Status has been changed successfully.')]);
    }
}

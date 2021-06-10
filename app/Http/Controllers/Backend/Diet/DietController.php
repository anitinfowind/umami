<?php

namespace App\Http\Controllers\Backend\Diet;

use App\Http\Requests\Backend\Diet\DietAddRequest;
use App\Http\Requests\Backend\Diet\DietDeleteRequest;
use App\Http\Requests\Backend\Diet\DietEditRequest;
use App\Http\Requests\Backend\Diet\DietSaveRequest;
use App\Http\Requests\Backend\Diet\DietShowRequest;
use App\Http\Requests\Backend\Diet\DietUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\Diet;

class DietController extends Controller
{
    /**
     * @var Diet
     */
    private $diet;

    /**
     * @param Diet $diet
     */
    public function __construct(Diet $diet)
    {
        $this->diet = $diet;
    }

    /**
     * @param DietShowRequest $request
     * @return View
     */
    public function index(DietShowRequest $request)
    {
        $diets = $this->diet->orderby('id','DESC')->get();

        return view('backend.diet.index',
            compact('diets')
        );
    }

    /**
     * @param DietAddRequest $request
     * @return View
     */
    public function addDiet(DietAddRequest $request)
    {
        return view('backend.diet.create');
    }

    /**
     * @param DietSaveRequest $request
     */
    public function saveDiet(DietSaveRequest $request)
    {
        $this->diet->create([
            'name' => $request->name(),
            'slug' => $this->getSlug($request->name(),'','diets'),
            'is_active' => ($request->isActive()) ? ACTIVE : INACTIVE,
        ]);

        return redirect()->route('admin.diet.index')
            ->with(['flash_success' => trans('Diet has been successfully added.')]);
    }

    /**
     * @param DietEditRequest $request
     * @param int $id
     * @return View
     */
    public function editDiet(DietEditRequest $request, int $id)
    {
        $diets = $this->diet->find($id);

        return view('backend.diet.edit',
            compact('diets')
        );
    }

    /**
     * @param DietUpdateRequest $request
     * @param int $id
     */
    public function updateDiet(DietUpdateRequest $request, int $id)
    {
        $this->diet->where('id', $id)->update([
            'name' => $request->name(),
            'is_active' => ($request->isActive()) ? ACTIVE : INACTIVE,
        ]);

        return redirect()->route('admin.diet.index')
            ->with(['flash_success' => trans('Diet has been successfully updated.')]);
    }

    /**
     * @param DietDeleteRequest $request
     * @param int $id
     */
    public function deleteDiet(DietDeleteRequest $request, int $id)
    {
        $this->diet->find($id)->delete();

        return redirect()->route('admin.diet.index')
            ->with(['flash_success' => trans('Diet has been successfully deleted.')]);
    }

    /**
     * @param DietShowRequest $request
     * @param int $modelId
     * @param string $modelStatus
     */
    public function updateStatus(DietShowRequest $request, int $modelId, string $modelStatus)
    {
        $this->diet->where('id', '=', $modelId)->update(['is_active' => $modelStatus]);

        return redirect()->route('admin.diet.index')
            ->with(['flash_success' => trans('Status has been changed successfully.')]);
    }
}

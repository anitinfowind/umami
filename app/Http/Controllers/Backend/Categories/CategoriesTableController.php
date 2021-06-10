<?php

namespace App\Http\Controllers\Backend\Categories;

use App\Http\Requests\Backend\Categories\CategoryShowRequest;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Categories\CategoryRepository;

class CategoriesTableController extends Controller
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param CategoryShowRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function __invoke(CategoryShowRequest $request)
    {
        return Datatables::of($this->categoryRepository->getForDataTable())
            ->escapeColumns(['id'])
             ->addColumn('name', function ($category) {
                return $category->name;
            })
            ->addColumn('is_active', function ($category) {
                return $category->is_active_label;
            })
            ->addColumn('created_at', function ($category) {
                return Carbon::parse($category->created_at)->toDateString();
            })
            ->addColumn('actions', function ($category) {
                return $category->action_buttons;
            })
            ->make(true);
    }
}

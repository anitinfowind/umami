<?php

namespace App\Http\Controllers\Backend\Categories;

use App\Models\Categories\Category;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Repositories\Backend\Categories\CategoryRepository;
use App\Http\Requests\Backend\Categories\CategoryShowRequest;
use App\Http\Requests\Backend\Categories\CategoryAddRequest;
use App\Http\Requests\Backend\Categories\CategorySaveRequest;
use App\Http\Requests\Backend\Categories\CategoryEditRequest;
use App\Http\Requests\Backend\Categories\CategoryUpdateRequest;
use App\Http\Requests\Backend\Categories\CategoryDeleteRequest;

class CategoriesController extends Controller
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @param Category $category
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        Category $category,
        CategoryRepository $categoryRepository
    ) {
        $this->category = $category;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param CategoryShowRequest $request
     * @return View
     */
    public function index(CategoryShowRequest $request)
    {
        return view('backend.categories.index');
    }

    /**
     * @param CategoryAddRequest $request
     * @return View
     */
    public function create(CategoryAddRequest $request)
    {
        return view('backend.categories.create');
    }

    /**
     * @param CategorySaveRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function store(CategorySaveRequest $request)
    {
        $this->categoryRepository->create($request);

        return new RedirectResponse(route('admin.categories.index'),
            ['flash_success' => trans('alerts.backend.categories.created')]
        );
    }

    /**
     * @param CategoryEditRequest $request
     * @param int $id
     * @return View
     */
    public function edit(CategoryEditRequest $request, int $id)
    {
        $category = $this->category->find($id);

        return view('backend.categories.edit',
            compact('category')
        );

    }

    /**
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function update(CategoryUpdateRequest $request, int $id)
    {
        $this->categoryRepository->update( $request, $id );

        return new RedirectResponse(route('admin.categories.index'),
            ['flash_success' => trans('alerts.backend.categories.updated')]
        );
    }

    /**
     * @param CategoryDeleteRequest $request
     * @param $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(CategoryDeleteRequest $request, $id)
    {
        $this->category->find($id)->delete();

        return new RedirectResponse(route('admin.categories.index'),
            ['flash_success' => trans('alerts.backend.categories.deleted')]
        );
    }

    /**
     * @param CategoryShowRequest $request
     * @param int $modelId
     * @param string $modelStatus
     */
    public function updateStatus(CategoryShowRequest $request, int $modelId, string $modelStatus)
    {
        $this->category->where('id', '=', $modelId)->update(['is_active' => $modelStatus]);

        return new RedirectResponse(route('admin.categories.index'),
            ['flash_success' => trans('Status has been changed successfully.')]
        );
    }

    public function categoryOrder()
    {
      $categorydata = $this->category->orderBy('order_no','ASC')->get();
      // echo '<pre>'; print_r($categorydata);exit;
       return view('backend.categories.ordersort', compact('categorydata'));
    }
     public function categoryOrderSave()
     {
       $order = !empty($_REQUEST['order'])?$_REQUEST['order']:'';
      $order = !empty($order)?explode(',',$order):[];
      if(!empty($order)){        
        $i = 1;
        foreach($order as $k=>$id){
         $this->category->where('id',$id)->update(['order_no'=>$i]);
          $i++;
        }
        echo json_encode(['status'=>'success','message'=>__('Sequence successfully updated')]); die;
      }else{
        echo json_encode(['status'=>'error','message'=>__('Unable to updated sequence')]); die;
      }  
     }
}

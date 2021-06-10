<?php

namespace App\Http\Responses\Backend\Categories;
use App\Models\Categories\Category;
use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Categories\Category
     */
    protected $categories;

    /**
     * @param App\Models\Categories\Category $categories
     */
    public function __construct($categories)
    {
        $this->categories = $categories;
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
      $category=Category::where('parent_id',0)->select('id','category_name')->get();
        return view('backend.categories.edit', compact('category'))->with([
            'categories' => $this->categories
        ]);
    }
}
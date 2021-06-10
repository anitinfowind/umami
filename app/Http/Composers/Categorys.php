<?php

namespace App\Http\Composers;
use Illuminate\View\View;
use App\Models\Categories\Category;
/**
 * Class Categorys.
 */
class Categorys
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('categorys', Category::select('id','name','slug')->orderBy('order_no','ASC')->where('is_active',ACTIVE)->get());
    }
}

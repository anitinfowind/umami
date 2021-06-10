<?php

namespace App\Http\Responses\Backend\Products;

use Illuminate\Contracts\Support\Responsable;
use App\Models\Categories\Category;
use App\Models\Products\Product;
use App\Models\Brand\Brand;
use App\Models\Diet;
use App\Models\Region;
use App\Models\Rating;
use App\Models\ProductAttribute;
use App\Models\Restaurant\Restaurant;
class EditResponse implements Responsable
{
    /**
     * @var App\Models\Products\Product
     */
    protected $products;

    /**
     * @param App\Models\Products\Product $products
     */
    public function __construct($products)
    {
        $this->products = $products;
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
      	$productAttrs	= ProductAttribute::where('is_active','ACTIVE')->get();
        $restaurants	= Restaurant::where('is_active', 'APPROVED')->select('id','name')->get();
        $categories		= Category::where('parent_id',0)->select('id','name')->get();
        $brands 		= Brand::where('is_active','ACTIVE')->select('id','name')->get();
        $diets 			= Diet::where('is_active','ACTIVE')->select('id','name')->get();
        $regions 		= Region::where('is_active','ACTIVE')->select('id','name')->get();
		$rating			= Rating::where('product_id',$this->products->id)->get();
		
		$total_user_rating	='';
		$total_user			='';
		if(count($rating)>0){
			$totalsum			= collect($rating)->sum('taste');
			$total_user			= count($rating);
			$ratingreview		= ($totalsum/$total_user);
			$total_user_rating	= round($ratingreview,1);
		}
  		 //  echo '<pre>'; print_r($this->products);exit;
        return view('backend.products.edit',compact('categories','brands','diets','regions','restaurants','productAttrs','total_user_rating','total_user'))->with([
            'products' => $this->products
        ]);
    }
}
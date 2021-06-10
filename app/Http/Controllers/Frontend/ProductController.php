<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Categories\Category;
use App\Models\Brand\Brand;
use App\Models\Diet;
use App\Models\Region;
use App\Models\Rating;
use App\Models\Products\Product;
use App\Models\Products\ProductImage;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use App\Repositories\Frontend\Product\ProductRepository;
use App\Http\Requests\Frontend\Product\ProductShowRequest;
use App\Http\Requests\Frontend\Product\ProductAddRequest;
use App\Http\Requests\Frontend\Product\ProductCreateRequest;
use App\Http\Requests\Frontend\Product\ProductEditRequest;
use App\Http\Requests\Frontend\Product\ProductUpdateRequest;
use App\Http\Requests\Frontend\Product\ProductDeleteRequest;
use App\Http\Requests\Frontend\Product\ProductImageRequest;
use App\Models\Restaurant\Restaurant;
use DB;
class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Brand
     */
    protected $brand;

    /**
     * @var Diet
     */
    protected $diet;

    /**
     * @var Region
     */
    protected $region;

    /**
     * @var Product
     */
    protected $product;
	
    /**
     * @var Product
     */
    protected $productAttribute;

    /**
     * @param ProductRepository $productRepository
     * @param Category $category
     * @param Brand $brand
     * @param Diet $diet
     * @param Region $region
     * @param Product $product
     */
    public function __construct(
        ProductRepository $productRepository,
        Category $category,
        Brand $brand,
        Diet $diet,
        Region $region,
        Product $product,
        ProductAttribute $productAttribute
    ) {
        $this->productRepository = $productRepository;
        $this->category = $category;
        $this->brand = $brand;
        $this->diet = $diet;
        $this->region = $region;
        $this->product = $product;
        $this->productAttribute = $productAttribute;
    }

    /**
     * @param ProductShowRequest $request
     * @return View
     */
    public function productList(ProductShowRequest $request)
    {
        $lists = $this->productRepository->list();
        return view('frontend.product.product-list',
            compact('lists')
        );
    }

    /**
     * @param ProductAddRequest $request
     * @return View
     */
    public function productAdd(ProductAddRequest $request)
    {   
        $attributes= $this->productAttribute->isActiveProductAttribute()->get();
        $category_data = $this->category->isActive()->pluck('name', 'id')->all();
        $brands = $this->brand->isActiveBrand()->pluck('name', 'id')->all();
        $diet = $this->diet->isActiveDiet()->pluck('name', 'id')->all();
        return view('frontend.product.product-add',
            compact('category_data','brands','diet','attributes')
        );
    }

    /**
     * @param ProductCreateRequest $request
     */
    public function productSave(ProductCreateRequest $request)
    {
        $this->productRepository->createProduct($request);
        session()->put('product',
                          [
                              'title' => trans('Product'),
                              'msg' => trans('Product has been successfully Add.')
                          ]
                      );

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * @param ProductEditRequest $request
     * @param string $slug
     * @return View
     */
    public function productEdit(ProductEditRequest $request, string $slug)
    {
        $attributes= $this->productAttribute->isActiveProductAttribute()->get();
        $productDetail = $this->product->with('productImage')->firstWhere('slug', $slug);
        $category_data = $this->category->isActive()->pluck('name', 'id')->all();
        $brands = $this->brand->isActiveBrand()->pluck('name', 'id')->all();
        $diet = $this->diet->isActiveDiet()->pluck('name', 'id')->all();
        return view('frontend.product.product-edit',
            compact('productDetail','category_data','brands','diet','attributes')
        );
    }

    public function updateProduct(ProductUpdateRequest $request )
    {
       $productimage= ProductImage::where('product_id',$request->id)->first();
        if(!empty($request->get('files'))>0)
        {
           $this->productRepository->updateProduct($request);
                session()->put('product_update',
                            [
                                'title' => trans('Product Update'),
                                'msg' => trans('Product has been successfully Updated.')
                            ]
                        );

                return response()->json([
                    'success' => true,
                ]);
        }
        elseif(empty($productimage))
        {
            session()->put('errors',
                      [
                          'title' => trans('Image Required'),
                          'msg' => trans('Product could not be Updated.')
                      ]
                  );

          return response()->json([
              'error' => true,
          ]);
        }else
        {
          $this->productRepository->updateProduct($request);
          session()->put('product_update',
                      [
                          'title' => trans('Product Update'),
                          'msg' => trans('Product has been successfully Updated.')
                      ]
                  );

          return response()->json([
              'success' => true,
          ]);
        }
    }

    /**
     * @param ProductDeleteRequest $request
     * @param string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteProduct(ProductDeleteRequest $request)
    {
       if ($request->ajax()) {
           $this->productRepository->deleteProduct($request->get('product_id'));

           return response()->json([
              'success' => true
           ]);
      }
    }

    /**
     * @param ProductImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeImage(ProductImageRequest $request)
    {
        return $this->productRepository->productRemoveImage($request);
    }

    /**
     * @return View
     */
    public function show(Request $request)
    {
        $productAttrs= $this->productAttribute->isActiveProductAttribute()->get();
        $categorys = $this->category->isActive()->select('name', 'id')->get();
        $diets = $this->diet->isActiveDiet()->select('name', 'id')->get();
        $regions = $this->region->isActiveRegion()->select('name', 'id')->get();

        $maxprice= $this->product->orderBy('price','DESC')->first();
        $status=0;
        if(isset($_REQUEST['status']) && !empty($_REQUEST['status']))
        {
          $status=1;
        }

        $filterdata='status = '.$status.'';
        if($request->get('editor'))
        {
          $filterdata.= " AND editor_pick = '1'";
        }
        if($request->get('shipping'))
        {
          $filterdata.= " AND shipping_type = 'FREE'";
        }
         if($request->get('diet'))
        {
         // $filterdata.= " AND diet_id = ".$request->get('diet')."";
        }
        // if($request->get('category'))
        // {
        //   $filterdata.= " AND category_id = ".$request->get('category')."";
        // }
       
        $order='';
        if($request->get('sort_by')=='highest')
        {
          $order = "DESC";
        }
       if($request->get('sort_by')=='lowest')
        {
          $order = "ASC";
        }
         
          if($status==1)
          {
            $products = $this->productRepository->productSearchList($filterdata,$order);
             if($request->get('category'))
            {

               $products=$products->whereIN('category_id',$request->get('category'));
            }
            //echo "<pre>"; print_r($products); exit;
             if($request->get('diet'))
              {
                $products=$products->whereIN('diet_id',$request->get('diet'));
              }
            
             return view('frontend.product.product-search',
            compact('products','categorys','diets','regions','productAttrs','maxprice'));
         }

          $products = $this->productRepository->productList();
          // echo "<pre>"; print_r($products); exit;
          if(isset($_REQUEST['search']) && !empty($_REQUEST['search']))
          {

            $products = $this->productRepository->productSearch($_REQUEST['search']);
          }
           if(isset($_REQUEST['brand']) && !empty($_REQUEST['brand']))
          {
            $brandId= $this->brand->where('slug',$_REQUEST['brand'])->select('id')->first();
            $products=$this->productRepository->productBrand($brandId->id);
          }
          if(isset($_REQUEST['category']) && !empty($_REQUEST['category']))
          {
            $catId= $this->category->where('slug',$_REQUEST['category'])->select('id')->first();
            $products=$this->productRepository->productCategoryFilter($catId->id);
          }
         
          return view('frontend.product.product-show',
              compact('products','categorys','diets','regions','productAttrs','maxprice')
          );
    }

    /**
     * @param string $slug
     * @return View
     */
    public function productDetail(string $slug)
    {
      if(isset($slug) && empty($slug))
      {
        return redirect()->back();
      }
      $details = $this->productRepository->productDetail($slug);
      $userdas=DB::table('products')->where('slug',$slug)->first();
      $getres= DB::table('products')->where('restaurant_id',$userdas->restaurant_id)->groupBy('user_id')->pluck('user_id')->toArray();
      $restaurant = Restaurant::find($userdas->restaurant_id);

     $productdata= DB::table('orders')
          ->select('product_id', DB::raw('count(*) as total'))
          ->whereIn('vendor_id',$getres)
          ->groupBy('product_id')
          ->orderBy('total','desc')
          ->limit(TEN)
          ->pluck('product_id')->toarray();
		  $productsrecomm=$this->product->whereIn('id',$productdata)->with('singleProductImage','category','region')->get();  
      $productAttrs = $this->productAttribute->isActiveProductAttribute()->get();

      $rating= Rating::where('product_id',$details->id)->get();
      
      $ratingreview='';
      $totaluser='';
      if(count($rating)>0)
      {
        $totalsum=collect($rating)->sum('average_rating');
        $totaluser= count($rating);
        $ratingreview=($totalsum/$totaluser);
      }
	  
	  $products_recom_ids	= DB::table('products')->where('product_admin_status',1)->where('restaurant_id',$userdas->restaurant_id)->groupBy('id')->pluck('id')->skip(0)->take(20)->toArray();
	  $productsrecommitems	= $this->product->leftJoin('restaurants', 'products.restaurant_id', '=', 'restaurants.id')->where('restaurants.is_active','APPROVED')->whereIn('products.id',$products_recom_ids)->whereNotIn('products.id', [$userdas->id])->with('productImage', 'category')->select('products.*')->get();
	  //dd($productsrecommitems);

        $product_addons = DB::table('product_addons')->where('product_id', $details->id)->get()->toArray();
        $product_addons = array_map(function ($value) {
            return (array)$value;
        }, $product_addons);
        if (!empty($product_addons)) {
            $product_addons = $this->group_by('label', $product_addons);
        }
        //echo '<pre>';print_r($product_addons);die;
        return view('frontend.product.product-details',
            compact('details', 'productAttrs','productsrecomm','productsrecommitems','ratingreview','totaluser', 'restaurant', 'product_addons')
        );
    }

    public function group_by($key, $data) {
        $result = array();
    
        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }
    
        return $result;
    }

    public function changeAddonPrice(Request $request)
    {
        print_r($request->all());die;
    }

   public function getRating($id=null)
   {
        $rating= Rating::where('product_id',$id)->get();
         return $rating ;
   }

   public  function prouctNameGet($productId=null)
   {
    $productName='';
     $pname= $this->product->where('id',$productId)->select('title')->first();
      if(!empty($pname))
      {
        $productName=$pname->title;
      }
       return $productName;
   }
}

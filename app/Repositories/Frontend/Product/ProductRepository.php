<?php

namespace App\Repositories\Frontend\Product;

use App\Http\Controllers\Controller;
use App\Models\Products\Product;
use App\Models\Products\ProductImage;
use App\Models\Products\ProductCategorys;
use App\Models\Products\ProductBrand;
use App\Models\Products\ProductDiet;
use App\Models\Restaurant\RestaurantBranch;
use Ramsey\Uuid\Uuid;
use Validator;
use Image;
use App\Models\Restaurant\Restaurant;
use App\Models\Admin_notification;

class ProductRepository
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var ProductImage
     */
    private $productimage;
     /**
     * @var productcategory
     */
    private $productcategory;
     /**
     * @var productbrand
     */
    private $productbrand;
    /**
     * @var productdiet
     */
    private $productdiet;
	
	/**
     * @var RestaurantBranch
     */
    private $restaurantBranch;

    /**
     * @param Product $product
     * @param ProductImage $productimage
	 * @param RestaurantBranch $restaurantBranch
     */
    public function __construct(
        Product $product,
        ProductImage $productimage,
    		RestaurantBranch $restaurantBranch,
        ProductCategorys $productcategory,
        ProductBrand $productbrand,
        ProductDiet $productdiet


    ) {
        $this->product = $product;
        $this->productimage = $productimage;
        $this->productcategory = $productcategory;
        $this->productbrand = $productbrand;
        $this->productdiet = $productdiet;
	    $this->restaurantBranch = $restaurantBranch;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list()
    {
        $products = $this->product->with('singleProductImage','pCategory','pBrand','pdiet');
		if (auth()->user()->isVender()) {
			$products->where('restaurant_id', $this->restaurantId(auth()->user()->id));
		} else {
			$products->where('user_id', auth()->user()->id);
		}
            
		return $products->orderBy('id', 'DESC')->get();
    }

    /**
     * @param $request
     */
    public function createProduct($request)
    {
      $diet='';
      $category='';
      $brand='';
      if(!empty($request->diet_id))
      {
       $diet= implode(',',$request->dietId());
      }
       if(!empty($request->brand_id))
      {
        $brand= implode(',',$request->brandId());
      }
       if(!empty($request->category_id))
      {
        $category= implode(',',$request->categoryId());
      }

       $instructname='';
       if ($request->hasFile('instruction_img')) {
        $image = $request->file('instruction_img');
        $instructname = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
        $image->move(PRODUCT_ROOT_PATH, $instructname);
      }
		$product = $this->product->create(
            [
                'user_id' => $request->userId(),
                'restaurant_id' => $this->restaurantId($request->userId()),
                'category_id' => $category,
                'brand_id' => $brand,
                'diet_id' => $diet,
              /*  'region_id' => $request->regionId(),*/
                'title' => $request->title(),
                'slug' => app(Controller::class)
                        ->getSlug($request->title(), '', 'products'),
                'price' => $request->price(),
               /* 'discount' => $request->discount(),*/
                'quantity' => isset($request->quantity)?$request->quantity:0,
                'remaining_quantity' => isset($request->quantity)?$request->quantity:0,
                'shipping_type' => isset($request->shipping_type)?$request->shipping_type:'FREE',
                'shipping_price' => $request->shippingPrice(),
                'description' => isset($request->description)?$request->description:'',
                'attribute_id' => $request->attributeIds(),
                'ingredients' => isset($request->ingredients)?$request->ingredients:'',
                'nutrition' => isset($request->nutrition)?$request->nutrition:'',
                'details' => isset($request->details)?$request->details:'',
                'instruction_img' => isset($instructname)?$instructname:'',
                'product_admin_status' => '0'
            ]
        );

         
		$this->productVideo($product->id(), $request->file('video'));
        if(!empty($request->category_id))
        {
          $this->productCategory($product->id(), $request->categoryId());
        }

        if(!empty($request->brand_id))
        {
        $this->productBrands($product->id(), $request->brandId());
        }

        if(!empty($request->diet_id))
        {
          $this->productDiets($product->id(), $request->dietId());
        } 

        $restaurant = Restaurant::find($this->restaurantId($request->userId()));

        Admin_notification::create(['user_id' => auth()->user()->id, 'type' => 'PRODUCT_CREATE', 'message' => $restaurant->name . ' created ' . $request->title() . ' product', 'json_data' => '{}', 'status' => '0']);
		
        return $this->productImage($product->id(), $request->files());
    }

    /**
     * @param $request
     */
    public function updateProduct($request)
    {
      $diet='';
      $category='';
      $brand='';
      if(!empty($request->diet_id))
      {
       $diet= implode(',',$request->dietId());
      }
      if(!empty($request->category_id))
      {
        $category= implode(',',$request->categoryId());
      }
      if(!empty($request->brand_id))
      {
       $brand= implode(',',$request->brandId());
      }

       $instructname=$request->oldinstruction_img;
       if ($request->hasFile('instruction_img')) {
        $image = $request->file('instruction_img');
        $instructname = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
        $image->move(PRODUCT_ROOT_PATH, $instructname);
      }
		$this->product->where('id', $request->id())
            ->update(
                [
                    'category_id' =>$category,
                    'brand_id' => $brand,
                    'diet_id' => $diet,
                   /* 'region_id' => $request->regionId(),*/
                    'title' => $request->title(),
                    //'price' => $request->price(),
                   /* 'discount' => $request->discount(),*/
                    'quantity' => $request->quantity(),
                    'remaining_quantity' => $request->quantity(),
                    'shipping_type' => $request->shippingType(),
                    //'shipping_price' => ($request->shippingType() == 'PAID') ? $request->shippingPrice() : null,
                    'description' => $request->description(),
                    'attribute_id' => $request->attributeIds(),
                    'ingredients' => $request->ingredients(),
                    'nutrition' => $request->nutrition(),
                    'details' => $request->details(),
                    'instruction_img' => $instructname,
                    'product_admin_status' => '0'
                   /* 'reward'  =>  $request->reward,*/
                ]
            );

            if(isset($request->product_image_id)){
              $productimagedata= ProductImage::where('product_id',$request->product_all_id[0])->get();
              $imagedata=$request->product_image_id;
              foreach ($imagedata as $key => $imageid) {
                $this->productimage->where('id', $productimagedata[$key]->id)->update(
                  [ 
                    'image' => $request->product_image_url[$key]
                  ]
                );
              }
            }
            
        $this->productVideo($request->id(),  $request->file('video'));
        
        
        if(!empty($request->diet_id))
        {
         $this->productDiets($request->id(), $request->dietId());
        }
        if(!empty($request->brand_id))
        {
         $this->productBrands($request->id(), $request->brandId());
        }
        if(!empty($request->category_id))
        {
         $this->productCategory($request->id(), $request->categoryId());
        }

        $restaurant = Restaurant::find($this->restaurantId(auth()->user()->id));

        Admin_notification::create(['user_id' => auth()->user()->id, 'type' => 'PRODUCT_UPDATE', 'message' => $restaurant->name . ' updated ' . $request->title() . ' product', 'json_data' => '{}', 'status' => '0']);
            
		return $this->productImage($request->id(), $request->files());
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function deleteProduct(int $id)
    {
        return $this->product->where('id', $id)->delete();
    }

    /**
     * @param $productId
     * @param $images
     * @throws \Exception
     */
    public function productImage($productId, $images)
    {
        if (!empty($images)) {
            foreach ($images as $image) {
                if (!empty($image)) {
                    $data = explode(';', $image);
                    $data1 = explode(',', $image);
                    $extension = explode("/", $data[0]);

                    $fileName = Uuid::uuid4()->toString() . '.'.$extension[1];
                    if (!is_dir(PRODUCT_ROOT_PATH)) {
                        mkdir(PRODUCT_ROOT_PATH);
                    }
                    $ifp = fopen(PRODUCT_ROOT_PATH.$fileName, 'wb');
                    fwrite($ifp, base64_decode($data1[1]));
                    fclose($ifp);
                    if($extension[1]!='mp4')
                    {
                      $img = Image::make(PRODUCT_ROOT_PATH.'/'.$fileName);
                      $img->crop(1024, 680);
                      $croppath =PRODUCT_ROOT_PATH.'/'.$fileName;
                      $img->save($croppath);
                    }
                    $this->productimage->create([
                        'product_id' => $productId,
                        'image' => $fileName,
                    ]);
                }
            }
        }

        return;
    }

    public function productCategory($productId, $category=null)
    {
      $categorys=$this->productcategory->where('p_id',$productId)->first();
      if(!empty($categorys))
      {
        $this->productcategory->where('p_id',$productId)->delete();
      }
        foreach ($category as $key => $value) {
          $this->productcategory->create([
            'p_id'=>$productId,
            'category_id'=>$value,
          ]);
        }
        return;
    }

    public function productBrands($productId, $brand=null)
    { 
      $brands=$this->productbrand->where('p_id',$productId)->first();
      if(!empty($brands))
      {
        $this->productbrand->where('p_id',$productId)->delete();
      }
        foreach ($brand as $key => $value) {
          $this->productbrand->create([
            'p_id'=>$productId,
            'brand_id'=>$value,
          ]);
        }
        return;
    }

    public function productDiets($productId, $diet=null)
    {
      $dietdata=$this->productdiet->where('p_id',$productId)->first();
      if(!empty($dietdata))
      {
        $this->productdiet->where('p_id',$productId)->delete();
      }
        foreach ($diet as $key => $value) {
          $this->productdiet->create([
            'p_id'=>$productId,
            'diet_id'=>$value,
          ]);
        }
        return;
    }

    public function productVideo($productId, $request)
	{
		if (!empty($request)) {
			$image = $request;
            $name = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
            $image->move(PRODUCT_ROOT_PATH, $name);
              
            $this->product->where('id',$productId)->update(['video' => $name]);
        }

        return;
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function productRemoveImage($request)
    {
        $imageId = $request->get('image_id');
        $productImage = $this->productimage->find($imageId)->delete();

        if ($productImage) {
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function productList()
    {
        return $this->product
					->with('singleProductImage','ppcategory','ppdiet','favorite','rating')
					->leftJoin('restaurants', 'products.restaurant_id', '=', 'restaurants.id')
					->where('restaurants.is_active','APPROVED')
          			->where('products.product_admin_status',1)
					->select('products.*')
          ->orderBy('products.sold_out')
					->get();
    }
     public function productBrand($id)
     {
      return $this->product
          ->with('singleProductImage','ppcategory','ppdiet','favorite')
          ->whereRaw("find_in_set('".$id."', brand_id)")
          ->where('product_admin_status',1)
          ->get();
     }

     public function productCategoryFilter($id)
     {
      return $this->product
          ->with('singleProductImage','ppcategory','ppdiet','favorite')
          ->whereRaw("find_in_set('".$id."', category_id)")
          ->where('product_admin_status',1)
          ->get();
     }

      public function productSearchList($result,$order=null)
    {
      if($order){
        return $this->product
          ->with('singleProductImage','ppcategory','ppdiet','favorite')->whereRaw($result)
          ->where('product_admin_status',1)
          ->orderBy('price',$order)
          ->get();
        }
        return $this->product
          ->with('singleProductImage','ppcategory','ppdiet','favorite')->whereRaw($result)
          ->where('product_admin_status',1)
          ->get();
    }
	
    public function productSearch($search)
    {
      return $this->product
					->with('singleProductImage','category','diet','favorite')
					->where('title', 'like', '%' . $search . '%')
          ->where('product_admin_status',1)
					->get();
    }
	
    /**
     * @param $slug
     */
    public function productDetail($slug)
    {
		$product = $this->product->where('slug', $slug);
		
		if(auth()->check()){
			$product->with('ProductImage','category','diet','favorite','user','order', 'avgRating', 'totalRating');
		} else {
			$product->with('ProductImage','category','diet','favorite','user', 'avgRating', 'totalRating');
		}
		
		return $product->first();
    }
	
	private function restaurantId(int $userId) 
	{
		$restaurantBranch = $this->restaurantBranch->where('user_id', $userId)->first();
		
		return !empty($restaurantBranch) ? $restaurantBranch->restaurant_id : ZERO;
	}
}

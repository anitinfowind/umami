<?php

namespace App\Http\Controllers\Backend\Products;

use App\Models\Products\Product;
use App\Models\Products\ProductImage;
use App\Models\Categories\Category;
use App\Models\Brand\Brand;
use App\Models\Diet;
use App\Models\Region;
use App\Models\Products\ProductCategorys;
use App\Models\Products\ProductBrand;
use App\Models\Products\ProductDiet;
use App\Models\ProductAttribute;
use App\Models\Product_review;
use App\Models\Restaurant\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Products\CreateResponse;
use App\Http\Responses\Backend\Products\EditResponse;
use App\Repositories\Backend\Products\ProductRepository;
use App\Http\Requests\Backend\Products\ManageProductRequest;
use App\Http\Requests\Backend\Products\CreateProductRequest;
use App\Http\Requests\Backend\Products\StoreProductRequest;
use App\Http\Requests\Backend\Products\EditProductRequest;
use App\Http\Requests\Backend\Products\UpdateProductRequest;
use App\Http\Requests\Backend\Products\DeleteProductRequest;
use Illuminate\Support\Str;
use Validator;
use Auth;
use DB;
use Image;
use Ramsey\Uuid\Uuid;
use VideoThumbnail;
use FFMpeg;

class ProductsController extends Controller
{
    /**
     * @var ProductRepository
     */
    protected $repository;
    protected $ProductImage;
    protected $product;
    protected $productAttribute;
    protected $productcategory;
    protected $productbrand;
    protected $productdiet;

    /**
     * ProductsController constructor.
     * @param ProductRepository $repository
     */
    public function __construct(ProductImage $ProductImage,ProductRepository $repository,Product $product,ProductAttribute $productAttribute,ProductCategorys $productcategory,ProductBrand $productbrand,ProductDiet $productdiet)
    {
        $this->repository = $repository;
        $this->product = $product;
        $this->ProductImage = $ProductImage;
        $this->productcategory = $productcategory;
        $this->productbrand = $productbrand;
        $this->productdiet = $productdiet;
        $this->productAttribute = $productAttribute;
    }

    /**
     * @param ManageProductRequest $request
     * @return ViewResponse
     */
    public function index(ManageProductRequest $request)
    {  
      $products=  $this->repository->productList();
        return new ViewResponse('backend.products.index', compact('products'));
    }

    /**
     * @param CreateProductRequest $request
     * @return View
     */
    public function create(CreateProductRequest $request)
    {   
        $productAttrs	= $this->productAttribute::where('is_active','ACTIVE')->get();
        $restaurants	= Restaurant::where('is_active', 'APPROVED')->select('id','name')->get();
        $categories		= Category::where('parent_id',0)->select('id','name')->get();
        $brands			= Brand::where('is_active','ACTIVE')->select('id','name')->get();
        $diets			= Diet::where('is_active','ACTIVE')->select('id','name')->get();
        $regions		= Region::where('is_active','ACTIVE')->select('id','name')->get();
		
		//echo '<pre>';print_r($productAttrs);exit;

        return view('backend.products.create', compact('categories','brands','diets','regions','restaurants','productAttrs'));
    }

    /**
     * @param StoreProductRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProductRequest $request)
    {
        //print_r($request->all());die;
       $attributes='';
       if(isset($request->attribute) && !empty($request->attribute))
       {
          $attributes= implode(',', $request->attribute);
       }
          if(!empty($request->file('video')))
           {
             $images = $request->file('video');
             $extnsion= $images->getClientOriginalExtension();
             $request->validate([
              'video'=>'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
             ]);
           }

        $category='';
         if(isset($request->category_id) && !empty($request->category_id) && $request->category_id!='null')
        {
          $category=implode(',', $request->category_id);
        }
         $diet_id='';
        if(isset($request->diet_id) && !empty($request->diet_id) && $request->diet_id!='null')
         {
          $diet_id= implode(',', $request->diet_id);
        }
         $brand_id='';
         if(isset($request->brand_id) && !empty($request->brand_id) && $request->brand_id!='null')
         {
          $brand_id= implode(',', $request->brand_id);
        }

        $userId=  Restaurant::where('id',$request->restaurant_id)->first();

        $product=new Product;
        $product->user_id=$userId->user_id;
        $product->restaurant_id=$request->restaurant_id;
         
        $product->brand_id=$brand_id;
        $product->diet_id=$diet_id;
        $product->category_id=$category;
       // $product->region_id=$request->region_id;
        $product->title=$request->title;
        $product->serving_for=$request->serving_for;
        $product->slug= $this->getSlug($request->title,'','products');
        $product->description=isset($request->description)?$request->description:'';
        $product->price=$request->price;
        //$product->discount=$request->discount;
        $product->quantity=isset($request->quantity)?$request->quantity:0;
        $product->remaining_quantity=isset($request->quantity)?$request->quantity:0;
        $product->shipping_type=isset($request->shipping_type)?$request->shipping_type:'FREE';
        $product->shipping_price=$request->shipping_price;
        $product->attribute_id=$attributes;
        $product->editor_pick=isset($request->editor_pick)?$request->editor_pick:0;
        $product->ingredients=isset($request->ingredients)?$request->ingredients:'';
        $product->nutrition=isset($request->nutrition)?$request->nutrition:'';
        $product->details=isset($request->details)?$request->details:'';
        $product->weight=isset($request->weight)?$request->weight:1;
        $product->height=isset($request->height)?$request->height:1;
        $product->length=isset($request->length)?$request->length:1;
        $product->width=isset($request->width)?$request->width:1;
        $product->daily_limit=isset($request->daily_limit)?$request->daily_limit:0;
        $product->sold_out=isset($request->sold_out)?$request->sold_out:0;
        
          if ($request->hasFile('video')) {
                 $uniqueName = time();
                 $images = $request->file('video');

                 $name = Uuid::uuid4()->toString().'.'.$images->getClientOriginalExtension();
                 $destinationPath = public_path('/uploads/product/');
                     $images->move($destinationPath, $name);
                     //print_r($status);die;
                //$videoSrc = '/' . $destinationPath . '/' . $name;
                //$videoUrl = url('/') . $videoSrc;
                $thumbName = time() . rand(1,10).'.jpg';
                $video_path = public_path('/uploads/product/thumb/');
                 // create thubnail
                \FFMpeg::fromDisk('videos')
                    ->open($name)
                    ->getFrameFromSeconds(2)
                    ->export()
                    ->toDisk('thumnails')
                    ->save($thumbName);

                $vthumb = VideoThumbnail::createThumbnail($video_path, public_path('/uploads/product/thumb/'), $thumbName, 2, 600, 600);
                if ($vthumb) {
                    $product->video_thumb = $thumbName;
                }      
                $product->video = $name;
        }

        $product->save();

        // Start by Infowind
            $addon_label = $request->label;
            $label_options = $request->label_option;
            if (!empty($addon_label)) {
                foreach ($addon_label as $key => $value) {
                    $label = $value;
                    $addon_options = $label_options[$key]['addon_option'];
                    $prices = $label_options[$key]['price'];
                    $shipping_prices = $label_options[$key]['shipping_price'];

                    if (!empty($addon_options)) {
                        foreach ($addon_options as $index => $row) {
                            $addon_data = [
                                'product_id' => $product->id,
                                'label' => trim($label),
                                'option_name' => trim($row),
                                'price' => $prices[$index],
                                'shipping_price' => $shipping_prices[$index]
                            ];
                            DB::table('product_addons')->insert($addon_data);
                        }
                    }
                }
            }
        // End by Infowind
        /*$this->productCategory($product->id, $request->category_id);*/
       $category='';
         if(isset($request->category_id) && !empty($request->category_id) && $request->category_id!='null')
        {
          $this->productCategory($product->id, $request->category_id);
        }
         $diet_id='';
        if(isset($request->diet_id) && !empty($request->diet_id) && $request->diet_id!='null')
         {
          $this->productDiets($product->id, $request->diet_id);
        }
         $brand_id='';
         if(isset($request->brand_id) && !empty($request->brand_id) && $request->brand_id!='null')
         {
          $this->productBrands($product->id, $request->brand_id);
        }
        

        $images = $request->file('image');
        if ($request->hasFile('image')) {
            foreach ($images  as $key => $value) {

                 $name = Uuid::uuid4()->toString().'.'.$value->getClientOriginalExtension();
                 $destinationPath = public_path('/uploads/product/');
                  if($value->getClientOriginalExtension()!='mp4')
                  {
                      $value->move($destinationPath, $name);
                      $img = Image::make(public_path('/uploads/product/'.$name));
                      $img->crop(1024, 680);
                      $croppath = public_path('/uploads/product/').$name;
                      $img->save($croppath);

                      $name2 = 'th_' . $name;
                      $img2 = Image::make($croppath)->resize(500, 332);
                      $croppath2 = public_path('/uploads/product/').$name2;
                      $img2->save($croppath2, 60);
                    }else
                    {
                       $value->move($destinationPath, $name);
                    }
                
                  $productimage= array('product_id'=>$product->id,'image'=>$name);
                DB::table('product_images')->insert($productimage);
              }    
        }
        return new RedirectResponse(route('admin.products.index'),
            ['flash_success' => trans('alerts.backend.products.created')]
        );
    }

    /**
     * @param Product $product
     * @param EditProductRequest $request
     * @return EditResponse
     */
    public function edit(Product $product, EditProductRequest $request)
    {
        return new EditResponse($product);
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //echo '<pre>'; 
        //print_r($request->all());die;
        $productimage= ProductImage::where('product_id',$product['id'])->first();
        if(empty($productimage))
        {
          $validator = Validator::make($request->all(), [
            'image' => 'required',
        ]);

           if ($validator->fails()) {
           return redirect('admin/products/'.$product['id'].'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }
      }
        

        $attributes='';
         if(isset($request->attribute) && !empty($request->attribute))
         {
            $attributes= implode(',', $request->attribute);
         }
         
           if(!empty($request->file('video')))
           {
             $images = $request->file('video');
             $extnsion= $images->getClientOriginalExtension();
             $request->validate([
              'video'=>'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
             ]);
           }
        $product=Product::where('id',$product['id'])->first();

        $diet_id='';
        if(isset($request->diet_id) && !empty($request->diet_id) && $request->diet_id!='null')
         {          
          $diet_id= implode(',', $request->diet_id);
          $this->productDiets($product->id, $request->diet_id);
        }
         $brand_id='';
         if(isset($request->brand_id) && !empty($request->brand_id) && $request->brand_id!='null')
         {
          $brand_id= implode(',', $request->brand_id);
          $this->productBrands($product->id, $request->brand_id);
         }
        
        $category='';
         if(isset($request->category_id) && !empty($request->category_id) && $request->category_id!='null')
        {
          $category=implode(',', $request->category_id);
          $this->productCategory($product->id, $request->category_id);
        }
        $userId=  Restaurant::where('id',$request->restaurant_id)->first();

        $product->category_id=$category;
        $product->brand_id=$brand_id;
        $product->diet_id=$diet_id;
        $product->user_id=isset($userId->user_id)?$userId->user_id:1;
        $product->restaurant_id=$request->restaurant_id;
       // $product->region_id=$request->region_id;
        $product->title=$request->title;
        $product->serving_for=$request->serving_for;
        $product->description=isset($request->description)?$request->description:'';
        $product->price=$request->price;
        $product->quantity=isset($request->quantity)?$request->quantity:0;
        $product->remaining_quantity=isset($request->quantity)?$request->quantity:0;
        $product->shipping_type=$request->shipping_type;
        $product->shipping_price=$request->shipping_price;
        $product->attribute_id=$attributes;
        $product->editor_pick=isset($request->editor_pick)?$request->editor_pick:0;
        $product->ingredients=isset($request->ingredients)?$request->ingredients:'';
        $product->nutrition=isset($request->nutrition)?$request->nutrition:'';
        $product->details=isset($request->details)?$request->details:'';
        $product->weight=isset($request->weight)?$request->weight:1;
        $product->height=isset($request->height)?$request->height:1;
        $product->length=isset($request->length)?$request->length:1;
        $product->width=isset($request->width)?$request->width:1;
        $product->daily_limit=isset($request->daily_limit)?$request->daily_limit:0;
        $product->sold_out=isset($request->sold_out)?$request->sold_out:0;
		$product->is_home_recommended=isset($request->is_home_recommended)?$request->is_home_recommended:'inactive';
		$product->is_home_cat_product=isset($request->is_home_cat_product)?$request->is_home_cat_product:'inactive';
		$product->is_rating_show=isset($request->is_rating_show)?$request->is_rating_show:'N';
         if ($request->hasFile('video')) {
                 $images = $request->file('video');
                 $name = Uuid::uuid4()->toString().'.'.$images->getClientOriginalExtension();
                 $destinationPath = public_path('/uploads/product/');
                 $images->move($destinationPath, $name);
                 $product->video= $name;
        }

        $product->save();

        // Start by Infowind
        $addon_label = $request->label;
        $label_options = $request->label_option;
        if (!empty($addon_label)) {
            DB::table('product_addons')->where('product_id', $product->id)->delete();
            foreach ($addon_label as $key => $value) {
                if(!empty($value) && !empty($label_options[$key]['addon_option'])) {   
                    $label = $value;
                    $addon_options = $label_options[$key]['addon_option'];
                    $prices = $label_options[$key]['price'];
                    $shipping_prices = $label_options[$key]['shipping_price'];

                    if (!empty($addon_options)) {
                        foreach ($addon_options as $index => $row) {
                            $addon_data = [
                                'product_id' => $product->id,
                                'label' => trim($label),
                                'option_name' => trim($row),
                                'price' => $prices[$index],
                                'shipping_price' => $shipping_prices[$index]
                            ];
                            DB::table('product_addons')->insert($addon_data);
                        }
                    }
                }
            }
        }
        // End by Infowind
        
            /*if(isset($request->product_image_id)){
                $productimagedata= ProductImage::where('product_id',$request->product_all_id[0])->get();
            $imagedata=$request->product_image_id;
            foreach ($imagedata as $key => $imageid) {
                    $this->ProductImage->where('id', $productimagedata[$key]->id)->update(
                                [ 
                                  'image' => $request->product_image_url[$key]
                                ]
                              );

                }
            }*/
          if(isset($request->product_image_url)){
            $productimagedata = ProductImage::where('product_id',$product->id)->get();
            foreach ($productimagedata as $k => $v) {
              ProductImage::where('id',$v->id)->update(['image' => $request->product_image_url[$k]]);
            }
          }

        $images = $request->file('image');
        if ($request->hasFile('image')){
          //ProductImage::where('product_id',$product['id'])->delete();
             foreach ($images  as $key => $value)
              {
                  $name = Uuid::uuid4()->toString().'.'.$value->getClientOriginalExtension();
                 $destinationPath = public_path('/uploads/product/');
                  if($value->getClientOriginalExtension()!='mp4')
                  {
                      $value->move($destinationPath, $name);
                      $img = Image::make(public_path('/uploads/product/'.$name));
                      $img->crop(1024, 680);
                      $croppath =PRODUCT_ROOT_PATH.'/'.$name;
                      $img->save($croppath);

                      $name2 = 'th_' . $name;
                      $img2 = Image::make($croppath)->resize(500, 332);
                      $croppath2 = PRODUCT_ROOT_PATH.'/'.$name2;
                      $img2->save($croppath2, 60);
                    }else
                    {
                       $value->move($destinationPath, $name);
                    }
                  $productimage= array('product_id'=>$product->id,'image'=>$name);
                DB::table('product_images')->insert($productimage);
              }

          }

          return redirect('admin/products/'.$product['id'].'/edit')->with(['flash_success' => trans('alerts.backend.products.updated')]);
        /*return new RedirectResponse(route('admin.products.index'),
            ['flash_success' => trans('alerts.backend.products.updated')]
        );*/
    }

     /**
        * Display the specified resource.
        *
        * @param  int  $id
        * @return Response
        */
    public function show($id)
    { 
        // $categorydata = Category::orderBy('order_no','ASC')->get();
        // $productdata=$this->product->with('category')->where('products.is_home_recommended','active')->where('products.product_admin_status',1)->select('products.*')->get();

        //$productdata=$this->product->with('category')->leftJoin('restaurants', 'products.restaurant_id', '=', 'restaurants.id')->where('restaurants.is_active','APPROVED')->where('products.is_home_recommended','active')->where('products.product_admin_status',1)->select('products.*')->get();
       //return view('backend.products.ordersort', compact('productdata','categorydata'));
    }

    /**
     * @param Product $product
     * @param DeleteProductRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(int $id)
    {
         $this->product->where('id',$id)->delete();

        return new RedirectResponse(route('admin.products.index'),
            ['flash_success' => trans('alerts.backend.products.deleted')]
        );
    }

    public function viewProduct(int $id)
    {   
      $productAttrs= $this->productAttribute::where('is_active','ACTIVE')->get();
      $detail= $this->product->with('productImage','category','diet','region','brand','user','restaurant')->where('id',$id)->first();
      
         //echo '<pre>'; print_r($detail);exit;
         return view('backend.products.show', compact('detail','productAttrs'));
    }

    public function subCategory()
    {
        $id=$_REQUEST['id'];
        $data='';
        if(!empty($id)) {
            $subcat=Category::where('parent_id',$id)->get();
           
            if(count($subcat)>0) {
                $data.='<select name="category_id[]" class="form-control tags box-size categories" >
                <option>Product Sub Category</option>';
                foreach($subcat as $cat) {
                    $data.= '<option value="'.$cat->id.'">'.$cat->category_name.'</option>';
                }
                $data.='</select>';
            }
        }

        return $data;
    }

     public function statusProduct($id=null, $status=null)
     {
     
       $this->product->where('id',$id)->update(['product_admin_status'=>$status]);
        return new RedirectResponse(route('admin.products.index'),
            ['flash_success' => trans('Product update status successfully.')]
        );

     }

    public function productCategory($productId, $category=null)
    {
      $categorys=$this->productcategory->where('p_id',$productId)->first();
      if(!empty($categorys))
      {
        $this->productcategory->where('p_id',$productId)->delete();
      }
       if(!empty($category))
       {
            foreach ($category as $key => $value) {
              $this->productcategory->create([
                'p_id'=>$productId,
                'category_id'=>$value,
              ]);
            }
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

        if(!empty($brand))
        {
          foreach ($brand as $key => $value) {
              $this->productbrand->create([
                'p_id'=>$productId,
                'brand_id'=>$value,
              ]);
            }
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
        if(!empty($diet))
        {
           foreach ($diet as $key => $value) {
              $this->productdiet->create([
                'p_id'=>$productId,
                'diet_id'=>$value,
              ]);
            }
        }
        return;
    }

   public function productRemoveImage(UpdateProductRequest $request)
   {
      $imageId = $request->get('image_id');
        $productImage = $this->ProductImage->find($imageId)->delete();
        if ($productImage) {
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            'error' => true
        ]);
    
   }


   public function product_reviews(Request $request)
   {
      $product_reviews = Product_review::with('product', 'user')->orderBy('created_at', 'desc')->get();
      //dd($product_reviews);
      return view('backend.product_reviews', compact('product_reviews'));
   }

   public function delete_review(Request $request)
   {
      $review_id = $request->input('review_id');
      Product_review::where('id', $review_id)->delete();
      return response()->json(['success' => true]);
   }

   public function update_review(Request $request)
   {
      $review_id = $request->input('review_id');
      $review_data = json_decode($request->input('review_data'), true);
      Product_review::where('id', $review_id)->update(['rate_food' => $review_data['rate_food'], 'rate_shipping' => $review_data['rate_shipping'], 'rate_packaging' => $review_data['rate_packaging'], 'rate_instructions' => $review_data['rate_instructions'], 'comment' => $review_data['comment']]);
      return response()->json(['success' => true]);
   }

   public function productOrder()
    { 
        $categorydata = Category::orderBy('order_no','ASC')->get();
        $productdata=$this->product->with('category')->where('products.is_home_cat_product','active')->where('products.product_admin_status',1)->orderBy('order_no','ASC')->orderBy('order_cat_id','ASC')->select('products.*')->get();

        //$productdata=$this->product->with('category')->leftJoin('restaurants', 'products.restaurant_id', '=', 'restaurants.id')->where('restaurants.is_active','APPROVED')->where('products.is_home_recommended','active')->where('products.product_admin_status',1)->select('products.*')->get();
       return view('backend.products.ordersort', compact('productdata','categorydata'));
    }

     public function productOrderSave(Request $request)
     {
      
      $order = !empty($_REQUEST['prodorder'])?$_REQUEST['prodorder']:'';
      //$order = !empty($order)?explode(',',$order):[];      
      $catorder = !empty($_REQUEST['catorder'])?$_REQUEST['catorder']:'';
      
       if(!empty($order) && !empty($catorder)){ 
           foreach($catorder as $k=>$id){
                $cat_id = $id['id'];
                $i = 1;
                 foreach($order as $l=>$value){
                     if($cat_id == $value['category_id'] ){
                        $status = $this->product->where('id',$value['product_id'])->update(['order_no'=>$i,'order_cat_id' => $cat_id ]);
                      $i++;   
                     } 
                 }   
            }

          echo json_encode(['status'=>'success','message'=>__('Sequence successfully updated')]); die;
            
        }
        else{
        echo json_encode(['status'=>'error','message'=>__('Unable to updated sequence')]); die;
      } 
    }
}

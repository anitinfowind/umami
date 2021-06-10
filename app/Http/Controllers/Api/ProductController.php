<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Frontend\Access\User\UserRepository;
use Config;
use Illuminate\Http\Request;
use Validator;
use App\Models\Products\Product; 
use App\Models\Categories\Category; 
use App\Models\Region; 
use App\Models\Diet; 
use App\Models\Brand\Brand; 
use App\Models\Rating;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Repositories\Frontend\Product\ProductRepository;
use DB;
class ProductController extends APIController
{
    protected $repository;
    protected $product;

    /**
     * __construct.
     *
     * @param $repository
     */
     /**
     * @var ProductRepository
     */
    protected $productRepository;

    public function __construct(UserRepository $repository, ProductRepository $productRepository,Product $product)
    {
        $this->repository = $repository;
        $this->product = $product;
        $this->productRepository = $productRepository;
    }

    /**
     * Register User.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function category(Request $request)
    {
       if (isset($request->user_id) && !empty($request->user_id))
       {
        $category= Product::with('category')->where('user_id',$request->user_id)->get();
        if(count($category)>0)
        {
          $dataresult['status']='1';
          $dataresult['message']='Category data get successfully.';
          $dataresult['category']='';
          $dataresult1=array();
          foreach ($category as $key => $value) {
            $dataresult1[$key]['id']=$value->category->id;
            $dataresult1[$key]['name']=$value->category->name;
          }
            $dataresult['category']=$dataresult1;
            return $this->respond($dataresult);
        } else {
            $dataresult['status']='0';
            $dataresult['message']='User id not match';
            return $this->respond($dataresult);
        }
       } else {
           $category= Category::where('is_active','ACTIVE')->get();
            $dataresult['status']='1';
            $dataresult['message']='Category data get successfully.';
            $dataresult['category']='';
            $dataresult1=array();

            foreach ($category as $key => $value) {
                 $dataresult1[$key]['id']=$value->id;
                 $dataresult1[$key]['name']=$value->name;
            }
            $dataresult['category']=$dataresult1;
            return $this->respond($dataresult);
       }
    }

    public function region(Request $request)
    {
       if (isset($request->user_id) && !empty($request->user_id))
       {
        $regions= Product::with('region')->where('user_id',$request->user_id)->get();
        if(count($regions)>0)
        {
          $dataresult['status']='1';
          $dataresult['message']='Region data get successfully.';
          $dataresult['region']='';
          $dataresult1=array();
          foreach ($regions as $key => $value) {
            $dataresult1[$key]['id']=$value->region->id;
            $dataresult1[$key]['name']=$value->region->name;
          }
            $dataresult['region']=$dataresult1;
            return $this->respond($dataresult);
        } else {
            $dataresult['status']='0';
            $dataresult['message']='user id not match';
            return $this->respond($dataresult);
        }
       } else {
           $regions= Region::where('is_active','ACTIVE')->get();
            $dataresult['status']='1';
            $dataresult['message']='Region data get successfully.';
            $dataresult['region']='';
            $dataresult1=array();

            foreach ($regions as $key => $value) {
                $dataresult1[$key]['id']=$value->name;
                $dataresult1[$key]['name']=$value->name;
            }
            $dataresult['region']=$dataresult1;
            return $this->respond($dataresult);
       }
    }

    public function diet(Request $request)
    {
       if (isset($request->user_id) && !empty($request->user_id))
       {
        $category= Product::with('diet')->where('user_id',$request->user_id)->get();
        if(count($category)>0)
        {
          $dataresult['status']='1';
          $dataresult['message']='Diet data get successfully.';
          $dataresult['diet']='';
          $dataresult1=array();
          foreach ($category as $key => $value) {
            $dataresult1[$key]['id']=$value->diet->id;
            $dataresult1[$key]['name']=$value->diet->name;
          }
            $dataresult['diet']=$dataresult1;
            return $this->respond($dataresult);
        } else {
            $dataresult['status']='0';
            $dataresult['message']='user id not match';
            return $this->respond($dataresult);
        }
       } else {
           $category= Diet::where('is_active','ACTIVE')->get();
            $dataresult['status']='1';
            $dataresult['message']='Diet data get successfully.';
            $dataresult['diet']='';
            $dataresult1=array();

            foreach ($category as $key => $value) {
                 $dataresult1[$key]['id']=$value->id;
                 $dataresult1[$key]['name']=$value->name;
            }
            $dataresult['diet']=$dataresult1;
            return $this->respond($dataresult);
       }
    }

    public function brand(Request $request)
    {
       if (isset($request->user_id) && !empty($request->user_id))
       {
        $category= Product::with('brand')->where('user_id',$request->user_id)->get();
        if(count($category)>0)
        {
          $dataresult['status']='1';
          $dataresult['message']='Brand data get successfully.';
          $dataresult['brands']='';
          $dataresult1=array();
          foreach ($category as $key => $value) {
            $dataresult1[$key]['id']=$value->brand->id;
            $dataresult1[$key]['name']=$value->brand->name;
          }
            $dataresult['brands']=$dataresult1;
            return $this->respond($dataresult);
        } else {
            $dataresult['status']='0';
            $dataresult['message']='user id not match';
            return $this->respond($dataresult);
        }
       } else {
           $category= Brand::where('is_active','ACTIVE')->get();
            $dataresult['status']='1';
            $dataresult['message']='Brand data get successfully.';
            $dataresult['brands']='';
            $dataresult1=array();

            foreach ($category as $key => $value) {
                 $dataresult1[$key]['id']=$value->id;
                 $dataresult1[$key]['name']=$value->name;
            }
            $dataresult['brands']=$dataresult1;
            return $this->respond($dataresult);
       }
    }

     public function country()
     {
       $countrys= Country::get();
       $countrydata['status']='1';
       $countrydata['message']='Country data get successfully.';
       $countrydata['country']='';
        $countryresult=array();
       foreach ($countrys as $key => $country) {
        $countryresult[$key]['id']=$country->id;
        $countryresult[$key]['name']=$country->name;
       }
       $countrydata['country']= $countryresult;
       return $this->respond($countrydata);
     }

     public function state(Request $request)
     {
        if(isset($request->country_id) && !empty($request->country_id))
        {
           $states= State::where('country_id',$request->country_id)->get();
           $statedata['status']='1';
           $statedata['message']='State data get successfully.';
           $statedata['states']='';
           $stateresult=array();
           foreach ($states as $key => $state) {
            $stateresult[$key]['id']=$state->id;
            $stateresult[$key]['name']=$state->name;
           }
           $statedata['states']= $stateresult;
           return $this->respond($statedata);
        } else {
            $statedata['status']='0';
            $statedata['message']='Country Id empty.';
           return $this->respond($statedata);
        }
     }

     public function city(Request $request)
     {
        if(isset($request->state_id) && !empty($request->state_id))
        {
           $cities= City::where('state_id',$request->state_id)->get();
           $citidata['status']='1';
           $citidata['message']='City data get successfully.';
           $citidata['cities']='';
           $cityresult=array();
           foreach ($cities as $key => $city) {
            $cityresult[$key]['id']=$city->id;
            $cityresult[$key]['name']=$city->name;
           }
           $citidata['cities']= $cityresult;
           return $this->respond($citidata);
        } else {
            $citidata['status']='0';
            $citidata['message']='State Id empty.';
           return $this->respond($citidata);
        }
     }

     public function allProductType()
     {
        $dataresult['status']='1';
        $dataresult['message']='Data get successfully.';
        $category= Category::where('is_active','ACTIVE')->get();
          
          $dataresult['category']='';
          $dataresult1=array();

          foreach ($category as $key => $value) {
               $dataresult1[$value->id]=$value->name;
          }
          $dataresult['category']=$dataresult1;


          $regions= Region::where('is_active','ACTIVE')->get();
            $dataresult['region']='';
            $dataresult1=array();

            foreach ($regions as $key => $region) {
                 $dataresult1[$region->id]=$region->name;
            }
            $dataresult['region']=$dataresult1;

          $diets= Diet::where('is_active','ACTIVE')->get();
            $dataresult['diet']='';
            $dataresult1=array();

            foreach ($diets as $key => $diet) {
                 $dataresult1[$diet->id]=$diet->name;
            }
            $dataresult['diet']=$dataresult1;

          $brands= Brand::where('is_active','ACTIVE')->get();
            $dataresult['brands']='';
            $dataresult1=array();

            foreach ($brands as $key => $brand) {
                 $dataresult1[$brand->id]=$brand->name;
            }

            $dataresult['brands']=$dataresult1;
            return $this->respond($dataresult);
     }

     public function allCountryData()
     {
       $alldata['status']='1';
       $alldata['message']='All country data get successfully.';
       $countrys= Country::get();
       $alldata['country']='';
        $countryresult=array();
       foreach ($countrys as $key => $country) {
        $countryresult[$key]['id']=$country->id;
        $countryresult[$key]['name']=$country->name;
       }

       $alldata['country']= $countryresult;
       $states= State::where('country_id',101)->get();
         $alldata['states']='';
         $stateresult=array();
         foreach ($states as $key => $state) {
          $stateresult[$key]['id']=$state->id;
          $stateresult[$key]['name']=$state->name;
         }
         $alldata['states']= $stateresult;

       $cities= City::where('state_id',3)->get();
         $alldata['cities']='';
         $cityresult=array();
         foreach ($cities as $key => $city) {
          $cityresult[$key]['id']=$city->id;
          $cityresult[$key]['name']=$city->name;
         }
         $alldata['cities']= $cityresult;
       $categorys= Category::where('is_active','ACTIVE')->get();
          
          $alldata['category']='';
          $dataresult1=array();
          foreach ($categorys as $key => $category) {
             $dataresult1[$key]['id']=$category->id;
             $dataresult1[$key]['name']=$category->name;
          }

          $alldata['category']=$dataresult1;
         return $this->respond($alldata); 
     } 

     public function prodctsDetail(Request $request)
     {
       $slug=$request->get('slug');
       $details = $this->productRepository->productDetail($slug);
      
     //  echo '<pre>'; print_r($details); exit;
       if(!empty($details))
       {
         $restaurantname=restaurantName($details->restaurant_id);
         $productrating=$this->getRating($details->id);
                $ratingreview='';
                $totaluser='';
                if(count($productrating)>0)
                {
                  $totalsum=collect($productrating)->sum('average_rating');
                  $totaluser= count($productrating);
                  $ratingreview=($totalsum/$totaluser);
                }
            $productdata['totaluser']=$totaluser;
            $productdata['rating']=$ratingreview;
            $productdata['title']= $details->title;
            $productdata['restaurantname']= isset($restaurantname)?$restaurantname:'';
            if(isset($details->favorite->id)&& !empty($details->favorite->id))
            {
               $productdata['is_favorite']='1' ;

            }else{
                $productdata['is_favorite']='0' ;
            }
          
            $productdata['product_id']= $details->id;
            $productdata['slug']= $details->slug;
            $productdata['quantity']= $details->quantity;
            $productdata['price']= $details->price;
            $productdata['discount']= $details->discount;
            $productdata['shipping_type']= $details->shipping_type;
            $productdata['shipping_price']= $details->shipping_price;
            $productdata['editor_pick']= $details->editor_pick;
            $productdata['description']= $details->description;
            $productdata['ingredients']= $details->ingredients;
            $productdata['nutrition']= $details->nutrition;
            $productdata['details']= $details->details;
            $productdata['video']= url('uploads/product').'/'.$details->video;
            $productdata['vendor_fname']= isset($details->user->first_name)?$details->user->first_name:'';
            $productdata['vendor_lname']= isset($details->user->last_name)?$details->user->last_name:'';
            $productdataimage=array();
            foreach ($details->ProductImage as $key => $image) {
              $productdataimage[$key]['image']= url('uploads/product').'/'.$image->image;
            }
         $productdata['image']=$productdataimage;


          $getres= DB::table('products')->where('restaurant_id',$details->restaurant_id)->groupBy('user_id')->pluck('user_id')->toArray();

         $productdatare= DB::table('orders')
              ->select('product_id', DB::raw('count(*) as total'))
              ->whereIn('vendor_id',$getres)
              ->groupBy('product_id')
              ->orderBy('total','desc')
              ->limit(TEN)
              ->pluck('product_id')->toarray();
          $productsrecomms=$this->product->whereIn('id',$productdatare)->with('singleProductImage','category','region')->get(); 
           $recommendeddata=array();
          foreach ($productsrecomms as $re => $productsrecomm)
          {
               $productrating=$this->getRating($productsrecomm->id);
                $ratingreview='';
                $totaluser='';
                if(count($productrating)>0)
                {
                  $totalsum=collect($productrating)->sum('average_rating');
                  $totaluser= count($productrating);
                  $ratingreview=($totalsum/$totaluser);
                }

              $restaurantname=restaurantName($productsrecomm->restaurant_id);
              $recommendeddata[$re]['restaurant_name']= $restaurantname;
              $recommendeddata[$re]['ratingreview']= $ratingreview;
              $recommendeddata[$re]['total_user']= $totaluser;
              if(isset($productsrecomm->singleProductImage->image) && !empty($productsrecomm->singleProductImage->image))
              {
               $recommendeddata[$re]['image']=url('uploads/product').'/'.$productsrecomm->singleProductImage->image;
              }
              else
              {
                 $recommendeddata[$re]['image']=url('images/no-product-image.png');
              }
              $recommendeddata[$re]['slug']=$productsrecomm->slug;
              $recommendeddata[$re]['title']=$productsrecomm->title;
              $recommendeddata[$re]['price']=$productsrecomm->price;
              $recommendeddata[$re]['quantity']=$productsrecomm->quantity;
            
          }



          return $this->respond([
                      'status'=>'1',
                      'message'=>'Get product successfully',
                      'data'=>$productdata,
                      'recommended'=>$recommendeddata,
                    ]);
       }
       else
       {
         return $this->respond([
                      'status'=>'0',
                      'message'=>'Product Not found.'
                    ]);

       }

     }

     public function getRating($id=null)
     {
          $rating= Rating::where('product_id',$id)->get();
           return $rating ;
     }
}

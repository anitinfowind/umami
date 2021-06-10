<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faqs\Faq;
use App\Models\Slider\Slider;
use App\Models\Banner;
use App\Models\Rating;
use App\Models\Brand\Brand;
use App\Models\Products\Product;
use App\Models\Categories\Category;
use Illuminate\Http\Request;
use DB;
class FrontendController extends APIController
{
 
    /**
     * @var Faq
     */
    private $faq;
    /**
     * @var Product
     */
    protected $product;
    /**
     * @var Category
     */
    protected $category;
   /**
     * @param PagesRepository $pagesRepository
     * @param Slider $slider
     * @param Faq $faq
     * @param Brand $brand
     */
    public function __construct( 
      Faq $faq,Product $product,
        Category $category
    ) {
        $this->faq = $faq;
        $this->product = $product;
        $this->category = $category;

      }
    /**
     * @return View
     */
    public function faq(Request $request)
    {
        $faqs = $this->faq->where('status', ONE)->orderBy('created_at', 'desc')->get();
       $faqdata= array();
        foreach ($faqs as $key => $value) {
          $faqdata[$key]['question']=$value->question;
          $faqdata[$key]['answer']=$value->answer;
        }
          return $this->respond([
            'status'=>'1',
            'message'=>'Faq list data.',
            'data'=>$faqdata,
          ]);
    }

    public function homeData(Request $request)
    {
      $sliders= Slider::where('status',1)->get();
      $sliderdata=array();
      foreach ($sliders as $key => $slider) {
        $sliderdata[$key]['image']=url('uploads/slider').'/'.$slider->slider_image;
        $sliderdata[$key]['title']=$slider->title;
        $sliderdata[$key]['description']=$slider->description;
      }

      $brands= Brand::where('is_active',ACTIVE)->get();
      $branddata=array();
      foreach ($brands as $b => $brand) {
        $branddata[$b]['image']=url('uploads/brand').'/'.$brand->image;
        $branddata[$b]['slug']=$brand->slug;
        $branddata[$b]['name']=$brand->name;
      }

      $banners= Banner::where('is_active',ACTIVE)->orderBy('id','DESC')->limit(TWO)->get();
      $bannerdata=array();
      foreach ($banners as $ba => $banner) {
        $bannerdata[$ba]['image']=url('uploads/banner').'/'.$banner->image;
      }

        $categoryproduct=array();
        $category= $this->category->get();
        foreach ($category as $key => $value) {
        $categoryproduct[$key]['category']=$value->name;
        $categoryproduct[$key]['product']= $this->product
          ->with('singleProductImage','favorite')
          ->where('category_id',$value->id)
          ->where('product_admin_status',1)
          ->get();
        }
        

         $packages=$this->product->with('singleProductImage')->orderBy('id','desc') ->where('product_admin_status',1)->where('shipping_type','PAID')->limit(TEN)->get();
          $packagedata=array();
          foreach ($packages as $p => $package) {
            if(isset($package->singleProductImage->image) && !empty($package->singleProductImage->image))
            {
              $productrating=$this->getRating($package->id);
                $ratingreview='';
                $totaluser='';
                if(count($productrating)>0)
                {
                  $totalsum=collect($productrating)->sum('average_rating');
                  $totaluser= count($productrating);
                  $ratingreview=($totalsum/$totaluser);
                }
              $restaurantname=restaurantName($package->restaurant_id);
              $packagedata[$p]['restaurant_name']= $restaurantname;
              $packagedata[$p]['ratingreview']= $ratingreview;
              $packagedata[$p]['total_user']= $totaluser;
              if(isset($package->singleProductImage->image) &&!empty($package->singleProductImage->image))
                {
                 $packagedata[$p]['image']=url('uploads/product').'/'.$package->singleProductImage->image;
                }
                else
                {
                  $packagedata[$p]['image']=url('images/no-product-image.png');
                }
              
              $packagedata[$p]['slug']=$package->slug;
              $packagedata[$p]['product_id']=$package->id;
              $packagedata[$p]['restaurant_id']=$package->restaurant_id;
              $packagedata[$p]['title']=$package->title;
              $packagedata[$p]['price']=$package->price;
              $packagedata[$p]['quantity']=$package->quantity;
            }
          }
             

           $flashs=$this->product->with('singleProductImage')->orderBy('id','desc') ->where('product_admin_status',1)->where('shipping_type','FREE')->limit(SIX)->get();
           $flashdata=array();
          foreach ($flashs as $f => $flash) {
           
              $productrating=$this->getRating($flash->id);
                $ratingreview='';
                $totaluser='';
                if(count($productrating)>0)
                {
                  $totalsum=collect($productrating)->sum('average_rating');
                  $totaluser= count($productrating);
                  $ratingreview=($totalsum/$totaluser);
                }
              $restaurantname=restaurantName($flash->restaurant_id);

              $flashdata[$f]['restaurant_name']= $restaurantname;
              $flashdata[$f]['ratingreview']= $ratingreview;
              $flashdata[$f]['total_user']= $totaluser;
              if(isset($flash->singleProductImage->image) &&!empty($flash->singleProductImage->image))
              {
                $flashdata[$f]['image']=url('uploads/product').'/'.$flash->singleProductImage->image;
              }
              else
              {
                $flashdata[$f]['image']=url('images/no-product-image.png');
              }
              
              $flashdata[$f]['slug']=$flash->slug;
              $flashdata[$f]['product_id']=$flash->id;
              $flashdata[$f]['restaurant_id']=$flash->restaurant_id;
              $flashdata[$f]['title']=$flash->title;
              $flashdata[$f]['price']=$flash->price;
              $flashdata[$f]['quantity']=$flash->quantity;
          }

           $order = DB::table('orders')
                        ->select('product_id', DB::raw('count(*) as total'))
                        ->groupBy('product_id')
                        ->orderBy('total','desc')
                        ->limit(TEN)
                ->pluck('product_id')->toarray();

          $productsrecomms=$this->product->whereIn('id',$order)->with('singleProductImage') ->where('product_admin_status',1)->get();
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
              if(isset($productsrecomm->singleProductImage->image) &&!empty($productsrecomm->singleProductImage->image))
              {
               $recommendeddata[$re]['image']=url('uploads/product').'/'.$productsrecomm->singleProductImage->image;
              }
              else
              {
                $recommendeddata[$re]['image']=url('images/no-product-image.png');
              }
             
              $recommendeddata[$re]['slug']=$productsrecomm->slug;
              $recommendeddata[$re]['product_id']=$productsrecomm->id;
              $recommendeddata[$re]['restaurant_id']=$productsrecomm->restaurant_id;
              $recommendeddata[$re]['title']=$productsrecomm->title;
              $recommendeddata[$re]['price']=$productsrecomm->price;
              $recommendeddata[$re]['quantity']=$productsrecomm->quantity;
          }

          $catproductss=array();
         foreach ($categoryproduct as $cp => $categoryps)
         {
            $catproductss[$cp]['category_name']=$categoryps['category'];
            $proouctcat=$categoryps['product'];
            foreach($proouctcat as $cc=> $product)
            {
              
                $productrating=$this->getRating($product->id);
                $ratingreview='';
                $totaluser='';
                if(count($productrating)>0)
                {
                  $totalsum=collect($productrating)->sum('average_rating');
                  $totaluser= count($productrating);
                  $ratingreview=($totalsum/$totaluser);
                }
                 $restaurantname=restaurantName($product->restaurant_id);
                 $catproductss[$cp]['product'][$cc]['restaurant_name']=$restaurantname;
                 $catproductss[$cp]['product'][$cc]['ratingreview']= $ratingreview;
                 $catproductss[$cp]['product'][$cc]['total_user']= $totaluser;
                  if(isset($product->singleProductImage->image) &&!empty($product->singleProductImage->image))
                  {
                   $catproductss[$cp]['product'][$cc]['image']=url('uploads/product').'/'.$product->singleProductImage->image;
                  }
                  else
                  {
                     $catproductss[$cp]['product'][$cc]['image']=url('images/no-product-image.png');
                  }
                
                 $catproductss[$cp]['product'][$cc]['slug']=$product->slug;
                 $catproductss[$cp]['product'][$cc]['product_id']=$product->id;
                 $catproductss[$cp]['product'][$cc]['restaurant_id']=$product->restaurant_id;
                 $catproductss[$cp]['product'][$cc]['title']=$product->title;
                 $catproductss[$cp]['product'][$cc]['price']=$product->price;
                 $catproductss[$cp]['product'][$cc]['quantity']=$product->quantity;
            }
        }
       return $this->respond([
            'status'=>'1',
            'slider'=>$sliderdata,
            'brand'=>$branddata,
            'banner'=>$bannerdata,
            'categoryProduct'=>$catproductss,
            'package'=>$packagedata,
            'flashs'=>$flashdata,
            'recommanded'=>$recommendeddata,

          ]);



    }

   public function getRating($id=null)
   {
        $rating= Rating::where('product_id',$id)->get();
         return $rating ;
   }

}

<?php

namespace App\Http\Controllers\Frontend\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Categories\Category;
use App\Models\Brand\Brand;
use App\Models\Products\Product;
use App\Models\Products\ProductImage;
use App\Models\Products\ProductInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;
use DB;
use Auth;
/**
 * Class ProductController.
 */
class ProductController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
      $getproduct=Product::where('products.user_id',Auth()->user()->id)
                  ->leftjoin('product_images','product_images.p_id','=','products.id')
                  ->leftjoin('product_informations','product_informations.product_id','products.id')
                  ->select('products.*','product_images.image','product_informations.sale_price')
                  ->where('product_images.default',1)
                  ->orderby('products.id','DESC')
                  ->get();
                //  echo '<pre>'; print_r($getproduct);exit;

        return view('frontend.vendor.product.index', compact('getproduct'));
    }
   public function addProduct()
   {
       $categorys =Category::where('is_active','ACTIVE')->where('parent_id',0)->get();

    $brands=Brand::where('is_active','ACTIVE')->get();
    return view('frontend.vendor.product.create', compact('categorys','brands'));
   }

    public function saveproduct(Request $request)
    {
      $request->validate([
      'name' => 'required',
      'price' => 'required|numeric',
      'quantity' => 'required|numeric',
    ]);
       
     $category =$request->category_id;
      $productadd=new Product;
      $productadd->user_id=Auth::user()->id;
      $productadd->category_id=end($category);
      $productadd->brand_id=$request->brand_id;
      $productadd->name=$request->name;
      $productadd->description=$request->description;
      $productadd->price=$request->price;
      $productadd->quantity=$request->quantity;
      $productadd->status=isset($request->status)?1:0;
      $productadd->save();
      $images = $request->file('image');
         if ($request->hasFile('image'))
         {
             foreach ($images  as $key => $value)
              {
                $default=0;
                if($key==0)
                {
                  $default=1;
                }
                
                 $name = rand(11111, 99999).'.'.$value->getClientOriginalExtension();
                 $destinationPath = public_path('/product/');
                 $value->move($destinationPath, $name);
                  $productimage= array('p_id'=>$productadd->id,'image'=>$name,'default'=>$default);
                DB::table('product_images')->insert($productimage);
              }    
          }
        $productinfo=new ProductInformation;
        $productinfo->product_id=$productadd->id;
        $productinfo->title=$request->name;
        $productinfo->description=$request->description;
        $productinfo->slug=Str::slug($request->name);
        $productinfo->sku='UMAMIP'.rand(111,999);
        $productinfo->main_price=$request->price;
        $productinfo->quantity=$request->quantity;
        $productinfo->remaining=$request->quantity;
        $productinfo->sale_price=$request->sale_price;
        $productinfo->save();

        return redirect()->route('frontend.vendor.product')->withFlashSucess('alerts.backend.products.created');

    }

     public function productEdit($id=null)
     {
        $categorys=Category::where('status',1)->where('parent_id',0)->get();
        $brands=Brand::where('status',1)->get();

        $editproduct=Product::where('products.user_id',Auth()->user()->id)
                  ->leftjoin('product_images','product_images.p_id','=','products.id')
                  ->leftjoin('product_informations','product_informations.product_id','products.id')
                  ->select('products.*','product_images.image','product_informations.sale_price')
                  ->where('products.id',$id)
                  ->first();
          $getimage=ProductImage::where('p_id',$id)->get();
        return view('frontend.vendor.product.edit', compact('editproduct','categorys','brands','getimage'));
     }

      public function productDelete($id=null)
      {
         Product::where('id',$id)->update(['deleted_at'=>now()]);
         return redirect()->back()->withFlashSucess('Product Deleted Ssuccessfully');

      }
     public function productUpdate(Request $request,$productid=null)
     {
          $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
          ]);
        $cid = $request->category_id;
        $product=Product::where('id',$productid)->first();
        $product->user_id=Auth::user()->id;
        $product->category_id=end($cid);
        $product->brand_id=$request->brand_id;
        $product->name=$request->name;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->quantity=$request->quantity;
        $product->status=isset($request->status) ? 1 : 0;
        $product->save();
        $images = $request->file('image');
           if ($request->hasFile('image'))
           {
             DB::table('product_images')->where('p_id',$productid)->delete();
               foreach ($images  as $key => $value)
                {
                  $default=0;
                  if($key==0)
                  {
                    $default=1;
                  }
                  
                   $name = rand(11111, 99999).'.'.$value->getClientOriginalExtension();
                   $destinationPath = public_path('/product/');
                   $value->move($destinationPath, $name);
                    $productimage= array('p_id'=>$product->id,'image'=>$name,'default'=>$default);
                  DB::table('product_images')->insert($productimage);
                }    
            }

          $productinfo=ProductInformation::where('product_id',$productid)->first();
          if(empty( $productinfo))
          {
            $productinfo= new ProductInformation;
            $productinfo->product_id=$product->id;
            $productinfo->slug=Str::slug($request->name);
            $productinfo->sku='UMAMIP'.rand(111,999);
          }
            $productinfo->title=$request->name;
            $productinfo->description=$request->description;
            $productinfo->main_price=$request->price;
            $productinfo->quantity=$request->quantity;
            $productinfo->remaining=$request->quantity;
            $productinfo->sale_price=$request->sale_price;
            $productinfo->save();


          return redirect()->route('frontend.vendor.product')->withFlashSucess('alerts.backend.products.updated');
      }
}

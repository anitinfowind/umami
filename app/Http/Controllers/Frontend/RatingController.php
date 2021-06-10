<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Rating;
use App\Models\OrderDetail;
use App\Models\Restaurant\RestaurantBranch;
use App\Models\Products\Product;
use App\Models\Product_review;
class RatingController extends Controller
{
    /**
     * @return View
     */
        /**
     * @var rating
     */
      private $rating;
        /**
     * @var RestaurantBranch
     */
    private $restaurantBranch;
  
  /**
     * @var Product
     */
    private $product;
    public function __construct(Rating $rating,RestaurantBranch $restaurantBranch,Product $product){
      $this->rating = $rating;
      $this->restaurantBranch = $restaurantBranch;
      $this->product = $product;

    } 
    public function userRating(Request $request)
    {
     $ratingdata= Rating::where('user_id',auth()->user()->id)->where('product_id',$request->productid)->where('order_id',$request->orderid)->first();
      //echo '<pre>'; print_r( $ratingdata);
       if(isset($ratingdata) && !empty($ratingdata))
       {
       }
       else {
         $ratingdata= new Rating;
         $ratingdata->user_id=auth()->user()->id;
       }
       $overall=($request->taste+$request->shipping+$request->visual+$request->deliver)/4;
         $total=  number_format($overall,2);
         $ratingdata->product_id=$request->productid;
         $ratingdata->order_detail_id=$request->order_detail_id;
         $ratingdata->order_id=$request->orderid;
         $ratingdata->average_rating=$total;
         $ratingdata->taste=$request->taste;
         $ratingdata->shipping=$request->shipping;
         $ratingdata->visual=$request->visual;
         $ratingdata->deliver=$request->deliver;
         $ratingdata->comment=$request->comment;
         $ratingdata->type='product';
         $ratingdata->save();

         session()->put('rating',
        [
          'title' => trans('Rating'),
          'msg' => trans('Rating update successfully.')
        ]
      );
        return redirect()->back();
    }

    public function ratingList()
    {
       //$ratings= $this->ratingData();
      //$product_reviews = Product_review::with('product', 'user')->where('products.user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
      $user_id = auth()->user()->id;
      $product_reviews = Product_review::with(['product' => function($query) use($user_id)
          {
              $query->where('user_id', '=', $user_id);
          }, 'user'
      ])->orderBy('created_at', 'desc')->get();
      //dd($product_reviews);
      return view('frontend.rating.rating-list', compact('product_reviews'));
    }

    public function ratingData()
    {
       $restaurantId = $this->restaurantBranch->where('user_id', auth()->user()->id)->value('restaurant_id');
        if(auth()->user()->isVender()){
          $productIds = $this->product->where('restaurant_id', $restaurantId)->pluck('id');
        } else {
          $productIds = $this->product->where('restaurant_id', $restaurantId)->where('user_id', auth()->user()->id)->pluck('id');
        }
        
        return $this->rating->whereIn('product_id', $productIds)
            ->with('product','DetailProduct')
            ->orderBy('created_at','desc')
            ->paginate(PAGINATION);
    }

    public function userRatingList()
    {
      $lists= $this->rating->where('user_id',auth()->user()->id)->with('product')->orderBy('id','DESC')->get();
       return view('frontend.rating.rating-user', compact('lists'));
       //echo '<pre>'; print_r($lists);
    }

}
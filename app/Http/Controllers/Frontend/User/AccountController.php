<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\ChangePasswordRequest;
use App\Http\Requests\Frontend\User\FavoriteRequest;
use App\Http\Requests\Frontend\User\ProfileShowRequest;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Models\Favorite;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use App\Models\Access\User\User;
use App\Repositories\Frontend\Access\User\UserRepository;
use DB;
class AccountController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Favorite
     */
    private $favorite;

    /**
     * @var Product
     */
    private $product;

    /**
     * @param UserRepository $userRepository
     * @param Favorite $favorite
     * @param Product $product
     */
    public function __construct(
        UserRepository $userRepository,
        Favorite $favorite,
        Product $product
    ) {
        $this->userRepository = $userRepository;
        $this->favorite = $favorite;
        $this->product = $product;
    }

    /**
     * @param ProfileShowRequest $request
     * @return View
     */
    public function index(ProfileShowRequest $request)
    {
        return view('frontend.user.account');
    }

    /**
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->userRepository->updateProfile($request);

        session()->put('update-profile',
            [
                'title' => 'Profile',
                'msg' => trans('Your profile has been successfully updated.')
            ]
        );

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param ChangePasswordRequest $request
     * @return mixed
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        return $this->userRepository->updatePassword($request);
    }

    /**
     * @return View
     */
    public function wishList()
    {
        if (auth()->user()->isUser()) {
            $favorites = $this->favorite->with('user','product')
                            ->where('user_id', auth()->user()->id)
                            ->orderBy('id', 'desc')
                            ->paginate(PAGINATION);
        } else {
            $productIds = $this->product->where('user_id', auth()->user()->id)->pluck('id')->all();
            $favorites = $this->favorite->with('user','product')
                              ->whereIn('product_id', $productIds)
                              ->orderBy('id', 'desc')
                              ->paginate(PAGINATION); 
        }

        return view('frontend.wishlist.wishlist',
            compact('favorites')
        );
    }

    /**
     * @param FavoriteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function favourite(FavoriteRequest $request)
    {
        if ($request->ajax()) {
            $favorite = $this->favorite->where('product_id', $request->productId())
                            ->where('user_id', auth()->user()->id)
                            ->first();
            $is_fav = 0;
            if (empty($favorite)) 
            {
                $this->favorite->create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $request->productId()
                ]);
                $is_fav = 1;
            } 
            else 
            {
                $this->favorite
                        ->where('product_id', $request->productId())
                        ->where('user_id', auth()->user()->id)
                        ->delete();
                $is_fav = 0;
            }

            return response()->json([
                'success' => 1,
                'is_fav'=>$is_fav
            ]);
        }

        return response()->to('/');
    }

    public function favouriteCheck(FavoriteRequest $request)
    {
        if ($request->ajax()) {
            $favorite = $this->favorite->where('product_id', $request->productId())
                            ->where('user_id', auth()->user()->id)
                            ->first();
            $is_fav = 0;
            if (empty($favorite)) 
            {
                $is_fav = 1;
            } 
            else 
            {
                $is_fav = 0;
            }

            return response()->json([
                'success' => 1,
               'is_fav_check'=>$is_fav
            ]);
        }

        return response()->to('/');
    }

    /**
     * @param FavoriteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFavorite(FavoriteRequest $request)
    {
        if ($request->ajax()) {
            $this->favorite->where('id', $request->get('favorite_id'))->delete();

            return response()->json([
                  'success' => true
            ]);
        }

        return response()->to('/');
    }

    public function paymentMethod(Request $request)
    {
      echo '<pre>'; print_r($request->all()); exit;
    } 

   
   public function updateEmail(Request $request)
   {
       User::where('id', auth()->user()->id)
            ->update([
                'email' => $request->email
            ]);

       session()->put('update-profile',
                  [
                      'title' => 'Email',
                      'msg' => trans('Your Email has been successfully updated.')
                  ]
              );

        return response()->json([
            'success' => true
        ]);
   }

    public function emailNotification()
    {
      $email= DB::table('email_notifications')->where('user_id', auth()->user()->id)->first();
      return view('frontend.user.email-notification',compact('email'));
    } 
     public function emailStatus(Request $request)
     {
        if ($request->ajax()) {
           $usermail= DB::table('email_notifications')->where('user_id',auth()->user()->id)->first();
            if(empty($usermail)) {
              DB::table('email_notifications')->where('user_id',auth()->user()->id)->insert(['user_id'=>auth()->user()->id,'notification'=>'1']);
            } else {
              if($usermail->notification=='1')
              {
                $status='0';
              }
              else
              {
                $status='1';
              }
                DB::table('email_notifications')->where('user_id',auth()->user()->id)->update(['notification'=>$status]);
            }

            return response()->json([
                  'success' => true
            ]);
        }
     }
}

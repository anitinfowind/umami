<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\ChangePasswordRequest;
use App\Http\Requests\Frontend\User\FavoriteRequest;
use App\Http\Requests\Frontend\User\ProfileShowRequest;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Models\Favorite;
use App\Models\RoleUser;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use App\Models\Access\User\User;
use App\Repositories\Frontend\Access\User\UserRepository;
use DB;
use Ramsey\Uuid\Uuid;
use Validator;
class AccountController extends APIController
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
     * @var User
     */
    private $user;

    /**
     * @param UserRepository $userRepository
     * @param Favorite $favorite
     * @param Product $product
     */
    public function __construct(
        UserRepository $userRepository,
        Favorite $favorite,
        Product $product,
        User $user
    ) {
        $this->userRepository = $userRepository;
        $this->favorite = $favorite;
        $this->product = $product;
        $this->user = $user;
    }

    /**
     * @param ProfileShowRequest $request
     * @return View
     */
    public function viewProfile(Request $request)
    {
       if(!empty($request->get('user_id')))
       {
         $userdata= $this->user->where('id',$request->get('user_id'))->first();
         if(!empty($userdata))
         {
            $accountdata['user_id']=$userdata->id;
            $accountdata['first_name']=$userdata->first_name;
            $accountdata['last_name']=$userdata->last_name;
            $accountdata['email']=$userdata->email;
            $accountdata['phone']=$userdata->phone;
            $accountdata['image']=url('uploads/user/'.$userdata->slug.'/'.$userdata->image);
            return $this->respond([
              'status'=>'1',
              'message'=>'user information list data',
              'data'=>$accountdata
            ]);
         } else {
            $accountdata['status']='0';
            $accountdata['message']='User information not found';
            return $this->respond($accountdata);
         }

       }  else {
            $accountdata['status']='0';
            $accountdata['message']='User id not fount';
            return $this->respond($accountdata);
       }
    }


    public function updateProfile(Request $request)
    {
       if(!empty($request->get('user_id')))
       {
        $userdata= $this->user->where('id',$request->get('user_id'))->first();
         if($request->hasFile('image'))
         {
            $this->unlinkProfile($request,$userdata);
          $profile = $this->uploadProfile($request,$userdata);
         }

         User::where('id', $request->get('user_id'))
            ->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => isset($request->email)?$request->email:$userdata->email,
                'image' =>isset($profile)?$profile:$userdata->image,
            ]);
         
         if(!empty($userdata)) 
         {
            $accountdata['user_id']=$userdata->id;
            $accountdata['first_name']=$userdata->first_name;
            $accountdata['last_name']=$userdata->last_name;
            $accountdata['email']=$userdata->email;
            $accountdata['phone']=$userdata->phone;
            $accountdata['image']=url('uploads/user/'.$userdata->slug.'/'.$userdata->image);
            return $this->respond([
              'status'=>'1',
              'message'=>'User profile update successfully.',
              'data'=>$accountdata
            ]);
         }
       }  else {
            $accountdata['status']='0';
            $accountdata['message']='User id invalid';
            return $this->respond($accountdata);
       }
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
    public function wishList(Request $request)
    {
        $validation = Validator::make($request->all(), [
                  'user_id'    => 'required'
              ]);
            if ($validation->fails()) {
                return $this->throwValidation($validation->messages()->first());
            }
          $roleId= RoleUser::where('user_id',$request->get('user_id'))->first();
        if (isset($roleId->role_id)&& $roleId->role_id==3) {
            $favorites = $this->favorite->with('product')
                            ->where('user_id', $request->get('user_id'))
                            ->orderBy('id', 'desc')
                            ->get();
                if($favorites->isNotEmpty()) 
                {           
                  $wishlistdata=array();
                  foreach ($favorites as $key => $favorite)
                  {
                     $wishlistdata[$key]['product_id']= isset($favorite->product->id)?$favorite->product->id:'';
                     $wishlistdata[$key]['slug']= isset($favorite->product->slug)?$favorite->product->slug:'';
                      $wishlistdata[$key]['title']= isset($favorite->product->title)?$favorite->product->title:'';
                      $wishlistdata[$key]['price']= isset($favorite->product->price)?$favorite->product->price:'';
                       $categorylist= isset($favorite->product->category_id)?$favorite->product->category_id:'';
                       $dietlist= isset($favorite->product->diet_id)?$favorite->product->diet_id:'';

                        $categorydata='';
                        if(isset($categorylist) && !empty( $categorylist))
                        {
                          $category= explode(',',$favorite->product->category_id);
                          $category2=array();
                          foreach ($category as $c => $value)
                          {
                            if(!empty($value))
                            {
                              $category2[]= checkCategoryName($value);
                            }
                          }
                          $categorydata= implode(',', $category2);
                        }
                        $dietdata='';
                        if(isset($dietlist) && !empty( $dietlist))
                        {
                          $diets= explode(',',$favorite->product->diet_id);
                          $dite2=array();
                          foreach ($diets as $d => $diet)
                          {
                            if(!empty($diet))
                            {
                              $dite2[]= checkDietName($diet);
                            }
                          }
                          $dietdata=implode(',',$dite2);
                        }

                       $wishlistdata[$key]['category']=$categorydata;
                        $wishlistdata[$key]['diet']=$dietdata;

                      if(isset($favorite->product->singleProductImage->image) && !empty($favorite->product->singleProductImage->image))
                      {
                        $wishlistdata[$key]['image']= url('uploads/product/'.$favorite->product->singleProductImage->image);
                      }
                       else
                       {
                         $wishlistdata[$key]['image']=url('/images/no-product-image.png');
                       }
                      $wishlistdata[$key]['created_at']=date('Y-m-d', strtotime($favorite->created_at));
                  }
                   return $this->respond([
                      'status'=>'1',
                      'message'=>'Get wishlist successfully',
                      'data'=>$wishlistdata,
                    ]);
                }
                else
                {
                  return $this->respond([
                      'status'=>'0',
                      'message'=>'Record not found',
                      
                    ]);

                }
        } else {
            $productIds = $this->product->where('user_id', $request->get('user_id'))->pluck('id')->all();
            $favorites = $this->favorite->with('user','product')
                              ->whereIn('product_id', $productIds)
                              ->orderBy('id', 'desc')
                              ->get(); 
        }
    }

    /**
     * @param FavoriteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function favourite(Request $request)
    {
       $validation = Validator::make($request->all(), [
                  'user_id'    => 'required',
                  'product_id' => 'required',
              ]);

               if ($validation->fails()) {
                return $this->throwValidation($validation->messages()->first());
            }
        $favorite = $this->favorite->where('product_id', $request->get('product_id'))
                  ->where('user_id', $request->get('user_id'))
                  ->first();
        if (empty($favorite))
         {
            $this->favorite->create([
                'user_id' => $request->get('user_id'),
                'product_id' => $request->get('product_id')
            ]);
           $product= Product::where('id',$request->get('product_id'))->first();
           $responsdata['user_id']=$request->get('user_id');
           $responsdata['product_title']=$product->title;
           $responsdata['product_price']=$product->price;
            return $this->respond([
            'status'=>'1',
            'message'=>'Add wishlist successfully',
            'data'=>$responsdata,
          ]);
        } else {
            $this->favorite
                    ->where('product_id', $request->get('product_id'))
                    ->where('user_id', $request->get('user_id'))
                    ->delete();
            $responsdata['status']='0';
            $responsdata['message']='product unfavorite';
            return $this->respond($responsdata);
        }
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
                  'status' => true
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
            'status' => true
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
                  'status' => true
            ]);
        }
     }


    private function uploadProfile($requestData,$userdata)
    {
        if ($requestData->hasFile('image')) {
            $extension = $requestData->file('image')->getClientOriginalExtension();
            $fileName = Uuid::uuid4()->toString() . '.' . $extension;
            if ($requestData->file('image')->move(USER_PROFILE_IMAGE_ROOT_PATH . $userdata->slug . DS, $fileName)) {
                return $fileName;
            }
        }

        return $userdata->image;
    }
    private function unlinkProfile($requestData, $userdata)
    {
        if ($requestData->hasFile($requestData->image)) {
            $user = $this->findById($userdata->id);
            @unlink(USER_PROFILE_IMAGE_ROOT_PATH . $user->slug . DS . $user->image);
        }

        return;
    }

}

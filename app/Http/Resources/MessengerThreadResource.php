<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Auth\User;
use App\Models\Auth\UserProfile;

class MessengerThreadResource extends JsonResource
{
    
    public function toArray($request)
    {
        if(!empty($this->userexist($this->recipient_id)))
        {
           return [
            "id"=>$this->id,
            "recipient_id"=>$this->recipient_id,
            "thread_id" => $this->thread_id,
            "recipient_name"=>$this->senderName($this->recipient_id),
            "recipient_img"=>$this->senderImage($this->recipient_id),
            "is_login"  => $this->getLoggedInStatus($this->recipient_id),
            "updated_at"=>$this->updated_at
            
          ];
        }
       
    }
   

    public function senderImage($value='')
    {
      
      if (!empty($value)){
            $userAvatar = User::find($value);
              
            $checkAvatar =   $userAvatar->avatar_type == 'Social' ? 
                                      (!empty($userAvatar->avatar_location) ? $userAvatar->avatar_location : '' )
                                      : (!empty($userAvatar->avatar_location) ? asset('user/image/'.$userAvatar->avatar_location) : '');


            if (!empty($checkAvatar)) {
                       return $checkAvatar; die();      
                }else{

                  $image = UserProfile::where('user_id',$value)->first();
                    return   !empty($image->profile_images) ? url('/profileimage/'.$image->profile_images) :url('/profileimage/noimage.jpg');  
                }                          

              
       }
    }

    public function senderName($value='')
    {
        if(!empty($value)){
           return User::find($value)->full_name;
        } 
    
    }
    public function userexist($value='')
    {
       if(!empty($value)){
           return User::find($value);
        } 

    }

    public function getLoggedInStatus($user_id){
      return User::find($user_id)->is_login;
    }
   
}


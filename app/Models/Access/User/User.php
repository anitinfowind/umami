<?php

namespace App\Models\Access\User;

use App\Models\Access\User\Traits\Relationship\UserRelationship;
use App\Models\Access\User\Traits\UserAccess;
use App\Models\RoleUser;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantLocation;
use App\Models\Restaurant\RestaurantBranch;
use App\Models\Restaurant\RestaurantCategory;
use App\Models\Categories\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Access\User\Traits\Attribute\UserAttribute;
class User extends Authenticatable
{
    use UserAccess,Notifiable,SoftDeletes,UserRelationship,UserAttribute;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'slug',
        'email',
        'password',
        'phone',
        'image',
        'status',
        'confirmation_code',
        'confirmed',
        'remember_token',
        'created_by',
        'updated_by',
        'forgot_password_string',
        'device_type',
        'device_token',
        'reward_point',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @param string $value
     * @return string
     */
    public function setFirstNameAttribute(string $value)
    {
        return $this->attributes['first_name'] =  ucfirst($value);
    }

    /**
     * @param string $value
     * @return string
     */
    public function setLastNameAttribute(string $value)
    {
        return $this->attributes['last_name'] =  ucfirst($value);
    }

    public function id()
    {
        return $this->id;
    }

    public function firstName()
    {
        return isset($this->first_name) ? $this->first_name : '';
    }

    public function lastName()
    {
        return isset($this->last_name) ? $this->last_name : '';
    }

    public function fullName()
    {
        return $this->firstName() . ' ' . $this->lastName();
    }

    public function slug()
    {
        return $this->slug ?? '';
    }

    public function email()
    {
        return isset($this->email) ? $this->email : '';
    }

    public function phoneNo()
    {
        return isset($this->phone) ? $this->phone : '';
    }

    public function image()
    {
        return isset($this->image) ? $this->image : '';
    }

    /**
     * @return string
     */
    public function confirmationCode()
    {
        return (string) $this->confirmation_code;
    }

    public function isAdmin() : bool
    {
        return $this->hasRole(ONE);
    }

    public function isUser() : bool
    {
        return $this->hasRole(THREE);
    }

    public function isVender() : bool
    {
        return $this->hasRole(TWO);
    }

    public function isManager() : bool
    {
        return $this->hasRole(FOUR);
    }

    public function hasRole($roleId) :bool
    {
        return (bool) $this->role->where('user_id', auth()->user()->id)->get()->contains('role_id', $roleId);
    }

    public function role()
    {
        return $this->hasOne(RoleUser::class,'user_id');
    }
     public function isApprovedRestaurant()
    {
        return $this->hasOne(Restaurant::class,'user_id')->where('is_active', 'APPROVED');
    }

     public function isRestaurantLocation()
    {
        return $this->hasOne(RestaurantLocation::class,'user_id');
    }

    public function isRestaurant()
    {
        return $this->hasOne(Restaurant::class,'user_id');
    }

    public function isRestaurantCategory()
    {
       return $this->hasMany(RestaurantCategory::class,'user_id')->with('category');
    }

     public function isRestaurantBranchs()
    {
        return $this->hasOne(RestaurantBranch::class,'user_id');
    }

    public function restaurant()
    {
      return $this->hasOne(Restaurant::class, 'user_id')->with('restaurantLocation');
    }
}

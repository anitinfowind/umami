<?php

namespace App\Models\Notification;

use App\Models\BaseModel;
use App\Models\Products\Product;
class Notification extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table ='user_notifications';

    public function __construct()
    {
        //$this->table = config('access.notifications_table');
    }


    public function getProductNotifi()
    {
      return $this->belongsTo(Product::class,'product_id')->with('singleProductImage');;
    }
}

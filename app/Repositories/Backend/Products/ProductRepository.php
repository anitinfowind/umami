<?php

namespace App\Repositories\Backend\Products;

use DB;
use Carbon\Carbon;
use App\Models\Products\Product;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Auth;
/**
 * Class ProductRepository.
 */
class ProductRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Product::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->leftJoin('users', 'users.id', '=', 'products.user_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->leftJoin('brands','brands.id','=','products.brand_id')
            ->Join('product_images','product_images.product_id','=','products.id')
            ->select([
                config('module.products.table').'.id',
                config('module.users.table').'.first_name',
                config('module.categories.table').'.name as catname',
                config('module.brands.table').'.name as bname',
                config('module.products.table').'.title',
                config('module.product_images.table').'.image',
                config('module.products.table').'.price',
                config('module.products.table').'.quantity',
                config('module.products.table').'.created_at',
                config('module.products.table').'.updated_at',
            ])
            ->orderby('products.id','DESC');
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @throws GeneralException
     * @return bool
     */
     public function productList()
     {
       return Product::with('singleProductImage','pCategory','pBrand','pdiet')
            ->orderby('id','DESC')
            ->get();
     }


}

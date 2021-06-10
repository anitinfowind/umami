<?php

namespace App\Http\Controllers\Backend\Products;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Products\ProductRepository;
use App\Http\Requests\Backend\Products\ManageProductRequest;

class ProductsTableController extends Controller
{
    /**
     * @var ProductRepository
     */
    protected $product;

    /**
     * @param ProductRepository $product
     */
    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

    /**
     * @param ManageProductRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function __invoke(ManageProductRequest $request)
    {
        return Datatables::of($this->product->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('first_name', function ($product) {
                return $product->first_name;
            })
            ->addColumn('name', function ($product) {
                return $product->catname;
            })
             ->addColumn('name', function ($product) {
                return $product->bname;
            })
            ->addColumn('name', function ($product) {
                return $product->name;
            })
            ->addColumn('image', function ($product) {
              return '<img style="width:70px"; src="'.URL('product/'.$product->image).'">';
            })
            ->addColumn('price', function ($product) {
                return $product->price;
            })
            ->addColumn('sale_price', function ($product) {
                return $product->sale_price;
            })
            ->addColumn('quantity', function ($product) {
                return $product->quantity;
            })
            ->addColumn('status', function ($product) {
                return $product->status_label;
            })
            ->addColumn('actions', function ($product) {
                return $product->action_buttons;
            })
            ->make(true);
    }
}

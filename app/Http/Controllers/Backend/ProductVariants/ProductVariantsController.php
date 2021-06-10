<?php

namespace App\Http\Controllers\Backend\ProductVariants;

use App\Http\Requests\Backend\ProductVariants\ProductVariantsAddRequest;
use App\Http\Requests\Backend\ProductVariants\ProductVariantsDeleteRequest;
use App\Http\Requests\Backend\ProductVariants\ProductVariantsEditRequest;
use App\Http\Requests\Backend\ProductVariants\ProductVariantsSaveRequest;
use App\Http\Requests\Backend\ProductVariants\ProductVariantsShowRequest;
use App\Http\Requests\Backend\ProductVariants\ProductVariantsUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\ProductVariants;
use App\Models\Products\Product;
use Ramsey\Uuid\Uuid;
use File;

class ProductVariantsController extends Controller
{
    /**
     * @var ProductAttribute
     */
    private $productVariants;
    
    /**
     * @param ProductAttribute $productAttribute
     */
    public function __construct(ProductVariants $productVariants)
    {
        $this->productVariants = $productVariants;
      

    }

    /**
     * @param ProductAttributeShowRequest $request
     * @return View
     */
    public function index(ProductVariantsShowRequest $request)
    {  
        $productVariants = $this->productVariants->orderby('id','DESC')->get();
       
        return view('backend.product_variants.index',
            compact('productVariants')
        );
    }

    /**
     * @param ProductAttributeAddRequest $request
     * @return View
     */
    public function addProductVariants(ProductVariantsAddRequest $request)
    {   
        $products  = Product::where('status', '1')->select('id','title')->get();
        return view('backend.product_variants.create',compact('products'));
    }

    /**
     * @param ProductAttributeSaveRequest $request
     */
    public function saveProductVariants(ProductVariantsSaveRequest $request)
    {  

        $this->productVariants->create([
            'product_id' => $request->product_id,
            'variant_name'=> $request->variant_name,
            'price' => $request->price,
            'status' => $request->is_atcive,
        ]);

        return redirect()->route('admin.productVariants.index')
            ->with(['flash_success' => trans('Product variant has been successfully added.')]);
    }

    /**
     * @param ProductAttributeEditRequest $request
     * @param int $id
     * @return View
     */
    public function editProductVariants(ProductVariantsEditRequest $request, int $id)
    {
        $productVariants = $this->productVariants->find($id);
        $products  = Product::where('status', '1')->select('id','title')->get();
        
        return view('backend.product_variants.edit',
            compact('productVariants','products')
        );
    }

    /**
     * @param ProductAttributeUpdateRequest $request
     * @param int $id
     */
    public function updateProductVariants(ProductVariantsUpdateRequest $request, int $id)
    {  

       $updateAttribute=  $this->productVariants->where('id', $id)->first();
       
       
       $updateAttribute->product_id = $request->product_id;
       $updateAttribute->variant_name = $request->variant_name;
       $updateAttribute->price = $request->price;
       $updateAttribute->status = $request->is_atcive;
       $updateAttribute->save();

        return redirect()->route('admin.productVariants.index')
            ->with(['flash_success' => trans('Product variant has been successfully updated.')]);
    }

    /**
     * @param ProductAttributeDeleteRequest $request
     * @param int $id
     */
    public function deleteProductVariants(ProductVariantsDeleteRequest $request, int $id)
    {

       $deleteAttribute = $this->productVariants->where('id', $id)->first();
          
        $this->productVariants->find($id)->delete();

        return redirect()->route('admin.productVariants.index')
            ->with(['flash_success' => trans('Product variant has been successfully deleted.')]);
    }

    /**
     * @param ProductAttributeShowRequest $request
     * @param int $modelId
     * @param string $modelStatus
     */
    public function updateStatus(ProductVariantsShowRequest $request, int $modelId, string $modelStatus)
    {
        $this->productVariants->where('id', '=', $modelId)->update(['status' => $modelStatus]);

        return redirect()->route('admin.productVariants.index')
            ->with(['flash_success' => trans('Status has been changed successfully.')]);
    }
}

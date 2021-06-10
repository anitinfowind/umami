<?php

namespace App\Http\Controllers\Backend\ProductAttribute;

use App\Http\Requests\Backend\ProductAttribute\ProductAttributeAddRequest;
use App\Http\Requests\Backend\ProductAttribute\ProductAttributeDeleteRequest;
use App\Http\Requests\Backend\ProductAttribute\ProductAttributeEditRequest;
use App\Http\Requests\Backend\ProductAttribute\ProductAttributeSaveRequest;
use App\Http\Requests\Backend\ProductAttribute\ProductAttributeShowRequest;
use App\Http\Requests\Backend\ProductAttribute\ProductAttributeUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use Ramsey\Uuid\Uuid;
use File;

class ProductAttributeController extends Controller
{
    /**
     * @var ProductAttribute
     */
    private $productAttribute;

    /**
     * @param ProductAttribute $productAttribute
     */
    public function __construct(ProductAttribute $productAttribute)
    {
        $this->productAttribute = $productAttribute;
    }

    /**
     * @param ProductAttributeShowRequest $request
     * @return View
     */
    public function index(ProductAttributeShowRequest $request)
    {
        $productAttributes = $this->productAttribute->orderby('id','DESC')->get();

        return view('backend.product_attribute.index',
            compact('productAttributes')
        );
    }

    /**
     * @param ProductAttributeAddRequest $request
     * @return View
     */
    public function addProductAttribute(ProductAttributeAddRequest $request)
    {
        return view('backend.product_attribute.create');
    }

    /**
     * @param ProductAttributeSaveRequest $request
     */
    public function saveProductAttribute(ProductAttributeSaveRequest $request)
    {  
       if ($request->hasFile('icon')) {
        $image = $request->file('icon');
        $name = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
        $image->move(ATTRIBUTE_ROOT_PATH, $name);
    }
        $this->productAttribute->create([
            'name' => $request->name(),
            'slug' => $this->getSlug($request->name(),'','product_attributes'),
            'icon' => $name,
            'is_active' => ($request->isActive()) ? ACTIVE : INACTIVE,
        ]);

        return redirect()->route('admin.productAttribute.index')
            ->with(['flash_success' => trans('Product attribute has been successfully added.')]);
    }

    /**
     * @param ProductAttributeEditRequest $request
     * @param int $id
     * @return View
     */
    public function editProductAttribute(ProductAttributeEditRequest $request, int $id)
    {
        $productAttributes = $this->productAttribute->find($id);

        return view('backend.product_attribute.edit',
            compact('productAttributes')
        );
    }

    /**
     * @param ProductAttributeUpdateRequest $request
     * @param int $id
     */
    public function updateProductAttribute(ProductAttributeUpdateRequest $request, int $id)
    {
       $updateAttribute=  $this->productAttribute->where('id', $id)->first();
        
          if($request->file('icon')!='')
          { 
            if(!empty($updateAttribute->icon) &&  File::exists(ATTRIBUTE_ROOT_PATH.$updateAttribute->icon))
            {
              $path = public_path('uploads/attributeicon/'.$updateAttribute->icon);
              @unlink($path);
            }
          }

          if ($request->hasFile('icon'))
          {
            $image = $request->file('icon');
            $name = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
            $image->move(ATTRIBUTE_ROOT_PATH, $name);
            $updateAttribute->icon=$name;
          }
       $updateAttribute->name = $request->name();
       $updateAttribute->is_active = ($request->isActive()) ? ACTIVE : INACTIVE;
       $updateAttribute->save();

        return redirect()->route('admin.productAttribute.index')
            ->with(['flash_success' => trans('Product attribute has been successfully updated.')]);
    }

    /**
     * @param ProductAttributeDeleteRequest $request
     * @param int $id
     */
    public function deleteProductAttribute(ProductAttributeDeleteRequest $request, int $id)
    {

       $deleteAttribute=  $this->productAttribute->where('id', $id)->first();
        
            if(!empty($deleteAttribute->icon) &&  File::exists(ATTRIBUTE_ROOT_PATH.$deleteAttribute->icon))
            {
              $path = public_path('uploads/attributeicon/'.$deleteAttribute->icon);
              @unlink($path);
            }
          
        $this->productAttribute->find($id)->delete();

        return redirect()->route('admin.productAttribute.index')
            ->with(['flash_success' => trans('Product attribute has been successfully deleted.')]);
    }

    /**
     * @param ProductAttributeShowRequest $request
     * @param int $modelId
     * @param string $modelStatus
     */
    public function updateStatus(ProductAttributeShowRequest $request, int $modelId, string $modelStatus)
    {
        $this->productAttribute->where('id', '=', $modelId)->update(['is_active' => $modelStatus]);

        return redirect()->route('admin.productAttribute.index')
            ->with(['flash_success' => trans('Status has been changed successfully.')]);
    }
}

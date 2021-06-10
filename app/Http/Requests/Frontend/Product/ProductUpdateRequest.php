<?php

namespace App\Http\Requests\Frontend\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isVender() || $this->user()->isManager();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            //'description' => 'required|string',
           // 'brand_id'=>'required',
            //'diet_id'=>'required',
           // 'category_id'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'The about product field is required.',
            'brand_id.required'=>'The Brand field is required',
            //'diet_id.required'=>'The Diet field is required',
            'category_id.required'=>'The Category field is required',
        ];
    }
	
	/**
     * @return mixed
     */
    public function id()
    {
        return $this->input('id');
    }
	
	/**
     * @return mixed
     */
    public function categoryId()
    {
        return $this->input('category_id');
    }
	
	/**
     * @return mixed
     */
    public function brandId()
    {
        return $this->input('brand_id');
    }
	
	/**
     * @return mixed
     */
    public function dietId()
    {
        return $this->input('diet_id');
    }
	
	/**
     * @return mixed
     */
    public function regionId()
    {
        return $this->input('region_id');
    }
	
	/**
     * @return mixed
     */
    public function title()
    {
        return $this->input('title');
    }
	
	/**
     * @return mixed
     */
    public function price()
    {
        return $this->input('price');
    }
	
	/**
     * @return mixed
     */
    public function discount()
    {
        return $this->input('discount');
    }
	
	/**
     * @return mixed
     */
    public function quantity()
    {
        return $this->input('quantity');
    }
	
	/**
     * @return mixed
     */
    public function shippingType()
    {
        return $this->input('shipping_type');
    }
	
	/**
     * @return mixed
     */
    public function shippingPrice()
    {
        return $this->input('shipping_price');
    }
	
	/**
     * @return mixed
     */
    public function attributeIds()
    {
        if ($this->input('attribute_id')) {
			return implode(',', $this->input('attribute_id'));
		} 
		
		return;
    }
	
	/**
     * @return mixed
     */
    public function editorPick()
    {
        return ($this->input('editor_pick')) ?? false;
    }
	
	/**
     * @return mixed
     */
    public function description()
    {
        return nl2br(strip_tags($this->input('description')));
    }
	
	/**
     * @return mixed
     */
	public function ingredients()
    {
        return nl2br(strip_tags($this->input('ingredients')));
    }
	
	/**
     * @return mixed
     */
	public function nutrition()
    {
        return nl2br(strip_tags($this->input('nutrition')));
    }
	
	public function details()
    {
        return nl2br(strip_tags($this->input('details')));
    }
	
	/**
     * @return mixed
     */
	public function files()
    {
        return $this->input('files');
    }
}

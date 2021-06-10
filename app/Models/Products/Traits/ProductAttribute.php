<?php

namespace App\Models\Products\Traits;

/**
 * Class ProductAttribute.
 */
trait ProductAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">
         '.$this->getEditButtonAttribute("edit-product", "admin.products.edit").'
              '.$this->getDeleteButtonAttribute("delete-product", "admin.products.destroy").'
                </div>';
    }

     public function getStatusLabelAttribute()
    {
        if ($this->isActive()) {
            return "<label class='label label-success'>".trans('labels.general.active').'</label>';
        }

        return "<label class='label label-danger'>".trans('labels.general.inactive').'</label>';
    }


    public function isActive()
    {
        return $this->status == 1;
    }
}

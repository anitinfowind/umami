<?php

namespace App\Models\Brand\Traits;

/**
 * Class BrandAttribute.
 */
trait BrandAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> '.$this->getEditButtonAttribute("edit-slider", "admin.sliders.edit").''
            .$this->getDeleteButtonAttribute("delete-slider", "admin.sliders.destroy").'
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

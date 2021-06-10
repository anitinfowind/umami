<?php

namespace App\Models\Categories\Traits;

/**
 * Class CategoryAttribute.
 */
trait CategoryAttribute
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
         '.$this->getEditButtonAttribute("edit-category", "admin.categories.edit").'
              '.$this->getDeleteButtonAttribute("delete-category", "admin.categories.destroy").'
              '.$this->changeActionAttribute('admin.categories.update-category-status').'
                </div>';
    }

    /**
     * @return string
     */
    public function getIsActiveLabelAttribute()
    {
        if ($this->is_active == ACTIVE) {
            return "<label class='label label-success'>".trans('labels.general.active').'</label>';
        }

        return "<label class='label label-danger'>".trans('labels.general.inactive').'</label>';
    }

}

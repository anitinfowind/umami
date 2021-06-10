<?php

namespace App\Models\Video\Traits;

/**
 * Class VideoAttribute.
 */
trait VideoAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> '.$this->getEditButtonAttribute("edit-video", "admin.videos.edit").
                $this->getDeleteButtonAttribute("delete-video", "admin.videos.destroy").'
                </div>';
    }
  public function getIsActiveLabelAttribute()
    {
        if ($this->is_active == ACTIVE) {
            return "<label class='label label-success'>".trans('labels.general.active').'</label>';
        }

        return "<label class='label label-danger'>".trans('labels.general.inactive').'</label>';
    }
}

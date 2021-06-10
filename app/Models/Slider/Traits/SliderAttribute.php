<?php

namespace App\Models\Slider\Traits;

/**
 * Class SliderAttribute.
 */
trait SliderAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> '.$this->getEditButtonAttribute("edit-slider", "admin.sliders.edit").'
        '.$this->getDeleteButtonAttribute("delete-slider", "admin.sliders.destroy").'
        '.$this->getStatusButtonAttribute('btn btn-default btn-flat').'
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

    public function getStatusButtonAttribute($class)
    {
        if ($this->status == 0) {
            return '<a class="'.$class.'" href="'.route('admin.sliders.update-slider-status', [$this, 1]).'"><i class="fa fa-check-square" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.backend.access.users.activate').'"></i></a>';
        } else {
            return '<a class="'.$class.'" href="'.route('admin.sliders.update-slider-status', [$this, 0]).'"><i class="fa fa-square" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.backend.access.users.deactivate').'"></i></a>';
        }
    }
}

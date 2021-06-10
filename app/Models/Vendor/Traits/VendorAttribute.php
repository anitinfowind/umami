<?php

namespace App\Models\Vendor\Traits;

/**
 * Class VendorAttribute.
 */
trait VendorAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> '.$this->getEditButtonAttribute("edit-vendor", "admin.vendors.edit").'
        '.$this->getDeleteButtonAttribute("delete-vendor", "admin.vendors.destroy").'
        '.$this->getStatusButtonAttribute('btn btn-default btn-flat').'
        '.$this->getViewButtonAttribute('btn btn-default btn-flat').'
                </div>';
    }
    public function getConfirmedLabelAttribute()
    {
        if ($this->isConfirmed()) {
            return "<label class='label label-success'>".trans('labels.general.yes').'</label>';
        }

        return "<label class='label label-danger'>".trans('labels.general.no').'</label>';
    }
    public function isConfirmed()
    {
        return $this->confirmed == 1;
    }

    /**
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        if ($this->isActive()) {
            return "<label class='label label-success'>".trans('labels.general.active').'</label>';
        }

        return "<label class='label label-danger'>".trans('labels.general.inactive').'</label>';
    }


    public function getApprovelsLabelAttribute()
    {
       //echo $this->id; exit;
        if ($this->isActive()) {
            return "<input type='checkbox' name='approvel' class='profileapprovel' id='".$this->id."'>";
        }

        return "<label class='label label-danger'>".trans('labels.general.inactive').'</label>';
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status == 1;
    }

    /**
     * @return string
     */
    public function getStatusButtonAttribute($class)
    {
        if ($this->id != access()->id()) {
            switch ($this->status) {
                case 0:
                    if (access()->allow('activate-user')) {
                        $name = $class == '' ? 'Activate' : '';

                        return '<a class="'.$class.'" href="'.route('admin.vendors.update-vendor-status', [$this, 1]).'"><i class="fa fa-check-square" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.backend.access.users.activate').'"></i>'.$name.'</a>';
                    }

                    break;

                case 1:
                    if (access()->allow('deactivate-user')) {
                        $name = ($class == '') ? 'Deactivate' : '';

                        return '<a class="'.$class.'" href="'.route('admin.vendors.update-vendor-status', [$this, 0]).'"><i class="fa fa-square" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.backend.access.users.deactivate').'"></i>'.$name.'</a>';
                    }

                    break;

                default:
                    return '';
            }
        }

        return '';
    }

    public function getViewButtonAttribute($class)
    {
        if ($this->id != access()->id()) {
                    if (access()->allow('activate-user')) {
                        $name = $class == '' ? 'View' : '';

                        return '<a class="'.$class.'" href="'.route('admin.vendors.view', [$this]).'"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="'.trans('View').'"></i>'.$name.'</a>';
            }
        }

        return '';
    }

 }
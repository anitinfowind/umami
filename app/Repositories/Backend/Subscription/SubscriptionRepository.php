<?php

namespace App\Repositories\Backend\Subscription;

use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Subscription\Subscription;
use App\Models\Subscription\SubscriptionImage;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use File;
/**
 * Class SubscriptionRepository.
 */
class SubscriptionRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Subscription::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->select([
                config('module.subscriptions.table').'.id',
                config('module.subscriptions.table').'.title',
                config('module.subscriptions.table').'.description',
                config('module.subscriptions.table').'.price',
                config('module.subscriptions.table').'.discount',
                config('module.subscriptions.table').'.payment_type',
                config('module.subscriptions.table').'.created_at',
                config('module.subscriptions.table').'.updated_at',
            ]);
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @throws GeneralException
     * @return bool
     */
    public function create(array $input)
    {   
         $monthdata='';
        if(!empty($input['month']))
        {
          $monthdata=implode(',', $input['month']);
        }

         $input['month']=$monthdata;
         $input['slug']=app(Controller::class)->getSlug($input['name'],'','subscriptions');
         $input['title']=isset($input['name'])?$input['name']:'';

        if ($subid=Subscription::create($input)) {

             if (!empty($input['image'])) {

               foreach ($input['image'] as $key => $value) {
                 $name = Uuid::uuid4()->toString().'.'.$value->getClientOriginalExtension();
                  $destinationPath = public_path('/uploads/subscription/');
                  $value->move($destinationPath, $name);

                   $imagedata=array('subscription_id'=>$subid->id,'image'=>$name);
                   SubscriptionImage::create($imagedata);
               }
             }
             
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.subscriptions.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Subscription $subscription
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Subscription $subscription, array $input)
    {
        $imagedata= SubscriptionImage::where('subscription_id',$subscription->id)->get();

        $monthdata='';
        if(!empty($input['month']))
        {
          $monthdata=implode(',', $input['month']);
        }

         $input['month']=$monthdata;
         $input['title']=isset($input['name'])?$input['name']:'';
         if (!empty($input['image'])) {

          foreach ($imagedata as $key => $v) {

            if (File::exists(public_path('/uploads/subscription/'.$v->image))) {
                  @unlink(public_path('/uploads/subscription/'.$v->image));
              }
          }
          SubscriptionImage::where('subscription_id',$subscription->id)->delete();

             foreach ($input['image'] as $key => $value) {
               $name = Uuid::uuid4()->toString().'.'.$value->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/subscription/');
                $value->move($destinationPath, $name);

                 $imagedata=array('subscription_id'=>$subscription->id,'image'=>$name);
                 SubscriptionImage::create($imagedata);
             }
       }
    	   if ($subscription->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.subscriptions.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Subscription $subscription
     * @throws GeneralException
     * @return bool
     */
    public function delete(Subscription $subscription)
    {
        if ($subscription->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.subscriptions.delete_error'));
    }
}

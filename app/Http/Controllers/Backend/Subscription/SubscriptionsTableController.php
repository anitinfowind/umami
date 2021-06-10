<?php

namespace App\Http\Controllers\Backend\Subscription;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Subscription\SubscriptionRepository;
use App\Http\Requests\Backend\Subscription\ManageSubscriptionRequest;
use Str;
class SubscriptionsTableController extends Controller
{
    /**
     * @var SubscriptionRepository
     */
    protected $subscription;

    /**
     * SubscriptionsTableController constructor.
     * @param SubscriptionRepository $subscription
     */
    public function __construct(SubscriptionRepository $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * @param ManageSubscriptionRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function __invoke(ManageSubscriptionRequest $request)
    {
        return Datatables::of($this->subscription->getForDataTable())
            ->escapeColumns(['id'])
             ->addColumn('title', function ($subscription) {
                return $subscription->title;
            })
            ->addColumn('description', function ($subscription) {
                return Str::limit($subscription->description,100);
            })
             ->addColumn('price', function ($subscription) {
                return $subscription->price;
            })
            ->addColumn('discount', function ($subscription) {
                return $subscription->discount;
            })
            ->addColumn('payment_type', function ($subscription) {
                return $subscription->payment_type;
            })
            ->addColumn('created_at', function ($subscription) {
                return Carbon::parse($subscription->created_at)->toDateString();
            })
            ->addColumn('actions', function ($subscription) {
                return $subscription->action_buttons;
            })
            ->make(true);
    }
}

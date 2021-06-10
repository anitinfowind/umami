<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Subscription\Subscription;

class SubscriptionController extends Controller
{
    /**
     * @var Subscription
     */
    protected $subscription;

    /**
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * @return View
     */
    public function index()
    {
        $subscriptions = $this->subscription
                            ->orderBy('created_at', 'DESC')
                            ->with('subscriptionImage')
                            ->get();

        return view('frontend.subscription.subscription',
            compact('subscriptions')
        );
    }
}

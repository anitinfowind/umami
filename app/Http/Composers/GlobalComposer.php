<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Models\Order;
use App\Models\OrderDetail;

/**
 * Class GlobalComposer.
 */
class GlobalComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        if (auth()->check()) {

          $view->with('orderCount', 0);
          //$view->with('orderCount', OrderDetail::where('user_id', auth()->user()->id) ->where('payment_status', '0')->count());
			// $view->with('orderCount', Order::where('user_id', auth()->user()->id)->where('order_id', null)->count());
		}
    }
}

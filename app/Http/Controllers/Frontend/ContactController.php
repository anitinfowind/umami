<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Contact\ContactRequest;
use App\Models\Contact;
use DB;

class ContactController extends Controller
{
    /**
     * @var Contact
     */
    private $contact;

    /**
     * @param Contact $contact
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return View
     */
    public function contact()
    {
        /*$restaurant = DB::table('restaurants')->where('user_id', 150)->first();
        $shipping_info = json_decode($restaurant->shipping_info, true);
        $estimated_delivery_date = estimated_delivery_date(['restaurant' => $restaurant]);
        echo '<pre>';
        print_r($shipping_info);

        $order_date = date('Y-m-d');
        $shipping_info = json_decode($restaurant->shipping_info, true);
        $delivery_date = date('Y-m-d', strtotime("+" . $shipping_info['preparation_time'] . " day", strtotime($order_date)));
        $daynum = (date('N', strtotime($delivery_date)) - 1);
        $first_pickup_date = '';
        $days_after = '';
        foreach ($shipping_info['pickuptime'] as $key => $value) {
            if(isset($value['enabled']) && $value['enabled'] == 1) {
              if($first_pickup_date == '') $first_pickup_date = $key;
              if($key >= $daynum && $days_after == '') $days_after = $key - $daynum;
            }
        }
        echo '<br>' . $days_after;
        if($days_after === '') {
        $days_after = (6 - $daynum) + $first_pickup_date + 1;
        }
        $pickup_date = date('Y-m-d', strtotime("+" . $days_after . " day", strtotime($delivery_date)));
        $delivery_date = date('Y-m-d', strtotime("+" . ($days_after + $shipping_info['delivery_days']) . " day", strtotime($delivery_date)));
        echo '<br>' . $pickup_date . '<br>' . $delivery_date;*/
        
        return view('frontend.contact_us.contact');
    }

    /**
     * @param ContactRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contactStore(ContactRequest $request)
    {
        $contact = $this->contact->create([
            'name' => $request->name(),
            'phone' => $request->phoneNo(),
            'email' => $request->email(),
            'subject' => $request->subject(),
            'message' => $request->message(),
        ])->fresh();

        $this->sendMail(
            [
                'name' => $contact->name(),
                'phone' => $contact->phoneNo(),
                'emailFrom' => $contact->email(),
                'email' => 'info@umamisquare.com',
                'subject' => $contact->subject(),
                'msg' => $contact->message(),
            ],
            'emails.contact2',
            'User want to contact you'
        );

        return response()->json([
            'success' => true
        ]);
    }
}

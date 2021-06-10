<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * @var Newsletter
     */
    private $newsletter;

    /**
     * @param Newsletter $newsletter
     */
    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(Request $request)
    {
        $email = $request->get('email');
        $subscribe = $this->newsletter->where('email',$email)->first();
		//print_r($subscribe);exit;
        if (empty($subscribe)) {
			$this->newsletter->create(['email' => $email]);
		}
		
		$this->sendMail(
				[
                    'email' => $email,
                    'name' => 'Umami Square'
                ],
                'emails.newsletter2',
                'Newsletter Subscribed Successfully'
            );
			
		klaviyo_add_user(['email' => $email, 'type' => 'newsletter']);

            return response()->json([
                'success' => true
            ]);
        
		
		

        /*return response()->json([
            'success' => false
        ]);*/
   }
}

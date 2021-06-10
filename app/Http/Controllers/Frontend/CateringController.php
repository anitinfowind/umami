<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Chef;
class CateringController extends Controller
{
    private $chefs;

    public function __construct(Chef $chefs)
    {
      $this->chefs= $chefs;

    }

    /**
     * @return View
     */
    public function show()
    {
		$chefslist= $this->chefs->paginate(PAGINATION);
        return view('frontend.catering.catering', compact('chefslist'));
    }

     public function showAllChef()
     {
       //$chefslist= $this->chefs->with('getRestautentName')->paginate(PAGINATION);
        $chefslist = $this->chefs->with(['getRestautent'])->where('status', '1')->get();
        //echo '<pre>'; print_r($chefslist); exit;
        return view('frontend.catering.allchefs', compact('chefslist'));

     }

     public function chefDetail($slug=null)
     {
         $chefsDetail= $this->chefs->where('slug',$slug)->first();

        // echo '<pre>'; print_r($chefsDetail);exit;
         return view('frontend.chef.chef-detail', compact('chefsDetail'));

     }
}

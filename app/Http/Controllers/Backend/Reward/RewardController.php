<?php

namespace App\Http\Controllers\Backend\Reward;

use App\Models\Reward;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
class RewardController extends Controller
{
  
    /**
     * @var RewardController
     */
    protected $reward;

    /**
     * RewardController constructor.
     * @param RewardController $reward
     */
    public function __construct(Reward $reward)
    {
        $this->reward = $reward;
    }

    /**
     * @param RewardController $request
     * @return ViewResponse
     */
    public function index()
    {   
        $rewards=  $this->reward->get();
        return view('backend.reward.index', compact('rewards'));
    }

    /**
     * @param CreateVendorRequest $request
     * @return CreateResponse
     */
    public function create()
    {
        return view('backend.reward.create');
    }

    /**
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
         $request->validate([
                          'discount_price'=>'required||numeric',
                          'earn_point'=>'required||numeric',
                        ]
                      );
          
        $this->reward->create([
                            'discount_price'=> $request->discount_price,
                            'earn_point' => $request->earn_point,
                            'is_active' => isset($request->is_active)?ACTIVE:INACTIVE,
                          ]
                        );

        return new RedirectResponse(route('admin.reward.index'),
            ['flash_success' => trans('Reward has been create successfully')]
        );
    }

    /**
     * @param Vendor $vendor
     * @param EditVendorRequest $request
     * @return EditResponse
     */
    public function edit($id=null)
    {
      $reward=  $this->reward->find($id);
        return view('backend.reward.edit', compact('reward'));
    }

    /**
     * @param UpdateVendorRequest $request
     * @param Vendor $vendor
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function update(Request $request, $id=null)
    {

        $this->reward->where('id', $id)->update([
                                  'discount_price'=>$request->discount_price,
                                  'earn_point' => $request->earn_point,
                                  'is_active' =>isset($request->is_active)?ACTIVE:INACTIVE,
                                  ]
                              );

        return new RedirectResponse(route('admin.reward.index'),
            ['flash_success' => trans('Reward has been update successfully.')]
        );
    }

    /**
     * @param Vendor $vendor
     * @param DeleteVendorRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(Request $request,int $id)
    {
        $this->reward->where('id', $id)->delete();

        return new RedirectResponse(route('admin.reward.index'),
            ['flash_success' => trans('Reward has been deleted successfully')]
        );
    }

   
}

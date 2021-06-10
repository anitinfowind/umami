<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\AddressEditFormRequest;
use App\Http\Requests\Frontend\User\AddressFormRequest;
use App\Http\Requests\Frontend\User\AddAddressRequest;
use App\Http\Requests\Frontend\User\UpdateAddressRequest;
use App\Models\Access\User\UserAddress;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Repositories\Frontend\Access\User\AddressRepository;

class AddressController extends Controller
{
    /**
     * @var Country
     */
    private $country;

    /**
     * @var State
     */
    private $state;

    /**
     * @var City
     */
    private $city;

    /**
     * @var UserAddress
     */
    private $userAddress;

    /**
     * @var AddressRepository
     */
    private $addressRepository;

    /**
     * @param Country $country
     * @param State $state
     * @param City $city
     * @param UserAddress $userAddress
     * @param AddressRepository $addressRepository
     */
    public function __construct(
        Country $country,
        State $state,
        City $city,
        UserAddress $userAddress,
        AddressRepository $addressRepository
    ) {
        $this->country = $country;
        $this->state = $state;
        $this->city = $city;
        $this->userAddress = $userAddress;
        $this->addressRepository = $addressRepository;
    }

    /**
     * @param AddressFormRequest $request
     * @return View
     */
    public function showAddress(AddressFormRequest $request)
    {
        $userAddresses = $this->userAddress->loginUserId()
                            ->with('country', 'state', 'city')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('frontend.user.address.address',
            compact('userAddresses')
        );
    }

    /**
     * @param AddressFormRequest $request
     * @return View
     */
    public function addressFrom(AddressFormRequest $request)
    {
        $countries = $this->country->where('sortname','US')->pluck('name','id')->all();

        return view('frontend.user.address.add_address',
            compact('countries')
        );
    }

    /**
     * @param AddAddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveAddress(AddAddressRequest $request)
    {
        $this->addressRepository->addAddress($request);

        session()->put('address',
            [
                'title' => 'Address',
                'msg' => trans('Your address has been successfully added.')
            ]
        );

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param AddressFormRequest $request
     */
    public function getState(AddressFormRequest $request)
    {
        $countryId	=	$request->get('country_id');
        if ($countryId !='') {
            $stateList	=	$this->state
                                ->where('country_id',$countryId)
                                ->orderBy('name','ASC')
                                ->pluck('name','id')
                                ->all();

            $list	=	'<select class="form-control" id="state" name="state_id"><option value="">'.trans('Select State').'</option>';

            if (count($stateList)>0) {
                foreach($stateList as $k=>$v) {
                    $list.= '<option value='.$k.'>'.$v.'</option>';
                }
            }
            $list	.=	'</select>';
            echo $list;
            die;
        } else {
            echo '<select class="form-control" name="state_id"><option value="">'.trans('Select State').'</option></select>';
            die;
        }
    }

    /**
     * @param AddressFormRequest $request
     */
    public function getCity(AddressFormRequest $request)
    {
        $stateId	=	$request->get('state_id');
        if ($stateId !='') {
            $cityList	=	$this->city
                                ->where('state_id', $stateId)
                                ->orderBy('name','ASC')
                                ->pluck('name','id')
                                ->all();

            $list	=	'<select class="form-control"  name="city_id"><option value="">'.trans('Select City').'</option>';

            if(count($cityList)>0){
                foreach($cityList as $k=>$v){
                    $list.= '<option value='.$k.'>'.$v.'</option>';
                }
            }
            $list	.=	'</select>';
            echo $list;
            die;
        }else{
            echo '<select class="form-control" name="city_id"><option value="">'.trans('Select City').'</option></select>';
            die;
        }
    }

    /**
     * @param AddressFormRequest $request
     */
    public function removeAddress(AddressFormRequest $request)
    {
        $addressId = $request->get('address_id');

        $address = $this->userAddress->find($addressId)->delete();
        if ($address) {
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }

    /**
     * @param AddressFormRequest $request
     */
    public function primaryAddress(AddressFormRequest $request)
    {
        $addressId = $request->get('address_id');
        $status = $request->get('status');
        $this->userAddress->loginUserId()->update(['is_primary_address' => INACTIVE]);
        $this->userAddress->loginUserId()->where('id', $addressId)->update(['is_primary_address' => $status]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param AddressEditFormRequest $request
     * @param int $addressId
     * @return View
     */
    public function editAddressFrom(AddressEditFormRequest $request, int $addressId)
    {
        $userAddress = $this->userAddress->loginUserId()->where('id', $addressId)->first();
        $countries = $this->country->where('sortname','US')->pluck('name','id')->all();
        $states = $this->state->where('country_id', $userAddress->countryId())->pluck('name','id')->all();
        $cities = $this->city->where('state_id', $userAddress->stateId())->pluck('name','id')->all();

        return view('frontend.user.address.update_address',
            compact('countries', 'userAddress', 'states', 'cities')
        );
    }

    /**
     * @param UpdateAddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAddress(UpdateAddressRequest $request)
    {
        $this->addressRepository->updateAddress($request);

        session()->put('address',
            [
                'title' => 'Address',
                'msg' => trans('Your address has been successfully updated.')
            ]
        );

        return response()->json([
            'success' => true
        ]);
    }
}

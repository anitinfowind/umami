<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Access\User\UserAddress;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Repositories\Frontend\Access\User\AddressRepository;
use Validator;
use Illuminate\Http\Request;
class AddressController extends APIController
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
    public function showAddress(Request $request)
    {
      if(!empty($request->get('user_id')))
      {
        $userAddresses = $this->userAddress->where('user_id',$request->user_id)
                      ->with('country', 'state', 'city')
                      ->orderBy('created_at', 'desc')
                      ->get();
          if(count($userAddresses)>0)
          {
             
             $getaddress=array();
             foreach ($userAddresses as $key => $value) {
                    $getaddress[$key]['id']=$value->id;
                    $getaddress[$key]['country_id']=$value->country_id;  
                    $getaddress[$key]['state_id']=$value->state_id;  
                    $getaddress[$key]['city_id']=$value->city_id;  
                    $getaddress[$key]['country']=$value->country->name; 
                    $getaddress[$key]['state']=$value->state->name;
                    $getaddress[$key]['city']=$value->city->name;
                    $getaddress[$key]['add_lat']=$value->add_lat;
                    $getaddress[$key]['add_long']=$value->add_long;
                    $getaddress[$key]['street_address']=$value->street_address;
                    $getaddress[$key]['landmark']=$value->landmark;
                    $getaddress[$key]['pincode']=$value->pincode;
                    $getaddress[$key]['address_type']=$value->address_type;
                    $getaddress[$key]['is_active']=$value->is_active;
                    $getaddress[$key]['is_primary_address']=$value->is_primary_address;
                   
             }
               $address=$getaddress;
              return $this->respond([
             'status'=> '1',
             'message'=> 'User Address get successfully.',
             'data'=>$address
           ]);
          } else {
              $address['status']= '0';
              $address['message']='Address not found.';
              return $this->respond($address);
          }
      } else {
            $address['status']= '0';
            $address['message']='Invalid user id.';
            return $this->respond($address);
      }
    }

    /**
     * @param AddAddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveAddress(Request $request)
    {

         $validation = Validator::make($request->all(), [
              'user_id'    => 'required',
              'address_type' => 'required',
              'pincode' => 'required',
              'country_id' => 'required',
              'state_id' => 'required',
              'city_id' => 'required',
          ]);

           if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

      if(!empty($request->get('user_id')))
      {
       $this->userAddress->create([
            'user_id' => $request->user_id,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'street_address' => $request->street_address,
            'landmark' => $request->landmark,
            'pincode' => $request->pincode,
            'add_lat' => $request->add_lat,
            'add_long' => $request->add_long,
            'address_type' => $request->address_type,
            'is_active' => $request->is_active ?? INACTIVE,
            'is_primary_address' => $request->is_primary_address ?? INACTIVE,
        ]);

         $responsdata['country_id']=$request->country_id;
         $responsdata['state_id']=$request->state_id;
         $responsdata['city_id']=$request->city_id;
         $responsdata['street_address']=$request->street_address;
         $responsdata['add_lat']=$request->add_lat;
         $responsdata['add_long']=$request->add_long;
         $responsdata['landmark']=$request->landmark;
         $responsdata['pincode']=$request->pincode;
         $responsdata['address_type']=$request->address_type;
          return $this->respond([
            'status'=>'1',
            'message'=>'Address successfully add.',
            'data'=>$responsdata,
          ]);
      } else {
            $responsdata['status']='0';
            $responsdata['message']='User Id invalid';
            return $this->respond($responsdata);
      }
    }

   /**
     * @param UpdateAddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAddress(Request $request)
    {

      $validation = Validator::make($request->all(), [
              'id' =>'required',
              'user_id'    => 'required',
              'address_type' => 'required',
              'pincode' => 'required',
              'country_id' => 'required',
              'state_id' => 'required',
              'city_id' => 'required',
              'add_lat' =>'required',
              'add_long'=>'required',
          ]);

           if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

      if(!empty($request->get('id')) && !empty($request->get('user_id')))
      {
       $this->userAddress->where('id', $request->id)
            ->update([
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'street_address' => $request->street_address,
                'landmark' => $request->landmark,
                'pincode' => $request->pincode,
                'add_lat' => $request->add_lat,
                'add_long' => $request->add_long,
                'address_type' => $request->address_type
        ]);
             $responsdata['country_id']=$request->country_id;
             $responsdata['state_id']=$request->state_id;
             $responsdata['city_id']=$request->city_id;
             $responsdata['street_address']=$request->street_address;
             $responsdata['landmark']=$request->landmark;
             $responsdata['pincode']=$request->pincode;
             $responsdata['add_lat']=$request->add_lat;
             $responsdata['add_long']=$request->add_long;
             $responsdata['address_type']=$request->address_type;
              return $this->respond([
                'status'=>'1',
                'message'=>'Address successfully updated.',
                'data'=>$responsdata,
              ]);
      } else {
              $responsdata['status']='0';
              $responsdata['message']='Invalid id';
              return $this->respond($responsdata);
      }
    }


    /**
     * @param AddressFormRequest $request
     */
    public function removeAddress(Request $request)
    {
      if(!empty($request->get('id')) && !empty($request->get('user_id')))
      {
        $addressId = $request->get('id');
        $address = $this->userAddress->find($addressId);
          if(!empty($address))
          {
            $this->userAddress->find($addressId)->delete();
            $responsdata['status']='1';
            $responsdata['message']='Address successfully deleted';
            return $this->respond($responsdata);
          } else {
            $responsdata['status']='0';
            $responsdata['message']='User address not match.';
            return $this->respond($responsdata);
          }
      } else {
            $responsdata['status']='0';
            $responsdata['message']='Invalid id';
            return $this->respond($responsdata);
      } 
    }


}

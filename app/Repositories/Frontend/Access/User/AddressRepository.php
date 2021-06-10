<?php

namespace App\Repositories\Frontend\Access\User;

use App\Models\Access\User\UserAddress;
use App\Repositories\BaseRepository;

class AddressRepository extends BaseRepository
{
    /**
     * @var UserAddress
     */
    protected $userAddress;

    /**
     * @param UserAddress $userAddress
     */
    public function __construct(UserAddress $userAddress)
    {
        $this->userAddress = $userAddress;
    }

    /**
     * @param object $request
     */
    public function addAddress(object $request)
    {
        return $this->userAddress->create([
            'user_id' => auth()->user()->id,
            'country_id' => $request->countryId(),
            'state_id' => $request->stateId(),
            'city_id' => $request->cityId(),
            'street_address' => $request->streetAddress(),
            'alternative_address' => $request->alternativeAddress(),
            'landmark' => $request->landmark(),
            'pincode' => $request->pincode(),
            'address_type' => $request->addressType(),
            'is_active' => $request->isActive() ?? INACTIVE,
            'is_primary_address' => $request->isPrimaryAddress() ?? INACTIVE,
        ]);
    }

    /**
     * @param object $request
     * @return mixed
     */
    public function updateAddress(object $request)
    {
        return $this->userAddress->where('id', $request->addressId())
            ->update([
                'country_id' => $request->countryId(),
                'state_id' => $request->stateId(),
                'city_id' => $request->cityId(),
                'street_address' => $request->streetAddress(),
                'alternative_address' => $request->alternativeAddress(),
                'landmark' => $request->landmark(),
                'pincode' => $request->pincode(),
                'address_type' => $request->addressType()
        ]);
    }
}

<?php

namespace App\Repositories\Frontend\Access\User;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Models\Access\User\UserAddress;
use App\Models\RoleUser;
use App\Repositories\BaseRepository;
use Ramsey\Uuid\Uuid;
use App\Models\Access\User\SocialLogin;
use Str,Hash;
class UserRepository extends BaseRepository
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var UserAddress
     */
    protected $userAddress;

    /**
     * @var RoleUser
     */
    protected $roleUser;

    /**
     * @param User $user
     * @param RoleUser $roleUser
     * @param UserAddress $userAddress
     */
    public function __construct(
        User $user,
        RoleUser $roleUser,
        UserAddress $userAddress
    ) {
        $this->user = $user;
        $this->roleUser = $roleUser;
        $this->userAddress = $userAddress;
    }

    /**
     * @param $email
     *
     * @return bool
     */
    public function findById($userId)
    {
        return $this->user->where('id', $userId)->first();
    }

    /**
     * @param $email
     *
     * @return bool
     */
    public function findByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }

    /**
     * @param object $requestData
     * @return string
     */
    public function userRegistered(object $requestData)
    {
        $slug = app(Controller::class)->getSlug(
            $requestData->firstName() . ' ' . $requestData->lastName() . time(),
            '',
            'users'
        );
        $confirmationCode = $requestData->confirmationCode();
        $user = $this->user->create([
            //'first_name' => $requestData->firstName(),
            //'last_name' => $requestData->lastName(),
            'slug' => $slug,
            'email' => $requestData->email(),
            //'phone' => $requestData->phoneNo(),
            'password' => $requestData->password(),
            'confirmation_code' => $confirmationCode,
            'status' => $requestData->isActive(),
            //'confirmed' => $requestData->isConfirm(),
            'confirmed' => '1',
            'remember_token' => $requestData->token(),
        ])->fresh();

        $this->assignRole($requestData->userType(), $user);
        $this->userPermission($user);

        return $user;
    }
    public function userRegisterApp(object $requestData)
    {
        $slug = app(Controller::class)->getSlug(
              $requestData->first_name,
              '',
              'users'
          );
         $user = $this->user->create([
            'first_name' => $requestData->first_name,
            'slug' => $slug,
            'email' => $requestData->email,
            'phone' => isset($requestData->phone)?$requestData->phone:'',
            'password' => Hash::make($requestData->password),
            'confirmation_code' =>Uuid::uuid4()->toString(),
            'status' => 1,
            'confirmed' => 1
        ])->fresh();

        $this->assignRole($requestData->role, $user);
        $this->userPermission($user);

        return $user;
    }

    public function vendorRegisterApp(object $requestData)
    {
        $slug = app(Controller::class)->getSlug(
              $requestData->first_name,
              '',
              'users'
          );
         $user = $this->user->create([
            'first_name' => $requestData->first_name,
            'slug' => $slug,
            'phone' => $requestData->phone,
            'email' => $requestData->email,
            'password' => Hash::make($requestData->password),
            'confirmation_code' =>Uuid::uuid4()->toString(),
            'status' => 1,
            'confirmed' => 0
        ])->fresh();

        $this->assignRole($requestData->role, $user);
        $this->userPermission($user);

        return $user;
    }
    public function branchAdd(object $requestData)
    {
        $slug = app(Controller::class)->getSlug(
              $requestData->first_name.$requestData->last_name,
              '',
              'users'
          );
         $user = $this->user->create([
            'first_name' => $requestData->first_name,
            'last_name' => $requestData->last_name,
            'slug' => $slug,
            'phone' => $requestData->phone,
            'email' => $requestData->email,
            'password' => Hash::make($requestData->password),
            'confirmation_code' =>Uuid::uuid4()->toString(),
            'status' => 1,
            'confirmed' => 0
        ])->fresh();

        $this->assignRole($requestData->role, $user);
        $this->userPermission($user);

        return $user;
    }

    /**
     * @param $userType
     * @param $user
     * @return mixed
     */
    private function assignRole($userType, $user)
    {
        return $this->roleUser->create([
            'user_id' => $user->id(),
            'role_id' => $userType
        ]);
    }

    /**
     * @param $user
     * @return mixed
     */
    private function userPermission($user)
    {
        $permissions = $user->roles->first()->permissions->pluck('id');

        return $user->permissions()->sync($permissions);
    }

    /**
     * @param object $requestData
     * @return mixed
     * @throws \Exception
     */
    public function updateProfile(object $requestData)
    {
        $this->unlinkProfile($requestData);
        $profile = $this->uploadProfile($requestData);

        return $this->findById(auth()->user()->id)
            ->update([
                'first_name' => $requestData->firstName(),
                'last_name' => $requestData->lastName(),
                'phone' => $requestData->phoneNo(),
                'image' => $profile
            ]);
    }

    /**
     * @param $requestData
     * @return string
     * @throws \Exception
     */
    private function uploadProfile($requestData)
    {
        if ($requestData->hasFile('image')) {
            $extension = $requestData->file('image')->getClientOriginalExtension();
            $fileName = Uuid::uuid4()->toString() . '.' . $extension;
            if ($requestData->file('image')->move(USER_PROFILE_IMAGE_ROOT_PATH . auth()->user()->slug . DS, $fileName)) {
                return $fileName;
            }
        }

        return auth()->user()->image();
    }

    /**
     * @param $requestData
     */
    private function unlinkProfile($requestData)
    {
        if ($requestData->hasFile($requestData->profileImage())) {
            $user = $this->findById(auth()->user()->id);
            @unlink(USER_PROFILE_IMAGE_ROOT_PATH . auth()->user()->slug . DS . $user->image());
        }

        return;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updatePassword($request)
    {
        $user = $this->findById(auth()->user()->id);
        if (Hash::check($request->oldPassword(), $user->getAuthPassword())) {
            $user->password = Hash::make($request->newPassword());
            if ($user->save()) {

                return response()->json([
                    'success' => true
                ]);
            }
        } else {
            $error[] = trans("Please enter correct old password.");

            return response()->json(['errors' => ['error' => $error]], 422);
        }
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



    /**
     * @param $data
     * @param $provider
     * @return UserRepository|bool
     */
    public function findOrCreateSocial($data, $provider)
    {
        $user_email = $data->email ?: "{$data->id}@{$provider}.com";

        $user = $this->findByEmail($user_email);
        if (!$user) {
            if (!config('access.users.registration')) {
                throw new GeneralException(trans('exceptions.frontend.auth.registration_disabled'));
            }

            $user = $this->create([
                'name'  => $data->name,
                'email' => $user_email,
            ], true);
        }

        if (!$user->hasProvider($provider)) {
            $user->providers()->save(new SocialLogin([
                'provider'    => $provider,
                'provider_id' => $data->id,
                'token'       => $data->token,
                'avatar'      => $data->avatar,
            ]));
        } else {
            $user->providers()->update([
                'token'  => $data->token,
                'avatar' => $data->avatar,
            ]);
        }
        return $user;
    }


    /**
     * @param array $data
     * @param bool  $provider
     * @return static
     */
    public function create(array $data, $provider = false)
    {
        $user = new User;
        $user->first_name = $data['name'];
        //$user->last_name = $data['last_name'];
        $user->slug = app(Controller::class)->getSlug(
              $data['name'],'','users');
        $user->email = $data['email'];
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->status = 1;
        $user->password = $provider ? null : Hash::make($data['password']);

        if (config('access.users.requires_approval')) {
            $user->confirmed = 0; 
        } elseif (config('access.users.confirm_email')) { 
            if ($provider) {
                $user->confirmed = 1; 
            } else {
                $user->confirmed = 0;
                $confirm = true;
            }
        } else {
            $user->confirmed = 1;
        }

            if ($user->save()) {
                $this->assignRole('2', $user);
                $this->userPermission($user);
                 
                if (config('access.users.confirm_email') && $provider === false) {
                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                }
            }

        return $user;
    }

}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\RestaurantBranch\RestaurantBranchAddRequest;
use App\Http\Requests\Frontend\RestaurantBranch\RestaurantBranchDeleteRequest;
use App\Http\Requests\Frontend\RestaurantBranch\RestaurantBranchEditRequest;
use App\Http\Requests\Frontend\RestaurantBranch\RestaurantBranchSaveRequest;
use App\Http\Requests\Frontend\RestaurantBranch\RestaurantBranchShowRequest;
use App\Http\Requests\Frontend\RestaurantBranch\RestaurantBranchUpdateRequest;
use App\Models\Access\User\User;
use App\Models\Categories\Category;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Repositories\Frontend\Restaurant\RestaurantRepository;

class RestaurantBranchController extends Controller
{
    /**
     * @var RestaurantRepository
     */
    protected $restaurantRepository;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var User
     */
    protected $user;

    /**
     * RestaurantBranchController constructor.
     * @param RestaurantRepository $restaurantRepository
     * @param UserRepository $userRepository
     * @param Category $category
     * @param User $user
     */
    public function __construct(
        RestaurantRepository $restaurantRepository,
        UserRepository $userRepository,
        Category $category,
        User $user
    ) {
        $this->restaurantRepository = $restaurantRepository;
        $this->userRepository = $userRepository;
        $this->category = $category;
        $this->user = $user;
    }

    /**
     * @param RestaurantBranchShowRequest $showRequest
     * @return View
     */
    public function branch(RestaurantBranchShowRequest $showRequest)
    {
        $branches = $this->restaurantRepository->branch();

        return view('frontend.restaurant.branch.list',
            compact('branches')
        );
    }

    /**
     * @param RestaurantBranchAddRequest $request
     * @return View
     */
    public function addBranch(RestaurantBranchAddRequest $request)
    {
        $categories =  $this->category->isActive()->get();

        return view('frontend.restaurant.branch.add_branch',
            compact('categories')
        );
    }

    /**
     * @param RestaurantBranchSaveRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function saveBranch(RestaurantBranchSaveRequest $request)
    {
        $user = $this->userRepository->userRegistered($request);
        $restaurantId = auth()->user()['isApprovedRestaurant']->id();
        $this->restaurantRepository->createAndUpdateBranch($user->id, $restaurantId, $request);

        $mailData = [
            'name' => $user->firstName() .' '. $user->lastName(),
            'email' => $user->email(),
            'password' => $request->get('password'),
            'url' => url('login'),
        ];

        $this->sendMail(
            $mailData,
            'emails.user_registration',
            'New user registration'
        );

        session()->put('branch',
            [
                'title' => trans('Branch'),
                'msg' => trans('Branch has been successfully added.')
            ]
        );

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param RestaurantBranchDeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteBranch(RestaurantBranchDeleteRequest $request)
    {
        if ($request->ajax()) {
            $this->user->where('id', $request->userId())
                ->update(['email' => uniqid(), 'phone' => uniqid()]);

            $this->user->where('id', $request->userId())->delete();
            $restaurantId = auth()->user()['isApprovedRestaurant']->id();
            $this->restaurantRepository->removeBranch($request->userId(), $restaurantId);
            $branchCount = $this->restaurantRepository->branchCount($restaurantId);

            if($branchCount < ONE){
                $lastRecord		=	true;
            }

            return response()->json([
                'success' => true,
                'lastRecord'	=>	isset($lastRecord) ? $lastRecord : ''
            ]);
        }

        return response()->to('/');
    }

    /**
     * @param RestaurantBranchEditRequest $request
     * @param int $branchId
     * @return View
     */
    public function editBranch(RestaurantBranchEditRequest $request, int $branchId)
    {
        $branchDetails = $this->restaurantRepository->branchInformation($branchId);
        $categories =  $this->category->isActive()->get();
        $restaurantCategory = $this->restaurantRepository
            ->getRestaurantCategory($branchDetails->userId(), $branchDetails->restaurantId())
            ->pluck('category_id')
            ->all();

        $restaurantServiceType = $this->restaurantRepository
            ->getRestaurantServiceType($branchDetails->userId(), $branchDetails->restaurantId())
            ->pluck('service_type_id')
            ->all();

        return view('frontend.restaurant.branch.edit_branch',
            compact('categories','branchDetails', 'restaurantCategory', 'restaurantServiceType')
        );
    }

    /**
     * @param RestaurantBranchUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateBranch(RestaurantBranchUpdateRequest $request)
    {
        $this->user->where('id', $request->userId())->update([
            'first_name' => $request->firstName(),
            'last_name' => $request->lastName(),
        ]);

        $restaurantId = auth()->user()['isApprovedRestaurant']->id();
        $this->restaurantRepository->createAndUpdateBranch($request->userId(), $restaurantId, $request);

        session()->put('branch',
            [
                'title' => trans('Branch'),
                'msg' => trans('Branch has been successfully updated.')
            ]
        );

        return response()->json([
            'success' => true
        ]);
    }

    public function viewBranch(int $branchId)
    {
        $branchDetails = $this->restaurantRepository->branchInformation($branchId);

        return view('frontend.restaurant.branch.view',
            compact('branchDetails')
        );
    }
}

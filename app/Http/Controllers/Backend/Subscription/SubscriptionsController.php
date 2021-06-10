<?php

namespace App\Http\Controllers\Backend\Subscription;

use App\Models\Subscription\Subscription;
use App\Models\Subscription\SubscriptionFeature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Subscription\CreateResponse;
use App\Http\Responses\Backend\Subscription\EditResponse;
use App\Repositories\Backend\Subscription\SubscriptionRepository;
use App\Http\Requests\Backend\Subscription\ManageSubscriptionRequest;
use App\Http\Requests\Backend\Subscription\CreateSubscriptionRequest;
use App\Http\Requests\Backend\Subscription\StoreSubscriptionRequest;
use App\Http\Requests\Backend\Subscription\EditSubscriptionRequest;
use App\Http\Requests\Backend\Subscription\UpdateSubscriptionRequest;
use App\Http\Requests\Backend\Subscription\DeleteSubscriptionRequest;

class SubscriptionsController extends Controller
{
    /**
     * @var SubscriptionRepository
     */
    protected $repository;

    /**
     * SubscriptionsController constructor.
     * @param SubscriptionRepository $repository
     */
    public function __construct(SubscriptionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ManageSubscriptionRequest $request
     * @return ViewResponse
     */
    public function index(ManageSubscriptionRequest $request)
    {
        return new ViewResponse('backend.subscriptions.index');
    }

    /**
     * @param CreateSubscriptionRequest $request
     * @return CreateResponse
     */
    public function create(CreateSubscriptionRequest $request)
    {
        return new CreateResponse('backend.subscriptions.create');
    }

    /**
     * @param StoreSubscriptionRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function store(StoreSubscriptionRequest $request)
    {
        $input = $request->except(['_token']);
        $this->repository->create($input);

        return new RedirectResponse(route('admin.subscriptions.index'),
            ['flash_success' => trans('alerts.backend.subscriptions.created')]
        );
    }

    /**
     * @param Subscription $subscription
     * @param EditSubscriptionRequest $request
     * @return EditResponse
     */
    public function edit(Subscription $subscription, EditSubscriptionRequest $request)
    {
        return new EditResponse($subscription);
    }

    /**
     * @param UpdateSubscriptionRequest $request
     * @param Subscription $subscription
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        $input = $request->except(['_token']);
        $this->repository->update( $subscription, $input );

        return new RedirectResponse(route('admin.subscriptions.index'),
            ['flash_success' => trans('alerts.backend.subscriptions.updated')]
        );
    }

    /**
     * @param Subscription $subscription
     * @param DeleteSubscriptionRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(Subscription $subscription, DeleteSubscriptionRequest $request)
    {
        $this->repository->delete($subscription);

        return new RedirectResponse(route('admin.subscriptions.index'),
            ['flash_success' => trans('alerts.backend.subscriptions.deleted')]
        );
    }

    /**
     * @param Request $request
     * @return View
     */
    public function Feature(Request $request)
    {
        $getplanlist=SubscriptionFeature::with('getplan')->get();

        return view('backend.subscriptions.feature.index',
            compact('getplanlist')
        );
    }

    /**
     * @return View
     */
    public function FeatureCreate()
    {
        $getplan=Subscription::where('status',1)->get();

        return view('backend.subscriptions.feature.create',
            compact('getplan')
        );
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function FeatureStore(Request $request)
    {
         $request->validate([
          'price'=>'required|numeric',
         ]);
          $feature= new SubscriptionFeature;
          $feature->title=$request->title;
          $feature->price=$request->price;
          $feature->subscription_plan_id=$request->subscription_id;
          $feature->features=$request->features;
          $feature->status=isset($request->status)?1:0;
          $feature->save();

          return redirect()->to('admin/subscriptions/feature')
              ->withFlashSuccess('Plan add successfull');
    }

    /**
     * @param null $id
     * @return View
     */
    public function FeatureEdit($id=null)
    {
        $getfeature=SubscriptionFeature::find($id);
        $getplan=Subscription::where('status',1)->get();

        return view('backend.subscriptions.feature.edit',
            compact('getfeature','getplan')
        );
   }

    /**
     * @param Request $request
     * @param null $id
     * @return mixed
     */
    public function FeatureUpdate(Request $request, $id=null)
    {
         $request->validate([
          'price'=>'required|numeric',
         ]);
          $feature= SubscriptionFeature::where('id',$id)->first();
          $feature->title=$request->title;
          $feature->price=$request->price;
          $feature->subscription_plan_id=$request->subscription_id;
          $feature->features=$request->features;
          $feature->status=isset($request->status)?1:0;
          $feature->save();

          return redirect()->to('admin/subscriptions/feature')
              ->withFlashSuccess('Plan add successfull');
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function FeatureDelete($id=null)
    {
        SubscriptionFeature::where('id',$id)->delete();

        return redirect()->to('admin/subscriptions/feature')
            ->withFlashSuccess('feature Plan delete successfull');
    }
}

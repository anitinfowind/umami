<?php

namespace App\Http\Controllers\Backend\Faqs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Faqs\CreateFaqsRequest;
use App\Http\Requests\Backend\Faqs\DeleteFaqsRequest;
use App\Http\Requests\Backend\Faqs\EditFaqsRequest;
use App\Http\Requests\Backend\Faqs\ManageFaqsRequest;
use App\Http\Requests\Backend\Faqs\StoreFaqsRequest;
use App\Http\Requests\Backend\Faqs\UpdateFaqsRequest;
use App\Http\Responses\Backend\Faq\EditResponse;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\Faqs\Faq;
use App\Repositories\Backend\Faqs\FaqsRepository;

class FaqsController extends Controller
{
    /**
     * @var FaqsRepository
     */
    protected $faq;

    /**
     * @param FaqsRepository $faq
     */
    public function __construct(FaqsRepository $faq)
    {
        $this->faq = $faq;
    }

    /**
     * @param ManageFaqsRequest $request
     * @return ViewResponse
     */
    public function index(ManageFaqsRequest $request)
    {
        return new ViewResponse('backend.faqs.index');
    }

    /**
     * @param CreateFaqsRequest $request
     * @return ViewResponse
     */
    public function create(CreateFaqsRequest $request)
    {
        return new ViewResponse('backend.faqs.create');
    }

    /**
     * @param StoreFaqsRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function store(StoreFaqsRequest $request)
    {
        $this->faq->create($request->all());

        return new RedirectResponse(route('admin.faqs.index'),
            ['flash_success' => trans('alerts.backend.faqs.created')]
        );
    }

    /**
     * @param Faq $faq
     * @param EditFaqsRequest $request
     * @return EditResponse
     */
    public function edit(Faq $faq, EditFaqsRequest $request)
    {
        return new EditResponse($faq);
    }

    /**
     * @param UpdateFaqsRequest $request
     * @param Faq $faq
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function update(UpdateFaqsRequest $request, Faq $faq)
    {
        $this->faq->update($faq, $request->all());

        return new RedirectResponse(route('admin.faqs.index'),
            ['flash_success' => trans('alerts.backend.faqs.updated')]
        );
    }

    /**
     * @param Faq $faq
     * @param DeleteFaqsRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(Faq $faq, DeleteFaqsRequest $request)
    {
        $this->faq->delete($faq);

        return new RedirectResponse(route('admin.faqs.index'),
            ['flash_success' => trans('alerts.backend.faqs.deleted')]
        );
    }
}

<?php

namespace App\Http\Controllers\Backend\Faqs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Faqs\EditFaqsRequest;
use App\Models\Faqs\Faq;
use App\Repositories\Backend\Faqs\FaqsRepository;

class FaqStatusController extends Controller
{
    protected $faq;

    /**
     * @param FaqsRepository $faq
     */
    public function __construct(FaqsRepository $faq)
    {
        $this->faq = $faq;
    }

    /**
     * @param Faq $faq
     * @param $status
     * @param EditFaqsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function store(Faq $faq, $status, EditFaqsRequest $request)
    {
        $this->faq->mark($faq, $status);

        return redirect()
            ->route('admin.faqs.index')
            ->with('flash_success', trans('alerts.backend.faqs.updated'));
    }
}

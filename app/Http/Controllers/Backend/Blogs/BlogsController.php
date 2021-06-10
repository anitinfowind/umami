<?php

namespace App\Http\Controllers\Backend\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Blogs\ManageBlogsRequest;
use App\Http\Requests\Backend\Blogs\StoreBlogsRequest;
use App\Http\Requests\Backend\Blogs\UpdateBlogsRequest;
use App\Http\Responses\Backend\Blog\CreateResponse;
use App\Http\Responses\Backend\Blog\EditResponse;
use App\Http\Responses\Backend\Blog\IndexResponse;
use App\Http\Responses\RedirectResponse;
use App\Models\Blogs\Blog;
use App\Repositories\Backend\Blogs\BlogsRepository;

class BlogsController extends Controller
{
    /**
     * @var string[]
     */
    protected $status = [
        'Published' => 'Published',
        'Draft'     => 'Draft',
        'InActive'  => 'InActive',
        'Scheduled' => 'Scheduled',
    ];

    /**
     * @var BlogsRepository
     */
    protected $blog;

    /**
     * @param BlogsRepository $blog
     */
    public function __construct(BlogsRepository $blog)
    {
        $this->blog = $blog;
    }

    /**
     * @param ManageBlogsRequest $request
     * @return IndexResponse
     */
    public function index(ManageBlogsRequest $request)
    {
        return new IndexResponse($this->status);
    }

    /**
     * @param ManageBlogsRequest $request
     * @return CreateResponse
     */
    public function create(ManageBlogsRequest $request)
    {
        return new CreateResponse($this->status);
    }

    /**
     * @param StoreBlogsRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function store(StoreBlogsRequest $request)
    {
        $this->blog->create($request->except('_token'));

        return new RedirectResponse(route('admin.blogs.index'),
            ['flash_success' => trans('alerts.backend.blogs.created')]
        );
    }

    /**
     * @param Blog $blog
     * @param ManageBlogsRequest $request
     * @return EditResponse
     */
    public function edit(Blog $blog, ManageBlogsRequest $request)
    {
        return new EditResponse($blog, $this->status);
    }

    /**
     * @param Blog $blog
     * @param UpdateBlogsRequest $request
     * @return RedirectResponse
     */
    public function update(Blog $blog, UpdateBlogsRequest $request)
    {
        $input = $request->all();

        $this->blog->update($blog, $request->except(['_token', '_method']));

        return new RedirectResponse(route('admin.blogs.index'),
            ['flash_success' => trans('alerts.backend.blogs.updated')]
        );
    }

    /**
     * @param Blog $blog
     * @param ManageBlogsRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(Blog $blog, ManageBlogsRequest $request)
    {
        $this->blog->delete($blog);

        return new RedirectResponse(route('admin.blogs.index'),
            ['flash_success' => trans('alerts.backend.blogs.deleted')]
        );
    }
}

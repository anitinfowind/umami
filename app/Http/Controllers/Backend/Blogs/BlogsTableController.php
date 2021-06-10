<?php

namespace App\Http\Controllers\Backend\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Blogs\ManageBlogsRequest;
use App\Repositories\Backend\Blogs\BlogsRepository;
use Yajra\DataTables\Facades\DataTables;

class BlogsTableController extends Controller
{
    /**
     * @var BlogsRepository
     */
    protected $blogs;

    /**
     * @param BlogsRepository $blogs
     */
    public function __construct(BlogsRepository $blogs)
    {
        $this->blogs = $blogs;
    }

    /**
     * @param ManageBlogsRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function __invoke(ManageBlogsRequest $request)
    {
        return Datatables::of($this->blogs->getForDataTable())
            ->escapeColumns(['name'])
            ->addColumn('status', function ($blogs) {
                return $blogs->status;
            })
            ->addColumn('publish_datetime', function ($blogs) {
                return $blogs->publish_datetime->format('d-M-Y h:i A');
            })
            ->addColumn('created_by', function ($blogs) {
                return $blogs->user_name;
            })
            ->addColumn('created_at', function ($blogs) {
                return $blogs->created_at->format('d-M-Y');
            })
            ->addColumn('actions', function ($blogs) {
                return $blogs->action_buttons;
            })
            ->make(true);
    }
}

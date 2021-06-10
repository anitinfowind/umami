<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blogs\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * @var Blog
     */
    private $blog;

    /**
     * @var Comment
     */
    private $comment;

    /**
     * @param Blog $blog
     * @param Comment $comment
     */
    public function __construct(
        Blog $blog,
        Comment $comment
    ) {
        $this->blog = $blog;
        $this->comment = $comment;
    }

    /**
     * @return View
     */
    public function show()
    {
        $blogs = $this->blog->where('status', PUBLISHED)->orderBy('created_at', 'desc')->get();

        return view('frontend.blog.blog',
            compact('blogs')
        );
    }

    /**
     * @param string $slug
     * @return View
     */
    public function blogDetail(string $slug)
    {
        $recent_blogs = $this->blog->where('status', PUBLISHED)->orderBy('created_at', 'desc')->limit(5)->get();
        $blogDetail = $this->blog->where('slug', $slug)->firstOrFail();
        $comments = $this->comment->blogComment($blogDetail->id)->get();

        return view('frontend.blog.blog-detail',
            compact('blogDetail', 'comments', 'recent_blogs')
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(Request $request)
    {
        if ($request->ajax()) {
            $this->comment->create([
                'user_id' => auth()->user()->id,
                'blog_id' => $request->get('blog_id'),
                'comment' => nl2br(strip_tags($request->get('comment'))),
            ]);

            $comments = $this->comment->blogComment($request->get('blog_id'))->get();

            return response()->json([
                'success' => true,
                'comment' => \View::make('frontend.blog.comment-element', compact('comments'))->render()
            ]);
        }

        return redirect()->to('/');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeComment(Request $request)
    {
        $commentId = $request->get('comment_id');

        $comment = $this->comment->find($commentId)->delete();
        if ($comment) {
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }
}

<?php

namespace App\Repositories\Backend\Blogs;

use App\Events\Backend\Blogs\BlogCreated;
use App\Events\Backend\Blogs\BlogDeleted;
use App\Events\Backend\Blogs\BlogUpdated;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Models\Blogs\Blog;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use DB,File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class BlogsRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Blog::class;

    protected $upload_path;

    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;

    public function __construct()
    {
        $this->upload_path = 'img'.DIRECTORY_SEPARATOR.'blog'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config('module.blogs.table').'.created_by')
            ->select([
                config('module.blogs.table').'.id',
                config('module.blogs.table').'.name',
                config('module.blogs.table').'.publish_datetime',
                config('module.blogs.table').'.status',
                config('module.blogs.table').'.created_by',
                config('module.blogs.table').'.created_at',
                config('access.users_table').'.first_name as user_name',
            ]);
    }

    /**
     * @param array $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function create(array $input)
    {
        DB::transaction(function () use ($input) {
            $input['slug'] = app(Controller::class)->getSlug($input['name'],'','blogs');
            $input['publish_datetime'] = Carbon::parse($input['publish_datetime']);
            $input = $this->uploadImage($input);
            $input['created_by'] = access()->user()->id;

            if ($blog = Blog::create($input)) {
                event(new BlogCreated($blog));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.blogs.create_error'));
        });
    }

    /**
     * Update Blog.
     *
     * @param \App\Models\Blogs\Blog $blog
     * @param array                  $input
     */
    public function update(Blog $blog, array $input)
    {
        $input['publish_datetime'] = Carbon::parse($input['publish_datetime']);
        $input['updated_by'] = access()->user()->id;

        // Uploading Image
        if (array_key_exists('featured_image', $input)) {
            $this->deleteOldFile($blog);
            $input = $this->uploadImage($input);
        }

        DB::transaction(function () use ($blog, $input){
            if ($blog->update($input)) {
                event(new BlogUpdated($blog));

                return true;
            }

            throw new GeneralException(
                trans('exceptions.backend.blogs.update_error')
            );
        });
    }

    /**
     * @param \App\Models\Blogs\Blog $blog
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Blog $blog)
    {
        DB::transaction(function () use ($blog) {
            if ($blog->delete()) {
                event(new BlogDeleted($blog));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.blogs.delete_error'));
        });
    }

    /**
     * Upload Image.
     *
     * @param array $input
     *
     * @return array $input
     */
    public function uploadImage($input)
    {
        $avatar = $input['featured_image'];
        if (isset($avatar) && !empty($avatar)) {
            $extension = $avatar->getClientOriginalExtension();
            $fileName =	Uuid::uuid4()->toString().'.'.$extension;
            if ($avatar->move(BLOG_ROOT_PATH, $fileName)) {
                $input = array_merge($input, ['featured_image' => $fileName]);
            }

            return $input;
        }
    }

    /**
     * Destroy Old Image.
     *
     * @param int $id
     */
    public function deleteOldFile($model)
    {
        if (File::exists(BLOG_ROOT_PATH.$model->featured_image)) {
            @unlink(BLOG_ROOT_PATH.$model->featured_image);
        }
    }
}

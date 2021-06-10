<?php

namespace App\Repositories\Backend\Video;

use DB;
use Carbon\Carbon;
use App\Models\Video\Video;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use File;
/**
 * Class VideoRepository.
 */
class VideoRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Video::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->select([
                config('module.videos.table').'.id',
                config('module.videos.table').'.title',
                config('module.videos.table').'.video',
                config('module.videos.table').'.location',
                config('module.videos.table').'.is_active',
                config('module.videos.table').'.video_type',
                config('module.videos.table').'.embedded_url',
                config('module.videos.table').'.created_at',
                config('module.videos.table').'.updated_at',
            ]);
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @throws GeneralException
     * @return bool
     */
    public function create(array $input)
    {

        if (Video::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.videos.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Video $video
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Video $video, array $input)
    {
    	if ($video->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.videos.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Video $video
     * @throws GeneralException
     * @return bool
     */
    public function delete(Video $video)
    {
        if ($video->delete()) {
           if (File::exists(public_path('/uploads/video/'.$video['video']))) {
                @unlink(public_path('/uploads/video/'.$video['video']));
            }
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.videos.delete_error'));
    }
}

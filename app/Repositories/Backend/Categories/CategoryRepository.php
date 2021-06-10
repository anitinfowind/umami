<?php
namespace App\Repositories\Backend\Categories;

use App\Models\Categories\Category;
use App\Repositories\BaseRepository;
use App\Http\Controllers\Controller;

class CategoryRepository extends BaseRepository
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->category->query()
            ->select([
                config('module.categories.table').'.id',
                config('module.categories.table').'.name',
                config('module.categories.table').'.is_active',
                config('module.categories.table').'.created_at',
                config('module.categories.table').'.updated_at',
            ]);
    }

    /**
     * @param object $requestData
     * @return mixed
     */
    public function create(object $requestData)
    {
        return $this->category->create([
            'name' => $requestData->name(),
            'description' => $requestData->description(),
            'slug' => app(Controller::class)->getSlug($requestData->name(), '', 'categories'),
            'is_active' => ($requestData->get('is_active')) ? ACTIVE : INACTIVE,
        ]);
    }

    /**
     * @param object $requestData
     * @param int $id
     * @return mixed
     */
    public function update(object $requestData, int $id)
    {
        return $this->category->where('id', $id)->update([
            'name' => $requestData->name(),
            'description' => $requestData->description(),
            'is_active' => ($requestData->get('is_active')) ? ACTIVE : INACTIVE,
        ]);
    }

}
<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Database\DatabaseManager;
use IndieHD\Velkart\Models\Eloquent\Category;
use IndieHD\Velkart\Contracts\CategoryRepositoryContract;
use IndieHD\Velkart\Repositories\Eloquent\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryContract
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * @var DatabaseManager
     */
    protected $db;

    /**
     * CategoryRepository constructor.
     * @param Category $category
     * @param DatabaseManager $db
     */
    public function __construct(Category $category, DatabaseManager $db)
    {
        $this->category = $category;
        $this->db = $db;
    }

    public function model(): Category
    {
        return $this->category;
    }

    public function modelClass(): string
    {
        return Category::class;
    }
}

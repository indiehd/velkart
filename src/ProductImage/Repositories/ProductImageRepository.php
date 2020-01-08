<?php

namespace IndieHD\Velkart\ProductImage\Repositories;

use Illuminate\Contracts\Filesystem\Factory as FilesystemContract;
use Illuminate\Database\DatabaseManager;
use IndieHD\Velkart\Base\Repositories\BaseRepository;
use IndieHD\Velkart\Base\Traits\UploadsFiles;
use IndieHD\Velkart\ProductImage\Contracts\ProductImageRepositoryContract;
use IndieHD\Velkart\ProductImage\ProductImage;

class ProductImageRepository extends BaseRepository implements ProductImageRepositoryContract
{
    use UploadsFiles;

    /**
     * @var ProductImage
     */
    protected $productImage;

    /**
     * @var FilesystemContract
     */
    protected $filesystem;

    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * ProductImageRepository constructor.
     * @param ProductImage $productImage
     * @param FilesystemContract $filesystem
     * @param DatabaseManager $db
     */
    public function __construct(ProductImage $productImage, FilesystemContract $filesystem, DatabaseManager $db)
    {
        $this->productImage = $productImage;
        $this->filesystem = $filesystem;
        $this->db = $db;
    }

    public function model(): object
    {
        return $this->productImage;
    }

    public function modelClass(): string
    {
        return ProductImage::class;
    }

    public function update(int $id, array $attributes): bool
    {
        $this->db->beginTransaction();

        $model = $this->model()->find($id);

        if ($model) {
            $oldFile = $model->src;

            if ($model->update($attributes)) {
                if ($this->filesystem->disk('public')->delete($oldFile)) {
                    $this->db->commit();
                    return true;
                }
            }
        }

        $this->db->rollBack();
        return false;
    }

    public function delete(int $id): bool
    {
        $this->db->beginTransaction();

        $model = $this->model()->find($id);

        if ($model) {
            if ($model->delete()) {
                if ($this->filesystem->disk('public')->delete($model->src)) {
                    $this->db->commit();
                    return true;
                }
            }
        }

        $this->db->rollBack();
        return false;
    }
}

<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Contracts\Filesystem\Factory as FilesystemContract;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Traits\UploadsFiles;
use IndieHD\Velkart\Contracts\ProductImageRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\ProductImage;

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

    public function model(): Model
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

        $model = $this->model()->lockForUpdate()->find($id);

        if ($model) {
            [$origDisk, $origPath] = [$model->disk, $model->path];

            if ($model->update($attributes)) {
                if ($this->filesystem->disk($origDisk)->delete($origPath)) {
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

        try {
            $model = $this->findById($id);

            if ($model->delete()) {
                $this->filesystem->disk($model->disk)->delete($model->path);
            }

        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }

        $this->db->commit();
        return true;
    }
}

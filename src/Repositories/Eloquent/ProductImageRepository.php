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

    /**
     * @return Model
     */
    public function model(): Model
    {
        return $this->productImage;
    }

    /**
     * @return string
     */
    public function modelClass(): string
    {
        return ProductImage::class;
    }

    /**
     * Updates A Product Image
     *
     * @param int $id
     * @param array $attributes
     * @return bool
     * @throws \Exception
     */
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

    /**
     * Deletes a Product Image
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        $this->db->beginTransaction();

        try {
            $model = $this->findById($id);

            if ($model->delete()) {
                if (!$this->filesystem->disk($model->disk)->delete($model->path)) {
                    throw new \Exception("Product image $id at $model->path not deleted from $model->disk");
                }
            }

        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }

        $this->db->commit();
        return true;
    }
}

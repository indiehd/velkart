<?php

namespace IndieHD\Velkart\ProductImage\Repositories;

use Illuminate\Contracts\Filesystem\Factory as FilesystemContract;
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
     * ProductImageRepository constructor.
     * @param ProductImage $productImage
     * @param FilesystemContract $filesystem
     */
    public function __construct(ProductImage $productImage, FilesystemContract $filesystem)
    {
        $this->productImage = $productImage;
        $this->filesystem = $filesystem;
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
        $model = $this->model()->find($id);
        $oldFile = $model->src;

        if ($model->update($attributes)) {
            $this->filesystem->disk('public')->delete($oldFile);

            return true;
        }

        return false;
    }

    public function delete(int $id): bool
    {

        $model = $this->model()->find($id);

        if ($model->delete()) {
            $this->filesystem->disk('public')->delete($model->src);

            return true;
        }

        return false;
    }
}

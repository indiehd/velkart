<?php

namespace Tests\Unit\Products;

use Illuminate\Contracts\Filesystem\Factory as FilesystemContract;
use Illuminate\Http\UploadedFile;
use IndieHD\Velkart\Base\Traits\UploadsFiles;
use IndieHD\Velkart\ProductImage\Contracts\ProductImageRepositoryContract;
use IndieHD\Velkart\Tests\TestCase;

class ProductImageTest extends TestCase
{
    use UploadsFiles;

    protected $repo;

    protected $filesystem;

    public function setUp(): void
    {
        parent::setUp();

        $this->repo = resolve(ProductImageRepositoryContract::class);
        $this->filesystem = resolve(FilesystemContract::class);
    }

    /** @test */
    public function itCanCreateAProductImageAndStoreImageOnDisk()
    {
        $productImage = factory($this->repo->modelClass())->create();

        $this->assertInstanceOf($this->repo->modelClass(), $productImage);
        $this->assertCount(1, $this->repo->list());
        $this->assertDatabaseHas('product_images', ['src' => $productImage->src]);

        $exists = $this->filesystem->disk('public')->exists($productImage->src);
        $this->assertTrue($exists, 'The product image does NOT exist');
    }

    /** @test */
    public function itCanUpdateAProductImageAndRemovesOldImageFromDisk()
    {
        $productImage = factory($this->repo->modelClass())->create();
        $oldFile = $productImage->src;

        $newImage = UploadedFile::fake()->image('product.jpg', 600, 600);
        $newFile = $this->storeFile($newImage);

        $updated = $this->repo->update($productImage->id, [
            'src' => $newFile
        ]);

        $oldFileExists = $this->filesystem->disk('public')->exists($oldFile);

        $this->assertTrue($updated, 'ProductImage did NOT update');
        $this->assertDatabaseHas('product_images', ['src' => $newFile]);
        $this->assertDatabaseMissing('product_images', ['src' => $oldFile]);
        $this->assertFalse($oldFileExists, 'ProductImage old file STILL exists');
    }

    /** @test */
    public function itCanDeleteAProductImageAndDeleteImageFromDisk()
    {
        $productImage = factory($this->repo->modelClass())->create();

        $this->assertDatabaseHas('product_images', ['src' => $productImage->src]);
        $this->assertTrue($this->repo->delete($productImage->id));
        $this->assertDatabaseMissing('product_images', ['src' => $productImage->src]);

        $exists = $this->filesystem->disk('public')->exists($productImage->src);
        $this->assertFalse($exists, 'The product image still exists');
    }
}

<?php

namespace Tests\Unit\Products;

use Illuminate\Contracts\Filesystem\Factory as FilesystemContract;
use Illuminate\Database\QueryException;
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

    private function createProductImage($params = null): object
    {
        if ($params === null)
            $params = factory($this->repo->modelClass())->make()->toArray();

        return $this->repo->create($params);
    }

    /** @test */
    public function itCanCreateAProductImage()
    {
        $this->assertDatabaseHas('product_images', ['src' => $this->createProductImage()->src]);
    }

    /** @test */
    public function itCanSaveImageToDiskDuringCreation()
    {
        $productImage = $this->createProductImage();

        $exists = $this->filesystem->disk('public')->exists($productImage->src);
        $this->assertTrue($exists, 'The product image does NOT exist');
    }

    /** @test */
    public function itThrowsAQueryExceptionWhenGivenAnInvalidProductId()
    {
        $this->expectException(QueryException::class);

        $this->createProductImage([
            'product_id' => 5,
            'src' => 'somerandomstring'
        ]);
    }

    /** @test */
    public function itCanUpdateAProductImage()
    {
        $productImage = $this->createProductImage();

        $updated = $this->repo->update($productImage->id, [
            'src' => "productImage.jpg"
        ]);

        $this->assertTrue($updated, 'ProductImage did NOT update');
        $this->assertDatabaseHas('product_images', ['src' => 'productImage.jpg']);
    }

    /** @test */
    public function itRemovesOldImageFromDiskWhenUpdatingImage()
    {
        $productImage = $this->createProductImage();
        $oldFile = $productImage->src;

        $newImage = UploadedFile::fake()->image('product.jpg', 600, 600);
        $newFile = $this->storeFile($newImage);

        $this->repo->update($productImage->id, [
            'src' => $newFile
        ]);

        $oldFileExists = $this->filesystem->disk('public')->exists($oldFile);

        $this->assertFalse($oldFileExists, 'ProductImage old file STILL exists');
    }

    /** @test */
    public function itFailsToUpdateWhenProductImageIdIsInvalid()
    {
        $updated = $this->repo->update(5, [
            'src' => 'productImage.jpg'
        ]);

        $this->assertFalse($updated, 'ProductImage DID update');
        $this->assertDatabaseMissing('product_images', ['src' => 'productImage.jpg']);
    }

    /** @test */
    public function itCanDeleteAProductImage()
    {
        $productImage = $this->createProductImage();
        $deleted = $this->repo->delete($productImage->id);

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('product_images', ['src' => $productImage->src]);
    }

    /** @test */
    public function itRemovesImageFromDiskWhenDeletingAProductImage()
    {
        $productImage = $this->createProductImage();
        $this->repo->delete($productImage->id);

        $exists = $this->filesystem->disk('public')->exists($productImage->src);
        $this->assertFalse($exists, 'The product image still exists');
    }

    /** @test */
    public function itCanFailDeletingAProductImage()
    {
        $this->assertFalse($this->repo->delete(5), 'ProductImage DID delete');
    }

    /** @test */
    public function itBelongsToAProduct()
    {
        $productImage = $this->createProductImage();

        $this->assertNotNull($productImage->product);
    }
}

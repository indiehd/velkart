<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use Illuminate\Contracts\Filesystem\Factory as FilesystemContract;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use IndieHD\Velkart\Contracts\ProductImageRepositoryContract;
use IndieHD\Velkart\Traits\UploadsFiles;

class ProductImageTest extends RepositoryTestCase
{
    use UploadsFiles;

    protected $filesystem;

    public function setUp(): void
    {
        parent::setUp();

        $this->repo = resolve(ProductImageRepositoryContract::class);
        $this->filesystem = resolve(FilesystemContract::class);
    }

    /** @test */
    public function itCanSaveImageToDiskDuringCreation()
    {
        $productImage = $this->create();

        $exists = $this->filesystem->disk('public')->exists($productImage->path);
        $this->assertTrue($exists, 'The product image does NOT exist');
    }

    /** @test */
    public function itThrowsAQueryExceptionWhenGivenAnInvalidProductId()
    {
        $this->expectException(QueryException::class);

        $this->create([
            'product_id' => 5,
            'src' => 'somerandomstring'
        ]);
    }

    /** @test */
    public function itCanUpdate()
    {
        $productImage = $this->create();

        $updated = $this->getRepository()->update($productImage->id, [
            'disk' => 'public',
            'path' => 'productImage.jpg',
        ]);

        $this->assertTrue($updated, 'ProductImage did NOT update');
        $this->assertDatabaseHas($this->getRepository()->model()->getTable(), [
            'disk' => 'public',
            'path' => 'productImage.jpg',
        ]);
    }

    /** @test */
    public function itRemovesOldImageFromDiskWhenUpdatingImage()
    {
        $productImage = $this->create();
        $oldFile = $productImage->path;

        $newImage = UploadedFile::fake()->image('product.jpg', 600, 600);
        $newPath = $this->storeFile($newImage);

        $this->getRepository()->update($productImage->id, [
            'path' => $newPath
        ]);

        $oldFileExists = $this->filesystem->disk('public')->exists($oldFile);

        $this->assertFalse($oldFileExists, 'ProductImage old file STILL exists');
    }

    /** @test */
    public function itFailsToUpdateWhenProductImageIdIsInvalid()
    {
        $updated = $this->getRepository()->update(5, [
            'src' => 'productImage.jpg'
        ]);

        $this->assertFalse($updated, 'ProductImage DID update');
        $this->assertDatabaseMissing($this->getRepository()->model()->getTable(), ['src' => 'productImage.jpg']);
    }

    /** @test */
    public function itRemovesImageFromDiskWhenDeletingAProductImage()
    {
        $productImage = $this->create();
        $this->getRepository()->delete($productImage->id);

        $exists = $this->filesystem->disk('public')->exists($productImage->src);
        $this->assertFalse($exists, 'The product image still exists');
    }

    /** @test */
    public function itFailsToDeleteWhenProductImageIdIsInvalid()
    {
        $this->assertFalse($this->getRepository()->delete(5), 'ProductImage DID delete');
    }

    /** @test */
    public function itBelongsToAProduct()
    {
        $productImage = $this->create();

        $this->assertNotNull($productImage->product);
    }
}

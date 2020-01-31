<?php

namespace IndieHD\Velkart\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use IndieHD\Velkart\Models\Eloquent\Cart;

interface CartRepositoryContract
{
    /**
     * Get the underlying model's class name.
     *
     * @return string
     */
    public function modelClass(): string;

    /**
     * Get an instance of the underlying model.
     *
     * @return Model
     */
    public function model(): Model;

    /**
     * Get all the records.
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return iterable
     */
    public function all(string $order = 'id', string $sort = 'desc', array $columns = ['*']): iterable;

    /**
     * Get a record by its ID.
     *
     * @param $id
     * @return Cart
     */
    public function findById($id): Cart;

    /**
     * Get a record by its long-form identifier.
     *
     * @param string $identifier
     * @return Collection
     */
    public function findByIdentifier(string $identifier): Collection;

    /**
     * Create a new record.
     *
     * @param string $identifier
     */
    public function create(string $identifier): void;

    /**
     * Destroy an existing record by its long-form identifier.
     *
     * @param string $identifier
     * @return mixed
     */
    public function delete(string $identifier);
}

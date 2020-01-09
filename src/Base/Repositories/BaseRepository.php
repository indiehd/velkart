<?php

namespace IndieHD\Velkart\Base\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseRepository
{
    abstract public function model(): object;

    abstract public function modelClass(): string;

    /**
     * List all the records
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return iterable
     */
    public function list(string $order = 'id', string $sort = 'desc', array $columns = ['*']): iterable
    {
        return $this->model()->orderBy($order, $sort)->get($columns);
    }

    /**
     * Finds a record by its id
     *
     * @param int $id
     * @return object
     * @throws ModelNotFoundException
     */
    public function findById(int $id): object
    {
        return $this->model()->findOrFail($id);
    }

    /**
     * Create a new record
     *
     * @param array $attributes
     * @return object
     */
    public function create(array $attributes): object
    {
        return $this->model()->create($attributes);
    }

    public function update(int $id, array $attributes): bool
    {
        $model = $this->model()->find($id);
        return $model->update($attributes);
    }

    abstract public function delete(int $id): bool;
}

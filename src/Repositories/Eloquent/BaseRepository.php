<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use IndieHD\Velkart\Traits\ProvidesFactory;

abstract class BaseRepository
{
    use ProvidesFactory;

    /**
     * @return Model
     */
    abstract public function model(): Model;

    /**
     * @return string
     */
    abstract public function modelClass(): string;

    /**
     * List all the records.
     *
     * @param string $order
     * @param string $sort
     * @param array  $columns
     *
     * @return iterable
     */
    public function list(string $order = 'id', string $sort = 'desc', array $columns = ['*']): iterable
    {
        return $this->model()->orderBy($order, $sort)->get($columns);
    }

    /**
     * Finds a record by its id.
     *
     * @param int $id
     *
     * @throws ModelNotFoundException
     *
     * @return object
     */
    public function findById(int $id): object
    {
        return $this->model()->findOrFail($id);
    }

    /**
     * Create a new record.
     *
     * @param array $attributes
     *
     * @return object
     */
    public function create(array $attributes): object
    {
        return $this->model()->create($attributes);
    }

    /**
     * Updates a record.
     *
     * @param int   $id
     * @param array $attributes
     *
     * @return bool
     */
    public function update(int $id, array $attributes): bool
    {
        $model = $this->model()->find($id);

        return $model->update($attributes);
    }

    /**
     * Deletes a record.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            $this->findById($id)->delete();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return true;
    }
}

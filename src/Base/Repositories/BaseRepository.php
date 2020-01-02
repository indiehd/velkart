<?php

namespace IndieHD\Velkart\Base\Repositories;

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

    public function delete(int $id): bool
    {
        $model = $this->model()->find($id);
        return $model->delete();
    }
}

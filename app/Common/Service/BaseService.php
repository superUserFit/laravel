<?php

namespace App\Common\Service;

use App\Common\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;


abstract class BaseService
{
    private BaseRepository $repository;


    public function __construct(BaseRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Create a new record.
     */
    public function create(Model|string $model, array $data)
    {
        if (is_string($model)) {
            $model = new $model();
        }

        return $this->repository->create($model, $data);
    }

    /**
     * Retrieve a record by ID.
     */
    public function findById(string $model, $id)
    {
        return $this->repository->findById($model, $id);
    }

    /**
     * Update a record by ID.
     */
    public function update(Model|string $model, $id, array $data)
    {
        return $this->repository->update($model, $id);
    }

    /**
     * Delete a record by ID.
     */
    public function delete(Model $model)
    {
        return $this->repository->delete($model);
    }


    public function deleteAll($models) {
        return $this->repository->deleteAll($models);
    }
}
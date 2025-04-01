<?php

namespace App\Common\Repository;

use Illuminate\Database\Eloquent\Model;


abstract class BaseRepository {
    public function findById(string $model, $id) {
        return $model::findOrFail($id);
    }


    public function create(Model|string $model, array $data) {
        if(is_string($model)) {
            $model = new $model;
        }

        return $model::create($data);
    }


    public function update(Model $model, array $data) {
        return $model->update($data);
    }


    public function delete(Model $model) {
        return $model->delete();
    }


    public function deleteAll(array $models)
    {
        // If an array of models is passed, delete them in bulk
        return collect($models)->each(fn ($model) => $model->delete());
    }
}
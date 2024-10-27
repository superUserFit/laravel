<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;


class Helpers {
    public static function ErrorException(\Exception $error, int $statusCode) {
        return response()->json([
            'message' => $error->getMessage()
        ], $statusCode);
    }

        /**
     * Loads data into a model.
     *
     * @param Model $Model The model instance.
     * @param array $data The array of data to load into the model.
     * @return Model $Model
     */
    public static function loadData($Model, $data) {
        $fillable = $Model->getFillable();

        foreach($data as $key => $value) {
            if(in_array($key, $fillable)) {
                $Model->$key = $value;
            }
        }

        return $Model;
    }
}
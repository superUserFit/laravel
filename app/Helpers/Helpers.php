<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;


class Helpers {
    public static function ErrorException($message, int $statusCode) {
        $error = '';
        switch($statusCode) {
            case 400:
                $error = 'Bad Request';
                break;
            case 401:
                $error = 'Unauthorized';
                break;
            default:
                $error = 'Internal Error';
        }

        return response()->json([
            'code' => $statusCode,
            'name' => $error,
            'message' => $message
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
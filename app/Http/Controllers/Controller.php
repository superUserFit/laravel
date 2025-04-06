<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function response($data)
    {
        return response()->json($data);
    }
}

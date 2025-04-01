<?php

namespace Routes\Message;

use App\Events\PushMessage;
use App\Http\Controllers\Message\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.my_middleware')->prefix('/message')->group(function() {
    Route::post('/send-message', function(Request $request) {
        event(
            new PushMessage(
                $request->input('username'),
                $request->input('message'),
            )
        );

        return ['success' => true];
    });
});

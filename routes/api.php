<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EventApiController;
use App\Http\Controllers\API\TicketApiController;

Route::middleware('api')->group(function () {
    Route::get('/events', [EventApiController::class, 'index']);
    Route::get('/events/{slug}', [EventApiController::class, 'show']);
    Route::post('/tickets/validate', [TicketApiController::class, 'validate']);
});
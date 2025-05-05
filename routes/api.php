<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\TicketTypeController;
use App\Http\Controllers\API\RegionController;
use App\Http\Controllers\API\ServiceController;

Route::apiResource('services', ServiceController::class);
Route::apiResource('regions', RegionController::class);
Route::apiResource('members', MemberController::class);
Route::apiResource('ticket-types', TicketTypeController::class);



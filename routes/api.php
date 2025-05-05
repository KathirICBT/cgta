<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\TicketTypeController;
use App\Http\Controllers\API\RegionController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\EventCategoryController;
use App\Http\Controllers\API\PackageServiceController;

Route::apiResource('package-services', PackageServiceController::class);
Route::apiResource('event-categories', EventCategoryController::class);
Route::apiResource('packages', PackageController::class);
Route::apiResource('services', ServiceController::class);
Route::apiResource('regions', RegionController::class);
Route::apiResource('members', MemberController::class);
Route::apiResource('ticket-types', TicketTypeController::class);



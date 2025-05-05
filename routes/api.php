<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MemberController;

Route::apiResource('members', MemberController::class);



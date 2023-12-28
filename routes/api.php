<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    StateController,
    CityController,
    IBGEController
};

Route::get('states', [StateController::class, 'index']);
Route::get('state/byName/{name}', [StateController::class, 'byName']);
Route::get('state/byInitials/{initials}', [StateController::class, 'byInitials']);

Route::get('cities/{state_id}', [CityController::class, 'index']);
Route::get('city/byName/{stateId}/{cityName}', [CityController::class, 'byName']);

Route::get('store_states', [IBGEController::class, 'states']);
Route::get('store_cities/{stateInitials}', [IBGEController::class, 'cities']);

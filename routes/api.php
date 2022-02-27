<?php

use App\Http\Controllers\MealsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//...?per_page=5&tags=2&lang=hr&with=ingredients,category,tags&diff_time=1493902343&page=2

Route::get('/test', function(Request $request){
    return $request->tag;
});

Route::get('/meal', [MealsController::class, 'filter_meals']);

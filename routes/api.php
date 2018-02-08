<?php

use Illuminate\Http\Request;
use App\Helper\String_Helper;
use Phpml\Association\Apriori;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/predict/{search}', function ($search){
    $result = String_Helper::Predict_String($search);
    return($result);

});


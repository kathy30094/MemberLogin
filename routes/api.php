<?php

use Illuminate\Http\Request;

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


// Route::group(['middleware' => ['web']], function () {
//     // your routes here
//     Route::resource('member','MemberController');
// });
Route::post('testPost','TestController@testPost');

Route::put('testPut/{id}','TestController@testPut');

Route::get('testGet','TestController@testGet');

Route::delete('testDelete/{id}','TestController@testDelete');

Route::resource('re','TestController');

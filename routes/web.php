<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('survey');
});

Route::get('/survey', function () {
    return view('survey');
});

Route::post('/result', 'SurveyController@result');
Route::get('/about', function() {
    return view('about');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get("/response/{id}", "SurveyController@viewResponse");
    Route::get("/all", "SurveyController@viewAllResponses");
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});

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

Route::get('/',        'SurveyController@survey');
Route::get('/survey',  'SurveyController@survey');
Route::post('/result', 'SurveyController@result');
Route::get('/about',   'SurveyController@about');
Route::get("/byIsp", "SurveyController@viewByIsp");
Route::get("/byIsp/{isp}", "SurveyController@viewByIsp");
Route::get("/all", "SurveyController@viewAllResponses");


Route::group(['middleware' => 'auth'], function () {
    Route::get("/response/{id}", "SurveyController@viewResponse");
    Route::get("/home", "SurveyController@viewAllResponses");

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});

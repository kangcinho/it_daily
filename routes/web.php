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

Route::get('/',function(){
  return redirect('itdaily');
});                 
//Section Unit
Route::get('unit',array(
  'uses' => 'UnitController@showUnit',
));
Route::get('getUnit',array(
  'uses' => 'UnitController@getUnit',
));
Route::post("unit/tambahUnit", array(
  'uses' => 'UnitController@tambahUnit',
));
Route::post("unit/{slug}/editUnit", array(
  'uses' => 'UnitController@editUnit',
));
Route::get('unit/{slug}/deleteUnit', array(
  'uses' => 'UnitController@deleteUnit',
));
//Akhir Section Unit


//Section IT Daily
Route::get('itdaily',array(
  'uses' => 'ITController@showITdaily',
));
Route::get('getITdaily',array(
  'uses' => 'ITController@getITdaily',
));
Route::post("itdaily/tambahITdaily", array(
  'uses' => 'ITController@tambahITdaily',
));
Route::post("itdaily/{slug}/editITdaily", array(
  'uses' => 'ITController@editITdaily',
));
Route::get('itdaily/{slug}/deleteITdaily', array(
  'uses' => 'ITController@deleteITdaily',
));
Route::get('itdaily/exportToExcel/{search}', array(
  'uses' => 'ITController@exportToExcel'
));
Route::get('itdaily/exportToPdf/{search}',array(
  'uses' => 'ITController@exportToPdf'
));
//Akhir section IT Daily

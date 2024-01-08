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
    return view('welcome');
});

Route::get('/main/import', 'Import\ImportController@index');
Route::get('/main/import/list-data-dtl', 'Import\ImportController@list_data_dtl')->name('import.data.dtl');
Route::get('/main/import/list-data-hdr', 'Import\ImportController@list_data_hdr')->name('import.data.hdr');
Route::get('/main/import/store','Import\ImportController@store')->name('import.store');
Route::post('/main/import/import-file', 'Import\ImportController@importFile')->name('import.absensi');

Route::prefix('v1')->group(function () {
    Route::get('data', 'Import\ImportController@get_data');
    Route::post('/api/register', 'AuthController@register');
    Route::post('/api/me', 'AuthController@me');
});
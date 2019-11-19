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

Route::get('formDatosConferencia', 'FormController@mostrarFormDatosConferencia');

Route::get('formLugaresSugeridos', 'FormController@mostrarFormLugaresSugeridos');

Route::get('formEstadosVideoconferencia', 'FormController@mostrarFormEstadosVideconferencias');

Route::post('enviarForm', 'FormController@enviarForm');

Route::post('enviarFormLugaresSugeridos', 'FormController@enviarFormLugaresSugeridos');
Route::post('enviarFormEstadosVideoconferencia', 'FormController@enviarFormEstadosVideoconferencia');


Route::prefix('api')->group(function () {
    Route::get('participantes', 'ApiController@getParticipantes')->middleware('cors');
    Route::post('videoconferencia', 'ApiController@guardarVideoConferencia');
    Route::post('estadosVideoconferencia', 'ApiController@guardarEstadosVideoconferencia');
    Route::get('cantidadEstados', 'ApiController@getCantidadEstados')->middleware('cors');
});

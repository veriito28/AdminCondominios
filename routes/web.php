<?php

use Illuminate\Http\Request;
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


Route::name('mostrarLogin')->get('login','InvitadoCtrl@mostrarLogin');
Route::name('login')->post('login','InvitadoCtrl@login');

Route::name('logout')->get('logout','InvitadoCtrl@logout');
Route::name('principal')->get('/','InvitadoCtrl@mostrarLogin');

Route::group(['prefix' => 'usuario','middleware' => ['auth']], function () {
	Route::name('bienvenido')->get('/', 'CondominioCtrl@bienvenido');
	Route::name('mostrarConceptos')->get('/conceptos', 'ConceptoCtrl@mostrar');
	Route::name('guardarConcepto')->post('/conceptos', 'ConceptoCtrl@guardar');
	Route::name('eliminarConcepto')->delete('conceptos/{id}','ConceptoCtrl@eliminar');
	

	Route::name('editarConcepto')->get('concepto/{id}/editar','ConceptoCtrl@editar');
	Route::name('actualizarConcepto')->put('concepto/{id}','ConceptoCtrl@actualizar');

	Route::name('editarConcepto')->post('/conceptos', 'ConceptoCtrl@guardar');
	Route::name('guardarConcepto')->post('/conceptos', 'ConceptoCtrl@guardar');

	Route::name('seleccionarCondominio')->get('/condominios/seleccionar/{id_condominio}', 'CondominioCtrl@seleccionarCondominio');

	Route::name('guardarCondominio')->post('condominios','CondominioCtrl@guardar');
	Route::group(['prefix' => 'condominio'], function () {
		Route::name('mostrarCondominio')->get('/{id}/show','CondominioCtrl@mostrar');
		Route::name('editarCondominio')->get('/{id}/edit','CondominioCtrl@editar');
		Route::name('eliminarCondominio')->delete('/delete','CondominioCtrl@eliminar');
		Route::name('guardarCasa')->post('casas','CasaCtrl@guardar');
		Route::name('eliminarCasa')->delete('casas/{id}','CasaCtrl@eliminar');
		
		Route::name('editarCasa')->get('casas/{id}/editar','CasaCtrl@editar');
		Route::name('actualizarCasa')->put('casas/{id}','CasaCtrl@actualizar');
		
		Route::name('pagos')->get('pagos','IngresosCtrl@pagos');
		Route::name('guardarPagos')->post('pagos','IngresosCtrl@guardarPagos');

		Route::name('gastosOrdinarios')->get('gastos/ordinarios','GastoCtrl@ordinarios');
		Route::name('guardarGastosOrdinarios')->post('gastos/ordinarios','GastoCtrl@guardarOrdinarios');
	});
});
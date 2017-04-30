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
		
		Route::name('pagos')->get('ingresos/pagos/{tipo?}/{anio?}','IngresosCtrl@pagos');
		Route::name('guardarPagos')->post('ingresos/pagos/{tipo}/{anio?}','IngresosCtrl@guardarPagos');

		Route::name('ingresosExtraudinarios')->get('ingresos/extraudinarios/{anio?}','IngresosCtrl@ingresosExtraudinarios');
		Route::name('guardarIngresoExtraudinario')->post('ingresos/extraudinarios/{anio?}','IngresosCtrl@guardarIngresoExtraudinario');
		Route::name('eliminarIngresoExtraudinario')->delete('ingresos/extraudinarios/{anio}/{id}','IngresosCtrl@eliminarIngresoExtraudinario');
		Route::name('editarIngresoExtraudinario')->get('ingresos/extraudinarios/{anio}/{id}/editar','IngresosCtrl@editarIngresoExtraudinario');
		Route::name('actualizarIngresoExtraudinario')->put('ingresos/extraudinarios/{anio}/{id}','IngresosCtrl@actualizarIngresoExtraudinario');

		Route::name('gastosOrdinarios')->get('gastos/ordinarios/{anio?}','GastoCtrl@ordinarios');
		Route::name('guardarGastosOrdinarios')->post('gastos/ordinarios/{anio?}','GastoCtrl@guardarOrdinarios');

		Route::name('gastosExtraudinarios')->get('gastos/extraudinarios/{anio?}','GastoCtrl@gastosExtraudinarios');
		Route::name('guardarGastoExtraudinario')->post('gastos/extraudinarios/{anio?}','GastoCtrl@guardarGastoExtraudinario');
		Route::name('eliminarGastoExtraudinario')->delete('gastos/extraudinarios/{anio}/{id}','GastoCtrl@eliminarGastoExtraudinario');
		Route::name('editarGastoExtraudinario')->get('gastos/extraudinarios/{anio}/{id}/editar','GastoCtrl@editarGastoExtraudinario');
		Route::name('actualizarGastoExtraudinario')->put('gastos/extraudinarios/{anio}/{id}','GastoCtrl@actualizarGastoExtraudinario');
	
		Route::name('adeudosMensuales')->get('adeudos/mensualidades/{anio?}','AdeudoCtrl@mensualidades');
		Route::name('guardarAdeudosMensuales')->post('adeudos/mensualidades/{anio?}','AdeudoCtrl@guadarMensualidades');
	
		Route::name('otrosAdeudos')->get('adeudos/otros/{anio?}','AdeudoCtrl@otrosAdeudos');
		Route::name('guardarOtroAdeudo')->post('adeudos/otros/{anio?}','AdeudoCtrl@guardarOtroAdeudo');
		Route::name('eliminarOtroAdeudo')->delete('adeudos/otros/{anio}/{id}','AdeudoCtrl@eliminarOtroAdeudo');
		Route::name('editarOtroAdeudo')->get('adeudos/otros/{anio}/{id}/editar','AdeudoCtrl@editarOtroAdeudo');
		Route::name('actualizarOtroAdeudo')->put('adeudos/otros/{anio}/{id}','AdeudoCtrl@actualizarOtroAdeudo');
	
		


	});
});
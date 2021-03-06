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

Route::name('calando')->get('calando',function (){
	dd(\App\Adeudo::casaHasta(1,\Date::now())->get());
});



Route::name('mostrarLogin')->get('login','InvitadoCtrl@mostrarLogin');
Route::name('login')->post('login','InvitadoCtrl@login');

Route::name('logout')->get('logout','InvitadoCtrl@logout');
Route::name('principal')->get('/','InvitadoCtrl@mostrarLogin');

Route::group(['prefix' => 'usuario','middleware' => ['auth']], function () {

	Route::name('cambiarContrasenia')->put('contrasenia', 'InvitadoCtrl@cambiarContrasenia');

	Route::name('bienvenido')->get('/', 'CondominioCtrl@bienvenido');

	Route::name('mostrarConceptos')->get('/conceptos', 'ConceptoCtrl@mostrar');
	Route::name('guardarConcepto')->post('/conceptos', 'ConceptoCtrl@guardar');
	Route::name('eliminarConcepto')->delete('conceptos/{id}','ConceptoCtrl@eliminar');
	Route::name('editarConcepto')->get('concepto/{id}/editar','ConceptoCtrl@editar');
	Route::name('actualizarConcepto')->put('concepto/{id}','ConceptoCtrl@actualizar');
	

	Route::name('mostrarCuentas')->get('/cuentas', 'CuentaCtrl@mostrar');
	Route::name('guardarCuenta')->post('/cuentas', 'CuentaCtrl@guardar');
	Route::name('eliminarCuenta')->delete('cuentas/{id}','CuentaCtrl@eliminar');
	Route::name('editarCuenta')->get('cuenta/{id}/editar','CuentaCtrl@editar');
	Route::name('actualizarCuenta')->put('cuenta/{id}','CuentaCtrl@actualizar');
	

	Route::name('seleccionarCondominio')->get('/condominios/seleccionar/{id_condominio}', 'CondominioCtrl@seleccionarCondominio');

	Route::name('guardarCondominio')->post('condominios','CondominioCtrl@guardar');
	Route::group(['prefix' => 'condominio'], function () {

		Route::name('mostrarConceptosGastos')->get('gastos/conceptos', 'ConceptoGastoCtrl@mostrar');
		Route::name('guardarConceptoGasto')->post('gastos/conceptos', 'ConceptoGastoCtrl@guardar');
		Route::name('eliminarConceptoGasto')->delete('gastos/conceptos/{id}','ConceptoGastoCtrl@eliminar');
		Route::name('editarConceptoGasto')->get('gastos/concepto/{id}/editar','ConceptoGastoCtrl@editar');
		Route::name('actualizarConceptoGasto')->put('gastos/concepto/{id}','ConceptoGastoCtrl@actualizar');


		Route::name('mostrarConceptosAdeudos')->get('/adeudos/conceptos', 'ConceptoAdeudoCtrl@mostrar');
		Route::name('guardarConceptoAdeudo')->post('/adeudos/conceptos', 'ConceptoAdeudoCtrl@guardar');
		Route::name('eliminarConceptoAdeudo')->delete('/adeudos/conceptos/{id}','ConceptoAdeudoCtrl@eliminar');
		Route::name('editarConceptoAdeudo')->get('/adeudos/concepto/{id}/editar','ConceptoAdeudoCtrl@editar');
		Route::name('actualizarConceptoAdeudo')->put('/adeudos/concepto/{id}','ConceptoAdeudoCtrl@actualizar');

		Route::name('mostrarCondominio')->get('/{id}/show','CondominioCtrl@mostrar');
		Route::name('editarCondominio')->get('/{id}/edit','CondominioCtrl@editar');
		Route::name('eliminarCondominio')->delete('/delete/{id}','CondominioCtrl@eliminar');
		Route::name('cargarCasas')->post('casas/excel','CasaCtrl@cargarExcel');
		Route::name('guardarCasas')->post('casas/excel/save','CasaCtrl@guardarExcel');
		Route::name('exportarCasas')->get('casas/excel/export','CasaCtrl@exportarExcel');
		
		Route::name('guardarCasa')->post('casas','CasaCtrl@guardar');
		Route::name('eliminarCasa')->delete('casas/{id}','CasaCtrl@eliminar');
		
		Route::name('editarCasa')->get('casas/{id}/editar','CasaCtrl@editar');
		Route::name('actualizarCasa')->put('casas/{id}','CasaCtrl@actualizar');
		
		Route::name('pagosMensuales')->get('ingresos/pagosMensuales/{mes?}/{anio?}','IngresosCtrl@pagosMensuales');
		Route::name('guardarPagosMensuales')->post('ingresos/pagosMensuales/{mes}/{anio?}','IngresosCtrl@guardarPagosMensuales');

		Route::name('pagos')->get('ingresos/pagos/{tipo?}/{anio?}','IngresosCtrl@pagos');
		Route::name('guardarPagos')->post('ingresos/pagos/{tipo}/{anio?}','IngresosCtrl@guardarPagos');

		Route::name('otrosPagos')->get('ingresos/otros/{anio?}','IngresosCtrl@otrosPagos');
		Route::name('pagosDeAduedo')->get('ingresos/adeudos/{id}/{anio?}','IngresosCtrl@pagosDeAduedo');
		Route::name('guardarOtrosPagos')->post('ingresos/otros/{anio?}','IngresosCtrl@guardarOtrosPagos');


		Route::name('ingresosExtraordinarios')->get('ingresos/extraordinarios/{anio?}','IngresosCtrl@ingresosExtraordinarios');
		Route::name('guardarIngresoExtraordinario')->post('ingresos/extraordinarios/{anio?}','IngresosCtrl@guardarIngresoExtraordinario');
		Route::name('eliminarIngresoExtraordinario')->delete('ingresos/extraordinarios/{id}','IngresosCtrl@eliminarIngresoExtraordinario');
		Route::name('editarIngresoExtraordinario')->get('ingresos/extraordinarios/{anio}/{id}/editar','IngresosCtrl@editarIngresoExtraordinario');
		Route::name('actualizarIngresoExtraordinario')->put('ingresos/extraordinarios/{anio}/{id}','IngresosCtrl@actualizarIngresoExtraordinario');

		Route::name('gastosOrdinarios')->get('gastos/ordinarios/{anio?}','GastoCtrl@ordinarios');
		Route::name('guardarGastosOrdinarios')->post('gastos/ordinarios/{anio?}','GastoCtrl@guardarOrdinarios');

		Route::name('gastosExtraordinarios')->get('gastos/extraordinarios/{anio?}','GastoCtrl@gastosExtraordinarios');
		Route::name('guardarGastoExtraordinario')->post('gastos/extraordinarios/{anio?}','GastoCtrl@guardarGastoExtraordinario');
		Route::name('eliminarGastoExtraordinario')->delete('gastos/extraordinarios/{id}','GastoCtrl@eliminarGastoExtraordinario');
		Route::name('editarGastoExtraordinario')->get('gastos/extraordinarios/{anio}/{id}/editar','GastoCtrl@editarGastoExtraordinario');
		Route::name('actualizarGastoExtraordinario')->put('gastos/extraordinarios/{anio}/{id}','GastoCtrl@actualizarGastoExtraordinario');
	
		Route::name('adeudosMensuales')->get('adeudos/mensualidades/{anio?}','AdeudoCtrl@mensualidades');
		Route::name('guardarAdeudosMensuales')->post('adeudos/mensualidades/{anio?}','AdeudoCtrl@guadarMensualidades');
	
		Route::name('otrosAdeudos')->get('adeudos/otros/{anio?}','AdeudoCtrl@otrosAdeudos');
		Route::name('guardarOtroAdeudo')->post('adeudos/otros/{anio?}','AdeudoCtrl@guardarOtroAdeudo');
		Route::name('eliminarOtroAdeudo')->delete('adeudos/otros/{id}','AdeudoCtrl@eliminarOtroAdeudo');
		Route::name('editarOtroAdeudo')->get('adeudos/otros/{anio}/{id}/editar','AdeudoCtrl@editarOtroAdeudo');
		Route::name('actualizarOtroAdeudo')->put('adeudos/otros/{anio}/{id}','AdeudoCtrl@actualizarOtroAdeudo');
	
		Route::name('mostrarReporteGeneral')->get('reportes/general/mostrar/{anio?}/{mes?}','ReporteCtrl@mostrarReporteGeneral');
		Route::name('reporteGeneral')->match(['get', 'post'],'reportes/general/{anio?}/{mes?}','ReporteCtrl@general');
		Route::name('reportePersonal')->match(['get', 'post'],'reportes/personal/{casa_id}/{anio?}/{mes?}','ReporteCtrl@personal');
		Route::name('mostrarReportePersonal')->match(['get', 'post'],'reportes/personal/mostrar/{casa_id}/{anio?}/{mes?}','ReporteCtrl@mostrarReportePersonal');

		Route::name('mostrarReporteIngresos')->get('reportes/ingresos/mostrar/{anio?}/{mes?}','ReporteCtrl@mostrarReporteIngresos');
		Route::name('reporteIngresos')->match(['get', 'post'],'reportes/ingresos/{anio?}/{mes?}','ReporteCtrl@ingresos');

	});
});
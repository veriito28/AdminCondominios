<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Date;
use App\Pago;
use App\Gasto;
use App\Condominio;
use App\Adeudo;

class ReporteCtrl extends Controller
{
	function __construct(Condominio $condominio,Pago $pago,Adeudo $adeudo,Gasto $gasto)
	{
		$this->condominio = $condominio;
		$this->pago = $pago;
		$this->adeudo = $adeudo;
		$this->gasto = $gasto;
	}
	public function general($anio = null,$mes = null,Request $request)
	{
        
        $fecha = Date::now(); 
        if ($anio || $request->has('anio')) {
            $fecha->year = $request->anio?$request->anio:$anio;
        }
        if ($mes || $request->has('mes')) {
            $fecha->month = $request->mes?$request->mes:$mes; 
        }

        if ($request->has('encabezado')) {
            $encabezado = $request->encabezado; 
        }
        if ($request->has('mensaje')) {
            $mensaje =$request->mensaje; 
        }

        $presupuesto_atrazadas = 0;
        $diferencia = 0;
        $condominio = session()->get('condominio');
		if ($request->has('presupuesto_atrazadas')) {
            $presupuesto_atrazadas = $request->presupuesto_atrazadas;
        }
        if ($request->has('diferencia')) {
            $diferencia = $request->diferencia;
        }else{
            $condominio = $this->condominio->find($condominio->id);
            $adeudoMensual = $this->adeudo->mensualidades()->condominioId($condominio->id)->fecha($fecha)->first();
            $pagosMensuales = $this->pago->mensuales()->normales()->condominioId($condominio->id)->fecha($fecha)->get();
            $sumaPagosNormales = round($pagosMensuales->sum('cantidad'),2);
            $sumaAdeudo = round((isset($adeudoMensual)?$adeudoMensual->cantidad:0) * $condominio->casas->count(),2);
            $diferencia = $sumaPagosNormales - $sumaAdeudo;
        }
    	return view('reportes.general',compact('condominio','fecha','encabezado','mensaje','presupuesto_atrazadas','diferencia'));
	}
    public function mostrarReporteGeneral($anio = null,$mes = null,Request $request)
    {
	    $fecha = Date::now(); 
    	if ($anio || $request->has('anio')) {
	    	$fecha->year = $request->anio?$request->anio:$anio;
    	}
    	if ($mes || $request->has('mes')) {
	    	$fecha->month = $request->mes?$request->mes:$mes; 
    	}
    	if ($request->has('encabezado')) {
    		$encabezado =$request->encabezado; 
    	}
    	if ($request->has('mensaje')) {
    		$mensaje =$request->mensaje; 
    	}
        $presupuesto_atrazadas = 0;
        $diferencia = 0;
        if ($request->has('presupuesto_atrazadas')) {
            $presupuesto_atrazadas = $request->presupuesto_atrazadas;
        }
        if ($request->has('diferencia')) {
            $diferencia = $request->diferencia;
        }
    	// Ingresos Ordinarios
    	$condominio = session()->get('condominio');
    	$condominio = $this->condominio->find($condominio->id);
    	$pagosMensuales = $this->pago->mensuales()->normales()->condominioId($condominio->id)->fecha($fecha)->get();
    	$pagosAtrasados = $this->pago->mensuales()->atrasadas()->condominioId($condominio->id)->fecha($fecha)->get();
    	$pagosAdelantados = $this->pago->mensuales()->adelantadas()->condominioId($condominio->id)->fecha($fecha)->get();
		$adeudoMensual = $this->adeudo->mensualidades()->condominioId($condominio->id)->fecha($fecha)->first();
		// Gastos Ordinarios
		$gastosOrdinarios = $this->gasto->ordinarios()->condominioId($condominio->id)->fecha($fecha)->get();

    	// Ingresos Extraordinarios
    	$otrosPagos = $this->pago->otros()->condominioId($condominio->id)->fecha($fecha)->get();
		// Gastos Extraordinarios
		$gastosExtraordinarios = $this->gasto->extraordinarios()->condominioId($condominio->id)->fecha($fecha)->get();

		// $gastosOrdinarios = $this->gasto->ordinarios()->condominioId($condominio->id)->fecha($fecha)->get();
		
		$pdf = \PDF::loadView('reportes.pdf.general',compact('condominio','fecha','pagosMensuales','pagosAtrasados','pagosAdelantados','adeudoMensual','gastosOrdinarios','otrosPagos','gastosExtraordinarios','encabezado','mensaje','presupuesto_atrazadas','diferencia'));
		return $pdf->stream('reporteGeneral.pdf');
	}
    public function ingresos($anio = null,$mes = null,Request $request)
    {
        $fecha = Date::now(); 
        if ($anio || $request->has('anio')) {
            $fecha->year = $request->anio?$request->anio:$anio;
        }
        if ($mes || $request->has('mes')) {
            $fecha->month = $request->mes?$request->mes:$mes; 
        }

        if ($request->has('encabezado')) {
            $encabezado = $request->encabezado; 
        }
        if ($request->has('mensaje')) {
            $mensaje =$request->mensaje; 
        }

        $condominio = session()->get('condominio');
        $condominio = $this->condominio->find($condominio->id);
        return view('reportes.ingresos',compact('condominio','fecha','encabezado','mensaje'));

    }
    public function mostrarReporteIngresos($anio = null,$mes = null,Request $request)
    {

        $fecha = Date::now(); 
        if ($anio || $request->has('anio')) {
            $fecha->year = $request->anio?$request->anio:$anio;
        }
        if ($mes || $request->has('mes')) {
            $fecha->month = $request->mes?$request->mes:$mes; 
        }
        if ($request->has('encabezado')) {
            $encabezado =$request->encabezado; 
        }
        if ($request->has('mensaje')) {
            $mensaje =$request->mensaje; 
        }
        $condominio = session()->get('condominio');
        $condominio = $this->condominio->find($condominio->id);
        // $adeudosMensuales = $this->adeudo->mensualidades()->condominioId($condominio->id)->hasta($fecha)->get();
        $pdf = \PDF::loadView('reportes.pdf.ingresos',compact('condominio','fecha','encabezado'));
        return $pdf->stream('reporteIngresos.pdf');
    }    
}

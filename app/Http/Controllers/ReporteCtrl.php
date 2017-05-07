<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Date;
use App\Pago;
use App\Gasto;
use App\Condominio;
use App\Casa;
use App\Adeudo;
use App\Cuenta;
use App\Reporte;
use Auth;
class ReporteCtrl extends Controller
{
	function __construct(Condominio $condominio,Casa $casa,Reporte $reporte,Cuenta $cuenta,Pago $pago,Adeudo $adeudo,Gasto $gasto)
	{
        $this->condominio = $condominio;
        $this->casa = $casa;
        $this->cuenta = $cuenta;
		$this->reporte = $reporte;
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
        if ($request->has('diferencia')) {
            $diferencia = $request->diferencia;
        }
        if ($request->has('presupuesto_atrazadas')) {
            $presupuesto_atrazadas = $request->presupuesto_atrazadas;
        }
        $reporte = $this->reporte->condominioId( $condominio->id)->fecha($fecha)->first();
        if ($request->has('guardar')) {
            if (!$reporte) {
                $fecha->day = 1;
                $reporte = $this->reporte->updateOrCreate([
                    'condominio_id' => $condominio->id,
                    'fecha'         => $fecha->toDateString() 
                ]);
            }            
            $reporte->fill([
                'encabezado'             => $encabezado,
                'mensaje'                => $mensaje,
                'diferencia_autorizada'  => $diferencia,
                'prosupuestado_atrazado' => $presupuesto_atrazadas
            ]);
            $reporte->save();
        }
        if ($reporte) {
            $encabezado = $reporte->encabezado;
            $mensaje = $reporte->mensaje;
            $diferencia = $reporte->diferencia_autorizada;
            $presupuesto_atrazadas = $reporte->prosupuestado_atrazado;
        }else{
            if (!$request->has('diferencia')) {
                $condominio = $this->condominio->find($condominio->id);
                $adeudoMensual = $this->adeudo->mensualidades()->condominioId($condominio->id)->fecha($fecha)->first();
                $pagosMensuales = $this->pago->mensuales()->normales()->condominioId($condominio->id)->fecha($fecha)->get();
                $sumaPagosNormales = round($pagosMensuales->sum('cantidad'),2);
                $sumaAdeudo = round((isset($adeudoMensual)?$adeudoMensual->cantidad:0) * $condominio->casas->count(),2);
                $diferencia = $sumaPagosNormales - $sumaAdeudo;
            }
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
    public function personal($casa_id = null,$anio = null,$mes = null,Request $request)
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
            }else{
                $mensaje = "*El pago de este aviso no lo exenta del pago de adeudos anteriores o no incluídos.";
            }
            if ($request->has('cuentas_seleccionadas')) {
                $cuentas_seleccionadas = $request->cuentas_seleccionadas; 
            }
            $condominio = session()->get('condominio');
            $condominio = $this->condominio->find($condominio->id);
            $casa = $this->casa->find($casa_id);
            $cuentas = $this->cuenta->usuarioId(Auth::user()->id)->get();
            return view('reportes.personal',compact('condominio','cuentas_seleccionadas','casa','cuentas','fecha','encabezado','mensaje'));
    }
      public function mostrarReportePersonal($casa_id = null, $anio = null,$mes = null,Request $request)
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
            $mensaje = $request->mensaje; 
        }else{
            $mensaje = "*El pago de este aviso no lo exenta del pago de adeudos anteriores o no incluídos.";
        }
        if ($request->has('cuentas_seleccionadas')) {
            $cuentas_seleccionadas = $this->cuenta->usuarioId(Auth::user()->id)
            ->whereIn('id',explode(",", $request->cuentas_seleccionadas))
            ->get();
        }
        $condominio = session()->get('condominio');
        $condominio = $this->condominio->find($condominio->id);
        $casa = $this->casa->find($casa_id);
           
        $pdf = \PDF::loadView('reportes.pdf.personal',compact('condominio','casa','fecha','encabezado','mensaje','cuentas_seleccionadas'));
        return $pdf->stream('reportePersonal.pdf');
    }

}

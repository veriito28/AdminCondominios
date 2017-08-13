<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PagoStoreRequest;
use App\Http\Requests\IngresoExtraStoreRequest;
use App\Http\Requests\IngresoExtraUpdateRequest;
use App\Http\Requests\PasswordConfirmationRequest;
use App\Pago;
use App\Condominio;
use Carbon\Carbon;
use App\Adeudo;
use App\Concepto;

class IngresosCtrl extends Controller
{
	function __construct(Pago $pago,Condominio $condominio,Adeudo $adeudo,Concepto $concepto)
	{
        $this->pago       = $pago;
        $this->condominio = $condominio;
        $this->adeudo     = $adeudo;
        $this->concepto   = $concepto;
    }
    public function pagos($tipo,$anio = null, Request $request)
    {
    	if (!$anio) {
			$anio = Carbon::now()->year;
    	}
    	$condominio = session()->get('condominio');
    	$condominio = $this->condominio->id($condominio->id)->first();
    	$meses = config('helper.meses');
        $concepto = $this->concepto->slugNombre($tipo)->first();
        $adeudosMensuales = $this->adeudo
                                 ->with('pagos')
                                 ->mensualidades()
                                 ->conceptoId($concepto->id)
                                 ->condominioId($condominio->id)
                                 ->anio($anio)
                                 ->get();
        
        return view('ingresos.pagos',compact('condominio','anio','meses','tipo','adeudosMensuales','concepto'));
    }
    public function guardarPagos($tipo,$anio = null,PagoStoreRequest $request)
    {
    	$index = 1;
        $meses = config('helper.meses');
        $condominio = session()->get('condominio');
        $concepto = $this->concepto->slugNombre($tipo)->first();
    	$adeudosMensuales = $this->adeudo
                                 ->with('pagos')
                                 ->mensualidades()
                                 ->conceptoId($concepto->id)
                                 ->condominioId($condominio->id)
                                 ->anio($anio)
                                 ->get();
        foreach ($request->except(['_token','fecha_pago']) as $key => $valores) {
          	$fecha = Carbon::createFromDate($anio,$meses[$key],1);
    		foreach ($valores as $casa_id => $cantidad) {
    			if (!is_null($cantidad)) {
		    		$adeudoMenusal = $adeudosMensuales->first(function ($adeudo, $key) use($fecha) {
                        return $adeudo->fecha->month == $fecha->month;
                    });
                    if (is_null($adeudoMenusal)) {
                        $adeudoMenusal = $this->adeudo->create([
                                    'tipo'          => 'M',
                                    'condominio_id' => $condominio->id, 
                                    'fecha'         => $fecha->toDateString(), 
                                    'concepto'      => 'mensualidad',
                                    'cantidad'      => 0
                                ]);
                    }
                    $pago = Pago::updateOrCreate([
                                'tipo'          => 'M',
                                'casa_id'       => $casa_id, 
                                'adeudo_id'     => $adeudoMenusal->id, 
                                'condominio_id' => $condominio->id,
                                'fecha'         => $fecha->toDateString(), 
                                'concepto'      => $tipo
                            ],
                            [
                                'fecha_pago' => Carbon::parse($request->fecha_pago)->toDateString(), 
                                'cantidad'   => $cantidad
                            ]);
		    		$index += 1;
    			}
    		}
    	}
    	if ($index > 1) {
	    	return redirect()->back()->with(['message'=>'Pagos Guardados correctamente.','type'=>'success']);
    	}
    	return redirect()->back()->with(['message'=>'Sin pagos para actualizar.','type'=>'success']);
    }
    public function pagosMensuales($mes = '',$anio = '')
    {
        if (!$anio) {
            $anio = Carbon::now()->year;
        }
        if (!$mes) {
            $mesesIndex = config('helper.mesesIndex');
            $mes = $mesesIndex[Carbon::now()->month];
        }
        $condominio = session()->get('condominio');
        $condominio = $this->condominio->id($condominio->id)->first();
        $meses = config('helper.meses');
        $conceptos = $this->concepto->tipoAdeudo()->get();
        
        return view('ingresos.pagosMensuales',compact('condominio','anio','meses','mes','conceptos'));
    }
    public function ingresosExtraordinarios($anio = null)
    {
        if (!$anio) {
            $anio = Carbon::now()->year;
        }
        $condominio = session()->get('condominio');
        $ingresosExtraordinarios = $this->pago->extraordinarios()->condominioId($condominio->id)->anio($anio)->get();
        return view("ingresos.extraordinarios",compact('condominio','anio','ingresosExtraordinarios'));
    }
    public function guardarIngresoExtraordinario($anio = null,IngresoExtraStoreRequest $request)
    {
        $datos = $request->except('_token');
        $datos['tipo'] = 'E';
        if ($this->pago->create($datos)) {
            return redirect()->back()->with(['message'=>'Ingreso Extraordinario guardados correctamente.','type'=>'success']);
        }
        return redirect()->back()->with(['message'=>'Ingreso Extraordinario no registrado.','type'=>'error']);
    }
    public function eliminarIngresoExtraordinario($id,PasswordConfirmationRequest $request)
    {
        $ingresoExtraordinario = $this->pago->find($id);
        if ($ingresoExtraordinario->delete()) {
            return redirect()->back()->with(['message'=>'Ingreso Extraordinario eliminado.','type'=>'success']);
        }
        return redirect()->back()->with(['message'=>'Ingreso Extraordinario no eliminado.','type'=>'error']);
    }
    public function editarIngresoExtraordinario($anio,$id)
    {
        $ingresoExtraordinario = $this->pago->find($id);
        return view("ingresos.extraordinarios.edit",compact('condominio','anio','ingresoExtraordinario'));
    }
    public function actualizarIngresoExtraordinario($anio,$id,IngresoExtraUpdateRequest $request)
    {
        $ingresoExtraordinario = $this->pago->find($id);
        $ingresoExtraordinario->fill($request->only(['fecha','cantidad','concepto']));
        $ingresoExtraordinario->save();
        return redirect()->route('ingresosExtraordinarios',compact('anio'))->with(['message'=>'Ingreso Extraordinario Actualizado.','type'=>'success']);

    }
    public function otrosPagos($anio='',Request $request)
    {
        if (!$anio) {
            $anio = Carbon::now()->year;
        }
        $condominio = session()->get('condominio');
        $otrosAdeudos = $this->adeudo
           ->otros()
           ->condominioId($condominio->id)
           ->anio($anio)
           ->with('pagos')
           ->get();

        return view("ingresos.otros",compact('condominio','anio','otrosAdeudos','adeudo_seleccionado'));
    }
    public function guardarOtrosPagos($anio='',Request $request)
    {
        $index = 1;
        $meses = config('helper.meses');
        $condominio = session()->get('condominio');
        foreach ($request->except(['_token']) as $key => $valores) {
        $fecha = Carbon::createFromDate($anio,$meses[$key],1);
            foreach ($valores as $adeudo_id => $cantidad) {
                if (!is_null($cantidad)) {
                    $otroAdeudo = $this->adeudo->find($adeudo_id);
                    $pago = Pago::updateOrCreate([
                                'tipo'          => 'O',
                                'condominio_id' => $condominio->id,
                                'casa_id'       => $otroAdeudo->casa_id,
                                'adeudo_id'     => $adeudo_id, 
                                'fecha'         => $fecha->toDateString(), 
                            ],
                            [
                                'cantidad' => $cantidad
                            ]);
                    $index += 1;
                }
            }
        }
        if ($index > 1) {
            return redirect()->back()->with(['message'=>'Pagos Guardados correctamente.','type'=>'success']);
        }
        return redirect()->back()->with(['message'=>'Sin pagos para actualizar.','type'=>'success']);  
    }
    public function pagosDeAduedo($id, $anio = null)
    {
        if (!$anio) {
            $anio = Carbon::now()->year;
        }
        $condominio = session()->get('condominio');
        $otroAdeudo = $this->adeudo
           ->with('pagos','casa')
           ->find($id);
        return view("ingresos.otros.mensualidades",compact('condominio','anio','otroAdeudo'));
    }
}

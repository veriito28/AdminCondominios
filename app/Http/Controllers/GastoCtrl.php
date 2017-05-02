<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GastoStoreRequest;
use App\Http\Requests\GastoExtraStoreRequest;
use App\Http\Requests\GastoExtraUpdateRequest;
use App\Gasto;
use App\Concepto;
use Carbon\Carbon;
class GastoCtrl extends Controller
{
 
    function __construct (Gasto $gasto,Concepto $concepto)
    {
    	$this->gasto = $gasto;
    	$this->concepto = $concepto;
    }
    public function ordinarios ($anio = null, Request $request)
    {
    	if (!$anio) {
			$anio = Carbon::now()->year;
    	}
    	$condominio = session()->get('condominio');
    	$conceptos = $this->concepto->get();
        $meses = config('helper.meses');
    	return view('gastos.ordinarios',compact('condominio','anio','conceptos','meses'));
    }
    public function guardarOrdinarios($anio = null,GastoStoreRequest $request)
    {
    	if (!$anio) {
			$anio = Carbon::now()->year;
    	}
        $meses = config('helper.meses');
    	$index = 1;
    	foreach ($request->except(['_token','condominio_id']) as $key => $valores) {
    		$fecha = Carbon::createFromDate($anio,$meses[$key],1);
    		foreach ($valores as $concepto => $cantidad) {
    			if ($cantidad) {
		    		$this->gasto->updateOrCreate([
									'tipo' => 'O',
									'condominio_id' => $request->condominio_id, 
									'fecha' => $fecha->toDateString(), 
									'concepto_id' => $concepto
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
	public function gastosExtraordinarios($anio = null)
    {
        if (!$anio) {
            $anio = Carbon::now()->year;
        }
        $condominio = session()->get('condominio');
        $gastosExtraordinarios = $this->gasto->extraordinarios()->condominioId($condominio->id)->anio($anio)->get();
        return view("gastos.extraordinarios",compact('condominio','anio','gastosExtraordinarios'));
    }
    public function guardarGastoExtraordinario($anio = null,GastoExtraStoreRequest $request)
    {
        $datos = $request->except('_token');
        $datos['tipo'] = 'E';
        if ($this->gasto->create($datos)) {
            return redirect()->back()->with(['message'=>'Gasto Extraordinario guardados correctamente.','type'=>'success']);
        }
        return redirect()->back()->with(['message'=>'Gasto Extraordinario no registrado.','type'=>'error']);
    }
    public function eliminarGastoExtraordinario($anio,$id)
    {
        $gastoExtraordinario = $this->gasto->find($id);
        if ($gastoExtraordinario->delete()) {
            return redirect()->back()->with(['message'=>'Ingreso Extraordinario eliminado.','type'=>'success']);
        }
        return redirect()->back()->with(['message'=>'Ingreso Extraordinario no eliminado.','type'=>'error']);
    }
    public function editarGastoExtraordinario($anio,$id)
    {
        $gastoExtraordinario = $this->gasto->find($id);
        return view("gastos.extraordinarios.edit",compact('condominio','anio','gastoExtraordinario'));
    }
    public function actualizarGastoExtraordinario($anio,$id,GastoExtraUpdateRequest $request)
    {
        $gastoExtraordinario = $this->gasto->find($id);
        $gastoExtraordinario->fill($request->only(['fecha','cantidad','concepto']));
        $gastoExtraordinario->save();
        return redirect()->route('gastosExtraordinarios',compact('anio'))->with(['message'=>'Ingreso Extraordinario Actualizado.','type'=>'success']);
    }   
}

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
    protected $meses = ["enero" => 1, "febrero" => 2, "marzo" => 3, "abril"  => 4, "mayo"  => 5, "junio" => 6, "julio" => 7, "agosto" => 8, "septiembre" => 9, "octubre" => 10, "noviembre" => 11, "diciembre" => 12];

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
    	$meses = $this->meses;    	
    	return view('gastos.ordinarios',compact('condominio','anio','conceptos','meses'));
    }
    public function guardarOrdinarios($anio = null,GastoStoreRequest $request)
    {
    	if (!$anio) {
			$anio = Carbon::now()->year;
    	}
    	$meses = $this->meses;    	    	
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
	public function gastosExtraudinarios($anio = null)
    {
        if (!$anio) {
            $anio = Carbon::now()->year;
        }
        $condominio = session()->get('condominio');
        $gastosExtraudinarios = $this->gasto->extraudinarios()->condominioId($condominio->id)->anio($anio)->get();
        return view("gastos.extraudinarios",compact('condominio','anio','gastosExtraudinarios'));
    }
    public function guardarGastoExtraudinario($anio = null,GastoExtraStoreRequest $request)
    {
        $datos = $request->except('_token');
        $datos['tipo'] = 'E';
        if ($this->gasto->create($datos)) {
            return redirect()->back()->with(['message'=>'Gasto Extraudinario guardados correctamente.','type'=>'success']);
        }
        return redirect()->back()->with(['message'=>'Gasto Extraudinario no registrado.','type'=>'error']);
    }
    public function eliminarGastoExtraudinario($anio,$id)
    {
        $gastoExtraudinario = $this->gasto->find($id);
        if ($gastoExtraudinario->delete()) {
            return redirect()->back()->with(['message'=>'Ingreso Extraudinario eliminado.','type'=>'success']);
        }
        return redirect()->back()->with(['message'=>'Ingreso Extraudinario no eliminado.','type'=>'error']);
    }
    public function editarGastoExtraudinario($anio,$id)
    {
        $gastoExtraudinario = $this->gasto->find($id);
        return view("gastos.extraudinarios.edit",compact('condominio','anio','gastoExtraudinario'));
    }
    public function actualizarGastoExtraudinario($anio,$id,GastoExtraUpdateRequest $request)
    {
        $gastoExtraudinario = $this->gasto->find($id);
        $gastoExtraudinario->fill($request->only(['fecha','cantidad','concepto']));
        $gastoExtraudinario->save();
        return redirect()->route('gastosExtraudinarios',compact('anio'))->with(['message'=>'Ingreso Extraudinario Actualizado.','type'=>'success']);
    }   
}

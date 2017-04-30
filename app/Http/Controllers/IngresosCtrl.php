<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PagoStoreRequest;
use App\Http\Requests\IngresoExtraStoreRequest;
use App\Http\Requests\IngresoExtraUpdateRequest;
use App\Pago;
use App\Condominio;
use Carbon\Carbon;
class IngresosCtrl extends Controller
{
    protected $meses = ["enero" => 1, "febrero" => 2, "marzo" => 3, "abril"  => 4, "mayo"  => 5, "junio" => 6, "julio" => 7, "agosto" => 8, "septiembre" => 9, "octubre" => 10, "noviembre" => 11, "diciembre" => 12];
	function __construct(Pago $pago,Condominio $condominio)
	{
		$this->pago = $pago;
		$this->condominio = $condominio;
	}
    public function pagos($tipo = 'mensualidad' ,$anio = null, Request $request)
    {
    	if (!$anio) {
			$anio = Carbon::now()->year;
    	}
    	$condominio = session()->get('condominio');
    	$condominio = $this->condominio->id($condominio->id)->first();
    	$meses = $this->meses;
        return view('ingresos.pagos',compact('condominio','anio','meses','tipo'));
    }
    public function guardarPagos($tipo = 'mensualidad' ,$anio = null,PagoStoreRequest $request)
    {
        // dd($request->all());
    	$index = 1;
        $meses = $this->meses;
    	foreach ($request->except(['_token']) as $key => $valores) {
    	$fecha = Carbon::createFromDate($anio,$meses[$key],1);
    		foreach ($valores as $casa_id => $cantidad) {
    			if ($cantidad) {
		    		$pago = Pago::updateOrCreate([
                                'tipo' => 'M',
                                'casa_id' => $casa_id, 
                                'fecha' => $fecha->toDateString(), 
                                'concepto' => $tipo
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
    public function ingresosExtraudinarios($anio = null)
    {
        if (!$anio) {
            $anio = Carbon::now()->year;
        }
        $condominio = session()->get('condominio');
        $ingresosExtraudinarios = $this->pago->extraudinarios()->condominioId($condominio->id)->anio($anio)->get();
        return view("ingresos.extraudinarios",compact('condominio','anio','ingresosExtraudinarios'));
    }
    public function guardarIngresoExtraudinario($anio = null,IngresoExtraStoreRequest $request)
    {
        $datos = $request->except('_token');
        $datos['tipo'] = 'E';
        if ($this->pago->create($datos)) {
            return redirect()->back()->with(['message'=>'Ingreso Extraudinario guardados correctamente.','type'=>'success']);
        }
        return redirect()->back()->with(['message'=>'Ingreso Extraudinario no registrado.','type'=>'error']);
    }
    public function eliminarIngresoExtraudinario($anio,$id)
    {
        $ingresoExtraudinario = $this->pago->find($id);
        if ($ingresoExtraudinario->delete()) {
            return redirect()->back()->with(['message'=>'Ingreso Extraudinario eliminado.','type'=>'success']);
        }
        return redirect()->back()->with(['message'=>'Ingreso Extraudinario no eliminado.','type'=>'error']);
    }
    public function editarIngresoExtraudinario($anio,$id)
    {
        $ingresoExtraudinario = $this->pago->find($id);
        return view("ingresos.extraudinarios.edit",compact('condominio','anio','ingresoExtraudinario'));
    }
    public function actualizarIngresoExtraudinario($anio,$id,IngresoExtraUpdateRequest $request)
    {
        $ingresoExtraudinario = $this->pago->find($id);
        $ingresoExtraudinario->fill($request->only(['fecha','cantidad','concepto']));
        $ingresoExtraudinario->save();
        return redirect()->route('ingresosExtraudinarios',compact('anio'))->with(['message'=>'Ingreso Extraudinario Actualizado.','type'=>'success']);

    }
}

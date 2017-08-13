<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdeudoCasaStoreRequest;
use App\Http\Requests\AdeudoCasaUpdateRequest;
use App\Http\Requests\PasswordConfirmationRequest;

use App\Adeudo;
use App\Condominio;
use App\Concepto;
use Carbon\Carbon;

class AdeudoCtrl extends Controller
{
    function __construct(Adeudo $adeudo,Condominio $condominio,Concepto $concepto)
    {
    	$this->adeudo = $adeudo;
        $this->condominio = $condominio;
    	$this->concepto = $concepto;
    }
    public function mensualidades($anio = null)
    {
		if (!$anio) {
			$anio = Carbon::now()->year;
    	}
    	$condominio = session()->get('condominio');
    	$meses = config('helper.meses');
        $conceptos = $this->concepto->tipoMensuales()->condominioId($condominio->id)->get();
    	// $conceptos = ['mensualidad'=>'Mensualidad'];
    	$adeudosMensuales = $this->adeudo->mensualidades()->condominioId($condominio->id)->anio($anio)->get();
        return view('adeudos.mensualidades',compact('conceptos','adeudosMensuales','condominio','anio','meses'));
    }

	public function guadarMensualidades($anio = null, Request $request)
    {
		if (!$anio) {
			$anio = Carbon::now()->year;
    	}
        $meses = config('helper.meses');
    	$index = 1;
    	$condominio = session()->get('condominio');
        $conceptos = $this->concepto->tipoMensuales()->condominioId($condominio->id)->get();
    	foreach ($request->except(['_token']) as $key => $valores) {
    		$fecha = Carbon::createFromDate($anio,$meses[$key],1);
    		foreach ($valores as $concepto => $cantidad) {
    			if (!is_null($cantidad)) {
                    $conc = null;
                    foreach ($conceptos as $copt) {
                        if ($copt->id === $concepto) {
                            $conc = $copt;
                        }
                    }
		    		$this->adeudo->updateOrCreate([
                                    'tipo'          => 'M',
                                    'condominio_id' => $condominio->id,
                                    'fecha'         => $fecha->toDateString(),
                                    'concepto_id'   => $concepto,
                                    'concepto'      => $conc->nombre,
                                ],
    							[
                                    'cantidad' => $cantidad
    							]);
		    		$index += 1;
    			}
    		}
    	}
    	if ($index > 1) {
	    	return redirect()->back()->with(['message'=>'Adeudos Guardados correctamente.','type'=>'success']);
    	}
    	return redirect()->back()->with(['message'=>'Sin adeudos para actualizar.','type'=>'success']);
    }


    public function otrosAdeudos($anio = null)
    {
        if (!$anio) {
            $anio = Carbon::now()->year;
        }
        $condominio = session()->get('condominio');
        $condominio = $this->condominio->find($condominio->id);
        $otrosAdeudos = $this->adeudo->otros()->condominioId($condominio->id)->anio($anio)->get();
        return view("adeudos.otros",compact('condominio','anio','otrosAdeudos'));
    }
    public function guardarOtroAdeudo($anio = null,AdeudoCasaStoreRequest $request)
    {
        $datos = $request->except('_token');
        $condominio = session()->get('condominio');
        $datos['condominio_id'] = $condominio->id;
        $datos['tipo'] = 'O';
        if ($this->adeudo->create($datos)) {
            return redirect()->back()->with(['message'=>'Adeudo guardados correctamente.','type'=>'success']);
        }
        return redirect()->back()->with(['message'=>'Adeudo no registrado.','type'=>'error']);
    }
    public function eliminarOtroAdeudo($id,PasswordConfirmationRequest $request)
    {
        if ($otroAdeudo = $this->adeudo->find($id)) {
            if ($otroAdeudo->delete()) {
                return redirect()->back()->with(['message'=>'Adeudo eliminado.','type'=>'success']);
            }
        }
        return redirect()->back()->with(['message'=>'Adeudo no eliminado.','type'=>'error']);
    }
    public function editarOtroAdeudo($anio,$id)
    {
        $otroAdeudo = $this->adeudo->find($id);
        return view("adeudos.otros.edit",compact('condominio','anio','otroAdeudo'));
    }
    public function actualizarOtroAdeudo($anio,$id,Request $request)
    {
        $otroAdeudo = $this->adeudo->find($id);
        $otroAdeudo->fill($request->only(['fecha','cantidad','concepto']));
        $otroAdeudo->save();
        return redirect()->route('otrosAdeudos',compact('anio'))->with(['message'=>'Adeudo Actualizado.','type'=>'success']);
    }
}

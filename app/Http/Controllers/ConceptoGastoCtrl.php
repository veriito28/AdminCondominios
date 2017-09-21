<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConceptoStoreRequest;
use App\Http\Requests\ConceptoUptadeRequest;
use App\Http\Requests\PasswordConfirmationRequest;
use App\ConceptoGasto as Concepto;

class ConceptoGastoCtrl extends Controller
{

    function __construct(Concepto $concepto = null)
    {
    	$this->concepto = $concepto;
    }
    public function mostrar()
    {
        $condominio =session()->get('condominio');
		$tipos = [
			['id'=>'G','nombre'=>'General'],
			['id'=>'C','nombre'=>'Condominio'],
		];
		
 	    $conceptos = $this->concepto->misConceptos($condominio->id)->get(); 	
    	return view('gastos.conceptos.index',compact('conceptos','condominio','tipos'));
    }

    public function guardar(ConceptoStoreRequest $request)
    {
    	$datos = $request->all();
        $concepto = $this->concepto->create($datos);
        return redirect()->back()->with(['message'=>'Concepto agregado correctamente','type'=>'success']);
    }
    public function editar($id)
    {
    	$concepto = $this->concepto->id($id)->first();
		return view('gastos.conceptos.edit',compact('concepto'));    	
    }
    public function actualizar($id, ConceptoUptadeRequest $request)
    {
    	$concepto = $this->concepto->id($id)->first();
    	$concepto->fill($request->all());
    	$concepto->save();
        return redirect()->route('mostrarConceptosGastos')->with(['message'=>'Concepto actualizada correctamente','type'=>'success']);
    }
    public function eliminar($id,PasswordConfirmationRequest $request)
    {
    	$concepto = $this->concepto->id($id)->first();
    	if ($concepto->delete()) {
        	return redirect()->back()->with(['message'=>'Concepto eliminada correctamente','type'=>'success']);
	    }
        return redirect()->back()->with(['message'=>'No es posible borrar la concepto','type'=>'error']);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConceptoStoreRequest;
use App\Http\Requests\ConceptoUptadeRequest;
use App\Http\Requests\PasswordConfirmationRequest;
use App\ConceptoAdeudo as Concepto;

class ConceptoAdeudoCtrl extends Controller
{
    function __construct(Concepto $concepto = null)
    {
    	$this->concepto = $concepto;
    }
    public function mostrar()
    {
        $condominio =session()->get('condominio');
        $deudores = [
			['id'=>'G','nombre'=>'General'],
			['id'=>'P','nombre'=>'Personal'],
		];
		$tipos = [
			['id'=>'M','nombre'=>'Mensual'],
			['id'=>'F','nombre'=>'Fijo'],
		];
 	    $conceptos = $this->concepto->condominioId($condominio->id)->get(); 	
    	return view('adeudos.conceptos.index',compact('conceptos','condominio','deudores','tipos'));
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
		return view('adeudos.conceptos.edit',compact('concepto'));    	
    }
    public function actualizar($id, ConceptoUptadeRequest $request)
    {
    	$concepto = $this->concepto->id($id)->first();
    	$concepto->fill($request->all());
    	$concepto->save();
        return redirect()->route('mostrarConceptosAdeudos')->with(['message'=>'Concepto actualizada correctamente','type'=>'success']);
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

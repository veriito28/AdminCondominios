<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConceptoStoreRequest;
use App\Http\Requests\ConceptoUptadeRequest;
use App\Concepto;

class ConceptoCtrl extends Controller
{
    function __construct(Concepto $concepto = null)
    {
    	$this->concepto = $concepto;
    }
    public function mostrar()
    {
	    $conceptos = $this->concepto->get(); 	
    	return view('conceptos.index',compact('conceptos'));
    }
    public function guardar(ConceptoStoreRequest $request)
    {
    	$concepto = $this->concepto->create($request->all());
        return redirect()->back()->with(['message'=>'Concepto agregado correctamente','type'=>'success']);
    }
    public function editar($id)
    {
    	$concepto = $this->concepto->id($id)->first();
		return view('conceptos.edit',compact('concepto'));    	
    }
    public function actualizar($id, ConceptoUptadeRequest $request)
    {
    	$concepto = $this->concepto->id($id)->first();
    	$concepto->fill($request->all());
    	$concepto->save();
        return redirect()->route('mostrarConceptos')->with(['message'=>'concepto actualizada correctamente','type'=>'success']);
    }
    public function eliminar($id)
    {
    	$concepto = $this->concepto->id($id)->first();
    	if ($concepto->delete()) {
        	return redirect()->back()->with(['message'=>'concepto eliminada correctamente','type'=>'success']);
	    }
        return redirect()->back()->with(['message'=>'No es posible borrar la concepto','type'=>'error']);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConceptoStoreRequest;
use App\Http\Requests\ConceptoUptadeRequest;
use App\Http\Requests\PasswordConfirmationRequest;

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
    	$datos = $request->all();
        if ($datos['tipo'] == 'A') {
            if (session()->has('condominio')) {
                $condominio =session()->get('condominio');
                $datos['condominio_id'] = $condominio->id;
            }else{
                return redirect()->back()->with(['message'=>'Condominio no seleccionado','type'=>'warning']);
            }       
        }
        $concepto = $this->concepto->create($datos);
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
        return redirect()->route('mostrarConceptos')->with(['message'=>'Concepto actualizada correctamente','type'=>'success']);
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

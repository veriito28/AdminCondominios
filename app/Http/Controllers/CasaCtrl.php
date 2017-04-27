<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CasaStoreRequest;
use App\Http\Requests\CasaUpdateRequest;
use App\Casa;

class CasaCtrl extends Controller
{
    function __construct(Casa $casa){
    	$this->casa = $casa;
    }
	public function guardar(CasaStoreRequest $request)
    {
    	$casa = $this->casa->create($request->all());
        return redirect()->back()->with(['message'=>'Casa agregada correctamente','type'=>'success']);
    }
    public function editar($id)
    {
    	$casa = $this->casa->id($id)->first();
		return view('casas.edit',compact('casa'));    	
    }
    public function actualizar($id, CasaUpdateRequest $request)
    {
    	$casa = $this->casa->id($id)->first();

    	$casa->fill($request->all());
    	$casa->save();
        return redirect()->route('mostrarCondominio',['id'=>$casa->condominio_id])->with(['message'=>'Casa actualizada correctamente','type'=>'success']);
    }
    public function eliminar($id)
    {
    	$casa = $this->casa->id($id)->first();
    	if ($casa->delete()) {
        	return redirect()->back()->with(['message'=>'Casa eliminada correctamente','type'=>'success']);
	    }
        return redirect()->back()->with(['message'=>'No es posible borrar la casa','type'=>'error']);
    }
}

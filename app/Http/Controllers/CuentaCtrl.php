<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CuentaStoreRequest;
use App\Http\Requests\CuentaUpdateRequest;
use App\Http\Requests\PasswordConfirmationRequest;

use App\Cuenta;
use Auth;
class CuentaCtrl extends Controller
{
    function __construct(Cuenta $cuenta)
    {
    	$this->cuenta = $cuenta;
    }
    public function mostrar()
    {
    	$cuentas = $this->cuenta->usuarioId(Auth::user()->id)->get();
    	return view('cuentas.index',compact('cuentas'));
    }
    public function guardar(CuentaStoreRequest $request)
    {
    	if ($cuenta = $this->cuenta->create($request->all())) {
	    	return redirect()->back()->with(['message'=>'Cuenta Guardada correctamente.','type'=>'success']);
    	}
    	return redirect()->back()->with(['message'=>'No se pudo guardar al cuenta.','type'=>'warning']);
    }
    public function editar($id)
    {
    	if ($cuenta = $this->cuenta->id($id)->usuarioId(Auth::user()->id)->first()){
	    	return view('cuentas.edit',compact('cuenta'));
    	}
    	return redirect()->back()->with(['message'=>'No se encontro la cuenta para editar.','type'=>'warning']);
	}
	public function actualizar($id, CuentaUpdateRequest $request)
    {
    	if ($cuenta = $this->cuenta->id($id)->usuarioId(Auth::user()->id)->first()){
    		$cuenta->fill($request->all());
    		$cuenta->save();
	    	return redirect()->route('mostrarCuentas')->with(['message'=>'Cuenta Actualizada correctamente.','type'=>'success']);
    	}
    	return redirect()->back()->with(['message'=>'No se encontro la cuenta para actualizar.','type'=>'warning']);
	}
	public function eliminar($id,PasswordConfirmationRequest $request)
    {
    	if ($cuenta = $this->cuenta->id($id)->usuarioId(Auth::user()->id)->first()){
    		$cuenta->delete();
	    	return redirect()->route('mostrarCuentas')->with(['message'=>'La cuenta fue eliminada.','type'=>'success']);
    	}
    	return redirect()->back()->with(['message'=>'No se encontro la cuenta para eliminar.','type'=>'warning']);
	}
}

<?php

namespace App\Http\Controllers;
use App\Http\Requests\PasswordConfirmationRequest;
use App\Http\Requests\CondominioShowRequest;
use App\Http\Requests\CondominioStoreRequest;
use Illuminate\Http\Request;
use App\Condominio;
use Auth;
class CondominioCtrl extends Controller
{
    function __construct(Condominio $condominio){
    	$this->condominio = $condominio;
    }
    public function bienvenido()
    {
        $condominios = Auth::user()->condominios;
        return view('bienvenido',compact('condominios'));
    }

    public function mostrar($id)
    {
    	$condominio = $this->condominio->id($id)->with('casas')->first();
        return view('condominios.show',compact('condominio'));
    }

    public function editar($id)
    {
    	$condominio = $this->condominio->id($id)->first();
        return view('condominios.edit',compact('condominio'));
    }

    public function actualizar($value='')
    {
        $condominio = $this->condominio->id($request->id)->first();
        $seleccionado = $request->seleccionado;
        if ($request->has('seleccionado') && $request->seleccionado == true) {
                foreach (Auth::user()->condominios as $condo) {
                    Auth::user()->condominios()->updateExistingPivot($condo->id, ['seleccionado' => false]);        
                }       
            Auth::user()->condominios()->updateExistingPivot($condominio->id, ['seleccionado' => true]);
        }
        $condominio->fill($request->all());
        $condominio->save();
        return redirect()->back()->with(['message'=>'Condominio actualizado correctamente','type'=>'success']);
    }

    public function seleccionarCondominio($id_condominio)
    {
        if ($condominio =  $this->condominio->id($id_condominio)->first()) {
            $this->actualizarCondominioSeleccionado($condominio->id);
            return redirect()->back()->with(['message'=>'Condominio seleccionado correctamente','type'=>'success']);
        }
        return redirect()->back()->with(['message'=>'Condominio no encontrado','type'=>'error']);
    }
    
    public function guardar(CondominioStoreRequest $request)
    {
    	$condominio = $this->condominio->create($request->all());
        $condominio->usuarios()->attach(Auth::user()->id);
        if ($request->seleccionado == true) {
            $this->actualizarCondominioSeleccionado($condominio->id);
        }
        return redirect()->back()->with(['message'=>'Condominio agregado correctamente','type'=>'success']);
    }
    private function actualizarCondominioSeleccionado($id_condominio)
    {
        foreach (Auth::user()->condominios as $condo) {
            if ($id_condominio!== $condo->id ) {
                Auth::user()->condominios()->updateExistingPivot($condo->id, ['seleccionado' => false]);        
            }else{
                Auth::user()->condominios()->updateExistingPivot($condo->id, ['seleccionado' => true]);
                session()->regenerate();
                session()->put('condominio', $condo);
            }
        }       
    }
    public function eliminar($id, PasswordConfirmationRequest $request)
    {
    	if ($condominio = $this->condominio->id($id)->first()) {
            if ($condominio->id == session()->get('condominio')->id) {
                session()->forget('condominio');
            }
            if ($condominio->delete()) {
                return redirect()->route('bienvenido')->with(['message'=>'Condominio borrado','type'=>'success']);  
            }
        }
    	return redirect()->route('bienvenido')->with(['message'=>'El condominio no pudo ser borrado. ','type'=>'warning']);	
    }
}

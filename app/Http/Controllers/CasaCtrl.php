<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CasaStoreRequest;
use App\Http\Requests\PasswordConfirmationRequest;
use App\Http\Requests\CasaUpdateRequest;
use App\Casa;
use App\Condominio;
use Excel;

class CasaCtrl extends Controller
{
    function __construct(Casa $casa,Condominio $condominio){
        $this->casa = $casa;
    	$this->condominio = $condominio;
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
    public function eliminar($id,PasswordConfirmationRequest $request)
    {
    	if ($casa = $this->casa->find($id)) {
            if ($casa->delete()) {
            	return redirect()->back()->with(['message'=>'Casa eliminada correctamente','type'=>'success']);
            }
        }
        return redirect()->back()->with(['message'=>'No es posible borrar la casa','type'=>'error']);
    }
    public function cargarExcel(Request $request)
    {
        $casas =collect([]);
        $condominio = session()->get('condominio');
//        $condominio = $this->condominio->id($condominio->id)->first();
        $name = explode(".",$request->file->getClientOriginalName());
        if (end($name)=='xls' || end($name)=='xlsx') {
            $sheet = Excel::selectSheetsByIndex(0)->load($request->file,function($reader) use ($casas){
                foreach ($reader->get() as $article) {
                    $casa = new Casa($article->toArray());
                    $casas->push($casa);
                }
            });
        }else{
            return redirect()->back()->with(['message'=>'Archivo no admitido','type'=>'error']);
        }
        return view('condominios.excel',compact('condominio','casas'));
    }
    public function guardarExcel(Request $request)
    {
        for ($i=0; $i < sizeof($request->nombre) ; $i++) { 
            $pago = Casa::updateOrCreate([
                    'condominio_id' => $request->condominio_id,
                    'nombre'        => $request->nombre[$i]
            ],
            [
                    'contacto'   => $request->contacto[$i],
                    'interfon'   => $request->interfon[$i],
                    'no_cliente' => $request->no_cliente[$i],
                    'email'      => $request->email[$i],
                    'telefono'   => $request->telefono[$i],
                    'celular'    => $request->celular[$i],
                    'manzana'    => $request->manzana[$i],
                    'lote'       => $request->lote[$i],
                    'fecha_ent'  => $request->fecha_ent[$i]
            ]);
        }
       return redirect()->route('mostrarCondominio',['id'=>$request->condominio_id])->with(['message'=>'Casas agregadas correctamente','type'=>'success']);
    }

}

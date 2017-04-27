<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pago;
use App\Condominio;

class IngresosCtrl extends Controller
{
	function __construct(Pago $pago,Condominio $condominio)
	{
		$this->pago = $pago;
		$this->condominio = $condominio;
	}
    public function pagos(Request $request)
    {
    	if ($request->has('year')) {
			$year = $request->year;    		
    	}else{
			$year = \Carbon\Carbon::now()->year;
    	}
    	$condominio = session()->get('condominio');
    	$condominio = $this->condominio->id($condominio->id)->first();
    	$meses = ["enero" => 1, "febrero" => 2, "marzo" => 3, "abril"  => 4, "mayo"  => 5, "junio" => 6, "julio" => 7, "agosto" => 8, "septiembre" => 9, "octubre" => 10, "noviembre" => 11, "diciembre" => 12];
    	return view('pagos.index',compact('condominio','year','meses'));
    }
    public function guardarPagos(Request $request)
    {
    	$index = 1;
    	$meses = ["enero" => 1, "febrero" => 2, "marzo" => 3, "abril"  => 4, "mayo"  => 5, "junio" => 6, "julio" => 7, "agosto" => 8, "septiembre" => 9, "octubre" => 10, "noviembre" => 11, "diciembre" => 12];
    	foreach ($request->except(['_token','year']) as $key => $valores) {
    		$date = \Carbon\Carbon::createFromDate($request->year,$meses[$key],1);
    		if (\Carbon\Carbon::now()->year == $date->year) {
	    		$concepto = "mensualidad";
    		}elseif(\Carbon\Carbon::now()->year > $date->year){
	    		$concepto = "mensualidad_atrasada";
    		}else{
	    		$concepto = "mensualidad_adelantada";
    		}
    		foreach ($valores as $casa_id => $cantidad) {
    			if ($cantidad) {
		    		$pago = $this->pago->firstOrNew(['tipo' => '1','casa_id' => $casa_id, 'fecha' => $date, 'concepto' => $concepto]);
    				$pago->cantidad = $cantidad;
    				$pago->save();
		    		$index += 1;
    			}
    		}
    	}
    	dd($this->pago->get());
    	if ($index > 1) {
	    	return redirect()->back()->with(['message'=>'Pagos Guardados correctamente.','type'=>'success']);
    	}
    	return redirect()->back()->with(['message'=>'Sin pagos para actualizar.','type'=>'success']);
    }
}

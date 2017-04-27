<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gasto;
use App\Concepto;
class GastoCtrl extends Controller
{
    function __construct(Gasto $gasto,Concepto $concepto)
    {
    	$this->gasto = $gasto;
    	$this->concepto = $concepto;
    }
    public function ordinarios(Request $request)
    {
    	if ($request->has('year')) {
			$year = $request->year;    		
    	}else{
			$year = \Carbon\Carbon::now()->year;
    	}
    	$condominio = session()->get('condominio');
    	$conceptos = $this->concepto->get();
    	$meses = ["enero" => 1, "febrero" => 2, "marzo" => 3, "abril"  => 4, "mayo"  => 5, "junio" => 6, "julio" => 7, "agosto" => 8, "septiembre" => 9, "octubre" => 10, "noviembre" => 11, "diciembre" => 12];
    	return view('gastos.ordinarios',compact('condominio','year','conceptos','meses'));
    }
}

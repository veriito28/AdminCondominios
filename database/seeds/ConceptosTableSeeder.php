<?php

use Illuminate\Database\Seeder;
use App\Concepto;
class ConceptosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conceptos = ['Administracion de condominios','Jardineria','Limpieza de áreas comunes','Mantenimiento de alberca','Recibo de agua potable	','Recibo de energia electrica C.F.E.',	'Recoleccion de basura',	'Teleporteo y acceso automatico	'];
    	foreach ($conceptos as $value) {
    			Concepto::create(['nombre'=>$value]);
    	}
    }

}

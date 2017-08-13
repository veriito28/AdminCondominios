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
        $conceptos = [
            ['nombre' => 'Administracion de condominios','tipo'=>'G'],
            ['nombre' => 'Jardineria','tipo'=>'G'],
            ['nombre' => 'Limpieza de áreas comunes','tipo'=>'G'],
            ['nombre' => 'Mantenimiento de alberca','tipo'=>'G'],
            ['nombre' => 'Recibo de agua potable','tipo'=>'G'],
            ['nombre' => 'Recibo de energia electrica C.F.E.','tipo'=>'G'],
            ['nombre' => 'Recoleccion de basura','tipo'=>'G'],
            ['nombre' => 'Teleporteo y acceso automatico','tipo'=>'G'],
          //  ['nombre' => 'Cuota Mensual','tipo'=>'A'],
        ];
    	foreach ($conceptos as $concepto) {
    		Concepto::create($concepto);
    	}
    }

}

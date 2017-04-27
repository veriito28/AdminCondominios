<?php

use Illuminate\Database\Seeder;
use App\Condominio;
use App\Usuario;
class CondominiosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $condominio = Condominio::create(['nombre'=>'La Primavera']);
    	$condominio->usuarios()->attach(Usuario::first()->id,['seleccionado'=>true]);
    }
}

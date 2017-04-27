<?php

use Illuminate\Database\Seeder;
use App\Casa;
use App\Condominio;
class CasasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Casa::create([	'nombre'=>'Casa #1', 
        				'contacto'=>'Rafael Gonzalez',
        				'email'=> 'rafa.gc2807@gmail.com',
        				'condominio_id'=>Condominio::first()->id]);
        Casa::create([	'nombre'=>'Casa #2', 
        				'contacto'=>'Jose Ramon Perez',
        				'email'=> 'joseramonperez@gmail.com',
        				'condominio_id'=>Condominio::first()->id]);
        Casa::create([	'nombre'=>'Casa #3', 
        				'contacto'=>'Veronica Valenzuela',
        				'email'=> 'veritto@gmail.com',
        				'condominio_id'=>Condominio::first()->id]);
    }
}

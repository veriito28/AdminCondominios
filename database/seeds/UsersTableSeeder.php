<?php

use Illuminate\Database\Seeder;
use App\Usuario;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Usuario::create([    'nombre'=>'Veronica Valenzuela',
                            'username'=>'vvalenzuela',
                            'password'=>'asd123'
                        ]);
        Usuario::create([	'nombre'=>'Rafael Gonzalez',
        					'username'=>'rgonzalez',
        					'password'=>'asd123'
        				]);
    }
}

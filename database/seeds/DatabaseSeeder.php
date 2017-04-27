<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CondominiosTableSeeder::class);
        $this->call(CasasTableSeeder::class);
        $this->call(ConceptosTableSeeder::class);
    }
}

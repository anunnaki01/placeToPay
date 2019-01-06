<?php

use Illuminate\Database\Seeder;

class CustomerTypesSedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer_types')->insert([
            'name' => 'Persona',
        ]);
        DB::table('customer_types')->insert([
            'name' => 'Empresa',
        ]);
    }
}

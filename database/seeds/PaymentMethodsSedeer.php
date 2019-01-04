<?php

use Illuminate\Database\Seeder;

class PaymentMethodsSedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert([
            'name' => 'PSE',
        ]);
    }
}

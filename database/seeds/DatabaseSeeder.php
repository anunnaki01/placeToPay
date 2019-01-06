<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'customer_types',
            'payment_methods',
        ]);

        // $this->call(UsersTableSeeder::class);
         $this->call(CustomerTypesSedeer::class);
         $this->call(PaymentMethodsSedeer::class);
    }

    protected function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) DB::table($table)->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}

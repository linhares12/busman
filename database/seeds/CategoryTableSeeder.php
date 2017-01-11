<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
            	'id' => 1,
            	'type' => 'expense',
            	'name' => 'account_transfer',
            	'color' => '#000000',
            	'company' => 1
            ],
            [
            	'id' => 2,
            	'type' => 'receipt',
            	'name' => 'account_transfer',
            	'color' => '#000000',
            	'company' => 1
            ]

        ]);
    }
}

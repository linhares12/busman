<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
            	'name' => 'Admin do Sistema',
            	'email' => 'admin@admin.com',
            	'password' => Hash::make('busman.123'),
            	'company' => 1,
	        	'status' => 'active'
            ],

        ]);
    }
}

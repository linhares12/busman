<?php

namespace Maxcelos\People\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Maxcelos\People\Entities\Tenancy;
use Maxcelos\People\Entities\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Tenancy::create([
            'name' => 'default',
            'description' => 'Default tenancy',
        ]);

        Tenancy::create([
            'name' => 'alternative',
            'description' => 'Some other tenancy',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        factory(User::class, 100)->create();
    }
}

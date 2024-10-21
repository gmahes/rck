<?php

namespace Database\Seeders;

use App\Models\UserAuth;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        UserAuth::create([
            'username' => 'it_chakra',
            'password' => Hash::make('it_chakra'),
            'role' => 'superadmin',
        ]);
        UserDetail::create([
            'nik' => '123456789',
            'username' => 'it_chakra',
            'fullname' => 'Gregi Maulana Mahes',
            'position' => 'IT Support',
            'division' => 'Non Operasional',
        ]);
    }
}

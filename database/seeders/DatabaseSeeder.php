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
        UserAuth::create([
            'username' => 'it_chakra',
            'password' => Hash::make('it_chakra'),
            'role' => 'superadmin',
        ]);
        UserDetail::create([
            'nik' => 12345678,
            'username' => 'it_chakra',
            'fullname' => 'superadmin',
            'position' => 'superadmin',
            'division' => 'superadmin',
        ]);
    }
}

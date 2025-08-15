<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    User::create([
        'name' => 'Admin',
        'email' => 'admin@unah.hn',
        'password' => 'Rsbarm25',
        'usertype' => 'superadmin',
        'is_approved' => true,
    ]);
}
}

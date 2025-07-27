<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\User::create([

        'username' => 'Operator',
        'password' => bcrypt('12345'),
        'nama_admin' => 'Operator',
        'id_level' => 'LVL002',
        'last_login' => now()
    ]);
}
}

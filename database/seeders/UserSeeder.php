<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'firstname' => 'Giovanni',
            'lastname'  => 'D\'Apote',
            'email'     => 'giovanni_dapote@outlook.it',
            'username'  => 'palla451',
            'password'  => Hash::make('Carlotta19761977')
        ]);
    }
}

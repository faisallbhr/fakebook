<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'faisal',
            'email'=>'faisal@mail.com',
            'password'=>bcrypt('password'),
            'remember_token'=>Str::random(10)
        ]);
        User::create([
            'name'=>'farid',
            'email'=>'farid@mail.com',
            'password'=>bcrypt('password'),
            'remember_token'=>Str::random(10)
        ]);
        User::create([
            'name'=>'rigel',
            'email'=>'rigel@mail.com',
            'password'=>bcrypt('password'),
            'remember_token'=>Str::random(10)
        ]);
    }
}

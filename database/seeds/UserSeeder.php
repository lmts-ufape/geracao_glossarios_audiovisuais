<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
			"name" => "Editor",
			"email" => "editor@editor", 
            "password" => Hash::make("12345678")]);
        \App\User::create([
            "name" => "Admin",
            "email" => "admin@admin", 
            "password" => Hash::make("12345678")]);
    }
}

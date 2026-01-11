<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //1. creer un admin
        \App\Models\User::create([
            'name' => 'Admin System',
            'email' => 'admin@gmail.com',
            'password' =>  bcrypt('12345678'),
            'role' => 'admin',
            'service' => 'Direction',
            'is_active' => true,
        ]);

        // 2. Créer un Responsable (Pour tester Membre 2 plus tard)
        \App\Models\User::create([
            'name' => 'Reponsable IT',
            'email' => 'respo@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'responsable',
            'service' => 'Informatique',
            'is_active' => true,
        ]);
    }
}

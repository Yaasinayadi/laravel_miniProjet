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

        $catServeurs = \App\Models\Category::create([
            'name' => 'Serveurs',
            'icon' => 'server'
        ]);

        $catLaptops = \App\Models\Category::create([
            'name' => 'Ordinateurs Portables',
            'icon' => 'laptop'
        ]);

        $catSwitchs = \App\Models\Category::create([
            'name' => 'Switchs Reseau',
            'icon' => 'network-wired'
        ]);

        // 4. Créer des ressources de test (RESTORED)
        \App\Models\Resource::create([
            'name' => 'Serveur Dell PowerEdge R740',
            'category_id' => $catServeurs->id,
            'description' => 'Serveur haute performance pour virtualisation.',
            'specs' => 'RAM: 64GB, CPU: Dual Xeon, HDD: 4TB',
            'state' => 'active'
        ]);

        \App\Models\Resource::create([
            'name' => 'Serveur HP ProLiant DL380',
            'category_id' => $catServeurs->id,
            'description' => 'Serveur de stockage de données.',
            'specs' => 'RAM: 32GB, CPU: Xeon Gold, SSD: 2TB',
            'state' => 'active'
        ]);

        \App\Models\Resource::create([
            'name' => 'MacBook Pro M2',
            'category_id' => $catLaptops->id,
            'description' => 'Ordinateur portable pour développement.',
            'specs' => 'RAM: 16GB, Chip: M2, SSD: 512GB',
            'state' => 'active'
        ]);

        \App\Models\Resource::create([
            'name' => 'Lenovo ThinkPad X1',
            'category_id' => $catLaptops->id,
            'description' => 'Ultrabook professionnel.',
            'specs' => 'RAM: 16GB, CPU: i7, SSD: 1TB',
            'state' => 'active'
        ]);

        \App\Models\Resource::create([
            'name' => 'Cisco Switch Catalyst 9200',
            'category_id' => $catSwitchs->id,
            'description' => 'Switch administrable 24 ports.',
            'specs' => 'Ports: 24x 1Gbps, PoE+',
            'state' => 'active'
        ]);
    }
}

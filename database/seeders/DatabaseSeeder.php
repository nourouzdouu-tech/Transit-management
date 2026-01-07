<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dossier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Créer un agent par défaut
        User::create([
            'name' => 'Admin Agent',
            'email' => 'agent@transit.com',
            'password' => Hash::make('password'),
            'role' => 'agent',
            'phone' => '0123456789'
        ]);

        // Créer un client de test
        $client = User::create([
            'name' => 'Client Test',
            'email' => 'client@test.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'phone' => '0987654321'
        ]);

        // Créer quelques dossiers de test
        Dossier::create([
            'numero' => 'DOS-2024-0001',
            'client_id' => $client->id,
            'agent_id' => 1,
            'status' => 'En cours',
            'description' => 'Import de marchandises depuis la Chine',
            'date_creation' => now(),
            'date_echeance' => now()->addDays(15),
            'priorite' => 'Haute'
        ]);
    }
}
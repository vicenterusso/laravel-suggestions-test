<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // Criaçcão de usuário Admin no Seeder
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin@123'),
            'admin' => 1,
        ]);

        // Cria 50 usuários comuns
        \App\Models\User::factory()->count(300)->create();

        // Cria 20 sugestões com autores aleatorios criados anteriormente
        \App\Models\Suggestion::factory(20)->create();

        // Cria 500 vinculos de votos em sugestões
        \App\Models\UserVote::factory(500)->create();

        // Cria novas sugestões que não terão votos garantidamente
        \App\Models\Suggestion::factory(10)->create();
    }
}

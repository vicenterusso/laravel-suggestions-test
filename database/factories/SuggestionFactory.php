<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuggestionFactory extends Factory
{
    public function definition(): array
    {
        // Pelo menos 70% das sugestões devem ser de status 0-Pendente no seeder
        $status = fake()->randomElement([0, 0, 0, 0, 0, 0, 0, 1, 2, 3]);

        // Por opção, admin não terá sugestões criadaas no seed
        $user = \App\Models\User::where('admin', 0)
            ->inRandomOrder()
            ->first();

        return [
            'user_id' => $user->id,
            'titulo' => fake()->sentence(3),
            'descricao' => fake()->sentence(20),
            'status' =>$status,
        ];
    }

}

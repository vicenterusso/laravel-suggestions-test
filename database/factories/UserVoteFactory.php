<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserVoteFactory extends Factory
{
    public function definition(): array
    {

        // Recuperar uma sugestão aleatoria
        $suggestion = \App\Models\Suggestion::inRandomOrder()
            ->first();

        $user = \App\Models\User::where('admin', 0)
            ->whereNotIn('id', function($query) use ($suggestion) {
                $query->select('user_id')->from('user_votes')->where('suggestion_id', $suggestion->id);
            })->first();

        // Se nao achou nenhum, cria um usuario
        if(is_null($user)) {
            $user = \App\Models\User::factory()->create();
        }

        return [
            'user_id' => $user->id,
            'suggestion_id' => $suggestion->id,
            'vote' => 1, // Explicita um voto
        ];
    }

}

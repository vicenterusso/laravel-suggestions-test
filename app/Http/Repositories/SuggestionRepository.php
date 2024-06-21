<?php

namespace App\Http\Repositories;

use App\Models\Suggestion;
use App\Models\UserVote;

class SuggestionRepository
{


    public function getSuggestions($page = null, $limit = 10): mixed
    {
        $query = Suggestion::select([
            'suggestions.*',
            'users.name AS user_name'
        ])
            ->addSelect(\DB::raw('COUNT(user_votes.vote) as votes'))
            ->join('users', 'suggestions.user_id', '=', 'users.id')
            ->leftJoin('user_votes', 'suggestions.id', '=', 'user_votes.suggestion_id')
            ->groupBy('suggestions.id')
            ->orderBy('votes', 'desc');

        if ($page !== null) {
            return $query->paginate(page: $page,perPage: $limit);
        }

        return $query->paginate($limit);
    }


    public function createSuggestion(array $validSuggestion): ?Suggestion
    {

        // Cria nova sugestão após validacao
        $suggestion = new Suggestion();
        //$suggestion->status = 0; // Por default via database, '0'

        $suggestion->titulo = $validSuggestion['titulo'];
        $suggestion->descricao = $validSuggestion['descricao'];

        if($suggestion->save()) {
            return $suggestion;
        }

        return null;

    }

    public function vote(int $suggestion_id): bool
    {

        // Verifica se há votos deste usuario na sugestão
        $voto = UserVote::where('suggestion_id', $suggestion_id)
            ->where('user_id', auth()->user()->id)
            ->first();

        if($voto) {
            return false;
        }

        $voto = new UserVote();
        $voto->suggestion_id = $suggestion_id;
        $voto->user_id = auth()->user()->id;
        $voto->vote = 1;

        return $voto->save();


    }

}

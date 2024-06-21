<?php

namespace App\Livewire;

use App\Http\Repositories\SuggestionRepository;
use App\Models\UserVote;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\App;
use Livewire\WithPagination;
use App\Models\Suggestion;
use Livewire\Component;

class SuggestionList extends Component
{

    use WithPagination;
    use AuthorizesRequests;

    public $feedbackMessage;
    public $isAdmin;

    public function statusChanged($status_id, $suggestion_id)
    {

        try {

            $suggestion = Suggestion::find($suggestion_id);
            $this->authorize('update', $suggestion);


            $suggestion = Suggestion::where('id', $suggestion_id)->first();
            if ($suggestion) {
                $suggestion->status = $status_id;
            }

            if ($suggestion->save()) {
                $this->feedbackMessage = [
                    'id' => $suggestion_id,
                    'type' => 'Sucesso',
                    'msg' => 'Status alterado com sucesso!'
                ];
            } else {
                $this->feedbackMessage = [
                    'id' => $suggestion_id,
                    'type' => 'Erro',
                    'msg' => 'Houve um erro ao tentar alterar o status!'
                ];
            }
        } catch (\Exception $e) {
            $this->feedbackMessage = [
                'id' => $suggestion_id,
                'type' => 'Erro',
                'msg' => 'Você não tem permissão para alterar o status!'
            ];
        }

    }

    public function upvote($suggestion_id)
    {

        $repository = App::make(SuggestionRepository::class);
        $voto = $repository->vote($suggestion_id);

        if(!$voto) {
            $this->feedbackMessage = [
                'id' => $suggestion_id,
                'type' => 'Erro',
                'msg' => 'Você já votou nesta sugestão!',
            ];
            return;
        }

        $this->feedbackMessage = [
            'id' => $suggestion_id,
            'type' => 'Sucesso',
            'msg' => 'Voto computado com sucesso!'
        ];

    }

    public function render()
    {
        $repository = App::make(SuggestionRepository::class);
        $suggestions = $repository->getSuggestions();

        return view('livewire.suggestion-list', [
            'suggestions' => $suggestions
        ]);
    }
}

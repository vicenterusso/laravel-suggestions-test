<?php

namespace App\Livewire;

use App\Http\Repositories\SuggestionRepository;
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

    /**
     * Função de troca de status realizados por um Admin
     *
     * @param $status_id ID do status a ser alterado
     * @param $suggestion_id ID da sugestão a ser alterada
     * @return void
     */
    public function statusChanged($status_id, $suggestion_id)
    {

        try {

            // Este try catch está capturando a exception que
            // este ->autorize() pode lançar. Se o usuário não
            // for admin, a exception é lançada e capturada
            // mais abaixo.
            //
            // Esta verifica se o usuário é admin ou nào está
            // declarada no arquivo "SuggestionPolicy"
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

    /**
     * Função de voto em sugestão. Aqui é feita a verificação se o usuário
     * já votou na sugestão ou não. Se sim, retorna uma mensagem de erro.
     *
     * @param $suggestion_id ID da sugestão a ser votada
     * @return void
     */
    public function upvote($suggestion_id)
    {

        // Instancia o repositório explicitamente
        // (Livewire não tem injeção de dependência)
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

        // Instancia o repositório explicitamente
        // (Livewire não tem injeção de dependência)
        $repository = App::make(SuggestionRepository::class);

        // Retorna as sugestãos ordenadas por voto. Aqui não preciso passar
        // a página pois o Livewire facilita todo o processo de paginação
        $suggestions = $repository->getSuggestions();

        return view('livewire.suggestion-list', [
            'suggestions' => $suggestions
        ]);
    }
}

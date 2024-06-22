<?php

namespace App\Livewire;

use App\Http\Repositories\SuggestionRepository;
use App\Http\Requests\StoreSuggestionRequest;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class CreateSuggestion extends Component
{

    public $titulo;
    public $descricao;
    public $feedbackMessage;


    protected function rules(): array
    {
        return (new StoreSuggestionRequest())->rules();
    }


    protected function messages(): array
    {
        return (new StoreSuggestionRequest())->messages();
    }

    /**
     * Função que cria a sugestão via Livewire. Toda a regra
     * de validação está isolada em um FormRequest, sendo aproveitaada
     * nos controllers via API tambem
     *
     * @return void
     */
    public function createSuggestion() {

        $validSuggestion = $this->validate();

        // Instancia o repositório explicitamente
        // (Livewire não tem injeção de dependência)
        $repository = App::make(SuggestionRepository::class);

        // Cria a sugestão e retorna
        $suggestion = $repository->createSuggestion($validSuggestion);

        // Se o retorno for um objeto 'Suggestion', a sugestão
        // foi criada com sucesso
        if($suggestion instanceof \App\Models\Suggestion) {
            $this->feedbackMessage = [
                'type' => 'Sucesso',
                'msg' => 'Sugestão enviada com sucesso!'
            ];
        } else {
            $this->feedbackMessage = [
                'type' => 'Erro',
                'msg' => 'Houve um erro ao enviar a sugestão. Tente novamente!',
            ];
        }

        $this->titulo = '';
        $this->descricao = '';
    }

    public function render()
    {
        return view('livewire.create-suggestion');
    }
}

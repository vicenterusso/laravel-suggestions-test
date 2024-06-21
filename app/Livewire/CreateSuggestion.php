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

    public function createSuggestion() {

        $validSuggestion = $this->validate();

        $repository = App::make(SuggestionRepository::class);
        $suggestion = $repository->createSuggestion($validSuggestion);

        if(!is_null($suggestion)) {
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

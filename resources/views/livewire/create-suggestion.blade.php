<div class="w-1/2 bg-white p-8">

    @if (is_array($feedbackMessage))
        <div class="{{ $feedbackMessage['type'] == 'Sucesso' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700' }} border px-4 py-3 rounded relative mb-5" role="alert">
            <strong class="font-bold">{{ $feedbackMessage['type'] }}</strong>
            <span class="block sm:inline">{{ $feedbackMessage['msg'] }}</span>
        </div>
    @endif

    <form wire:submit="createSuggestion" method="POST">

        <h2 class="text-lg font-bold mb-4">Nova Sugestão</h2>
        @csrf
        <div class="mb-4">
            <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Título</label>
            <input type="text" wire:model="titulo" id="titulo" name="titulo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <div class="text-red-600 mt-1">@error('titulo') {{ $message }} @enderror</div>
        </div>
        <div class="mb-4">
            <label for="descricao" class="block text-gray-700 text-sm font-bold mb-2">Descrição</label>
            <textarea wire:model="descricao" id="descricao" name="descricao" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="4"></textarea>
            <div class="text-red-600">@error('descricao') {{ $message }} @enderror</div>
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Enviar Sugestão
            </button>
        </div>
    </form>

</div>

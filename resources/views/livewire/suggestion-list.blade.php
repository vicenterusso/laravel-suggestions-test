<div class="{{ $isAdmin == 'true' ? '' : 'w-1/2' }} bg-white p-8">

    <h2 class="text-lg font-bold mb-4">Sugestões</h2>

    <div class="flex flex-col space-y-4">
        @foreach($suggestions as $suggestion)
            <div class="flex justify-between bg-gray-100 p-4 rounded-lg">
                <div class="w-full mr-10">
                    <h3><span class="font-bold">Data de Criação:</span> {{ $suggestion->created_at->format('d/m/Y') }}</h3>
                    <h3><span class="font-bold">Título:</span> {{ $suggestion->titulo }} (#{{ $suggestion->id }})</h3>
                    <p class="mt-1 font-bold">Descrição da sugestão:</p>
                    <p>{{ $suggestion->descricao }}</p>
                    <p class="mt-1"><span class="font-bold">Autor:</span> {{ $suggestion->user_name }}</p>

                    @if (is_array($feedbackMessage) && $feedbackMessage['id'] === $suggestion->id)
                        <div id="alert-{{ $suggestion->id }}" class="{{ $feedbackMessage['type'] == 'Sucesso' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700' }} border px-4 py-3 rounded relative mt-5" role="alert">
                            <span class="block sm:inline">{{ $feedbackMessage['msg'] }}</span>
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                <svg class="fill-current h-6 w-6 text-red" onclick="document.getElementById('alert-{{ $suggestion->id }}').style.display='none';" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <title>Close</title>
                                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-2.779a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                                    </svg>
                            </span>
                        </div>
                    @endif

                </div>
                @if($isAdmin == 'true')
                    <div class="flex flex-col">
                        @php
                            $statusText = [
                                0 => 'Pendente',
                                1 => 'Aprovada',
                                2 => 'Rejeitada',
                                3 => 'Em Desenvolvimento',
                            ];
                        @endphp

                        <p><span class="font-bold">Status:</span> {{ $statusText[$suggestion->status] }}</p>

                        <p class="mt-2 font-bold">Alterar para:</p>
                        <select id="status-{{ $suggestion->id }}" value="{{ $suggestion->status }}" class="w-[250px] mb-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full">
                            <option value="0" {{ $suggestion->status == 0 ? 'selected' : '' }}>Pendente</option>
                            <option value="1" {{ $suggestion->status == 1 ? 'selected' : '' }}>Aprovada</option>
                            <option value="2" {{ $suggestion->status == 2 ? 'selected' : '' }}>Rejeitada</option>
                            <option value="3" {{ $suggestion->status == 3 ? 'selected' : '' }}>Em Desenvolvimento</option>
                        </select>
                        <button wire:click="statusChanged(document.getElementById('status-{{ $suggestion->id }}').value, {{ $suggestion->id }})" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Alterar Status</button>
                    </div>
                @else
                <div class="flex flex-col">
                    <button wire:click="upvote({{ $suggestion->id }})" class="w-[100px] bg-blue-500 text-white px-4 py-2 rounded-lg">Votar 👍</button>
                    <span class="text-gray-500 text-center">Votos: <span class="font-bold text-black">{{ $suggestion->votes }}</span></span>
                </div>
                @endif
            </div>
        @endforeach

        <div>
            {{ $suggestions->links() }}
        </div>

    </div>
</div>

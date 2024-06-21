<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Sugestões (API)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex text-gray-900">

                    <div class="w-1/2 bg-white p-8">

                        <h2 class="text-lg font-bold mb-4">Sugestões</h2>

                        <div class="flex flex-col space-y-4">

                            <div id="suggestion-list"></div>
                            <div id="suggestion-pagination"></div>

                        </div>
                    </div>

                    <div id="create-suggestion-container" class="w-1/2 bg-white p-8">

                        <div class="success hidden bg-green-100 border-green-400 text-green-700 border px-4 py-3 rounded relative mb-5" role="alert">
                            <strong class="font-bold">Sucesso</strong>
                            <span class="block sm:inline">Sugestão enviada com sucesso!</span>
                        </div>
                        <div class="error hidden bg-red-100 border-red-400 text-red-700 border px-4 py-3 rounded relative mb-5" role="alert">
                            <strong class="font-bold">Erro!</strong>
                            <span class="block sm:inline">Houve um erro ao enviar a sugestão. Tente novamente!</span>
                        </div>

                        <form id="create-suggestion-form" method="POST">
                            <h2 class="text-lg font-bold mb-4">Nova Sugestão</h2>
                            <div class="mb-4">
                                <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Título</label>
                                <input type="text" id="titulo" name="titulo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <div class="text-red-600 mt-1"></div>
                            </div>
                            <div class="mb-4">
                                <label for="descricao" class="block text-gray-700 text-sm font-bold mb-2">Descrição</label>
                                <textarea id="descricao" name="descricao" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="4"></textarea>
                                <div class="text-red-600"></div>
                            </div>
                            <div class="flex items-center justify-between">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Enviar Sugestão
                                </button>
                            </div>
                        </form>

                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>

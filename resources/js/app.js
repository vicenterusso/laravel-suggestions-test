import './bootstrap';

/**
 * Carrega um template HTML via AJAX que será reutilizado
 * na listagem de sugestoes e na paginação
 */
async function loadTemplate(url) {
    const response = await fetch(url);
    return await response.text();
}

// Evento de carregamento do DOM
document.addEventListener('DOMContentLoaded', function () {

    // Adiciona evento de click aos links de paginacaop
    document.getElementById('suggestion-pagination').addEventListener('click', async function (event) {
        if (event.target && event.target.classList.contains('page-link')) {
            // Recupera a pagina clicada
            const page = event.target.getAttribute('data-page');

            // Executa a requisição dos dados paginados
            await requestPage(page);
        }
    });


    // Adiciona evento de click de votação
    document.getElementById('suggestion-list').addEventListener('click', async function (event) {
        if (event.target && event.target.classList.contains('btn-vote')) {

            // Recupear o ID da sugestão que está sendo votada
            const id = event.target.getAttribute('data-id');

            // Executa a requisição de votação, exibindo o alerta de sucesso ou erro
            window.axios.post('/api/suggestion/vote/' + id)
                .then(response => {
                    document.getElementById('alert-'+id).classList.remove('hidden');
                })
                .catch(error => {
                    document.getElementById('alert-error-'+id).classList.remove('hidden');
                });
        }
    });
});

/**
 * Função de requisição da API para listagem de sugestões, com o parametro
 * 'page' indicando qual página de sugestões deve ser carregada
 */
async function requestPage(page) {

    // Carrega os templates HTML via AJAX para a substituicao apos a requisicao da API
    let suggestion_template = await loadTemplate('templates-js/suggestion-list.html');
    let suggestion_pagination_template = await loadTemplate('templates-js/suggestion-pagination.html');

    window.axios.get('/api/suggestions?page=' + page).then(response => {

        let container = document.getElementById('suggestion-list')
        container.innerHTML = '';

        // Para cada sugestão, substituir os placeholders do template
        response.data['data'].forEach(item => {

            // Ajusta a data BR
            let dateBR = (new Date(item['created_at'])).toLocaleDateString('pt-BR', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                timeZone: 'UTC',
            })

            // Realiza a substituição dos placeholders do
            // template com os dados vindos da API
            let t = suggestion_template
                .replace(/{{CREATED_AT}}/g, dateBR)
                .replace(/{{TITULO}}/g, item['titulo'])
                .replace(/{{DESCRICAO}}/g, item['descricao'])
                .replace(/{{ID}}/g, item['id'])
                .replace(/{{USER_NAME}}/g, item['user_name'])
                .replace(/{{VOTES}}/g, item['votes']);


            // Insere os dados gerados e substituidos no container de sugestoes
            container.insertAdjacentHTML('beforeend', t);
        });

        // Calcula a paginação e substitui os placeholders do template
        let prevPage = response.data['current_page'] > 1 ? response.data['current_page'] - 1 : 1;
        let nextPage = response.data['current_page'] < response.data['last_page'] ? response.data['current_page'] + 1 : response.data['last_page'];

        let t = suggestion_pagination_template
            .replace('{{PREV_LINK}}', prevPage)
            .replace('{{NEXT_LINK}}', nextPage);

        let pcontainer = document.getElementById('suggestion-pagination')
        pcontainer.innerHTML = t;

    });
}

/**
 * Evento de carregamento da pagina por completo, após o DOM,
 * styles, scripts, imagens, etc
 */
window.onload = async function () {

    // Se existe o containr de listar sugestoes
    if(document.getElementById('suggestion-list')) {
        await requestPage(1);
    }

    // Se existe o formulario de criar sugestoes
    let form = document.getElementById('create-suggestion-form')
    if(form) {

        function clearErrors() {
            // Limpa os erros antigos(pre-existentes) do formulario
            const errorDivs = document.querySelectorAll('.text-red-600');
            errorDivs.forEach(function(div) {
                div.innerHTML = '';
            });
        }

        // Exibe os erros no formulario vindos da API
        function displayErrors(errors) {
            Object.keys(errors).forEach(function(field) {
                const fieldElement = document.querySelector(`[name="${field}"]`);
                if (fieldElement) {
                    const errorDiv = fieldElement.nextElementSibling;
                    if (errorDiv && errorDiv.classList.contains('text-red-600')) {
                        errorDiv.innerHTML = errors[field].join('<br>');
                    }
                }
            });
        }

        // Adiciona evento de submit ao formulario
        form.addEventListener('submit', function (event) {

            // Evita que o formulario seja enviado via POST padrão
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();

            // Limpa os erros
            clearErrors();

            // Executa o request com os dados digitados no formulario e
            // exibe o alerta de sucesso ou erro de acordo com o resultado
            const formData = new FormData(form);
            window.axios.post('/api/suggestion', formData)
                .then(response => {
                    document.querySelector('#create-suggestion-container .success').style.display = 'block';
                })
                .catch(error => {
                    displayErrors(error.response.data.errors);
                });


        });
    }

};

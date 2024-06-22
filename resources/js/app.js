import './bootstrap';


async function loadTemplate(url) {
    const response = await fetch(url);
    return await response.text();
}

document.addEventListener('DOMContentLoaded', function () {
    // Adiciona evento de click aos links de paginacaop
    document.getElementById('suggestion-pagination').addEventListener('click', async function (event) {
        if (event.target && event.target.classList.contains('page-link')) {
            const page = event.target.getAttribute('data-page');
            await requestPage(page);
        }
    });


    // Adiciona evento de click de votacao
    document.getElementById('suggestion-list').addEventListener('click', async function (event) {
        if (event.target && event.target.classList.contains('btn-vote')) {
            const id = event.target.getAttribute('data-id');

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

async function requestPage(page) {
    // Carrega um template HTML via AJAX para a substituicao apos a requisicao da API
    let suggestion_template = await loadTemplate('templates-js/suggestion-list.html');
    let suggestion_pagination_template = await loadTemplate('templates-js/suggestion-pagination.html');

    window.axios.get('/api/suggestions?page=' + page).then(response => {

        let container = document.getElementById('suggestion-list')
        container.innerHTML = '';

        // Para cada sugestão, substituir os placeholders do template
        response.data['data'].forEach(item => {

            // Ajusta a data
            let dateBR = (new Date(item['created_at'])).toLocaleDateString('pt-BR', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                timeZone: 'UTC',
            })

            let t = suggestion_template
                .replace(/{{CREATED_AT}}/g, dateBR)
                .replace(/{{TITULO}}/g, item['titulo'])
                .replace(/{{DESCRICAO}}/g, item['descricao'])
                .replace(/{{ID}}/g, item['id'])
                .replace(/{{USER_NAME}}/g, item['user_name'])
                .replace(/{{VOTES}}/g, item['votes']);


            // Inserir o HTML no container
            container.insertAdjacentHTML('beforeend', t);
        });

        let prevPage = response.data['current_page'] > 1 ? response.data['current_page'] - 1 : 1;
        let nextPage = response.data['current_page'] < response.data['last_page'] ? response.data['current_page'] + 1 : response.data['last_page'];

        let t = suggestion_pagination_template
            .replace('{{PREV_LINK}}', prevPage)
            .replace('{{NEXT_LINK}}', nextPage);

        let pcontainer = document.getElementById('suggestion-pagination')
        pcontainer.innerHTML = t;

    });
}

window.onload = async function () {

    // Se existe o containr de listar sugestoes
    if(document.getElementById('suggestion-list')) {
        await requestPage(1);
    }

    // Se existe o formulario de criar sugestoes
    let form = document.getElementById('create-suggestion-form')
    if(form) {

        function clearErrors() {
            // Clear any previous error messages
            const errorDivs = document.querySelectorAll('.text-red-600');
            errorDivs.forEach(function(div) {
                div.innerHTML = '';
            });
        }

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
            event.preventDefault();

            event.stopPropagation();
            event.stopImmediatePropagation();

            clearErrors();

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

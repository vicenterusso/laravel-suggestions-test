# Projeto Laravel

### Requisitos

PHP 8.1

MySQL 5.7.22

Nginx

### Instalação

Clonar o repositorio
```
git@github.com:vicenterusso/laravel-suggestions-test.git
```

Copie o `.env.example` para `.env` e configure as variaveis corretamente.

```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```

*Obs: Caso use docker (veja abaixo), o `.env.example` ja está com os dados corretos pre-configurados*

Executar os comandos
```sh
composer install
php artisan migrate:fresh
php artisan db:seed #opcional
npm install
npm run build
```

### Docker Compose (opcional)

Para facilitar há um projeto em docker compose e o projeto Laravel deve ser copiado para a pasta `teste-od`, como mostra a estrutura abaixo
```
├── data                         // Database
├── etc                          // Configuracoes
│   ├── nginx
│   │   ├── nginx.conf
│   │   └── vhosts
│   │       └── teste-od.conf
│   └── php
│       ├── php.ini
│       └── www.conf
├── web
│    └── teste-od                // Projeto laravel
└── docker-compose.yml
```

Executar com o seguinte comando

```
docker compose up -d
```

Sem seguida acessar a shell

```
docker exec -ti od_app bash
```
E na pasta `/var/www/teste-od` executar os mesmos comandos da instalação acima



### Features

- Primeiro usuário criado será o administrador
- Caso o seed seja executado, será criado um usuário administrador automaticamente:
    - Usuário: `admin@admin.com`
    - Senha: `admin@123`
- Foram criados duas versões, ambas usam o mesmo arquivo de lógica evitando código repetido (`SuggestionRepository`):
    - Livewire components
    - API padrão
- Seção Admin (alteração de status) somente em versão Livewire



## Descrição do Projeto

Este é o backend do sistema SocGest, desenvolvido com a framework Laravel, versão 11.x 

## Pré-requisitos
Certifique-se de ter as seguintes ferramentas instaladas no seu sistema antes de começar a configurar o projeto:

- PHP (>= 8.2)
- Composer
- Laravel (>= 11.x)
- MySQL ou outra base de dados compatível
- IDE (recomendados: Visual Studio Code ou PHPStorm)

## Configuração do Projeto

1. Certifique-se de que o servidor MySQL está ativo e crie uma base de dados para o projeto
2. Abra o terminal no diretório do projeto
3. Execute o comando `composer install` para instalar as dependências do projeto
4. Execute o comando `cp .env.example .env` para criar o arquivo de configuração do ambiente
5. Execute o comando `php artisan key:generate` para gerar a chave de encriptação da aplicação
6. Configure o arquivo `.env` com as informações da sua base de dados (Username, Password, Nome da Base de Dados...)
7. Execute o comando `php artisan migrate` para criar as tabelas na base de dados
8. Execute o comando `php artisan serve` para iniciar o servidor local


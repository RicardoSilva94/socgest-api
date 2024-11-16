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

1. Abra o terminal no diretório do projeto
2. Execute o comando `composer install` para instalar as dependências do projeto
3. Execute o comando `cp .env.example .env` para criar o arquivo de configuração do ambiente
4. Execute o comando `php artisan key:generate` para gerar a chave de encriptação da aplicação
5. Configure o arquivo `.env` com as informações da sua base de dados
6. Execute o comando `php artisan migrate` para criar as tabelas da base de dados
7. Execute o comando `php artisan db:seed` para popular as tabelas da base de dados
8. Execute o comando `php artisan serve` para iniciar o servidor local

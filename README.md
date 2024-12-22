# API de Vendas 🛍️

Uma API RESTful desenvolvida em Laravel para gestão de vendas simples.

## Recursos

-   Modelo mutitenant single database
-   CRUD de Pedidos, Clientes, Categorias, Produtos, Papéis e Usuários.
-   Cadastro de Produtos com envio de imagem e relacionamento com categoria
-   Autenticação JWT com Sanctum.
-   Recuperação de senha com envio de código de validaçao por email
-   Autorização com ACL baseado em "Roles and Permissions".
-   Documentação com Swagger.

## Tecnologias

-   **Linguagem:** PHP 8.3
-   **Framework:** Laravel 11
-   **Banco de Dados:** MySQL
-   **Cache:** Redis
-   **Ferramentas:** Docker, Laravel Sail, Swagger, Mailpit

## Como Executar

Clone o repositório:

```bash
git clone https://github.com/paulokalleby/api-vendas.git

cd api-vendas
```

Crie o Arquivo .env

```bash
cp .env.example .env
```

Subir containers do projeto

```sh
./vendor/bin/sail up -d
```

Instalar dependências

```bash
./vendor/bin/sail composer i
```

Gere a chave do projeto Laravel

```bash
./vendor/bin/sail artisan key:generate
```

Execute a migração do banco de dados e popule tabela de usuários

```bash
./vendor/bin/sail artisan migrate --seed
```

Acesse a documentação da api
[http://localhost](http://localhost)

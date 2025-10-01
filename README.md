# CWI Test Microservices

## Visão Geral

Este projeto oferece uma API REST em PHP + Laravel e um Microserviço em Node.js + Express.

A API em Laravel fornece endpoints para o gerenciamento de usuários, além de servir como proxy para o Microserviço em Node.js.

## Estrutura do Projeto

- `/laravel-cwi-api`: API REST PHP + Laravel;
- `/node-ms`: Microserviço Node.js + Express;
- `/.github/`: Definição da pipeline de CI usando Github Actions;
- `/docker-config/`: Configuração do WebServer NGINX usada no `docker-compose`.

## Tecnologias Utilizadas

### Backend

- **Laravel 12** (PHP 8.2+)
- **MySQL 8.0** (Banco de dados)
- **Node.js + Express** (Microserviço)
- **PM2** (Process Manager para Node.js)

### Infraestrutura

- **Docker & Docker Compose**
- **NGINX** (Web Server)
- **phpMyAdmin** (Interface de administração do MySQL)

## Funcionalidades

### API Laravel

- **Gerenciamento de Usuários**: CRUD completo (Create, Read, Update, Delete)
- **Proxy para Microserviço**: Integração com o serviço Node.js
- **Health Check**: Endpoint para verificação de saúde da API

### Microserviço Node.js

- **API Simples**: Endpoint básico com mensagem de status
- **Process Management**: Gerenciado pelo PM2 para alta disponibilidade

## Como Executar o Projeto

### Pré-requisitos

- Docker
- Docker Compose
- Git

### Passo a Passo

1. **Clone o repositório**

   ```bash
   git clone <url-do-repositorio>
   cd cwi-test
   ```

2. **Execute o Docker Compose**

   ```bash
   docker-compose up --build
   ```

3. **Aguarde a inicialização**

   - O MySQL será configurado automaticamente
   - As imagens Docker serão construídas
   - Todos os serviços serão iniciados

4. **Acesse os serviços**
   - **API Laravel**: http://localhost:6162
   - **Microserviço Node.js**: http://localhost:3000
   - **phpMyAdmin**: http://localhost:8383

PS: As variáveis de ambiente para rodar localmente já estão pré-configuradas no `docker-compose.yml`, para facilitar a inicialização!

### Endpoints Disponíveis

#### API Laravel (http://localhost:6162)

- **`GET /api/users`** - Listar usuários

  - **Descrição**: Retorna uma lista de todos os usuários cadastrados.
  - **Entrada**: Nenhuma (requisição GET simples).
  - **Saída**:
    ```json
    {
      "data": [
        {
          "id": 1,
          "name": "John Doe",
          "email": "john@example.com",
          "created_at": "2023-10-01T00:00:00.000000Z",
          "updated_at": "2023-10-01T00:00:00.000000Z"
        },
        {
          "id": 2,
          "name": "Jane Smith",
          "email": "jane@example.com",
          "created_at": "2023-10-01T00:00:00.000000Z",
          "updated_at": "2023-10-01T00:00:00.000000Z"
        }
      ]
    }
    ```
  - **Possíveis Erros**:
    - `500 Internal Server Error`: Erro interno do servidor.

- **`POST /api/users`** - Criar usuário

  - **Descrição**: Cria um novo usuário no sistema.
  - **Entrada**:
    ```json
    {
      "name": "John Doe",
      "email": "john@example.com",
      "password": "password123",
      "password_confirmation": "password123"
    }
    ```
  - **Saída**:
    ```json
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2023-10-01T00:00:00.000000Z",
      "updated_at": "2023-10-01T00:00:00.000000Z"
    }
    ```
  - **Possíveis Erros**:
    - `422 Unprocessable Entity`: Dados inválidos (ex.: email já existe, senha fraca).
    - `500 Internal Server Error`: Erro interno do servidor.

- **`GET /api/users/{id}`** - Buscar usuário por ID

  - **Descrição**: Retorna os detalhes de um usuário específico.
  - **Entrada**: Nenhuma (ID passado na URL).
  - **Saída**:
    ```json
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2023-10-01T00:00:00.000000Z",
      "updated_at": "2023-10-01T00:00:00.000000Z"
    }
    ```
  - **Possíveis Erros**:
    - `404 Not Found`: Usuário não encontrado.
    - `500 Internal Server Error`: Erro interno do servidor.

- **`PUT /api/users/{id}`** - Atualizar usuário

  - **Descrição**: Atualiza os dados de um usuário existente.
  - **Entrada (Todos campos são opcionais)**:
    ```json
    {
      "name": "Updated Name",
      "email": "updated@example.com",
      "password": "newpass123",
      "password_confirmation": "newpass123"
    }
    ```
  - **Saída**:
    ```json
    {
      "id": 1,
      "name": "Updated Name",
      "email": "updated@example.com",
      "created_at": "2023-10-01T00:00:00.000000Z",
      "updated_at": "2023-10-01T00:00:00.000000Z"
    }
    ```
  - **Possíveis Erros**:
    - `404 Not Found`: Usuário não encontrado.
    - `422 Unprocessable Entity`: Dados inválidos (ex.: email já existe).
    - `500 Internal Server Error`: Erro interno do servidor.

- **`DELETE /api/users/{id}`** - Deletar usuário

  - **Descrição**: Remove um usuário do sistema.
  - **Entrada**: Nenhuma (ID passado na URL).
  - **Saída**:
    ```json
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2023-10-01T00:00:00.000000Z",
      "updated_at": "2023-10-01T00:00:00.000000Z"
    }
    ```
  - **Possíveis Erros**:
    - `404 Not Found`: Usuário não encontrado.
    - `500 Internal Server Error`: Erro interno do servidor.

- **`GET /api/health`** - Health check

  - **Descrição**: Verifica se a API está funcionando corretamente.
  - **Entrada**: Nenhuma.
  - **Saída**:
    ```json
    {
      "status": "ok"
    }
    ```
  - **Possíveis Erros**:
    - `500 Internal Server Error`: Erro interno do servidor.

- **`GET /api/external`** - Proxy para microserviço
  - **Descrição**: Faz proxy para o microserviço Node.js.
  - **Entrada**: Nenhuma.
  - **Saída**:
    ```json
    {
      "message": "Hello from Node.js microservice!"
    }
    ```
  - **Possíveis Erros**:
    - `500 Internal Server Error`: Erro ao conectar com o microserviço.

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

- `GET /api/users` - Listar usuários
- `POST /api/users` - Criar usuário
- `GET /api/users/{id}` - Buscar usuário por ID
- `PUT /api/users/{id}` - Atualizar usuário
- `DELETE /api/users/{id}` - Deletar usuário
- `GET /api/health` - Health check
- `GET /api/external` - Proxy para microserviço

#### Microserviço Node.js (http://localhost:3000)

- `GET /` - Mensagem de status do serviço

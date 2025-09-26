# 🌐 Conecta Lá - Sistema de Teste

[![PHP](https://img.shields.io/badge/PHP-7.4.33-blue.svg)](https://php.net)
[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-3.1.13-red.svg)](https://codeigniter.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange.svg)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.0-purple.svg)](https://getbootstrap.com)
[![Docker](https://img.shields.io/badge/Docker-Ready-blue.svg)](https://docker.com)

> Sistema completo de teste desenvolvido com CodeIgniter 3, incluindo autenticação de usuários, API de clima integrada e interface moderna e responsiva.

## 📋 Visão Geral

O **Conecta Lá** é uma aplicação web completa que demonstra as melhores práticas de desenvolvimento com PHP e CodeIgniter 3. O sistema inclui:

- 🔐 **Autenticação completa** (registro, login, logout)
- 🌤️ **API de clima integrada** com wttr.in
- 🎨 **Interface moderna** com design clean e responsivo
- 📱 **Frontend responsivo** usando Bootstrap 5
- 🐳 **Containerização** com Docker
- 📚 **Documentação Swagger** automática
- 🔄 **Sistema de migrations** para banco de dados

## 🚀 Tecnologias Utilizadas

### Backend
- **PHP 7.4.33** - Linguagem principal
- **CodeIgniter 3.1.13** - Framework MVC
- **MySQL 8.0** - Banco de dados relacional
- **Composer** - Gerenciamento de dependências PHP

### Frontend
- **Bootstrap 5.3.0** - Framework CSS responsivo
- **Font Awesome 6.0.0** - Biblioteca de ícones
- **JavaScript ES6+** - Interatividade dinâmica
- **CSS3** - Estilização customizada com gradientes e animações

### Infraestrutura
- **Docker & Docker Compose** - Containerização
- **Apache 2.4** - Servidor web
- **phpMyAdmin** - Interface de administração do banco

### APIs Externas
- **wttr.in** - API de clima gratuita (sem chave necessária)
- **OpenAPI/Swagger** - Documentação automática da API

## 🏗️ Arquitetura

```
conecta-la/
├── application/           # Código da aplicação
│   ├── controllers/       # Controllers (Auth, Dashboard, Weather, etc.)
│   ├── models/           # Models (User_model, Weather_model)
│   ├── views/            # Views HTML com Bootstrap
│   ├── config/           # Configurações (database, routes, etc.)
│   └── libraries/        # Bibliotecas customizadas
├── system/               # Framework CodeIgniter
├── public/               # Assets estáticos
├── swagger/              # Documentação Swagger
├── docker/               # Configurações Docker
└── database.sql          # Schema inicial do banco
```

## 📦 Instalação e Configuração

### Pré-requisitos
- Docker e Docker Compose
- Git
- Navegador web moderno

### 1. Clone o Repositório
```bash
git clone <seu-repositorio>
cd conecta-la
```

### 2. Subir com Docker
```bash
docker-compose up --build -d
```

### 3. Acessar a Aplicação
- **Aplicação**: http://localhost:8080
- **Demonstração Online**: https://conectala.jeansilva.dev.br/
- **phpMyAdmin**: http://localhost:8081
- **Documentação Swagger**: http://localhost:8080/swagger/

### 4. Configurar Banco de Dados
O banco é criado automaticamente via Docker Compose. Para importar dados iniciais:

```bash
# Via phpMyAdmin (recomendado)
# Acesse http://localhost:8081
# Importe o arquivo database.sql
```

## 🎯 Funcionalidades

### 👤 Sistema de Usuários
- **Registro de usuários** com validação
- **Login/logout** com sessões seguras
- **Perfil do usuário** com edição
- **Dashboard personalizado**

### 🌤️ API de Clima
- **Busca em tempo real** por cidade
- **Armazenamento local** dos dados
- **Interface interativa** com toggle JSON
- **Cidades favoritas** pré-configuradas

### 🎨 Interface Moderna
- **Design clean** com cores sutis
- **Gradientes suaves** e sombras elegantes
- **Ícones Font Awesome** em todos os elementos
- **Responsividade total** (mobile-first)
- **Animações suaves** e transições

## 🛣️ Rotas da Aplicação

### Páginas Públicas
- `GET  /` - Homepage com apresentação do sistema
- `GET  /login` - Página de login
- `GET  /register` - Página de registro

### Área Logada (Requer Autenticação)
- `GET  /dashboard` - Dashboard principal com clima
- `GET  /profile` - Visualizar perfil
- `GET  /profile/edit` - Editar perfil

### API REST (JSON)
- `POST /auth/login` - Autenticação
- `POST /auth/register` - Registro de usuário
- `GET  /auth/logout` - Logout

- `GET  /weather/{city}` - Obter clima armazenado
- `POST /weather/fetch/{city}` - Buscar clima da API externa

- `GET  /users` - Listar usuários (admin)
- `POST /users` - Criar usuário
- `GET  /users/{id}` - Detalhes do usuário
- `PUT  /users/{id}` - Atualizar usuário
- `DELETE /users/{id}` - Remover usuário

### Sistema
- `GET  /migrate` - Executar migrations
- `GET  /docs` - Documentação Swagger

## 🎨 Design System

### Paleta de Cores
- **Primária**: `#3498db` (Azul médio)
- **Secundária**: `#2980b9` (Azul escuro)
- **Background**: Gradiente `#f8f9fa` → `#e9ecef`
- **Texto**: `#2c3e50` (Cinza escuro)
- **Acentos**: `#6c757d` (Cinza médio)

### Componentes
- **Cards**: Bordas arredondadas (12px), sombras suaves
- **Botões**: Gradientes sutis, hover effects
- **Formulários**: Input groups com ícones, validação visual
- **Navbar**: Design minimalista, navegação clara

### Tipografia
- **Fonte principal**: 'Segoe UI', sans-serif
- **Monospace**: Para código JSON
- **Tamanhos responsivos**: Mobile-first approach

## 🔧 Configurações

### Variáveis de Ambiente (.env)
```bash
# Banco de dados
DB_HOST=db
DB_USER=root
DB_PASS=example
DB_NAME=test_conectala

# API
API_KEY=sua-chave-secreta-aqui

# Clima (opcional)
WEATHER_API_KEY=sua-chave-openweathermap
```

### Arquivos de Configuração
- `application/config/config.php` - Configurações gerais
- `application/config/database.php` - Conexão banco
- `application/config/routes.php` - Definição de rotas
- `docker-compose.yml` - Orquestração de containers

## 🧪 Testando a Aplicação

### Fluxo Básico
1. **Acesse** http://localhost:8080
2. **Registre-se** ou faça login
3. **Explore o dashboard** e busque o clima
4. **Edite seu perfil** nas configurações

### Exemplos de API

```bash
# Registrar usuário
curl -X POST http://localhost:8080/index.php/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"João Silva","email":"joao@email.com","password":"senha123"}'

# Fazer login
curl -X POST http://localhost:8080/index.php/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"joao@email.com","password":"senha123"}'

# Buscar clima
curl -X POST http://localhost:8080/index.php/weather/fetch/Sao%20Paulo

# Obter clima armazenado
curl http://localhost:8080/index.php/weather/Sao%20Paulo
```

## 🔒 Segurança

- **Senhas hasheadas** com `password_hash()`
- **Validação de entrada** em todos os formulários
- **Prepared statements** nas consultas SQL
- **Sessões seguras** para autenticação
- **Headers CORS** configurados
- **API Key opcional** para proteção de endpoints

## 📊 Banco de Dados

### Tabelas Principais
- `users` - Usuários do sistema
- `weather` - Cache de dados climáticos
- `ci_sessions` - Sessões do CodeIgniter

### Migrations
```bash
# Executar migrations
docker-compose exec app php index.php migrate
```

## 🐳 Docker

### Containers
- **app**: Apache + PHP 7.4 + aplicação
- **db**: MySQL 8.0
- **phpmyadmin**: Interface web para MySQL

### Comandos Úteis
```bash
# Ver logs
docker-compose logs -f app

# Acessar container
docker-compose exec app bash

# Parar tudo
docker-compose down
```

## 📚 Documentação

- **Swagger UI**: http://localhost:8080/swagger/
- **OpenAPI Spec**: `/openapi.yaml`
- **Código**: Comentários em português

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch (`git checkout -b feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -am 'Adiciona nova funcionalidade'`)
4. Push para a branch (`git push origin feature/nova-funcionalidade`)
5. Abra um Pull Request

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para detalhes.

## 👥 Autor

**Conecta Lá Team**
- Sistema de teste desenvolvido para demonstração de tecnologias web modernas

---

⭐ **Dê uma estrela se este projeto te ajudou!**

📧 **Contato**: Para dúvidas ou sugestões, abra uma issue no repositório.
- Spec: `/docs/openapi.json`

## Exemplos (cURL)

```bash
# Listar
curl -s http://localhost/index.php/users | jq

# Criar
curl -s -X POST http://localhost/index.php/users \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{"name":"Alice","email":"alice@example.com","password":"secret123"}' | jq

# Detalhar
curl -s http://localhost/index.php/users/1 | jq

# Atualizar
curl -s -X PUT http://localhost/index.php/users/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{"name":"Alice Souza"}' | jq

# Deletar
curl -s -X DELETE http://localhost/index.php/users/1 \
  -H "Authorization: Bearer $TOKEN" | jq

# Registrar
curl -s -X POST http://localhost/index.php/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Bob","email":"bob@example.com","password":"secret456"}' | jq

# Login
TOKEN=$(curl -s -X POST http://localhost/index.php/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"bob@example.com","password":"secret456"}' | jq -r .token)
```

Observação: Se remover `index.php` da URL com rewrite, ajuste as URLs conforme a configuração do seu servidor.

## 🚀 Deploy / GitHub Actions

Este repositório inclui um workflow (`.github/workflows/deploy.yml`) e um script de deploy (`scripts/deploy.sh`) que automatizam o deploy via SSH no push para a branch `main`.

Secrets recomendados no GitHub (Settings > Secrets > Actions):

Como funciona:

1. Ao dar push em `main`, a Action faz checkout do código.
2. A Action copia `scripts/deploy.sh` para o servidor via `scp` (usa `SSH_PRIVATE_KEY` quando disponível, ou `sshpass` com `SERVER_PASSWORD`).
3. A Action executa o script remoto que faz `git reset --hard origin/main`, ajusta os mapeamentos de portas no `docker-compose.yml` (substitui `8080:80` e `8082:80` pelos valores informados) e roda `docker compose up -d --build`.

Observações e segurança:
- Preferível usar `SSH_PRIVATE_KEY` em vez de senha.
- O script faz alterações simples no `docker-compose.yml` e cria um backup `docker-compose.yml.bak` antes.
- Ajuste `scripts/deploy.sh` conforme sua topologia (por exemplo, se usa docker swarm, traefik, ou outras portas).

Nota: neste servidor usamos `nginx` como proxy reverso para rotear domínios/ports para os containers. O deploy altera os mapeamentos de porta do compose para evitar conflitos com containers existentes (por exemplo, usa `8020` em vez de `8080`). Se você administra um Nginx externo, ajuste as regras de proxy/reverse proxy para apontar para as portas escolhidas.

Para disparar manualmente, faça um commit na `main` ou abra um pull request que seja merged em `main`.


## Segurança e Boas Práticas

- Senhas armazenadas com `password_hash`.
- Validação de entrada usando `form_validation` (com mensagens 422 em erros).
- Consultas via Query Builder (prepared statements).
- Cabeçalhos CORS básicos incluídos (ajuste para produção).
- `API_KEY` opcional para operações de escrita.

## Estrutura principal

- `application/controllers/Users.php` — Controller REST (JSON, validação, erros)
- `application/models/User_model.php` — Acesso ao banco (CRUD)
- `application/config/routes.php` — Rotas `/users`
- `application/config/api.php` — Chave de API
- `database.sql` — Esquema MySQL

## Executando localmente

Você pode usar o servidor embutido do PHP (apenas para desenvolvimento):

```bash
php -S 0.0.0.0:8000 -t .
# Acesse: http://localhost:8000/index.php/users
```

## Executando com Docker (recomendado)

O projeto inclui um `Dockerfile` e `docker-compose.yml` para subir o app, MySQL e phpMyAdmin.

1. Edite `docker-compose.yml` se quiser alterar credenciais (padrão `root:example`).
2. Suba os containers:

```bash
docker-compose up --build -d
```

3. Acesse a aplicação em `http://localhost:8080/` e o phpMyAdmin em `http://localhost:8081/`.

4. Importe o schema `database.sql` no phpMyAdmin ou rode um script SQL para criar as tabelas.

Variáveis úteis (em `.env` ou export):
- DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT
- API_KEY — chave para proteger endpoints de escrita
- WEATHER_API_KEY — chave da API externa de clima (ex.: OpenWeatherMap)

Observação: se `WEATHER_API_KEY` não estiver configurada o sistema usará `wttr.in` (sem necessidade de chave) para buscas de clima. Se desejar usar OpenWeatherMap defina `WEATHER_API_KEY`.

## Documentação Swagger / OpenAPI

Abra `http://localhost:8080/swagger/` para ver a documentação interativa. O arquivo OpenAPI está em `openapi.yaml`.

## Integração com API externa de clima (exemplo)

Implementação adicionada:
- `application/controllers/Weather.php` — endpoints `GET /weather/{city}` e `POST /weather/fetch/{city}` (fetch imediato)
- `application/models/Weather_model.php` — armazenamento em tabela `weather`

Fluxo recomendado para integrar uma API externa de clima:

1. Registrar-se no provedor (ex.: OpenWeatherMap) e obter `WEATHER_API_KEY`.
2. Implementar chamada HTTP segura (timeout, retry limitado), validar status e conteúdo JSON.
3. Mapear os campos necessários (temperatura, descrição, etc.) e armazenar em tabela local com timestamp.
4. Defender endpoint de escrita (fetch) com `API_KEY` para evitar uso indevido.
5. Agendar atualizações periódicas via cron (dentro do container ou host). No Docker, pode-se adicionar um container `cron` que executa `curl -s -H "X-API-Key: $API_KEY" http://app:80/index.php/weather/fetch/Sao%20Paulo` a cada N minutos.

Exemplo: buscar e armazenar o clima de "São Paulo":

```bash
# trigger manual (requere API_KEY header se configurado)
curl -X POST "http://localhost:8080/index.php/weather/fetch/Sao%20Paulo" -H "X-API-Key: $API_KEY"

# ler dados armazenados
curl "http://localhost:8080/index.php/weather/Sao%20Paulo" | jq
```

## 🔒 Segurança

- **Senhas hasheadas** com `password_hash()`
- **Validação de entrada** em todos os formulários
- **Prepared statements** nas consultas SQL
- **Sessões seguras** para autenticação
- **Headers CORS** configurados
- **API Key opcional** para proteção de endpoints

## 📊 Banco de Dados

### Tabelas Principais
- `users` - Usuários do sistema
- `weather` - Cache de dados climáticos
- `ci_sessions` - Sessões do CodeIgniter

### Migrations
```bash
# Executar migrations
docker-compose exec app php index.php migrate
```

## 🐳 Docker

### Containers
- **app**: Apache + PHP 7.4 + aplicação
- **db**: MySQL 8.0
- **phpmyadmin**: Interface web para MySQL

### Comandos Úteis
```bash
# Ver logs
docker-compose logs -f app

# Acessar container
docker-compose exec app bash

# Parar tudo
docker-compose down
```

## 📚 Documentação

- **Swagger UI**: http://localhost:8080/swagger/
- **OpenAPI Spec**: `/openapi.yaml`
- **Código**: Comentários em português

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch (`git checkout -b feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -am 'Adiciona nova funcionalidade'`)
4. Push para a branch (`git push origin feature/nova-funcionalidade`)
5. Abra um Pull Request

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para detalhes.

## 👥 Autor

**Jean A. Silva**
- https://jeansilva.dev.br
- Sistema de teste desenvolvido para demonstração de tecnologias web modernas

---

⭐ **Dê uma estrela se este projeto te ajudou!**

📧 **Contato**: Para dúvidas ou sugestões, abra uma issue no repositório.

# Projeto Yii2 Framework Teste

Este repositório contém o código para um teste de desenvolvimento utilizando o Yii2 Framework, configurado para funcionar dentro de containers Docker.

## Requisitos Obrigatórios

- PHP 7.1
- Composer versão 1.10
- MySQL 8
- Uso de JSON para o corpo na API

## Requisitos Desejáveis

- Uso de Docker para execução
- Dockerfile incluindo todas as dependências necessárias
- Estruturação do código com boas práticas
- Uso de conceitos atuais de desenvolvimento
- Projeto disponibilizado em repositório Git
- Uso de migrations do Yii2 para configuração da base de dados

## Configuração e Execução

### Primeiro acesso e construção do ambiente
Para construir e subir o ambiente pela primeira vez, execute:

```bash
docker compose up --build -d
```

### Subir o ambiente Docker
Para subir o ambiente sem reconstruir:

```bash
docker compose up -d
```

### Desligar o ambiente Docker
Para desligar o ambiente:

```bash
docker compose down
```

### Executar Migrations
Para rodar as migrations e configurar o banco de dados:

```bash
docker exec -it yii2-framework-web-1 php /var/www/html/yii migrate --interactive=0
```

### Criar Usuário via Terminal
Após executar as migrations, é possível criar um usuário através do terminal para acessar as funcionalidades da API que requerem autenticação. Utilize o seguinte comando para criar um novo usuário:

```bash
docker exec -it yii2-framework-web-1 php /var/www/html/yii user/create <username> <password> "<name>"
```

## Uso da API
A API pode ser acessada através do seguinte link de collection do Postman, que inclui exemplos de requisições para todas as funcionalidades implementadas:

[Collection do Postman](https://www.postman.com/tiagoluvizotoneves/workspace/yii2-framework-test-1/overview)

Este link inclui todos os detalhes necessários para testar as funcionalidades da API, incluindo a autenticação e criação de usuários.

## Funcionalidades Implementadas

### Autenticação
- **Endpoint:** `POST /auth/login`
- **Descrição:** Autentica o usuário e retorna um token JWT para acesso às APIs protegidas.
- **Parâmetros:**
  - `username`: usuário gerado via terminal
  - `password`: Senha do usuário gerada via terminal

### Cadastro de Cliente Básico
- **Endpoint:** `POST /clients`
- **Descrição:** Cadastra um novo cliente no sistema com validação de CPF e dados de endereço.
- **Parâmetros:**
  - `name`: Nome do cliente
  - `cpf`: CPF do cliente
  - `cep`: CEP do endereço
  - `street`: Logradouro
  - `number`: Número da residência
  - `city`: Cidade
  - `state`: Estado
  - `complement`: Complemento (opcional)
  - `gender`: Sexo (M ou F)
  - `photo`: Foto do cliente (opcional, arquivo de imagem)

### Lista de Clientes
- **Endpoint:** `GET /clients/page`
- **Descrição:** Lista os clientes cadastrados com suporte a paginação.
- **Parâmetros de Query:**
  - `page`: Número da página para paginação

### Cadastro de Produto
- **Endpoint:** `POST /products`
- **Descrição:** Cadastra um novo produto associado a um cliente existente.
- **Parâmetros:**
  - `name`: Nome do produto
  - `price`: Preço do produto
  - `client_id`: ID do cliente detentor do produto
  - `photo`: Foto do produto (opcional, arquivo de imagem)

### Lista de Produtos
- **Endpoint:** `GET /products`
- **Descrição:** Lista os produtos cadastrados com suporte a paginação e filtro por cliente.
- **Parâmetros de Query:**
  - `page`: Número da página para paginação
  - `client_id`: ID do cliente para filtrar os produtos

## Desenvolvimento

Este projeto foi desenvolvido seguindo as melhores práticas atuais de desenvolvimento de software, utilizando o framework Yii2 para garantir uma estrutura robusta e escalável.

## Contribuição
Contribuições para o projeto são bem-vindas. Para contribuir, por favor, clone o repositório, faça suas alterações e submeta um pull request.

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

## Funcionalidades Implementadas

1. **Autenticação por credencial (usuário/senha) com retorno de token (Bearer)**
   - A autenticação é feita através da API e retorna um token JWT para ser usado nas demais requisições que exigem autenticação.

2. **Criação de usuário via comando de terminal**
   - Possibilidade de criar um usuário diretamente via terminal, informando login, senha e nome.

## Configuração e Execução

### Primeiro acesso e construção do ambiente
Para construir e subir o ambiente pela primeira vez, execute:

- docker compose up --build -d

### Subir o ambiente Docker
Para subir o ambiente sem reconstruir

- docker compose up -d

### Desligar o ambiente Docker
Para desligar o ambiente:

- docker compose down

### Executar Migrations
Para rodar as migrations e configurar o banco de dados:

- docker exec -it yii2-framework-web-1 php /var/www/html/yii migrate --interactive=0

## Uso da API
A API pode ser acessada através do seguinte link de collection do Postman, que inclui exemplos de requisições para todas as funcionalidades implementadas:

[Postman Collection](https://www.postman.com/tiagoluvizotoneves/workspace/yii2-framework-test-1/overview)

Este link inclui todos os detalhes necessários para testar as funcionalidades da API, incluindo a autenticação e criação de usuários.

## Desenvolvimento

Este projeto foi desenvolvido seguindo as melhores práticas atuais de desenvolvimento de software, utilizando o framework Yii2 para garantir uma estrutura robusta e escalável.

## Contribuição
Contribuições para o projeto são bem-vindas. Para contribuir, por favor, clone o repositório, faça suas alterações e submeta um pull request.

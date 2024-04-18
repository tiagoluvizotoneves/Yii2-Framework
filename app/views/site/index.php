<?php

/** @var yii\web\View $this */

$this->title = 'Teste de CRUD';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1>Projeto Yii2 Framework Teste</h1>
        <p>Este repositório contém o código para um teste de desenvolvimento utilizando o Yii2 Framework, configurado para funcionar dentro de containers Docker.</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
            <h2>Requisitos Obrigatórios</h2>
            <ul>
                <li>PHP 7.1</li>
                <li>Composer versão 1.10</li>
                <li>MySQL 8</li>
                <li>Uso de JSON para o corpo na API</li>
            </ul>

            <h2>Requisitos Desejáveis</h2>
            <ul>
                <li>Uso de Docker para execução</li>
                <li>Dockerfile incluindo todas as dependências necessárias</li>
                <li>Estruturação do código com boas práticas</li>
                <li>Uso de conceitos atuais de desenvolvimento</li>
                <li>Projeto disponibilizado em repositório Git</li>
                <li>Uso de migrations do Yii2 para configuração da base de dados</li>
            </ul>

            <h2>Configuração e Execução</h2>
            <h3>Primeiro acesso e construção do ambiente</h3>
            <pre><code>docker compose up --build -d</code></pre>

            <h3>Subir o ambiente Docker</h3>
            <pre><code>docker compose up -d</code></pre>

            <h3>Desligar o ambiente Docker</h3>
            <pre><code>docker compose down</code></pre>

            <h3>Executar Migrations</h3>
            <pre><code>docker exec -it yii2-framework-web-1 php /var/www/html/yii migrate --interactive=0</code></pre>

            <h3>Criar Usuário via Terminal</h3>
            <pre><code>docker exec -it yii2-framework-web-1 php /var/www/html/yii user/create username password "name"</code></pre>

            <h2>Uso da API</h2>
            <p>A API pode ser acessada através do seguinte link de collection do Postman, que inclui exemplos de requisições para todas as funcionalidades implementadas:</p>
            <p><a href="https://www.postman.com/tiagoluvizotoneves/workspace/yii2-framework-test-1/overview" target="_blank">https://www.postman.com/tiagoluvizotoneves/workspace/yii2-framework-test-1/overview</a></p>

            <h2>Funcionalidades Implementadas</h2>
            <h3>Autenticação</h3>
            <p><strong>Endpoint:</strong> <code>POST /auth/login</code></p>
            <p><strong>Descrição:</strong> Autentica o usuário e retorna um token JWT para acesso às APIs protegidas.</p>

            <h3>Cadastro de Cliente Básico</h3>
            <p><strong>Endpoint:</strong> <code>POST /clients</code></p>
            <p><strong>Descrição:</strong> Cadastra um novo cliente no sistema com validação de CPF e dados de endereço.</p>

            <h3>Lista de Clientes</h3>
            <p><strong>Endpoint:</strong> <code>GET /clients/page</code></p>
            <p><strong>Descrição:</strong> Lista os clientes cadastrados com suporte a paginação.</p>

            <h3>Lista de Produtos</h3>
            <p><strong>Endpoint:</strong> <code>GET /products</code></p>
            <p><strong>Descrição:</strong> Lista os produtos cadastrados com suporte a paginação e filtro por cliente.</p>

            <h2>Desenvolvimento</h2>
            <p>Este projeto foi desenvolvido seguindo as melhores práticas atuais de desenvolvimento de software, utilizando o framework Yii2 para garantir uma estrutura robusta e escalável.</p>

            <h2>Contribuição</h2>
            <p>Contribuições para o projeto são bem-vindas. Para contribuir, por favor, clone o repositório, faça suas alterações e submeta um pull request.</p>


            </div>
        </div>

    </div>
</div>

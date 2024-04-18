#!/bin/bash
set -e

# Função para aguardar o MySQL estar pronto
wait_for_mysql() {
    echo "Aguardando MySQL..."
    while ! mysqladmin ping -h db --silent; do
        sleep 1
        echo "Aguardando pelo MySQL..."
    done
    echo "MySQL está pronto."
}

# Executa a função
wait_for_mysql

# Aplica as migrations
echo "Aplicando migrations..."
php yii migrate --interactive=0

# Inicia o servidor web PHP
echo "Iniciando o servidor web..."
php -S 0.0.0.0:80 -t /var/www/html/web

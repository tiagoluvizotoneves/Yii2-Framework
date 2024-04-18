# Escolha da imagem base
FROM php:7.1-fpm

# Instalação de pacotes necessários
RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
        git \
        unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalação do Composer na versão específica
RUN curl -o composer-setup.php https://getcomposer.org/installer \
    && php composer-setup.php --version=1.10.22 --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Configuração do diretório de trabalho
WORKDIR /var/www/html

# Instalação do Yii2 Framework utilizando o Composer
RUN composer create-project --prefer-dist yiisoft/yii2-app-basic . && \
    ls -la /var/www/html/  

# Adicionar a dependência do Yii2 JWT
RUN composer require sizeg/yii2-jwt

# Criação dos diretórios necessários e ajuste das permissões
RUN mkdir -p runtime web/assets && chmod -R 777 runtime web/assets

# Expondo a porta 80
EXPOSE 80

# Comando para iniciar o servidor web embutido do PHP na porta 80
CMD php -S 0.0.0.0:80 -t /var/www/html/web
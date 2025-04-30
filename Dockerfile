FROM php:8.0-apache

# 安裝 mysqli（PHP 與 MySQL 連線的擴充）
RUN docker-php-ext-install mysqli

# 將你的 PHP 程式碼複製進容器
COPY . /var/www/html/

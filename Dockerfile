FROM yiisoftware/yii2-php:7.4-apache

WORKDIR /app

# Change document root for Apache
RUN sed -i -e 's|/app/web|/app/web|g' /etc/apache2/sites-available/000-default.conf


CMD sh commands.sh

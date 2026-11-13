FROM php:7.3-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
	&& sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Fix archived Debian Buster repositories for PHP 7.3
RUN sed -i 's|http://debian.org|http://debian.org|g' /etc/apt/sources.list \
	&& sed -i '/security.debian.org/d' /etc/apt/sources.list \
	&& apt-get update && apt-get install -y --no-install-recommends \
	libzip-dev \
	zip \
	unzip \
	&& docker-php-ext-install -j$(nproc) mysqli zip \
	&& a2enmod rewrite \
	&& sed -i '/<Directory \${APACHE_DOCUMENT_ROOT}>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
	&& apt-get clean \
	&& rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

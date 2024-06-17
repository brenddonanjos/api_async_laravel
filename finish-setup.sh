# Entra no container php-fpm e executa o composer install caso a pasta vendor não exista
# Define as permissões necessárias para as pastas storage e bootstrap/cache
# roda as migrations
docker exec php-fpm bash -c "cd /var/www && \
    if [ ! -d 'vendor' ]; then \
        composer install --no-interaction --prefer-dist --optimize-autoloader; \
    else \
        echo 'Vendor directory already exists. Skipping composer install.'; \
    fi && \
    chmod -R 777 storage bootstrap/cache"

# Entra no container do nginx e define as permissões necessárias para as pastas storage e bootstrap/cache
docker exec nginx bash -c "cd /var/www && \
    chmod -R 777 storage bootstrap/cache"

echo "Setup completed successfully."
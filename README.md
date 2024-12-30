# Backend Ecommerce

Este proyecto es una aplicación de comercio electrónico construida con Laravel 8 y dockerizada para facilitar su despliegue y desarrollo.

## Requisitos Previos

Antes de comenzar con la instalación, asegúrate de tener instalados los siguientes requisitos:

- Docker
- Docker Compose
- Git

## Instalación

Sigue estos pasos para instalar y configurar el proyecto:

1. Clona el repositorio:

    ```bash
    git clone https://github.com/tu-usuario/Backend-Ecommerce.git
    cd Backend-Ecommerce
    ```

2. Copia el archivo de entorno:

    ```bash
    cp .env.example .env
    ```

3. Construye y levanta los contenedores de Docker:

    ```bash
    docker-compose up -d --build
    ```

4. Instala las dependencias de Composer:

    ```bash
    docker-compose exec app composer install
    ```

5. Genera la clave de la aplicación:

    ```bash
    docker-compose exec app php artisan key:generate
    ```
6. Enlazar el almacenamiento público, ejecuta el siguiente comando:

    ```bash
    docker-compose exec app php artisan storage:link
    ```

7. Ejecuta las migraciones y los seeders:

    ```bash
    docker-compose exec app php artisan migrate --seed
    ```


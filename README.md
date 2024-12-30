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

2. Copia el archivo de entorno (dentro de la carpeta src):

    ```bash
    cp .env.example .env
    ```

3. Construye y levanta los contenedores de Docker (Asegurarse que se este ejecutando docker):

    ```bash
    docker-compose up -d --build
    ```

4. Ingresa al contenedor del proyecto (Asegurarse que el contenedor este en ejecucion):

    ```bash
    docker exec -it backend-ecommerce bash
    ```

5. Instala las dependencias de Composer:

    ```bash
    composer install
    ```

6. Genera la clave de la aplicación:

    ```bash
    php artisan key:generate
    ```
7. Enlazar el almacenamiento público, ejecuta el siguiente comando:

    ```bash
    php artisan storage:link
    ```

7. Ejecuta las migraciones y los seeders:

    ```bash
    php artisan migrate --seed
    ```

8. Ejecutar comando creado para obtener productos desde api externa (Opcional):

    ```bash
    php artisan fetch:products
    ```

9. Y por ultimo se debe ejecutar el proyecto:

    ```bash
    php artisan serve --host=0.0.0.0 --port=8000
    ```

## Usuario para pruebas

El siguiente es el usuario por defecto para realizar pruebas en el proyecto:

- **Email:** admin@example.com
- **Contraseña:** admin

## Acceso a la documentación de Swagger

Este es el enlace a la documentación de las APIs con Swagger. Ten en cuenta que no están todos los endpoints documentados:

http://localhost:8000/api/documentation

## Colección de Postman

Para probar los endpoints, descarga e importa la colección de Postman desde el siguiente enlace:

https://drive.google.com/file/d/1Z7hFhWvppHxECvto7az1R084afDQtZJx/view?usp=sharing

Asegúrate de revisar la documentación de cada endpoint para entender su funcionamiento y los parámetros necesarios.
# Proyecto Laravel con Vue (appWeb)

Este proyecto utiliza Laravel como backend y Vue.js como frontend. A continuación, se detallan los pasos para iniciar el proyecto.

## Requisitos previos

- PHP >= 8.0
- Composer
- Node.js >= 14.x
- NPM o Yarn
- MySQL o cualquier base de datos compatible con Laravel

## Instalación

1. Clona el repositorio:
    ```bash
    git clone https://github.com/cristaalm/appWeb.git
    cd appWeb
    ```

2. Instala las dependencias de PHP:
    ```bash
    composer install
    ```

3. Instala las dependencias de Node.js:
    ```bash
    npm install
    # o si usas Yarn
    yarn install
    ```

4. Configura el archivo `.env`:
    - Copia el archivo de ejemplo:
      ```bash
      cp .env.example .env
      ```
    - Configura las variables de entorno, como la conexión a la base de datos.

5. Genera la clave de la aplicación:
    ```bash
    php artisan key:generate
    ```

6. Ejecuta las migraciones:
    ```bash
    php artisan migrate
    ```

## Ejecución del proyecto

1. Inicia el servidor de desarrollo de Laravel:
    ```bash
    php artisan serve
    ```

2. Compila los assets de Vue.js:
    ```bash
    npm run dev
    # o si usas Yarn
    yarn dev
    ```

3. Accede al proyecto en tu navegador en [http://localhost:8000](http://localhost:8000).

## Comandos útiles

- Compilar assets para producción:
  ```bash
  npm run build
  # o si usas Yarn
  yarn build
  ```

- Ejecutar pruebas:
  ```bash
  php artisan test
  ```

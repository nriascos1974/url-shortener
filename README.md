## About Proyect Backend Url Shortener

Este proyecto contiene 4 APIs, con el CRD para la creacion, Consulta y Eliminacion de URLs cortas.
para poder ejecutarlo localmente, siga los pasos descritos a continuacion:

1. Descargar el Proyecto:
   Clona el repositorio.

2. Instalar Dependencias: 
    abre una terminal y asegurate que este posicionado en la ruta del proyecto y ejecuta: composer install

3. Configurar el Entorno:
   Copia el archivo .env.example a un nuevo archivo llamado .env: Luego, configura los parámetros del archivo .env según tu entorno para configurar la conexion a base de datos.
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nombre_de_base_de_datos
   DB_USERNAME=usuario
   DB_PASSWORD=contraseña

4. Generar la Clave de Aplicación:
   Genera esta clave ejecutando: php artisan key:generate


5. Ejecutar Migraciones:
   ejecuta: php artisan migrate

6. Iniciar el Servidor de Desarrollo: 
   ejecuta: php artisan serve. Esto levantará el servidor en http://localhost:8000 por defecto. Si todo esta bien al suvir el servidor e ingresar la URL anterior te abrira una pagina de LARAVEL.

7. Documentacion de las Rutas
   http://localhost:8000/api/documentation


NOTA: Para testear las 4 rutas del backend ejecta: php artisan test.

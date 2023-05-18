# API de almacenamiento de imágenes

Esta API está construida en Laravel y permite guardar imágenes en un servidor web, borrar imagenes, actualizar las imagenes o el nombre y obtener las imagenes. Esto se hace por medio de cuatro endopoint.
Antes de guardar las imágenes, se convierten a webp para que sean usadas en la web y se hace utilizando la librería "intervention/image", y la extensión de PHP "imagick". Para asegurar la seguridad de la API, todos los endpoint estan protegido con la librería Sanctum y se requiere un token de autenticación generado en otra API para poder acceder.

## Instalación

Para instalar y utilizar esta API, se requiere lo siguiente:

- PHP >= 7.3
- Composer
- Servidor web (por ejemplo, Apache o Nginx)
- Imagick

1. Clona el repositorio en tu servidor web:

        git clone https://github.com/LuiferEduardoo/image-storage.git
        
        
2. Instala las dependencias del proyecto utilizando Composer:

        cd tu-repositorio
        composer install


3. Crea un archivo .env a partir del archivo .env.example y configura las variables de entorno necesarias:

        cp .env.example .env

4. Genera una clave de aplicación:

        php artisan key:generate


5. Configura tu base de datos en el archivo .env y ejecuta las migraciones para crear las tablas de la base de datos:

        php artisan migrate


## Endpoints

### /images
- Método: GET
- Descripción: Obtiene la lista de imagenes registrados en el sistema.
- Query Parameters:
  - id (opcional): Permite obtener una imagen por su id.
- Respuestas:
  - Código de estado 200: Lista de imagenes en formato JSON.
  - Código de estado 404: Imagen no encontrada.
  - Código de estado 500: Error a la hora de obtener la imagen.

### /images/create
- Método: POST
- Descripción: Subir una imagen.
- Query Parameters:
  - folder (obligatorio): Permite saber en que lugar sera guardado la imagen.
- Respuestas:
  - Código de estado 200: Un mensaje de exito y la información de la imagen en formato JSON.
  - Código de estado 400: Archivo invalido.
  - Código de estado 500: Error a la hora de subir la imagen.

### /images
- Método: DELETE
- Descripción: Borrar una imagen.
- Query Parameters:
  - id (obligatorio): Permite obtener la imagen que se quiere borrar.
- Respuestas:
  - Código de estado 200: Un mensaje que indica que la imagen fue borrada.
  - Código de estado 404: Imagen no encontrada.
  - Código de estado 500: Error a la hora de borrar la imagen.

### /images/{id}
- Método: PATCH
- Descripción: Actualizar la imagen o su nombre.
- Parámetros:
  - id (path): Permite saber cual imagen se va actualizar.
- Respuestas:
  - Código de estado 200: Un mensaje que indica que la imagen fue borrada.
  - Código de estado 409: El nombre ya existe.
  - Código de estado 500: Error a la hora de cambiar el nombre de la imagen o la imagen.

# ¿Cómo contribuyo?  

En el caso que tú quieras contribuir a mejor esta API, me parece genial. Simplemente debes realizar los siguientes pasos: 

1. Haz un fork del repositorio.
2. Crea una rama para tu contribución: 

        git checkout -b mi-contribucion
4. Haz tus cambios y commitea tus cambios: 

        git commit -am 'Agregué una nueva característica'
6. Hacer push a la rama 

        git push origin mi-contribucion
8. Crea un pull request.


# Licencia

Esta API está disponible bajo la licencia MIT. Ver el archivo LICENSE para más información.


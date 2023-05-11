# API de almacenamiento de imágenes

Esta API está construida en Laravel y permite guardar imágenes en un servidor web. Antes de guardar las imágenes, se convierten a webp para que sean usadas en la web y se hace utilizando la librería Spatie/Image. Cuando se realiza una solicitud POST, la API devuelve un mensaje que indica si la solicitud fue exitosa y la URL de la imagen. Además, para asegurar la seguridad de la API, el endpoint /create/{folder} está protegido con la librería Sanctum y se requiere un token de autenticación generado en otra API para poder acceder.

## Instalación

Para instalar y utilizar esta API, se requiere lo siguiente:

- PHP >= 7.3
- Composer
- Servidor web (por ejemplo, Apache o Nginx)

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

# Uso 

Para usar esta API, primero debes generar un token en otro API y usar la misma tabla de la base de datos.
Las solictudes a la base de datos va hacer por el endpoint "/create/{folder}" y van a tener los siguientes parametros:  
- Imagen: Va a tener el archivo tipo imagen que se piensa subir. 
- Folder: El nombre de la carpeta donde se piensa guardar la imagen. 

Luego que se pasa estos parametros, la API procesará la imagen, la convertira a webp y la guardará en la carpeta proporcionada. Y dicha solicitud es exitosa devolverá un mensaje de éxito junto cn la URL de la imagen. 

# Ejemplo de solicitud

        curl -X POST \
        http://localhost:8000/create/images \
        -H 'Authorization: Bearer {your_token_here}' \
        -H 'Content-Type: multipart/form-data' \
        -F 'image=@/path/to/your/image.jpg'


# Respuesta favorable de la API 

        {
            "success": true,
            "message": "Image uploaded successfully",
            "url": "http://localhost:8000/storage/images/image.webp"
        }


# ¿Cómo contribuyo?  

En el caso que tú quieras contribuir a mejor esta API, me parece genial. Simplemente debes realizar los siguientes pasos: 

    1. Haz un fork del repositorio.
    2. Crea una rama para tu contribución (git checkout -b mi-contribucion).
    3. Haz tus cambios y commitea tus cambios (git commit -am 'Agregué una nueva característica').
    4. Hacer push a la rama (git push origin mi-contribucion).
    5. Crea un pull request.


# Licencia

Esta API está disponible bajo la licencia MIT. Ver el archivo LICENSE para más información.


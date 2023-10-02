
# TFG José Antonio Lorenzo López
#### !Actualmende no está disponible el servidor
## Índice
- Instalación
- Donde encontrar la documentación
- Endpoints
- Enlace al despliegue
- Licencia del proyecto
---
## Instalación
1. Clonar el repositorio desde el repositorio remoto en tu máquina local.

2. Asegúrate de tener Docker y Docker Compose instalados. Si estás utilizando macOS o Windows, puedes descargar Docker Desktop, y en el caso de Windows, asegúrate de tener WSL2 instalado. Si estás en Linux, sigue las instrucciones específicas para tu distribución.


3. Crea un archivo .env a partir del archivo .env.example proporcionado. Asegúrate de no cambiar ninguna variable en este momento. 

4. Crea un alias para simplificar los comandos utilizando el siguiente comando:
`$ alias sail='[-f sail] && sh sail || sh vendor/bin/sail'`

5. Levanta el proyecto utilizando el siguiente comando:
`$ sail up -d`


6. Genera la clave del servidor con el siguiente comando:
`$ sail artisan key:generate`

7. Instala las dependencias del proyecto utilizando el siguiente comando:
`$ sail composer install`

8. Realiza la migración de las tablas y los datos en la base de datos con el siguiente comando:
`$ sail artisan migrate --seed`

Y ya podríamos acceder mediante el localhost a:
- laravel localhost:80
- Frontend localhost:8000    
- phpmyadmin localhost:8080
+ credenciales: Servidor: mysql, Usuario: sail, Password: password**

---
## Donde encontrar la documentacion
La documentación esta en la carpeta documentación, ahí se encuentra tanto el archivo de insomnia con las peticiones como la carpeta para ver las solicitudes en modo open api (menos recomendable) usando npx serve, recomiendo importar el archivo insomnia.json dentro de insomnia

---
## Enlace al despliegue
https://precious-truffle-6b69ae.netlify.app/

---
## EndPoints 
|Método|Ruta|Descripción|
|---|---|---|
|GET|/user|Obtiene los datos del usuario autenticado|
|POST|/register|Registra un nuevo usuario|
|POST|/login|Inicia sesión de un usuario|
|GET|/logout|Cierra sesión de un usuario|
|GET|/genres|Obtiene todos los géneros|
|GET|/genre/{id}|Obtiene un género por su ID|
|POST|/genre|Crea un nuevo género|
|DELETE|/genre/{id}|Elimina un género por su ID|
|PUT|/genre/{id}|Actualiza un género por su ID|
|GET|/songs|Obtiene todas las canciones|
|GET|/song/{id}|Obtiene una canción por su ID|
|GET|/songs/genre/{id}|Obtiene canciones por ID de género|
|GET|/songs/artist/{id}|Obtiene canciones por ID de artista|
|POST|/song|Crea una nueva canción|
|DELETE|/song/{id}|Elimina una canción por su ID|
|PUT|/song/{id}|Actualiza una canción por su ID|
|GET|/artists|Obtiene todos los artistas|
|GET|/artist/{id}|Obtiene un artista por su ID|
|POST|/artist|Crea un nuevo artista|
|DELETE|/artist/{id}|Elimina un artista por su ID|
|PUT|/artist/{id}|Actualiza un artista por su ID|
|GET|/playlists|Obtiene todas las listas de reproducción|
|POST|/playlist|Crea una nueva lista de reproducción|
|DELETE|/playlist/{id}|Elimina una lista de reproducción por su ID|
|POST|/playlist/{id}/song|Agrega una canción a una lista de reproducción por su ID|
|DELETE|/playlist/{id}/song|Elimina una canción de una lista de reproducción por su ID|
|PUT|/playlist/{id}|Cambia el nombre de una lista de reproducción por su ID|
|GET|/favorites|Obtiene los favoritos del usuario autenticado|
|POST|/favorite/{id}|Crea un nuevo favorito por su ID|
|DELETE|/favorite/{id}|Elimina un favorito por su ID|

---
## Licencia del proyecto
 CC0 1.0 Universal (CC0 1.0)

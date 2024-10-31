# Tienda Vintage

## Descripción del Proyecto
"Tienda Vintage" es una tienda en línea que permite a los usuarios explorar una variedad de productos, filtrarlos por categorías y rangos de precio, realizar búsquedas personalizadas, y completar compras de forma fácil y rápida. El sistema incluye autenticación de usuarios, una página de confirmación de compra y un historial de ventas.

## Tecnologías Utilizadas
- PHP 
- MySQL
- HTML/CSS
- XAMPP (para el servidor local y base de datos)

## Requisitos
Para ejecutar este proyecto en tu entorno local, necesitas tener instalado XAMPP

## Instrucciones de Instalación

### 1. Configuración del Entorno
1. Descarga e instala [XAMPP].
2. Inicia XAMPP y asegúrate de que los servicios de **Apache** y **MySQL** están activos.

### 2. Configuración de la Base de Datos
1. Abre el navegador y dirígete a [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
2. Crea una nueva base de datos llamada `tienda_vintage`.
3. Importa el archivo `tienda_vintage.sql` (si existe un archivo SQL en tu proyecto que contiene las tablas) en esta base de datos. Puedes hacerlo seleccionando la base de datos y luego usando la opción **Importar** en PHPMyAdmin.
4. Asegúrate de que las tablas `productos`, `usuarios` y `ventas` están creadas correctamente en la base de datos siguiendo la estructura descrita anteriormente.

### 3. Configuración del Proyecto en XAMPP
1. Descarga o clona el repositorio del proyecto en tu computadora.
2. Copia la carpeta del proyecto en el directorio `htdocs` de XAMPP. (En mi caso esta ubicado en "C:\xampp\htdocs")
3. Abre el archivo `db.php` en el directorio del proyecto y asegúrate de que la configuración de conexión a la base de datos sea correcta:

<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "tienda_vintage";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

### 4. Ejecutar el Proyecto
1. Abre tu navegador web.
2. Dirígete a la URL: http://localhost/tienda_vintage/login/.
3. Deberías ver la página de ingreso.

## Uso del Proyecto
Inicio de Sesión: Utiliza la página de inicio de sesión para autenticarte. Ingresa con un usuario existente en la tabla usuarios de la base de datos.
En caso que no existan usuarios Utilizar la siguiente consulta SQL para crear uno:

INSERT INTO usuarios (nombre_cliente, correo, dirección, contraseña) 
VALUES ('josefa', 'josefa@gmail.com', 'Calle super real 2090 no fake', 'josefa');

Las credenciales a utilizar en caso de solo tener el usuario "josefa" son:
usuario: josefa
contraseña: josefa

Luego de ingresar con las credenciales se podra visualizar la pagina de home (Tienda)